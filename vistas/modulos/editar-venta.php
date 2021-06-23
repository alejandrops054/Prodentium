<div class="content-wrapper">

  <section class="content-header">
    <h1>Editar</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Crear venta</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">

      <!--=====================================
      EL FORMULARIO
      ======================================-->
      <div class="col-lg-5 col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border"></div>
          <form role="form" method="post" class="formularioVenta">
            <div class="box-body">
              <div class="box">
                <?php

                    $item = "ventas.id";
                    $valor = $_GET["idVenta"];

                    $venta = ControladorVentas::ctrMostrarVentas($item, $valor);

                    $itemUsuario = "id";
                    $valorUsuario = $venta[0]["id_vendedor"];

                    $vendedor = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                    $itemCliente = "id";
                    $valorCliente = $venta[0]["id_cliente"];

                    $cliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                    $porcentajeImpuesto = $venta[0]["impuesto"] * 100 / $venta[0]["neto"];

                    //Trae la prioridad del registro por venta
                    $itemPrioridadVenta = "id";
                    $valorPrioridadVenta = $venta[0]["id_prioridad"];

                    $prioridadVenta = ControladorPrioridad::ctrMostrarPrioridad($itemPrioridadVenta, $valorPrioridadVenta);

                    //Trae el status del pago de registro por venta
                    $itemHistorial = "id";
                    $valorHistorial = $venta[0]["id_historial"];

                    $historial = ControladorHistorial::ctrMostrarHistorial($itemHistorial, $valorHistorial);

                ?>

                <!--=====================================
                ENTRADA DEL VENDEDOR
                ======================================-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                    <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
                    <input type="hidden" name="idVendedor" value="<?php echo $vendedor["id"]; ?>">
                    <input type="hidden" name="id_ventas" value="<?php echo $_GET["idVenta"]; ?>">
                  </div>
                </div> 

                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                   <input type="text" class="form-control" id="editarVenta" name="editarVenta" value="<?php echo $venta[0]["codigo"]; ?>" readonly>
                  </div>
                </div>

                <!--=====================================
                ENTRADA DEL DOCTOR
                ======================================--> 

                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    <select class="form-control" id="seleccionarCliente" name="seleccionarCliente" required>
                    <option value="<?php echo $cliente["id"]; ?>"><?php echo $cliente["nombre"]; ?></option>

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
                ENTRADA DEL PRIORIDAD
                ======================================--> 
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-exclamation"></i></span>
                    <select class="form-control" id="seleccionarPrioridad" name="seleccionarPrioridad" required>
                      <option value="<?php echo $prioridadVenta['id']; ?>" selected><?php echo $prioridadVenta["nombre"]; ?></option>
                      <?php

                      $itemPrioridad = null;
                      $valorPrioridad = null;

                      $prioridad = ControladorPrioridad::ctrMostrarPrioridad($itemPrioridad, $valorPrioridad);

                      foreach ($prioridad as $keyPrioridad => $valuePrioridad) {
                      ?>
                          <option value="<?php echo $valuePrioridad["id"]; ?>"><?php echo $valuePrioridad["nombre"]; ?></option>
                      <?php
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
                    <input class="form-control" type="text" id="nuevoPaciente" name="nuevoPaciente" placeholder="Nombre del paciente." value="<?php echo $historial['paciente']; ?>">
                  </div>
                </div>
                <!--=====================================
                ENTRADA DEL AREA DE NOTA
                ======================================--> 
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                    <textarea class="form-control" id="nuevaNota" name="nuevaNota" rows="5" placeholder="Escribe una nota."><?php echo $venta[0]["nota"]; ?></textarea>
                  </div>
                </div>

                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================--> 

                <div class="form-group row nuevoProducto">

                <?php

                $listaProducto = json_decode($venta[0]["productos"], true);

                foreach ($listaProducto as $key => $value) {

                  $item = "id";
                  $valor = $value["id"];
                  $orden = "id";

                  $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

                  $stockAntiguo = $respuesta["stock"] + $value["cantidad"];
                  
                  echo '<div class="row" style="padding:5px 15px">
                        <div class="col-xs-6" style="padding-right:0px">
                          <div class="input-group">
                            <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'.$value["id"].'"><i class="fa fa-times"></i></button></span>
                            <input type="text" class="form-control nuevaDescripcionProducto" idProducto="'.$value["id"].'" name="agregarProducto" value="'.$value["descripcion"].'" readonly required>
                          </div>
                        </div>

                        <div class="col-xs-3">
                          <input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="'.$value["cantidad"].'" stock="'.$stockAntiguo.'" nuevoStock="'.$value["stock"].'" required>
                        </div>

                        <div class="col-xs-3 ingresoPrecio" style="padding-left:0px">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                            <input type="text" class="form-control nuevoPrecioProducto" precioReal="'.$respuesta["precio_venta"].'" name="nuevoPrecioProducto" value="'.$value["total"].'" readonly required>
                          </div>
                        </div>
                      </div>';
                }


                ?>

                </div>

                <input type="hidden" id="listaProductos" name="listaProductos">

                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->

                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>
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
                              <!--<input type="number" class="form-control input-lg" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" value="<?php //echo $porcentajeImpuesto; ?>" required>-->
                              <input type="number" class="form-control input-lg" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" value="0" required>
                               <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" value="<?php echo $venta[0]["impuesto"]; ?>" required>
                               <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" value="<?php echo $venta[0]["neto"]; ?>" required>
                              <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                            </div>
                          </td>

                           <td style="width: 50%">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                              <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" total="<?php echo $venta[0]["neto"]; ?>"  value="<?php echo $historial['faltante'];//$venta[0]["total"]; ?>" readonly required>
                              <input type="hidden" name="totalVenta" value="<?php echo $historial['faltante'];//$venta[0]["total"]; ?>" id="totalVenta">
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
            <button type="submit" class="btn btn-primary pull-right">Guardar cambios</button>
          </div>

        </form>

        <?php

          $editarVenta = new ControladorVentas();
          $editarVenta -> ctrEditarVenta();
          
        ?>

        </div>
      </div>

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
                  <!--<th>Código</th>-->
                  <th>Descripcion</th>
                  <!--<th>Stock</th>-->
                  <th>Acciones</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

