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
    <h1>Control de gastos</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>     
      <li class="active">Controlador de gastos</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregarCompras">Registrar gasto</button>
        <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregarProveedor">Agregar proveedor</button>
        <?php 
            if(isset($_GET["fechaInicial"])){
                echo'<a href="vistas/modulos/descargar-reporte-gastos.php?compras=compras&fechaInicial='.$_GET["fechaInicial"].'&fechaFinal='.$_GET["fechaFinal"].'">';
              }else{

                }          
              echo'<button class="btn btn-primary">Descargar reporte en Excel</button></a>';   
          ?>  
        <button type="button" class="btn btn-default pull-right" id="gasto-btn">
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

      <!--indicamos que solo se puede enseñar el boton a ciertos perfiles -->
      <div class="box-body"> 

       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
        <thead>
         <tr>     
           <th style="width:10px">#</th>
           <th>Proveedor</th>
           <th>Usuarios</th>
           <th>Descripción</th>
           <th>Cantidad pagada</th>
           <th>Fecha de gasto</th>
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
          
          $ordenar =  "id";

          $compras = ControladorCompras::ctrRangoFechasCompras($fechaInicial, $fechaFinal,$ordenar);

          foreach ($compras as $key => $value) {
            
            //aregamos controladores proveedor 
            $itemProveedor = "id";
            $valorProveedor = $value["id_proveedor"];
            $proveedores = ControladorProveedor::ctrMostrarProveedor($itemProveedor, $valorProveedor);
            
            $itemUsuario = "id";
            $valorUsuario = $value["id_usuario"];
            $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
            
            echo '<tr>
                  <td>'.($key+1).'</td> 
                  <td class="text-uppercase">'.$proveedores["empresa"].'</td>
                  <td>'.$respuestaUsuario["nombre"].'</td>
                  <td class="text-uppercase">'.$value["descripcion"].'</td>
                  <td class="text-uppercase">$'.number_format($value["gasto"],2).'</td>
                  <td class="text-uppercase">'.$value["fecha"].'</td>
                
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-warning btnEditarCompras" idCompras="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarGasto"><i class="fa fa-file-text-o"></i></button>
                    </div>  
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
MODAL AGREGAR GASTOS
======================================-->
<div id="modalAgregarCompras" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">

        <div class="modal-header" style="background:#011e41; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Registrar gasto</h4>
        </div>

        <div class="modal-body">
          <div class="box-body">
            <div class="row">

              <div class="col-md-12">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="nuevaDescripcion" id="nuevaDescripcion" placeholder="Descripción de gasto">
                </div>
              </div>
 
              <div class="col-md-12">
                <div class="form-group">
                  <select class="form-control input-lg" name="seleccionarProveedor" id="seleccionarProveedor">
                    <option>Selecciona proveedor</option>
                    <?php 
                      $item = null;
                      $valor = null;

                      $proveedor = ControladorProveedor::ctrMostrarProveedor($item, $valor);
                      foreach ($proveedor as $key => $value){
                        echo '<option class="input-group-addon" value="'.$value["id"].'">'.$value["empresa"].'</option>';
                      }                   
                    ?>
                  </select>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <input type="number" class="form-control input-lg" name="IngresoDeGasto" placeholder="total">
                </div>
              </div>
            
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
              <button type="submit" class="btn btn-primary">Registrar gasto</button>
            </div>

          </form>
          
          <?php
            $crearGasto = new ControladorCompras();
            $crearGasto -> ctrCrearCompras();
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal editar gasto -->
<div id="modalEditarGasto" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" method="post">

        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar gasto</h4>
        </div>

        <div class="modal-body">
          <div class="box-body">
            <div class="row">

              <div class="col-md-12">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="editarDescripcion" id="editarDescripcion" placeholder="Descripción de gasto" value="">
                  <input type="hidden" id="idCompras" name="idCompras"> 
                </div>
              </div>
 
              <div class="col-md-12">
                <div class="form-group">
                  <select class="form-control input-lg" name="editarSeleccionarProveedor" id="editarSeleccionarProveedor">
                    <option value="" id="editarSeleccionarProveedor"></option>
                     <option value="#">Seleccione una opcion</option>
                    <?php 
                        echo '<option class="input-group-addon" value="'.$value["id"].'">'.$value["empresa"].'</option>';              
                    ?>
                  </select>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <input type="number" class="form-control input-lg" name="editarGasto" id="editarGasto" placeholder="total">
                </div>
              </div>
            
            </div>
          </div>
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
      </div>

      </form>
      <?php
        $EditarGasto = new ControladorCompras();
        $EditarGasto -> ctrEditarCompras();
      ?>
    </div>
  </div>
</div>

<!-- MODAL AGREGAR PROVEEDOR -->
<div id="modalAgregarProveedor" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#011e41; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar proveedor</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevaEmpresa" id="nuevaEmpresa" placeholder="Nombre de la empresa" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL EJECUTIVO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user-circle"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoProveedo" placeholder="Nombre del ejecutivo">
              </div>
            </div>
            <!-- ENTRADA PARA EL EMAIL -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 
                <input type="email" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar email">
              </div>
            </div>
            <!-- ENTRADA PARA EL TELÉFONO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                <input type="number" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar teléfono">
              </div>
            </div>

             <!-- ENTRADA PARA descripcion -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevaDescripcion" placeholder="Ingresar descripción">
              </div>
            </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar proveedor</button>
        </div>
      </form>
      <?php
        $crearProveedor = new ControladorProveedor();
        $crearProveedor -> ctrCrearProveedorGastos();
      ?>
    </div>
  </div>
</div>

<?php

  $eliminarGatos = new ControladorCompras();
  $eliminarGatos -> ctrBorrarCompras();

?>

