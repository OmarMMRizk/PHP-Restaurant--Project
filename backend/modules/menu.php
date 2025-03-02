<?php
include_once './backend/database/db.php';

class Product
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function add($name, $desc, $price, $category_id)
    {
        $stmt = $this->conn->prepare("INSERT INTO products (name, description, price, category_id,image) VALUES (?, ?, ?, ?,?)");
        $stmt->execute([$name, $desc, $price, $category_id,$image]);
    }

    public function update($id, $name, $desc, $price, $category_id)
    {
        $stmt = $this->conn->prepare("UPDATE products SET name=?, description=?, price=?, category_id=? WHERE id=?");
        $stmt->execute([$name, $desc, $price, $category_id, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function getAll()
    {
        return $this->conn->query("SELECT products.*, categories.name as category_name FROM products 
                                   JOIN categories ON products.category_id = categories.id")->fetchAll();
    }
    public function getPizza()
    {
        return $this->conn->query("SELECT products.* FROM products 
                                    WHERE products.category_id = 1")->fetchAll();
    }
    public function getBurger()
    {
        return $this->conn->query("SELECT products.* FROM products 
                                   WHERE products.category_id =2")->fetchAll();
    }
    public function getSushi()
    {
        return $this->conn->query("SELECT products.* FROM products 
                                   WHERE products.category_id = 3")->fetchAll();
    }
    public function getDesserts()
    {
        return $this->conn->query("SELECT products.* FROM products 
                                   WHERE products.category_id = 4")->fetchAll();
                                   
    }
}
?>
