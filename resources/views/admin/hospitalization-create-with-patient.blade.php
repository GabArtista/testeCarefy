@extends('layouts.app')

@section('title', '| Novo Paciente e Internação')
@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="page-header">
                    <h5 class="m-b-10">Criar Novo Paciente e Internação</h5>
                </div>
                <div class="main-body">
                    <div class="page-wrapper">
                        <form method="POST" action="{{ route('hospitalization.storeWithPatient') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nome do Paciente</label>
                                <input type="text" name="name" class="form-control" required
                                    placeholder="Nome completo do paciente">
                            </div>
                            <div class="form-group">
                                <label for="birth">Data de Nascimento</label>
                                <input type="date" name="birth" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input type="text" name="cpf" class="form-control" required maxlength="14"
                                    placeholder="CPF do paciente">
                            </div>
                            <div class="form-group">
                                <label for="blood_type">Tipo Sanguíneo</label>
                                <input type="text" name="blood_type" class="form-control" maxlength="3"
                                    placeholder="Tipo sanguíneo (ex: A+, O-)">
                            </div>
                            <hr>
                            <h5>Detalhes da Internação</h5>
                            <div class="form-group">
                                <label for="entry">Data de Entrada</label>
                                <input type="datetime-local" name="entry" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="exit">Data de Saída</label>
                                <input type="datetime-local" name="exit" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="description">Descrição</label>
                                <input type="text" name="description" class="form-control" maxlength="255"
                                    placeholder="Descrição da internação (opcional)">
                            </div>
                            <button type="submit" class="btn btn-success">Salvar Paciente e Internação</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection