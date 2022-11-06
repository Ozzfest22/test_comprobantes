@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <br>
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center h1">Nuevo Cliente</h1>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-dark alert-dismissible fade show" role="alert">
                            <strong>¡Revise los campos!</strong>
                            @foreach ($errors->all() as $error)
                            <span class="badge badge-danger">{{ $error }}</span>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <form action="{{route('products.store')}}" id="formCreate" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="codigoProducto">Código</label>
                                        <input type="text" name="cod_prod" class="form-control" value="{{old('cod_prod')}}" id="codigoProducto" placeholder="Código">
                                        @if($errors->has('cod_prod'))
                                        <span class="text-danger">{{$errors->first('cod_prod')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="nameProducto">Nombre</label>
                                        <input type="text" name="name" class="form-control" value="{{old('name')}}" id="nameProducto" placeholder="Nombre">
                                        @if($errors->has('name'))
                                        <span class="text-danger">{{$errors->first('name')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="descripProducto">Descripción</label>
                                <textarea class="form-control" name="description" id="descripProducto" placeholder="Descripción" style="height: 100px">{{old('description')}}</textarea>
                                @if($errors->has('description'))
                                <span class="text-danger">{{$errors->first('description')}}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="precioProducto">Precio</label>
                                <input type="number" step="any" name="price" class="form-control" value="{{old('price')}}" id="precioProducto" placeholder="Precio">
                                @if($errors->has('price'))
                                <span class="text-danger">{{$errors->first('price')}}</span>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-success" id="ajaxSubmit">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    console.log('Hi!');
</script>
@stop