<?php

class Checkout extends Controller
{
    public function index()
    {
        $data['title'] = 'checkout';

        // Fetch cart items
        $db = new Database();
        $customerId = Auth::getCustomerID();

        // Fetch cart data
        $data['cart'] = $db->query("SELECT * FROM cart WHERE customer_id = $customerId");

        // Fetch cart products
        $cart_products = $db->query("SELECT * FROM cart_products WHERE customer_id = :customer_id", [':customer_id' => $customerId]);
        $products = [];

        // Iterate over each cart product
        foreach ($cart_products as $cart_product) {
            $error = [];
            $product_id = $cart_product->product_id;

            if ($cart_product->selected == 1) {

                // Fetch product data for the current cart product
                $product = $db->query("SELECT * FROM product WHERE product_id = $product_id");

                // Fetch product images for the current product
                $images = $db->query("SELECT * FROM product_image WHERE product_id = $product_id");
                $product_image = (array) $images[0];

                // Prepare product inventory ID
                $product_inventory_id = $product[0]->product_inventory_id;

                // Fetch product inventory data for the current product
                $product_inventory = $db->query("SELECT * FROM product_inventory WHERE product_inventory_id = $product_inventory_id");
                $quantity = $product_inventory[0]->quantity;




                $product_category_id = $product[0]->product_category_id;
                $category = $db->query("SELECT category_name FROM product_category WHERE product_category_id = $product_category_id");
                if (!empty($product_inventory) || isset($product_inventory[0])) {
                    if ($quantity < 1) {
                        $error[$product_id]['msg'] = "out of stock";

                        $cartModel = new CartDetails();
                        $cartProducts = new CartProduct();

                        $cartProducts->updateQuantity($customerId, $product_id, 0);

                        $cartProducts->updateSelectedStatus($customerId, $product_id, 0);

                        $_SESSION['cart_products'] = $cartProducts->getItemsByCustomerId($customerId);

                        $cartModel->updateCartTotals($customerId);
                        $cart = $cartModel->getCartByCustomerId($customerId);
                        $_SESSION['cart'] = $cart[0];
                        $_SESSION['error'] = $error;

                        redirect('cart');
                    } elseif ($cart_product->quantity > $quantity) {
                        $error[$product_id]['msg'] = "exceeds stock";
                        $error[$product_id]['available_quantity'] = $quantity;

                        $cartModel = new CartDetails();
                        $cartProducts = new CartProduct();

                        $cartProducts->updateQuantity($customerId, $product_id, $quantity);

                        $_SESSION['cart_products'] = $cartProducts->getItemsByCustomerId($customerId);

                        $cartModel->updateCartTotals($customerId);
                        $cart = $cartModel->getCartByCustomerId($customerId);
                        $_SESSION['cart'] = $cart[0];
                        $_SESSION['error'] = $error;

                        redirect('cart');
                    } else {
                        // Construct the product array for the current cart item
                        $mapped_product = [
                            'product_id' => $product[0]->product_id,
                            'name' => $product[0]->name,
                            'description' => $product[0]->description,
                            'price' => $product[0]->price,
                            'quantity' => $cart_product->quantity,
                            'selected' => $cart_product->selected,
                            'image_url' => $product_image['image_url'],
                            'reamaing_quantity' => $product_inventory['quantity'],
                            'category' => $category[0]->category_name,
                            'error' => $error
                        ];

                        // Add the mapped product to the products array
                        $products[] = $mapped_product;

                        // Now $cart_products contains an array of cart products with associated details
                        $data['checkout_products'] = $products;
                    }
                }
            }
        }



        // Fetch customer's address
        $customerModel = new Customer();
        $customerAddress = $customerModel->getCustomerAddress($customerId);
        $data['customerAddress'] = $customerAddress;

        // Load the checkout view
        $this->view('cart/Checkout', $data);
    }

    public function bulkCheckout($bulk_req_id)
    {
        $data['title'] = 'Bulk Order Confirmation';

        $error =[];

        $db = new Database();
        $customerId = Auth::getCustomerID();

        // $userId = Auth::getUserId();

        $bulkOrderRequest = new BulkOrderReq();
        $bulkOrderReq = $bulkOrderRequest->getBulkReqDetails($bulk_req_id);

        $product_id = $bulkOrderReq[0]->product_id;

        // Fetch product data for the current cart product
        $product = $db->query("SELECT * FROM product WHERE product_id = $product_id");

        // Fetch product images for the current product
        $images = $db->query("SELECT * FROM product_image WHERE product_id = $product_id");
        $product_image = (array) $images[0];

        $product_category_id = $product[0]->product_category_id;
        $category = $db->query("SELECT category_name FROM product_category WHERE product_category_id = $product_category_id");

        $data['checkout_product'] = [
            'bulk_req_id' => $bulk_req_id,
            'product_id' => $product[0]->product_id,
            'name' => $product[0]->name,
            'description' => $product[0]->description,
            'price' => $bulkOrderReq[0]->price_per_unit,
            'quantity' => $bulkOrderReq[0]->quantity,
            'selected' => 1,
            'image_url' => $product_image['image_url'],
            'category' => $category[0]->category_name,
            'error' => $error
        ];

        // Fetch customer's address
        $customerModel = new Customer();
        $customerAddress = $customerModel->getCustomerAddress($customerId);
        $data['customerAddress'] = $customerAddress;

        // show($data);

        $this->view('customers/bulk-checkout', $data);
    }

    public function saveAddress()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customerId = Auth::getCustomerID();

            // Check if the required POST fields exist before accessing them
            if (
                isset($_POST['address_line_1']) &&
                isset($_POST['city']) &&
                isset($_POST['province']) &&
                isset($_POST['zip_code'])
            ) {
                // Create an array with the allowed columns and their values for the new address
                $addressData = [
                    //'customer_id' => $customerId, // Associate the address with the customer
                    'address_line_1' => $_POST['address_line_1'],
                    'address_line_2' => $_POST['address_line_2'] ?? null,
                    'city' => $_POST['city'],
                    'province' => $_POST['province'],
                    'zip_code' => $_POST['zip_code']
                    // Add more fields as needed
                ];

                // Create a new Address instance and save the new address in the Address table
                $newAddress = new Address();
                $newlySavedAddress = $newAddress->saveAddressD($addressData);

                $newAddressId = $newAddress->getLastAddressIdByAddress($addressData);

                // Store the new address data in the session
                // var_dump($addressData); // Check if $addressData is populated correctly
                $_SESSION['NEWADDRESS'] = $addressData;
                // var_dump($_SESSION['NEWADDRESS']); // Check if

                // Unset the session data after setting it
                unset($_SESSION['newAddress']);

                echo $newAddressId;
            } else {
                // One or more required POST fields are missing
                echo "Failed to save address. Required fields are missing.";
            }
        } else {
            // Invalid request method
            echo "Invalid request method.";
        }
    }
}
