<?php

/*if($_SESSION["perfil"] == "Especial"){

  echo '<script>
          window.location = "inicio";
        </script>';

  return;

}

$xml = ControladorVentas::ctrDescargarXML();

if($xml){

  rename($_GET["xml"].".xml", "xml/".$_GET["xml"].".xml");

  echo '<a class="btn btn-block btn-success abrirXML" archivo="xml/'.$_GET["xml"].'.xml" href="ventas">Se ha creado correctamente el archivo XML <span class="fa fa-times pull-right"></span></a>';

}*/
?>
<div class="content-wrapper">

  <section class="content-header">
    <h1>Soporte Técnico</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Crear tickets</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAltaTickets">Nuevo ticket</button>
         <!--<button type="button" class="btn btn-default pull-right" id="daterange-btn">  
            <span>
              <i class="fa fa-calendar"></i> 

              <?php

                /*if(isset($_GET["fechaInicial"])){
                  echo $_GET["fechaInicial"]." - ".$_GET["fechaFinal"];
                }else{
                  echo 'Rango de fecha';  
                }*/

              ?>
            </span>
            <i class="fa fa-caret-down"></i>
         </button>-->
      </div>

      <div class="box-body">
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
        <thead>
         <tr>
           <th>#</th>
           <th>Folio</th>
           <th>Título</th>
           <th>Asunto</th>
           <th>Descripción</th>
           <th>Prioridad</th>
           <th>Fecha de creación</th>
           <th>Fecha de modificación</th>
           <th>Estado</th>
           <th>Acciones</th>
         </tr> 
        </thead>

        <tbody>

        <?php

          if(isset($_GET["fechaInicial"])){

            $fechaInicial = $_GET["fechaInicial"];
            $fechaFinal = $_GET["fechaFinal"];

          }else{

            $fechaInicial = null;
            $fechaFinal = null;

          }

          $respuesta = ControladorTickets::ctrRangoFechasTickets($fechaInicial, $fechaFinal);

          foreach ($respuesta as $key => $value){
          ?>
           
          <tr>

            <td><?php echo $value["id"]; ?></td>
            <td><?php echo $value["folio"]; ?></td>
            <td><?php echo $value["titulo"]; ?></td>
            <td><?php echo $value["asunto"]; ?></td>
            <td><?php echo $value["descripcion"]; ?></td>
            <?php

            $itemPrioridad = "id";
            $valorPrioridad = $value["id_prioridad"];

            $respuestaPrioridad = ControladorPrioridad::ctrMostrarPrioridad($itemPrioridad, $valorPrioridad);

            if($valorPrioridad == "1"){

              echo '<td><button class="btn btn-danger btn-xs text-center">'.$respuestaPrioridad["nombre"].'</button></td>';
            }else{
              echo '<td><button class="btn btn-warning btn-xs text-center">'.$respuestaPrioridad["nombre"].'</button></td>';
            }
            ?>
            <td><?php echo $value["fecha_alta"]; ?></td>
            <td><?php echo $value["fecha_modificacion"]; ?></td>
            <?php 
            if ($value["status"] == "Pendiente") {

              echo '<td><button class="btn btn-danger btn-xs text-center">'.$value["status"].'</button></td>';
              
            }else{

              echo '<td><button class="btn btn-warning btn-xs text-center">'.$value["status"].'</button></td>';

            }
            ?>
            <td>
              <div class="btn-group">
                <button class="btn btn-primary " idTicket="<?php echo $value["id"]; ?>"><i class="far fa-eye"></i></button>
                <button class="btn btn-warning btnEditarTickets" idTicket="<?php echo $value["id"]; ?>" data-toggle="modal" data-target="#modalEditarTickets"><i class="fas fa-edit"></i></button>
                <?php

              //if($_SESSION["perfil"] == "Administrador"){

              echo '<button class="btn btn-danger btnEliminarTickets" idTicket="'.$value["id"].'"><i class="fa fa-times"></i></button>';

              //} 
              ?>
              </div>  
            </td>

          </tr>
          <?php
            }
        ?>
        </tbody>
       </table>
       <?php

        //$eliminarTicket = new ControladorTickets();
        //$eliminarTicket -> ctrEliminarTickets();

      ?>
      </div>
    </div>
  </section>
</div>

<!--=====================================
MODAL AGREGAR TICKETS
======================================-->
<div id="modalAltaTickets" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#011e41; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Nuevo ticket de soporte</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!--=====================================
                ENTRADA DEL TÍTULO
                ======================================--> 
            <div class="col-md-12">
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-ticket"></i></span>
                    <input type="text" class="form-control input-lg" name="titulo" id="titulo" placeholder="Título" required>
                  </div>
                </div>
            </div>
            <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 
              <div class="col-md-12">
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                    <?php
                    $item = null;
                    $valor = null;
                    $tickets = ControladorTickets::ctrMostrarTickets($item, $valor);

                    if(!$tickets){

                      echo '<input type="text" class="form-control" id="folio" name="folio" value="1001" readonly>';
                  
                    }else{

                      foreach ($tickets as $key => $value) {
                          
                      }
                      $folio = $value["folio"] + 1;

                      echo '<input type="text" class="form-control" id="folio" name="folio" value="'.$folio.'" readonly>';
                    }
                    ?>
                  </div>
                </div>
              </div>
            <!--=====================================
                ENTRADA DEL ASUNTO
                ======================================--> 
            <div class="col-md-12">
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="text" class="form-control input-lg" name="asunto" id="asunto" placeholder="Asunto" required>
                  </div>
                </div>
            </div>
            <!--=====================================
                ENTRADA DEL PRIORIDAD
                ======================================--> 
            <div class="col-md-12">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-exclamation"></i></span>
                  <select class="form-control input-lg" id="seleccionarPrioridad" name="seleccionarPrioridad" required>
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
                  <input type="hidden" name="seleccionarStatus" id="seleccionarStatus" value="Pendiente">
                </div>
              </div>
            </div>
           <!--=====================================
              ENTRADA DE DESCRIPCIÓN
              ======================================--> 
            <div class="col-md-12">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <textarea name="descripcion" class="form-control" rows="5"  placeholder="Descripción"></textarea>
                </div>
              </div>  
            </div> 
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar ticket</button>
        </div>
      </form>

      <?php
        $crearTicket = new ControladorTickets();
        $crearTicket -> ctrCrearTickets();
      ?>
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR TICKETS
======================================-->
<div id="modalEditarTickets" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#011e41; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!--=====================================
                ENTRADA DEL TÍTULO
                ======================================--> 
            <div class="col-md-12">
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-ticket"></i></span>
                    <input type="text" class="form-control input-lg" name="editarTitulo" id="editarTitulo" required>
                  </div>
                </div>
            </div>
            <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 
              <div class="col-md-12">
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                    <input type="text" class="form-control" id="editarFolio" name="editarFolio" value="1001" readonly>
                  </div>
                </div>
              </div>
            <!--=====================================
                ENTRADA DEL ASUNTO
                ======================================--> 
            <div class="col-md-12">
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="text" class="form-control input-lg" name="editarAsunto" id="editarAsunto" placeholder="Asunto" required>
                  </div>
                </div>
            </div>
            <!--=====================================
                ENTRADA DEL PRIORIDAD
                ======================================--> 
            <div class="col-md-12">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-exclamation"></i></span>
                  <select class="form-control input-lg" id="editarPrioridad" name="editarPrioridad" required>
                    <option value="">Seleccionar Prioridad</option>
                    <?php
                    /*$item1 = null;
                    $valor1 = null;

                    $prioridad = ControladorPrioridad::ctrMostrarPrioridad($item1, $valor1);

                     foreach ($prioridad as $key1 => $value1) {
                    ?>
                        <option value="<?php echo $value1["id"]; ?>"><?php echo $value1["nombre"]; ?></option>
                    <?php
                     }*/
                  ?>
                  </select>
                  <input type="hidden" name="editarStatus" id="editarStatus" value="Pendiente">
                </div>
              </div>
            </div>
           <!--=====================================
              ENTRADA DE DESCRIPCIÓN
              ======================================--> 
            <div class="col-md-12">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <textarea name="editarDescripcion" id="editarDescripcion" class="form-control" rows="5"  placeholder="Descripción"></textarea>
                </div>
              </div>  
            </div> 
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar ticket</button>
        </div>
      </form>

      <?php
        //$crearTicket = new ControladorTickets();
        //$crearTicket -> ctrCrearTickets();
      ?>
    </div>
  </div>
</div>