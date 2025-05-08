<?php
    require_once 'core/myFunctions.php';

    // if user not yet registered and/or logged in
    if(!isset($_SESSION['username'])) {
        header('Location: login.php');
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AJAX 1:Many</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    </head>
    <body>
        <main>
            <a href="core/handleForms.php?btn_Logout=1">Logout</a>


            <!-- MAIN INTERFACE -->
            <div class="flex flex-row flex-nowrap justify-evenly">

                <!-- ADD CUSTOMER -->
                <div class="bg-white border rounded-lg shadow-lg p-6 w-[40%] h-[60vh]">

                    <div class="text-center">Add customers here</div>

                    <form id="addCustomerForm" class="w-full mt-12 space-y-10">

                        <div class="space-y-4">

                            <div class="inputField">
                                <label for="username">Username: </label>
                                <input id="formUsername" type="text" name="username" class="inputBox" required>
                            </div>

                            <div class="inputField">
                                <label for="firstName">First Name: </label>
                                <input id="formFirstName" type="text" name="firstName" class="inputBox" required>
                            </div>

                            <div class="inputField">
                                <label for="lastName">Last Name: </label>
                                <input id="formLastName" type="text" name="lastName" class="inputBox" required>
                            </div>

                            <div class="inputField">
                                <label for="adress">Home Address: </label>
                                <input id="formAddress" type="text" name="adress" class="inputBox" required>
                            </div>

                            <div class="inputField">
                                <label for="contactNum">Contact Number: </label>
                                <input id="formContact" type="text" name="contactNum" class="inputBox" required>
                            </div>

                        </div>

                        <button id="addCustomerBtn" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Add
                        </button>

                    </form>

                </div>    
                <!-- /ADD CUSTOMER -->
                

                <!-- VIEW ALL CUSTOMERS -->
                    <!-- edit customer record by dbclick -->
                    <!-- delete customer record by $('#delBtn').on('click') -->
                    
                    <div class="flex flex-col bg-white border rounded-lg shadow-lg p-6 w-[50%] h-[70vh]">
                        <div class="text-center">All current customers</div>

                        <div class="flex flex-row flex-wrap w-full max-h-[90%] overflow-y-auto gap-8 mt-8">
                            
                            <?php $customerData = getAllCustomers($pdo); ?>
                            <?php foreach ($customerData as $row) { ?>
                                <div class="flex flex-col hover:cursor-pointer justify-center border border-gray-400 rounded-md w-[29%] h-auto gap-4 px-6 py-8">
                                    <div><?= $row['username'] ?></div>
                                    <div><?= $row['first_Name'] ?></div>
                                    <div><?= $row['last_Name'] ?></div>
                                    <div><?= $row['home_address'] ?></div>
                                    <div><?= $row['contact_Num'] ?></div>
                                    <div><?= $row['added_by'] ?></div>
                                    <div><?= $row['date_added'] ?></div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                <!-- /VIEW ALL CUSTOMERS -->
            </div>
            <!-- /MAIN INTERFACE -->


            <!-- CUSTOMER'S ORDERS INTERFACE -->
            <div class="flex flex-row flex-wrap">
                <!-- show/hide under main interface -->
                <!-- edit orders by dbclick -->
                <!-- delete orders by $('#delBtn').on('click') -->
            </div>
            <!-- /CUSTOMER'S ORDERS INTERFACE -->

        </main>


        <script src="myScripts.js"></script>
    </body>
</html>