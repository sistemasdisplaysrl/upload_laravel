@extends('layouts.admin')

@section('content')
<div class="page-heading"><h3>Seguridad</h3></div>
<hr>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow">
      <div class="card-header"><h4>Cambiar contraseña</h4></div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.account.security.update') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Contraseña actual</label>
            <input type="password" name="current_password" class="form-control" required>
            @error('current_password')<small class="text-danger">{{ $message }}</small>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Nueva contraseña</label>
            <input type="password" name="password" class="form-control" required>
            @error('password')<small class="text-danger">{{ $message }}</small>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Confirmar nueva contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required>
          </div>
          <div class="d-flex gap-2">
            <a href="{{ route('admin.manuales.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
            <button class="btn btn-primary" type="submit"><i class="bi bi-shield-lock"></i> Actualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
