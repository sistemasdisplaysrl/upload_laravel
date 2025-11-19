@extends('layouts.admin')

@section('content')
    <div class="page-heading">
        <h3>Editar el Usuario: {{ $usuario->name }}</h3>
    </div>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-6">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Llene los campos del Formulario</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="role">Rol (*)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <select name="role" id="role" class="form-control" required>
                                            <option value="">Seleccione un Rol</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" {{ $usuario->roles->pluck('id')->first() == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('role')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nombre del Usuario (*)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ $usuario->name }}" required>
                                    </div>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email del Usuario (*)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="text" name="email" id="email" class="form-control" value="{{ $usuario->email }}" required>
                                    </div>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Actualizar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection