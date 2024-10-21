<?php
require_once './config.php'; 
class categoriasModel{
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB.';charset=utf8', MYSQL_USER, MYSQL_PASS);
    }
    function getCategorias() {
        $query = $this->db->prepare('SELECT * FROM categorias');
        $query->execute();

        $list = $query->fetchAll(PDO::FETCH_OBJ);
        return $list;
    }

    function showCategoria($id_categoria){
        $query = $this->db->prepare('SELECT nombre_categoria FROM categorias WHERE id_categoria = ?');
        $query->execute(array($id_categoria));
        return  $query->fetch(PDO::FETCH_OBJ);
        
        
    }

    function insertCategoria($nombre){
        $query = $this->db->prepare('INSERT INTO categorias(nombre_categoria) VALUES(?)');
        $query->execute (array($nombre));

        return $this->db->lastInsertId();
    }
    function getCategoria($id){
        $query = $this->db->prepare('SELECT nombre_categoria FROM categorias WHERE id_categoria = ?');
        $query->execute(array($id));
        return $query->fetch(PDO::FETCH_OBJ);
        
         
    }
    
    function removeCategoria($id) {
        $query = $this->db->prepare('DELETE FROM categorias WHERE id_categoria = ?');
        $query->execute([$id]);
    }

    function actualizarCategoria($id, $nombre){
        $query = $this->db->prepare("UPDATE categorias SET nombre_categoria='$nombre' WHERE id_categoria = ?");
        $query->execute(array($id));
    }
    
}