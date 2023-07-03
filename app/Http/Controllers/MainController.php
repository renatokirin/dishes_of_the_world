<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MealService;
use App\Services\DataGenerationService;


class MainController extends Controller
{

    private $mealService;
    private $dataGenerationService;

    public function __construct(MealService $mealService, DataGenerationService $dataGenerationService)
    {
        $this->mealService = $mealService;
        $this->dataGenerationService = $dataGenerationService;
    }


    public function getMeals(Request $request)
    {

        $request->validate([
            'category_id' => 'nullable|integer',
            'tags' => 'nullable|string',
            'tags.*' => 'integer',
            'with' => 'nullable|string',
            'diff_time' => 'nullable|integer',
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
        ]);

        if ($request->has('lang')) {
            $locale = $request->query('lang');
            app()->setLocale($locale);
        } else {
            return response()->json([
                'message' => 'Language is required'
            ], 406);
        }

        $meals = $this->mealService->getMeals($request);

        return response()->json([
            'meta' => [
                'currentPage' => $meals->currentPage(),
                'totalItems' => $meals->total(),
                'itemsPerPage' => $meals->perPage(),
                'totalPages' => $meals->lastPage(),
            ],
            'data' => $meals->items(),
        ]);
    }


    public function deleteMeal(int $id)
    {
        $response = $this->mealService->deleteMeal($id);

        return response()->json($response);
    }

    public function generateData()
    {
        $response = $this->dataGenerationService->generateData();

        return response()->json($response);
    }

    public function getCategories()
    {
        return $this->mealService->getCategories();
    }

    public function getIngredients()
    {
        return $this->mealService->getIngredients();
    }

    public function getTags()
    {
        return $this->mealService->getTags();
    }
}
