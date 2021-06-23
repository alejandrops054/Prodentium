<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>
            window.location = "inicio";
        </script>';

  return;
}

?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>Administrar proveedores</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar proveedores</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProveedor">Agregar proveedor</button>

      </div>

      <div class="box-body">
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
        <thead>
         <tr>
           <th style="width:10px">#</th>
           <th>Empresa</th>
           <th>Nombre del ejecutivo</th>
           <th>Email</th>
           <th>Teléfono</th>
           <th>Descripción</th>
           <th>Fecha de alta</th>
           <th>Acciones</th>
         </tr> 
        </thead>
        <tbody>

        <?php

          $item = null;
          $valor = null;

          $proveedor = ControladorProveedor::ctrMostrarProveedor($item, $valor);

          foreach ($proveedor as $key => $value) {
            

            echo '<tr>
                    <td>'.($key+1).'</td>
                    <td>'.$value["empresa"].'</td>
                    <td>'.$value["nombre"].'</td>
                    <td>'.$value["correo"].'</td>
                    <td>'.$value["telefono"].'</td>
                    <td>'.$value["descripcion"].'</td>             
                    <td>'.$value["fecha"].'</td>

                    <td>

                      <div class="btn-group">
                        <button class="btn btn-warning btnEditarProveedor" data-toggle="modal" data-target="#modalEditarProveedor" idProveedor="'.$value["id"].'"><i class="fa fa-pencil"></i></button>';

                      if($_SESSION["perfil"] == "Administrador"){

                          echo '<button class="btn btn-danger btnEliminarProveedor" idProveedor="'.$value["id"].'"><i class="fas fa-user-times"></i></button>';

                      }
                      echo '</div>  
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
MODAL AGREGAR CLIENTE
======================================-->

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
        $crearProveedor -> ctrCrearProveedor();
      ?>
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR PROVEEDOR
======================================-->

<div id="modalEditarProveedor" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar proveedor</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" name="editarEmpresa" id="editarEmpresa" value="" readonly>
                <input type="hidden" id="idProveedor" name="idProveedor"> 
              </div>
            </div>
            <!-- ENTRADA PARA EL DOCUMENTO ID -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 
                <input type="text" class="form-control input-lg" name="editarProveedo" id="editarProveedo" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL EMAIL -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" class="form-control input-lg" name="editarCorreo" id="editarCorreo" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL TELÉFONO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                <input type="text" class="form-control input-lg" name="editarTelefono" id="editarTelefono" required>
              </div>
            </div>
             <!-- ENTRADA PARA LA descripcion-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
                <input type="text" class="form-control in put-lg" name="editarDescripcion" id="editarDescripcion" required>
              </div>
            </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>

      <?php

        $editarProveedor = new ControladorProveedor();
        $editarProveedor -> ctrEditarProveedor();

      ?>
    </div>
  </div>
</div>
<?php

  $eliminarProveedor = new ControladorProveedor();
  $eliminarProveedor -> ctrBorrarProveedor();

?>


