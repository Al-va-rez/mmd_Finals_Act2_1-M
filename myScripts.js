$('.inputBox').addClass('border border-gray-500 rounded-md focus:cursor-none focus:outline-red-500');

$('.inputField').addClass('flex flex-col w-full text-xl');

$('.customerContainer').addClass('hover:cursor-pointer border border-gray-400 rounded-md w-[29%] h-auto px-6 py-8');

$('.customerDetails').addClass('flex flex-col justify-center gap-4');

$('.cancelEditBtn').addClass('bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded');

$('.cancelOrderEditBtn').addClass('bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded');

$('.deleteCustomerBtn').addClass('bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded');

$('#customerOrders').addClass('flex flex-col mx-auto bg-white border rounded-lg shadow-lg p-6 m-8 w-[90%] h-[45vh]');



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
                            }, 500);
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


$('.customerDetails').on('dblclick',
    function(event) {
        const container = $(this).closest('.customerContainer');
        container.find('.customerDetails').toggleClass('hidden');
        container.find('.editCustomerForm').toggleClass('hidden');
    }
);


$('.editCustomerForm').on('submit',
    function(event) {
        event.preventDefault();

        var form = $(this);

        var customerContainer = form.closest('.customerContainer');

        var formData = {
            customerID: customerContainer.find('.customerID').val(),
            newFirstName: customerContainer.find('.newFirstName').val(),
            newLastName: customerContainer.find('.newLastName').val(),
            newAddress: customerContainer.find('.newAddress').val(),
            newContact: customerContainer.find('.newContact').val(),
            editCustomerReq: 1
        };


        $.ajax(
            {
                type: "POST",
                url: "core/handleForms.php",
                data: formData,
                success: function(data) {
                    switch (data) {
                        case 'Success':
                            alert('Changes saved!')
                            location.reload();
                            break;
                    
                        default:
                            console.log('something went wrong')
                            break;
                    }
                }
            }
        )
    }
);


$('.cancelEditBtn').on('click',
    function(event) {
        const container = $(this).closest('.customerContainer');
        container.find('.editCustomerForm').toggleClass('hidden');
        container.find('.customerDetails').toggleClass('hidden');
    }
);


$('.deleteCustomerBtn').on('click',
    function(event) {
        event.preventDefault();

        var form = $(this);

        var customerContainer = form.closest('.customerContainer');

        var customerID = customerContainer.find('.customerID').val();

        $.ajax(
            {
                type: "POST",
                url: "core/handleForms.php",
                data: {
                    customerID: customerID,
                    deleteCustomerReq: 1
                },
                success: function(data) {
                    switch (data) {
                        case 'Success':
                            alert('Customer deleted!')
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


$('.customerDetails').on('click',
    function(event) {
        event.preventDefault();

        $('#customerOrders').removeClass('hidden');
        $('#orderRecords').removeClass('hidden');

        var customerID = $(this).closest('.customerContainer').find('.customerID').val();

        $('#orderHeader').text('Orders of customer ' + customerID);

        // Loop through all order rows
        $('#orderRecords tbody tr.orderRow').each(
            function () {
                var orderCustomerID = $(this).find('.orderOfCustomer').data('customer-id');

                if (orderCustomerID == customerID) {
                    $(this).show(); // Show the matching order row
                } else {
                    $(this).hide(); // Hide unrelated order rows
                }
            }
        );
    }
);



$(document).on('dblclick', '.orderRow',
    function(event) {
        const currentRow = $(this);
        const editRow = currentRow.next('.editOrderRow');

        $('.editOrderRow').not(editRow).addClass('hidden'); // Close others
        editRow.toggleClass('hidden');
    }
);

// Submit edit form
$(document).on('submit', '.editOrderForm',
    function(event) {
        event.preventDefault();

        const form = $(this);
        const orderID = form.find('.orderID').val();
        const newName = form.find('.newOrderName').val();
        const newQty = form.find('.newOrderQuantity').val();
        const newPrice = form.find('.newOrderPrice').val();

        $.ajax(
            {
                type: 'POST',
                url: 'core/handleForms.php',
                data: {
                    orderID: orderID,
                    newOrderName: newName,
                    newOrderQuantity: newQty,
                    newOrderPrice: newPrice,
                    editOrderReq: 1
                },
                success: function(data) {
                    switch (data) {
                        case 'Success':
                            alert('Order updated!');
                            location.reload();
                            break;
                    
                        default:
                            console.log('something went wrong');
                            break;
                    }
                }
            }
        );
    }
);

// Cancel edit
$(document).on('click', '.cancelOrderEditBtn',
    function () {
        $(this).closest('.editOrderRow').addClass('hidden');
    }
);

$(document).on('click', '.deleteOrderBtn',
    function(event) {
        event.preventDefault();

        var row = $(this).closest('tr');

        var customerID = row.find('.orderOfCustomer').data('customer-id');
        var orderID = row.find('.orderIDCell').text();

        $.ajax(
            {
                type: "POST",
                url: "core/handleForms.php",
                data: {
                    orderID,
                    customerID,
                    deleteOrderReq: 1
                },
                success: function(data) {
                    switch (data) {
                        case 'Success':
                            alert('Order deleted!');
                            location.reload();
                            break;
                    
                        default:
                            console.log('something went wrong');
                            break;
                    }
                }
            }
        )
    }
);



$('.openOrderMenu').on('click',
    function(event) {
        event.preventDefault();

        var customerID = $(this).closest('.customerContainer').find('.customerID').val();

        $('#addMenuHeader').text('Add and order for customer ' + customerID);
        $('#addCustomerForm').toggleClass('hidden');
        $('#addOrderForm').toggleClass('hidden').attr('data-customer-id', customerID);
    }
);

$('#cancelAddingOrder').on('click',
    function(event) {
        event.preventDefault();

        $('#addMenuHeader').text('Add customers here');
        $('#addCustomerForm').toggleClass('hidden');
        $('#addOrderForm').toggleClass('hidden')
    }
);


$('#addOrderForm').on('submit',
    function(event) {
        event.preventDefault();

        var formData = {
            customerID: $(this).data('customer-id'),
            orderName: $('#formOrderName').val(),
            orderQuantity: $('#formOrderQuantity').val(),
            orderPrice: $('#formOrderPrice').val(),
            addOrderReq: 1
        };

        $.ajax(
            {
                type: "POST",
                url: "core/handleForms.php",
                data: formData,
                success: function(data) {
                    switch (data) {
                        case 'Success':
                            alert('Order added!');
                            location.reload();
                            break;
                    
                        default:
                            console.log('something went wrong');
                            break;
                    }
                }
            }
        )
    }
);


$('#viewDeleteLogs').on('click',
    function(event) {
        event.preventDefault();

        $('#deleteLogs').toggleClass('hidden');
    }
);

$('#closeLogs').on('click',
    function(event) {
        event.preventDefault();

        $('#deleteLogs').toggleClass('hidden');
    }
);