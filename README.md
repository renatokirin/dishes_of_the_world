# Dishes of the world

Meal filtering system that provides an API for generating sample data, retrieving meals, categories, ingredients, and tags, filtering meals, and soft deleting a meal. It is built using PHP and the Laravel framework.


## Running the project
* `composer install`
* rename .env.example to .env
* configure database in .env
* `php artisan migrate`

  For development, SQLite was used. To use SQLite in this project, change DB_CONNECTION=sqlite and remove the following lines: DB_DATABASE, DB_USERNAME, DB_PASSWORD.
  Create database.sqlite file in the /database folder 


### GET /meals/generate
Generates sample data for meals, categories, ingredients, and tags.

### GET /meals
Retrieves a list of meals with optional filtering and pagination.
Query parameters:
* `lang` (required,string): Specify the language for localization
* `category_id` (optional,integer): Filter meals by category ID
* `tags` (optional,string): Filter meals by comma-separated tag IDs.
* `with` (optional,string): Specify additional related data to include in the response (tags, ingredients, category).
* `diff_time` (optional,integer): Filter meals by creation time greater than the given UNIX timestamp.
* `page` (optional,integer): The page number for pagination (default: 1).
* `per_page` (optional,integer): The number of meals per page (deafult: 10).


### DELETE /meals/{id}
Soft deletes a meal by its ID.

### GET /categories
Retrieves a list of all categories.

### GET /ingredients
Retrieves a list of all ingredients.

### GET /tags
Retrieves a list of all tags.
