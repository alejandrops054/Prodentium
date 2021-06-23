<?php

if($_SESSION["perfil"] == "Asistente"){

  echo '<script>
          window.location = "ventas";
        </script>';
  return;

}
?>
<div class="content-wrapper">

  <section class="content-header">
    <h1>Bienvenid@<small>Panel de Control</small></h1>

    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Tablero</li>
    </ol>
  </section>

  <section class="content">
    
    <div class="row">
    <?php
      include "inicio/cajas-superiores.php";
    ?>
    </div> 

     <div class="row">   
        <div class="col-lg-6">
          <?php
           include "reportes/grafico-ventas.php";
          ?>
        </div>
        <div class="col-lg-6">
          <?php 
              include "reportes/grafico-compras.php";
           ?>
        </div>
     </div>

  </section>
</div>
