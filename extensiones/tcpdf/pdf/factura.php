<?php

require_once "../../../controladores/salidas.controlador.php";
require_once "../../../modelos/salidas.modelo.php";

require_once "../../../controladores/solicitantes.controlador.php";
require_once "../../../modelos/solicitantes.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemSalida = "id_salida";
$valorSalida = $this->codigo;
//Con los paramtros definidos, se ejecuta el metodo mostrar Salidas
$respuestaSalida = ControladorSalidas::ctrMostrarSalidas($itemSalida, $valorSalida);

//Almacenamos en diferenctes variables toda la informacion de la venta

//En fecha le quitamos la hora
$fecha = substr($respuestaSalida["fecha_salida"],0,-8);
//Decodificado
$productos = json_decode($respuestaSalida["productos"], true);
//Formato numerico con 2 decimales
$total = number_format($respuestaSalida["total_valor_salida"],2);

//TRAEMOS LA INFORMACIÓN DEL Solicitante

$itemSolicitante = "id_solicitante";
$valorSolicitante = $respuestaSalida["id_solicitante"];

$respuestaSolicitante = ControladorSolicitantes::ctrMostrarSolicitantes($itemSolicitante, $valorSolicitante);

//TRAEMOS LA INFORMACIÓN DEL VENDEDOR

$itemUsuario = "id_usuario";
$valorUsuario = $respuestaSalida["id_usuario"];

$respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//Iniciando el grupo de paginas
$pdf->startPageGroup();
//Se adiciona una nueva pagina
$pdf->AddPage();

// ---------------------------------------------------------
//Se crea un bloque de maquetacion 
//Trabajar siempre en tablas la construccion de documentos pdf
$bloque1 = <<<EOF
	
		<table>
		<tr>
		<td style=" background-color:white; width:540px"></td>
		</tr>
		<tr>
			<td style="width:40px"><img src="images/logo-escudo-lima-villa-college.png"></td>
			<td style="width:60px"></td>
			<td style="background-color:white; width:340px">
				<div style="font-size:16px; text-align:center; line-height:15px;">
					<br>
					LIMA VILLA COLLEGE
					<br>
					Sistema de Inventario
				</div>
			</td>
			<td style="background-color:white; width:100px; text-align:center; color:blue"><br><br>CÓDIGO SALIDA<br>$respuestaSalida[codigo_salida]</td>
		</tr>
		<tr>
		<td style=" background-color:white; width:540px"></td>
		</tr>
		<tr>
		<td style=" background-color:white; width:540px"></td>
		</tr>
		</table>

EOF;
//Se cierra el bloque

//Ejecutamos el metodo escribir en html, donde pasamos el bloque y los demas parametros en falso
$pdf->writeHTML($bloque1, false, false, false, false, '');

// ---------------------------------------------------------
//Las imagenes en blanco sirven para los espaciados 
$bloque2 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:540px"><img src="images/back.jpg"></td>
		
		</tr>

	</table>

	<table style="font-size:10px; padding:5px 10px;">
	
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:390px">

				Solicitante: $respuestaSolicitante[nombres] $respuestaSolicitante[apellidos]

			</td>

			<td style="border: 1px solid #666; background-color:white; width:150px; text-align:right">
			
				Fecha: $fecha

			</td>

		</tr>

		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:540px">Responsable Entrega: $respuestaUsuario[nombres] $respuestaUsuario[apellidos]</td>

		</tr>

		<tr>
		
		<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>

		</tr>

	</table>
	
	EOF;
$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------------------------

$bloque3 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		
		<td style="border: 1px solid #666; background-color:white; width:260px; text-align:center">Producto</td>
		<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Cantidad</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Unit.</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Total</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------

foreach ($productos as $key => $item) {

$itemProducto = "id_producto";
$valorProducto = $item["id"];
$orden = "id_producto";

$respuestaProducto = ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto, $orden);

$valorUnitario = number_format($respuestaProducto["costo_unitario"], 2);

$precioTotal = number_format($item["total"], 2);

$bloque4 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:260px; text-align:center">
				$item[descripcion]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
				$item[cantidad]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">S/. 
				$valorUnitario
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">S/. 
				$precioTotal
			</td>


		</tr>

	</table>


EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

}

// ---------------------------------------------------------

$bloque5 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>

			<td style="color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>

		</tr>
		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
				Total:
			</td>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				S/. $total
			</td>

		</tr>


	</table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');



// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 

$pdf->Output($respuestaSolicitante['nombres'].".pdf", 'D');

}

}
//Instacion la clase
$factura = new imprimirFactura();
//En la variable factura almacenamos lo que venga via get 
$factura -> codigo = $_GET["codigo"];
//Ejecutamos el metodo para la impresion de la factura
$factura -> traerImpresionFactura();

?>