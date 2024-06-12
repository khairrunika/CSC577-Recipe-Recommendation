var totalRecipe = 0, totalCuisine = 0, totalMeal = 0, totalConsumer = 0;
$(function () {
    getAllRecipes();
    getAllCuisine();
    getAllMeal();
});

function getAllRecipes(){
    $.ajax({
        url: '/CSC577-Recipe-Recommendation/source/api/admin/getRecipes.php',
        dataType: 'json',
        type: 'GET',
        contentType: "application/json; charset=utf-8",
        success: function (response) {
            for (var i = 0; i < response.length; i++){
                totalRecipe++;
            }
            $("#totalRecipe").text(totalRecipe);
            
        },
        error: function (xhr, status, error) {
            console.error('XHR:', xhr);
            console.error('Status:', status);
            console.error('Error:', error);
        }
    });
}
function getAllCuisine(){
    $.ajax({
        url: '/CSC577-Recipe-Recommendation/source/api/admin/getCuisine.php',
        dataType: 'json',
        type: 'GET',
        contentType: "application/json; charset=utf-8",
        success: function (response) {
            for (var i = 0; i < response.length; i++){
                totalCuisine++;
            }
            $("#totalCuisine").text(totalCuisine);
            
        },
        error: function (xhr, status, error) {
            console.error('XHR:', xhr);
            console.error('Status:', status);
            console.error('Error:', error);
        }
    });
}
function getAllMeal(){
    $.ajax({
        url: '/CSC577-Recipe-Recommendation/source/api/admin/getMeal.php',
        dataType: 'json',
        type: 'GET',
        contentType: "application/json; charset=utf-8",
        success: function (response) {
            for (var i = 0; i < response.length; i++){
                totalMeal++;
            }
            $("#totalMeal").text(totalMeal);
            
        },
        error: function (xhr, status, error) {
            console.error('XHR:', xhr);
            console.error('Status:', status);
            console.error('Error:', error);
        }
    });
}
//log out
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