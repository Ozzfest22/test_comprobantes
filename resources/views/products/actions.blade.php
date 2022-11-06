<a href="{{route('products.edit', $id)}}" class="edit btn btn-primary btn-sm">Editar</a>

<form action="{{route('products.destroy', $id)}}" class="formDelete" method="POST">
    @csrf
    @method('DELETE')
    
    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
    
</form>