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
    <h1>Crear ODT</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Crear ODT</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm">
      <!--=====================================
      EL FORMULARIO
      ======================================-->
      <div class="col-lg-5 col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border"></div>
          <form role="form" method="post" class="formularioVenta">
            <div class="box-body">
              <div class="box">
                <!--=====================================
                ENTRADA DEL VENDEDOR
                ======================================-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                    <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
                    <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">
                  </div>
                </div> 
                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <?php
                    
                    $item = null;
                    $valor = $_GET["idVenta"];

                    $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);

                    if(!$ventas){

                      echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="10001" readonly>';
                  
                    }else{

                      foreach ($ventas as $key => $value) {
                          
                      }
                      $codigo = $value["codigo"] + 1;

                      echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="'.$codigo.'" readonly>';
                    }
                    ?>
                  </div>
                </div>
                <!--=====================================
                ENTRADA DEL DOCTOR
                ======================================--> 
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    <select class="form-control" id="seleccionarCliente" name="seleccionarCliente" required>
                    <option value="">Seleccionar Doctor</option>
                    <?php
                      $item = null;
                      $valor = null;

                      $categorias = ControladorClientes::ctrMostrarClientes($item, $valor);

                       foreach ($categorias as $key => $value) {

                         echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                       }
                    ?>
                    </select>
                  </div>
                </div>
                <!--=====================================
                ENTRADA DEL PACIENTE
                ======================================--> 
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input class="form-control" type="text" id="nuevoPaciente" name="nuevoPaciente" placeholder="Nombre del paciente">
                  </div>
                </div>
                <!--=====================================
                ENTRADA DEL PRIORIDAD
                ======================================--> 
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-exclamation"></i></span>
                    <select class="form-control" id="seleccionarPrioridad" name="seleccionarPrioridad" required>
                      <option value="">Seleccionar Prioridad</option>
                      <?php
                      $item1 = null;
                      $valor1 = null;

                      $prioridad = ControladorPrioridad::ctrMostrarPrioridad($item1, $valor1);

                       foreach ($prioridad as $key1 => $value1) {
                      ?>
                          <option value="<?php echo $value1["id"]; ?>"><?php echo $value1["nombre"]; ?></option>
                      <?php
                       }
                    ?>
                    </select>
                    <input type="hidden" name="seleccionarStatus" id="seleccionarStatus" value="1">
                  </div>
                </div>
                <!--=====================================
                ENTRADA DEL AREA DE NOTA
                ======================================--> 
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                    <textarea class="form-control" id="nuevaNota" name="nuevaNota" rows="5" placeholder="Escribir nota"></textarea>
                  </div>
                </div>
                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================--> 
                <div class="form-group row nuevoProducto"></div>
                <input type="hidden" id="listaProductos" name="listaProductos">
                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->
                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar ODT</button>
                <hr>
                <div class="row">
                  <!--=====================================
                  ENTRADA IMPUESTOS Y TOTAL
                  ======================================-->
                  <div class="col-xs-8 pull-right">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Impuesto</th>
                          <th>Total</th>      
                        </tr>

                      </thead>
                      <tbody>
                        <tr>
                          <td style="width: 50%">
                            <div class="input-group">
                              <input type="number" class="form-control input-lg" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" placeholder="0" required>
                               <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" required>
                               <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" required>
                              <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                            </div>

                          </td>
                          <td style="width: 50%">

                            <div class="input-group">
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                              <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" total="" placeholder="00000" readonly required>
                              <input type="hidden" name="totalVenta" id="totalVenta">
                            </div>

                          </td>
                        </tr>
                      </tbody>

                    </table>
                  </div>
                </div>
                <hr>
                <!--=====================================
                ENTRADA MÉTODO DE PAGO
                ======================================-->

                <div class="form-group row">
                  <div class="col-xs-6" style="padding-right:0px">
                     <div class="input-group">
                      <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago" required>
                        <option value="">Seleccione método de pago</option>
                        <option value="Financiamiento">Financiamiento</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta Crédito">Tarjeta Crédito</option>
                        <option value="Tarjeta Débito">Tarjeta Débito</option>
                        <option value="Transferencia">Transferencia</option>                  
                      </select>    
                    </div>
                  </div>

                  <div class="cajasMetodoPago"></div>
                  <input type="hidden" id="listaMetodoPago" name="listaMetodoPago">
                </div>
                <br>
              </div>

          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right">Guardar ODT</button>
          </div>
        </form>
        <?php

          $guardarVenta = new ControladorVentas();
          $guardarVenta -> ctrCrearVenta();
          
        ?>

        </div> 
      </div>
    </div>
    <div class="col-sm">
      <!--=====================================
      LA TABLA DE PRODUCTOS
      ======================================-->

      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
        <div class="box box-warning">
          <div class="box-header with-border"></div>
          <div class="box-body">
        
            <table class="table table-bordered table-striped dt-responsive tablaVentas">      
               <thead>
                 <tr>
                  <th style="width: 10px">#</th>
                  <th>Imagen</th>
                  <th>Descripción</th>
                  <th>Precio</th>
                  <!--<th>Stock</th>-->
                  <th>Acciones</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>

      </div>
    </div>
    </div>
  </section>
</div>

