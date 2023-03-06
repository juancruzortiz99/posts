<x-app-layout>

    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8 py-8">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($posts as $post)
                <article class="w-full h-80 bg-cover bg-center @if ($loop->first) md:col-span-2 @endif"
                    style="background-image: url(@if ($post->image) {{ Storage::url($post->image->url) }}@else https://cdn.pixabay.com/photo/2022/11/10/20/44/switzerland-7583676_960_720.jpg @endif)">
                    <div class="w-full h-full px-8 flex flex-col justify-center">
                        <div>
                            @foreach ($post->tags as $tag)
                                @if ($tag->color == 'yellow')
                                    <a href="{{ route('posts.tag', $tag) }}"
                                        class="inline-block px-3 h-6 text-white rounded-full"
                                        style="background-color: {{ $tag->color }}; color:black;"><strong>{{ $tag->name }}</strong></a>
                                @else
                                    <a href="{{ route('posts.tag', $tag) }}"
                                        class="inline-block px-3 h-6 text-white rounded-full"
                                        style="background-color: {{ $tag->color }}; color:white;"><b>{{ $tag->name }}</b></a>
                                @endif
                            @endforeach
                        </div>
                        <h1 class="text-4xl text-white leading-8 font-bolt">
                            <a href="{{ route('posts.show', $post) }}">
                                {{ $post->name }}
                            </a>
                        </h1>
                    </div>
                </article>
            @endforeach

        </div>

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>

</x-app-layout>
