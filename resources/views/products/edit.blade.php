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
                        <h1>Editar Producto</h1>
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
                        <form action="{{route('products.update', $product->id)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="codigoProducto">Código</label>
                                        <input type="text" name="cod_prod" class="form-control" id="codigoProducto" value="{{$product->cod_prod}}" placeholder="Código">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="nameProducto">Nombre</label>
                                        <input type="text" name="name" class="form-control" id="nameProducto" value="{{$product->name}}" placeholder="Nombre">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="descripProducto">Descripción</label>
                                <textarea class="form-control" name="description" id="descripProducto" placeholder="Descripción" style="height: 100px">{{$product->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="precioProducto">Precio</label>
                                <input type="number" step="any" name="price" class="form-control" id="precioProducto" value="{{$product->price}}" placeholder="Precio">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Guardar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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