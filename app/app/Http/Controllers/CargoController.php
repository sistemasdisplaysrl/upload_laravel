<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = trim((string) $request->input('buscar'));

        $cargos = Cargo::query()
            ->when($buscar, function ($q) use ($buscar) {
                $q->where(function ($q) use ($buscar) {
                    $q->where('cargo', 'like', "%$buscar%")
                      ->orWhere('nro_coorporativo', 'like', "%$buscar%");
                });
            })
            ->orderBy('cargo')
            ->paginate(10)
            ->appends(['buscar' => $buscar]);

        return view('admin.cargos.index', compact('cargos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cargos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cargo' => 'required',
            'nro_coorporativo' => 'required',
            'usuario_telegram' => 'required',
        ]);

        $cargo = new Cargo();
        $cargo->cargo = strtoupper($request->cargo);
        $cargo->nro_coorporativo = $request->nro_coorporativo;
        $cargo->usuario_telegram = $request->usuario_telegram;
        $cargo->save();

        return redirect()->route('admin.cargos.index')->with('mensaje', 'Cargo creado exitosamente')->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cargo = Cargo::findOrFail($id);
        return view('admin.cargos.show', compact('cargo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cargo = Cargo::findOrFail($id);
        return view('admin.cargos.edit', compact('cargo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'cargo' => 'required',
            'nro_coorporativo' => 'required',
            'usuario_telegram' => 'required',
        ]);

        $cargo = Cargo::findOrFail($id);
        $cargo->cargo = strtoupper($request->cargo);
        $cargo->nro_coorporativo = $request->nro_coorporativo;
        $cargo->usuario_telegram = $request->usuario_telegram;
        $cargo->save();

        return redirect()->route('admin.cargos.index')->with('mensaje', 'Cargo actualizado exitosamente')->with('icono', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cargo = Cargo::findOrFail($id);
        $cargo->delete();
        return redirect()->route('admin.cargos.index')->with('mensaje', 'Cargo eliminado exitosamente')->with('icono', 'success');
    }
}
