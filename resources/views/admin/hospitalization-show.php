@extends('layouts.app')

@section('title', '| Detalhes da Internação')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <h5>Detalhes da Internação</h5>
                        <p><strong>Nome do Paciente:</strong> {{ $hospitalization->patient->name }}</p>
                        <p><strong>Data de Entrada:</strong> {{
                            \Carbon\Carbon::parse($hospitalization->entry)->format('d/m/Y H:i') }}</p>
                        <p><strong>Data de Saída:</strong> {{ $hospitalization->exit ?
                            \Carbon\Carbon::parse($hospitalization->exit)->format('d/m/Y H:i') : 'Ainda internado' }}
                        </p>
                        <a href="{{ route('hospitalization.index') }}" class="btn btn-secondary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection