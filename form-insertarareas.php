<?php 
############################################################################################################
# Software: Regimed                                                                                        #
#(Registro de Medios Informáticos)     					                                		           #
# Version:  3.0.1                                                     				                       #
# Fecha:    01/06/2016 - 03/04/2018                                             					                       #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			           #
#          	Msc. Carlos Pollan Estrada											         		           #
# Licencia: Freeware                                                				                       #
#                                                                       			                       #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                #
############################################################################################################
@session_start();
require_once('connections/miConex.php');
		include('chequeo.php');
			$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
include ('script.php'); ?>
	<link href="css/template.css" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="ajax.js"></script> 
<script language="JavaScript" >
// Check for a blank field
function submit_page(form){
 foundError = false;
 
 if(isFieldBlank(form.t2)) {
  alert("El campo 'NOMBRE' est� en blanco.");
  foundError = true;
 }
 else 
  if(foundError == false )
  document.form1.action="insertaarea.php";
 else
   document.form1.action="javascript:goHist(-1)";
}

function retornar(){
 document.location="registroareas.php";
}

function isFieldBlank(theField){
 innStr = theField.value;
 innLen = innStr.length;

 if(theField.value == "" && innLen==0)
  return true;
 else
  return false;

}

function ctype_digit(theField)
{
 val = theField.value;
 Len = val.length;
 
  for(var i=0; i<Len; i++)
  {
   var ch = val.substring(i,i+1)
   if(ch < "0" || "16"< ch)
     return true;
  }
}

function ci(theField)   {
 val = theField.value;
 Len = val.length;

  for(var i=0; i<Len; i++)
    var chh = val.substring(i,i+1)
    
  if(i < "16")
    return true;
}
function controld(){
	if((document.getElementById('idunidades').value) =="-1"){
		alert('Debe seleccionar la Entidad.');
		document.getElementById('idunidades').focus();
		return false;
	}else if((document.getElementById('nombre').value) ==""){
		alert('Debe escribir el nombre del Area.');
		document.getElementById('nombre').focus();
		return false;
	}
}
</script>
<style type="text/css">
<!--
.Estilo2 {
	color: #0099CC;
	font-weight: bold;
}
.Estilo3 {color: #009999}
.Estilo4 {color: #336666; font-weight: bold; }

div.message {
	font-family : "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size : 14px;
	color : #c30;
	text-align: center;
	width: auto;
	background-color: #f9f9f9;
	border: solid 1px #d5d5d5;
	margin: 3px 0px 10px;
	padding: 3px 20px;
}
-->
</style>
<?php 
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$sql_uactiva = "select * from datos_generales where id_datos='".$_COOKIE['unidades']."'";
}else{
	$sql_uactiva = "select * from datos_generales";
}
$result_uactiva= mysqli_query($miConex, $sql_uactiva); ?>
<div id="buscad"> 
<br><br>
<table width="100%" border="0" class="table">
	<tr>
		<td>
			<form name="form1" method="post" action="insertaarea.php" onsubmit="return controld();">
				<table width="100%" border="0" class="table" align="left"> <?php
					if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){ ?>
						<input name="idunidades" type="hidden" id="idunidades" value="<?php echo $_COOKIE['unidades'];?>"><?php
					}elseif (mysqli_num_rows($result_uactiva) ==1){ 
						$rowent = mysqli_fetch_array($result_uactiva);?>
						<input name="idunidades" type="hidden" id="idunidades" value="<?php echo $rowent['id_datos']?>"><?php
					} else{ ?>
						<tr>
							<td colspan="2"><div align="right" class="contentheading"><?php echo $btdatosentidad2;?></div>
								<select onkeypress="return handleEnter(this, event)" name="idunidades" class="form-control" size="1" id="idunidades">
									<option value="-1"><?php echo $seleccione.$LA.$btdatosentidad3;?></option><?php
									while($rowent = mysqli_fetch_array($result_uactiva)) {?>
										<option value="<?php echo $rowent['id_datos'];?>" <?php if(($rowent['id_datos']) ==@$_POST['idunidades']){ echo "selected";} ?>><?php echo $rowent['entidad']?></option><?php
									} ?>
								</select>
							</td>
						</tr><?php 
					} ?>              
					<tr>
						<td colspan="2"></td>
					</tr><?php 
					$sedg=mysqli_query($miConex, "select * from datos_generales") or die(mysql_error());
					$quedg= mysqli_fetch_array($sedg);
					$dagen= $quedg['id_datos'];
					$result = mysqli_query($miConex, "SELECT * FROM areas");
					if (!$result) {
						echo 'No se puede ejecutar la Consulta: ' . mysql_error();
						exit;
					}
					$num_campo = mysqli_num_fields($result);
					$ultimo = mysqli_num_rows ($result);
					$ultimo= $ultimo+1;  ?>
					<tr>
						<td colspan="2"><?php echo $new2.$btAreas2 ?></td>
					</tr>
					<tr>
						<td align="right"><b><div  align="right"><?php echo $apodo1;?></div></b></td>
						<td><input name="nombre" type="text" id="nombre" required placeholder="Escriba nombre para la nueva area" class="form-control" maxlength="50"></td>
					</tr>
					<tr>			
						<td colspan="3" align="center">
							<input class="btn" type="submit" name="insertar" value="Guardar">
						</td>
					</tr>
				</table> 
			</form>	
		</td>
	</tr>
</table>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="js/main.js"></script>