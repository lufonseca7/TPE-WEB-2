<?php
require_once './config.php'; 
class productoModel{
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB.';charset=utf8', MYSQL_USER, MYSQL_PASS);
    }
    function getProducts() {
        $query = $this->db->prepare('SELECT a.* , b.* FROM productos a LEFT JOIN  categorias b ON a.categoria = b.id_categoria');
        $query->execute();

        $list = $query->fetchAll(PDO::FETCH_OBJ);
        return $list;
    }

    function showProducto($id){
        $query = $this->db->prepare('SELECT * FROM productos WHERE id = ?');
        $query->execute(array($id));
        return  $query->fetch(PDO::FETCH_OBJ);
        
        
    }

    function insertProduct($producto, $categoria, $precio,$marca){
        $query = $this->db->prepare('INSERT INTO productos(nombre_producto, categoria, precio, marca) VALUES(?,?,?,?)');
        $query->execute (array($producto, $categoria, $precio,$marca));

        return $this->db->lastInsertId();
    }
    function getProduct($id){
        $query = $this->db->prepare('SELECT nombre_producto, categoria, precio, marca FROM productos WHERE id = ?');
        $query->execute(array($id));
        return $query->fetch(PDO::FETCH_OBJ);
        
         
    }
    
    function removeProducto($id) {
        $query = $this->db->prepare('DELETE FROM productos WHERE id = ?');
        $query->execute([$id]);
    }

    function filtrarProducto($id){
        $query =$this->db->prepare('SELECT a.*, b.* FROM productos a LEFT JOIN categorias b ON a.categoria= b.id_categoria  WHERE b.id_categoria = ?');
        $query->execute(array($id));
        return  $query->fetchAll(PDO::FETCH_OBJ);
    

    }

    function actualizarProducto($id,$nuevoNombre, $categoria, $precio, $marca){
        $query = $this->db->prepare("UPDATE productos SET nombre_producto='$nuevoNombre', categoria='$categoria',precio='$precio', marca='$marca' WHERE id = ?");
        $query->execute(array($id));
    }
    
}