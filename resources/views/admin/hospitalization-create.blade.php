@extends('layouts.app')

@section('title', '| Nova Internação')
@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="page-header">
                    <h5 class="m-b-10">Criar Internação para {{ $patient->name }}</h5>
                </div>
                <div class="main-body">
                    <div class="page-wrapper">
                        <form action="{{ route('hospitalization.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
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
                            <button type="submit" class="btn btn-success">Salvar Internação</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection