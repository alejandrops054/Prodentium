<link rel="stylesheet" type="text/css" href="vistas/dist/css/corte_caja.css">

<div class="content-wrapper">

  <section class="content-header">
    <h1>Corte de caja</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administración de corte de caja</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border botones">
        <button class="btn btn-primary inicioCaja" data-toggle="modal" data-target="#montoInicioModal">Inicio caja</button>
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalBalance">Balance del día</button>
        <button class="btn btn-primary cierreCaja" data-toggle="modal" data-target="#modalCierreCaja">Cierre caja</button>
         <button type="button" class="btn btn-default pull-right" id="daterange-btnCorteCaja">  
            <span>
              <i class="fa fa-calendar"></i> 

              <?php

                if(isset($_GET["fechaInicial"])){
                  
                  echo $_GET["fechaInicial"]." - ".$_GET["fechaFinal"];
                }else{
                  echo 'Rango de fecha';  
                }

              ?>
            </span>
            <i class="fa fa-caret-down"></i>
         </button>
      </div>

      <div class="box-body">
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
        <thead>
         <tr>
           <th>#</th>
           <th>Movimiento</th>
           <th>Fecha del movimiento</th>
           <th>Realizó</th>
           <th>Ingresos</th>
           <th>Egresos</th>
           <th>Balance general</th>
           <th>Acciones</th>
         </tr> 
        </thead>
        <tbody>
        <?php

          if(isset($_GET["fechaInicial"])){

            $fechaInicial = $_GET["fechaInicial"];
            $fechaFinal = $_GET["fechaFinal"];

          }else{

            $fechaInicial = date("Y-m-d");
            $fechaFinal = null;

          }

          $respuesta = ControladorCorteCaja::ctrRangoFechasCorteCaja($fechaInicial, $fechaFinal);

          foreach ($respuesta as $key => $value){
           

           echo '<tr>
                  <td>'.$value["id"].'</td>
                  <td>'.$value["concepto"].'</td>
                  <td>'.$value["fecha"].'</td>';

          $itemUsuario = "id";
          $valorUsuario = $value["id_vendedor"];

          $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

           echo '<td>'.$respuestaUsuario["nombre"].'</td>       
                  <td>$ '.number_format($value["ingresos"],2).'</td>
                  <td>$ '.number_format($value["egresos"],2).'</td>
                  <td>$ '.number_format($value["valance"],2).'</td>
                <td>
                
                <div class="btn-group">
                  <button class="btn btn-warning btnDetallesCorteCaja" id_corte="'.$value["id"].'" fecha="'.$value["fecha"].'" data-toggle="modal" data-target="#modalDetallesCorteCaja"><i class="far fa-eye"></i></button>';
                  if(isset($_GET["fechaInicial"])){

                  }else{
                   //echo'<button class="btn btn-primary" id_corte="'.$value["id"].'" fecha="'.$value["fecha"].'" id="printThisHistorico responsecontainer" id="btnPrint"><i class="fa fa-print"></i>  Imprimir</button>'; 
                  }
              
          echo'</div>  
              </td>
            </tr>';
            }
        ?>
        </tbody>
      </table>
    </div>
    </div>
  </section>
</div>

<!--=====================================
MODAL ACCESOS CAJA NOOOOO BOOORRAAAAARR!!!
======================================
<div id="loginModal" class="modal fade" role="dialog">  
      <div class="modal-dialog">  
   <!-- Modal content 
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Accesos</h4>  
                </div>  
                <div class="modal-body accesos">
                <!-- ENTRADA PARA EL MONTO 
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-user"></i></span>     
                          <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuario" />  
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                     <input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="Contraseña" />  
                   </div>
                 </div>
                     <button type="button" id="login_button" class="btn btn-primary btnAccesosCorteCaja">Acceder</button>  
                </div>  
           </div>  
      </div>  
 </div>  

<!--=====================================
MODAL MONTO DE INICIO DE CAJA
======================================-->
<div id="montoInicioModal" class="modal fade" role="dialog">  
      <div class="modal-dialog">  
   <!-- Modal content-->  
           <div class="modal-content">  
             <form role="form" method="post">
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Monto inicio de caja</h4>  
                </div>  
                <div class="modal-body">  

                      <!-- ENTRADA PARA EL MONTO -->
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-usd"></i></span> 
                          <input type="number" class="form-control input-lg" name="nuevoMonto" placeholder="Ingresar monto" required>
                        </div>
                      </div>

                      <!-- ENTRADA CONCEPTO -->
                      <input type="hidden" name="concepto" value="INICIO DE CAJA">
                      <!-- ENTRADA VENDEDOR -->
                      <input type="hidden" name="id_vendedor" value="<?php echo $_SESSION["id"]; ?>">
                      <!-- ENTRADA HISTORIAL -->
                      <input type="hidden" name="id_historial" value="<?php echo $_SESSION["id"]; ?>">
                      <!-- ENTRADA CAJA -->
                      <input type="hidden" name="caja" value="1">
                      <!-- ENTRADA EGRESOS -->
                      <input type="hidden" name="egresos" value="0"> 
                    <?php

                      $inicioCaja = new ControladorCorteCaja();
                      $inicioCaja -> ctrIngresarInicioCaja();

                    ?>
                </div>
                <div class="modal-footer">
                  <button type="submit" id="login_button" class="btn btn-primary btnValidarInicioCaja">Guardar</button> 
                </div> 
              </form> 
           </div>  
      </div>  
 </div>  

<!--=====================================
MODAL BALANCE
======================================-->
<div id="modalBalance" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div id="printThis">
        <div class="modal-header" style="background:#011e41; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Balance del día <?php echo date("Y-m-d"); ?></h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
              <!-- INGRESOS CORTE DEL DÍA -->
              <div class="form-title text-center">
                <h4>INGRESOS</h4>
              </div>
              <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                  <thead>
                   <tr>
                     <th width="5%">#</th>
                     <th width="20%">Fecha</th>
                     <th width="20%">Doctor</th>
                     <th width="20%">Usuario</th>
                     <th width="20">ODT</th>
                     <th width="20%">Servicio</th>
                     <th width="15%">Importe</th>
                   </tr> 
                  </thead>
                  <tbody>
                  <?php

                      /*=============================================
                      MUESTRA MONTO INICIO DE CAJA TABLA 'corte_caja'
                      =============================================*/ 

                      $itemCorte = "concepto";
                      $valorCorte = "INICIO DE CAJA";

                      $itemCorte2 = "fecha";
                      $valorCorte2 = date("Y-m-d");

                      $respuestaCorteCaja = ControladorCorteCaja::ctrMostrarInicioCaja($itemCorte, $valorCorte, $itemCorte2, $valorCorte2);

                      $contadorIngresos = 1;

                      if ($respuestaCorteCaja["concepto"] == "INICIO DE CAJA") {

                      echo'<tr>
                            <td>'.$contadorIngresos.'</td>
                            <td>'.$respuestaCorteCaja["fechaInicioCaja"].'</td>
                            <td>'.$respuestaCorteCaja["nombre"].'</td>
                            <td>'.$respuestaCorteCaja["concepto"].'</td>
                            <td>'.$respuestaCorteCaja["codigo"].'</td>
                            <td>$ '.number_format($respuestaCorteCaja["ingresos"],2).'</td>
                           </tr>';

                      }

                      /*=============================================================================
                      MUESTRA HISTORIAL PAGOS VENTAS TABLA 'historial_pagos'
                      =============================================================================*/ 

                      $itemHistorialPagos = "fecha";
                      $valorHistorialPagos = date("Y-m-d");

                      $respuestaHistorialPagos = ControladorHistorial::ctrPagosBalanceHoy($itemHistorialPagos, $valorHistorialPagos);

                      $sumaHistorialPagos = 0;

                      $cobradoTransferencia = 0;

                      $contadorHistorialPagos = 2;

                      foreach ($respuestaHistorialPagos as $keyHistorialPagos => $valueHistorialPagos) {

                          echo'<tr>
                                <td>'.$contadorHistorialPagos.'</td>
                                <td>'.$valueHistorialPagos["fecha"].'</td>
                                <td>'.$valueHistorialPagos["nombreDoctor"].'</td>
                                <td>'.$valueHistorialPagos["nombreUsuario"].'</td>
                              </tr>';


                          //Decodificamos el objeto JSON para obtener el valor de "descripción y precio"
                          $objetoJson = json_decode($valueHistorialPagos["productos"]);

                          echo "<td>";

                          foreach ($objetoJson as $keyJson => $valueJson) {

                              echo '<p>'.$valueJson->{'descripcion'}.': $ '.number_format($valueJson->{'precio'},2).'</p></br>';
                          }

                          echo "</td>";
                          //Sí es transferencia suma total de montos y lo resta al final
                          if($valueHistorialPagos["metodo_pago"] == "Transferencia" && $valueHistorialPagos["metodo_pago"] == "Tarjeta Crédito" && $valueHistorialPagos["metodo_pago"] == "Tarjeta Débito"){

                            $cobradoTransferencia += $valueHistorialPagos["cobrado"];

                            echo '<td>Transferencia: $ '.number_format($valueHistorialPagos["cobrado"],2).'</td>';

                          }else{

                            echo '<td>'.$valueHistorialPagos["metodo_pago"].' $ '.number_format($valueHistorialPagos["cobrado"],2).'</td>';

                          }
                        echo '</tr>';

                        //SUMA TOTAL HISTORIAL PAGOS
                        $sumaHistorialPagos += $valueHistorialPagos["cobrado"];

                        //CONTADOR DE FILAS HISTORIAL PAGOS
                        $contadorHistorialPagos = $contadorHistorialPagos + 1;

                      }

                      $ingresosTotales = $sumaHistorialPagos + $respuestaCorteCaja["ingresos"] - $cobradoTransferencia;

                      /*=====================================
                      MUESTRA MONTO CIERRE DE CAJA TABLA 'corte_caja'
                      ===================================== 
                      if ($respuestaCorteCaja["concepto"] == "CIERRE DE CAJA") {

                        $itemCorteCierre = "concepto";
                        $valorCorteCierre = "CIERRE DE CAJA";

                        $itemCorteCierre2 = "fecha";
                        $valorCorteCierre2 = date("Y-m-d");

                        $respuestaCorteCajaCierre = ControladorCorteCaja::ctrMostrarInicioCaja($itemCorteCierre, $valorCorteCierre, $itemCorteCierre2, $valorCorteCierre2);

                        echo '<tr>';
                          echo '<td>'.$contadorHistorialPagos.'</td>';
                          echo '<td>'.$respuestaCorteCajaCierre["fecha"].'</td>';
                          echo '<td>'.$respuestaCorteCajaCierre["nombre"].'</td>';
                          echo '<td>'.$respuestaCorteCajaCierre["concepto"].'</td>';
                          echo '<td>$ '.number_format($respuestaCorteCajaCierre["ingresos"],2).'</td>';

                        echo '</tr>';
                      }*/
                  ?>
                  <tr>
                    <td colspan="5" style="text-align: right;"><strong>TOTAL: </strong></td>
                    <td><strong><?php echo "$ ".number_format($ingresosTotales,2); ?></strong></td>
                  </tr>
                  <input type="hidden" name="id_cliente" value="<?php echo $_SESSION["id"]; ?>">
                  </tbody>
              </table>
              <!-- EGRESOS CORTE DEL DÍA -->
                <div class="form-title text-center">
                  <h4>EGRESOS</h4>
                </div>
               <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                  <thead>
                   <tr>
                     <th width="5%">#</th>
                     <th width="20%">Fecha</th>
                     <th width="20%">Usuario</th>
                     <th width="20%">Proveedor</th>
                     <th width="20%">Concepto</th>
                     <th width="15%">Importe</th>
                   </tr> 
                  </thead>
                  <tbody>
                  <?php 

                    $item = "fecha";
                    $valor = date("Y-m-d");

                    $sumaEgresos = 0;

                    $contadorEgresos = 1;

                    $respuestaCajaEgresos = ControladorCorteCaja::ctrMostrarCajaEgresos($item, $valor);

                    foreach ($respuestaCajaEgresos as $keyCajaEgresos => $valueCajaEgresos){

                      echo '<tr>';
                        echo '<td>'.$contadorEgresos.'</td>';
                        echo '<td>'.$valueCajaEgresos["fechaCompra"].'</td>';
                        echo '<td>'.$valueCajaEgresos["nombreUsuario"].'</td>';
                        echo '<td>'.$valueCajaEgresos["nombreProveedor"].'</td>';
                        echo '<td>'.$valueCajaEgresos["descripcionCompra"].'</td>';
                        echo '<td>$ '.number_format($valueCajaEgresos["gasto"],2).'</td>';

                      echo '</tr>'; 

                      $sumaEgresos += $valueCajaEgresos["gasto"];

                      //CONTADOR PARA CONSECUTIVOS EN TABLA
                      $contadorEgresos= $contadorEgresos + 1;


                    }

                    //INGRESOS NETOS
                    $totalIngresos = $ingresosTotales - $sumaEgresos;
                  ?>
                  <tr>
                    <td colspan="5" style="text-align: right;"><strong>TOTAL: </strong></td>
                    <td><strong><?php echo "$ ".number_format($sumaEgresos,2); ?></strong></td>
                  </tr>
                  <input type="hidden" name="id_cliente" value="<?php echo $_SESSION["id"]; ?>">
                  </tbody>
              </table>
              <div class="row border rounded-circle">
                <div class="col-sm">
                </div>
                <div class="col-sm" style="text-align: center; background-color: lightgray;">
                  <strong>INGRESOS NETOS</strong>
                </div>
                <div class="col-sm" style="text-align: center; background-color: lightgray;">
                  <strong><?php echo "$ ".number_format($totalIngresos,2); ?></strong>
                </div>
                <div class="col-sm">
                </div>
              </div>
          </div>
        </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btnPrint"><i class="fa fa-print"></i> Imprimir</button>  
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

 <!--=====================================
MODAL CIERRE DE CAJA
======================================-->
<div id="modalCierreCaja" class="modal fade" role="dialog">  
      <div class="modal-dialog">  
   <!-- Modal content-->  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Cierre de caja</h4>  
                </div>  
                <div class="modal-body"> 
                   <table class="table table-bordered table-striped" width="100%">
                      <thead>
                       <tr>
                         <th>Fecha</th>
                         <th>Usuario</th>
                         <th>Total ingresos</th>
                         <th>Total egresos</th>
                         <th>Total en caja</th>
                       </tr> 
                      </thead>
                      <tbody>
                      <?php 

                          echo '<tr>';
                            echo '<td>'.$valor.'</td>';
                            echo '<td>'.$_SESSION["nombre"].'</td>';
                            echo '<td>$ '.number_format($ingresosTotales,2).'</td>';
                            echo '<td>$ '.number_format($sumaEgresos,2).'</td>';
                            echo '<td>$ '.number_format($totalIngresos,2).'</td>';

                          echo '</tr>'; 
                      ?>
                      <input type="hidden" name="id_cliente" value="<?php //echo $_SESSION["id"]; ?>">
                      </tbody>
                  </table> 
                    <?php

                      $cierreCaja = new ControladorCorteCaja();
                      $cierreCaja -> ctrIngresarCorteCaja();

                    ?>
                </div> 
                <div class="modal-footer accesos">
                  <form role="form" method="post">

                      <!-- ENTRADA CONCEPTO -->
                      <input type="hidden" name="concepto" value="CIERRE DE CAJA">
                      <input type="hidden" name="caja" value="1">
                      <input type="hidden" name="id_vendedor" value="<?php echo $_SESSION["id"]; ?>">
                      <input type="hidden" name="id_historial" value="<?php echo $_SESSION["id"]; ?>">
                      <input type="hidden" name="cobrado" value="<?php echo $ingresosTotales; ?>">
                      <input type="hidden" name="faltante" value="<?php echo $sumaEgresos; ?>">
                      <input type="hidden" name="balance" value="<?php echo $totalIngresos; ?>">

                      <br />  
                      <button type="submit" class="btn btn-primary btnAccesosCorteCaja">Realizar corte</button>  
                  </form>
                </div> 
           </div>  
      </div>  
 </div> 


 <!--=====================================
MODAL DETALLES CORTE CAJA
======================================-->
<div id="modalDetallesCorteCaja" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!--=====================================
      CABEZA DEL MODAL
      ======================================-->
      <div id="printThisHistorico">

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        
        <div id="responsecontainer" align="center"></div>
          
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnPrintHistorico"><i class="fa fa-print"></i> Imprimir</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>