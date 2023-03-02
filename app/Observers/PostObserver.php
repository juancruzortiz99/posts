<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostObserver
{

    public function creating(Post $post): void
    {
        //Solo sirve para los seeders
       /**  if (!\App::runningInConsole()) {
            $post->user_id = auth()->user()->id;
        }*/
    }


    public function deleting(Post $post): void
    {
        if ($post->image) {
            Storage::delete($post->image->url);
        }
    }
}
