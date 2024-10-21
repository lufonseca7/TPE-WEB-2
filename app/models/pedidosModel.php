<?php
require_once './config.php'; 
class pedidosModel{
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB.';charset=utf8', MYSQL_USER, MYSQL_PASS);
        $this->deploy();

    }
    
    private function deploy(){
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        $password = 'admin';
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        if(count($tables) == 0){
            $sql = <<<END
            CREATE TABLE `categorias` (
            `id_categoria` int(11) NOT NULL,
            `nombre_categoria` varchar(30) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
            INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`) VALUES
            (2, 'Procesadores'),
            (3, 'Placas de video'),
            (4, 'Memoria Ram'),
            (10, 'Mouses');
            CREATE TABLE `pedidos` (
            `id_pedido` int(11) NOT NULL,
            `nombre` varchar(22) NOT NULL,
            `marca` varchar(22) NOT NULL,
            `categoria` varchar(22) NOT NULL,
            `precio` int(11) NOT NULL,
            `unidad` int(11) NOT NULL,
            `monto_total` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            INSERT INTO `pedidos` (`id_pedido`, `nombre`, `marca`, `categoria`, `precio`, `unidad`, `monto_total`) VALUES
            (7, 'rtx 3050 ', 'Evga', '3', 220000, 2, 440000),
            (20, '8gb 3200mhz', 'Fury', '4', 25000, 2, 50000),
            (21, 'Ryzen 7-5800', 'AMD', '2', 300000, 1, 300000),
            (22, 'I5-10400', 'Intel', '2', 180000, 1, 180000);
            CREATE TABLE `productos` (
            `id` int(11) NOT NULL,
            `nombre_producto` varchar(30) NOT NULL,
            `categoria` int(11) NOT NULL,
            `precio` int(11) NOT NULL,
            `marca` varchar(15) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
            INSERT INTO `productos` (`id`, `nombre_producto`, `categoria`, `precio`, `marca`) VALUES
            (6, 'rtx 3050 ', 3, 220000, 'Evga'),
            (7, '8gb 3200mhz', 4, 25000, 'Fury'),
            (13, 'I5-10400', 2, 180000, 'Intel'),
            (15, 'Ryzen 7-5800', 2, 300000, 'AMD'),
            (16, 'g203', 10, 100000, 'Logitech');
            CREATE TABLE `usuarios` (
                `id` int(11) NOT NULL,
                `usuario` varchar(22) NOT NULL,
                `password` varchar(100) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
            INSERT INTO `usuarios` (`id`, `usuario`, `password`) VALUES
            (1, 'webadmin', '$hashedPassword');
            ALTER TABLE `categorias`
            ADD PRIMARY KEY (`id_categoria`) USING BTREE;
            ALTER TABLE `pedidos`
            ADD PRIMARY KEY (`id_pedido`);
            ALTER TABLE `productos`
            ADD PRIMARY KEY (`id`),
            ADD KEY `fk_productos_categorias` (`categoria`);
            ALTER TABLE `usuarios`
            ADD PRIMARY KEY (`id`);
            ALTER TABLE `categorias`
            MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
            ALTER TABLE `pedidos`
            MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
            ALTER TABLE `productos`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
            ALTER TABLE `usuarios`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
            ALTER TABLE `productos`
            ADD CONSTRAINT `fk_productos_categorias` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id_categoria`);
            COMMIT;
            END;
            $this->db->query($sql);
        }
    }



    function getPedidos(){
        $query = $this->db->prepare('SELECT a.*, b.*,c.* FROM pedidos a LEFT JOIN categorias b ON a.categoria= b.id_categoria LEFT JOIN productos c ON a.nombre=c.nombre_producto');
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function getPedido($id_pedido){
        $query = $this->db->prepare('SELECT * FROM pedidos WHERE id_pedido = ?');
        $query->execute(array($id_pedido));
        return $query->fetch(PDO::FETCH_OBJ);
        
         
    }
    
    function insertPedido($nombre, $marca,$categoria, $precio, $unidades, $monto_total){
        $query = $this->db->prepare('INSERT INTO pedidos(nombre, marca, categoria, precio, unidad, monto_total) VALUES(?,?,?,?,?,?)');
        $query->execute (array($nombre,$marca, $categoria, $precio, $unidades, $monto_total));

        return $this->db->lastInsertId();
    }

    function removePedido($id_pedido) {
        $query = $this->db->prepare('DELETE FROM pedidos WHERE id_pedido = ?');
        $query->execute([$id_pedido]);
    }

    function filtrarPedido($id){
        $query =$this->db->prepare('SELECT a.*, b.*,c.* FROM pedidos a LEFT JOIN categorias b ON a.categoria= b.id_categoria LEFT JOIN productos c ON a.nombre=c.nombre_producto WHERE c.id = ?');
        $query->execute(array($id));
        return  $query->fetchAll(PDO::FETCH_OBJ);
    

    }
}