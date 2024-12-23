<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::with('user')->latest()->get();
        // return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048' 
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public'); 
            $fields['image'] = $imagePath;
        }

        $post = $request->user()->posts()->create($fields);

        return ['post' => $post, 'user' => $post->user];
        // return $post;
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        if ($post->image) {
            $post->image = asset('storage/' . $post->image);
        }
    
        return ['post' => $post, 'user' => $post->user];
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
{

    Gate::authorize('modify', $post);

    // Validáljuk a bejövő adatokat
    $fields = $request->validate([
        'title' => 'required|max:255',
        'body' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' 
    ]);


    if ($request->hasFile('image')) {

        $imagePath = $request->file('image')->store('uploads', 'public');
        $fields['image'] = $imagePath;
    }

    $post->update($fields);

    return ['post' => $post, 'user' => $post->user];
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (!Gate::allows('modify', $post)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        $post->delete();
    
        return ['message' => 'The post was deleted'];
    }
}