<?php

namespace ElCaminas;
use \PDO;
use \ElCaminas\Producto;
class Carrito
{
    protected $connect;
    /** Sin parámetros. Sólo crea la variable de sesión
    */
    public function __construct()
    {
        global $connect;
        $this->connect = $connect;
        if (!isset($_SESSION['carrito'])){
            $_SESSION['carrito'] = array();
        }

    }
    public function addItem($id, $cantidad){
        $_SESSION['carrito'][$id] = $cantidad;
    }
    public function deleteItem($id){
      unset($_SESSION['carrito'][$id]);
    }
    public function empty(){
      unset($_SESSION['carrito']);
      self::__construct();
    }
    public function howMany(){
      return count($_SESSION['carrito']);
    }
    public function toHtml(){
      //NO USAR, de momento
      $str = <<<heredoc
      <table class="table">
        <thead> <tr> <th>#</th> <th>Producto</th> <th>Cantidad</th> <th>Precio</th> <th>Total</th> <th>Eliminar</th></tr> </thead>
        <tbody>
heredoc;
      if ($this->howMany() > 0)
        {
        $i=0; $total=0;
        foreach($_SESSION['carrito'] as $key => $cantidad)
          {
          $producto = new Producto($key);
          $i++;
          $subtotal = $producto->getPrecioReal() * $cantidad;
          $subtotalTexto = number_format($subtotal , 2, ',', ' ') ;
          $str .=  "<tr><th scope='row'>$i</th><td><a href='" .  $producto->getUrl() . "'>" . $producto->getNombre() . "</a>&nbsp;<a class='open-modal' title='Haga clic aquí para ver el detalle del producto' href='".$producto->getUrl()."'><span style='color:#000' class='fa fa-external-link'></span></a></td><td>$cantidad</td><td>" .  $producto->getPrecioReal() ." €</td><td>$subtotalTexto €</td><td><a href='carro.php?action=delete&id=".$producto->getId()."' onclick='return confirmar()'>X</a></td></tr>";
          $total=$total+($producto->getPrecioReal()); //Se van acumulando los precios de los productos del carro.
          }
        }
      $str.="</tbody>";
      if ($this->howMany()>0){$str.="<thead><tr> <th></th> <th>Total Carro:</th> <th></th> <th></th>";
                              $str.="<th>".$total." €</th> <th>IVA Incluido</th></tr> </thead>";}
      $str.="</table>";
      return $str;
    }
    //Método getTotal para PayPal:
    public function getTotal()
      {
      $total=0;
      foreach($_SESSION['carrito'] as $key => $cantidad)
        {
        $producto = new Producto($key);
        $subtotal = $producto->getPrecioReal() * $cantidad;
        $subtotalTexto = number_format($subtotal , 2, ',', ' ') ;
        $total=$total+($producto->getPrecioReal()); //Se van acumulando los precios de los productos del carro.
        }
      return $total;
      }
}
