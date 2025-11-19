@extends('layouts.admin')

@section('content')
    <div class="page-heading">
        <h3>Gestion de Cargos</h3>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('admin.cargos.index') }}" method="get">
                                <div class="input-group">
                                    <input type="text" name="buscar" id="buscar" class="form-control" value="{{ request('buscar') ?? '' }}" placeholder="Buscar">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.cargos.create') }}" class="btn btn-success float-end"> <i class="bi bi-plus"></i> Agregar Cargo</a>
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
                                    <th>Nro. Corporativo</th>
                                    <th>Usuario de Telegram</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nro = ($cargos->currentPage() - 1) * $cargos->perPage() + 1;
                                @endphp
                                @foreach ($cargos as $cargo)
                                    <tr>
                                        <td class="text-center">{{ $nro++ }}</td>
                                        <td>{{ $cargo->cargo }}</td>
                                        <td class="text-center">{{ $cargo->nro_coorporativo }}</td>
                                        <td class="text-center">{{ $cargo->usuario_telegram }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.cargos.edit', $cargo->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('admin.cargos.destroy', $cargo->id) }}" method="POST" style="display: inline;" class="form-eliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($cargos->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-4 px-3">
                                <div class="text-muted">
                                    Mostrando {{ $cargos->firstItem() }} de {{ $cargos->lastItem() }} de {{ $cargos->total() }} registros
                                </div>
                                <div>
                                    {{ $cargos->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection