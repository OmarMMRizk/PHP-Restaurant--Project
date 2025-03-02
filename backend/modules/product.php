<?php
include_once '../backend/database/db.php';

class Product
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }
    public function add($name, $desc, $price, $category_id, $image)
    {
        $image_path = $this->uploadImage($image);
        $stmt = $this->conn->prepare("INSERT INTO products (name, description, price, category_id, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $desc, $price, $category_id, $image_path]);
    }

    public function update($id, $name, $desc, $price, $category_id, $image = null)
    {
        if ($image && $image['size'] > 0) {
            $image_path = $this->uploadImage($image);
            $stmt = $this->conn->prepare("UPDATE products SET name=?, description=?, price=?, category_id=?, image=? WHERE id=?");
            $stmt->execute([$name, $desc, $price, $category_id, $image_path, $id]);
        } else {
            $stmt = $this->conn->prepare("UPDATE products SET name=?, description=?, price=?, category_id=? WHERE id=?");
            $stmt->execute([$name, $desc, $price, $category_id, $id]);
        }
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

    public function getProductCount()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM products");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getAllByCategory($category_id)
    {
        $stmt = $this->conn->prepare("SELECT products.*, categories.name as category_name FROM products 
        JOIN categories ON products.category_id = categories.id 
        WHERE products.category_id = ?");
        $stmt->execute([$category_id]);
        return $stmt->fetchAll();
    }

    private function uploadImage($image)
    {
        $target_dir = "../images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($image["name"]);
        move_uploaded_file($image["tmp_name"], $target_file);
        return $target_file;
    }

    public function search($keyword)
{
    $stmt = $this->conn->prepare("SELECT products.*, categories.name as category_name FROM products 
    JOIN categories ON products.category_id = categories.id 
    WHERE products.name LIKE :keyword OR products.description LIKE :keyword");
    $stmt->execute(['keyword' => "%$keyword%"]);
    return $stmt->fetchAll();
}
}



?>