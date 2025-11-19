@extends('layouts.admin')

@section('content')
<div class="page-heading"><h3>Perfil</h3></div>
<hr>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">
                <h4>Datos del perfil</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Nombre: </strong>
                    <span>{{ $user->name }}</span>
                </div>
                <div class="mb-3">
                    <strong>Email: </strong>
                    <span>{{ $user->email }}</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.manuales.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
