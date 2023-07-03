<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Translatable;

class Category extends Model
{
    use HasFactory;

    use Translatable;

    public $translatedAttributes = ['title'];

    protected $fillable = ['title', 'slug'];

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}
