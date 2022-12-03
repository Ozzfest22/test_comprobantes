@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid p-5">
    <div class="row">
        <div class="col-12">
            <h1>Productos</h1>
            <hr class="bg-dark w-100">
        </div>
    </div>
    <div class="row p-2 d-flex mb-3">
        <div class="col-1 m-auto">
            <a href="{{route('products.create')}}" class="btn btn-primary rounded-circle">N</a>
            <a href="#" data-toggle="modal" data-target="#modalDeletes" class="btn btn-danger" >Eliminados</a>
        </div>
        <div class="col-8 d-flex p-2 m-auto">
            <input type="hidden" class="form-control mx-2 w-50">
        </div>
        <div class="col-2 m-auto">
            <button class="btn btn-success mx-2"> Excel</button>
            <button class="btn btn-danger mx-2">PDF</button>
            <button class="btn btn-primary rounded-circle mx-2">P</button>
        </div>
    </div>

    {{-- tabla de contenido --}}
    <div class="row">
        <div class="col-12">
            <table class="table table-striped mt-2 nowrap text-center" style="width:100%;" id="tableProducts">
                <thead style="background-color:#ffff" class="text-center">
                    <th hidden>ID</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('products.modalEliminados')

@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

<script>
    $(document).ready(function() {
        $('#tableProducts').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('products.index')}}",
            dataType: 'json',
            type: "POST",
            columns: [{
                    data: 'cod_prod',
                    name: 'cod_prod'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'acciones',
                    name: 'acciones'
                }
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
            },
            responsive: true
        });
    });
</script>
@stop