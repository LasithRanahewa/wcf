<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

    <style>
        /* Your CSS styles go here */
        .containercheckout {
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 0.5rem;
            width: 60%;
            margin-left: 10%;
            margin-right: 5%;
            padding-left: 10px;
            /* Add padding to the left side */
        }

        .changeaddress {
            width: 100%;
            border: 1px solid #EEEEEE;
            padding: 10px 20px;
            margin-bottom: 20px;
            border-radius: 0.5rem;
            margin-left: 20px;
            /* Add small left padding */
            margin-right: 20px;
            /* Add small right padding */
            cursor: pointer;
            background-color: #F5F5F5;
            /* Add cursor pointer for clickability */
        }

        .contentcheckout {
            width: 100%;
        }

        .cartitems {
            width: 100%;
            display: flex;
            align-items: flex-start;
            margin-left: 3%;
            margin-right: 10%;
            padding-top: 3%;
        }


        .summary {
            width: 25%;
            border: 1px solid #EEEEEE;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: .5rem;
            margin-left: 3%;
            margin-right: 15%;
            height: 50%;
            background-color: #F5F5F5;


        }

        .delivery-option {
            display: flex;
            /* Use flexbox to align items */
            align-items: center;
            /* Align items vertically */
            margin-right: 10px;
        }

        .delivery-option-label-custom {
            cursor: pointer;
            display: inline-flex;
            /* Use inline-flex for label */
            align-items: center;
            /* Align items vertically */
            vertical-align: middle;
            /* margin-right:px; */
        }

        .material-icons {
            font-size: 18px;
            /* Adjust icon size as needed */
        }

        .delivery-option-title {
            margin-left: .4rem;
            /* Add space between icon and title */
        }

        .delivery-option-input:checked+.delivery-option-label-custom {
            /* color: #fff; */
            /* Change text color when selected */
            /* background-color: #2196f3; */
            /* Change background color when selected */
        }

        .toggle {
            width: 50%;
            /* Half of the container width */
            height: 100%;
            background-color: #fff;
            /* Background color of the toggle */
            border-radius: 20px;
            /* Match container's border-radius */
            transition: transform 0.3s;
        }

        .delivery-option-input:checked+.delivery-option-label-custom:last-of-type~.toggle {
            transform: translateX(100%);
            /* Move toggle to the right for delivery */
        }

        .cart {
            width: 100%;
            border: 1px solid #EEEEEE;
            padding: 10px 20px;
            margin-bottom: 20px;
            border-radius: 0.5rem;

            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-content: center;
            margin-top: 5%;
            background-color: #F5F5F5;
            /* Add small left padding */
        }

        .top {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            margin: 20px 0;
        }

        .detail h2 {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin: 5px 0;
            font-size: 1vw;
            color: #333;
            font-weight: lighter;
        }

        .detail h2 span {
            margin-left: 20px;
            /* Add margin to create space between h2 and span */
            display: flex;
            align-items: center;
        }

        .detail h2 span::before {
            /* Add a vertical bar before the span */
            margin-right: 10px;
            /* Add margin to separate the vertical bar from text */
        }

        .detail h2 span::after {
            margin-left: 10px;
            /* Add margin to separate the text from the currency symbol */
        }

        .detail h2#discount span::before,
        .detail h2#delivery span::before,
        .detail h2#total span::before {
            content: "";
            /* Remove the vertical bar for specific h2 elements */
        }

        .smallcart {
            display: flex;
            flex-direction: row;
        }

        .product {
            display: flex;
            flex-direction: row;
            padding: 10px;
            width: 100%;
            justify-content: space-around;
            margin-bottom: 5%;
        }

        .imag-box {
            width: 100px;
            height: 80px;
        }

        .detail {
            flex-direction: column;
            margin-left: 10%;
            margin-right: 10%;
        }

        .details {
            display: flex;
            flex-direction: column;
            width: 150px;
            height: 80px;
        }

        .pdetails {
            flex-direction: row;
        }

        .product-details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: start;
        }

        .product-details p {
            line-height: 1.5;
            margin-bottom: 5px;
            display: block;
            font-size: 1vw;
            font-weight: lighter;
            color: #333;
        }

        .product-details .title {
            line-height: 1.5;
            margin-bottom: 5px;
            display: block;
            font-size: 1vw;
            font-weight: bolder;
            color: #000;
        }

        hr {
            margin: 5px 0;
            border: 1px solid #ddd;
        }

        .promo {
            display: flex;
            flex-direction: row;
        }

        .button {
            background-color: #000;
            color: #fff;
            padding: 8px 30px;
            cursor: pointer;
            margin-bottom: 15px;
            border-radius: 0.5rem;
            margin-left: 35%;
            margin-top: 5%;
        }

        /* CSS for form buttons */
        .form-buttons {
            margin-top: 20px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .form-buttons button {
            padding: 8px 16px;
            margin-right: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
        }

        .form-buttons button[type="submit"] {
            background-color: #000;
            /* Green */
            color: white;
        }

        .form-buttons button[type="submit"]:hover {
            background-color: hsl(152, 51%, 52%);
        }

        .form-buttons button[type="button"] {
            background-color: #000;
            /* Red */
            color: white;
        }

        .form-buttons button[type="button"]:hover {
            background-color: hsl(152, 51%, 52%);
        }

        .change-address-form {
            display: none;
            width: 100%;
            border: 1px solid #EEEEEE;
            padding: 10px 20px;
            margin-bottom: 20px;
            border-radius: 0.5rem;
            margin-left: 20px;
            margin-right: 20px;
            background-color: #F5F5F5;
            /* Hide the form initially */
        }
    </style>
</head>


<body>
    <?php $this->view('includes/header', $data) ?>
    <header>
        <?php $this->view('customers/acc-nav', $data) ?>
    </header>

    <div class="contentcheckout">
        <div class="cartitems">
            <div class="containercheckout">
                <div class="changeaddress" onclick="toggleAddressForm()">
                    <h2><i class="material-icons">add_circle_outline</i> Change Your Address</h2>
                    <?php if (isset($_SESSION['NEWADDRESS'])) : ?>
                        <p><?php echo $_SESSION['NEWADDRESS']['address_line_1']; ?></p>
                        <p><?php echo $_SESSION['NEWADDRESS']['address_line_2']; ?></p>
                        <p><?php echo $_SESSION['NEWADDRESS']['city']; ?></p>
                        <p><?php echo $_SESSION['NEWADDRESS']['province']; ?></p>
                        <p><?php echo $_SESSION['NEWADDRESS']['zip_code']; ?></p>
                    <?php elseif (isset($data['customerAddress'])) : ?>
                        <p><?php echo $data['customerAddress']->address_line_1; ?></p>
                        <p><?php echo $data['customerAddress']->address_line_2 ?? ''; ?></p>
                        <p><?php echo $data['customerAddress']->city; ?></p>
                        <p><?php echo $data['customerAddress']->province; ?></p>
                        <p><?php echo $data['customerAddress']->zip_code; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Modal for Change Address Form -->

                <div class="change-address-form">
                    <h2> Change Your Address</h2>

                    <form action="#" method="post" class="address-form" onsubmit="saveAddress(); return false;">
                        <?php if (!empty($errors['address_line_1'])) : ?>
                            <p class="validate-mzg "><?= $errors['address_line_1'] ?></p>
                        <?php endif; ?>
                        <input value="<?= set_value('address_line_1') ?>" type="text" name="address_line_1" placeholder="Address Line 1">

                        <?php if (!empty($errors['address_line_2'])) : ?>
                            <p class="validate-mzg "><?= $errors['address_line_2'] ?></p>
                        <?php endif; ?>
                        <input value="<?= set_value('address_line_2') ?>" type="text" name="address_line_2" placeholder="Address Line 2">

                        <?php if (!empty($errors['city'])) : ?>
                            <p class="validate-mzg "><?= $errors['city'] ?></p>
                        <?php endif; ?>
                        <input value="<?= set_value('city') ?>" type="text" name="city" placeholder="City">

                        <?php if (!empty($errors['province'])) : ?>
                            <p class="validate-mzg "><?= $errors['province'] ?></p>
                        <?php endif; ?>
                        <select name="province" id="province">
                            <!-- <option value="" style="color:#757575;">Province</option> -->
                            <option value="Western" selected>Western Province</option>
                            <option value="Central">Central Province</option>
                            <option value="Eastern">Eastern Province</option>
                            <option value="North Central">North Central Province</option>
                            <option value="Northern">Northern Province</option>
                            <option value="North Western">North Western Province</option>
                            <option value="Sabaragamuwa">Sabaragamuwa Province</option>
                            <option value="Southern">Southern Province</option>
                            <option value="Uva">Uva Province</option>
                        </select>

                        <?php if (!empty($errors['zip_code'])) : ?>
                            <p class="validate-mzg "><?= $errors['zip_code'] ?></p>
                        <?php endif; ?>
                        <input value="<?= set_value('zip_code') ?>" type="text" name="zip_code" placeholder="Zip Code">

                        <p>Your existing default address setting will be replaced if you make some changes here.</p>
                        <div class="form-buttons">
                            <button type="submit">Save Address</button>
                            <button type="button" onclick="cancelAddressForm()">Cancel</button>
                        </div>
                    </form>
                </div>
                <!-- End of Modal -->

                <div class="cart">


                    <?php
                    // show($data);
                    if (!isset($_POST['errors'])) {
                        $errors = [];

                        unset($_SESSION['errors']);
                    }

                    $subtotal = 0;
                    $discount = 0;
                    $total = 0;
                    $delivery = 0;

                    // $cart = $data['cart'];
                    // // show($cart);

                    $checkoutProduct = $data['checkout_product'];
                    // show($checkoutProducts);

                    $subtotal = ($checkoutProduct['price'])*($checkoutProduct['quantity']);
                    $delivery = $subtotal * 0.15;
                    $total = $subtotal + $delivery;

                    // show($_SESSION);


                    ?>
                    <div class="smallcart">
                        <div class="product">
                            <div class="imag-box">
                                <img class="img" src="<?php echo ROOT . '/' . $checkoutProduct['image_url'] ?>" width="80vw" height="80vw" alt="<?php echo $checkoutProduct['name']; ?>">
                            </div>
                            <div class="details">
                                <div class="pdetails">
                                    <div class="product-details">
                                        <p><?php echo $checkoutProduct['name'] ?></p>
                                        <p><?php echo $checkoutProduct['category'] ?></p>
                                        <p class="unit-price">RS.<?php echo $checkoutProduct['price'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="Qdetails">
                                <div class="quantity">
                                    <p><?php echo $checkoutProduct['quantity'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="summary">
                <div class="top">
                    <h2>Order Summary</h2>
                </div>
                <div class="detail">
                    <!-- Google Material Symbols Outlined Font -->
                    <div class="delivery-option">
                        <!-- Pickup Option -->
                        <input type="radio" id="pickup" name="delivery-option" class="delivery-option-input" checked>
                        <label for="pickup" class="delivery-option-label-custom">
                            <i class="material-icons">store</i>
                        </label>
                        <span class="delivery-option-title">PickUp</span>

                        <!-- Delivery Option -->
                        <input type="radio" id="delivery" name="delivery-option" class="delivery-option-input-custom">
                        <label for="delivery" class="delivery-option-label-custom">
                            <i class="material-icons">local_shipping</i>
                        </label>
                        <span class="delivery-option-title">Delivery</span>
                    </div>

                    <h2 id="subtotal">Subtotal<span>RS.<?php echo $subtotal ?></span></h2>
                    <!-- <h2 id="discount">Discount(-20%)<span>-RS.<?php echo $discount ?></span></h2> -->
                    <h2 id="delivery">Delivery<span>RS.<?php echo $delivery ?></span></h2>
                    <hr />
                    <h2 id="total">Total<span>RS.<?php echo $total ?></span></h2>
                </div>
                <div class="confirm-button">
                    <button class="button" onclick="paymentGateway()">Pay</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <?php $this->view('includes/footer', $data) ?>




    <script>
        function changeAddressInPickupMode() {
            alert("You can't change the address in pickup mode.");
        }

        var type = 'pickup';

        // Function to toggle the address form visibility and change the background color when pickup is selected
        function toggleAddressForm() {
            // Get the status of the pickup option
            var isPickupSelected = document.getElementById('pickup').checked;
            var deliveryOption = document.getElementById('delivery');

            // Get the elements related to changing the address
            var changeAddressSection = document.querySelector('.changeaddress');
            var addressForm = document.querySelector('.change-address-form');

            // If pickup is selected, do not show the address form and change background color
            if (isPickupSelected) {
                var form = document.querySelector('.change-address-form');
                form.style.display = 'none';
                changeAddressSection.style.backgroundColor = '#EEEEEE'; // Add background color
            } else {
                // If delivery is selected, show the address form and remove background color
                addressForm.style.display = 'block'; // Assuming address form should be visible for delivery
                changeAddressSection.style.backgroundColor = ''; // Remove background color
            }
        }

        // Attach event listener to the "Change Your Address" section
        document.querySelector('.changeaddress').addEventListener('click', function(event) {
            // Get the status of the pickup option
            var isPickupSelected = document.getElementById('pickup').checked;

            // If pickup mode is selected, show the message
            if (isPickupSelected) {
                changeAddressInPickupMode();
            } else {
                // If delivery mode is selected, toggle the address form
                toggleAddressForm();
            }
        });

        // Function to handle cancellation of the address form
        function cancelAddressForm() {
            var form = document.querySelector('.change-address-form');
            form.style.display = 'none';
        }

        var addressId = <?php echo isset($data['customerAddress']) ? $data['customerAddress']->address_id : 'null'; ?>;

        // Function to handle saving of the address
        function saveAddress() {
            // Get the form data
            var formData = new FormData(document.querySelector('.address-form'));

            // Send the form data to the server
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'checkout/saveAddress', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Handle success response
                    console.log(xhr.responseText);
                    addressId = xhr.responseText;
                    cancelAddressForm();
                    alert('Delivery address changed successfully!');
                } else {
                    // Handle error response
                    console.error('Error:', xhr.statusText);
                }
            };
            xhr.send(formData);
        }

        // Function to handle the delivery option selection
        function handleDeliveryOption() {
            // Get the status of the pickup option
            var isPickupSelected = document.getElementById('pickup').checked;

            // Get the elements related to changing the address
            var changeAddressSection = document.querySelector('.changeaddress');
            var addressForm = document.querySelector('.change-address-form');

            // If pickup is selected, hide the address form and update the style
            if (isPickupSelected) {
                addressForm.style.display = 'none';
                changeAddressSection.style.backgroundColor = '#CCCCCC';
            } else {
                type = 'delivery';
                // If delivery is selected, show the address form and update the style
                addressForm.style.display = 'none'; // Assuming address form should be visible for delivery
                changeAddressSection.style.backgroundColor = '';
            }
        }

        // Attach event listeners to the radio buttons for delivery options
        document.getElementById('pickup').addEventListener('change', handleDeliveryOption);
        document.getElementById('delivery').addEventListener('change', handleDeliveryOption);

        // Initially handle the selected delivery option
        handleDeliveryOption();
    </script>



    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
    <script>
        function paymentGateway() {
            event.preventDefault();
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    alert(xhttp.responseText);
                    console.log(xhttp.responseText);

                    var res = xhttp.responseText;
                    console.log(res);
                    var obj = JSON.parse(xhttp.responseText);

                    var bulk_order_details_id = obj["order_id"];

                    payhere.onCompleted = function onCompleted(bulk_order_details_id) {
                        var paymentCompletedXhttp = new XMLHttpRequest();

                        paymentCompletedXhttp.onreadystatechange = function() {
                            if (paymentCompletedXhttp.readyState == 4 && paymentCompletedXhttp.status == 200) {
                                console.log("Payment completed. OrderID:" + bulk_order_details_id);
                                // Redirect to the invoice page
                                window.location = "<?php echo ROOT . '/invoice'; ?>";
                            }
                        };

                        paymentCompletedXhttp.open("GET", "<?php echo ROOT . '/payments/onCompleteBulkPayment/'; ?>" + bulk_order_details_id, true);
                        paymentCompletedXhttp.send();

                    };

                    // Payment window closed
                    payhere.onDismissed = function onDismissed() {

                        var paymentDismissedXhttp = new XMLHttpRequest();

                        paymentDismissedXhttp.onreadystatechange = function() {
                            if (paymentDismissedXhttp.readyState == 4 && paymentDismissedXhttp.status == 200) {
                                console.log("Payment dismissed. BulkID:" + bulk_order_details_id);
                                window.location = "<?php echo ROOT . '/orders/bulk'; ?>";
                            }
                        };

                        paymentDismissedXhttp.open("GET", "<?php echo ROOT . '/payments/onFaliureBulkPayment/'; ?>" + bulk_order_details_id, true);
                        paymentDismissedXhttp.send();
                    };

                    // Error occurred
                    payhere.onError = function onError(error) {

                        var paymentErrorXhttp = new XMLHttpRequest();

                        paymentErrorXhttp.onreadystatechange = function() {
                            if (paymentErrorXhttp.readyState == 4 && paymentErrorXhttp.status == 200) {
                                console.log("Payment error. BulkID:" + bulk_order_details_id);
                                console.log("Error:" + error);
                                // Redirect to the cart page
                                window.location = "<?php echo ROOT.'/orders/bulk'; ?>";
                            }
                        };

                        paymentDismissedXhttp.open("GET", "<?php echo ROOT . '/payments/onFaliureBulkPayment/'; ?>" + bulk_order_details_id, true);
                        paymentDismissedXhttp.send();
                    };

                    var payment = {
                        "sandbox": true,
                        "merchant_id": obj["merchant_id"],
                        "return_url": "<?php echo ROOT.'/orders/bulk'; ?>",
                        "cancel_url": "<?php echo ROOT .'/orders/bulk'; ?>",
                        "notify_url": "<?php echo ROOT . '/notify'; ?>",
                        "order_id": obj["order_id"],
                        "items": "mobile",
                        "amount": obj["amount"],
                        "currency": obj["currency"],
                        "hash": obj["hash"],
                        "first_name": "Saman",
                        "last_name": "Perera",
                        "email": "samanp@gmail.com",
                        "phone": "0771234567",
                        "address": "No.1, Galle Road",
                        "city": "Colombo",
                        "country": "Sri Lanka",
                        "delivery_address": "No. 46, Galle road, Kalutara South",
                        "delivery_city": "Kalutara",
                        "delivery_country": "Sri Lanka",
                        "custom_1": "",
                        "custom_2": ""
                    };

                    payhere.startPayment(payment);
                }
            }


            if (type == 'pickup') {
                xhttp.open("GET", '<?php echo ROOT . '/payments/BulkPay/'; ?><?php echo $checkoutProduct['bulk_req_id']?>', true);
            } else {
                var url = '<?php echo ROOT . '/payments/BulkPay/'; ?>';
            }

            xhttp.send();

        }
    </script>


</body>

</html>