<?php

if($_SESSION["perfil"] == "Vendedor"){
  echo '<script>
          window.location = "inicio";
        </script>';
  return;
}

?>
<div class="content-wrapper">

  <section class="content-header">
    <h1>Administración de servicios</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administración de servicios</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">Agregar servicio</button>
      </div>

      <div class="box-body">
       <table class="table table-bordered table-striped dt-responsive tablaProductos" width="100%">
        <thead>
         <tr>
           
           <th style="width:10px">#</th>
           <th>Imagen</th>
           <th>Nombre</th>
           <th>Precio</th>
           <th>Fecha de alta</th>
           <th>Acciones</th>
           
         </tr> 
        </thead>      
       </table>
       <input type="hidden" value="<?php echo $_SESSION['perfil']; ?>" id="perfilOculto">
      </div>
    </div>
  </section>
</div>

<!--=====================================
MODAL AGREGAR PRODUCTO
======================================-->
<div id="modalAgregarProducto" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#011e41; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar servicio</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="far fa-folder-open"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevaDescripcion" placeholder="Ingresar servicio" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL EJECUTIVO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span> 
                <input type="text" class="form-control input-lg" id="nuevoPrecioVenta" name="nuevoPrecioVenta" step="any" min="0" placeholder="Precio de venta">
              </div>
            </div>

                        <!-- ENTRADA PARA SUBIR FOTO -->
            <div class="form-group">
              <div class="panel">SUBIR IMAGEN</div>
                <input type="file" class="nuevaImagen" name="nuevaImagen">
                <p class="help-block">Peso máximo de la imagen 2MB</p>
                <img src="" class="img-thumbnail previsualizar" width="100px">
              </div>

          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar servicios</button>
        </div>
      </form>
      <?php

        $crearProducto = new ControladorProductos();
        $crearProducto -> ctrCrearProducto();

      ?>  
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR PRODUCTO
======================================-->
<div id="modalEditarProducto" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#011e41; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar servicio</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <!--<class="box-body">-->
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="far fa-folder-open"></i></span> 
                <input type="text" class="form-control input-lg" id="editarDescripcion" name="editarDescripcion" required readonly> 
              </div>
            </div>
            <!-- ENTRADA PARA EL EJECUTIVO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span> 
                <input type="text" class="form-control input-lg" id="editarPrecioVenta" name="editarPrecioVenta" step="any" min="0" placeholder="Precio de venta">
              </div>
            </div>

                        <!-- ENTRADA PARA SUBIR FOTO -->
            <div class="form-group">
              <div class="panel">SUBIR IMAGEN</div>
                <input type="file" class="nuevaImagen" name="editarImagen">
                <p class="help-block">Peso máximo de la imagen 2MB</p>
                <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
                <input type="hidden" name="imagenActual" id="imagenActual">
            </div>
                  
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar cambios</button>
        </div>
      </form>
      <?php

        $editarProducto = new ControladorProductos();
        $editarProducto -> ctrEditarProducto();

      ?>  
    </div>
  </div>
</div>

<?php
  $eliminarProducto = new ControladorProductos();
  $eliminarProducto -> ctrEliminarProducto();
?>      



