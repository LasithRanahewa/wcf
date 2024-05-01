<style>
    .content-order,
    .content-orders {
        padding: 20px;
        margin-top: 20px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }

    .order {
        border: 1px solid var(--bg2);
        border-radius: 10px;
        margin-bottom: 40px;
        padding: 20px;
        width: 100%;
        position: relative;
        background-color: var(--white);
        transition: box-shadow 0.3s;
    }

    .order:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .status {
        background-color: var(--light);
        color: black;
        padding: 5px 10px;
        border-radius: 10px;
        font-size: 14px;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        border-bottom: 1px solid var(--bg2);
    }

    .order-header a {
        color: var(--green2);
    }

    .order-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .order-info p {
        margin: 0;
    }

    .order-info small, .order-details small {
        font-size: 14px;
    }

    .order-details {
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-details p {
        margin: 0;
    }

    .product-details {
        width: 120px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        overflow: hidden;
    }

    .product-details img {
        width: 100%;
        height: auto;
        margin-bottom: 5px;
    }

    .message {
        color: var(--blk);
        font-size: 1rem;
        margin: 0;
        padding: 1rem;
        /* padding-bottom: 2rem; */
        /* center */
        text-align: center;
    }

    .mzg-box {
        background-color: var(--primary);
        border-radius: 5px;
        margin-bottom: 1rem;
        padding: 0.5rem 1rem;

    }
</style>

<?php $this->view('customers/acc-header', $data) ?>

    <div class="main-container">

        <!-- side bar -->
        <?php
        // Define the isCurrentPage function
        function isCurrentPage($pageName)
        {
            // Get the path part of the URL
            $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            // Check if the current path starts with the given page name
            return strncmp($currentPath, $pageName, strlen($pageName)) === 0;
        }
        ?>

        <div class="side-bar-customer">
            <ul class="customer-sidebar-list">
                <li class="customer-sidebar-list-item main-title <?= isCurrentPage('profile') ? 'selected' : '' ?>" id="profile-nav">
                    <a href="<?= ROOT ?>/profile"><span style="margin-left: 5px;">My Profile</span></a>
                </li>
                <!-- <li class="customer-sidebar-list-item sub-title <?= isCurrentPage('editProfile') ? 'selected' : '' ?>" id="editp-nav">
                                <a href="<?= ROOT ?>/profile/editProfile">Edit Profile<span style="margin-left: 35px;"></span></a>
                            </li>
                            <li class="customer-sidebar-list-item sub-title <?= isCurrentPage('editAddress') ? 'selected' : '' ?>" id="edita-nav">
                                <a href="<?= ROOT ?>/profile/editAddress">Edit Address<span style="margin-left: 35px;"></span></a>
                            </li>
                            <li class="customer-sidebar-list-item sub-title <?= isCurrentPage('password') ? 'selected' : '' ?>" id="password-nav">
                                <a href="<?= ROOT ?>/profile/password">Change Password<span style="margin-left: 35px;"></span></a>
                            </li> -->
                <li class="customer-sidebar-list-item main-title selected <?= isCurrentPage('orders') ? 'selected' : '' ?>" id="orders-nav">
                    <a href="<?= ROOT ?>/orders"><span style="margin-left: 5px;">My Orders</span></a>
                </li>
                <li class="customer-sidebar-list-item main-title <?= isCurrentPage('bulk') ? 'selected' : '' ?>" id="bulk-nav">
                    <a href="<?= ROOT ?>/orders/bulk"><span style="margin-left: 5px;">My Bulk Orders</span></a>
                </li>
                <li class="customer-sidebar-list-item main-title <?= isCurrentPage('review') ? 'selected' : '' ?>" id="review-nav">
                    <a href="<?= ROOT ?>/review"><span style="margin-left: 5px;">My Reviews</span></a>
                </li>
            </ul>
        </div>

        <!-- points -->
        <div class="container">
            <?php if (message()) : ?>
                <div class="mzg-box">
                    <div class="messege"><?= message('', true) ?></div>
                </div>
            <?php endif; ?>

            <div class="title">
                <h2>My Orders</h2>
            </div>

            <div class="content-order">
                <!-- <div class="content-show">
                    <label for="row-count">Show:</label>
                    <select id="display-options">
                        <option value="last-5">Last 5 orders</option>
                        <option value="last-30-days">Last 30 days</option>
                        <option value="all-orders">All orders</option>
                        <option value="retail-orders">Retail orders</option>
                        <option value="bulk-orders">Bulk orders</option>
                    </select>
                </div> -->

                <div class="content-orders">
                    <?php if (!empty($orders)) : ?>
                        <?php foreach ($groupedOrders as $orderDetailsId => $orderItems) { ?>
                            <div class="order">
                                <div class="order-header">
                                    <div class="order-info">
                                        <p>order <strong style="color: var(--green2);"><?= $orderDetailsId ?></strong></p>
                                        <p><small>Placed on <?= $orderItems[0]['created_at'] ?></small></p>
                                    </div>
                                    <a href="<?= ROOT ?>/orders/<?= $orderDetailsId ?>">View</a>
                                </div>
                                <?php foreach ($orderItems as $key => $orderItem) : ?>
                                    <!-- Display status and updated on details only for the first item -->
                                    <?php if ($key === 0) : ?>
                                        <div class="order-details">
                                            <img src="<?= ROOT."/".$orderItem['image_url'] ?>" alt="Product Image" width="100" height="100">
                                            <p><?= $orderItem['product_name'] ?></p>
                                            <p>Qty: <?= $orderItem['quantity'] ?></p>
                                            <div class="status"><?= $orderItem['status'] ?></div>
                                            <p><small>Updated on <?= $orderItem['created_at'] ?></small></p>
                                        </div>
                                    <?php else : ?>
                                        <!-- For subsequent items, only display product details -->
                                        <div class="order-details">
                                            <img src="<?= ROOT."/".$orderItem['image_url'] ?>" alt="Product Image" width="100" height="100">
                                            <p><?= $orderItem['product_name'] ?></p>
                                            <p>Qty: <?= $orderItem['quantity'] ?></p>
                                            <div><pre>                                     </pre></div>
                                            <div><pre>                                     </pre></div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php } ?>
                    <?php else : ?>
                        <div class="no-detail">
                            <p>No orders found.</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- <script>
    // Get the select element
    var selectDisplayOptions = document.getElementById("display-options");

    // Add event listener to handle selection change
    selectDisplayOptions.addEventListener("change", function() {
        // Get the selected value
        var selectedValue = this.value;

        // Get all rows in the table body
        var tableRows = document.querySelectorAll(".content-orders table tr");

        // Loop through each row
        for (var i = 1; i < tableRows.length; i++) {
            // Show or hide rows based on the selected value
            switch (selectedValue) {
                case "last-5":
                    // Loop through each row starting from the last row
                    for (var i = tableRows.length - 1; i >= 0; i--) {
                        // Calculate the index of the row relative to the end of the table
                        var reverseIndex = tableRows.length - 1 - i;

                        // Show or hide rows based on their position relative to the end of the table
                        if (reverseIndex < 5) {
                            tableRows[i].style.display = "table-row";
                        } else {
                            tableRows[i].style.display = "none";
                        }
                    }
                    break;
                case "all-orders":
                    // Show all rows
                    tableRows[i].style.display = "table-row";
                    break;
                default:
                    break;
            }
        }
    });
</script> -->



<?php $this->view('includes/footer', $data) ?>