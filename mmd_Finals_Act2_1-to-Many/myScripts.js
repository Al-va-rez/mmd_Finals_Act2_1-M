$('.inputBox').addClass('border border-gray-500 rounded-md focus:cursor-none focus:outline-red-500');

$('.inputField').addClass('flex flex-col w-full text-xl');



$('#registerForm').on('submit',
    function(event) {
        event.preventDefault();

        var formData = {
            username: $('#formUsername').val(),
            firstName: $('#formFirstName').val(),
            lastName: $('#formLastName').val(),
            password: $('#formPassword').val(),
            confirmPassword: $('#formConfirmPassword').val(),
            registerReq: 1
        };


        $.ajax(
            {
                type: "POST",
                url: "core/handleForms.php",
                data: formData,
                success: function(data) {
                    switch (data) {
                        case 'Success':
                            alert("Registration successful! Close the message to redirect to login page...");
                            setTimeout(function() {
                                window.location.href = "login.php";
                            }, 2000);
                            break;
                        
                        case 'Weak password':
                            alert(data);
                            break;
                        
                        case 'Passwords not the same':
                            alert(data);
                            break;
                        
                        case 'User already registered':
                            alert(data);
                            break;
                    
                        default:
                            console.log('something went wrong');
                            break;
                    }
                    
                }
            }
        )
    }
)


$('#loginForm').on('submit',
    function(event) {
        event.preventDefault();

        var formData = {
            username: $('#formUsername').val(),
            password: $('#formPassword').val(),
            loginReq: 1
        };


        $.ajax(
            {
                type: "POST",
                url: "core/handleForms.php",
                data: formData,
                success: function(data) {
                    switch (data) {
                        case 'Success':
                            window.location.href = "index.php";
                            break;
                        
                        case 'Incorrect Password':
                            alert(data);
                            break;
                        
                        case 'User not yet registered':
                            alert(data);
                            break;
                    
                        default:
                            console.log('something went wrong');
                            break;
                    }
                    
                }
            }
        )
    }
)


$('#addCustomerForm').on('submit',
    function(event) {
        event.preventDefault();

        var formData = {
            username: $('#formUsername').val(),
            firstName: $('#formFirstName').val(),
            lastName: $('#formLastName').val(),
            homeAddress: $('#formAddress').val(),
            contactNum: $('#formContact').val(),
            addCustomerReq: 1
        };


        $.ajax(
            {
                type: "POST",
                url: "core/handleForms.php",
                data: formData,
                success: function(data) {
                    switch (data) {
                        case 'Success':
                            alert('Customer added!')
                            location.reload();
                            break;
                    
                        default:
                            break;
                    }
                }
            }
        )
    }
);