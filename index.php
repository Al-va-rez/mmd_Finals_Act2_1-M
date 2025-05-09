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
            <!-- MISC BTNS -->
            <button id="registerBtn" type="button" onclick="location.href='core/handleForms.php?btn_Logout=1'" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700">
                Logout
            </button>
            <button id="viewDeleteLogs" type="button" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                View Delete Logs
            </button>
            <!-- /MISC BTNS -->


            <!-- MAIN INTERFACE -->
            <div class="flex flex-row flex-nowrap justify-evenly mt-4">

                <!-- ADDING RECORDS -->
                <div class="bg-white border rounded-lg shadow-lg p-6 w-[30%] h-[60vh]">

                    <!-- header -->
                    <div id="addMenuHeader" class="text-xl text-center font-bold">Add customers here</div>


                    <!-- ADD CUSTOMER -->
                    <form id="addCustomerForm" class="w-full mt-12 space-y-8">

                        <div class="space-y-6">

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
                    <!-- /ADD CUSTOMER -->


                    <!-- /ADD ORDER -->
                    <form id="addOrderForm" class="hidden w-full mt-12 space-y-8">

                        <div class="space-y-6">

                            <div class="inputField">
                                <label for="orderName">Order Name: </label>
                                <input id="formOrderName" type="text" name="orderName" class="inputBox" required>
                            </div>

                            <div class="inputField">
                                <label for="orderQuantity">Order Quantity: </label>
                                <input id="formOrderQuantity" type="text" name="orderQuantity" class="inputBox" required>
                            </div>

                            <div class="inputField">
                                <label for="orderPrice">Order Price: </label>
                                <input id="formOrderPrice" type="text" name="orderPrice" class="inputBox" required>
                            </div>

                        </div>

                        <button id="addOrderBtn" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Add
                        </button>
                        <button id="cancelAddingOrder" type="button" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                            Cancel order
                        </button>

                    </form>
                    <!-- /ADD ORDER -->

                </div>    
                <!-- /ADDING RECORDS -->
                

                <!-- VIEW ALL CUSTOMERS -->
                <div class="flex flex-col bg-white border rounded-lg shadow-lg p-6 w-[60%] h-[60vh]">

                    <!-- header -->
                    <div class="text-xl text-center font-bold">All current customers</div>

                    <!-- body -->
                    <div class="flex flex-row flex-wrap w-full max-h-[90%] overflow-y-auto gap-8 mt-8">
                        
                        <?php $customerData = getAllCustomers($pdo); ?>

                        <?php foreach ($customerData as $row) { ?>

                            <div class="customerContainer">

                                <input type="hidden" class="customerID" value="<?= $row['customer_id']; ?>">

                                
                                <!-- CUSTOMER DETAILS -->
                                <div class="customerDetails">

                                    <div class="font-bold text-center">Customer <?= $row['customer_id'] ?></div>
                                    <div><span class="font-bold">Name: </span><?= $row['first_Name'] ?>  <?= $row['last_Name'] ?></div>
                                    <div><span class="font-bold">Address: </span><?= $row['home_address'] ?></div>
                                    <div><span class="font-bold">Contact: </span><?= $row['contact_Num'] ?></div>
                                    <div><span class="font-bold">Added by: </span><?= $row['added_by'] ?></div>
                                    <div><span class="font-bold">Date added: </span><?= $row['date_added'] ?></div>

                                    <div>
                                        <button class="openOrderMenu px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Add Order</button>
                                        <button class="deleteCustomerBtn">Delete</button>

                                        <?php if (isset($row['updated_by'])) { ?> <!-- if record has been updated -->
                                            <div class="text-right text-sm text-gray-500 mt-4">
                                                <div>*Updated By: <?= $row['updated_by']; ?></div>
                                                <div>*Updated On: <?= $row['last_updated']; ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                </div>
                                <!-- /CUSTOMER DETAILS -->


                                <!-- EDIT CUSTOMER RECORD -->
                                <form class="editCustomerForm hidden w-full space-y-10">

                                    <div class="space-y-4">

                                        <input type="hidden" class="customerID" value="<?= $row['customer_id']; ?>">

                                        <div class="inputField">
                                            <label for="firstName">First Name: </label>
                                            <input type="text" name="firstName" class="inputBox newFirstName" value="<?= $row['first_Name']; ?>" required>
                                        </div>

                                        <div class="inputField">
                                            <label for="lastName">Last Name: </label>
                                            <input type="text" name="lastName" class="inputBox newLastName" value="<?= $row['last_Name']; ?>" required>
                                        </div>

                                        <div class="inputField">
                                            <label for="adress">Home Address: </label>
                                            <input type="text" name="adress" class="inputBox newAddress" value="<?= $row['home_address']; ?>" required>
                                        </div>

                                        <div class="inputField">
                                            <label for="contactNum">Contact Number: </label>
                                            <input type="text" name="contactNum" class="inputBox newContact" value="<?= $row['contact_Num']; ?>" required>
                                        </div>

                                    </div>

                                    <button id="editCustomerBtn" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                        Save Changes
                                    </button>
                                    <button type="button" class="cancelEditBtn">
                                        Cancel
                                    </button>

                                </form>
                                <!-- /EDIT CUSTOMER RECORD -->

                            </div>

                        <?php } ?>

                    </div>

                </div>
                <!-- /VIEW ALL CUSTOMERS -->

            </div>
            <!-- /MAIN INTERFACE -->


            <!-- CUSTOMER'S ORDERS INTERFACE -->
            <div id="customerOrders" class="hidden">

                <?php $ordersData = getAllOrders($pdo); ?>

                <!-- header -->
                <div id="orderHeader" class="text-xl text-center font-bold"></div>

                <!-- body -->
                <table id="orderRecords" class="mt-8 hidden min-w-full divide-y divide-gray-200 text-sm text-left">
                    <thead class="bg-gray-100 font-bold">
                        <tr>
                            <th class="px-4 py-2">Order ID</th>
                            <th class="px-4 py-2">Order Name</th>
                            <th class="px-4 py-2">Order Quantity</th>
                            <th class="px-4 py-2">Order Price</th>
                            <th class="px-4 py-2">Added By</th>
                            <th class="px-4 py-2">Date Added</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ordersData as $order) { ?>

                            <!-- ORDER DETAILS -->
                            <tr class="orderRow cursor-pointer hover:bg-gray-50">
                                <td class="orderOfCustomer" data-customer-id="<?= $order['customer_id'] ?>">
                                    <?= $order['customer_id'] ?>
                                </td>
                                <td class="orderIDCell px-4 py-2"><?= $order['order_id'] ?></td>
                                <td class="px-4 py-2"><?= $order['order_Name'] ?></td>
                                <td class="px-4 py-2"><?= $order['order_Quantity'] ?></td>
                                <td class="px-4 py-2"><?= $order['order_Price'] ?></td>
                                <td class="px-4 py-2"><?= $order['added_by'] ?></td>
                                <td class="px-4 py-2"><?= $order['date_added'] ?></td>
                                <td class="px-4 py-2">
                                    <?php if (isset($order['updated_by'])) { ?>
                                        <div class="text-sm text-gray-500">
                                            <div>*Updated By: <?= $order['updated_by'] ?></div>
                                            <div>*On: <?= $order['last_updated'] ?></div>
                                        </div>
                                    <?php } ?>
                                    <button class="deleteOrderBtn text-red-500 underline">Delete</button>
                                </td>
                            </tr>
                            <!-- /ORDER DETAILS -->


                            <!-- EDITING MENU -->
                            <tr class="editOrderRow hidden bg-gray-50">
                                <td colspan="8">
                                    <form class="editOrderForm space-y-4 p-4">
                                        <input type="hidden" class="orderID" value="<?= $order['order_id']; ?>">

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label>Order Name:</label>
                                                <input type="text" class="inputBox newOrderName w-full" value="<?= $order['order_Name'] ?>" required>
                                            </div>
                                            <div>
                                                <label>Quantity:</label>
                                                <input type="number" class="inputBox newOrderQuantity w-full" value="<?= $order['order_Quantity'] ?>" required>
                                            </div>
                                            <div>
                                                <label>Price:</label>
                                                <input type="number" class="inputBox newOrderPrice w-full" value="<?= $order['order_Price'] ?>" required>
                                            </div>
                                        </div>

                                        <div class="flex justify-end gap-2 pt-4">
                                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save</button>
                                            <button type="button" class="cancelOrderEditBtn px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            <!-- /EDITING MENU -->

                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- /CUSTOMER'S ORDERS INTERFACE -->


            <!-- DELETE LOGS -->
            <div id="deleteLogs" class="hidden fixed inset-0 bg-white bg-opacity-75 flex flex-col items-center justify-center z-50 p-8">

                <div class="bg-white border rounded-lg shadow-lg p-6 w-[50%] max-h-[80vh] overflow-y-auto">

                    <?php $deleteLogs = getAll_DeleteLogs($pdo); ?>

                    <table class="min-w-full table-auto border-collapse">
                        <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                            <tr>
                                <th class="px-4 py-2 border">Delete ID</th>
                                <th class="px-4 py-2 border">Customer ID</th>
                                <th class="px-4 py-2 border">Order ID</th>
                                <th class="px-4 py-2 border">Deleted By</th>
                                <th class="px-4 py-2 border">Time Deleted</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            <?php foreach ($deleteLogs as $log) { ?>
                                <tr class="hover:bg-gray-50 even:bg-gray-50">
                                    <td class="px-4 py-2 border text-center"><?= $log['del_id'] ?></td>
                                    <td class="px-4 py-2 border text-center"><?= $log['customer_id'] ?></td>
                                    <?php if(isset($log['order_id'])) { ?>
                                        <td class="px-4 py-2 border text-center"><?= $log['order_id'] ?></td>
                                    <?php } else { ?>
                                        <td class="px-4 py-2 border text-center italic">Customer record was deleted</td>
                                    <?php } ?>
                                    <td class="px-4 py-2 border text-center"><?= $log['deleted_by'] ?></td>
                                    <td class="px-4 py-2 border text-center"><?= $log['time_deleted'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <button id="closeLogs" class="mt-6 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                        Close
                    </button>
                </div>

            </div>
            <!-- /DELETE LOGS -->

        </main>


        <script src="myScripts.js"></script>
    </body>
</html>