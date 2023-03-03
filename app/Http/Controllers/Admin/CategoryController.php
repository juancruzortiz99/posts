<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    public function __construct()
    {
        //En el se le asignaran los permisos que tiene cada usuario.

        $this->middleware('can:admin.categories.index')->only('index');
        $this->middleware('can:admin.categories.edit')->only('edit', 'update');
        $this->middleware('can:admin.categories.create')->only('create', 'store');
        $this->middleware('can:admin.categories.destroy')->only('destroy');
    }


    public function index()
    {
        // Llamo a la tabla category y obtengo todos sus elemntos y atributos
        $categories = Category::all();

        return view('admin.categories.index', compact('categories'));
    }


    public function create()
    {
        return view('admin.categories.create');
    }


    public function store(Request $request)
    {

        // Valido para que el nombre sea obligatorio y el slug no exista en la BD
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories'
        ]);

        // Creo una categoria si es valida con todos los elementos enviados por request
        $category = Category::create($request->all());

        return redirect()->route('admin.categories.edit', $category)->with('info', 'La categoria se creó con éxito.');
    }


    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }


    public function update(Request $request, Category $category)
    {
        // Valido que haya un nombre y que el slug no exista salvo que sea el mismo q editamos
        $request->validate([
            'name' => 'required',
            'slug' => "required|unique:categories,slug,$category->id"
        ]);

        // Actualizo todos los datos
        $category->update($request->all());

        return redirect()->route('admin.categories.edit', $category)->with('info', 'La categoria se actualizó con éxito.');
    }


    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('info', 'La categoria se eliminó con éxito.');
    }
}
