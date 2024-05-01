<?php

/**
 * Customer model
 */
class Customer extends Model
{

    public $errors = [];
    protected $table = "customer";

    protected $allowedColumns = [
        "user_id",
        "address_id",
        "first_name",
        "last_name",
        "email",
        "telephone",
        // "birth_day",
        // "birth_month",
        // "birth_year",
        // "gender",
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['first_name'])) {
            $this->errors['first_name'] = "First name is required";
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $data['first_name'])) {
            $this->errors['first_name'] = "First name must contain only letters and spaces";
        } elseif (strlen($data['first_name']) < 2) {
            $this->errors['first_name'] = "First name must be at least 2 characters";
        }

        if (empty($data['last_name'])) {
            $this->errors['last_name'] = "Last name is required";
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $data['last_name'])) {
            $this->errors['last_name'] = "Last name must contain only letters and spaces";
        } elseif (strlen($data['last_name']) < 2) {
            $this->errors['last_name'] = "Last name must be at least 2 characters";
        }

        if (empty($data['telephone'])) {
            $this->errors['telephone'] = "Telephone is required";
        } else if (!is_numeric($data['telephone'])) {
            $this->errors['telephone'] = "Telephone must be numeric";
        } else if (strlen($data['telephone']) != 10) {
            $this->errors['telephone'] = "Telephone must be 10 digits";
        } else if (substr($data['telephone'], 0, 1) != 0) {
            $this->errors['telephone'] = "Telephone must start with 0";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
    public $customer_id;
    public function setCId($customer_id)
    {
        $this->customer_id = $customer_id;
    }

    // public function setId()
    // {
    //     $result = $this->select($this->table, 'Customer_id = :cid', [':cid' => $this->getId()]);
    //     return $result;
    // }

    // public function edit_validate($data)
    // {
    //     $this->errors = [];

    //     if(empty($data['firstname'])){
    //         $this->errors['firstname'] = "First name is required";
    //     }

    //     if(empty($data['lastname'])){
    //         $this->errors['lastname'] = "Last name is required";
    //     }

    //     // check email
    //     if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
    //         $this->errors['email'] = "Email is not valid";
    //     }
    //     else
    //     if($this->where(['email' => $data['email']])){
    //         $this->errors['email'] = "Email is already exists";
    //     }

    //     if(!empty($data['facebook_link'])){
    //         if(!filter_var($data['facebook_link'], FILTER_VALIDATE_URL)){
    //             $this->errors['facebook_link'] = "Facebook link is not valid";
    //         }
    //     }

    //     if(!empty($data['twitter_link'])){
    //         if(!filter_var($data['twitter_link'], FILTER_VALIDATE_URL)){
    //             $this->errors['twitter_link'] = "Twitter link is not valid";
    //         }
    //     }

    //     if(!empty($data['instagram_link'])){
    //         if(!filter_var($data['instagram_link'], FILTER_VALIDATE_URL)){
    //             $this->errors['instagram_link'] = "Instagram link is not valid";
    //         }
    //     }

    //     if(!empty($data['linkedin_link'])){
    //         if(!filter_var($data['linkedin_link'], FILTER_VALIDATE_URL)){
    //             $this->errors['linkedin_link'] = "Linkedin link is not valid";
    //         }
    //     }

    //     if(empty($this->errors)){
    //         return true;
    //     }

    //     return false;
    // }
    public function getCustomerAddress($customerId)
    {
        // Fetch the customer's address from the database based on the customer ID
        $addressModel = new Address(); // Assuming you have an Address model
        $customerAddress = $addressModel->getAddressByCustomerId($customerId);

        return $customerAddress;
    }

    public function getAddressId($customerId)
    {
        $addressId = $this->select($this->table, 'customer_id = ?', [$customerId])[0]->address_id;
        return $addressId;
    }

    // (A)
    // Profile Controller

    public function updateCustomerProfile($id, $data)
    {
        $table = 'customer';

        $setClause = '';
        foreach ($data as $key => $value) {
            $setClause .= "`$key` = :$key, ";
        }
        $setClause = rtrim($setClause, ', ');

        // Construct the full SQL query
        $query = "UPDATE $table SET $setClause WHERE `customer_id` = :id";

        // Add the customer ID to the data array
        $data['id'] = $id;

        // Perform the database update
        $db = new Database;
        $db->query($query, $data);
        return 1;
    }

    // Orders Controller - retail orders

    public function getOrders($user_id)
    {
        $query = "SELECT od.order_details_id, od.status, od.created_at, 
						oi.quantity, 
						p.name as product_name, 
						pi.image_url
				FROM order_details od
				LEFT JOIN order_item oi ON od.order_details_id = oi.order_details_id
				LEFT JOIN product p ON oi.product_id = p.product_id
				LEFT JOIN product_image pi ON p.product_id = pi.product_id
				WHERE od.user_id = :user_id
				GROUP BY od.order_details_id, p.product_id
				ORDER BY od.created_at DESC";

        $params = array(':user_id' => $user_id);
        $db = new Database;
        $result = $db->query($query, $params, PDO::FETCH_ASSOC);

        return $result;
    }

    public function getOrderDetails($order_id)
    {
        $query = "SELECT od.order_details_id, od.created_at, od.total, od.updated_at, od.status, od.delivery_cost,
						a.address_line_1, a.address_line_2, a.city,
						c.first_name, c.last_name, c.telephone,
                        (od.total + od.delivery_cost) AS total_cost
					FROM order_details od
					LEFT JOIN customer c ON od.user_id = c.user_id
					LEFT JOIN address a ON c.address_id = a.address_id
					WHERE od.order_details_id = :order_id
					GROUP BY od.order_details_id";

        $params = array(':order_id' => $order_id);
        $db = new Database;
        $result = $db->query($query, $params, PDO::FETCH_ASSOC);

        return $result;
    }

    public function getOrderItems($order_id)
    {
        $query = "SELECT oi.quantity, p.name AS product_name, p.price, 
						pi.image_url
					FROM order_item oi
					LEFT JOIN product p ON oi.product_id = p.product_id
					LEFT JOIN product_image pi ON p.product_id = pi.product_id
					WHERE oi.order_details_id = :order_id
					GROUP BY p.product_id";

        $params = array(':order_id' => $order_id);
        $db = new Database;
        $result = $db->query($query, $params, PDO::FETCH_ASSOC);

        // Calculate subtotal for each order item
        // foreach ($result as &$item) {
        //     $item['total_cost'] = $item['total'] + $item['deliver_cost'];
        // }

        return $result;
    }

    // Review Controller

    public function getProducts($user_id, $customer_id)
    {
        $query = "SELECT od.user_id, od.created_at,
                     oi.product_id,
                     p.name AS product_name,
                     pi.image_url,
                     pr.customer_id, pr.review_id, pr.review, pr.rating
              FROM order_details od
              LEFT JOIN order_item oi ON od.order_details_id = oi.order_details_id
              LEFT JOIN product p ON oi.product_id = p.product_id
              LEFT JOIN product_image pi ON p.product_id = pi.product_id
              LEFT JOIN product_review pr ON p.product_id = pr.product_id AND pr.customer_id = :customer_id
              WHERE od.user_id = :user_id
              GROUP BY p.product_id
              ORDER BY od.created_at DESC";

        $params = array(':user_id' => $user_id, ':customer_id' => $customer_id);
        $db = new Database();
        $result = $db->query($query, $params, PDO::FETCH_ASSOC);

        return $result;
    }

    public function getBulkProducts($user_id, $customer_id)
    {
        $query = "SELECT bod.bulk_order_details_id, bod.created_at,
                     br.bulk_req_id, br.product_id,
                     p.name AS product_name,
                     pi.image_url,
                     pr.customer_id, pr.review_id, pr.review, pr.rating
              FROM bulk_order_details bod
              LEFT JOIN bulk_order_req br ON bod.bulk_req_id = br.bulk_req_id
              LEFT JOIN product p ON br.product_id = p.product_id
              LEFT JOIN product_image pi ON p.product_id = pi.product_id
              LEFT JOIN product_review pr ON p.product_id = pr.product_id AND pr.customer_id = :customer_id
              WHERE bod.user_id = :user_id
              GROUP BY p.product_id
              ORDER BY bod.created_at DESC";

        $params = array(':user_id' => $user_id, ':customer_id' => $customer_id);
        $db = new Database();
        $result = $db->query($query, $params, PDO::FETCH_ASSOC);

        return $result;
    }


    public function addReview($product_id, $customer_id, $rating, $review)
    {
        $query = "INSERT INTO product_review (product_id, customer_id, rating, review, created_at, updated_at) 
                  VALUES (:product_id, :customer_id, :rating, :review, NOW(), NOW())";

        $params = array(
            ':product_id' => $product_id,
            ':customer_id' => $customer_id,
            ':rating' => $rating,
            ':review' => $review
        );

        $db = new Database();
        $result = $db->query($query, $params, PDO::FETCH_ASSOC);

        return $result;
    }

    // public function getProductDetails($product_id){
    //     $query = "SELECT p.product_id, p.name AS product_name,
    //                      pi.image_url
    //             FROM product p
    //             LEFT JOIN product_image pi ON p.product_id = pi.product_id
    //             WHERE p.product_id = :product_id
    //             GROUP BY p.product_id";

    //     $params = array(':product_id' => $product_id);

    //     $db = new Database();
    //     $result = $db->query($query, $params, PDO::FETCH_ASSOC);

    //     return $result;
    // }

    // public function getReviewDetails($product_id, $customer_id)
    // {
    //     $query = "SELECT pr.review_id, pr.product_id, pr.rating, pr.review,
    //                     p.name AS product_name,
    //                     pi.image_url
    //             FROM product_review pr
    //             LEFT JOIN product p ON pr.product_id = p.product_id
    //             LEFT JOIN product_image pi ON p.product_id = pi.product_id
    //             WHERE pr.product_id = :product_id AND pr.customer_id = :customer_id
    //             GROUP BY p.product_id";

    //     $params = array(':product_id' => $product_id, ':customer_id'=> $customer_id);

    //     $db = new Database();
    //     $result = $db->query($query, $params, PDO::FETCH_ASSOC);

    //     return $result;
    // }

    public function updateReview($id, $data)
    {
        $table = 'product_review';

        $setClause = '';
        foreach ($data as $key => $value) {
            $setClause .= "`$key` = :$key, ";
        }
        $setClause = rtrim($setClause, ', ');

        // Construct the full SQL query
        $query = "UPDATE $table SET $setClause WHERE `review_id` = :id";

        $data['id'] = $id;

        // Perform the database update
        $db = new Database;
        $db->query($query, $data);
        return 1;
    }



    //Order Controller - bulk orders

    public function getBulkOrders($user_id)
    {
        $query = "SELECT br.bulk_req_id, br.status AS request_status, br.quantity, br.created_at, br.updated_at,
                        p.name AS product_name,
                        pi.image_url
                FROM bulk_order_req br
                LEFT JOIN product p ON br.product_id = p.product_id
                LEFT JOIN product_image pi ON p.product_id = pi.product_id
                WHERE br.user_id = :user_id
                GROUP BY br.bulk_req_id
                ORDER BY br.created_at DESC";

        $params = array(':user_id' => $user_id);
        $db = new Database;
        $result = $db->query($query, $params, PDO::FETCH_ASSOC);

        return $result;
    }

    public function getBulkOrderDetails($bulk_req_id)
    {
        $query = "SELECT bod.bulk_order_details_id, bod.created_at, bod.updated_at, bod.total_cost, bod.delivery_cost,
                         bod.status, bod.type, bod.delivery_address_id,
                         p.name AS product_name, p.price,
                         pi.image_url,
                         c.first_name, c.last_name, c.telephone,
                         a.address_line_1, a.address_line_2, a.city,
                         br.quantity, 
                         (bod.total_cost + bod.delivery_cost) AS total
                  FROM bulk_order_details bod
                  LEFT JOIN bulk_order_req br ON bod.bulk_req_id = br.bulk_req_id
                  LEFT JOIN product p ON br.product_id = p.product_id
                  LEFT JOIN product_image pi ON p.product_id = pi.product_id
                  LEFT JOIN customer c ON br.user_id = c.user_id
                  LEFT JOIN address a ON c.address_id = a.address_id
                  WHERE bod.bulk_req_id = :bulk_req_id AND br.status = 'accepted'
                  GROUP BY bod.bulk_order_details_id";

        $params = array(':bulk_req_id' => $bulk_req_id);
        $db = new Database;
        $result = $db->query($query, $params, PDO::FETCH_ASSOC);

        return $result;
    }

    // public function getBulkProducts(){
    //     $query = "SELECT bod.bulk_order_details_id,
    //                     br.bulk_req_id, br.product_id,
    //                     p.name AS product_name,
    //                     pi.image_url,
    //                     FROM bulk_order_details bod
    //                     LEFT JOIN bulk_order_req br ON bod.bulk_req_id = br.bulk_req_id
    //                     ";

    //     $params = array(':bulk_req_id' => $bulk_req_id);
    //     $db = new Database;
    //     $result = $db->query($query, $params, PDO::FETCH_ASSOC);

    //     return $result;
    // }
}
