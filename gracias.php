<?php
session_start();
include("./include/funciones.php");
$connect = connect_db();
$title = "Plantas el Caminàs -> ";
include("./include/header.php");
require './include/ElCaminas/Carrito.php';
require './include/ElCaminas/Producto.php';
require './include/ElCaminas/Productos.php';
use ElCaminas\Carrito;
$carrito = new Carrito();
if ($carrito->howMany()>0) {$carrito->empty();}
?>
<div class="row">
  <div class="jumbotron">
      <h1>Gracias</h1>
      <p>Gracias por realizar su compra con nosotros</p>
      <p><a class="btn btn-primary btn-lg" href="index.php" role="button">Continuar</a></p>
  </div>
</div>
<?php
include("./include/footer.php");
?>
