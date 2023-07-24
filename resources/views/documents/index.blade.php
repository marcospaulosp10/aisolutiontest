<!DOCTYPE html>
<html>

<head>
    <title>Importação de Documentos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container mt-5">
        <!-- Exibir mensagem de erro ou sucesso -->
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @elseif(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                Importar JSON
            </div>
            <div class="card-body">
                <form action="{{ route('documents.import') }}" method="POST" enctype="multipart/form-data"
                    id="formData">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="file" class="form-control-file" name="file" id="file" required>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group">
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Importar
                                Arquivo</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <hr />

        <div class="card">
            <div class="card-header">
                Executar Fila
            </div>
            <div class="card-body">
                Total de registros na fila: {{ $total }}
                <form action="{{ route('documents.queue_execute') }}" method="GET" onsubmit="showSpinner()">
                    @csrf
                    <button type="submit" class="btn btn-warning mt-3" id="executarFila">Executar Fila</button>

                    <div id="spinnerContainer" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function showSpinner() {
            const submitBtn = document.getElementById('executarFila');
            const spinnerContainer = document.getElementById('spinnerContainer');

            submitBtn.disabled = true;
            spinnerContainer.style.display = 'block';
        }
    </script>
</body>

</html>
