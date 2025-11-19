<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = trim((string) $request->input('buscar'));

        $usuarios = User::query()
            ->with('roles')
            ->when($buscar, function ($q) use ($buscar) {
                $q->where(function ($q) use ($buscar) {
                    $q->where('name', 'like', "%$buscar%")
                      ->orWhere('email', 'like', "%$buscar%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->appends(['buscar' => $buscar]);

        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required',
        ]);

        $user = new User();
        $user->name = strtoupper($request->name);
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $user->roles()->sync($request->role);

        return redirect()->route('admin.usuarios.index')->with('mensaje', 'Usuario creado exitosamente')->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.usuarios.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
        ]);

        $usuario = User::findOrFail($id);
        $usuario->name = strtoupper($request->name);
        $usuario->email = $request->email;
        $usuario->save();

        $usuario->roles()->sync($request->role);

        return redirect()->route('admin.usuarios.index')->with('mensaje', 'Usuario actualizado exitosamente')->with('icono', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();
        return redirect()->route('admin.usuarios.index')->with('mensaje', 'Usuario eliminado exitosamente')->with('icono', 'success');
    }
}
