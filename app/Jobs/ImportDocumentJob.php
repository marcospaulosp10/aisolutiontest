<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $documentData;

    /**
     * Create a new job instance.
     *
     * @param  array  $documentData
     * @return void
     */
    public function __construct(array $documentData)
    {
        $this->documentData = $documentData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $category = Category::firstOrCreate(['name' => $this->documentData['categoria']]);

        $document = new Document([
            'title' => $this->documentData['titulo'],
            'contents' => $this->documentData['conteúdo']
        ]);

        $category->documents()->save($document);

        info('Documento importado com sucesso!');
    }
}
