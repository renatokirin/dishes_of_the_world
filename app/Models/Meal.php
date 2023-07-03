<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Astrotomic\Translatable\Translatable;

class Meal extends Model
{
    use HasFactory;

    use SoftDeletes;

    use Translatable;

    public $timestamps = true;

    public $translatedAttributes = ['title', 'description'];

    protected $fillable = ['category_id', 'title', 'description', 'tags', 'ingredients'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'meal_tag');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'meal_ingredient');
    }
}
