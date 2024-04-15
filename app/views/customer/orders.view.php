<style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .order {
            border: 1px solid #ddd;
            margin: 10px 0;
            padding: 10px;
        }
    </style>

<?php $this->view('customer/acc-header', $data) ?>
    <br><br>
    <?php $this->view('customer/acc-sidebar', $data) ?>
        
        <div class="main-container"> 

        <!-- points -->
        <div class="container">
            <div class="title">
                <h2>My Orders</h2>
            </div>

            <div class="content-order">
                <div class="content-show">
                    <label for="row-count">Show:</label>
                    <select id="row-count">
                        <option value="5">2 rows</option>
                        <option value="10">10 rows</option>
                        <option value="15">15 rows</option>
                    </select>
                </div>

                <div class="content-orders">
                    <?php if (!empty($orders)) : ?>
                        <table>
                            <tr>
                                <th>Order ID</th>
                                <th>Order Type</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Creation Date</th>
                                <th></th>
                            </tr>
                            <?php foreach ($orders as $order) : ?>
                                <tr>
                                    <td><?= $order['order_details_id'] ?></td>
                                    <td><?= $order['order_type'] ?></td>
                                    <td><?= $order['quantity'] ?></td>
                                    <td><?= $order['status'] ?></td>
                                    <td><?= $order['created_at'] ?></td>
                                    <td><a href="<?= ROOT ?>/customer/manageOrder/<?= $order['order_details_id'] ?>">Manage</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php else : ?>
                        <p>No orders found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

</body>

<?php $this->view('includes/footer', $data) ?>
</html>
</div></diV>
