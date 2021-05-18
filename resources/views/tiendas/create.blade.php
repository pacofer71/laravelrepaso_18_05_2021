<x-plantilla>
    <x-slot name="titulo">Gestion</x-slot>
    <x-slot name="cabecera">Gestión de Tiendas del Sur</x-slot>
    <x-errores />
    <form name="sd" method="POST" action="{{ route('tiendas.store') }}"" class=" p-4 bg-secondary text-light">
        @csrf
        <x-form-input name="nombre" label="Nombre Tienda" />
        <x-form-input name="localidad" label="Localidad" />
        <x-form-input name="direccion" label="Dirección Tienda" />
        <x-form-input name="email" label="E-Mail" type="mail" />
        <div class="mt-3">
            <button type="submit" class="btn btn-info"><i class="fas fa-save"></i> Enviar</button>

            <button type="reset" class=" ml-3 btn btn-warning"><i class="fas fa-broom"></i> Limpiar</button>
            <button class="ml-3 btn btn-primary" onclick="window.history.back();"><i class="fas fa-backward"></i>
                Volver</button>
        </div>
    </form>
</x-plantilla>
