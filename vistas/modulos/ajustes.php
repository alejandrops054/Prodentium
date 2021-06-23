<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Ajustes
        <small>Vista previa</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Ajustes</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Información de la empresa</h3>


          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              

                <?php 
                    $item = null;
                    $valor = null;

                    $respuesta = ControladorAjustes::ctrMostrarAjusteControlador($item, $valor);

                    foreach($respuesta as $key => $value){

                        echo'<div class="form-group">
                                <img src="'.$value["logo"].'" width=”100” height="100"  walt=""></br>
                                <strong>Empresa: </strong> '.$value["empresa"].'</br>
                                <strong>Direccón (Calle y número): </strong>'.$value["direccion"].'</br>
                                <strong>Colonia: </strong>'.$value["colonia"].'</br>
                                <strong>Codigo postal: </strong>'.$value["cp"].'</br>
                                <strong>Acaldía: </strong>'.$value["alcaldia"].'</br>
                                <strong>Estado: </strong>'.$value["estado"].'</br>
                                <strong>Numero télefonico: </strong>'.$value["telefono"].'</br>
                                <strong>Correo: </strong>'.$value["correo"].'</br>
                            </div>

                             <div class="box-header with-border">
                                <button class="btn btn-warning btnEditarEmpresa" data-toggle="modal" data-target="#modalEditarAjustes" idAjustes="'.$value["id"].'"><i class="fa fa-pencil"></i></button>
                             </div>
                            ';
                        }
                    ?>
            </div>
          </div>
        </div>
      </div>
  </section>
</div>
 
<!--Editar ajustes -->
<div id="modalEditarAjustes" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#011e41; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar información de la empresa</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Información</h3>
            </div>
          </div>

          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                <input type="text" class="form-control input-lg" name="editarEmpresa" id="editarEmpresa" placeholder="Empresa" required>
                <input type="hidden" id="idAjustes" name="idAjustes">
                </div>
              </div>

            </div>

            <div class="box-header with-border">
              <h3 class="box-title">Dirección </h3>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="editarDireccion" id="editarDireccion" placeholder="Dirección (calle y número)" required>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="editarColonia" id="editarColonia" placeholder="Colonia" required>
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                  <input type="numer" class="form-control input-lg" name="editarCp" id="editarCp" placeholder="Codigo Postal" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="editarAlcaldia" id="editarAlcaldia" placeholder="Alcaldia o municipio" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="editarEstado" id="editarEstado" placeholder="Estado o entidad" require>
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
                  <input type="text" class="form-control input-lg" name="editarTelefono" id="editarTelefono"  placeholder="Télefono" data-inputmask="'mask':'(999) 999-9999'" data-mask required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <input type="email" class="form-control input-lg" name="editarCorreo" id="editarCorreo" placeholder="Correo" required>
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
        $editarAjustes = new ControladorAjustes();
        $editarAjustes -> ctrEditarAjustes();
      ?>

    </div>
  </div>
</div>