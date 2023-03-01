<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tags;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tags::all();
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tags $tag)
    {
        return view('admin.tags.show', compact('tag'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tags $tag)
    {
        return view('admin.tags.edit', compact('tag'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tags $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tags $tag)
    {
        //
    }
}
