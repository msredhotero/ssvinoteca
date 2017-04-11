<?php


session_start();

if (!isset($_SESSION['usua_predio']))
{
	header('Location: ../../error.php');
} else {


include ('../../includes/funciones.php');
include ('../../includes/funcionesUsuarios.php');
include ('../../includes/funcionesHTML.php');
include ('../../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosHTML 		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Ventas",$_SESSION['refroll_predio'],'');


$id = $_GET['id'];

$resResultado = $serviciosReferencias->traerVentasPorId($id);

$descuento = mysql_result($resResultado,0,'descuento');
/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Venta";

$plural = "Ventas";

$eliminar = "eliminarVentas";

$modificar = "modificarVentas";

$idTabla = "idventa";

$tituloWeb = "Gestión: Vinoteca";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbdetallepreventas";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

/////////////// cabeceras para el detalle ////////////////////////////////////////////////////

$cabeceras	= "<th>Producto</th>
			   <th>Cantidad</th>
			   <th>Precio</th>
			   <th>SubTotal</th>";

//////////////////////////////////////////////////////////////////////////////////////////////

$carrito 	=	$serviciosReferencias->traerCarritoPorVenta($id);


if ($_SESSION['idroll_predio'] != 1) {

} else {

	
}


?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title><?php echo $tituloWeb; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link href="../../css/estiloDash.css" rel="stylesheet" type="text/css">
    

    
    <script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="../../css/jquery-ui.css">

    <script src="../../js/jquery-ui.js"></script>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>

	<style type="text/css">
		
  
		
	</style>
    
   
   <link href="../../css/perfect-scrollbar.css" rel="stylesheet">
      <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
      <script src="../../js/jquery.mousewheel.js"></script>
      <script src="../../js/perfect-scrollbar.js"></script>
      <script>
      jQuery(document).ready(function ($) {
        "use strict";
        $('#navigation').perfectScrollbar();
      });
    </script>
</head>

<body>

 <?php echo $resMenu; ?>

<div id="content">

<h3>Carrito</h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Finalizar Venta</p>
        	
        </div>
    	<div class="cuerpoBox">
        	<form class="form-inline formulario" role="form">
        	
			<div class="row">
            	<div class="form-group col-md-2" style="display:block">
                	<label class="control-label" for="codigobarra" style="text-align:left">Descuento</label>
                    <div class="input-group col-md-12">
	                    <input id="descuento" class="form-control" name="descuento" placeholder="Descuento..." required type="number" value="<?php echo $descuento; ?>">
                    </div>
                </div>
                
                <div class="col-md-12">
				<table class="table table-striped" id="table-6">
                    <thead>
                        <th class="text-center">Id</th>
                        <th style="width:260px;" class="text-center">Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Sub-Total</th>
                        <th class="text-center">Precio Arriba/Abajo</th>
                        <th style="width:120px;" class="text-center">Acciones</th>
                    </thead>
                    <tbody id="detalle">
                <?php
					$total = 0;
					$subTotal = 0;
					while ($row = mysql_fetch_array($carrito)) {
				?>
                	<tr>
                		<th class="text-center"><?php echo $row['refproductos']; ?></th>
                        <th style="width:260px;" class="text-center"><?php echo $row['nombre']; ?></th>
                        <th class="text-center"><?php echo $row['cantidad']; ?></th>
                        <th class="text-center"><?php if ($row['cantidad'] > 1) { echo $row['preciodescuento']; } else { echo $row['precio']; } ?></th>
                        <th class="text-center"><?php if ($row['cantidad'] > 1) { echo ((float)$row['cantidad'] * (float)$row['preciodescuento']); } else { echo ((float)$row['cantidad'] * (float)$row['precio']); } ?></th>
                        <th class="text-center"><?php if ($row['cantidad'] > 1) { ?><input type="checkbox" checked name="preciodescuento" id="preciodescuento"/><?php } else { ?><input type="checkbox" name="preciodescuento" id="preciodescuento"/><?php } ?></th>
                        <th style="width:120px;" class="text-center"><button type="button" class="btn btn-danger eliminarfila" id="<?php echo $row['refproductos']; ?>" style="margin-left:0px;">Eliminar</button></th>
                    
                    
                	</tr>
                <?php
					}
				?>
                	</tbody>
                    <tfoot>
                        <tr style="background-color:#CCC; font-weight:bold; font-size:18px;">
                            <td colspan="6" align="right">
                                Sub-Total $
                            </td>
                            <td>
                                <input type="text" readonly name="total" id="total" value="0" style="border:none; background-color:#CCC;"/>
                            </td>
                        </tr>
                        <tr style="background-color:#DDD; font-weight:bold; font-size:18px;">
                            <td colspan="6" align="right">
                                Total - Descuento $
                            </td>
                            <td>
                                <input type="text" readonly name="totaldescuento" id="totaldescuento" value="0" style="border:none; background-color:#DDD;"/>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                </div>
            </div>
            
            
            
            <div class='row' style="margin-left:25px; margin-right:25px;">
                <div class='alert'>
                
                </div>
                <div id='load'>
                
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:15px;">
                    <li>
                        <button type="button" class="btn btn-success" id="cargar" style="margin-left:0px;">Finalizar</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-danger varborrar" id="<?php echo $id; ?>" style="margin-left:0px;">Eliminar</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-default volver" style="margin-left:0px;">Volver</button>
                    </li>
                </ul>
                </div>
            </div>
            </form>
    	</div>
    </div>
    
    
   
</div>


</div>


<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	if ('<?php echo $cancelado; ?>' == 'Si') {
		$('#cancelado').prop('checked',true);	
		$('#cancelado').prop('disabled',true);
	} else {
		$('#cancelado').prop('checked',false);	
	}
	
	
	
	$('#total').prop('readonly', true);
	
	$('#fecha').prop('readonly', true);
	
	$('#usuario').prop('readonly', true);
	
	$('#numero').prop('readonly', true);
	
	$('.volver').click(function(event){
		 
		url = "index.php";
		$(location).attr('href',url);
	});//fin del boton modificar
	
	$('.varborrar').click(function(event){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			$("#idEliminar").val(usersid);
			$("#dialog2").dialog("open");

			
			//url = "../clienteseleccionado/index.php?idcliente=" + usersid;
			//$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton eliminar

	 $( "#dialog2" ).dialog({
		 	
			    autoOpen: false,
			 	resizable: false,
				width:600,
				height:240,
				modal: true,
				buttons: {
				    "Eliminar": function() {
	
						$.ajax({
									data:  {id: $('#idEliminar').val(), accion: '<?php echo $eliminar; ?>'},
									url:   '../../ajax/ajax.php',
									type:  'post',
									beforeSend: function () {
											
									},
									success:  function (response) {
											url = "index.php";
											$(location).attr('href',url);
											
									}
							});
						$( this ).dialog( "close" );
						$( this ).dialog( "close" );
							$('html, body').animate({
	           					scrollTop: '1000px'
	       					},
	       					1500);
				    },
				    Cancelar: function() {
						$( this ).dialog( "close" );
				    }
				}
		 
		 
	 		}); //fin del dialogo para eliminar
	
	
	<?php 
		echo $serviciosHTML->validacion($tabla);
	
	?>
	
	$('.eliminar').click(function(event){
                
			  usersid =  $(this).attr("id");
			  imagenId = 'img'+usersid;
			  
			  if (!isNaN(usersid)) {
				$("#idAgente").val(usersid);
                                //$('#vistaPrevia30').attr('src', e.target.result);
				$("#auxImg").html($('#'+imagenId).html());
				$("#dialog3").dialog("open");
				//url = "../clienteseleccionado/index.php?idcliente=" + usersid;
				//$(location).attr('href',url);
			  } else {
				alert("Error, vuelva a realizar la acción.");	
			  }
			  
			  //post code
	});
	
	$( "#dialog3" ).dialog({
		 	
		autoOpen: false,
		resizable: false,
		width:600,
		height:340,
		modal: true,
		buttons: {
			"Eliminar": function() {

				$.ajax({
							data:  {id: $("#idAgente").val(), accion: 'eliminarFoto'},
							url:   '../../ajax/ajax.php',
							type:  'post',
							beforeSend: function () {
									
							},
							success:  function (response) {
									url = "modificar.php?id=<?php echo $id; ?>";
									$(location).attr('href',url);
									
							}
					});
				$( this ).dialog( "close" );
				$( this ).dialog( "close" );
					$('html, body').animate({
						scrollTop: '1000px'
					},
					1500);
			},
			Cancelar: function() {
				$( this ).dialog( "close" );
			}
		}
 
 
	});
	
	
	//al enviar el formulario
    $('#cargar').click(function(){
		
		if (validador() == "")
        {
			//información del formulario
			var formData = new FormData($(".formulario")[0]);
			var message = "";
			//hacemos la petición ajax  
			$.ajax({
				url: '../../ajax/ajax.php',  
				type: 'POST',
				// Form data
				//datos del formulario
				data: formData,
				//necesario para subir archivos via ajax
				cache: false,
				contentType: false,
				processData: false,
				//mientras enviamos el archivo
				beforeSend: function(){
					$("#load").html('<img src="../../imagenes/load13.gif" width="50" height="50" />');       
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data == '') {
                                            $(".alert").removeClass("alert-danger");
											$(".alert").removeClass("alert-info");
                                            $(".alert").addClass("alert-success");
                                            $(".alert").html('<strong>Ok!</strong> Se modifico exitosamente el <strong><?php echo $singular; ?></strong>. ');
											$(".alert").delay(3000).queue(function(){
												/*aca lo que quiero hacer 
												  después de los 2 segundos de retraso*/
												$(this).dequeue(); //continúo con el siguiente ítem en la cola
												
											});
											$("#load").html('');
											url = "modificar.php?id=<?php echo $id; ?>";
											$(location).attr('href',url);
                                            
											
                                        } else {
                                        	$(".alert").removeClass("alert-danger");
                                            $(".alert").addClass("alert-danger");
                                            $(".alert").html('<strong>Error!</strong> '+data);
                                            $("#load").html('');
                                        }
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
                    $("#load").html('');
				}
			});
		}
    });
	
	$('#imagen1').on('change', function(e) {
	  var Lector,
		  oFileInput = this;
	 
	  if (oFileInput.files.length === 0) {
		return;
	  };
	 
	  Lector = new FileReader();
	  Lector.onloadend = function(e) {
		$('#vistaPrevia1').attr('src', e.target.result);         
	  };
	  Lector.readAsDataURL(oFileInput.files[0]);
	 
	});

});
</script>
<?php } ?>
</body>
</html>
