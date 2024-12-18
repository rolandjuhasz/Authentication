<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    // A modell védett tulajdonságai
    protected $fillable = ['file_path']; // Elérési útvonal mentése
}
