@extends('layouts.app')

@section('title', '| Importar Arquivo CSV')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <h5 class="m-b-10">Importar Arquivo CSV</h5>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="javascript:">Importar CSV</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Importar Pacientes via CSV</h5>
                                    </div>
                                    <div class="card-body">

                                        @if ($errors->any())
                                            @foreach ($errors->all() as $error)
                                                <p style="color:brown">{{ $error }}</p>
                                            @endforeach
                                        @endif

                                        <form action="{{ route('hospitalization.import') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="csvFile">Selecione um arquivo CSV</label>
                                                <input type="file" class="form-control-file" id="csvFile" name="csvFile"
                                                    accept=".csv">
                                            </div>
                                            <button type="submit" class="btn btn-primary" id="fileBtn">Importar</button>
                                        </form>
                                    </div>
                                </div>

                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h5>Entradas Válidas</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Nome do Paciente</th>
                                                    <th>Data de Nascimento</th>
                                                    <th>ID</th>
                                                    <th>Guia</th>
                                                    <th>Entrada</th>
                                                    <th>Saída</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($var_validEntries) && count($var_validEntries) > 0)
                                                    @foreach($var_validEntries as $data)
                                                        <tr>
                                                            <td>{{ $data['nome'] ?? 'N/A' }}</td>
                                                            <td>{{ $data['nascimento'] ?? 'N/A' }}
                                                            </td>
                                                            <td>{{ $data['codigo'] ?? 'N/A' }}</td>
                                                            <td>{{ $data['guia'] ?? 'N/A' }}</td>
                                                            <td>{{ $data['entrada'] ?? 'N/A' }}
                                                            </td>
                                                            <td>{{ $data['saida'] ?? 'N/A' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                @else
                                                    <tr>
                                                        <td colspan="6" class="text-center">Nenhuma entrada válida
                                                            encontrada.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h5>Entradas Inválidas</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Nome do Paciente</th>
                                                    <th>Data de Nascimento</th>
                                                    <th>ID</th>
                                                    <th>Guia</th>
                                                    <th>Entrada</th>
                                                    <th>Saída</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($var_invalidEntries) && count($var_invalidEntries) > 0)
                                                    @foreach($var_invalidEntries as $data)
                                                        <tr>
                                                            <td>{{ $data['nome'] ?? 'N/A' }}</td>
                                                            <td>{{$data['nascimento'] ?? 'N/A' }}
                                                            </td>
                                                            <td>{{ $data['codigo'] ?? 'N/A' }}</td>
                                                            <td>{{ $data['guia'] ?? 'N/A' }}</td>
                                                            <td>{{ $data['entrada'] ?? 'N/A' }}
                                                            </td>
                                                            <td>{{ $data['saida'] ?? 'N/A' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                @else
                                                    <tr>
                                                        <td colspan="6" class="text-center">Nenhuma entrada inválida
                                                            encontrada.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <button class="btn btn-primary mt-3" onclick="saveData()">Salvar Dados Válidos</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function saveData() {
        // Implementar lógica para salvar os dados válidos no banco de dados.
        alert('Implementar a lógica para salvar os dados válidos.');
    }
</script>
@endsection