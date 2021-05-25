<x-plantilla>
    <x-slot name="titulo">trabajadores</x-slot>
    <x-slot name="cabecera">Gestión de Trabajadores</x-slot>
    <x-mensajes />
    <div class="d-flex flex-row-reverse my-2 py-1">
        <div>
            <form name="search" action="{{ route('trabajadores.index') }}" class="form-inline">
                <select name="tienda" class="py-2" onchange="this.form.submit()">
                    <option value='%'>Cualquiera</option>
                    @foreach ($tiendas as $item)
                        @if ($request->tienda == $item->id)
                            <option value="{{ $item->id }}" selected>{{ $item->nombre }}</option>
                        @else
                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                        @endif
                    @endforeach
                </select>


        </div>
        <div class="py-2">

            <b>Tienda:</b>&nbsp;&nbsp;
        </div>
        <div>
            <select name="apellidos" class="py-2" onchange="this.form.submit()">
                @foreach ($apellidos as $k => $v)
                    @if($request->apellidos==$k)
                    <option value="{{ $k }}" selected>{{ $v }}</option>
                    @else
                    <option value="{{ $k }}">{{ $v }}</option>
                    @endif
                @endforeach
            </select>&nbsp;
        </div>
        <div class="py-2">
            <i class="fas fa-search"></i>
            <b>Apellidos:</b>&nbsp;&nbsp;
        </div>
        </form>
    </div>
    <a href="{{ route('trabajadores.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Crear
        Trabajador</a>
    <table class="table table-success table-striped mt-2">
        <thead>
            <tr>
                <th scope="col">Detalle</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col" colspan=2 class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trabajadores as $item)
                <tr>
                    <th scope="row">
                        <a href="{{ route('trabajadores.show', $item) }}" class="btn btn-info"><i
                                class="fas fa-info"></i> Detalles</a>
                    </th>
                    <td>{{ $item->apellidos }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->email }}</td>
                    <td class="text-center">
                        <a href="{{ route('trabajadores.edit', $item) }}" class="btn btn-warning"><i
                                class="fas fa-edit"></i> Editar</a>
                    </td>
                    <td class="text-center">
                        <form name="as" method="POST" action="{{ route('trabajadores.destroy', $item) }}">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i>
                                Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-2">
        {{ $trabajadores->withQueryString()->links() }}
    </div>
</x-plantilla>
