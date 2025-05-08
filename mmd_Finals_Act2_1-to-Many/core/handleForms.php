<?php
    require_once 'dbConfig.php';
    require_once 'myFunctions.php';


    
    /* --- USERS --- */
    // register
    if (isset($_POST['btn_Register'])) {

        if (!empty($_POST['username']) && !empty($_POST['first_Name']) && !empty($_POST['last_Name']) && !empty($_POST['password'])) {

            $role = $_POST['role'];
            $username = sanitizeInput($_POST['username']);
            $first_Name = sanitizeInput($_POST['first_Name']);
            $last_Name = sanitizeInput($_POST['last_Name']);

            if ($_POST['password'] == $_POST['password_conf']) {

                if (validatePassword(sanitizeInput($_POST['password']))) { // check password strength

                    $password = password_hash(sanitizeInput($_POST['password']), PASSWORD_DEFAULT); // encrypt password

                    $result = register($pdo, $role, $username, $first_Name, $last_Name, $password); // add user

                    $_SESSION['status'] = $result['status'];
                    $_SESSION['message'] = $result['message'];
                    header("Location: ../login.php");

                } else { // weak password
                    $_SESSION['status'] = "400";
                    $_SESSION['message'] = "Password must be more than 8 characters consisted of uppercase and lowercase letters and numbers.";
                    header("Location: ../register.php");
                }
            } else { // passwords not the same
                $_SESSION['status'] = "400";
                $_SESSION['message'] = "Passwords are not the same";
                header("Location: ../register.php");
            }
        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../register.php");
        }
    }

    // login
    if (isset($_POST['btn_Login'])) {

        if (!empty($_POST['username']) && !empty($_POST['password'])) {

            $username = sanitizeInput($_POST['username']);
            $password = sanitizeInput($_POST['password']);

            $check_User = check_UserExists($pdo, $username); 

            if ($check_User['status'] == '200') { // user found in database
                $username_FromDB = $check_User['userInfo']['username'];
                $role_FromDB = $check_User['userInfo']['role'];
                $password_FromDB = $check_User['userInfo']['password'];

                if (password_verify($password, $password_FromDB)) {

                    $_SESSION['username'] = $username_FromDB;
                    $_SESSION['role'] = $role_FromDB;
                    header('Location: ../index.php');
                    
                } else { // wrong password
                    $_SESSION['status'] = "400";
                    $_SESSION['message'] = "Wrong password.";
                    header("Location: ../login.php");
                }
            } else { // wrong username
                $_SESSION['status'] = $check_User['status'];
                $_SESSION['message'] = $check_User['message'];
                header("Location: ../login.php");
            }
        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../login.php");
        }
    }

    if (isset($_POST['test'])) {
        echo "Hello World" . $_POST['username'] . $_POST['password'];
    }

    // logout
    if (isset($_GET['btn_Logout'])) {
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        header('Location: ../index.php');
    }



    /* --- CUSTOMERS --- */
    // ADD
    if (isset($_POST['add_Customer_Btn'])) {
        $username = sanitizeInput($_POST['username']);
        $first_Name = sanitizeInput($_POST['first_Name']);
        $last_Name = sanitizeInput($_POST['last_Name']);
        $home_address = sanitizeInput($_POST['home_address']);
        $contact_Num = sanitizeInput($_POST['contact_Num']);
        $added_by = $_SESSION['username'];

        if (!empty($username) && !empty($first_Name) && !empty($last_Name) && !empty($home_address) && !empty($contact_Num)) {
            
            $query = addCustomer($pdo, $username, $first_Name, $last_Name, $home_address, $contact_Num, $added_by); 

            if ($query) {
                header("Location: ../index.php");
            } else {
                echo "AAAAAAAAAAAAAAAA";
            }

        } else {
            echo "There are empty fields";
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