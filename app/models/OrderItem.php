<?php

class OrderItem extends Model
{
    public $errors = [];

    protected $table = "order_item";
    public $allowedColumns = [
        "order_details_id",
        "product_id",
        "quantity"
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['order_details_id'])) {
            $this->errors['order_details_id'] = "Order details ID is required";
        } else if (!is_numeric($data['order_details_id'])) {
            $this->errors['order_details_id'] = "Order details ID must be a numeric value";
        }

        if (empty($data['product_id'])) {
            $this->errors['product_id'] = "Product ID is required";
        } else if (!is_numeric($data['product_id'])) {
            $this->errors['product_id'] = "Product ID must be a numeric value";
        }

        if (empty($data['quantity'])) {
            $this->errors['quantity'] = "Quantity is required";
        } else if (!is_numeric($data['quantity']) || $data['quantity'] <= 0) {
            $this->errors['quantity'] = "Quantity must be a positive numeric value";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function getByOrderDetailsId($orderDetailsId)
    {
        return $this->select($this->table, 'order_details_id = :order_details_id', [':order_details_id' => $orderDetailsId]);
    }

    public function getByOrderItemId($orderItemId)
    {
        return $this->select($this->table, 'order_item_id = :order_item_id', [':order_item_id' => $orderItemId]);
    }

    public function addOrderItem($data)
    {
        $params = [
            ':order_details_id' => $data['order_details_id'],
            ':product_id' => $data['product_id'],
            ':quantity' => $data['quantity'],
            ':created_at' => date('Y-m-d H:i:s'),
            ':updated_at' => date('Y-m-d H:i:s')
        ];
        $query = "INSERT INTO $this->table (order_details_id, product_id, quantity, created_at, updated_at) 
                  VALUES (:order_details_id, :product_id, :quantity, :created_at, :updated_at)";
        return $this->query($query, $params);
    }

    public function updateOrderItemQuantity($orderDetailsId, $productId, $quantity)
    {
        $query = "UPDATE $this->table SET quantity = :quantity 
                  WHERE order_details_id = :order_details_id AND product_id = :product_id";
        return $this->query($query, [':quantity' => $quantity, ':order_details_id' => $orderDetailsId, ':product_id' => $productId, ':updated_at' => date('Y-m-d H:i:s')]);
    }

    public function deleteOrderItem($orderDetailsId, $productId)
    {
        $query = "DELETE FROM $this->table 
                  WHERE order_details_id = :order_details_id AND product_id = :product_id";
        return $this->query($query, [':order_details_id' => $orderDetailsId, ':product_id' => $productId]);
    }

    public function deleteOrderItems($orderDetailsId)
    {
        $query = "DELETE FROM $this->table 
                  WHERE order_details_id = :order_details_id";
        return $this->query($query, [':order_details_id' => $orderDetailsId]);
    }
}