<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('blogs.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ]);

        $slug = Str::slug($request->title);

        $blog = Blog::create([
            'title' => $request->title,
            'slug' => $slug,
            'user_id' => Auth::id(),
            'body' => $request->body
        ]);


        $blog->categories()->attach($request->categories);

        return response()->json(['success' => true, 'message' => 'Blog berhasil dibuat!']);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->with('categories')->firstOrFail();

        return view('blogs.detail', compact('blog'));
    }

    public function myblog($userId)
    {
        $blogs = Blog::where('user_id', $userId)->with('categories')->get();


        return view('blogs.myblog', compact('blogs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
