<?php

if($_SESSION["perfil"] == "Asistente"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Administrar doctores</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar doctores</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">Agregar doctor</button>
      </div>

      <div class="box-body">
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
        <thead>
         <tr>
           
           <th style="width:10px">#</th>
           <th>Nombre</th>
           <th>Razón social</th>
           <th>RFC</th>
           <th>Dirección</th>
           <th>Colonia</th>
           <th>Alcaldía</th>
           <th>C.P.</th> 
           <th>Estado</th>
           <th>Email</th>
           <th>Teléfono</th>
           <th>Total ODTs</th>
           <th>Última ODT</th>
           <th>Alta en sistema</th>
           <th>Acciones</th>

         </tr> 
        </thead>
        <tbody>

        <?php

          $item = null;
          $valor = null;

          $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);

          foreach ($clientes as $key => $value) {
            echo '<tr>
                    <td>'.($key+1).'</td>
                    <td>'.$value["nombre"].'</td>
                    <td>'.$value["razon_social"].'</td>
                    <td>'.$value["rfc"].'</td>
                    <td>'.$value["direccion"].'</td>
                    <td>'.$value["colonia"].'</td>
                    <td>'.$value["municipio"].'</td>
                    <td>'.$value["cp"].'</td>
                    <td>'.$value["entidad"].'</td>
                    <td>'.$value["email"].'</td>
                    <td>'.$value["telefono"].'</td>        
                    <td>'.$value["compras"].'</td>
                    <td>'.$value["ultima_compra"].'</td>
                    <td>'.$value["fecha"].'</td>
                    <td>

                      <div class="btn-group">   
                        <button class="btn btn-warning btnEditarCliente" data-toggle="modal" data-target="#modalEditarCliente" idCliente="'.$value["id"].'"><i class="fas fa-user-edit"></i></button>';

                      if($_SESSION["perfil"] == "Administrador"){

                          echo '<button class="btn btn-danger btnEliminarCliente" idCliente="'.$value["id"].'"><i class="fas fa-user-times"></i></button>';

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
<div id="modalAgregarCliente" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#011e41; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar doctor</h4>
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
                <input type="text" class="form-control input-lg" name="nuevaRazonSocial" placeholder="Razon Social">
                </div>
              </div>
            </div>

            <div class="box-header with-border">
              <h3 class="box-title">Dirección</h3>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Dirección (Calle y número)">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="nuevaColonia" placeholder="Colonia" >
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                  <input type="numer" class="form-control input-lg" name="nuevoCP" placeholder="Codigo Postal">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="nuevoMunicio" placeholder="Alcaldia o municipio">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="nuevaEntidad" placeholder="Estado o entidad">
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
        $crearCliente -> ctrCrearCliente();
      ?>
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR CLIENTE
======================================-->

<div id="modalEditarCliente" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar doctor</h4>
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
                <input type="text" class="form-control input-lg" name="editarCliente" id="editarCliente" required>
                <input type="hidden" id="idCliente" name="idCliente">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                <input type="text" class="form-control input-lg" name="editarRfc" id="editarRfc" placeholder="RFC"  id="campo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                <input type="text" class="form-control input-lg" name="editarRazonSocial" id="editarRazonSocial" placeholder="Razon social">
                </div>
              </div>
            </div>

            <div class="box-header with-border">
              <h3 class="box-title">Dirección fiscal</h3>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="editarDireccion" id="editarDireccion"  required>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="editarColonia" id="editarColonia" placeholder="Colonia" required>
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                  <input type="numer" class="form-control input-lg" name="editarCP" id="editarCP" placeholder="Codigo Postal" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="editarMunicio" id="editarMunicio" placeholder="Alcaldia o municipio" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="editarEntidad" id="editarEntidad" placeholder="Estado o entidad" require>
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
                  <input type="text" class="form-control input-lg" name="editarTelefono" id="editarTelefono" data-inputmask="'mask':'(999) 999-9999'" data-mask required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <input type="email" class="form-control input-lg" name="editarEmail" id="editarEmail" required>
                </div>
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
        $editarCliente = new ControladorClientes();
        $editarCliente -> ctrEditarCliente();
      ?>

    </div>
  </div>
</div>

<?php

  $eliminarCliente = new ControladorClientes();
  $eliminarCliente -> ctrEliminarCliente();

?>


