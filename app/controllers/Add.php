<?php

class Add extends Controller
{

    public function index()
    {
        $data['title'] = "AddAPI";
    }

    public function workers()
    {
        // show($_POST);
        $address = [
            'address_line_1' => $_POST['address_line_1'],
            'address_line_2' => $_POST['address_line_1'],
            'city' => $_POST['city'],
            'zip_code' => $_POST['zip_code'],
            'province' => $_POST['province']
        ];

        $worker = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'mobile_number' => $_POST['mobile_number'],
            'worker_role' => $_POST['worker_role']
        ];

        $data['errors'] = [];

        $worker = new Worker;
        $address = new Address;

        $result = $worker->validate($_POST);
        $result2 = $address->validate($_POST);

        show(1);

        if ($result && $result2) {
            $db = new Database;

            show(2);

            $address = [
                'address_line_1' => $_POST['address_line_1'],
                'address_line_2' => $_POST['address_line_2'],
                'city' => $_POST['city'],
                'zip_code' => $_POST['zip_code'],
                'province' => $_POST['province']
            ];

            // $db->query("INSERT INTO address (address_line_1, address_line_2, city, zip_code) VALUES (:address_line_1, :address_line_2, :city, :zip_code)", $address);
            $db->query("INSERT INTO address (address_line_1, address_line_2, city, zip_code, province) VALUES (:address_line_1, :address_line_2, :city, :zip_code, :province)", $address);
            $address_id = $db->query("SELECT address_id FROM address WHERE address_id = (SELECT MAX(address_id) FROM address)")[0]->address_id;

            // show($address_id);

            show(3);
            // $worker['address_id'] = $address_id;

            $worker = [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'mobile_number' => $_POST['mobile_number'],
                'address_id' => $address_id,
                'worker_role' => $_POST['worker_role']
            ];

            show($worker);
            // show ($address);


            // $db->query("INSERT INTO worker (first_name, last_name, mobile_number, address_id) VALUES (:first_name, :last_name, :mobile_number, :address_id)", $worker);
            $db->query("INSERT INTO worker (first_name, last_name, mobile_number, address_id, worker_role) VALUES (:first_name, :last_name, :mobile_number, :address_id, :worker_role)", $worker);
            show(4);

            message("Worker added successfully!");
            redirect('admin/workers');
        } else {
            // show("kes");
            // show($worker->errors);
            $data['errors'] = array_merge($worker->errors, $address->errors);
            // show($data['errors']);

            //how to keep popup open and show errors

            $_SESSION['errors'] = $data['errors'];
            $_SESSION['form_data'] = $_POST; // assuming the form data is in $_POST
            $_SESSION['form_id'] = 'form1'; // replace 'form1' with your form identifier
            redirect('admin/workers');


            // $this->view('admin/workers', $data);
        }
    }

    public function staff()
    {
        show($_POST);

        // add confirmation password
        $_POST['confirm_password'] = $_POST['password'];

        $address = [
            'address_line_1' => $_POST['address_line_1'],
            'address_line_2' => $_POST['address_line_1'],
            'city' => $_POST['city'],
            'zip_code' => $_POST['zip_code'],
            'province' => $_POST['province']
        ];

        $staff = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'mobile_number' => $_POST['mobile_number'],
        ];

        $user = [
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'confirm_password' => $_POST['confirm_password'],
            'role' => $_POST['role']
        ];

        show($address);
        show($staff);
        show($user);

        $data['errors'] = [];

        $staff = new Staff;
        $address = new Address;
        $user = new User;

        $result = $staff->validate($_POST);
        $result2 = $address->validate($_POST);
        $result3 = $user->validate($_POST);

        show(1);

        if ($result && $result2 && $result3) {
            $db = new Database;

            show(2);

            $address = [
                'address_line_1' => $_POST['address_line_1'],
                'address_line_2' => $_POST['address_line_2'],
                'city' => $_POST['city'],
                'zip_code' => $_POST['zip_code'],
                'province' => $_POST['province']
            ];

            // $db->query("INSERT INTO address (address_line_1, address_line_2, city, zip_code) VALUES (:address_line_1, :address_line_2, :city, :zip_code)", $address);
            $db->query("INSERT INTO address (address_line_1, address_line_2, city, zip_code, province) VALUES (:address_line_1, :address_line_2, :city, :zip_code, :province)", $address);
            $address_id = $db->query("SELECT address_id FROM address WHERE address_id = (SELECT MAX(address_id) FROM address)")[0]->address_id;

            show($address_id);

            show(3);
            $user = [
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'role' => $_POST['role']
            ];

            $db->query("INSERT INTO user (email, password, role) VALUES (:email, :password, :role)", $user);
            // $user_id = $db->query("SELECT user_id FROM user WHERE email = :email", $user)[0]->email;
            $user_id = $db->query("SELECT user_id FROM user WHERE user_id = (SELECT MAX(user_id) FROM user)")[0]->user_id;

            show($user_id);

            show(4);

            $staff = [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'mobile_number' => $_POST['mobile_number'],
                'address_id' => $address_id,
                'user_id' => $user_id
            ];

            $db->query("INSERT INTO staff (first_name, last_name, mobile_number, address_id, user_id) VALUES (:first_name, :last_name, :mobile_number, :address_id, :user_id)", $staff);
            show(5);

            message("Staff member added successfully!");
            redirect('admin/staff');
        } else {
            show("kes");
            // show($worker->errors);
            $data['errors'] = array_merge($staff->errors, $address->errors, $user->errors);
            // show($data['errors']);
            show($data['errors']);

            //how to keep popup open and show errors

            $_SESSION['errors'] = $data['errors'];
            $_SESSION['form_data'] = $_POST; // assuming the form data is in $_POST
            $_SESSION['form_id'] = 'form1'; // replace 'form1' with your form identifier
            redirect('admin/staff');
        }
    }

    public function product_category()
    {
        show($_POST);

        $product_category = [
            'category_name' => $_POST['name']
        ];

        $data['errors'] = [];

        $product_category = new ProductCategory;

        $result = $product_category->validate($_POST);

        show(1);

        if ($result) {
            $db = new Database;

            show(2);

            $product_category = [
                'category_name' => $_POST['category_name']
            ];

            show($product_category);

            $db->query("INSERT INTO product_category (category_name) VALUES (:category_name)", $product_category);

            show(3);

            message("Product category added successfully!");
            $_SESSION['p'] = 1;
            redirect('admin/categories');
        } else {
            show("kes");
            // show($worker->errors);
            $data['errors'] = array_merge($product_category->errors);
            // show($data['errors']);
            show($data['errors']);

            //how to keep popup open and show errors

            $_SESSION['errors'] = $data['errors'];
            $_SESSION['form_data'] = $_POST; // assuming the form data is in $_POST
            $_SESSION['form_id'] = 'form1'; // replace 'form1' with your form identifier
            redirect('admin/categories');
        }
    }

    public function product()
    {


        $data['errors'] = [];

        $db = new Database;

        $product_inventory = new ProductInventory;
        $product_measurement = new ProductMeasurement;
        $product = new Product;

        $_POST['quantity'] = 0;

        $result = $product->validate($_POST);
        // $result2 = $product_inventory->validate($_POST);

        $x = $db->select('product', 'name = :name', [':name' => $_POST['name']]);
        if ($x) {
            // $errors['name'] = "Product already exists";
            $product->errors['name'] = "Product already exists";
            $result = false;
        }

        $result2 = $product_measurement->validate($_POST);

        show($_POST);



        if ($result && $result2) {


            $product_inventory = [
                'quantity' => $_POST['quantity']
            ];

            // show(2);
            $db->query("INSERT INTO product_inventory (quantity) VALUES (:quantity)", $product_inventory);
            $product_inventory_id = $db->query("SELECT product_inventory_id FROM product_inventory WHERE product_inventory_id = (SELECT MAX(product_inventory_id) FROM product_inventory)")[0]->product_inventory_id;

            show(1);
            // show($product_inventory_id);

            $product_measurement = [
                'length' => $_POST['length'],
                'width' => $_POST['width'],
                'height' => $_POST['height'],
                'weight' => $_POST['weight']
            ];
            $db->query("INSERT INTO product_measurement (length, width, height, weight) VALUES (:length, :width, :height, :weight)", $product_measurement);
            $product_measurement_id = $db->query("SELECT product_measurement_id FROM product_measurement WHERE product_measurement_id = (SELECT MAX(product_measurement_id) FROM product_measurement)")[0]->product_measurement_id;

            show(2);
            // show($product_measurement_id);

            $product = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'product_category_id' => $_POST['product_category_id'],
                'product_inventory_id' => $product_inventory_id,
                'product_measurement_id' => $product_measurement_id,
                'bulkmin' => $_POST['bulkmin'],
            ];

            show($product);

            $db->query("INSERT INTO product (name, description, price, product_category_id, product_inventory_id, product_measurement_id,bulkmin) VALUES (:name, :description, :price, :product_category_id, :product_inventory_id, :product_measurement_id,:bulkmin)", $product);

            show(3);
            $product_id = $db->query("SELECT product_id FROM product WHERE product_id = (SELECT MAX(product_id) FROM product)")[0]->product_id;

            show(4);

            show($product_id);

            message("Product added successfully!");
            redirect('admin/products/' . $product_id);
        } else {
            show(3);
            $data['errors'] = array_merge($product->errors, $product_measurement->errors);
            show($data['errors']);

            $_SESSION['errors'] = $data['errors'];
            $_SESSION['form_data'] = $_POST;

            redirect('admin/products/add');
        }
    }

    public function product_image()
    {
        // show($_POST);
        // show($_FILES);

        if (empty($_FILES['image']['name'])) {
            redirect('admin/products/' . $_POST['product_id']);
        }

        $folder = "uploads/images/";
        $a = 2;
        if (!file_exists($folder)) {
            $a  = 1;
            mkdir($folder, 0777, true);

            file_put_contents($folder . "index.php", "<?php //silence");
            file_put_contents("uploads/index.php", "<?php //silence");
            //display folder contains

        }

        $files = scandir($folder);
        // show($files);

        // show($a);

        $errors = [];

        $db = new Database;

        $product_image = new ProductImage;


        // $allowed = ['image/jpeg', 'image/png', 'image/avif', 'image/gif', 'image/webp'];

        // if (!empty($_FILES['image']['name'])) {

        //     if ($_FILES['image']['error'] == 0) {

        //         if (in_array($_FILES['image']['type'], $allowed)) {
        //             //everything good
        //             $destination = $folder . time() . $_FILES['image']['name'];
        //             move_uploaded_file($_FILES['image']['tmp_name'], $destination);



        //             $_POST['image_url'] = $destination;
        //         } else {
        //             $product_image->$errors['image'] = "Image type not allowed";
        //         }
        //     } else {
        //         $product_image->errors['image'] = "Could not upload image";
        //     }
        // }

        show($_POST);
        show($_FILES);


        $destination = $folder . time() . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        $_POST['image_url'] = $destination;


        if (empty($product_image->errors)) {
            $product_image_arr = [
                'image_url' => $_POST['image_url'],
                'product_id' => $_POST['product_id']
            ];

            show($product_image_arr);

            $db->query("INSERT INTO product_image (image_url, product_id) VALUES (:image_url, :product_id)", $product_image_arr);

            message("Product image added successfully!");
            redirect('admin/products/' . $_POST['product_id']);
        } else {
            // show($product_image->errors);
            $_SESSION['errors'] = $product_image->errors;
            $_SESSION['form_data'] = $_POST;

            redirect('admin/products/' . $_POST['product_id']);
        }
    }

    public function material()
    {
        show($_POST);
        if (empty($_POST['description'])) {
            $_POST['description'] = "";
        }

        $data['errors'] = [];

        $material = new Material;

        $result = $material->validate($_POST);

        $db = new Database();
        $x = $db->select('material', 'material_name = :material_name', [':material_name' => $_POST['name']]);
        if ($x) {
            // $errors['name'] = "Material already exists";
            $material->errors['name'] = "Material already exists";
            $result = false;
        }

        show(1);

        if ($result) {
            $db = new Database;

            show(2);

            $material = [
                'material_name' => $_POST['name'],
                'material_description' => $_POST['description']
            ];

            show($material);

            $db->query("INSERT INTO material (material_name, material_description) VALUES (:material_name, :material_description)", $material);

            show(3);

            message("Material added successfully!");
            redirect('admin/materials');
        } else {
            show("kes");
            // show($worker->errors);
            $data['errors'] = array_merge($material->errors);
            // show($data['errors']);
            show($data['errors']);

            //how to keep popup open and show errors

            $_SESSION['errors'] = $data['errors'];
            $_SESSION['form_data'] = $_POST; // assuming the form data is in $_POST
            $_SESSION['form_id'] = 'form1'; // replace 'form1' with your form identifier
            redirect('admin/materials');
        }
    }

    public function product_material()
    {
        show($_POST);

        $data['errors'] = [];

        $db = new Database;

        $product_material = new ProductMaterial;

        $result = $product_material->validate($_POST);

        show(1);

        if ($result) {
            $db = new Database;

            show(2);

            $product_material = [
                'product_id' => $_POST['product_id'],
                'material_id' => $_POST['material_id'],
                'quantity_needed' => $_POST['quantity_needed']
            ];

            show($product_material);

            $db->query("INSERT INTO product_material (product_id, material_id, quantity_needed) VALUES (:product_id, :material_id, :quantity_needed)", $product_material);

            show(3);

            message("Product material added successfully!");
            redirect('pm/product_materials/' . $_POST['product_id']);
        } else {
            show("kes");
            // show($worker->errors);
            $data['errors'] = array_merge($product_material->errors);
            // show($data['errors']);
            show($data['errors']);

            //how to keep popup open and show errors

            $_SESSION['errors'] = $data['errors'];
            $_SESSION['form_data'] = $_POST; // assuming the form data is in $_POST
            $_SESSION['form_id'] = 'form1'; // replace 'form1' with your form identifier
            redirect('pm/product_materials/' . $_POST['product_id']);
        }
    }

    public function production()
    {

        $_POST['status'] = 'pending';
        // show($_POST);


        // show($_POST);

        $data['errors'] = [];

        $db = new Database;

        $production = new Production;

        $result = $production->validate($_POST);

        // show(1);

        $materials = [];
        if ($result) {
            //fetch materials needed for product
            $url = ROOT . "/fetch/product_materials/" . $_POST['product_id'];
            $response = file_get_contents($url);
            $product_materials = json_decode($response, true);

            $materials = $product_materials;
            // show($product_materials);

            //fetch materials and update quantity by subtracting quantity needed*quantity produced
            foreach ($product_materials as $product_material) {
                $material_id = $product_material['material_id'];
                $quantity_needed = $product_material['quantity_needed'];
                $quantity_needed = $quantity_needed * $_POST['quantity'];
                // show($material_id);
                // show($quantity_needed);

                $material = $db->query("SELECT * FROM material WHERE material_id = :material_id", ['material_id' => $material_id])[0];
                // show($material);

                $stock_available = $material->stock_available;
                // show($stock_available);


                $stock_available = $stock_available - $quantity_needed;
                // show($stock_available);

                // show("--------------------");

                $db->query("UPDATE material SET stock_available = :stock_available WHERE material_id = :material_id", ['stock_available' => $stock_available, 'material_id' => $material_id]);
                // show("Stock updated successfully!");
            }

            // add production
            $production = [
                'product_id' => $_POST['product_id'],
                'quantity' => $_POST['quantity'],
                'status' => $_POST['status']
            ];

            // show($production);

            $db->query("INSERT INTO production (product_id, quantity, status) VALUES (:product_id, :quantity, :status)", $production);

            // show(3);

            // show("Production added successfully!");

            // fetch production id
            $production_id = $db->query("SELECT production_id FROM production WHERE production_id = (SELECT MAX(production_id) FROM production)")[0]->production_id;


            // get availabale workers
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

            // usort($available_workers, function ($a, $b) {
            //     return $a['updated_at'] <=> $b['updated_at'];
            // });

            // show($available_workers);

            // $number_of_workers_needed = $_POST['nocar']+$_POST['nosup']+$_POST['nopain'];
            $number_of_carpenters_needed = 0;
            $number_of_supervisors_needed = 0;
            $number_of_painters_needed = 0;

            // if (isset($_POST['nocar'])) {
            //     $number_of_carpenters_needed = $_POST['nocar'];
            // }
            // if (isset($_POST['nosup'])) {
            //     $number_of_supervisors_needed = $_POST['nosup'];
            // }
            // if (isset($_POST['nopain'])) {
            //     $number_of_painters_needed = $_POST['nopain'];
            // }
            if ($_POST['nocar'] != '') {
                $number_of_carpenters_needed = $_POST['nocar'];
            }
            if ($_POST['nosup'] != '') {
                $number_of_supervisors_needed = $_POST['nosup'];
            }
            if ($_POST['nopain'] != '') {
                $number_of_painters_needed = $_POST['nopain'];
            }

            // show($number_of_workers_needed);
            // show($number_of_carpenters_needed);
            // show($number_of_supervisors_needed);
            // show($number_of_painters_needed);

            $available_carpenters = [];
            $available_supervisors = [];
            $available_painters = [];

            foreach ($available_workers as $available_worker) {
                if ($available_worker['worker_role'] == 'carpenter') {
                    $available_carpenters[] = $available_worker;
                }
                if ($available_worker['worker_role'] == 'supervisor') {
                    $available_supervisors[] = $available_worker;
                }
                if ($available_worker['worker_role'] == 'painter') {
                    $available_painters[] = $available_worker;
                }
            }

            // show($available_carpenters);



            // show($number_of_workers_needed);

            $workers_assigned = [];
            $carpenters_assigned = [];
            $supervisors_assigned = [];
            $painters_assigned = [];

            //assign carpenters
            // if (isset($number_of_carpenters_needed)) {
            //     for ($i = 0; $i < $number_of_carpenters_needed; $i++) {
            //         $carpenters_assigned[] = $available_carpenters[$i];
            //         $workers_assigned[] = $available_carpenters[$i];
            //     }
            // }
            if ($number_of_carpenters_needed != '') {
                for ($i = 0; $i < $number_of_carpenters_needed; $i++) {
                    $carpenters_assigned[] = $available_carpenters[$i];
                    $workers_assigned[] = $available_carpenters[$i];
                }
            }
            // show($carpenters_assigned);

            //assign supervisors

            // if (isset($number_of_supervisors_needed)) {
            //     for ($i = 0; $i < $number_of_supervisors_needed; $i++) {
            //         $supervisors_assigned[] = $available_supervisors[$i];
            //         $workers_assigned[] = $available_supervisors[$i];
            //     }
            // }
            if ($number_of_supervisors_needed != '') {
                for ($i = 0; $i < $number_of_supervisors_needed; $i++) {
                    $supervisors_assigned[] = $available_supervisors[$i];
                    $workers_assigned[] = $available_supervisors[$i];
                }
            }

            //assign painters
            // if (isset($number_of_painters_needed)) {
            //     for ($i = 0; $i < $number_of_painters_needed; $i++) {
            //         $painters_assigned[] = $available_painters[$i];
            //         $workers_assigned[] = $available_painters[$i];
            //     }
            // }
            if ($number_of_painters_needed != '') {
                for ($i = 0; $i < $number_of_painters_needed; $i++) {
                    $painters_assigned[] = $available_painters[$i];
                    $workers_assigned[] = $available_painters[$i];
                }
            }

            // for ($i = 0; $i < $number_of_workers_needed; $i++) {
            //     // $workers_assigned[] = $available_workers[$i];

            // }
            // show($workers_assigned);


            //update worker availability
            foreach ($workers_assigned as $worker_assigned) {
                $worker_id = $worker_assigned['worker_id'];
                $db->query("UPDATE worker SET availability = :availability WHERE worker_id = :worker_id", ['availability' => 'unavailable', 'worker_id' => $worker_id]);
                show("Worker availability updated successfully!");
            }

            // add workers to production_worker table
            foreach ($workers_assigned as $worker_assigned) {
                $production_worker = [
                    'production_id' => $production_id,
                    'worker_id' => $worker_assigned['worker_id']
                ];
                // show($production_worker);

                $db->query("INSERT INTO production_worker (production_id, worker_id) VALUES (:production_id, :worker_id)", $production_worker);
                show("Worker added to production_worker table successfully!");
            }

            // show(4);

            $materials_used = [];
            foreach ($materials as $material) {
                $material_used = [
                    'production_id' => $production_id,
                    'material_id' => $material['material_id'],
                    'quantity_used' => $material['quantity_needed'] * $_POST['quantity']
                ];
                $materials_used[] = $material_used;
            }

            $url2 = ROOT . "/fetch/material_stk";
            $response2 = file_get_contents($url2);
            $material_stk = json_decode($response2, true);

            // show($material_stk);

            $production_material_data = [];

            // show($materials_used);


            $material_ids = [];
            foreach ($materials_used as $material_used) {
                $material_ids[] = $material_used['material_id'];
            }

            $material_ids = array_unique($material_ids);
            // show($material_ids);

            // filter $material_stk by $material_ids
            $material_stk_filtered = [];
            foreach ($material_stk as $material_stk) {
                if (in_array($material_stk['material_id'], $material_ids)) {
                    $material_stk_filtered[] = $material_stk;
                }
            }


            for ($i = 0; $i < count($materials_used); $i++) {
                $material_id = $materials_used[$i]['material_id'];
                $quantity_used = $materials_used[$i]['quantity_used'];

                // show($material_id);
                // show($quantity_used);


                foreach ($material_stk_filtered as $material_stk) {
                    if ($material_stk['material_id'] == $material_id) {
                        // show($material_stk);
                        $stock_available = $material_stk['quantity'];
                        // show($stock_available);

                        if ($stock_available >= $quantity_used) {
                            show("enough");
                            $stock_available = $stock_available - $quantity_used;
                            // show($stock_available);

                            $db->query("UPDATE material_stk SET quantity = :quantity WHERE stock_no = :stock_no", ['quantity' => $stock_available, 'stock_no' => $material_stk['stock_no']]);

                            $production_material_data[] = [
                                'production_id' => $production_id,
                                'stock_no' => $material_stk['stock_no'],
                                'quantity' => $quantity_used
                            ];
                            // show("Material stock updated successfully!");

                            // $x = $quantity_used;
                            break;
                        } else {
                            // show("not enough");
                            $quantity_used = $quantity_used - $stock_available;
                            // show($quantity_used);

                            $db->query("UPDATE material_stk SET quantity = :quantity WHERE stock_no = :stock_no", ['quantity' => 0, 'stock_no' => $material_stk['stock_no']]);
                            show("Material stock updated successfully!");

                            $production_material_data[] = [
                                'production_id' => $production_id,
                                'stock_no' => $material_stk['stock_no'],
                                'quantity' => $stock_available
                            ];
                        }
                    }
                }
            }
            $count_pm = count($production_material_data);
            $c = 0;
            foreach ($production_material_data as $production_material) {
                $db->query("INSERT INTO production_material (production_id, stock_no, quantity) VALUES (:production_id, :stock_no, :quantity)", $production_material);
                // show("Production material added successfully!");
                $c++;
            }
            if ($c == $count_pm) {
                redirect('pm/productions');
            }

            message("Production added successfully!");
            redirect('pm/productions');
        } else {
            show("kes");
            $data['errors'] = array_merge($production->errors);
            show($data['errors']);

            //how to keep popup open and show errors

            $_SESSION['errors'] = $data['errors'];
            $_SESSION['form_data'] = $_POST; // assuming the form data is in $_POST
            $_SESSION['form_id'] = 'form1'; // replace 'form1' with your form identifier
            redirect('pm/add_production');
        }
    }

    public function supplier()
    {
        show($_POST);

        $data['errors'] = [];

        $supplier = new Supplier;
        $address = new Address;

        $result = $supplier->validate($_POST);
        $result2 = $address->validate($_POST);

        if ($result && $result2) {

            show(1);

            $db = new Database;

            $address = [
                'address_line_1' => $_POST['address_line_1'],
                'address_line_2' => $_POST['address_line_2'],
                'city' => $_POST['city'],
                'zip_code' => $_POST['zip_code']
            ];

            $db->query("INSERT INTO address (address_line_1, address_line_2, city, zip_code) VALUES (:address_line_1, :address_line_2, :city, :zip_code)", $address);

            $address_id = $db->query("SELECT address_id FROM address WHERE address_id = (SELECT MAX(address_id) FROM address)")[0]->address_id;

            show(2);

            $supplier = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'telephone' => $_POST['telephone'],
                'brn' => $_POST['brn'],
                'address_id' => $address_id
            ];

            $db->query("INSERT INTO supplier_details (name, email, telephone, brn, address_id) VALUES (:name, :email, :telephone, :brn, :address_id)", $supplier);

            show(3);

            message("Supplier added successfully!");
            redirect('sk/suppliers');
        } else {
            show("kes");
            show($supplier->errors);
            show($address->errors);

            $data['errors'] = array_merge($supplier->errors, $address->errors);
            show($data['errors']);

            $_SESSION['errors'] = $data['errors'];
            $_SESSION['form_data'] = $_POST;
            $_SESSION['form_id'] = 'form1';

            redirect('sk/suppliers');
        }
    }

    public function material_order()
    {
        show($_POST);

        $data['errors'] = [];

        $material_order = new MaterialOrder;

        $result = $material_order->validate($_POST);

        show(1);

        if ($result) {
            $db = new Database;

            show(2);

            $material_order = [
                'material_id' => $_POST['material_id'],
                'supplier_id' => $_POST['supplier_id'],
                'quantity' => $_POST['quantity'],
                'price_per_unit' => $_POST['price_per_unit'],
                'total' => $_POST['total']
            ];

            show($material_order);

            $db->query("INSERT INTO material_order (material_id, supplier_id, quantity, price_per_unit, total) VALUES (:material_id, :supplier_id, :quantity, :price_per_unit, :total)", $material_order);

            show(3);

            // update material stock available
            $material_id = $_POST['material_id'];
            $quantity = $_POST['quantity'];

            $material = $db->query("SELECT * FROM material WHERE material_id = :material_id", ['material_id' => $material_id])[0];
            // show($material);

            $stock_available = $material->stock_available;
            // show($stock_available);

            $stock_available = $stock_available + $quantity;
            // show($stock_available);

            $db->query("UPDATE material SET stock_available = :stock_available WHERE material_id = :material_id", ['stock_available' => $stock_available, 'material_id' => $material_id]);

            // create material stock for this order
            $material_stk = [
                'material_order_id' => $db->query("SELECT material_order_id FROM material_order WHERE material_order_id = (SELECT MAX(material_order_id) FROM material_order)")[0]->material_order_id,
                'material_id' => $material_id,
                'quantity' => $quantity,
                'price_per_unit' => $_POST['price_per_unit']
            ];

            $db->query("INSERT INTO material_stk (material_order_id, material_id, quantity, price_per_unit) VALUES (:material_order_id, :material_id, :quantity, :price_per_unit)", $material_stk);


            message("Material order added successfully and material stock updated!");
            redirect('sk/material_orders');
        } else {
            show("kes");
            // show($worker->errors);
            $data['errors'] = array_merge($material_order->errors);
            // show($data['errors']);
            show($data['errors']);

            //how to keep popup open and show errors

            $_SESSION['errors'] = $data['errors'];
            $_SESSION['form_data'] = $_POST; // assuming the form data is in $_POST
            $_SESSION['form_id'] = 'form1'; // replace 'form1' with your form identifier
            redirect('sk/material_orders/add');
        }
    }

    public function chat_record()
    {
        $db = new Database;

        if (!isset($_POST)) {
            $array['Status'] = "Post not set";
            echo json_encode($array);
            die();
        }

        $chat_record = [
            'connection' => $_POST['connection'],
            'sent_by' => $_POST['sent_by'],
            'message' => $_POST['message'],
            'created_at' => $_POST['created_at']
        ];

        $query = "INSERT INTO chat_records (connection, sent_by, message, created_at) VALUES (:connection, :sent_by, :message, :created_at)";
        $db->query($query, $chat_record);

        $array['Status'] = "Success";

        header("Content-Type: application/json");
        echo json_encode($array);
    }
}
