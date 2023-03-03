<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    //Creamos un metodo contruct
    public function __construct()
    {

        //En el se le asignaran los permisos que tiene cada usuario.

        $this->middleware('can:admin.users.index')->only('index');
        $this->middleware('can:admin.users.edit')->only('edit' , 'update');

    }

    public function index()
    {
        // Devuelve la vista de todos los usuarios

        return view('admin.users.index');
    }

    public function edit(User $user)
    {
        // Recoge todos los roles y le envia a la vista el usuario
        // y todos los roles que existen 


        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Le asigna al usuario que editamos previamente los roles
        // y a traves de sync le modifica los roles, tanto si le quitamos
        // como si se le añaden

        $user->roles()->sync($request->roles);

        return redirect()->route('admin.users.edit', $user)->with('info', 'Se asignó los roles correctamente');
    }
}
