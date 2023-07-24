<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ImportDocumentJob;
use App\Validators\JsonValidator;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;


class DocumentController extends Controller
{
    public function index()
    {
        $totalPendingJobs = DB::table('jobs')
        ->where('queue', 'default')
        ->whereNull('reserved_at')
        ->get()->count();

        return view('documents.index', ['total' => $totalPendingJobs]);
    }
    public function import(Request $request)
    {

        $uploadedFile = $request->file('file');

        $jsonContent = json_decode(file_get_contents($uploadedFile->path()), true);

        foreach ($jsonContent['documentos'] as $documento) {
            ImportDocumentJob::dispatch($documento);
        }

        return redirect()->route('documents.index')->with('success', 'Documentos importados com sucesso!');
    }


}
