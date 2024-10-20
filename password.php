<?php 
$clave = "admin";  
$clave_encriptada = password_hash ($clave , PASSWORD_DEFAULT );  
echo "La clave $clave encriptada es la siguiente: $clave_encriptada";  
?>
