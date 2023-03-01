<x-app-layout>
    <div class="py-8 mx-auto max-w-5xl px-2 sm:px-6 lg:px-8">
        <h1 class="uppercase text-center text-3xl font-bold">Etiqueta: {{ $tag->name }}</h1>

        @foreach ($posts as $post)
        <x-cardposts :post="$post"/>

        @endforeach

        <div class="mt-4">
            {{$posts->links()}}
        </div>
    </div>
</x-app-layout>
