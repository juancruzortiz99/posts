<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tags;

class TagController extends Controller
{
    public function __construct()
    {
        //En el se le asignaran los permisos que tiene cada usuario.

        $this->middleware('can:admin.tags.index')->only('index');
        $this->middleware('can:admin.tags.edit')->only('edit', 'update');
        $this->middleware('can:admin.tags.create')->only('create', 'store');
        $this->middleware('can:admin.tags.destroy')->only('destroy');
    }


    public function index()
    {
        // Recogo todos los tags
        $tags = Tags::all();
        return view('admin.tags.index', compact('tags'));
    }


    public function create()
    {
        // Asigno un array donde estaran los diferentes colores en
        // en un select
        $colors = [
            'red' => 'Color rojo',
            'yellow' => 'Color amarillo',
            'green' => 'Color verde',
            'blue' => 'Color azul',
            'pink' => 'Color rosado',
            'indigo' => 'Color indigo',
            'purple' => 'Color morado'
        ];
        

        return view('admin.tags.create', compact('colors'));

    }

    
    public function store(Request $request)
    {
        // Antes de crear valido, que haya un nombre, que exista una etiqueta
        // y que sea unica. Y que tenga color
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:tags',
            'color' => 'required' 
        ]);

        
        $tag = Tags::create($request->all());
    
        return redirect()->route('admin.tags.edit', compact('tag'))->with('info', 'La etiqueta se creó con éxito');
    }

    
    public function edit(Tags $tag)
    {
        $colors = [
            'red' => 'Color rojo',
            'yellow' => 'Color amarillo',
            'green' => 'Color verde',
            'blue' => 'Color azul',
            'pink' => 'Color rosado',
            'indigo' => 'Color indigo',
            'purple' => 'Color morado'
        ];

        return view('admin.tags.edit', compact('tag', 'colors'));
        
    }

   
    public function update(Request $request, Tags $tag)
    {
        $request->validate([
            'name' => 'required',
            'slug' => "required|unique:tags,slug,$tag->id",
            'color' => 'required' 
        ]);

        $tag->update($request->all());

        return redirect()->route('admin.tags.edit', $tag)->with('info', 'La etiqueta se actualizó con éxito');
    }

   
    public function destroy(Tags $tag)
    {
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('info', 'La etiqueta se eliminó con éxito');
    }
}
