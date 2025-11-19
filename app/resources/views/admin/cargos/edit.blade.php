@extends('layouts.admin')

@section('content')
    <div class="page-heading">
        <h3>Editar el Cargo: {{ $cargo->cargo }}</h3>
    </div>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-6">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Llene los campos del Formulario</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.cargos.update', $cargo->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cargo">Nombre del Cargo (*)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                        <input type="text" name="cargo" id="cargo" class="form-control" value="{{ $cargo->cargo }}" required>
                                    </div>
                                    @error('cargo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nro_coorporativo">Nro. Corporativo (*)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                        <input type="text" name="nro_coorporativo" id="nro_coorporativo" class="form-control" value="{{ $cargo->nro_coorporativo }}" required>
                                    </div>
                                    @error('nro_coorporativo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="usuario_telegram">Usuario de Telegram (*)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                        <input type="text" name="usuario_telegram" id="usuario_telegram" class="form-control" value="{{ $cargo->usuario_telegram }}" required>
                                    </div>
                                    @error('usuario_telegram')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="{{ route('admin.cargos.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-reload"></i> Actualizar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection