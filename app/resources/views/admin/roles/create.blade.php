@extends('layouts.admin')

@section('content')
    <div class="page-heading">
        <h3>Creacion de un nuevo Rol</h3>
    </div>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Llene los campos del Formulario</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Nombre del Rol (*)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                        <input type="text" name="name" id="name" class="form-control" required>
                                    </div>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div>
                                    <h3>Permisos</h3>
                                    @foreach($permissions as $permission)
                                        @php
                                            // Mapeo simple para mostrar nombres bonitos
                                            $labels = [
                                                'usuarios.view'   => 'Mostrar usuarios',
                                                'usuarios.create' => 'Crear usuario',
                                                'usuarios.edit'   => 'Editar usuario',
                                                'usuarios.delete' => 'Eliminar usuario',
                                                'cargos.view'     => 'Mostrar cargos',
                                                'cargos.create'   => 'Crear cargo',
                                                'cargos.edit'     => 'Editar cargo',
                                                'cargos.delete'   => 'Eliminar cargo',
                                                'manuales.view'   => 'Mostrar manuales',
                                                'manuales.create' => 'Crear manual',
                                                'manuales.edit'   => 'Editar manual',
                                                'manuales.delete' => 'Eliminar manual',
                                                'ajustes.view'    => 'Ver ajustes',
                                                'ajustes.update'  => 'Actualizar ajustes',
                                            ];

                                            $label = $labels[$permission->name] ?? $permission->name;
                                        @endphp
                                        <div>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection