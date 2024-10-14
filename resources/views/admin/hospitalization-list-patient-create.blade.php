@extends('layouts.app')

@section('title', '| Listar Pacientes')
@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <h5 class="m-b-10">Lista de Pacientes</h5>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="javascript:">Pacientes</a></li>
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
                                        <h5>Pacientes</h5>
                                        <a href="{{ route('hospitalization.createWithPatient') }}"
                                            class="btn btn-primary mb-3">
                                            Adicionar Novo Paciente e Internação
                                        </a>

                                        <a href="{{ route('hospitalization.csvimport') }}" class="btn btn-primary mb-3">
                                            Importar Arquivo
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Nome do Paciente</th>
                                                    <th>Data de Nascimento</th>
                                                    <th>CPF</th>
                                                    <th>Guia</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($patients as $patient)
                                                    <tr>
                                                        <td>{{ $patient->user->name ?? 'N/A' }}</td>
                                                        <!-- Obtendo o nome do usuário -->
                                                        <td>{{ \Carbon\Carbon::parse($patient->user->birth)->format('d/m/Y') ?? 'N/A' }}
                                                        </td>
                                                        <!-- Data de Nascimento do Usuário -->
                                                        <td>{{ $patient->social_number }}</td>
                                                        <td>
                                                            @foreach ($patient->guides as $guide)
                                                                <div>{{ $guide->description }} (Entrada: {{ $guide->entry }},
                                                                    Saída: {{ $guide->exit }})</div>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            <!-- Botão para editar ou outras ações -->
                                                            <a href="{{ route('hospitalization.createForPatient', $patient->id) }}"
                                                                class="btn btn-primary mb-3">
                                                                Adicionar Nova Internação
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection