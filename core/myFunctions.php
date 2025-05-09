<?php
    require_once 'dbConfig.php';


    
    /* --- INPUT SECURITY --- */
    function sanitizeInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validatePassword($password) {
        if (strlen($password) > 8) { // longer than 8 char
            $hasLower = false;
            $hasUpper = false;
            $hasNumber = false;

            for ($i = 0; $i < strlen($password); $i++) {
                if (ctype_lower($password[$i])) { // has lower case
                    $hasLower = true; 
                }
                elseif (ctype_upper($password[$i])) { // has upper case
                    $hasUpper = true; 
                }
                elseif (ctype_digit($password[$i])) { // has numbers
                    $hasNumber = true;
                }
                
                if ($hasLower && $hasUpper && $hasNumber) {
                    return true; 
                }
            }
        } else {
            return false; 
        }
    }


    /* --- USER ACCOUNTS --- */
    // CHECK IF ALREADY REGISTERED
    function check_UserExists($pdo, $username) {
        $response = array();

        $sql = "SELECT * FROM user_credentials WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$username])) {

            $userInfo = $stmt->fetch();

            if ($stmt->rowCount() > 0) { // user already in database
                $response = array(
                    "result" => true,
                    "status" => "200",
                    "userInfo" => $userInfo
                );
            } else { // green light for adding user
                $response = array(
                    "result" => false,
                    "status" => "400",
                    "message" => "User not found in database"
                );
            }
        }

        return $response;
    }

    // REGISTER
    function register($pdo, $username, $first_Name, $last_Name, $password) {

        $response = array();

        $check_User = check_UserExists($pdo, $username);

        
        if (!$check_User['result']) { // add user to database

            $sql = "INSERT INTO user_credentials (username, first_Name, last_Name, password) VALUES (?,?,?,?)";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute([$username, $first_Name, $last_Name, $password])) {
                $response = "Success";
            }

        } else { // user already registered
            $response = "User already registered";
        }

        return $response;
    }


    /* --- DELETE LOGS --- */
    // FETCH
    function getAll_DeleteLogs($pdo) {
        $sql = "SELECT * FROM delete_logs";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute();

        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // RECORD
    function recordDeletion_ofCustomer($pdo, $customer_id, $deleted_by) {
        $sql = "INSERT INTO delete_logs (customer_id, deleted_by) VALUES (?,?)";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$customer_id, $deleted_by]);

        if ($executeQuery) {
            return true;
        }
    }

    function recordDeletion_ofOrder($pdo, $customer_id, $order_id, $deleted_by) {
        $sql = "INSERT INTO delete_logs (customer_id, order_id, deleted_by) VALUES (?,?,?)";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$customer_id, $order_id, $deleted_by]);

        if ($executeQuery) {
            return true;
        }
    }


    /* --- CUSTOMERS --- */
    // FETCH ALL
    function getAllCustomers($pdo) {
        $sql = "SELECT * FROM customers";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute();

        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // ADD
    function addCustomer($pdo, $first_Name, $last_Name, $home, $contact, $added_by) {
        $sql = "INSERT INTO customers (first_Name, last_Name, home_address, contact_Num, added_by) VALUES (?,?,?,?,?)";   

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$first_Name, $last_Name, $home, $contact, $added_by]);

        if ($executeQuery) {
            return true;
        }
    }

    // UPDATE
    function editCustomer($pdo, $first_Name, $last_Name, $home, $contact, $updated_by, $customer_id) {
        $sql = "UPDATE customers
                    SET first_Name = ?,
                        last_Name = ?,
                        home_address = ?, 
                        contact_Num = ?,
                        updated_by = ?
                    WHERE customer_id = ?
                ";   

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$first_Name, $last_Name, $home, $contact, $updated_by, $customer_id]);

        if ($executeQuery) {
            return true;
        }
    }

    // DELETE
    function deleteCustomer($pdo, $customer_id) {
        $remove_fromOrders = "DELETE FROM orders WHERE customer_id = ?";

        $query_Remove = $pdo->prepare($remove_fromOrders);
        $executeRemoval = $query_Remove->execute([$customer_id]);

        if ($executeRemoval) {
            $sql = "DELETE FROM customers WHERE customer_id = ?";

            $query = $pdo->prepare($sql);
            $executeQuery = $query->execute([$customer_id]);

            if ($executeQuery) {
                return true;
            }
        }
    }



    /* --- ORDERS --- */
    // FETCH ALL
    function getAllOrders($pdo) {
        
        $sql = "SELECT * FROM orders";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([]);

        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // ADD
    function addOrder($pdo, $order_Name, $order_Quantity, $order_Price, $customer_id, $added_by) {
        $sql = "INSERT INTO orders (order_Name, order_Quantity, order_Price, customer_id, added_by) VALUES (?,?,?,?,?)";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$order_Name, $order_Quantity, $order_Price, $customer_id, $added_by]);

        if ($executeQuery) {
            return true;
        }
    }

    // UPDATE
    function editOrder($pdo, $order_Name, $order_Quantity, $order_Price, $order_id, $updated_by) {
        $sql = "UPDATE orders
                SET order_Name = ?,
                    order_Quantity = ?,
                    order_Price = ?,
                    updated_by = ?
                WHERE order_id = ?
                ";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$order_Name, $order_Quantity, $order_Price, $updated_by, $order_id]);

        if ($executeQuery) {
            return true;
        }
    }

    // DELETE
    function deleteOrder($pdo, $order_id) {
        $sql = "DELETE FROM orders WHERE order_id = ?";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$order_id]);

        if ($executeQuery) {
            return true;
        }
    }
?>