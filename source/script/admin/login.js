var username, password;

$('#loginAdminBtn').on('click', function () {
    username = $("#username").value;
    password = $("#password").value;
    const data = {
        "username": username,
        "password": password
    }
    login(data);
});

function login(data) {
    $.ajax({
        url: 'api/login.php',
        dataType: 'json',
        type: 'POST',
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify(data),
        success: function (response) {
            if (response.success) {
                window.location.href = 'Dashboard.html';
            } else {
                alert(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        }
    });
}

function validateInput(){
    username = $("#username").value;
    password = $("#password").value;

    if(username == null || password == null){
        
    }
}