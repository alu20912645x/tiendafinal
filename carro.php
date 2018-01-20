<?php
  session_start();
  include("./include/funciones.php");
  $connect = connect_db();
  //El redirect se monta en un par de métodos de Producto.php
  if (isset ($_GET['redirect'])===true)
    {$redirect=$_GET['redirect'];}
  else
    {$redirect='index.php';}

  $title = "Plantas el Caminàs -> ";
  include("./include/header.php");
  require './include/ElCaminas/Carrito.php';
  require './include/ElCaminas/Producto.php';
  require './include/ElCaminas/Productos.php';
  use ElCaminas\Carrito;


  $carrito = new Carrito();
  // Falta comprobar qué acción: add, delete, empty
  $action="view";
  if(isset($_GET["action"]))
    {$action=$_GET["action"];}
  if ($action=="add")
    {$carrito->addItem($_GET["id"], 1);}
  elseif ($action=="delete")
    {$carrito->deleteItem($_GET["id"]);}
  elseif ($action=="empty")
    {$carrito->empty();}

?>
<script>
	function confirmar()
		{
		//Siempre que una acción no se pueda deshacer hay que pedir confirmación al usuario:
		if (confirm("¿Seguro que desea realizar esta acción?"))
			return true;
		else
			return false;
		}
</script>
  <div class="row carro" style='padding-bottom: 25px;'>
    <h2 class='subtitle' style='margin:0'>Carrito de la compra</h2>
    <?php  echo $carrito->toHtml();
    if ($carrito->howMany()>0) //No mostraremos el botón de vaciar carrito si ya no quedan productos en el carro.
      {?>
      <a href='./carro.php?action=empty' class='btn btn-danger' style='position:relative; left: 5px;bottom: 5px' onclick='return confirmar()'>Vaciar carro</a>
      <a href='./checkout.php' class='btn btn-primary' style='float: right; position:relative; left: 5px;bottom: 5px'>Confirmar pedido</a>
      <a href='<?php echo $redirect;?>' class='btn btn-success' style='float: right; position:relative; left: 0px;bottom: 5px'>Seguir comprando</a>
      <?php } ?>
  </div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle del producto</h4>
      </div>
      <div class="modal-body">
        <iframe src='#' width="100%" height="600px" frameborder=0 style='padding:8px'></iframe>
      </div>
    </div>
  </div>
</div>
<?php
$bottomScripts = array();
$bottomScripts[] = "modalIframeProducto.js";
include("./include/footer.php");
?>
