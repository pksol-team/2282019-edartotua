<?php
	
// if ($_SERVER['SERVER_NAME'] != 'auto-live.test') {
// 	$con = mysqli_connect("localhost","autot611_builder","~L*]omF}}?63","autot611_ATF_builder");
// } else {
// 	$con = mysqli_connect("localhost","root","","autotrade");
// }
// DB info
$con = mysqli_connect("localhost","root","","clickhos_autot611_atf_builder");
if (!$con ) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
}

?>