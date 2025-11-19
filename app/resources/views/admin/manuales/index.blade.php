@extends('layouts.admin')

@section('content')
    <div class="page-heading">
        <h3>Gestion de Manuales</h3>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('admin.manuales.index') }}" method="get">
                                <div class="input-group">
                                    <input type="text" name="buscar" id="buscar" class="form-control" value="{{ request('buscar') ?? '' }}" placeholder="Buscar">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.manuales.create') }}" class="btn btn-success float-end"> <i class="bi bi-plus"></i> Agregar Manual</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th>Nro.</th>
                                    <th>Cargo</th>
                                    <th>Nombre del Manual</th>
                                    <th>Version</th>
                                    <th>Archivo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nro = ($manuales->currentPage() - 1) * $manuales->perPage() + 1;
                                @endphp
                                @foreach ($manuales as $manual)
                                    <tr>
                                        <td class="text-center">{{ $nro++ }}</td>
                                        <td>{{ $manual->cargo->cargo }}</td>
                                        <td>{{ $manual->nombre }}</td>
                                        <td class="text-center">{{ $manual->version }}</td>
                                        <td class="text-center">
                                            @if ($manual->archivo)
                                                <a class="btn btn-info btn-sm" href="{{ asset('storage/manuales/' . $manual->archivo) }}" target="_blank"><i class="bi bi-file-earmark-pdf"></i> Ver</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center"> <span class="badge bg-{{ $manual->estado == 'VIGENTE' ? 'success' : 'danger' }}">{{ $manual->estado }}</span></td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.manuales.edit', $manual->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('admin.manuales.destroy', $manual->id) }}" method="POST" style="display: inline;" class="form-eliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($manuales->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-4 px-3">
                                <div class="text-muted">
                                    Mostrando {{ $manuales->firstItem() }} de {{ $manuales->lastItem() }} de {{ $manuales->total() }} registros
                                </div>
                                <div>
                                    {{ $manuales->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection