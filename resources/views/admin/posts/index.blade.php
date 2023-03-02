@extends('adminlte::page')

@section('title', 'Admin Post')

@section('content_header')

    <a href="{{ route('admin.posts.create') }}" class="btn btn-success btn-sm float-right">Nuevo post</a>



    <h1>Listado de post</h1>

@stop

@section('content')
    @livewire('admin.posts-index')
@stop
