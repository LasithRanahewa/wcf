<?php include "inc/header.view.php"; ?>
<?php
$url = ROOT . "/fetch/pxn_bulk_orders";
$response = file_get_contents($url);
$pxn_blks = json_decode($response, true);
// show($pxn_blks);

usort($pxn_blks, function ($a, $b) {
    return $a['bulk_req']['estimated_date'] <=> $b['bulk_req']['estimated_date'];
});
?>

<div class="table-section">
    <?php if (message()) : ?>
        <div class="mzg-box">
            <div class="messege"><?= message('', true) ?></div>
        </div>
    <?php endif; ?>

    <h2 class="table-section__title">Production needed approved bulk orders</h2>

    <div id="scrollable_sec">
        <table class="table-section__table" id="pxn-blk-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Materials Needed</th>
                    <!-- <th>Created At</th> -->
                    <th>Target Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="table-section__tbody">
                <?php foreach ($pxn_blks as $pxn_blk) : ?>
                    <?php if ($pxn_blk['bulk_req']['quantity_available'] < $pxn_blk['bulk_req']['quantity']) : ?>
                        <tr>
                            <td><?= $pxn_blk['bulk_order_details_id'] ?></td>
                            <td><?= 'PRD-' . str_pad($pxn_blk['bulk_req']['product_id'], 3, '0', STR_PAD_LEFT) ?></td>
                            <td><?= $pxn_blk['bulk_req']['product_name'] ?></td>
                            <td><?= $pxn_blk['bulk_req']['quantity_available'] . ' / ' . $pxn_blk['bulk_req']['quantity'] ?></td>
                            <td>
                                <?php
                                foreach ($pxn_blk['product_materials'] as $mat) {
                                    echo $mat['material_name'] . ' x ' . $mat['quantity_needed'] * $pxn_blk['bulk_req']['quantity']  . "<br>";
                                }
                                ?>
                            </td>
                            <!-- <td><?= $pxn_blk['created_at'] ?></td> -->
                            <td><?= $pxn_blk['bulk_req']['estimated_date'] ?></td>
                            <td>
                                <?php
                                if ($pxn_blk['missing_materials_count'] == 0) {

                                    $quantity_difference = $pxn_blk['bulk_req']['quantity'] - $pxn_blk['bulk_req']['quantity_available'];
                                    echo "<a class='table-section__button' onclick='navfunc(\"{$pxn_blk['bulk_req']['product_id']}\",\"{$quantity_difference}\")'>Start Production</a>";
                                } else {
                                    echo "<a class='table-section__button table-section__button-del' onclick='openPopup(\"{$pxn_blk['bulk_order_details_id']}\")'>Missing Materials</a>";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<div class="popup-form" id="missing-mat">
    <div class="popup-form__content">
        <form action="" method="POST" class="form">
            <!-- <h2 class="popup-form-title">Delete Item</h2> -->
            <!-- <p>Are you sure you want to delete this item?</p> -->
            <p class="confirmation-text">The following materials are required for production:</p>

            <div class="table-section" style="width: 100%; padding:20px 0; background-color:#fff;">
                <table class="table-section__table" id="missing-materials">
                    <thead>
                        <tr>
                            <th>Material ID</th>
                            <th>Material Name</th>
                            <th>Quantity Needed</th>
                        </tr>
                    </thead>
                    <tbody id="tt">
                    </tbody>
                </table>
            </div>
            <div class="form-group frm-btns">
                <!-- <button type="submit" class="form-btn submit-btn">Yes</button> -->
                <button type="button" class="form-btn cancel-btn" onclick="closePopup()">Close</button>
            </div>
        </form>
    </div>
</div>

<script>
    openPopup = (id) => {
        const popup = document.getElementById('missing-mat');
        const confirmationText = document.querySelector('.confirmation-text');

        const url = "<?php echo ROOT ?>/fetch/pxn_missing/" + id;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                confirmationText.innerHTML = "The following materials are required for production:";

                const tableBody = document.getElementById('tt');
                data.forEach(material => {
                    console.log(material.material_name);
                    let tableRow = `<tr style="background-color:var(--light)">
                                        <td>${material.material_id}</td>
                                        <td>${material.material_name}</td>
                                        <td>${material.missing_qty}</td>
                                    </tr>`;
                    console.log(tableRow);

                    tableBody.innerHTML += tableRow;
                });
            });


        popup.classList.add('popup-form--open');

    }
</script>

<script>
    // Function to open popup form
    // function openPopup(popupId) {
    //     const popup = document.getElementById(popupId);
    //     popup.classList.add('popup-form--open');
    // }

    // Function to close popup form
    function closePopup() {
        const popups = document.querySelectorAll('.popup-form');
        // confirmText = document.querySelector('.confirmation-text');
        // confirmText.innerHTML = "Are you sure you want to delete ";
        popups.forEach(popup => {
            popup.classList.remove('popup-form--open');
        });

        const tableBody = document.getElementById('tt');

        tableBody.innerHTML = '';


        // Clear validation messages
        const validationMessages = document.querySelectorAll('.validate-mzg');
        validationMessages.forEach(message => {
            message.innerHTML = '';
        });



    }
</script>


<script>
    navfunc = (product_id, qty) => {
        sessionStorage.setItem('product_id', product_id);
        sessionStorage.setItem('quantity', qty);
        let nav = document.getElementById('add_prod-nav');
        nav.click();
    }
</script>


<?php include "inc/footer.view.php"; ?>