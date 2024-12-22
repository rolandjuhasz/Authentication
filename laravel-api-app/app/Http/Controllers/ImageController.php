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
    $images = Image::all(); // Lekérdezi az összes képet
    return response()->json($images); // JSON formátumban adja vissza
}

public function store(Request $request)
{
    // Validáció
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Kép mentése
    $imageName = time() . '.' . $request->image->extension();
    $request->image->move(public_path('images'), $imageName);

    // Adat mentése az adatbázisba
    $image = new Image();
    $image->image_name = $imageName;
    $image->save();

    // Válasz küldése
    return response()->json([
        'success' => 'Image uploaded successfully.',
        'image' => $image, // Ez tartalmazza az adatokat
    ]);
}

}
