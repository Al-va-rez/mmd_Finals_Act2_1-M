<?php
    require_once 'dbConfig.php';
    require_once 'myFunctions.php';


    
    /* --- USERS --- */
    // register
    if (isset($_POST['registerReq'])) {

        $username = sanitizeInput($_POST['username']);
        $firstName = sanitizeInput($_POST['firstName']);
        $lastName = sanitizeInput($_POST['lastName']);
        $tempPassword = sanitizeInput($_POST['password']);
        $confirmPassword = sanitizeInput($_POST['confirmPassword']);

        if ($tempPassword == $confirmPassword) {

            if (validatePassword($tempPassword)) { // check password strength

                $password = password_hash($tempPassword, PASSWORD_DEFAULT); // encrypt password

                $result = register($pdo, $username, $firstName, $lastName, $password); // add user

                echo $result;

            } else {
                echo "Weak password";
            }
        } else {
            echo "Passwords not the same";
        }
        
    }

    // login
    if (isset($_POST['loginReq'])) {

        $username = sanitizeInput($_POST['username']);
        $password = sanitizeInput($_POST['password']);

        $check_User = check_UserExists($pdo, $username); 

        if ($check_User['result']) { // user found in database

            $username_FromDB = $check_User['userInfo']['username'];
            $password_FromDB = $check_User['userInfo']['password'];

            if (password_verify($password, $password_FromDB)) {

                $_SESSION['username'] = $username_FromDB;
                echo "Success";
                
            } else {
                echo "Incorrect Password";
            }
        } else {
            echo "User not yet registered";
        }

    }

    // logout
    if (isset($_GET['btn_Logout'])) {
        unset($_SESSION['username']);
        header('Location: ../index.php');
    }



    /* --- CUSTOMERS --- */
    // ADD
    if (isset($_POST['addCustomerReq'])) {

        $firstName = sanitizeInput($_POST['firstName']);
        $lastName = sanitizeInput($_POST['lastName']);
        $homeAddress = sanitizeInput($_POST['homeAddress']);
        $contactNum = sanitizeInput($_POST['contactNum']);
        $added_by = $_SESSION['username'];

            
        $query = addCustomer($pdo, $firstName, $lastName, $homeAddress, $contactNum, $added_by);

        if ($query) {
            echo "Success";
        } else {
            echo "AAAAAAAAAAAAAAAA";
        }
    }

    // UPDATE
    if (isset($_POST['editCustomerReq'])) {

        $newFirstName = sanitizeInput($_POST['newFirstName']);
        $newLastName = sanitizeInput($_POST['newLastName']);
        $newAddress = sanitizeInput($_POST['newAddress']);
        $newContact = sanitizeInput($_POST['newContact']);
        $updated_by = $_SESSION['username'];
        $customer_id = $_POST['customerID'];
            
        $query = editCustomer($pdo, $newFirstName, $newLastName, $newAddress, $newContact, $updated_by, $customer_id); 

        if ($query) {
            echo "Success";
        } else {
            echo "AAAAAAAAAAAAAAAA";
        }
    }

    // DELETE
    if (isset($_POST['deleteCustomerReq'])) {

        $query1 = deleteCustomer($pdo, $_POST['customerID']);
        $query2 = recordDeletion_ofCustomer($pdo, $_POST['customerID'], $_SESSION['username']);

        if ($query1 && $query2) {
            echo "Success";
        } else {
            echo "AAAAAAAAAAAA";
        }
    }



    /* --- ORDERS --- */
    // ADD
    if (isset($_POST['add_Order_Btn'])) {
        $order_Name = sanitizeInput($_POST['order_Name']);
        $order_Quantity = sanitizeInput($_POST['order_Quantity']);
        $order_Price = sanitizeInput($_POST['order_Price']);
        $added_by = $_SESSION['username'];

        if (!empty($order_Name && !empty($order_Quantity)) && !empty($order_Price)) {
            
            $query = addOrder($pdo, $order_Name, $order_Quantity, $order_Price, $_GET['customer_id'], $added_by);
            
            if ($query) {
                header("Location: ../view_Orders.php?customer_id=" . $_GET['customer_id']);
            } else {
                echo "AAAAAAAAAAAAAAAA";
            }

        } else {
            echo 'There are empty fields';
        }
    }

    // UPDATE
    if (isset($_POST['editOrderReq'])) {

        $newOrderName = sanitizeInput($_POST['newOrderName']);
        $newOrderQuantity = sanitizeInput($_POST['newOrderQuantity']);
        $newOrderPrice = sanitizeInput($_POST['newOrderPrice']);
        $updated_by = $_SESSION['username'];
        $orderID = $_POST['orderID'];
            
        $query = editOrder($pdo, $newOrderName, $newOrderQuantity, $newOrderPrice, $orderID, $updated_by);
        
        if ($query) {
            echo "Success";
        } else {
            echo "AAAAAAAAAAAAAAAA";
        }
    }

    // DELETE
    if (isset($_POST['del_Order_Btn'])) {
        $query1 = deleteOrder($pdo, $_GET['order_id']);
        
        $query2 = recordDeletion_ofOrder($pdo, $_GET['customer_id'], $_GET['order_id'], $_SESSION['username']);

        if ($query1 && $query2) {
            header("Location: ../view_Orders.php?customer_id=" . $_GET['customer_id']);
        } else {
            echo "AAAAAAAAAAAA";
        }
    }
?>