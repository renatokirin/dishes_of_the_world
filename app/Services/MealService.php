<?php

namespace App\Services;

use App\Models\Meal;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MealService
{
    public function getMeals(Request $request)
    {

        $query = Meal::query();

        if ($request->has('category_id')) {
            $query->where('category_id', $request->query('category_id'));
        }

        if ($request->has('tags')) {
            $tagIds = explode(',', $request->query('tags'));
            $query->where(function ($q) use ($tagIds) {
                foreach ($tagIds as $tagId) {
                    $q->whereHas('tags', function ($subq) use ($tagId) {
                        $subq->where('tags.id', $tagId);
                    });
                }
            });
        }

        if ($request->has('diff_time')) {
            $timestamp = $request->query('diff_time');
            $date = Carbon::createFromTimestamp($timestamp);
            $query->withTrashed()->where('created_at', '>', $date);
        }


        $perPage = $request->query('per_page', 10);



        $page = $request->query('page', 1);

        $meals = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->paginate($perPage);

        if ($request->has('with')) {
            $with = explode(',', $request->query('with'));

            if (!in_array("tags", $with)) $meals->makeHidden('tags');
            if (!in_array("ingredients", $with)) $meals->makeHidden('ingredients');
            if (!in_array("category", $with)) $meals->makeHidden('category');
        } else {
            $meals->makeHidden('tags');
            $meals->makeHidden('ingredients');
            $meals->makeHidden('category');
        }

        $meals->each(function ($meal) {
            if ($meal->deleted_at) {
                $meal->status = 'Deleted';
            } elseif ($meal->created_at != $meal->updated_at) {
                $meal->status = 'Updated';
            } else {
                $meal->status = 'Created';
            }
        });


        $meals->makeHidden([
            'category_id',
            'translations',
            'created_at',
            'updated_at',
            'deleted_at'
        ]);

        $meals->each(function ($meal) {
            $meal->category->makeHidden(['translations', 'created_at', 'updated_at']);
        });

        $meals->each(function ($meal) {
            $meal->tags->each(function ($tag) {
                $tag->makeHidden(['translations', 'pivot', 'created_at', 'updated_at']);
            });
        });

        $meals->each(function ($meal) {
            $meal->ingredients->each(function ($ingredient) {
                $ingredient->makeHidden(['translations', 'pivot', 'created_at', 'updated_at']);
            });
        });

        return $meals;
    }


    public function deleteMeal(int $id)
    {
        $meal = Meal::find($id);
        $meal->delete();

        return ['message' => 'Success'];
    }

    public function getCategories()
    {
        return Category::all();
    }

    public function getIngredients()
    {
        return Ingredient::all();
    }

    public function getTags()
    {
        return Tag::all();
    }
}
