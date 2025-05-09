<?php
    require_once 'core/dbConfig.php';
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

            <!-- LOGIN INTERFACE -->
            <div id="login" class="fixed inset-0 bg-white bg-opacity-100 flex flex-col items-center justify-center z-50 p-8">

                <div class="bg-white border rounded-lg shadow-lg p-6 w-[40%] max-h-[80vh] overflow-y-auto">

                    <h2 class="text-3xl font-bold text-center">Login</h2>

                    <form id="loginForm" class="mt-12 space-y-10">

                        <div class="space-y-4">
                            <div class="inputField">
                                <label for="username">Username: </label>
                                <input id="formUsername" type="text" name="username" class="inputBox" required>
                            </div>
                            <div class="inputField">
                                <label for="password">Password: </label>
                                <input id="formPassword" type="password" name="password" class="inputBox" required>
                            </div>
                        </div>
                        

                        <div class="space-x-2">
                            <button id="registerBtn" onclick="location.href='register.php'" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700">
                                Sign-up
                            </button>
                            <button id="loginBtn" type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                Login
                            </button>
                        </div>

                    </form>
                    
                </div>

            </div>
            <!-- /LOGIN INTERFACE -->

        </main>


        <script src="myScripts.js"></script>
    </body>
</html>