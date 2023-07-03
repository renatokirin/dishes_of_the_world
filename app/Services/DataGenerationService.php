<?php

namespace App\Services;

use App\Models\Meal;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Tag;
use Faker\Factory;
use App\Models\Language;

require_once(base_path() . '/vendor/autoload.php');

class DataGenerationService
{

    public function generateData()
    {
        $this->generateLanguages();
        $this->generateCategories();
        $this->generateIngredients();
        $this->generateTags();
        $this->generateMeals();

        return ['message' => 'Success'];
    }



    private function generateLanguages()
    {
        Language::create(['name' => 'English', 'code' => 'en']);
        Language::create(['name' => 'Croatian', 'code' => 'hr']);
        Language::create(['name' => 'German', 'code' => 'de']);
        Language::create(['name' => 'Dutch', 'code' => 'nl']);
    }


    private function generateCategories()
    {
        $locales = Language::pluck('code')->toArray();
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $category = new Category();

            foreach ($locales as $locale) {
                $word = $faker->word();
                $category->translateOrNew($locale)->title = $word;

                if ($locale == 'en') $category->slug = $word;
            }
            $category->save();
        }
    }


    private function generateIngredients()
    {
        $locales = Language::pluck('code')->toArray();
        $faker = Factory::create();

        for ($i = 0; $i < 25; $i++) {
            $ingredient = new Ingredient();
            foreach ($locales as $locale) {
                $word = $faker->word();
                $ingredient->translateOrNew($locale)->title = $word;

                if ($locale == 'en') $ingredient->slug = $word;
            }
            $ingredient->save();
        }
    }


    private function generateTags()
    {
        $locales = Language::pluck('code')->toArray();
        $faker = Factory::create();

        for ($i = 0; $i < 15; $i++) {
            $tag = new Tag();
            foreach ($locales as $locale) {
                $word = $faker->word();
                $tag->translateOrNew($locale)->title = $word;

                if ($locale == 'en') $tag->slug = $word;
            }
            $tag->save();
        }
    }


    private function generateMeals()
    {
        $locales = Language::pluck('code')->toArray();
        $faker = Factory::create();

        for ($i = 0; $i < 45; $i++) {
            $meal = new Meal();

            $meal->category_id = $faker->numberBetween(1, 10);

            $meal->save();

            foreach ($locales as $locale) {
                $meal->translateOrNew($locale)->title = substr($faker->text(), 0, 13);
                $meal->translateOrNew($locale)->description = substr($faker->text(), 0, 48);
            }

            $meal->save();

            $tagIds = [];
            for ($j = 0; $j < 3; $j++) {
                $tagIds[] = $faker->numberBetween(1, 15);
            }

            $ingredientIds = [];
            for ($j = 0; $j < 5; $j++) {
                $ingredientIds[] = $faker->numberBetween(1, 25);
            }

            $meal->tags()->sync($tagIds);
            $meal->ingredients()->sync($ingredientIds);
        }
    }
}
