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

        $username = sanitizeInput($_POST['username']);
        $firstName = sanitizeInput($_POST['firstName']);
        $lastName = sanitizeInput($_POST['lastName']);
        $homeAddress = sanitizeInput($_POST['homeAddress']);
        $contactNum = sanitizeInput($_POST['contactNum']);
        $added_by = $_SESSION['username'];

            
        $query = addCustomer($pdo, $username, $firstName, $lastName, $homeAddress, $contactNum, $added_by); 

        if ($query) {
            echo "Success";
        } else {
            echo "AAAAAAAAAAAAAAAA";
        }
    }

    // UPDATE
    if (isset($_POST['edit_Customer_Btn'])) {
        $first_Name = sanitizeInput($_POST['first_Name']);
        $last_Name = sanitizeInput($_POST['last_Name']);
        $home_address = sanitizeInput($_POST['home_address']);
        $contact_Num = sanitizeInput($_POST['contact_Num']);
        $updated_by = $_SESSION['username'];

        if (!empty($first_Name) && !empty($last_Name) && !empty($home_address) && !empty($contact_Num)) {
            
            $query = editCustomer($pdo, $first_Name, $last_Name, $home_address, $contact_Num, $updated_by); 

            if ($query) {
                header("Location: ../index.php");
            } else {
                echo "AAAAAAAAAAAAAAAA";
            }

        } else {
            echo "There are empty fields";
        }
    }

    // DELETE
    if (isset($_POST['del_Customer_Btn'])) {
        $query1 = deleteCustomer($pdo, $_GET['customer_id']);
        $query2 = recordDeletion_ofCustomer($pdo, $_GET['customer_id'], $_SESSION['username']);

        if ($query1 && $query2) {
            header("Location: ../index.php");
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
    if (isset($_POST['edit_Order_Btn'])) {
        $order_Name = sanitizeInput($_POST['order_Name']);
        $order_Quantity = sanitizeInput($_POST['order_Quantity']);
        $order_Price = sanitizeInput($_POST['order_Price']);
        $updated_by = $_SESSION['username'];
        
        if (!empty($order_Name && !empty($order_Quantity)) && !empty($order_Price)) {
            
            $query = editOrder($pdo, $order_Name, $order_Quantity, $order_Price, $_GET['order_id'], $updated_by);
            
            if ($query) {
                header("Location: ../view_Orders.php?customer_id=" . $_GET['customer_id']);
            } else {
                echo "AAAAAAAAAAAAAAAA";
            }

        } else {
            echo 'There are empty fields';
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