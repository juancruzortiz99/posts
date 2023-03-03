<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tags;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // Recogo de la BD todos los elementos con status 2, es decir, que esten publicados
        // Los ordeno al id mas rciente y los muestro cada 8
        $posts = Post::where('status', 2)->latest('id')->paginate(8);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        // Sirve para mostrar que solo se podran visualizar los posts publicados
        $this->authorize('published', $post);

        // Recogo los post donde la categoria_id del post sea igual que otros post
        // Que esten publicados y que no se muestre también el mismo post que se esta mostrando a la derecha
        $similares = Post::where('category_id', $post->category_id)
            ->where('status', 2)
            ->where('id', '!=', $post->id)
            ->latest('id')
            ->take(4)
            ->get();
        return view('posts.show', compact('post', 'similares'));
    }

    public function category(Category $category)
    {
        // Recogo los posts donde la categoria_id sean iguales a un mismo id de una categoria,
        // que esten publicados y que esten ordenados
        $posts = Post::where('category_id', $category->id)
            ->where('status', 2)
            ->latest('id')
            ->paginate(6);


        return view('posts.category', compact('posts', 'category'));
    }

    public function tag(Tags $tag)
    {
        // Recogo los posts donde tengan la misma etiqueta que el post que se muestra
        $posts = $tag->posts()->where('status', 2)->latest('id')->paginate(4);


        return view('posts.tag', compact('posts', 'tag'));
    }
}
