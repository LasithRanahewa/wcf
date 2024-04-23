<?php $this->view('customers/acc-header', $data) ?>
<br><br>
<?php $this->view('customers/acc-sidebar', $data) ?>

<div class="main-container"> 

    <!-- orders -->
    <div class="container">
        <div class="title">
            <h2>Order Details</h2>
        </div>

        <div class="content-manage-orders">
            <?php foreach ($data['order_details'] as $details) : ?>
                <div class="content-manage-order">
                    <div class="content-manage-order-left">
                        <p>Order <?= $details['order_details_id']; ?></p>
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

                        <?php foreach ($data['order_items'] as $item) : ?>
                            <div class="order-item">
                                <div class="order-item-image">
                                    <img src="<?= $item['product_image_url']; ?>" alt="Product Image" width="100" height="100">
                                    <p><?= $item['product_name']; ?></p>
                                </div>
                                <p>Rs. <?= $item['price']; ?></p>
                                <p>Qty: <?= $item['quantity']; ?></p>
                            </div>
                        <?php endforeach; ?>
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
                            <div class="right-left">
                                <p>Subtotal</p>
                                <p>Delivery Fee</p>
                            </div>
                            <div class="right-right">
                                <p>Rs.<?= $data['total_subtotal']; ?></p>
                                <p>Rs.<?= $details['delivery_cost']; ?></p>
                            </div>
                        </div>
                        <div class="right-lower-lower">
                            <div class="right-left">
                                <p>Total</p>
                            </div>
                            <div class="right-right">
                                <p><large>Rs.<?= $details['total']; ?></large></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</main>

</body>

<?php $this->view('includes/footer', $data) ?>
</html>

<style>
    .content-manage-order-left {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .content-manage-order {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        background-color: whitesmoke;
        padding: 10px;
    }

    .content-manage-detail {
        margin-bottom: 20px;
        background-color: whitesmoke;
        padding: 10px;
    }

    .content-manage-detail-mid {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 20px;
        background-color: white;
        padding: 10px;
    }

    .content-manage-detail-mid p {
        font-size: 16px;
        font-style: italic;
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
        background-color: whitesmoke;
        margin-right: 20px;
        padding: 10px;
        align-items: left;
    }

    .content-manage-payment-right {
        flex: 1;
        background-color: whitesmoke;
        padding: 10px;
    }

    .content-manage-payment-right large {
        font-size: 25px;
    }

    .right-lower {
        display: flex;
        justify-content: space-between;
        position: relative;
        padding-bottom: 10px;
    }

    .right-lower::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        border-bottom: 1px solid black;
    }

    .right-lower-lower {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }

    .right-left {
        align-items: left;
    }

    .right-right {
        align-items: right;
    }

    .content-manage-order-left p small,
    .content-manage-detail p small,
    .content-manage-order p:last-child {
        color: gray;
    }
</style>