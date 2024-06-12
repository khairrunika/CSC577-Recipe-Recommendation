$(function () {
    getAllRecipes();
});

function getAllRecipes(){
    var arrayReturn = [];
    $.ajax({
        url: '/CSC577-Recipe-Recommendation/source/api/admin/getRecipes.php',
        dataType: 'json',
        type: 'GET',
        contentType: "application/json; charset=utf-8",
        success: function (response) {

            for (var i = 0; i < response.length; i++){
                var item = {};
                item["recipe_number"] = (i+1);
                item["recipe_name"] = response[i].recipe_name;
                item["recipe_cookingTime"] = response[i].recipe_cookingTime;
                item["cuisine_type"] = response[i].cuisine_type;
                item["meal_type"] = response[i].meal_type;
                item["recipe_calories"] = response[i].recipe_calories;
                arrayReturn.push(item);
            }
            tableListOfRecipes(arrayReturn);
        },
        error: function (xhr, status, error) {
            console.error('XHR:', xhr);
            console.error('Status:', status);
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        }
    });
}

function tableListOfRecipes(data){
    tableListOfRecipes = $("#listOfRecipes").DataTable({
        "aaData": data,
        "columns":
        [
            { "data": "recipe_number" },
            { "data": "recipe_name" },
            { "data": "recipe_cookingTime" },
            { "data": "cuisine_type" },
            { "data": "meal_type" },
            { "data": "recipe_calories" }
        ]
    });
}