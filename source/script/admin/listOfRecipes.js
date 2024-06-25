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
                item["recipe_id"] = response[i].recipe_id; // Assuming there is a recipe_id field
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
        "columns": [
            { "data": "recipe_number" },
            { "data": "recipe_name" },
            { "data": "recipe_cookingTime" },
            { "data": "cuisine_type" },
            { "data": "meal_type" },
            { "data": "recipe_calories" },
            {
                "data": "recipe_id",
                "render": function (data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm" onclick="editRecipe(${data})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteRecipe(${data})">Delete</button>
                    `;
                }
            }
        ]
    });
}

function editRecipe(recipeId) {
    window.location.href = `../Admin/EditRecipe.html?recipe_id=${recipeId}`;
}

function deleteRecipe(recipeId) {
    if (confirm('Are you sure you want to delete this recipe?')) {
        $.ajax({
            url: `/CSC577-Recipe-Recommendation/source/api/admin/deleteRecipe.php`,
            type: 'POST',
            data: JSON.stringify({ recipe_id: recipeId }),
            contentType: "application/json; charset=utf-8",
            success: function(response) {
                $('#popupSuccess').text("Recipe deleted successfully.");
                $('#popup_success').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        });
    }
}

// Reload page when the "Ok" button in the success popup is clicked
$('#btnPopupSuccess').click(function() {
    location.reload();
});

// Log out
$("#logoutBtn").click(function() {
    $.ajax({
        url: '/CSC577-Recipe-Recommendation/source/api/admin/logout.php',
        type: 'POST',
        success: function(response) {
            // Redirect to login page after logout
            window.location.href = "../Admin/Login.html";
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        }
    });
});
