<?php $this->view('includes/header', $data) ?>

<head>
  <link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/cart.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
<?php $this->view('includes/header', $data) ?>
    <header>
        <?php $this->view('customers/acc-nav', $data) ?>
    </header>

  <div class="container-cart">
    <div class="cart">

      <div class="top">
        <h2>Your Cart</h2>
      </div>

      <?php

      $subtotal = 0;
      $total = 0;
      $delivery = 15;

      // $cartModel = new CartDetails();
      
      //               // Check if cart record already exists for the customer
      //               $existingCart = $cartModel->getCartByCustomerId(Auth::getCustomerID());
      //               show($existingCart);
      //               show($existingCart[0]->cart_id);
      
      //               $tot = $cartModel->updateCartTotals($existingCart[0]->customer_id);
      //               show($tot);
      

      $cart = $data['cart'];
      // show($cart);
      
      $subtotal = $cart[0]->sub_total;
      $total = $cart[0]->total;
      $delivery = $cart[0]->delivery_cost;

      $cartProducts = $data['cart_products'];
      // show($cartProducts);
      
      
      // // show($data);
      
      if (isset($_SESSION['error'])) {
        $errors = $_SESSION['error'];
      
       // unset($_SESSION['error']);
      //  show($errors);
      }
      
      // $customer_id = $existingCart[0]->customer_id;
      // $product_id = $cartProducts[0]['product_id'];
      // show($customer_id);
      
      // $cartpmodel = new CartProduct();
      // $cartitem = $cartpmodel->getCartItem($customer_id, $product_id);
      // show($cartitem);
      // $tables = ['product'];
      // $columns = ['*'];
      // $condition = ['product.product_id = cart_products.product_id'];
      // $cartItem = $cartProducts->join($tables, $columns, $condition,);
      ?><?php
      if (isset($cartProducts) && !empty($cartProducts)) {
          foreach ($cartProducts as $cartProduct) {
              $outOfStockClass = isset($errors[$cartProduct['product_id']]) ? 'out-of-stock' : ''; // Check if product is out of stock
              $exceedStockClass = isset($errors[$cartProduct['product_id']]['msg']) && $errors[$cartProduct['product_id']]['msg'] == 'exceeds stock' ? 'exceed-stock' : ''; // Check if quantity exceeds available stock
              $availableQuantity = isset($errors[$cartProduct['product_id']]['available_quantity']) ? $errors[$cartProduct['product_id']]['available_quantity'] : ''; // Get available quantity
      
              ?>
              <td>
                  <div class="smallcart">
                      <div class="product <?php echo $outOfStockClass; ?>"> <!-- Add the class here -->
                          <div class="checkboxe">
                              <input type="checkbox" class="select-checkbox" data-product-id="<?php echo $cartProduct['product_id']; ?>"
                                  <?php echo ($cartProduct['selected'] == 1 && empty($outOfStockClass)) ? 'checked' : ''; ?>>
                          </div>
                          <div class="imag-box">
                              <img class="img" src="<?php echo ROOT . '/' . $cartProduct['image_url'] ?>"
                                  alt="<?php echo $cartProduct['name'] . '1'; ?>" width="80vw" height="80vw">
                          </div>
                          <div class="details">
                              <div class="pdetails">
                                  <div class="product-details">
                                      <p><?php echo $cartProduct['name'] ?></p>
                                     <p><?php echo $cartProduct['category'] ?></p>
                                      <p class="unit-price">RS.<?php echo $cartProduct['price'] ?></p>
                                  </div>
                              </div>
                          </div>
                         
                              <div class="quantity">
                                  <button type="button" class="decrease"
                                      data-product-id="<?php echo $cartProduct['product_id']; ?>"><i><span
                                          class="material-symbols-outlined">
                                          remove
                                      </span></i></button>
                                  <input type="text" data-product-id="<?php echo $cartProduct['product_id']; ?>"
                                      value="<?php echo $cartProduct['quantity']; ?>" class="form-control">
                                  <button type="button" class="increase <?php echo $exceedStockClass; ?>"
                                      data-product-id="<?php echo $cartProduct['product_id']; ?>"
                                      data-available-quantity="<?php echo $availableQuantity; ?>"><i><span
                                          class="material-symbols-outlined">
                                          add
                                      </span></i></button>
                              </div>
                              <div class="remove">
                                  <button type="button" class="remove-button" data-product-id="<?php echo $cartProduct['product_id']; ?>">
                                      <i><span class="material-symbols-outlined">
                                          delete
                                      </span></i>
                                  </button>
                              </div>
                      </div>
                  </div>
              </td>
              <?php
          }
      } else {
          echo "<h5>Cart Is Empty</h5>";
      }
      ?>
      
      <div id="message-container"></div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectCheckboxes = document.querySelectorAll(".select-checkbox");

        selectCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                const productDiv = checkbox.closest('.product');
                const isOutOfStock = productDiv.classList.contains('out-of-stock');
                const increaseButton = productDiv.querySelector('.increase');
                const decreaseButton = productDiv.querySelector('.decrease');

                if (isOutOfStock && checkbox.checked) {
                    showMessage('This item is out of stock .', 'error');
                    checkbox.checked = false;
                }

                if (isOutOfStock) {
                    productDiv.style.backgroundColor = '#EEEE';
                    increaseButton.disabled = true;
                    decreaseButton.disabled = true;
                } else {
                    productDiv.style.backgroundColor = ''; // Reset to default
                    increaseButton.disabled = false;
                    decreaseButton.disabled = false;
                }
            });
        });

        const increaseButtons = document.querySelectorAll(".increase");

        increaseButtons.forEach(function (button) {
            button.addEventListener("click", function () {
                const availableQuantity = parseInt(button.dataset.availableQuantity);
                const input = button.previousElementSibling;
                const currentValue = parseInt(input.value, 10);
                const productId = button.dataset.productId;

                if (availableQuantity !== '' && currentValue >= availableQuantity) {
                    showMessage('The quantity exceeds the available stock.', 'error');
                    input.value = availableQuantity-1; // Set input value to available quantity
                    button.disabled = true; // Disable increase button
                } else {
                    input.value = currentValue + 1;
                }
            });
        });

        function showMessage(message, type) {
            const messageContainer = document.getElementById('message-container');
            const messageElement = document.createElement('div');
            messageElement.classList.add('message', type);
            messageElement.textContent = message;
            messageContainer.appendChild(messageElement);

            // Automatically remove message after 5 seconds
            setTimeout(function () {
                messageElement.remove();
            }, 5000);
        }
    });
</script>

    </div>
    <div class="summary">
      <div class="top">
        <h2>Order Summary</h2>
      </div>
      <div class="detail">
        <h2 id="subtotal">Subtotal<span>RS.<?php echo number_format($subtotal, 2); ?></span></h2>
      </div>
      <!-- <div class="promo">
        <div class="promocode">
          <input class="promocode" type="text" placeholder="Add the promocode " id="promoCode" />
        </div>
        <button class="applybutton" id="promo" onclick="promo()">Apply</button>
      </div> -->
      <div style="padding: 0 10px; margin-bottom: 20px">
        <button class="checkout" onclick="redirectToCheckout()">Check Out</button>
      </div>

    </div>
  </div>
  <?php $this->view('includes/footer', $data) ?>

  <!-- <script>
    function redirectToCheckout() {

      var checkoutURL = "<?php echo ROOT . '/checkout'; ?>";

      window.location.href = checkoutURL;
    }

    const customer_id = <?php echo isset($_SESSION['cart']->customer_id) ? $_SESSION['cart']->customer_id : 'null'; ?>;

    // Check if customer_id is valid before using it
    if (customer_id !== null) {
      console.log("Customer ID:", customer_id);
      // You can use customer_id in your JavaScript code here
    } else {
      console.log("Customer ID not found in session");
    }

    document.addEventListener("DOMContentLoaded", function () {
      console.log("DOM Loaded");

      const decreaseButtons = document.querySelectorAll(".decrease");
      const increaseButtons = document.querySelectorAll(".increase");
      const removeButton = document.querySelectorAll(".remove-button");
      const quantityInputs = document.querySelectorAll(".quantity input");
      const unitPrices = document.querySelectorAll(".unit-price");
      const selectCheckboxes = document.querySelectorAll(".select-checkbox");
      const subtotalElement = document.getElementById("subtotal");
      const discountElement = document.getElementById("discount");
      const deliveryElement = document.getElementById("delivery");
      const totalElement = document.getElementById("total");
      const delivery = <?php echo $delivery; ?>;

      console.log("Customer ID:", customer_id);

      // Function to update cart totals
      // function updateTotal() {
      //   console.log("Updating Total...");

      //   let newSubtotal = 0;

      //   // Loop through each product
      //   quantityInputs.forEach(function(input, index) {
      //     const quantity = parseInt(input.value, 10);
      //     const unitPrice = parseFloat(unitPrices[index].innerText);

      //     // Check if the checkbox is checked
      //     if (selectCheckboxes[index].checked) {
      //       newSubtotal += quantity * unitPrice;
      //     }
      //   });

      //   const newDiscount = 0.2 * newSubtotal;
      //   const newTotal = newSubtotal - newDiscount + delivery;

      //   subtotalElement.innerText = "Subtotal: $" + newSubtotal.toFixed(2);
      //   discountElement.innerText = "Discount(-20%): -$" + newDiscount.toFixed(2);
      //   deliveryElement.innerText = "Delivery: -$" + delivery.toFixed(2);
      //   totalElement.innerText = "Total: $" + newTotal.toFixed(2);

      //   console.log("Total Updated:", newTotal);
      // }

      // Attach event listeners
      decreaseButtons.forEach(function (button) {
        button.addEventListener("click", function () {
          console.log("Decrease Button Clicked");
          const input = button.nextElementSibling;
          const currentValue = parseInt(input.value, 10);
          const productId = button.dataset.productId;

          if (currentValue > 1) {
            input.value = currentValue - 1;
            // updateTotal();
            updateCart(customer_id, productId, input.value); // Update cart with new quantity
          }
        });
      });

      increaseButtons.forEach(function (button) {
        button.addEventListener("click", function () {
          const input = button.previousElementSibling;
          const currentValue = parseInt(input.value, 10);
          const productId = button.dataset.productId;
          // console.log("Increase Button Clicked", productId, currentValue);
          input.value = currentValue + 1;
          // updateTotal();
          updateCart(customer_id, productId, input.value); // Update cart with new quantity
        });
      });

      quantityInputs.forEach(function (input) {
        input.addEventListener("input", function () {
          const productId = input.dataset.productId;
          // updateTotal();
          updateCart(customer_id, productId, input.value); // Update cart with new quantity
          // console.log("Input Changed", productId, input.value);
        });
      });

      selectCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", updateSelectedItems); // Update total whenever a checkbox is checked or unchecked
      });

      console.log("Remove buttons:", removeButton.length);

      // Function to handle the click event of the "Remove" button
      removeButton.forEach(function (button) {
        button.addEventListener('click', function (event) {
          const productId = button.dataset.productId; // Get the product ID from the button's data attribute
          console.log(productId);
          removeFromCart(customer_id, productId); // Call the removeFromCart function
        });
      });
      // Initial update
      // updateTotal();

      // AJAX function to update the cart
      function updateCart(customer_id, productId, quantity) {
        const ROOT = "http://localhost/wcf/"; // Update with your server URL
        $.ajax({
          url: ROOT + 'Cart/edit', // Endpoint to handle updating the cart
          data: {
            customer_id: customer_id,
            product_id: productId,
            quantity: quantity,
            action: 'update'
          }, // Include the updated quantity and action
          method: "POST",
        }).done(function (response) {
          console.log(response);
          $('#loader').hide();
          $('.alert').show();
          $('#result').html(response);
          window.location.reload();
          // You may need to parse the response JSON and update the table accordingly
        });
      }

      function removeFromCart(customer_id, productId) {
        const ROOT = "http://localhost/wcf/";
        $.ajax({
          url: ROOT + 'Cart/edit',
          data: {
            customer_id: customer_id,
            product_id: productId,
            action: 'remove'
          }, // Data to be sent in the AJAX request
          method: "POST", // Method of the AJAX request
        }).done(function (response) {
          // Handle the response here (if needed)
          console.log(response);
          $('#loader').hide();
          $('.alert').show();
          $('#result').html(response);
          window.location.reload();
        });
      }
    });

    // Function to handle the "Check Out" button click event
    // Function to handle the "Check Out" button click event
    // Function to handle checkbox change event
    function handleCheckboxChange(checkbox) {
      const productId = checkbox.dataset.productId;
      const selected = checkbox.checked ? 1 : 0;
      // console.log(productId, selected);
      updateSelectedItems(customer_id, productId, selected); // Call the function to update selected items
    }

    // Function to update selected items in the database
    function updateSelectedItems(customer_id, productId, selected) {
      const ROOT = "http://localhost/wcf/";
      $.ajax({
        url: ROOT + 'Cart/edit', // Endpoint to handle updating selected items
        method: 'POST',
        data: {
          customer_id: customer_id,
          product_id: productId,
          selected: selected,
          action: 'updateSelectedItems'
        }, // Include the action parameter
        success: function (response) {
          console.log(response); // Log the response for debugging
          $('#loader').hide();
          $('.alert').show();
          $('#result').html(response);
          window.location.reload();
        },
        error: function (xhr, status, error) {
          console.error(error); // Log any errors for debugging
        }
      });
    }

    // Add event listeners to checkboxes
    document.querySelectorAll('.select-checkbox').forEach(function (checkbox) {
      checkbox.addEventListener('change', function () {
        handleCheckboxChange(checkbox); // Call the function to handle checkbox change
      });
    });
  </script> -->

  <script>
    function redirectToCheckout() {
        var checkoutURL = "<?php echo ROOT . '/checkout'; ?>";
        window.location.href = checkoutURL;
    }

    const customer_id = <?php echo isset($_SESSION['cart']->customer_id) ? $_SESSION['cart']->customer_id : 'null'; ?>;

    // Check if customer_id is valid before using it
    if (customer_id !== null) {
        console.log("Customer ID:", customer_id);
        // You can use customer_id in your JavaScript code here
    } else {
        console.log("Customer ID not found in session");
    }

    document.addEventListener("DOMContentLoaded", function () {
        console.log("DOM Loaded");

        const decreaseButtons = document.querySelectorAll(".decrease");
        const increaseButtons = document.querySelectorAll(".increase");
        const removeButton = document.querySelectorAll(".remove-button");
        const quantityInputs = document.querySelectorAll(".quantity input");
        const unitPrices = document.querySelectorAll(".unit-price");
        const selectCheckboxes = document.querySelectorAll(".select-checkbox");
        const subtotalElement = document.getElementById("subtotal");
        const discountElement = document.getElementById("discount");
        const deliveryElement = document.getElementById("delivery");
        const totalElement = document.getElementById("total");
        const delivery = <?php echo $delivery; ?>;

        console.log("Customer ID:", customer_id);

        decreaseButtons.forEach(function (button) {
            button.addEventListener("click", function () {
                console.log("Decrease Button Clicked");
                const input = button.nextElementSibling;
                const currentValue = parseInt(input.value, 10);
                const productId = button.dataset.productId;

                if (currentValue > 1) {
                    input.value = currentValue - 1;
                    updateCart(customer_id, productId, input.value);
                }
            });
        });

        increaseButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent default button behavior

        const input = button.previousElementSibling;
        const currentValue = parseInt(input.value, 10);
        const productId = button.dataset.productId;
        
        input.value = currentValue;
        updateCart(customer_id, productId, input.value);
    });
});

        quantityInputs.forEach(function (input) {
            input.addEventListener("input", function () {
                const productId = input.dataset.productId;
                updateCart(customer_id, productId, input.value);
            });
        });

        selectCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener("change", updateSelectedItems);
        });

        removeButton.forEach(function (button) {
            button.addEventListener('click', function (event) {
                const productId = button.dataset.productId;
                removeFromCart(customer_id, productId);
            });
        });

        function updateCart(customer_id, productId, quantity) {
            const ROOT = "http://localhost/wcf/";
            $.ajax({
                url: ROOT + 'Cart/edit',
                data: {
                    customer_id: customer_id,
                    product_id: productId,
                    quantity: quantity,
                    action: 'update'
                },
                method: "POST",
            }).done(function (response) {
                console.log(response);
                $('#loader').hide();
                $('.alert').show();
                $('#result').html(response);
                window.location.reload();
            });
        }

        function removeFromCart(customer_id, productId) {
            const ROOT = "http://localhost/wcf/";
            $.ajax({
                url: ROOT + 'Cart/edit',
                data: {
                    customer_id: customer_id,
                    product_id: productId,
                    action: 'remove'
                },
                method: "POST",
            }).done(function (response) {
                console.log(response);
                $('#loader').hide();
                $('.alert').show();
                $('#result').html(response);
                window.location.reload();
            });
        }
    });

    function handleCheckboxChange(checkbox) {
        const productId = checkbox.dataset.productId;
        const selected = checkbox.checked ? 1 : 0;
        updateSelectedItems(customer_id, productId, selected);
    }

    function updateSelectedItems(customer_id, productId, selected) {
        const ROOT = "http://localhost/wcf/";
        $.ajax({
            url: ROOT + 'Cart/edit',
            method: 'POST',
            data: {
                customer_id: customer_id,
                product_id: productId,
                selected: selected,
                action: 'updateSelectedItems'
            },
            success: function (response) {
                console.log(response);
                $('#loader').hide();
                $('.alert').show();
                $('#result').html(response);
                window.location.reload();
            },
            error: function (xhr, status, error) {
                console.error(error);
                window.location.reload();
            }
        });
    }

    document.querySelectorAll('.select-checkbox').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            handleCheckboxChange(checkbox);
        });
    });
</script>



</body>

</html>