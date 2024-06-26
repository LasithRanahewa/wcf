<?php include "inc/header.view.php"; ?>

<?php
if (isset($_SESSION['errors']) && isset($_SESSION['form_data']) && isset($_SESSION['form_id'])) {
    $errors = $_SESSION['errors'];
    $form_data = $_SESSION['form_data'];
    $form_id = $_SESSION['form_id'];
    // unset the session variables so they don't persist on page refresh
    unset($_SESSION['errors']);
    unset($_SESSION['form_data']);
    unset($_SESSION['form_id']);
    // display the errors and repopulate the form with the data
    // show($form_data);
}
?>

<?php if (message()) : ?>
    <div class="mzg-box">
        <div class="messege"><?= message('', true) ?></div>
    </div>
<?php endif; ?>


<!-- <h1>Products</h1> -->
<div class="table-section">

    <h2 class="table-section__title">Products</h2>



    <div class="table-section__add">
        <!-- <a href="<?php echo ROOT ?>/admin/products/categories" class="table-section__add-link">Product Categories</a> -->
        <a href="<?php echo ROOT ?>/admin/products/add" class="table-section__add-link">Add New Product</a>
    </div>

    <div class="table-section__search">
        <input type="text" id="searchProducts" placeholder="Search Products..." class="table-section__search-input">
    </div>

    <!-- fetch and display products in a table -->

    <div id="scrollable_sec">
        <table class="table-section__table" id="products_table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <!-- <th>Product Description</th> -->
                    <th>Category</th>
                    <th>Stocks Available</th>
                    <th>Product Measurement</th>
                    <th>Price</th>
                    <th>Listed</th>
                    <th>Actions</th>
                </tr>

            </thead>
            <tbody>
                <?php
                $url = ROOT . "/fetch/product";
                $response = file_get_contents($url);
                $data = json_decode($response, true);

                $products = $data['products'];
                // show($products);
                usort($products, function ($a, $b) {
                    return $b['product_id'] <=> $a['product_id'];
                });

                foreach ($products as $item) :
                ?>
                    <tr>
                        <td><?php echo sprintf('PRD-%03d', $item['product_id']); ?></td>
                        <td><?php echo $item['name']; ?></td>
                        <!-- <td><?php echo $item['description']; ?></td> -->
                        <td><?php echo $item['category_name']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php
                            foreach ($item['measurement'] as $key => $value) {
                                if ($key == 'weight') {
                                    echo ucfirst($key) . ' : ' . $value . ' kg<br>';
                                } else {
                                    echo ucfirst($key) . ' : ' . $value . ' cm<br>';
                                }
                            }
                            ?></td>
                        <td><?php echo $item['price']; ?></td>

                        <?php
                        if ($item['listed'] == 1) {
                            $x = 'Yes';
                        } else {
                            $x = 'No';
                        }
                        ?>
                        <td>
                            <?php if ($item['listed'] == 1) : ?>
                                <a class="  table-section__button-available">Yes</a>
                            <?php else : ?>
                                <a class="table-section__button-unavailable">No</a>
                            <?php endif; ?>

                        </td>
                        <td>
                            <!-- view -->
                            <?php
                            if ($item['listed'] == 1) {
                                echo '<a href="" class="table-section__button" onclick="unlistfunc(' . $item['product_id'] . ')">Unlist</a>';
                            } else {
                                echo '<a href="" class="table-section__button" onclick="listfunc(' . $item['product_id'] . ')">List</a>';
                            }
                            ?>

                            <a href="<?php echo ROOT ?>/admin/products/<?php echo $item['product_id'] ?>" class="table-section__button">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<script>
    document.getElementById('searchProducts').addEventListener('input', function() {
        let searchValue = this.value.toLowerCase();
        let rows = document.getElementById('products_table').rows;
        for (let i = 1; i < rows.length; i++) {
            let name = rows[i].cells[1].innerText.toLowerCase();
            let id = rows[i].cells[0].innerText.toLowerCase();
            let category = rows[i].cells[2].innerText.toLowerCase();
            let listed = rows[i].cells[6].innerText.toLowerCase();

            if (name.includes(searchValue) || id.includes(searchValue) || category.includes(searchValue) || listed.includes(searchValue)) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    });


    let ths = document.querySelectorAll('th');
    ths.forEach(th => {
        th.addEventListener('click', function() {
            let table = document.getElementById('products_table');
            let tbody = table.querySelector('tbody');
            let rows = Array.from(tbody.querySelectorAll('tr'));

            let index = Array.from(this.parentNode.children).indexOf(this);

            let order = this.dataset.order = -(this.dataset.order || -1);

            rows.sort((a, b) => {
                a = a.children[index].textContent;
                b = b.children[index].textContent;
                return a.localeCompare(b, undefined, {
                    numeric: true
                }) * order;
            });

            rows.forEach(row => tbody.appendChild(row));
        });
    });

    function listfunc(id) {
        // post request to list product
        // alert(id);
        let url = "<?php echo ROOT ?>/update/list_product/" + id;
        // alert(url);

        post = {
            method: 'post',
            body: JSON.stringify({
                id: id
            })
        }

        fetch(url, post)
            .then(res => res.json())
            .then(data => {
                alert(data);
                if (data == 1) {
                    // alert('Product listed successfully');
                    location.reload();
                } else {
                    // alert('Something went wrong');
                }
            })
            .catch(err => {
                // alert(err);
            })
    }

    function unlistfunc(id) {
        // alert(id);
        // post request to unlist product

        let url = "<?php echo ROOT ?>/update/unlist_product/" + id;

        post = {
            method: 'post',
            body: JSON.stringify({
                id: id
            })
        }

        fetch(url, post)
            .then(res => res.json())
            .then(data => {
                alert(data);
                if (data == 1) {
                    // alert('Product unlisted successfully');
                    location.reload();
                } else {
                    // alert('Something went wrong');
                }
            })
            .catch(err => {
                // alert(err);
            })



    }
</script>










<?php include "inc/footer.view.php"; ?>