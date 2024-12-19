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
}
