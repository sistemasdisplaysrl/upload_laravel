@extends('layouts.admin')

@section('content')
    <div class="page-heading">
        <h3>Ajustes del Sistema</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Configuraciones del Sistema</h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/ajustes/create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nombre" class="form-label">Nombre (*)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="bi bi-building"></i> </span>
                                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" id="nombre" placeholder="Nombre del sistema" value="{{ old('nombre', $ajuste->nombre ?? '') }}" required>
                                                @error('nombre')
                                                    <div class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }} </strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="descripcion" class="form-label">Descripcion (*)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="bi bi-info-circle"></i> </span>
                                                <input type="text" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" placeholder="Descripcion" value="{{ old('descripcion', $ajuste->descripcion ?? '') }}" required>
                                                @error('descripcion')
                                                    <div class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }} </strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sucursal" class="form-label">Sucursal (*)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-archive-fill"></i></span>
                                                <input type="text" class="form-control @error('sucursal') is-invalid @enderror" name="sucursal" id="sucursal" placeholder="Sucursal" value="{{ old('sucursal', $ajuste->sucursal ?? '') }}" required>
                                                @error('sucursal')
                                                    <div class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }} </strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="direccion" class="form-label">Direccion (*)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="bi bi-geo-alt"></i> </span>
                                                <textarea class="form-control @error('direccion') is-invalid @enderror" rows="1" name="direccion" id="direccion" placeholder="Calle, numero, ciudad y pais">{{ old('direccion', $ajuste->direccion ?? '') }}</textarea>
                                                @error('direccion')
                                                    <div class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }} </strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telefonos" class="form-label">Telefonos (*)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="bi bi-telephone"></i> </span>
                                                <input type="text" class="form-control @error('telefonos') is-invalid @enderror" name="telefonos" id="telefonos" placeholder="Telefonos" value="{{ old('telefonos', $ajuste->telefonos ?? '') }}" required>
                                                @error('telefonos')
                                                    <div class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }} </strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Correo (*)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="bi bi-envelope"></i> </span>
                                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Correo" value="{{ old('email', $ajuste->email ?? '') }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }} </strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="divisa" class="form-label">Divisa (*)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="bi bi-currency-dollar"></i> </span>
                                                <select class="form-control @error('divisa') is-invalid @enderror" name="divisa" id="divisa" required>
                                                    <option value="">Seleccione una divisa</option>
                                                    @foreach ($divisas as $divisa)
                                                        <option value="{{ $divisa['symbol'] }}" {{ old('divisa', $ajuste->divisa ?? '') == $divisa['symbol'] ? 'selected' : '' }}>{{ $divisa['name'] }} ({{ $divisa['symbol'] }}) </option>
                                                    @endforeach
                                                </select>
                                                @error('divisa')
                                                    <div class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }} </strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pagina_web" class="form-label">Sitio Web</label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="bi bi-globe"></i> </span>
                                                <input type="text" class="form-control @error('pagina_web') is-invalid @enderror" name="pagina_web" id="pagina_web" placeholder="Pagina Web" value="{{ old('pagina_web', $ajuste->pagina_web ?? '') }}">
                                                @error('pagina_web')
                                                    <div class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }} </strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="logo" class="form-label">Logo @if ( !isset($ajuste) || !$ajuste->logo ) (*) @else @endif</label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="bi bi-image"></i> </span>
                                                <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" id="logo" onchange="mostrarImagen(event)" accept="image/*" @if ( !isset($ajuste) || !$ajuste->logo ) required @endif>
                                                @error('logo')
                                                    <div class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }} </strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <center>
                                            @if ( isset($ajuste) && $ajuste->logo )
                                                <img src="{{ asset('storage/' . $ajuste->logo) }}" id="preview1" alt="Logo Actual" style="max-width: 250px; max-height: 250px; margin-top: 10px;">
                                            @else
                                                <img id="preview1" src="" style="max-width: 250px; max-height: 250px; margin-top: 10px;" alt="">
                                            @endif
                                        </center>
                                        <script>
                                            const mostrarImagen = e => 
                                                document.getElementById('preview1').src = URL.createObjectURL(e.target.files[0]);
                                        </script>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="imagen_login" class="form-label">Imagen del Login @if ( !isset($ajuste) || !$ajuste->imagen_login ) (*) @else @endif</label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="bi bi-camera"></i> </span>
                                                <input type="file" class="form-control @error('imagen_login') is-invalid @enderror" name="imagen_login" id="imagen_login" onchange="mostrarImagen2(event)" accept="image/*" @if ( !isset($ajuste) || !$ajuste->imagen_login ) required @endif>
                                                @error('imagen_login')
                                                    <div class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }} </strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <center>
                                            @if ( isset($ajuste) && $ajuste->imagen_login )
                                                <img src="{{ asset('storage/' . $ajuste->imagen_login) }}" id="preview2" alt="Imagen del Login Actual" style="max-width: 250px; max-height: 250px; margin-top: 10px;">
                                            @else
                                                <img id="preview2" src="" style="max-width: 250px; max-height: 250px; margin-top: 10px;" alt="">
                                            @endif
                                        </center>
                                        <script>
                                            const mostrarImagen2 = e => 
                                                document.getElementById('preview2').src = URL.createObjectURL(e.target.files[0]);
                                        </script>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"> <i class="bi bi-save"></i> Guardar Cambios</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection