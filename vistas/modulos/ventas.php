<?php

  if($_SESSION["perfil"] == "Asistente"){

    $itemCorte = "concepto";
    $valorCorte = "INICIO DE CAJA";

    $itemCorte2 = "fecha";
    $valorCorte2 = date("Y-m-d");

    $respuestaCorteCaja = ControladorCorteCaja::ctrMostrarInicioCaja($itemCorte, $valorCorte, $itemCorte2, $valorCorte2);

      if($respuestaCorteCaja["concepto"] != "INICIO DE CAJA"){
        
        echo'<script>
                swal({
                type: "error",
                title: "La caja no ha sido iniciada",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
              }).then(function(result){
                if (result.value) {
                  window.location = "corte-caja";
                }
              })
             </script>';
  
      return;

    }
  }

?>
<div class="content-wrapper">

  <section class="content-header">
    <h1>Administrar ODT</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar ODT</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <!--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalCorteDeCaja">Corte de caja</button>-->
        <a href="crear-venta"><button class="btn btn-primary">Crear ODT</button></a>
        <button class="btn btn-success" data-toggle="modal" data-target="#modalAltaCliente">Agregar Doctor</button>
         <button type="button" class="btn btn-default pull-right" id="daterange-btnVentas">  
            <span>
              <i class="fa fa-calendar"></i> 

              <?php

                if(isset($_GET["fechaInicialVenta"])){
                  echo $_GET["fechaInicialVenta"]." - ".$_GET["fechaFinalVenta"];
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
           <th>Folio</th>
           <th>Doctor</th>
           <th>Paciente</th>
           <th>Prioridad</th>
           <th>Usuario</th>
           <th>Forma de pago</th> 
           <th>Total</th>
           <th>Ultimo combrado</th>
           <th>Pendiente</th>
           <th>Estado de pago</th>
           <th>Fecha de operación</th>
           <th>Acciones</th>
         </tr> 
        </thead>

        <tbody>

        <?php

          if(isset($_GET["fechaInicialVenta"])){

            $fechaInicialVenta = $_GET["fechaInicialVenta"];
            $fechaFinalVenta = $_GET["fechaFinalVenta"];

          }else{

            $fechaInicialVenta = date("Y-m-d");
            $fechaFinalVenta = null;

          }


          $respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicialVenta, $fechaFinalVenta);

          foreach ($respuesta as $key => $value){
           
           echo '<tr>
                  <td>'.$value["codigo"].'</td>';

                  $itemCliente = "id";
                  $valorCliente = $value["id_cliente"];

                  $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                  echo '<td>'.$respuestaCliente["nombre"].'</td>';

                  $itemHistorial = "id";
                  $valorHistorial = $value["id_historial"];
                  
                  $respuestaHistorial = ControladorHistorial::ctrMostrarHistorial($itemHistorial, $valorHistorial);

                  echo '<td>'.$respuestaHistorial["paciente"].'</td>';

                  $itemPrioridad = "id";
                  $valorPrioridad = $value["id_prioridad"];

                  $respuestaPrioridad = ControladorPrioridad::ctrMostrarPrioridad($itemPrioridad, $valorPrioridad);

                  
                  if($valorPrioridad == "1"){

                    echo '<td><button class="btn btn-danger btn-xs text-center">'.$respuestaPrioridad["nombre"].'</button></td>';
                  }else{
                    echo '<td><button class="btn btn-warning btn-xs text-center">'.$respuestaPrioridad["nombre"].'</button></td>';
                  }
                
                  $itemUsuario =  "id";
                  $valorUsuario = $value["id_vendedor"];


                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                  echo '<td>'.$respuestaUsuario["nombre"].'</td>
                        <td>'.$value["metodo_pago"].'</td>';

                  echo '<td>$'.number_format($value["total"],2).'</td>
                        <td>$'.number_format($respuestaHistorial["cobrado"],2).'</td>
                        <td>$'.number_format($respuestaHistorial["faltante"],2).'</td>';

                 /* if($value["status"] != 1){
                      
                      echo '<td><button class="btn btn-success btn-xs active" idVenta="'.$value["id"].'" estadoVentas="2">Pagado</button></td>';

                      }else{

                      echo '<td><button class="btn btn-danger btn-xs active" idVenta="'.$value["id"].'" estadoVentas="1">Pendiente</button></td>';            
                      }*/

                  if($respuestaHistorial["faltante"] == 0){
                  
                  echo '<td><button class="btn btn-success btn-xs active" idVenta="'.$value["id"].'" estadoVentas="2">Pagado</button></td>';

                  }else{

                  echo '<td><button class="btn btn-danger btn-xs active" idVenta="'.$value["id"].'" estadoVentas="1">Pendiente</button></td>';            
                  }

                  echo '<td>'.$respuestaHistorial["fecha"].'</td>

                  <td>
                    <div class="btn-group">
                        <button class="btn btn-primary btnFormatopago" idVenta="'.$value["id"].'"><i class="far fa-eye"></i></button>
                        <button class="btn btn-warning btnEditarVenta" idVenta="'.$value["id"].'"><i class="fas fa-edit"></i></button>';

                      if($_SESSION["perfil"] == "Administrador"){

                      echo '<button class="btn btn-danger btnEliminarVenta" idVenta="'.$value["id"].'"><i class="fa fa-times"></i></button>';

                    }
                    echo '</div>  
                  </td>
                </tr>';
            }
        ?>
        </tbody>
       </table>
       <?php

        $eliminarVenta = new ControladorVentas();
        $eliminarVenta -> ctrEliminarVenta();

      ?>
      </div>
    </div>
  </section>
</div>


<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->
<div id="modalAltaCliente" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#011e41; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Doctor</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Información fiscal</h3>
            </div>
          </div>

          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="nuevoCliente" id="nuevoCliente" placeholder="Nombre del Doctor" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                <input type="text" class="form-control input-lg" name="nuevoRfc" id="nuevoRfc" placeholder="RFC"  id="campo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                <input type="text" class="form-control input-lg" name="nuevaRazonSocial" placeholder="Razon social">
                </div>
              </div>
            </div>

            <div class="box-header with-border">
              <h3 class="box-title">Dirección</h3>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Dirección" required>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="nuevaColonia" placeholder="Colonia" required>
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                  <input type="numer" class="form-control input-lg" name="nuevoCP" placeholder="Codigo Postal" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="nuevoMunicio" placeholder="Alcaldia o municipio" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="nuevaEntidad" placeholder="Estado o entidad" require>
                </div>
              </div>

            </div>
            </div>  
            <div class="box-header with-border">
              <h3 class="box-title">Información de contacto</h3>
            </div>

            <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Numero Teléfonico" data-inputmask="'mask': ['999-999-9999 [x99999]', '+52 99 99 9999[9]-9999']" data-mask>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                <input type="email" class="form-control input-lg" name="nuevoEmail" placeholder="Correo">
                </div>
              </div>
            </div>

          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar cliente</button>
        </div>
      </form>

      <?php
        $crearCliente = new ControladorClientes();
        $crearCliente -> ctrCrearClienteVentas();
      ?>
    </div>
  </div>
</div>
