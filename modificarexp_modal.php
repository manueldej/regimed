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
?>
	<link href="css/template.css" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="ajax.js"></script> <?php
if(isset($_GET['palabra'])){ $palabra=$_GET['palabra'];}
$explode2 = array();
if(isset($_POST['inv'])){
   $inv = $_POST['inv'];
   $explode=explode("*",$inv);
   if((strstr($_POST['idunidades'], '*')) !=""){
     $explode2=explode("*",$_POST['idunidades']);
   }else{
     $explode2[]= $_POST['idunidades'];
   }	
}
if(isset($_POST['marcado'])){
	$explode=$_POST['marcado'];
	$inv = substr($explode[0],0,-1);
	$explode2 = $_POST['idunidades'];
}
if(isset($_GET['marcado'])){
	$inv = $_GET['marcado'];
	$explode=explode("*",$inv);
	$inv = substr($explode[0],0,-1);
	$explode2 = $_GET['idunidades'];
}
if(isset($_GET['inv'])){
	$inv = $_GET['inv'];
	$explode=explode("*",$inv);
}
?>
<script language="JavaScript" >

// chequear campos en blanco 
function submit_page(form)
{
 foundError = false;
 
 if(isFieldBlank(form.t2)) {
  alert("El campo 'Inv' est� en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.cpu)) {
  alert("El campo 'CPU' est� en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.placa)) {
  alert("El campo 'PLACA' est� en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.chiset)) {
  alert("El campo 'CHIPSET' est� en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.mem)) {
  alert("El campo 'MEMORIA' est� en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.mem2)) {
  alert("El campo 'MEMORIA' est� en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.mem3)) {
  alert("El campo 'MEMORIA' est� en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.mem4)) {
  alert("El campo 'MEMORIA' est� en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.grafic)) {
  alert("El campo 'GRAFICS' est� en blanco.");
  foundError = true;
 }else
  if(isFieldBlank(form.fuente)) {
  alert("El campo 'FUENTE DE PODER' está en blanco.");
  foundError = true;
 }else
 if(isFieldBlank(form.so)) {
  alert("El campo 'SO' est� en blanco.");
  foundError = true;
 }else
   
 if(foundError == false )
  document.form1.action="insertarexp.php";
 else
   document.form1.action="javascript:goHist(-1)";
}

//------------------------- funciones -------------------------------------------//

function isFieldBlank(theField){
 innStr = theField.value;
 innLen = innStr.length;

 if(theField.value == "" && innLen==0)
  return true;
 else
  return false;


function ctype_digit(theField){
 val = theField.value;
 Len = val.length;

  for(var i=0; i<Len; i++)
  {
   var ch = val.substring(i,i+1)
   if(ch < "0" || "9"< ch)
     return true;
  }
}

function ci(theField) {
 val = theField.value;
 Len = val.length;

  for(var i=0; i<Len; i++)
    var chh = val.substring(i,i+1)

  if(i < "11")
    return true;
}
</script>
<div id="buscad">
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
</style>
		<form action="insertarexp.php" method="post" name="form1">
			<table width="58%" border="0" class="table"><?php
					$kl=0;
				foreach($explode as $key){
					if(!empty($key)){
						if(isset($_POST['marcado'])){
							$key = substr($key,0,-1);	
						}
						$queryx="select * from exp where id='".$key."' AND idunidades='".$explode2[$kl]."'";
						$result=mysqli_query($queryx) or die(mysql_error());
						$row = mysqli_fetch_array($result); 
						echo "<b>AFT: ".$row['inv']."</b>";			
						$memor=explode('*',$row["MEMORIA2"]);
						$redes=explode('*',$row["RED2"]); ?>			
						<tr>
							<td width="61" height="47" align="right"><img src="images/cpu.png" alt="CPU" width="45" height="45" class="Estilo1" longdesc="Unidad central de procesamiento " /></td>
						  <td width="98"><div align="right"><strong>CPU</strong></div></td>
						  <td width="387" colspan="3"><input onkeypress="return handleEnter(this, event)" name="cpu[]" type="text" class="form-control" id="cpu[]" value="<?php echo $row['CPU'];?>" size="50">						</td>
						</tr>
						<tr>
							<td height="42" align="right"><img src="images/placa.png" alt="Board" width="55" height="38" longdesc="Placa Base" /></td>
							<td><div align="right"><strong><?php echo $btPLACA;?></strong></div></td>
							<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="placa[]" type="text" class="form-control" id="placa[]" value="<?php echo $row['PLACA'];?>">						</td>
						</tr>
						<tr>
							<td align="right"><img src="images/chipset.png" alt="Chipset" width="55" height="38" longdesc="Chipset" /></td>
							<td><div align="right"><strong>CHIPSET </strong></div></td>
							<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="chiset[]" type="text" class="form-control" id="chiset[]" value="<?php echo $row['CHIPSET'];?>" size="50">						</td>
						</tr>
						<tr>
							<td align="right"><img src="images/ram.png" alt="RAM" width="40" height="40" longdesc="Tarjeta de Memoria " /></td>
							<td><div align="right"><strong><?php echo $Memorias1;?>-1</strong></div></td>
							<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="mem[]" type="text" class="form-control" id="mem[]" value="<?php echo $row['MEMORIA'];?>" size="50">						</td>
						</tr>
						<tr>
							<td align="right"><strong><img src="images/ram.png" alt="RAM" width="40" height="40" longdesc="Tarjeta de Memoria " /></strong></td>
							<td><div align="right"><strong><?php echo $Memorias1;?>-2</strong></div></td>
							<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="mem2[]" type="text" class="form-control" id="mem2[]" value="<?php echo @$memor[0]?>">	</td>
						</tr>
						<tr>
						  <td align="right"><strong><img src="images/ram.png" alt="RAM" width="40" height="40" longdesc="Tarjeta de Memoria " /></strong></td>
						  <td><div align="right"><strong><?php echo $Memorias1;?>-3</strong></div></td>
						  <td colspan="3"><input onkeypress="return handleEnter(this, event)" name="mem3[]" type="text" class="form-control" id="mem3[]" value="<?php echo @$memor[1];?>" /></td>
						</tr>
						<tr>
						  <td align="right"><strong><img src="images/ram.png" alt="RAM" width="40" height="40" longdesc="Tarjeta de Memoria " /></strong></td>
						  <td><div align="right"><strong><?php echo $Memorias1;?>-4</strong></div></td>
						  <td colspan="3"><input onkeypress="return handleEnter(this, event)" name="mem4[]" type="text" class="form-control" id="mem4[]" value="<?php echo @$memor[2]?>" /></td>
						</tr>
						<tr>
							<td align="right"><img src="images/video.png" alt="video" width="45" height="38" longdesc="Tarjeta de Video" /></td>
							<td><div align="right"><strong><?php echo $bttargeta;?></strong></div></td>
							<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="grafic[]" type="text" class="form-control" id="grafic[]" value="<?php echo $row['GRAFICS'];?>" size="50">						</td>
						</tr>
						<tr>
							<td align="right"><span align="left"><strong><img src="images/HDD.png" alt="HDD" width="40" height="40" longdesc="Disco Duro" /></strong></span></td>
							<td><div align="right"><strong>HDD-1</strong></div></td>
								<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="drive1[]" type="text" class="form-control" id="drive1[]" value="<?php echo $row['DRIVE1'];?>" size="50" ></td>
						</tr>
						<tr>
							<td align="right"><span align="left"><strong><img src="images/HDD.png" alt="HDD" width="40" height="40" longdesc="Disco Duro" /></strong></span></td>
							<td><div align="right"><strong>HDD-2</strong></div></td>
							<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="drive2[]" type="text" class="form-control" id="drive2[]" value="<?php echo $row['DRIVE2'];?>" size="50" >						</td>
						</tr>
						<tr>
							<td align="right"><span align="left"><strong><img src="images/DriveDVD.png" alt="DRIVE" width="40" height="40" longdesc="Disco Duro/Lector/Quemador" /></strong></span></td>
							<td><div align="right"><strong><?php echo $btdevice;?>-1</strong></div></td>
							<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="drive3[]" type="text" class="form-control" id="drive3[]" value="<?php echo $row['DRIVE3']?>" size="50" >						</td>
						</tr>
						<tr>
							<td align="right"><span align="left"><strong><img src="images/DriveDVD.png" alt="DRIVE" width="40" height="40" longdesc="Disco Duro/Lector/Quemador" /></strong></span></td>
							<td><div align="right"><strong><?php echo $btdevice;?>-2</strong></div></td>
							<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="drive4[]" type="text" class="form-control" id="drive4[]" value="<?php echo $row["DRIVE4"]?>" size="50" >						</td>
						</tr>
						<tr>
							<td align="right"><span align="left"><strong><img src="images/sonido.png" alt="SONIDO" width="40" height="40" longdesc="Tarjeta de Sonido " /></strong></span></td>
							<td><div align="right"><strong><?php echo $btSONIDO;?></strong></div></td>
							<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="sonido[]" type="text" class="form-control" id="sonido[]" value="<?php echo $row['SONIDO'];?>" size="50" ></td>
						</tr>
						<tr>
							<td align="right"><span align="left"><strong><img src="images/Ethernet card Vista.png" alt="RED" width="40" height="40" longdesc="Tarjeta de Red" /></strong></span></td>
							<td><div align="right"><strong><?php echo $btRED;?>-1</strong></div></td>
							<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="red0[]" type="text" class="form-control" id="red0[]" value="<?php echo $row['RED'];?>" size="50">					</td>
						</tr>
						<tr>
							<td align="right"><span align="left"><strong><img src="images/Ethernet card Vista.png" alt="RED" width="40" height="40" longdesc="Tarjeta de Red" /></strong></span></td>
							<td><div align="right"><strong><?php echo $btRED;?>-2</strong></div></td>
							<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="red1[]" type="text" class="form-control" id="red1[]" value="<?php echo @$redes[0];?>" size="50">						</td>
						</tr>
						<tr>
						  <td align="right"><strong><img src="images/Ethernet card Vista.png" alt="RED" width="40" height="40" longdesc="Tarjeta de Red" /></strong></td>
						  <td><div align="right"><strong><?php echo $btRED;?>-3</strong></div></td>
						  <td colspan="3"><input onkeypress="return handleEnter(this, event)" name="red2[]" type="text" class="form-control" id="red2[]" value="<?php echo @$redes[1];?>" size="50" /></td>
						</tr>
						<tr>
							<td align="right"><span align="left"><strong><img src="images/fuente1.jpg" title="RED" width="40" height="40" longdesc="Tarjeta de Red" /></strong></span></td>
							<td><div align="right"><strong><?php echo $btFUENTE;?></strong></div></td>
							<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="fuente[]" type="text" class="form-control" id="fuente[]" value="<?php echo $row['FUENTE']?>" size="50">				</td>
						</tr>
						<tr>
							<td align="right"><span align="left"><strong><img src="images/SO.png" alt="SO" width="40" height="40" longdesc="Sistema Operativo" /></strong></span></td>
							<td><div align="right"><strong>OS</strong></div></td>
							<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="so[]" type="text" class="form-control" id="so[]" value="<?php echo $row['OS']?>" size="50">						</td>	
						</tr>
						<tr>
							<td align="right"><span align="left"><strong><img src="images/custodios.png" alt="CUST" width="40" height="40" longdesc="Custodios" /></strong></span></td>
							<td><div align="right"><strong><?php echo strtoupper($btCustodios);?></strong></div></td>
							<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="custodio[]" type="text" class="form-control" id="custodio[]" value="<?php echo $row['custodio'];?>" readonly >			</td>
						</tr>					
						<tr>
							<td colspan="2" align="right"><div align="right"><strong><?php echo strtoupper($btNombre);?> PC</strong></div></td>
							<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="npc[]" type="text" class="form-control" id="npc[]" value="<?php echo $row['n_PC']?>" size="50"><input type="hidden" name="invt[]" value="<?php echo $key;?>"><input type="hidden" name="marcado[]" value="<?php echo $row['id'];?>"></td>
						</tr><?php 
						$kl++;
					}						
				}?>
				<tr>
					<td colspan="3" align="right"><input type="submit" class="btn" name="editar" value="<?php echo $btaceptar;?>" onClick="submit_page(this.form)">&nbsp;<input name="canc" onclick="window.parent.location='registromedios1.php';" type="button" class="btn" value="<?php echo $btcancelar;?>" /></td>
				</tr>
			</table>				
		</form>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="js/main.js"></script>
