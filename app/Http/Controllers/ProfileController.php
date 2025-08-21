<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the user profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Return the view with the user data
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        // Valida los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Actualiza los campos del usuario
        $user->name = $request->name;
        $user->email = $request->email;

        if($perfil = $request->file('profile_image')){

            if($user->profile_image) {
                $rutaImagen = 'profile_image/' . $user->profile_image;
                if(file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }

            $rutaGuardarImg = 'profile_image/';
            $fotoPerfil = date('YmdHis'). "." . $perfil->getClientOriginalExtension();
            $perfil->move($rutaGuardarImg, $fotoPerfil);
            $user['profile_image'] = "$fotoPerfil";
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

}
