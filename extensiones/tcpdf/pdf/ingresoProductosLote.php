<?php

require_once "../../../controladores/productos-entradas.controlador.php";
require_once "../../../modelos/productos-entradas.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

require_once "../../../controladores/entradas-almacen.controlador.php";
require_once "../../../modelos/entradas-almacen.modelo.php";

require_once "../../../controladores/proveedor.controlador.php";
require_once "../../../modelos/proveedor.modelo.php";


class imprimirReporteProductosLote{

public $codigoIngreso;

public function traerImpresionProductosLote(){

//TRAEMOS LA INFORMACIÓN DEL INGRESO A TRAVES DEL CODIGO INGRESO

$itemIngreso = "id_ingreso";
$valorIngreso = $this->codigoIngreso;

//Con los paramtros definidos, se ejecuta el metodo mostrar Salidas
$respuestaIngreso = ControladorEntradasAlmacen::ctrMostrarEntradas($itemIngreso, $valorIngreso);
//var_dump($respuestaIngreso);
//Almacenamos en diferenctes variables toda la informacion deL INGRESO

//En fecha le quitamos la hora
$fechaIngreso = substr($respuestaIngreso["fecha_ingreso"],0,-8);
//Decodificado


//TRAEMOS LA INFORMACION DE LOS PRODUCTOS PERTENECIENTES AL LOTE

$itemProductos="codigo_ingreso";
$valorCodigo=$this->codigoIngreso;
$ordenProducto="id_producto";
$respuestaProductos = ControladorProductosEntradas::ctrMostrarProductosEntradas($itemProductos,$valorCodigo);

//TRAEMOS LA INFORMACIÓN DEL PROVEEDOR

$itemProveedor = "id_proveedor";
$valorProveedor = $respuestaIngreso["id_proveedor"];

$respuestaProveedor = ControladorProveedor::ctrMostrarProveedor($itemProveedor, $valorProveedor);


//REQUERIMOS LA CLASE TCPDF

require_once("tcpdf_include.php");

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
			<td style="background-color:white; width:100px; text-align:center; color:blue"><br><br>LOTE INGRESO N..<br>$respuestaIngreso[id_ingreso]</td>
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
				Proveedor: $respuestaProveedor[nombre_proveedor] 
			</td>
			<td style="border: 1px solid #666; background-color:white; width:150px; text-align:right" >Fecha Ingreso: $fechaIngreso</td>
		</tr>
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:390px">Sector de Comercio: $respuestaProveedor[rubro]</td>
			<td style="border: 1px solid #666; background-color:white; width:150px; text-align:right" >RUC: $respuestaProveedor[ruc]</td>
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
		
		<td style="border: 1px solid #666; background-color:white; width:50px; text-align:center">Lote</td>
		<td style="border: 1px solid #666; background-color:white; width:55px; text-align:center">Código</td>
		<td style="border: 1px solid #666; background-color:white; width:200px; text-align:center">Descripción</td>
		<td style="border: 1px solid #666; background-color:white; width:65px; text-align:center">Cantidad</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Costo Unitario</td>
		<td style="border: 1px solid #666; background-color:white; width:70px; text-align:center">Costo Lote</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------
//var_dump($respuestaProductos);
//var_dump($respuestaProductos["costo_unitario"]);

foreach ($respuestaProductos as $key => $item) {
	
$valorUnitario = number_format($item["costo_unitario"], 2);

$costoLote = number_format($item["costo_lote"], 2);

$bloque4 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:50px; text-align:center">
				$item[codigo_ingreso]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:55px; text-align:center">
				$item[id_producto]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:200px; text-align:center"> 
				$item[descripcion]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:65px; text-align:center"> 
				$item[stock]
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">S/. 
				$valorUnitario
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:70px; text-align:center">S/. 
				$costoLote
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
				Valor Total:
			</td>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				S/. $respuestaIngreso[monto_ingreso]
			</td>

		</tr>


	</table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');



// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 

$pdf->Output($this->codigoIngreso.".pdf", 'D');

}

}
//Instacion la clase
$factura = new imprimirReporteProductosLote();
//En la variable factura almacenamos lo que venga via get 
$factura -> codigoIngreso = $_GET["codigoIngresoProd"];
//Ejecutamos el metodo para la impresion de la factura
$factura -> traerImpresionProductosLote();

?>