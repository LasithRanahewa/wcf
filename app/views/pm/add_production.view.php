<?php include "inc/header.view.php"; ?>


<?php
if (isset($_SESSION['errors']) && isset($_SESSION['form_data'])) {
    $errors = $_SESSION['errors'];
    $form_data = $_SESSION['form_data'];

    // unset the session variables so they don't persist on page refresh
    unset($_SESSION['errors']);
    unset($_SESSION['form_data']);

    // display the errors and repopulate the form with the data
    // show($form_data);
}

// show($form_data);
// show($errors);
// show($form_id);
?>

<!-- fetch workers and get count of available workers -->
<?php
$url = ROOT . "/fetch/workers";
$response = file_get_contents($url);
$workers = json_decode($response, true);
// show($workers);

$available_workers = [];
foreach ($workers as $worker) {
    if ($worker['availability'] == 'available') {
        $available_workers[] = $worker;
    }
}
// show($available_workers);

//sort workers by updated_at and make a queue
usort($available_workers, function ($a, $b) {
    return $a['updated_at'] <=> $b['updated_at'];
});
// show($available_workers);

$available_workers_count = count($available_workers);
// show($available_workers_count);

?>

<style>
    .form-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
        /* Add some space between form sections */
    }

    .addp {
        margin-top: 0;
        margin-bottom: 0;
        padding: 0.5rem;
        width: 100%;
        background-color: var(--primary);
    }

    .addp-danger {
        margin-top: 0;
        margin-bottom: 0;
        padding: 0.5rem;
        width: 100%;
        background-color: var(--secondary);
    }
</style>

<?php if (message()) : ?>
    <div class="mzg-box">
        <div class="messege"><?= message('', true) ?></div>
    </div>
<?php endif; ?>

<form action="<?php echo ROOT ?>/add/production" method="POST" class="form-section">
    <h2 class="table-section__title">Add Production</h2>

    <div class="form-wrapper">
        <div class="form-container">
            <?php
            $url_prod = ROOT . "/fetch/product";
            $response_prod = file_get_contents($url_prod);
            $products = json_decode($response_prod, true);
            // show($products['products']);
            $products = $products['products'];
            ?>
            <!-- product -->
            <?php if (!empty($errors['product_id'])) : ?>
                <p class="validate-mzg"><?= $errors['product_id'] ?></p>
            <?php endif; ?>

            <div class="form-group">
                <label for="product_id" class="page-label">Product:</label>
                <select id="product_id" name="product_id" class="page-select" onchange="handleProductChange(this)">
                    <?php
                    $x = false;
                    foreach ($products as $product) {
                        if ($form_data['product_id'] == $product['product_id']) {
                            $x = true;
                            echo '<option value="' . $product['product_id'] . '" selected>' . $product['name'] . '</option>';
                        }
                    }
                    if ($x == false) {
                        echo '<option value="" selected disabled>Select a product</option>';
                    }
                    ?>

                    <?php foreach ($products as $product) : ?>
                        <?php if ($form_data['product_id'] != $product['product_id']) : ?>
                            <option value="<?php echo $product['product_id'] ?>"><?php echo $product['name'] ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if (!empty($errors['quantity'])) : ?>
                <p class="validate-mzg"><?= $errors['quantity'] ?></p>
            <?php endif; ?>
            <!-- Number of products can be made -->
            <!-- <p class="validate-mzg hidden" id="nop"></p> -->
            <div class="mzg-box col-danger addp hidden" id="nop">
                <div class="messege">
                    <p class="validate-mzg hidden" id="nop"></p>
                </div>
            </div>
            <div class="form-group">
                <label class="page-label" for="quantity">Quantity:</label>
                <input value="<?php echo $form_data['quantity'] ?>" class="page-input" type="number" id="quantity" name="quantity">
            </div>

            <!-- <p class="validate-mzg" id="awc"></p> -->
            <!-- <?php if (!empty($errors['quantity'])) : ?>
            <p class="validate-mzg"><?= $errors['quantity'] ?></p>
        <?php endif; ?> -->
            <!-- <div class="form-group">
            <label class="page-label" for="now">Number of workers:</label>
            <input value="<?php echo $form_data['now'] ?>" class="page-input" type="number" id="now" name="now">
        </div> -->

            <!-- <p class="validate-mzg" id="awcar"></p> -->
            <div class="mzg-box col-danger addp" id="awcar">
                <div class="messege">
                    <p class="validate-mzg" id="awcar"></p>
                </div>
            </div>

            <div class="form-group">
                <label class="page-label" for="now">Number of Carpenters:</label>
                <input class="page-input" type="number" id="nocar" name="nocar">
            </div>

            <!-- <p class="validate-mzg" id="awpain"></p> -->
            <div class="mzg-box col-danger addp" id="awpain">
                <div class="messege">
                    <p class="validate-mzg" id="awpain"></p>
                </div>
            </div>
            <div class="form-group">
                <label class="page-label" for="now">Number of Painters:</label>
                <input class="page-input" type="number" id="nopain" name="nopain">
            </div>

            <!-- <p class="validate-mzg" id="awsup"></p> -->
            <div class="mzg-box col-danger addp" id="awsup">
                <div class="messege">
                    <p class="validate-mzg" id="awsup"></p>
                </div>
            </div>
            <div class="form-group">
                <label class="page-label" for="now">Number of Supervisors:</label>
                <input class="page-input" type="number" id="nosup" name="nosup">
            </div>

            <div style="display: flex; justify-content: center; width:100%">
                <button type="submit" class="form-btn submit-btn" style="max-width: 400px;">Add New Production</button>
            </div>

        </div>
    </div>
</form>

<script>
    
    let product_id = document.getElementById('product_id').value;
    // if nop in session storage
    if (sessionStorage.getItem('nop') && product_id) {
        const nop = sessionStorage.getItem('nop');
        // document.getElementById('nop').innerHTML = `Maximum ${nop} products can be made with the available materials`;
        // document.getElementById('nop').classList.remove('hidden');
        if (nop == 0) {
            document.getElementById('nop').innerHTML = `No products can be made with the available materials`;
            document.getElementById('nop').classList.remove('hidden');
            document.getElementById('nop').classList.remove('addp');
            document.getElementById('nop').classList.add('addp-danger');
        } else {
            document.getElementById('nop').innerHTML = `Maximum ${nop} products can be made with the available materials`;
            document.getElementById('nop').classList.remove('hidden');
            document.getElementById('nop').classList.remove('addp-danger');
            document.getElementById('nop').classList.add('addp');
        }


        // set input value of quantity to minimum 0 and maximum nop
        document.getElementById('quantity').setAttribute('min', 0);
        document.getElementById('quantity').setAttribute('max', nop);
    }

    function handleProductChange(e) {
        const nocarInput = document.getElementById('nocar');
        const nopainInput = document.getElementById('nopain');
        const nosupInput = document.getElementById('nosup');

        // Check if any input field is empty and set its value to zero
        if (nocarInput.value === '') {
            nocarInput.value = 0;
        }
        if (nopainInput.value === '') {
            nopainInput.value = 0;
        }
        if (nosupInput.value === '') {
            nosupInput.value = 0;
        }

        const product_id = e.value;
        const url = `<?php echo ROOT ?>/fetch/product_materials/${product_id}`;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                let nop = 0;

                let arr = [];
                data.forEach(element => {
                    // nop = 0;

                    if (element.quantity_needed <= element.stock_available) {
                        nop = Math.floor(element.stock_available / element.quantity_needed);
                        // console.log(nop);
                        arr.push(nop);
                    } else {
                        nop = 0;
                        arr.push(nop);
                    }

                    nop = Math.min(...arr);
                    // console.log(nop);


                });

                // console.log(nop);

                // document.getElementById('nop').innerHTML = `Maximum ${nop} products can be made with the available materials`;
                // document.getElementById('nop').classList.remove('hidden');
                // document.getElementById('nop').classList.remove('addp-danger');
                // document.getElementById('nop').classList.add('addp');
                if (nop == 0) {
                    document.getElementById('nop').innerHTML = `No products can be made with the available materials`;
                    document.getElementById('nop').classList.remove('hidden');
                    document.getElementById('nop').classList.remove('addp');
                    document.getElementById('nop').classList.add('addp-danger');
                } else {
                    document.getElementById('nop').innerHTML = `Maximum ${nop} products can be made with the available materials`;
                    document.getElementById('nop').classList.remove('hidden');
                    document.getElementById('nop').classList.remove('addp-danger');
                    document.getElementById('nop').classList.add('addp');
                }

                // set nop in sessionStorage
                sessionStorage.setItem('nop', nop);

                // set input value of quantity to minimum 0 and maximum nop
                document.getElementById('quantity').setAttribute('min', 0);
                document.getElementById('quantity').setAttribute('max', nop);


            }).catch(err => {
                console.log(err);
                nop = 0;
                document.getElementById('nop').innerHTML = `No products can be made with the available materials`;
                document.getElementById('nop').classList.remove('hidden');
                document.getElementById('nop').classList.remove('addp');
                document.getElementById('nop').classList.add('addp-danger');

                document.getElementById('quantity').setAttribute('min', 0);
                document.getElementById('quantity').setAttribute('max', nop);
            })
    }

    const url2 = `<?php echo ROOT ?>/fetch/workers`;
    fetch(url2)
        .then(response => response.json())
        .then(data => {
            // console.log(data);
            let awc = 0;

            let awcar = 0;
            let awpain = 0;
            let awsup = 0;

            data.forEach(element => {
                if (element.availability == 'available') {
                    awc++;
                    if (element.worker_role == 'carpenter') {
                        awcar++;
                    } else if (element.worker_role == 'painter') {
                        awpain++;
                    } else if (element.worker_role == 'supervisor') {
                        awsup++;
                    }
                }
            });

            // console.log(awc);
            // document.getElementById('awc').innerHTML = `Number of available workers: ${awc}`;
            // document.getElementById('awc').classList.remove('hidden');


            // document.getElementById('awcar').innerHTML = `Number of available carpenters: ${awcar}`;
            if (awcar == 0) {
                document.getElementById('awcar').innerHTML = `No carpenters available`;
                document.getElementById('awcar').classList.remove('hidden');
                document.getElementById('awcar').classList.remove('addp');
                document.getElementById('awcar').classList.add('addp-danger');
            } else {
                document.getElementById('awcar').innerHTML = `Number of available carpenters: ${awcar}`;
                document.getElementById('awcar').classList.remove('hidden');
                document.getElementById('awcar').classList.remove('addp-danger');
                document.getElementById('awcar').classList.add('addp');
            }
            // document.getElementById('awcar').classList.remove('hidden');

            // document.getElementById('awpain').innerHTML = `Number of available painters: ${awpain}`;
            if (awpain == 0) {
                document.getElementById('awpain').innerHTML = `No painters available`;
                document.getElementById('awpain').classList.remove('hidden');
                document.getElementById('awpain').classList.remove('addp');
                document.getElementById('awpain').classList.add('addp-danger');
            } else {
                document.getElementById('awpain').innerHTML = `Number of available painters: ${awpain}`;
                document.getElementById('awpain').classList.remove('hidden');
                document.getElementById('awpain').classList.remove('addp-danger');
                document.getElementById('awpain').classList.add('addp');
            }
            // document.getElementById('awpain').classList.remove('hidden');

            document.getElementById('awsup').innerHTML = `Number of available supervisors: ${awsup}`;
            if (awsup == 0) {
                document.getElementById('awsup').innerHTML = `No supervisors available`;
                document.getElementById('awsup').classList.remove('hidden');
                document.getElementById('awsup').classList.remove('addp');
                document.getElementById('awsup').classList.add('addp-danger');
            } else {
                document.getElementById('awsup').innerHTML = `Number of available supervisors: ${awsup}`;
                document.getElementById('awsup').classList.remove('hidden');
                document.getElementById('awsup').classList.remove('addp-danger');
                document.getElementById('awsup').classList.add('addp');
            }
            // document.getElementById('awsup').classList.remove('hidden');


            // set input value of now to minimum 0 and maximum awc
            // document.getElementById('now').setAttribute('min', 0);
            // document.getElementById('now').setAttribute('max', awc);

            document.getElementById('nocar').setAttribute('min', 1);
            document.getElementById('nocar').setAttribute('max', awcar);

            document.getElementById('nopain').setAttribute('min', 0);
            document.getElementById('nopain').setAttribute('max', awpain);

            document.getElementById('nosup').setAttribute('min', 0);
            document.getElementById('nosup').setAttribute('max', awsup);

        }).catch(err => {
            console.log(err);
            awc = 0;
            // document.getElementById('awc').innerHTML = `Number of available workers: ${awc}`;

            // document.getElementById('now').setAttribute('min', 0);
            // document.getElementById('now').setAttribute('max', awc);

            document.getElementById('nocar').setAttribute('min', 0);
            document.getElementById('nocar').setAttribute('max', awc);

            document.getElementById('nopain').setAttribute('min', 0);
            document.getElementById('nopain').setAttribute('max', awc);

            document.getElementById('nosup').setAttribute('min', 0);
            document.getElementById('nosup').setAttribute('max', awc);

            // document.getElementById('awc').classList.remove('hidden');
        })
</script>

<script>
    if (sessionStorage.getItem('product_id') && sessionStorage.getItem('quantity')) {
        const product_id = sessionStorage.getItem('product_id')
        const quantity = sessionStorage.getItem('quantity')

        document.getElementById('product_id').value = product_id;
        document.getElementById('quantity').value = quantity;

        sessionStorage.removeItem('product_id');
        sessionStorage.removeItem('quantity');
    }
    document.getElementById('nocar').addEventListener('input', function() {
        const nocar = document.getElementById('nocar').value;
        if (nocar == 0) {
            document.querySelector('.submit-btn').setAttribute('disabled', 'true');
        } else {
            document.querySelector('.submit-btn').removeAttribute('disabled');
        }
    });
</script>










<?php include "inc/footer.view.php"; ?>