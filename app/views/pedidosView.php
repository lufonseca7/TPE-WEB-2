<?php
class pedidosView{
    function __construct(){}

    function showAdminPedidosList($list, $listOfProducts){
        $count = count($list);
        $count = count($listOfProducts);
        require './templates/pedidosAdmin.phtml';
    }
    function showPedidosList($list, $listOfProducts){
        $count = count($list);
        $count = count($listOfProducts);
        require './templates/pedidos.phtml';
    }
    public function showError($error) {
        require './templates/error.phtml';
    }
}