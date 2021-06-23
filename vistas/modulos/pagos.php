
<div class="content-wrapper">
  <?php
    
    $item = "ventas.id";
    $valor = $_GET["idVenta"];

    $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);

    foreach($ventas as $key => $venta){

      echo '<section class="content-header">
              <h1>Folio: #'.$venta["codigo"].'</h1>
            </section>';

            $itemPrioridad = "id";
            $valorPrioridad = $venta[0]["id_prioridad"];

            $respuestaPrioridad = ControladorPrioridad::ctrMostrarPrioridad($itemPrioridad, $valorPrioridad);
            
          if($valorPrioridad == "1"){

            echo'<div class="pad margin no-print">
                  <div class="callout callout-danger" style="margin-bottom: 0!important;">
                    <h4><i class="fa fa-info"></i> Nota:</h4>.'.$venta["nota"].'
                  </div>
                </div>';
          }else{
            
            echo'<div class="pad margin no-print">
                  <div class="callout callout-warning" style="margin-bottom: 0!important;">
                    <h4><i class="fa fa-info"></i> Nota:</h4>.'.$venta["nota"].'
                  </div>
                </div>';
          }

          $itemAjuste = null;
          $valorAjuste = null;

          $respuestaAjustes = ControladorAjustes::ctrMostrarAjusteControlador($itemAjuste, $valorAjuste);
          
          foreach($respuestaAjustes as $key => $ajustes){
            echo'<section class="invoice">
                    <div class="row">
                      <div class="col-xs-12">
                        <h2 class="page-header">
                          <img src="'.$ajustes["logo"].'" width=”100” height="100"  walt="">
                          <small class="pull-right">'.strftime("%d %B %Y").'</small>
                        </h2>
                      </div>
                    </div>
            
                  <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <address>
                        <strong>'.$ajustes["empresa"].'</strong><br>
                        <b>'.$ajustes["direccion"].'</b></br> 
                        <b>'.$ajustes["colonia"].'</b> <b>#'.$ajustes["cp"].'</b></br>
                        <b>'.$ajustes["alcaldia"].'</b></br>
                        <b>'.$ajustes["estado"].'</b></br>
                        <b>'.$ajustes["telefono"].'</b></br>
                        <b>'.$ajustes["correo"].'</b></br>
                      </address>
                    </div>';
          }
 
                $itemCliente = "id";
                $valorCliente = $venta["id_cliente"];

                $cliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);
                
                echo'<div class="col-sm-4 invoice-col">
                      <b>Dr.</b>
                      <address>
                        <strong>'.$cliente["nombre"].'</strong><br>
                        <b>'.$cliente["direccion"].'</b></br>
                        <b>'.$cliente["colonia"].'</b> <b>#'.$cliente["cp"].'</b></br> 
                        <b>'.$cliente["municipio"].'</b></br>
                        <b>'.$cliente["entidad"].'</b></br>
                        <b>'.$cliente["telefono"].'</b></br>
                        <b>'.$cliente["correo"].'</b></br> 
                      </address>
                    </div>';

                    $itemHistorial =  "id";
                    $valorHistorial = $venta["id_historial"];

                    $historial = ControladorHistorial::ctrMostrarHistorial($itemHistorial, $valorHistorial);

                echo'<div class="col-sm-4 invoice-col">
                      <b>Folio: #'.$venta["codigo"].'</b></br>';

                      if($valorPrioridad == "1"){

                        echo'<b>Prioridad de pedido: <small class="btn-danger">Urgente</small></b></br>';
                      }else{

                        echo'<b>Prioridadstado de pedido: <small class="btn-warning">Importante</small></b></br>';
                      }

                      if($historial["faltante"] == 0){

                          echo '<b idVenta="'.$historial["faltante"].'">Estado de pago: <small class="btn-success">Pagado</small></b></br>';
                        }else{

                          echo '<b idVenta="'.$historial["faltante"].'">Estado de pago: <small class="btn-danger">Saldo pendiente $'.number_format($historial["faltante"],2).'</small></b></br>';
                        }

                echo'<b>Creación de ODT: '.$venta["fecha"].'</b>
                      <b>Ultomo pago de ODT: '.$historial["fecha"].' </b></div></div>
                      <div class="row">
                        <div class="col-xs-12 table-responsive">
                          <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Cantidad</th>
                              <th>Descripción</th>
                              <th>Precio Unitario</th>
                              <th>Total</th>
                            </tr>
                          </thead>';
                
                $listaProducto = json_decode($venta["productos"], true);

                foreach ($listaProducto as $key => $servicios) {

                  $item = "id";
                  $valor = $servicios["id"];
                  $orden = "id";

                  $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

                  echo'<tbody>
                          <tr>
                            <td>'.($key+1).'</td>
                            <th>'.$servicios["cantidad"].'</th>
                            <th>'.$servicios["descripcion"].'</th>
                            <th>$'.number_format($servicios["precio"],2).'</th>
                            <th>$'.number_format($servicios["total"],2).'</th>
                          </tr>
                        </tbody>';
                }

              echo'</table></div></div>
                    <div class="row">
                      <div class="col-sm-6">
                      <p class="lead">Historial de pagos:</p>
                        <div class="col-sm-12 invoice-col">
                          <address class="text-muted well well-sm no-shadow">';

                          $itemHistoriales =  $_GET["codigo"];
                          $valorHistoriales = $venta[0]["codigo"];
      
                          $historiales = ControladorHistorial::ctrMostrarHistorial($itemHistoriales, $valorHistoriales);

                          foreach($historiales as $key => $historicos){
                            
                            if($venta["codigo"] == $historicos["codigo"]){
                             
                              echo '<strong>Movimiento:'.($key+1).'-'.$historicos["fecha"].'</strong><b> Moto de pago: $'.number_format($historicos["cobrado"],2).'</b>'; 
                                   
                                  if($historicos["faltante"] == 0){

                                    echo'<b class="btn-success"> Adeudo:$'.number_format($historicos["faltante"],2).'
                                    </b><br>';
                                   }else{
                                    echo'<b class="btn-danger"> Adeudo:$'.number_format($historicos["faltante"],2).'
                                    </b><br>';
                                   }
                            }
                          }
                
                  echo'</address></div></div>

                        <div class="col-sm-6">
                          <p class="lead">Monto adeudado al '.$venta["fecha"].'</p>
                          
                          <div class="table-responsive">
                            <table class="table">
                            <tr>
                              <th style="width:50%">Sub Total:</th>
                              <td>$'.number_format($venta["neto"],2).'</td>
                            </tr>
                            <tr>
                              <th>Impuesto:</th>
                              <th>'.number_format($venta["impuesto"],2).' %</th>
                            </tr>
                            <tr>
                              <th>Total:</th>
                              <th>$'.number_format($venta["total"],2).'</th>
                            </tr>
                            </table>
                          </div>
                        </div>
                      </div>

                      <div class="row no-print">
                        <div class="col-xs-12">
                          <button type="submit" class="btn btn-primary name="Submit" onclick="javascript:window.print()"><i class="fa fa-print"></i>    Imprimir</button>
                        </div>
                      </div>
                  </section>
                  <div class="clearfix"></div>';
    }
  ?>
</div>