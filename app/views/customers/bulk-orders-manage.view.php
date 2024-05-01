<style>
    .content-manage-order {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        margin-top: 30px;
        background-color: var(--white);
        padding: 20px;
        border-radius: 10px;
    }
    
    .content-manage-order-left {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .content-manage-detail {
        margin-bottom: 20px;
        background-color: var(--white);
        padding: 20px;
        border-radius: 10px;
    }

    .content-manage-detail-mid {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 20px;
        background-color: var(--light);
        padding: 20px;
        border-radius: 10px;
    }

    .content-manage-detail-mid p {
        font-size: 13px;
        font-style: italic;
        color: var(--green2);
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        padding-right: 200px;
    }

    .order-item-image {
        width: 120px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        overflow: hidden;
    }

    .order-item-image img {
        width: 100%;
        height: auto;
        margin-bottom: 5px;
    }

    .content-manage-payment {
        display: flex;
        justify-content: space-between;
    }

    .content-manage-payment-left {
        flex: 1;
        background-color: var(--white);
        margin-right: 20px;
        padding: 20px;
        align-items: left;
        border-radius: 10px;
    }

    .content-manage-payment-right {
        flex: 1;
        background-color: var(--white);
        padding: 20px;
        border-radius: 10px;
    }

    .content-manage-payment-right large {
        font-size: 25px;
        color: var(--green2);
        font-weight: bold;
    }

    .content-manage-order-left p small,
    .content-manage-detail p small,
    .content-manage-order p:last-child {
        color: var(--bg1);
        font-size: 12px;
    }

    .right-lower h2 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        margin: 5px 0; 
        font-size: 1em;
        font-weight: lighter;
    }

    .right-lower h2 span {
        margin-left: 20px;
        display: flex;
        align-items: center;
    }

    .bottom-page {
        display: flex;
        flex-direction: column;
        align-items:flex-start; 
        margin-bottom: 10px;
    }

    .back-orders {
        background-color: var(--bg2);
        border: none;
        border-radius: 20px;
        padding: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 20px;
    }

    .back-orders:hover {
        background-color: var(--green1);
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
            function isCurrentPage($pageName) {
                // Get the path part of the URL
                $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                // Check if the current path starts with the given page name
                return strncmp($currentPath, $pageName, strlen($pageName)) === 0;
            }
            ?>
            
            <div class="side-bar-customer">
                    <ul class="customer-sidebar-list">
                        <li class="customer-sidebar-list-item main-title <?= isCurrentPage('profile') ? 'selected' : '' ?>" id="profile-nav">
                            <a href="<?=ROOT?>/profile"><span style="margin-left: 5px;">My Profile</span></a>
                        </li>
                            <!-- <li class="customer-sidebar-list-item sub-title <?= isCurrentPage('editProfile') ? 'selected' : '' ?>" id="editp-nav">
                                <a href="<?=ROOT?>/profile/editProfile">Edit Profile<span style="margin-left: 35px;"></span></a>
                            </li>
                            <li class="customer-sidebar-list-item sub-title <?= isCurrentPage('editAddress') ? 'selected' : '' ?>" id="edita-nav">
                                <a href="<?=ROOT?>/profile/editAddress">Edit Address<span style="margin-left: 35px;"></span></a>
                            </li>
                            <li class="customer-sidebar-list-item sub-title <?= isCurrentPage('password') ? 'selected' : '' ?>" id="password-nav">
                                <a href="<?=ROOT?>/profile/password">Change Password<span style="margin-left: 35px;"></span></a>
                            </li> -->
                        <li class="customer-sidebar-list-item main-title <?= isCurrentPage('orders') ? 'selected' : '' ?>" id="orders-nav">
                            <a href="<?=ROOT?>/orders"><span style="margin-left: 5px;">My Orders</span></a>
                        </li>
                        <li class="customer-sidebar-list-item main-title selected <?= isCurrentPage('bulk') ? 'selected' : '' ?>" id="bulk-nav">
                            <a href="<?=ROOT?>/orders/bulk"><span style="margin-left: 5px;">My Bulk Orders</span></a>
                        </li>
                        <li class="customer-sidebar-list-item main-title <?= isCurrentPage('review') ? 'selected' : '' ?>" id="review-nav">
                            <a href="<?=ROOT?>/review"><span style="margin-left: 5px;">My Reviews</span></a>
                        </li>
                    </ul>
            </div>

    <!-- orders -->
    <div class="container">
        <?php if (message()) : ?>
                <div class="mzg-box">
                    <div class="messege"><?= message('', true) ?></div>
                </div>
            <?php endif; ?>

        <div class="title">
            <h2>Bulk Order Details</h2>
        </div>

        <div class="content-manage-orders">
            <div class="bottom-page">
                <a href="<?=ROOT?>/orders/bulk" class="back-orders"><i class="material-icons">arrow_back</i></a>
            </div>

        <?php if (!empty($data['bulk_order_details'])) : ?>
            <?php foreach ($data['bulk_order_details'] as $details) : ?>
                <div class="content-manage-order">
                    <div class="content-manage-order-left">
                        <p>Order <strong style="color: var(--green2);"><?= $details['bulk_order_details_id']; ?></strong></p>
                        <p><small>Placed on <?= $details['created_at']; ?></small></p>
                    </div>
                    <p>Total: Rs.<?= $details['total']; ?></p>
                </div>

                <div class="content-manage-detail">
                    <p><small>Updated on <?= $details['updated_at']; ?></small></p>
                    <div class="content-manage-detail-mid">
                        <p>Your package has been <?= $details['status']?>.</p>
                        <p>Thank you for shopping with WOODCRAFT.</p>
                    </div>

                        <div class="order-item">
                            <!-- <div class="order-item-image"> -->
                                <img src="<?= ROOT."/".$details['image_url']; ?>" alt="Product Image" width="100" height="100">
                                <p><?= $details['product_name']; ?></p>
                            <!-- </div> -->
                            <p>Rs. <?= $details['price']; ?></p>
                            <p>Qty: <?= $details['quantity']; ?></p>
                            <p>Subtotal: Rs. <?= $details['total_cost']; ?></p>
                        </div>
                 </div>

                <div class="content-manage-payment">
                    <div class="content-manage-payment-left">
                        <h4>Shipping Address</h4><br>
                        <p><?= $details['first_name']; ?> <?= $details['last_name']; ?></p> 
                        <p><?= $details['city']; ?></p>
                        <p><?= $details['address_line_1']; ?>, <?= $details['address_line_2']; ?></p>
                        <p><?= $details['telephone']; ?></p> 
                    </div>

                    <div class="content-manage-payment-right">
                        <h3>Total Summary</h3><br>
                        <div class="right-lower">
                            <h2 id="subtotal">Subtotal<span>Rs. <?= $details['total_cost']; ?></span></h2>
                            <h2 id="delivery">Delivery<span>Rs. <?= $details['delivery_cost']; ?></span></h2>
                            <hr>
                            <h2 id="total">Total<large><span>Rs. <?= $details['total']; ?></span></large></h2>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="no-detail">
                <p>No bulk order details found.</p>
            </div>
        <?php endif; ?>
        </div>

    </div>
</div>
</main>

</body>

<?php $this->view('includes/footer', $data) ?>
</html>
