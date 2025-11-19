@extends('layouts.admin')

@section('content')
    <div class="page-heading">
        <h3>Editar Manual: {{ $manual->nombre }} (V{{ $manual->version }})</h3>
    </div>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-6">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Llene los campos del Formulario</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.manuales.update', $manual->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="cargo_id">Cargo (*)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                        <select name="cargo_id" id="cargo_id" class="form-control" required>
                                            <option value="">Seleccione un Cargo</option>
                                            @foreach ($cargos as $c)
                                                <option value="{{ $c->id }}" {{ $manual->cargo_id == $c->id ? 'selected' : '' }}>{{ $c->cargo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('cargo_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre del archivo (*)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $manual->nombre }}" required>
                                    </div>
                                    @error('nombre')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="version">Versión</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                        <input type="text" id="version" class="form-control" value="V{{ $manual->version }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="archivo">Reemplazar archivo (PDF)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-upload"></i></span>
                                        <input type="file" name="archivo" id="archivo" accept="application/pdf" class="form-control">
                                    </div>
                                    @error('archivo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="{{ route('admin.manuales.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
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