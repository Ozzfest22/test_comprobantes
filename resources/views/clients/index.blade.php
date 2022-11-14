@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<div class="container-fluid p-5">
    <div class="row">
        <div class="col-12">
            <h1>Clientes</h1>
            <hr class="bg-dark w100">
        </div>
    </div>
    <div class="row p-2 d-flex mb-3">
        <div class="col-1 m-auto">
            
            <a class="btn btn-primary rounded-circle" href="{{route('clients.create')}}">N</a>
            
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
    <div class="row">
        <div class="col-12">
            <table class="table table-striped mt-2 nowrap" style="width: 100%;" id="tableClients">
                <thead style="background-color:#ffff" class="text-center">
                    <th hidden>ID</th>
                    <th style="">Nombre</th>
                    <th style="">Email</th>
                    <th style="">Direccion</th>
                    <th style="">Doc</th>
                    <th style="">Telefono</th>
                    <th style="">Acciones</th>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td hidden>{{$client->id}}</td>
                        <td>{{$client->name}}</td>
                        <td>{{$client->email}}</td>
                        <td>{{$client->address}}</td>
                        <td>{{$client->doc_id}}</td>
                        <td>{{$client->phone}}</td>                        
                        <td>
                            <form action="{{route('clients.destroy', $client->id)}}" class="formDelete text-center" method="POST">
                                
                                <a class="btn btn-info" href="{{ route('clients.edit',$client->id) }}">Editar</a>
                                

                                @csrf
                                @method('DELETE')

                                
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                
                            </form>
                        </td>
                    </tr>
                    @endforeach()
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    $(document).ready( function () {
        $('#tableClients').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
            },
            responsive: true
        });
    } );
</script>


@stop