<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('admin.account.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
        ]);

        $user->fill($validated)->save();

        return back()->with('mensaje', 'Perfil actualizado correctamente')->with('icono', 'success');
    }

    public function security()
    {
        $user = Auth::user();
        return view('admin.account.security', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required','current_password'],
            'password' => ['required','string','min:8','confirmed','different:current_password'],
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('mensaje', 'Contraseña actualizada correctamente')->with('icono', 'success');
    }
}
