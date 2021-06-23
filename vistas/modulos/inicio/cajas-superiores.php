<?php

$item = null;
$valor = date("Y-m-d");
$orden = "id";

$ventas = ControladorVentas::ctrSumaTotalVentas();

$compras = ControladorCompras::ctrSumarTotalGasto($item, $valor);

$cobrado = ControladorHistorial::ctrSumaTotalHistorial($item, $valor);
//$balance = ControladorCorteCaja::ctrMostrarBalance();

//$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
//$totalCategorias = count($categorias);

$clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
$totalClientes = count($clientes);

?>

<div class="col-lg-3 col-xs-6">
  <div class="small-box bg" style="background:#03c1ed; color:white">
    <div class="inner">
      <h3>$<?php echo number_format($cobrado["cobrado"],2); ?></h3>
      <p>Ingreso</p>
    </div>
    
    <div class="icon">
      <i class="ion ion-social-usd"></i>
    </div>
    
    <a href="ventas" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>

  </div>
</div>

<div class="col-lg-3 col-xs-6">
  <div class="small-box bg" style="background:#898989; color:white">
    <div class="inner">
      <h3>$<?php echo number_format($compras["gasto"],2); ?></h3>
      <p>Egresos</p>
    </div>
    
    <div class="icon">
      <i class="ion ion-social-usd"></i>
    </div>
    
    <a href="compras" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>

  </div>
</div>

<!--<div class="col-lg-3 col-xs-6">
  <div class="small-box bg" style="background:#e09a0e; color:white">
    <div class="inner">
      <h3>$<?php //echo number_format($balance["valance"],2); ?></h3>
      <p>Corte de caja</p>
    </div>
    
    <div class="icon">
      <i class="ion ion-social-usd"></i>
    </div>
    
    <a href="compras" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>

  </div>
</div>-->
<!--
<div class="col-lg-3 col-xs-6">
  <div class="small-box bg" style="background:#e13132; color:white">
    <div class="inner">
      <?php
    
      ?>
      <p>ODT Urgentes</p>
    </div>
    
    <div class="icon">
      <i class="ion ion-clipboard"></i>
    </div>
    
    <a href="categorias" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>
-->
