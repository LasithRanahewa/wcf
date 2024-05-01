<?php include "inc/header.view.php"; ?>
<?php

$pxn_url = ROOT . "/fetch/production";
$pxn_response = file_get_contents($pxn_url);
$pxn = json_decode($pxn_response, true);
// show($pxn);

$nopxn = 0;
// $nopxn = count($pxn);
if ($pxn) {
    $nopxn = count($pxn);
}
// show($nopxn); 

$nopxn_cmp = 0;
$nopxn_prc = 0;
$nopxn_pnd = 0;

foreach ($pxn as $pxn) {
    if ($pxn['status'] == "completed") {
        $nopxn_cmp++;
    } elseif ($pxn['status'] == "processing") {
        $nopxn_prc++;
    } elseif ($pxn['status'] == "pending") {
        $nopxn_pnd++;
    }
}

$workers_url = ROOT . "/fetch/workers";
$workers_response = file_get_contents($workers_url);
$workers = json_decode($workers_response, true);

// show($workers);

$no_car = 0;
$nu_pain  = 0;
$no_sup = 0;
$avail_car = 0;
$avail_pain = 0;
$avail_sup = 0;

for ($i = 0; $i < count($workers); $i++) {
    if ($workers[$i]['worker_role'] == "carpenter") {
        $no_car++;
        if ($workers[$i]['availability'] == "available") {
            $avail_car++;
        }
    } elseif ($workers[$i]['worker_role'] == "painter") {
        $nu_pain++;
        if ($workers[$i]['availability'] == "available") {
            $avail_pain++;
        }
    } elseif ($workers[$i]['worker_role'] == "supervisor") {
        $no_sup++;
        if ($workers[$i]['availability'] == "available") {
            $avail_sup++;
        }
    }
}

// show($no_car);
// show($nu_pain);
// show($no_sup);
// show($avail_car);
// show($avail_pain);
// show($avail_sup);


$products_url = ROOT . "/fetch/product";
$products_response = file_get_contents($products_url);
$products = json_decode($products_response, true);
// show($products['products']);

// $product_ids = [];
foreach ($products['products'] as $product) {
    $product_ids[] = $product['product_id'];
}
$product_ids = array_unique($product_ids);
// show($product_ids);

$product_materials_url = ROOT . "/fetch/product_materials";
$product_materials_response = file_get_contents($product_materials_url);
$product_materials = json_decode($product_materials_response, true);
// show($product_materials);

// get product_ids from product_materials
$pm_product_ids = [];
foreach ($product_materials as $product_material) {
    $pm_product_ids[] = $product_material['product_id'];
}
$pm_product_ids = array_unique($pm_product_ids);
// show($pm_product_ids);

// get products without materials
$products_without_materials = [];
foreach ($product_ids as $product_id) {
    if (!in_array($product_id, $pm_product_ids)) {
        $products_without_materials[] = $product_id;
    }
}
// show($products_without_materials);
$products_without_materials_count = count($products_without_materials);
$products_without_materials_details = [];
foreach ($products_without_materials as $product_without_materials) {
    foreach ($products['products'] as $product) {
        if ($product_without_materials == $product['product_id']) {
            $products_without_materials_details[] = $product;
        }
    }
}
// show($products_without_materials_details);

$url3  = ROOT . "/fetch/approved_bulk_req_count";
$bulk_count = file_get_contents($url3);
// show($bulk_count);

?>

<style>
    .card-icon {
        font-size: 70px;
        /* color: #333; */
        font-variation-settings:
            'FILL' 0,
            'wght' 100,
            'GRAD' 0,
            'opsz' 24;
    }
</style>

<div class="table-section" style=" padding-bottom:0">
    <h2 class="table-section__title" style=" margin-bottom:0">Dashboard</h2>
</div>

<div class="dashboard">
    <a href="<?= ROOT . '/pm/productions' ?>" style="text-decoration:none" onclick="navfunc('prod-nav','pending')">
        <div class="card">
            <h3 class="card-title">No of Pending Productions</h3>
            <span class="material-icons-outlined card-icon">pending_actions</span>
            <p class="card-text"><?= $nopxn_pnd ?></p>
        </div>
    </a>
    <a href="<?= ROOT . '/pm/productions' ?>" style="text-decoration:none" onclick="navfunc('prod-nav','processing')">
        <div class="card">
            <h3 class="card-title">No of Ongoing Productions</h3>
            <span class="material-icons-outlined card-icon">hourglass_top</span>
            <p class="card-text"><?= $nopxn_prc ?></p>
        </div>
    </a>
    <!-- <a href="<?= ROOT . '/pm/approved_bulk_orders' ?>" style="text-decoration:none" onclick="navfunc('app_bulk-nav')">
        <div class="card">
            <h3 class="card-title">Approved bulk orders</h3>
            <span class="material-icons-outlined card-icon">task_alt</span>
            <p class="card-text"><?=$bulk_count?></p>
        </div>
    </a> -->



    <!-- Repeat for other cards -->
</div>


<div class="dashboard2" id="pwc-table">
    <div>
        <div class="charts-card">
            <p class="chart-title">Available Workers</p>
            <div id="chart"></div>
        </div>
    </div>


    <?php if ($products_without_materials_count > 0) : ?>
        <div class="table-section" style="width: 100%;margin:0; padding:0% ">
            <div class="mzg-box col-danger">
                <div class="messege"><?= (($products_without_materials_count == 1) ? 'There is a product in the system for which the materials have not yet been configured' : $products_without_materials_count . ' products exist in the system for which materials have not yet been configured')  ?>!</div>
            </div>
            <table class="table-section__table" style="margin:0; padding:0%" id="pwi">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="table-section__tbody">
                    <?php foreach ($products_without_materials_details as $product) : ?>
                        <tr>
                            <td><?= sprintf("PRD-%03d", $product['product_id']) ?></td>
                            <td><?= $product['name'] ?></td>
                            <td>
                                <a href="<?= ROOT ?>/pm/product_materials/<?= $product['product_id'] ?>" class="table-section__button">Click</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.45.2/apexcharts.min.js"></script>
<script>
    navfunc = (id, x) => {
        sessionStorage.setItem('x', x);
        let nav = document.getElementById(id);
        nav.click();
    }

    available_carpenters = <?= $avail_car ?>;
    available_painters = <?= $avail_pain ?>;
    available_supervisors = <?= $avail_sup ?>;

    const barChartOptions = {
        series: [{
                data: [available_carpenters, available_painters, available_supervisors],
            },

        ],
        chart: {
            type: 'bar',
            height: 300,
            toolbar: {
                show: false,
            },
        },
        colors: ['var(--blk)', 'var(--blk)', 'var(--blk)'],
        plotOptions: {
            bar: {
                distributed: true,
                borderRadius: 4,
                horizontal: true,
                //   columnWidth: '40%',
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        labels: ['Carpenters', 'Painters', 'Supervisors'],
        xaxis: {
            categories: ['Carpenters', 'Painters', 'Supervisors'],
        },
        yaxis: {
            title: {
                //   text: 'Worker Role',
            },
        },
    };

    const barChart = new ApexCharts(
        document.querySelector('#chart'),
        barChartOptions
    );
    barChart.render();
</script>

<?php include "inc/footer.view.php"; ?>