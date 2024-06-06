$(document).ready(function() {
    $('#listOfRecipes').DataTable({
        "ajax": "/CSC577-Recipe-Recommendation/source/api/admin/getRecipes.php",
        "columns": [
            { "data": null, "render": function (data, type, row, meta) { return meta.row + 1; } },
            { "data": "recipe_name" },
            { "data": "recipe_cookingTime" },
            { "data": "recipe_cuisineType" },
            { "data": "recipe_mealType" },
            { "data": "recipe_calories" },
            { "data": "recipe_dietaryTag" }
        ]
    });
});