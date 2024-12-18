<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class PhotoController extends Controller
{
    // Képek lekérése
    public function index()
    {
        // Lekérjük az összes képet az adatbázisból
        $photos = Photo::all();
    
        // Adjuk hozzá a teljes URL-t a képekhez
        $photos = $photos->map(function ($photo) {
            $photo->file_path = asset('storage/' . $photo->file_path);
            return $photo;
        });
    
        return response()->json($photos);
    }
    

    public function store(Request $request)
{
    // Validáljuk a képet, hogy a 'photo' mezőben kapjunk egy képfájlt
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // A fájl tárolása a 'public/photos' mappába
    $path = $request->file('photo')->store('public/images');

    // Az adatbázisba mentjük a képet, tároljuk az elérési utat
    $photo = new Photo();
    $photo->file_path = basename($path); // Az elérési útból csak a fájl nevét tároljuk
    $photo->save();

    // Visszatérünk egy válasszal (pl. sikerüzenettel)
    return response()->json(['message' => 'Kép sikeresen feltöltve!']);
}

    
}
