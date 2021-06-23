<?php

require_once "../controladores/corte-caja.controlador.php";
require_once "../modelos/corte-caja.modelo.php";

class AjaxCorteCaja{

	/*=============================================
	MOSTRAR DETALLES CORTE CAJA
	=============================================*/	

	public $id_corte;
	public $fecha;

	public function ajaxMostrarDetallesCaja(){

		//$item = "id";
		//$valor = $this->id_corte;

		

		echo '<div class="modal-header" style="background:#011e41; color:white">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title">Histórico Balance</h4>
        		</div>';

        echo '<div class="modal-body">
          		<div class="box-body">';

        echo '<div class="form-title text-center">
                <h4>INGRESOS</h4>
              </div>';
        echo '<table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                  <thead>
                   <tr>
                     <th width="5%">#</th>
                     <th width="20%">Fecha</th>
                     <th width="20%">Doctor</th>
                     <th width="20%">Usuario</th>
                     <th width="20%">Servicio</th>
                     <th width="15%">Importe</th>
                   </tr> 
                  </thead>
                  <tbody>';
				/*=============================================
				MUESTRA MONTO INICIO DE CAJA TABLA 'corte_caja'
				=============================================*/ 

				$itemCorte = "concepto";
				$valorCorte = "INICIO DE CAJA";

				$itemCorte2 = "fecha";
				$valorCorte2 = $this->fecha;

				$respuestaInicioCaja = ControladorCorteCaja::ctrMostrarInicioCaja($itemCorte, $valorCorte, $itemCorte2, $valorCorte2);

				$contadorIngresos = 1;

				if ($respuestaInicioCaja["concepto"] == "INICIO DE CAJA") {

					echo '<tr>';
						echo '<td>'.$contadorIngresos.'</td>';
						echo '<td>'.$respuestaInicioCaja["fechaInicioCaja"].'</td>';
						echo '<td></td>';
						echo '<td>'.$respuestaInicioCaja["nombre"].'</td>';
						echo '<td>'.$respuestaInicioCaja["concepto"].'</td>';
						echo '<td>$ '.number_format($respuestaInicioCaja["ingresos"],2).'</td>';
					echo '</tr>';

				}

				/*=============================================================================
				MUESTRA HISTORIAL PAGOS VENTAS TABLA 'historial_pagos'
				=============================================================================*/ 

				$itemCorte = "fecha";
				$valorCorte = $this->fecha;

				$respuestaCorteCaja = ControladorCorteCaja::ctrMostrarCajaIngresos($itemCorte, $valorCorte);

				$sumaHistorialPagos = 0;

				$cobradoTransferencia = 0;

              	$contadorHistorialPagos = 2;

				foreach ($respuestaCorteCaja as $keyCajaIngresos => $valueCajaIngresos){
					echo '<tr>';
				  	echo '<td>'.$contadorHistorialPagos.'</td>';
					echo '<td>'.$valueCajaIngresos["fecha"].'</td>';
					echo '<td>'.$valueCajaIngresos["nombreDoctor"].'</td>';
					echo '<td>'.$valueCajaIngresos["nombreUsuario"].'</td>';

					//Decodificamos el objeto JSON para obtener el valor de "descripción y precio"
					$objetoJson = json_decode($valueCajaIngresos["productos"]);

					echo "<td>";

					foreach ($objetoJson as $keyJson => $valueJson) {

							echo '<p>'.$valueJson->{'descripcion'}.': $ '.number_format($valueJson->{'precio'},2).'</p></br>';
					}

					echo "</td>";

					//Sí es transferencia suma total de montos y lo resta al final
					if($valueCajaIngresos["metodo_pago"] == "Transferencia" || $valueCajaIngresos["metodo_pago"] == "Tarjeta Crédito" || $valueCajaIngresos["metodo_pago"] == "Tarjeta Débito"){

						$cobradoTransferencia += $valueCajaIngresos["cobrado"];

						echo '<td>Transferencia: $ '.number_format($valueCajaIngresos["cobrado"],2).'</td>';

					}else{

						echo '<td>$ '.number_format($valueCajaIngresos["cobrado"],2).'</td>';

					}
				echo '</tr>';

					//SUMA TOTAL HISTORIAL PAGOS
	                $sumaHistorialPagos += $valueCajaIngresos["cobrado"];

	                //CONTADOR DE FILAS HISTORIAL PAGOS
	                $contadorHistorialPagos = $contadorHistorialPagos + 1;

				}

				$ingresosTotales = $sumaHistorialPagos + $respuestaInicioCaja["ingresos"] - $cobradoTransferencia;

					echo '<tr>';
					echo '<td colspan="5" style="text-align: right;"><strong>TOTAL EN CAJA: </strong></td>';
					echo '<td><strong>'; echo "$ ".number_format($ingresosTotales,2); echo '</strong></td>';
					echo '</tr>';

            echo '</tbody>
              </table>';
        echo '<div class="form-title text-center">
                  <h4>EGRESOS</h4>
              </div>';
        echo '<table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                  <thead>
                   <tr>
                     <th width="5%">#</th>
                     <th width="20%">Fecha</th>
                     <th width="20%">Usuario</th>
                     <th width="20%">Proveedor</th>
                     <th width="20%">Concepto</th>
                     <th width="15%">Importe</th>
                   </tr> 
                  </thead>
                  <tbody>';
					$item = "fecha";
					$valor = $this->fecha;

					$sumaEgresos = 0;

					$contadorEgresos = 1;

					$respuestaCajaEgresos = ControladorCorteCaja::ctrMostrarCajaEgresos($item, $valor);

					foreach ($respuestaCajaEgresos as $keyCajaEgresos => $valueCajaEgresos){

					  echo '<tr>';
					    echo '<td>'.$contadorEgresos.'</td>';
					    echo '<td>'.$valueCajaEgresos["fechaCompra"].'</td>';
					    echo '<td>'.$valueCajaEgresos["nombreUsuario"].'</td>';
                        echo '<td>'.$valueCajaEgresos["nombreProveedor"].'</td>';
					    echo '<td>'.$valueCajaEgresos["descripcionCompra"].'</td>';
					    echo '<td>$ '.number_format($valueCajaEgresos["gasto"],2).'</td>';

					  echo '</tr>'; 

					  $sumaEgresos += $valueCajaEgresos["gasto"];

					  //CONTADOR PARA CONSECUTIVOS EN TABLA
					  $contadorEgresos= $contadorEgresos + 1;


					}

					//INGRESOS NETOS
					$totalIngresos = $ingresosTotales - $sumaEgresos;
		echo '<tr>
				<td colspan="5" style="text-align: right;"><strong>TOTAL: </strong></td>
				<td><strong>'; echo "$ ".number_format($sumaEgresos,2); echo '</strong></td>
			</tr>';
        echo '</tbody>
              </table>
              <div class="row border rounded-circle">
                <div class="col-xs col-sm col-md col-lg">
                </div>
                <div class="col-xs col-sm col-md col-lg" style="text-align: center; background-color: lightgray;">
                  <strong>INGRESOS NETOS</strong>
                </div>
                <div class="col-xs col-sm col-md col-lg" style="text-align: center; background-color: lightgray;">
                  <strong>'; echo "$ ".number_format($totalIngresos,2); echo '</strong>
                </div>
                <div class="col-xs col-sm col-md col-lg">
                </div>
              </div>';

      	echo '</div>
    		</div>';
    		
	}
}

/*=============================================
MOSTRAR DETALLES CORTE CAJA
=============================================*/
if(isset($_POST["id_corte"])){

	$editar = new AjaxCorteCaja();
	$editar -> id_corte = $_POST["id_corte"];
	$editar -> fecha = $_POST["fecha"];
	$editar -> ajaxMostrarDetallesCaja();

}

