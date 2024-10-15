@extends('layouts.app')

@section('title', '| Internações')
@section('sidebar_hospitalization', 'active')

@section('content')
<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    <h5 class="m-b-10">Internações</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                                class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Internações</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card User-Activity">
                                    <div class="card-header">
                                        <h5>Todas as internações de hoje</h5>
                                        <div class="card-header-right">
                                            <a href="{{ route('hospitalization.listPatients') }}"
                                                class="btn btn-icon btn-outline-primary"
                                                title="Adicionar Nova Internação">
                                                <i class="feather icon-plus"></i> Adicionar Nova Internação
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-block text-center">
                                        <table id="tb-hospitalization" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Nome do Paciente</th>
                                                    <th>Data de Entrada</th>
                                                    <th>Data de Saída</th>
                                                    <th>Editar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($hospitalizations as $hospitalization)
                                                    <tr>
                                                        <td>{{ $hospitalization->patient->name }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($hospitalization->entry)->format('d/m/Y H:i') }}
                                                        </td>
                                                        <td>{{ $hospitalization->exit ? \Carbon\Carbon::parse($hospitalization->exit)->format('d/m/Y H:i') : 'Em Internação' }}
                                                        </td>
                                                        <td>
                                                            <!-- <a href="{{ route('hospitalization.show', $hospitalization->id) }}"
                                                                        class="btn btn-icon btn-outline-primary">
                                                                        <i class="feather icon-play"></i>
                                                                    </a> -->
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->

<script src="{{ asset('plugins/datatables/datatables.min.js') }}" defer></script>
<script>
    $(document).ready(function () {
        $('#tb-hospitalization').DataTable();
    });
</script>
@endsection