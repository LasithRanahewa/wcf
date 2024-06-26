<?php

class Product extends Model
{

    public $errors = [];
    protected $table = "product";

    protected $allowedColumns = [
        "name",
        "description",
        "product_category_id",
        "product_inventory_id",
        "product_measurement_id",
        "price",
        "bulkmin",
        "created_at",
        "updated_at",
        "deleted_at",
        "listed",
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['name'])) {
            $this->errors['name'] = "Product name is required";
        } else if (!preg_match("/^[a-zA-Z0-9 ]*$/", $data['name'])) {
            $this->errors['name'] = "Product name must contain only letters, numbers, and spaces";
        } else if (strlen($data['name']) < 2) {
            $this->errors['name'] = "Product name must be at least 2 characters";
        } else if (strlen($data['name']) > 100) {
            $this->errors['name'] = "Product name must be less than 100 characters";
        } 
        if (empty($data['description'])) {
            $this->errors['description'] = "Product description is required";
        }
        //price
        if (empty($data['price'])) {
            $this->errors['price'] = "Product price is required";
        } else if (!is_numeric($data['price'])) {
            $this->errors['price'] = "Product price must be numeric";
        } else if ($data['price'] < 0) {
            $this->errors['price'] = "Product price must be greater than 0";
        }
        if (empty($data['bulkmin'])) {
            $this->errors['bulkmin'] = "This field is required";
        } else if (!is_numeric($data['bulkmin'])) {
            $this->errors['bulkmin'] = "Value must be numeric";
        } else if ($data['bulkmin'] < 10) {
            $this->errors['bulkmin'] = "Value must be greater than or equal to 10";
        }
        //product_category_id
        if (empty($data['product_category_id'])) {
            $this->errors['product_category_id'] = "Product category is required";
        }

        if(empty($this->errors))
		{
			return true;
		}

		return false;
        
    }

    // (A)
    // Products Controller

    public function getProductReview($product_id){
        $query = "SELECT pr.product_id, pr.customer_id, pr.review, pr.rating, pr.created_at,
                        c.first_name, c.last_name
                FROM product_review pr
                LEFT JOIN customer c ON pr.customer_id = c.customer_id
                WHERE pr.product_id = :product_id
                ORDER BY pr.created_at DESC";

		$params = array(':product_id' => $product_id);
		$db = new Database;
		$result = $db->query($query, $params, PDO::FETCH_ASSOC);

		return $result;
    }
    
    public function getReviewCount($product_id){
        $query = "SELECT pr.product_id, COUNT(pr.review_id) AS review_count, COUNT(pr.rating) AS rating_count,
                        CAST(AVG(pr.rating) AS UNSIGNED) AS average_rating,
                        SUM(CASE WHEN pr.rating = 1 THEN 1 ELSE 0 END) AS rating_1_count,
                        SUM(CASE WHEN pr.rating = 2 THEN 1 ELSE 0 END) AS rating_2_count,
                        SUM(CASE WHEN pr.rating = 3 THEN 1 ELSE 0 END) AS rating_3_count,
                        SUM(CASE WHEN pr.rating = 4 THEN 1 ELSE 0 END) AS rating_4_count,
                        SUM(CASE WHEN pr.rating = 5 THEN 1 ELSE 0 END) AS rating_5_count
                FROM product_review pr
                WHERE pr.product_id = :product_id
                GROUP BY pr.product_id
                ORDER BY pr.created_at DESC";

		$params = array(':product_id' => $product_id);
		$db = new Database;
		$result = $db->query($query, $params, PDO::FETCH_ASSOC);

		return $result;
    }

    public function getProductById($productId)
    {
        return $this->select($this->table, 'product_id = :product_id', [':product_id' => $productId]);
    }

    public function getProductInventoryId($productId)
    {
        return $this->select($this->table, 'product_id = :product_id', [':product_id' => $productId]);
    }
    
}
