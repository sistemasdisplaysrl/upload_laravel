@extends('layouts.admin')

@section('content')
    <div class="page-heading">
        <h3>Gestion de Roles</h3>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Lista de Roles</h4>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-success float-end"> <i class="bi bi-plus"></i> Agregar Rol</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th>Nro.</th>
                                    <th>Nombre</th>
                                    <th>Permisos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nro = ($roles->currentPage() - 1) * $roles->perPage() + 1;
                                @endphp
                                @foreach ($roles as $role)
                                    <tr>
                                        <td class="text-center">{{ $nro++ }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @php
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
                                            @endphp

                                            @forelse ($role->permissions as $permission)
                                                <span class="badge bg-secondary mb-1">
                                                    {{ $labels[$permission->name] ?? $permission->name }}
                                                </span>
                                            @empty
                                                <span class="text-muted">Sin permisos</span>
                                            @endforelse
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display: inline;" class="form-eliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($roles->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-4 px-3">
                                <div class="text-muted">
                                    Mostrando {{ $roles->firstItem() }} de {{ $roles->lastItem() }} de {{ $roles->total() }} registros
                                </div>
                                <div>
                                    {{ $roles->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection