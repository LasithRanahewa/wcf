<?php include "inc/header.view.php"; ?>

<style>
    .top-btn-selected {
        background-color: var(--blk);
        color: white;
    }
</style>


<div class="table-section" style=" padding-bottom:0; padding-top:0;">
    <div class="buttons-container">
        <a href="<?=ROOT?>/sk/orders" style=" width: 33.2%; " class="btn-section__add-link top-btn-all " id="all-btn">Retail Orders</a>
        <a href="<?=ROOT?>/sk/orders/bulk" style=" width: 33.2%; " class="btn-section__add-link top-btn-pending" id="pen-btn">Bulk Orders</a>
        <a href="<?=ROOT?>/sk/orders/completed" style=" width: 33.2%; " class="btn-section__add-link top-btn-processing top-btn-selected" id="pro-btn">Completed Orders</a>
    </div>
    <h2 class="table-section__title" style=" margin-bottom:0">Completed orders</h2>
</div>

<?php include "inc/footer.view.php"; ?>