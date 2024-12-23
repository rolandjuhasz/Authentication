<?php

// app/Http/Controllers/ImageController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function index()
{
    $images = Image::all();
    return response()->json($images); 
}

public function store(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);


    $imageName = time() . '.' . $request->image->extension();
    $request->image->move(public_path('images'), $imageName);


    $image = new Image();
    $image->image_name = $imageName;
    $image->save();


    return response()->json([
        'success' => 'Image uploaded successfully.',
        'image' => $image,
    ]);
}

}
