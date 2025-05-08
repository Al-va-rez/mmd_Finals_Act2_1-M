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

            <!-- MAIN INTERFACE -->
            <div class="flex flex-row flex-nowrap">
                <!-- ADD CUSTOMER -->
                    <!-- form flex flex-col -->
                        <!-- div flex flex-row flex-nowrap -->
                            <!-- label -->
                            <!-- input first name -->
                        <!-- /div -->

                        <!-- div flex flex-row flex-nowrap -->
                            <!-- label -->
                            <!-- input last name -->
                        <!-- /div -->

                        <!-- div flex flex-row flex-nowrap -->
                            <!-- label -->
                            <!-- input address -->
                        <!-- /div -->

                        <!-- div flex flex-row flex-nowrap -->
                            <!-- label -->
                            <!-- input contact number -->
                        <!-- /div -->
                         
                        <!-- add customer button -->
                    <!-- /form -->
                <!-- /ADD CUSTOMER -->

                <!-- VIEW ALL CUSTOMERS -->
                    <!-- add dynamically using jquery -->
                    <!-- edit customer record by dbclick -->
                    <!-- delete customer record by $('#delBtn').on('click') -->
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