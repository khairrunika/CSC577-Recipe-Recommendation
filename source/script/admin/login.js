var username, password;

$('#loginAdminBtn').on('click', function () {
    username = $("#username").val();
    password = $("#password").val();
    const data = {
        username: username,
        password: password
    }
    login(data);
});

function login(data) {
    $.ajax({
        url: '/CSC577-Recipe-Recommendation/source/api/admin/login.php',
        dataType: 'json',
        type: 'POST',
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify(data),
        success: function (response) {
            window.location.href = '../Admin/Dashboard.html';
            
        },
        error: function (xhr, status, error) {
            // console.log('Error:', error);
            alert('An error occurred. Please try again.');
        }
    });
}

function validateInput(){
    username = $("#username").val();
    password = $("#password").val();

    if(username == null || password == null){
        
    }
}