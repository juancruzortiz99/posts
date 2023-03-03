<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    
    public function __construct()
    {
        // En el se le asignaran los permisos que tiene cada usuario.

        $this->middleware('can:admin.posts.index')->only('index');
        $this->middleware('can:admin.posts.edit')->only('edit', 'update');
        $this->middleware('can:admin.posts.create')->only('create', 'store');
        $this->middleware('can:admin.posts.destroy')->only('destroy');
    }


    public function index()
    {

        return view('admin.posts.index');
    }

 
    public function create()
    {
        // Asigno un mapa donde el name es la llave y el id la clave
        // Recogo todos los tags
        $categories = Category::pluck('name', 'id');
        $tags = Tags::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    
    public function store(PostRequest $request)
    {
        // Creo un post con las consultas realizadas en el formulario
        $post = Post::create($request->all());
        $this->authorize('author', $post);

        // Si existe un archivo enviado a traves de un inputfile, lo guardo en public/posts
        // y creo su imagen
        if ($request->file('file')) {
            $url =  Storage::put('public/posts', $request->file('file'));

            $post->image()->create([
                'url' => $url
            ]);
        }
        // Si el post tiene etiquetas los guardo en la tabla tags
        if ($request->tags) {
            $post->tags()->attach($request->tags);
        }

        return redirect()->route('admin.posts.edit', $post)->with('info', 'El post se agregó con éxito');
    }


    public function edit(Post $post)
    {
        // Autorizo dependiendo del autor y sus diferentes post
        $this->authorize('author', $post);

        // Asigno un mapa donde el name es la llave y el id la clave
        // Recogo todos los tags
        $categories = Category::pluck('name', 'id');
        $tags = Tags::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

   
    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('author', $post);

        // Actualizo el post dependiendo nuestras querys
        $post->update($request->all());

        // Si el usuario a subido un archivo o actualizado la imagen del post,
        // la guardo en el storage. Y en caso de haber una imagen anterior, la borro
        // y actualizo su url y si no hay la creo.
        if ($request->file('file')) {

            $url = Storage::put('public/posts', $request->file('file'));

            if ($post->image) {
                Storage::delete($post->image->url);

                $post->image->update([
                    'url' => $url
                ]);
            } else {
                $post->image()->create([
                    'url' => $url
                ]);
            }
        }
        // Si modifico las etiquetas, a traves de sync remplaza los cambios hechos
        // es decir, si habia otras etiquetas y agrego nuevas actualiza la BD
        if ($request->tags) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('admin.posts.edit', $post)->with('info', 'El post se actualizó con éxito');
    }

   
    public function destroy(Post $post)
    {
        $this->authorize('author', $post);

        $post->delete();

        return redirect()->route('admin.posts.index')->with('info', 'El post se eliminó con éxito');
    }
}
