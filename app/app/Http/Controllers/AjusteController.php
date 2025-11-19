<?php

namespace App\Http\Controllers;

use App\Models\Ajuste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AjusteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ajuste = Ajuste::first();
        $jsondata = file_get_contents(storage_path('app/public/divisas.json'));
        $divisas = json_decode($jsondata, true);
        return view('admin.ajuste.index', compact('divisas', 'ajuste'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ajuste = Ajuste::first();

        $rules = [
            'nombre' => 'required',
            'descripcion' => 'required',
            'sucursal' => 'required',
            'direccion' => 'required',
            'telefonos' => 'required',
            'email' => 'required|email',
            'divisa' => 'required',
            'pagina_web' => 'nullable',
        ];

        if (isset($ajuste)) {
            $rules['logo'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
            $rules['imagen_login'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }else{
            $rules['logo'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            $rules['imagen_login'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $request->validate($rules);

        if (!$ajuste) {
            $ajuste = new Ajuste();
        }

        $ajuste->nombre = $request->nombre;
        $ajuste->descripcion = $request->descripcion;
        $ajuste->sucursal = $request->sucursal;
        $ajuste->direccion = $request->direccion;
        $ajuste->telefonos = $request->telefonos;
        $ajuste->email = $request->email;
        $ajuste->divisa = $request->divisa;
        $ajuste->pagina_web = $request->pagina_web;

        if ($request->hasFile('logo')) {
            if ($ajuste->logo && Storage::disk('public')->exists($ajuste->logo)) {
                Storage::disk('public')->delete($ajuste->logo);
            }
            $ajuste->logo = $request->file('logo')->store('logos','public');
        }

        if ($request->hasFile('imagen_login')) {
            if ($ajuste->imagen_login && Storage::disk('public')->exists($ajuste->imagen_login)) {
                Storage::disk('public')->delete($ajuste->imagen_login);
            }
            $ajuste->imagen_login = $request->file('imagen_login')->store('imagenes_login','public');
        }
        
        $ajuste->save();

        return redirect()->route('admin.ajustes.index')->with('mensaje', 'Se guardo los cambios correctamente')->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ajuste $ajuste)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ajuste $ajuste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ajuste $ajuste)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ajuste $ajuste)
    {
        //
    }
}
