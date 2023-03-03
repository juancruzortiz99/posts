<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function __construct()
    {

        //En el se le asignaran los permisos que tiene cada usuario.

        $this->middleware('can:admin.roles.index')->only('index');
        $this->middleware('can:admin.roles.edit')->only('edit' , 'update');

    }

    public function index()
    {
        //  Recogo todos los roles
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }


    public function create()
    {
        //Recogo todos los permisos
        $permissions = Permission::all();

        return view('admin.roles.create', compact('permissions'));
    }




    public function store(Request $request)
    {

        $request->validate([
            'name'=>'required']);
            
            $role = Role::create(['name' => $request->name]);
            $role->permissions()->sync($request->permissions);

            return redirect()->route('admin.roles.edit', $role)->with('info','el rol se creo con exito');
    }


    public function edit(Role $role)
    {

        
       
        $permissions = Permission::all();

        return view('admin.roles.edit', compact('role', 'permissions'));
    }


    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role->update($request->all());

        $role->permissions()->sync($request->permissions);

        return redirect()->route('admin.roles.edit', $role)->with('info', 'El rol se actualizo con éxito');
    }


    public function destroy(Role $role)
    {
        $role->delete();

        return view('admin.roles.index')->with('info', 'El rol se eliminó con éxito');
    }
}
