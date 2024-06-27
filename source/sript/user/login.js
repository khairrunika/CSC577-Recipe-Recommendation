var username, password;

// $('#loginAdminBtn').on('click', function () {
//     username = $("#username").val();
//     password = $("#password").val();
//     const data = {
//         username: username,
//         password: password
//     }
//     login(data);
// });

$(document).ready(function() {
    $('#loginUserBtn').on('click', function () {
        console.log("Login button clicked");
        
        let username = $("#username").val();
        let password = $("#password").val();
        
        console.log("Username:", username);
        console.log("Password:", password);
        
        const data = {
            username: username,
            password: password
        }
        login(data);
    });
});

function login(data) {
    $.ajax({
        url: '/recipe_rocket/source/api/user/login.php',
        dataType: 'json',
        type: 'POST',
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify(data),
        success: function (response) {
            console.log('Response:', response);
            if (response.success) {
                window.location.href = 'homepage.html';
            } else {
                alert(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('XHR:', xhr);
            console.error('Status:', status);
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        }
    });
    
}