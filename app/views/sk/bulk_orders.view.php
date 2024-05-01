<?php include "inc/header.view.php"; ?>
<!-- <a href="<?= ROOT ?>/sk/orders/completed"> completed orders</a> -->
<?php
// show($data);
?>


<style>
    .top-btn-selected {
        background-color: var(--blk);
        color: white;
    }

    .disable-row {
        pointer-events: none;
        background-color: #fde7e7;
    }
</style>


<div class="table-section" style=" padding-bottom:0; padding-top:0;">
    <div class="buttons-container">
        <a href="<?= ROOT ?>/sk/orders" style=" width: 33.2%; " class="btn-section__add-link top-btn-all" id="all-btn">Retail Orders</a>
        <a href="<?= ROOT ?>/sk/orders/bulk" style=" width: 33.2%; " class="btn-section__add-link top-btn-pending top-btn-selected" id="pen-btn">Bulk Orders</a>
        <a href="<?= ROOT ?>/sk/orders/completed" style=" width: 33.2%; " class="btn-section__add-link top-btn-processing" id="pro-btn">Completed Orders</a>
    </div>
    <?php if (message()) : ?>
        <div class="mzg-box">
            <div class="messege"><?= message('', true) ?></div>
        </div>
    <?php endif; ?>

    <h2 class="table-section__title" style=" margin-bottom:0">Bulk Orders</h2>
</div>

<style>
    .top-btn-selected {
        background-color: var(--blk);
        color: white;
    }

    .card-icon {
        font-size: 70px;
        /* color: #333; */
        font-variation-settings:
            'FILL' 0,
            'wght' 100,
            'GRAD' 0,
            'opsz' 24;
    }

    .card-selected {
        background-color: var(--blk);
        color: white;
    }
</style>

<div class="dashboard">

    <div id="pickup-card">
        <a style="text-decoration:none;">
            <div class="card" id="pickup-card">
                <h3 class="card-title">Pickup Orders</h3>
                <span class="material-symbols-outlined card-icon">
                    box
                </span>
                <p class="card-text"><?= $data['pickup_count'] ?></p>
            </div>
        </a>
    </div>


    <div id="delivery-card">
        <a style="text-decoration:none">
            <div class="card" id="delivery_card">
                <h3 class="card-title">Delivery Orders</h3>
                <span class="material-symbols-outlined card-icon">
                    local_shipping
                </span>
                <p class="card-text"><?= $data['delivery_count'] ?></p>
            </div>
        </a>
    </div>

</div>


<div class="table-section">
    <h2 class="table-section__title">Pickup Orders</h2>

    <div id="scrollable_sec">
        <table class="table-section__table" id="pickup-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Order Details</th>
                    <th>Total Cost</th>
                    <th>Status</th>
                    <th>Target Date</th>
                    <!-- <th>Stock Availability</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="table-section__tbody">
            </tbody>
        </table>
    </div>
</div>



<div class="table-section">
    <h2 class="table-section__title">Delivery Orders</h2>

    <div id="scrollable_sec">
        <table class="table-section__table" id="delivery-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Order Details</th>
                    <th>Total Cost</th>
                    <th>Delivery Address</th>
                    <th>Status</th>
                    <th>Target Date</th>
                    <!-- <th>Stock Availability</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="table-section__tbody">
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pickupTable = document.getElementById('pickup-table');
        const deliveryTable = document.getElementById('delivery-table');

        fetch('<?= ROOT ?>/fetch/bulk_orders_sk')
            .then(response => response.json())
            .then(data => {
                console.log(data);

                let pickupTable = document.getElementById('pickup-table');
                let deliveryTable = document.getElementById('delivery-table');

                var deliveries = data.deliveries;
                var pickups = data.pickups;

                while (pickupTable.rows.length > 1) {
                    pickupTable.deleteRow(1);
                }

                while (deliveryTable.rows.length > 1) {
                    deliveryTable.deleteRow(1);
                }

                pickups.sort((a, b) => {
                    return new Date(b.bulk_req.created_at) - new Date(a.bulk_req.created_at);
                });

                pickups.forEach(item => {
                    let row = pickupTable.insertRow();
                    let order_id = "BOD-" + String(item.bulk_order_details_id).padStart(3, '0');
                    let customer_name = item.customer_name;
                    let order_details = item.bulk_req.product_name + ' x ' + item.bulk_req.quantity;
                    let total_cost = item.total_cost;
                    let status = item.status.charAt(0).toUpperCase() + item.status.slice(1);
                    let target_date = item.bulk_req.estimated_date;
                    let stock_availability = item.stock_availability;

                    row.insertCell().innerHTML = order_id;
                    row.insertCell().innerHTML = customer_name;
                    row.insertCell().innerHTML = order_details;
                    row.insertCell().innerHTML = total_cost;
                    row.insertCell().innerHTML = status;
                    row.insertCell().innerHTML = target_date;
                    // row.insertCell().innerHTML = stock_availability;

                    let actionCell = row.insertCell();

                    if (item.bulk_req.quantity <= item.bulk_req.quantity_available && item.status == 'pending') {
                        let actionBtn = document.createElement('a');
                        actionBtn.textContent = 'Update Status';
                        actionBtn.classList.add('table-section__button');
                        // actionBtn.classList.add('submit-btn');
                        actionBtn.onclick = function() {
                            openPopup(item.bulk_order_details_id, item.status, 'pickup', item.bulk_req.product_name, item.bulk_req.quantity, item.bulk_req.product_inventory_id);
                        }
                        actionCell.appendChild(actionBtn);
                    
                    } else if ( item.status == 'processing' || item.status == 'ready to pick up') {
                        let actionBtn = document.createElement('a');
                        actionBtn.textContent = 'Update Status';
                        actionBtn.classList.add('table-section__button');
                        // actionBtn.classList.add('submit-btn');
                        actionBtn.onclick = function() {
                            openPopup(item.bulk_order_details_id, item.status, 'pickup', item.bulk_req.product_name, item.bulk_req.quantity, item.bulk_req.product_inventory_id);
                        }
                        actionCell.appendChild(actionBtn);
                    }
                    else {
                        let actionBtn = document.createElement('a');
                        actionBtn.textContent = 'Products Unavailable';
                        actionBtn.classList.add('table-section__button-unavailable');
                        // row.classList.add('disable-row');
                        actionCell.appendChild(actionBtn);
                    }
                });

                deliveries.sort((a, b) => {
                    return new Date(b.bulk_req.created_at) - new Date(a.bulk_req.created_at);
                });

                deliveries.forEach(item => {
                    let row = deliveryTable.insertRow();
                    let order_id = "ORD-" + String(item.bulk_order_details_id).padStart(3, '0');
                    let customer_name = item.customer_name;
                    let order_details = item.bulk_req.product_name + ' x ' + item.bulk_req.quantity;
                    let total_cost = item.total_cost;
                    let delivery_address = item.delivery_address.address_line_1 + ',<br> ' + item.delivery_address.address_line_2 + ',<br> ' + item.delivery_address.city + ', <br>' + item.delivery_address.zip_code;
                    let status = item.status.charAt(0).toUpperCase() + item.status.slice(1);
                    let target_date = item.bulk_req.estimated_date;
                    let stock_availability = item.stock_availability;

                    row.insertCell().innerHTML = order_id;
                    row.insertCell().innerHTML = customer_name;
                    row.insertCell().innerHTML = order_details;
                    row.insertCell().innerHTML = total_cost;
                    row.insertCell().innerHTML = delivery_address;
                    row.insertCell().innerHTML = status;
                    row.insertCell().innerHTML = target_date;
                    // row.insertCell().innerHTML = stock_availability;

                    let actionCell = row.insertCell();

                    if (item.bulk_req.quantity <= item.bulk_req.quantity_available && item.status == 'pending') {
                        let actionBtn = document.createElement('a');
                        actionBtn.textContent = 'Update Status';
                        actionBtn.classList.add('table-section__button');
                        // actionBtn.classList.add('submit-btn');
                        actionBtn.onclick = function() {
                            openPopup(item.bulk_order_details_id, item.status, 'delivery', item.bulk_req.product_name, item.bulk_req.quantity, item.bulk_req.product_inventory_id);
                        }
                        actionCell.appendChild(actionBtn);
                    
                    } else if ( item.status == 'processing'|| item.status == 'delivering') {
                        let actionBtn = document.createElement('a');
                        actionBtn.textContent = 'Update Status';
                        actionBtn.classList.add('table-section__button');
                        // actionBtn.classList.add('submit-btn');
                        actionBtn.onclick = function() {
                            openPopup(item.bulk_order_details_id, item.status, 'delivery', item.bulk_req.product_name, item.bulk_req.quantity, item.bulk_req.product_inventory_id);
                        }
                        actionCell.appendChild(actionBtn);
                    }
                     else {
                        let actionBtn = document.createElement('a');
                        actionBtn.textContent = 'Products Unavailable';
                        actionBtn.classList.add('table-section__button-unavailable');
                        // row.classList.add('disable-row');
                        actionCell.appendChild(actionBtn);
                    }


                });

                var pickup_count = data.pickup_count;
                var delivery_count = data.delivery_count;

                if (pickup_count == 0 || pickup_count == null) {
                    document.getElementById('pickup-card').style.display = 'none';

                } else {
                    document.getElementById('pickup-card').querySelector('.card-text').textContent = pickup_count;
                }
                if (delivery_count == 0 || delivery_count == null) {
                    document.getElementById('delivery-card').style.display = 'none';
                } else {
                    document.getElementById('delivery_card').querySelector('.card-text').textContent = delivery_count;
                }

            });
    });
</script>


<div class="popup-form" id="update-popup">
    <div class="popup-form__content">
        <form action="" method="POST" class="form">
            <!-- <h2 class="popup-form-title">Delete Item</h2> -->
            <!-- <p>Are you sure you want to delete this item?</p> -->
            <p class="confirmation-text"> </p>

            <input type="hidden" name="status" value="" id="hidden-inp">
            <input type="hidden" name="product_inventory_id" value="" id="hidden-inp2">
            <input type="hidden" name="quantity_required" value="" id="hidden-inp3">


            <div class="form-group frm-btns">
                <button type="submit" class="form-btn submit-btn">Yes</button>
                <button type="button" class="form-btn cancel-btn" onclick="closePopup()">No</button>
            </div>
        </form>
    </div>
</div>

<script>
    openPopup = (id, status, type, name, qty, product_inventory_id) => {
        const popup = document.getElementById('update-popup');
        const confirmationText = document.querySelector('.confirmation-text');
        x = "ORD-" + String(id).padStart(3, '0');

        if (status == 'pending') {
            confirmationText.innerHTML += "Are you sure you want to allocate " + name + " x " + qty + " to order " + x + " ?";
            document.getElementById('hidden-inp').value = 'processing';
            document.getElementById('hidden-inp2').value = product_inventory_id;
            document.getElementById('hidden-inp3').value = qty;
        } else if (type == "pickup") {
            if (status == "processing") {
                status = "ready to pick up";
            } else if (status == "ready to pick up") {
                status = "completed";
            }
            confirmationText.innerHTML += "Are you sure you want to update the status of order " + x + " to " + status + " ?";
            document.getElementById('hidden-inp').value = status;
            document.getElementById('hidden-inp2').value = '';
            document.getElementById('hidden-inp3').value = '';
        } else if (type == "delivery") {
            if (status == "processing") {
                status = "delivering";
            } else if (status == "delivering") {
                status = "completed";
            }
            confirmationText.innerHTML += "Are you sure you want to update the status of order " + x + " to " + status + " ?";
            document.getElementById('hidden-inp').value = status;
            document.getElementById('hidden-inp2').value = '';
            document.getElementById('hidden-inp3').value = '';
        }

        popup.classList.add('popup-form--open');
        popup.querySelector('form').action = "<?php echo ROOT ?>/sk/update_bulk_order_status/" + id;
    }

    closePopup = () => {
        const popup = document.getElementById('update-popup');
        popup.classList.remove('popup-form--open');
        const confirmationText = document.querySelector('.confirmation-text');
        confirmationText.innerHTML = "";
    }
</script>











<?php include "inc/footer.view.php"; ?>