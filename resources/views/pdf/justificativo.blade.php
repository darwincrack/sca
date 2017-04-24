
<html>
	<head>
		
		<style>
		.encabezado{
			text-align: center;
		}

		.espacio{
			height: 6px;
		}
		.contenido tr {
			border-bottom: 1px solid black;
		}
@page {
	header: page-header;
	footer: page-footer;
}
		</style>
	</head>
	<body>

<div class="main">
	
<table width="100%">
	<tr>
		<td width="20%"> <img src="{{ URL::asset('assets/img/logomep_100x66.png') }}" ></td>
		<td "75%"></td>
		<td "25%" align="right"> <img src="{{ URL::asset('assets/img/'.$url_logo) }}" width="70" height="70" align="right" style="text-align: right; margin-left: 15px"> </td>
	</tr>
	<tr>
		<td width="20%"></td>
		<td "75%" class='encabezado'>MINISTERIO DE EDUCACIÓN PÚBLICA <BR>
		DIRECCION REGIONAL DE EDUCACIÓN DE ALAJUELA<BR>
		LICEO DE POÁS<BR>
		BOLETA JUSTIFICACION DE OMISIÓN DE MARCA</td>
		<td "25%"></td>
	</tr>
	<tr>
		<td colspan="4" class="espacio"></td>
	</tr>
	</table>


<table width="100%" style="border:1px solid black;" class="contenido">
	<tr >
		<td width="30%" style="border-right:1px solid black;  ">Departamento:</td>
		<td width="15%">Fecha:</td>
	</tr>
	<tr style="border:1px solid black;">
		<td width="20%" style="border-right:1px solid black; border-bottom:1px solid black;  ">{{$departamento}}</td>
		<td width="35%" style="border-bottom:1px solid black;  ">{{$fecha}}</td>
	</tr>


	<tr>
		<td width="30%" style="border-right:1px solid black;  ">Nombre del funcionario (a):</td>
		<td width="15%">Cédula:</td>
	</tr>
	<tr style="border:1px solid black;">
		<td width="20%" style="border-right:1px solid black;  ">{{$nombre}}</td>
		<td width="35%">{{$cedula}}</td>
	</tr>
	</table>

<table width="100%" style="border:1px solid black;" class="contenido">
	<tr >
		<td width="33%" >Todo el dia ( {{$todo_dia}} )</td>
		<td width="33%" >Mañana ( {{$manana}} )</td>
		<td width="33%" >Tarde( {{$tarde}} )</td>

	</tr>


	</table>


	<table width="100%" style="border:1px solid black;" class="contenido">
	<tr >
		<td width="30%" style="border-right:1px solid black;  ">Hora de Entrada:</td>
		<td width="15%">Hora de Salida:</td>
	</tr>
	<tr style="border:1px solid black;">
		<td width="20%" style="border-right:1px solid black;">{{$hora_entrada}}</td>
		<td width="35%" >{{$hora_salida}}</td>
	</tr>

	</table>


	<table width="100%" style="border:1px solid black;" class="contenido">
	<tr>
		<td>Motivo de la Omision:</td>

	</tr>
	<tr>
		<td >{{$tipo_justificativo}}</td>
	</tr>

	<tr>
		<td >{{$motivo_omision}}</td>
	</tr>

	</table>




	<table width="100%" style="border:1px solid black;" class="contenido">
	<tr>
		<td colspan="2" class="espacio"></td>
	</tr>

	<tr >
		<td width="30%" style=" text-align: center;">__________________________</td>
		<td width="15%" style="text-align: center">__________________________</td>
	</tr>
	<tr>
		<td width="20%" style="text-align: center; ">Firma del Jefe Inmediato</td>
		<td width="35%" style="text-align: center;">Firma del funcionario (a)</td>
	</tr>

	</table>








<br>
<hr>
<br>
<br>



	<table width="100%">
	<tr>
		<td width="20%"> <img src="{{ URL::asset('assets/img/logomep_100x66.png') }}" ></td>
		<td "75%"></td>
		<td "25%" align="right"> <img src="{{ URL::asset('assets/img/'.$url_logo) }}" width="70" height="70" align="right" style="text-align: right; margin-left: 15px"> </td>
	</tr>
	<tr>
		<td width="20%"></td>
		<td "75%" class='encabezado'>MINISTERIO DE EDUCACIÓN PÚBLICA <BR>
		DIRECCION REGIONAL DE EDUCACIÓN DE ALAJUELA<BR>
		LICEO DE POÁS<BR>
		BOLETA JUSTIFICACION DE OMISIÓN DE MARCA</td>
		<td "25%"></td>
	</tr>
	<tr>
		<td colspan="4" class="espacio"></td>
	</tr>
	</table>


<table width="100%" style="border:1px solid black;" class="contenido">
	<tr >
		<td width="30%" style="border-right:1px solid black;  ">Departamento:</td>
		<td width="15%">Fecha:</td>
	</tr>
	<tr style="border:1px solid black;">
		<td width="20%" style="border-right:1px solid black; border-bottom:1px solid black;  ">{{$departamento}}</td>
		<td width="35%" style="border-bottom:1px solid black;  ">{{$fecha}}</td>
	</tr>


	<tr>
		<td width="30%" style="border-right:1px solid black;  ">Nombre del funcionario (a):</td>
		<td width="15%">Cédula:</td>
	</tr>
	<tr style="border:1px solid black;">
		<td width="20%" style="border-right:1px solid black;  ">{{$nombre}}</td>
		<td width="35%">{{$cedula}}</td>
	</tr>
	</table>

<table width="100%" style="border:1px solid black;" class="contenido">
	<tr >
		<td width="33%" >Todo el dia ( {{$todo_dia}} )</td>
		<td width="33%" >Mañana ( {{$manana}} )</td>
		<td width="33%" >Tarde( {{$tarde}} )</td>

	</tr>


	</table>


	<table width="100%" style="border:1px solid black;" class="contenido">
	<tr >
		<td width="30%" style="border-right:1px solid black;  ">Hora de Entrada:</td>
		<td width="15%">Hora de Salida:</td>
	</tr>
	<tr style="border:1px solid black;">
		<td width="20%" style="border-right:1px solid black;">{{$hora_entrada}}</td>
		<td width="35%" >{{$hora_salida}}</td>
	</tr>

	</table>


	<table width="100%" style="border:1px solid black;" class="contenido">
	<tr>
		<td>Motivo de la Omision:</td>

	</tr>
	<tr>
		<td >{{$tipo_justificativo}}</td>
	</tr>

	<tr>
		<td >{{$motivo_omision}}</td>
	</tr>

	</table>




	<table width="100%" style="border:1px solid black;" class="contenido">
	<tr>
		<td colspan="2" class="espacio"></td>
	</tr>

	<tr >
		<td width="30%" style=" text-align: center;">__________________________</td>
		<td width="15%" style="text-align: center">__________________________</td>
	</tr>
	<tr>
		<td width="20%" style="text-align: center; ">Firma del Jefe Inmediato</td>
		<td width="35%" style="text-align: center;">Firma del funcionario (a)</td>
	</tr>

	</table>

</div>

	</body>
</html>
