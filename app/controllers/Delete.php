<?php

class Delete extends Controller
{

    public function index()
    {
        $data['title'] = "DeleteApi";
    }

    public function customers($id)
    {
        $db = new Database();

        $customer = $db->query("SELECT * FROM customer WHERE customer_id = $id");
        $address_id = $customer[0]->address_id;
        $user_id = $customer[0]->user_id;
        $db->query("DELETE FROM customer WHERE customer_id = $id");
        $db->query("DELETE FROM user WHERE user_id = $user_id");
        $db->query("DELETE FROM address WHERE address_id = $address_id");

        message("Customer deleted successfully!");
        redirect('admin/customers');
    }

    public function workers($id)
    {
        $db = new Database();

        $worker = $db->query("SELECT * FROM worker WHERE worker_id = $id");
        $address_id = $worker[0]->address_id;

        show($address_id);
        show($worker);

        //fetch all production workers
        $production_workers = $db->query("SELECT * FROM production_worker WHERE worker_id = $id");

        //if worker is a production worker dont delete
        if ($production_workers) {
            $message = sprintf("Worker (WRK-%03d) cannot be deleted because he is assigned for a production!", $id);
            message($message);
            redirect('admin/workers');
        } else {
            $db->query("DELETE FROM worker WHERE worker_id = $id");
            $db->query("DELETE FROM address WHERE address_id = $address_id");
            show(3);
            message("Worker deleted successfully!");
            redirect('admin/workers');
        }
    }

    public function staff($id)
    {
        $db = new Database();

        $staff = $db->query("SELECT * FROM staff WHERE staff_id = $id");
        $address_id = $staff[0]->address_id;
        $user_id = $staff[0]->user_id;
        $db->query("DELETE FROM staff WHERE staff_id = $id");
        $db->query("DELETE FROM user WHERE user_id = $user_id");
        $db->query("DELETE FROM address WHERE address_id = $address_id");

        message("Staff deleted successfully!");
        redirect('admin/staff');
    }

    public function product_categories($id)
    {
        $db = new Database();

        $url = ROOT . "/fetch/product";
        $response = file_get_contents($url);
        $products = json_decode($response, true);

        // show($products);

        foreach ($products['products'] as $product) {
            if ($product['product_category_id'] == $id) {
                $message = sprintf("Product category (CAT-%03d) cannot be deleted because it is used in a product!", $id);
                message($message);
                redirect('admin/categories');
            }
        }

        $db->query("DELETE FROM product_category WHERE product_category_id = $id");

        message("Product category deleted successfully!");
        redirect('admin/categories');
    }

    public function product_images($id)
    {
        $db = new Database();

        $product_id = $db->query("SELECT product_id FROM product_image WHERE product_image_id = $id")[0]->product_id;

        $db->query("DELETE FROM product_image WHERE product_image_id = $id");

        message("Product image deleted successfully!");
        redirect('admin/products/' . $product_id);
    }

    public function products($id)
    {
        $db = new Database();

        $product_id = $db->query("SELECT product_id FROM product WHERE product_id = $id")[0]->product_id;

        //get all product images
        $product_images = $db->query("SELECT * FROM product_image WHERE product_id = $product_id");

        //delete all product images
        foreach ($product_images as $product_image) {
            $db->query("DELETE FROM product_image WHERE product_image_id = $product_image->product_image_id");
        }

        $db->query("DELETE FROM product WHERE product_id = $id");


        message("Product deleted successfully!");
        redirect('admin/products');
    }

    public function materials($id)
    {
        $db = new Database();

        show($id);

        $material = $db->query("SELECT * FROM material WHERE material_id = $id");

        show($material);
        $stockAvailable = $material[0]->stock_available;
        show($stockAvailable);

        $product_material = $db->query("SELECT * FROM product_material WHERE material_id = $id");
        
        if($stockAvailable > 0){
            $message = sprintf("Material (MAT-%03d) cannot be deleted because it is available in stock!", $id);
            show($message);
            message($message);
            redirect('admin/materials');
        }
        else if ($product_material) {
            $message = sprintf("Material (MAT-%03d) cannot be deleted because it is used in a product!", $id);
            show($message);
            message($message);
            redirect('admin/materials');
        } else {
            $db->query("DELETE FROM material WHERE material_id = $id");
            message("Material deleted successfully!");
            show("Material deleted successfully!");
            redirect('admin/materials');
        }
    }

    public function product_materials($id)
    {
        $db = new Database();

        $product_id = $db->query("SELECT product_id FROM product_material WHERE product_material_id = $id")[0]->product_id;

        $db->query("DELETE FROM product_material WHERE product_material_id = $id");

        show($product_id);

        message("Product material deleted successfully!");
        redirect('pm/product_materials/' . $product_id);
    }

    public function supplier($id)
    {
        $db = new Database();

        $orders = $db->query("SELECT material_order_id FROM material_order WHERE supplier_id = $id");
        if (!empty($orders))
        {
            message("Supplier (".sprintf('SUP-%03d', $id).") cannot be deleted!");
            redirect('sk/suppliers');
        }

        // show($id);

        $supplier = $db->query("SELECT * FROM supplier_details WHERE supplier_id = $id");
        $address_id = $supplier[0]->address_id;

        // show($address_id);

        $db->query("DELETE FROM supplier_details WHERE supplier_id = $id");
        $db->query("DELETE FROM address WHERE address_id = $address_id");

        message("Supplier deleted successfully!");
        redirect('sk/suppliers');
    }
}
