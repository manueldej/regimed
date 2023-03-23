<?php 
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                		            #
# Version:  3.1.1                                                    				                        #
# Fecha:    24/03/2011 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada	(IN MEMORIAN)							         		            #
# Licencia: Freeware                                                				                        #
#                                                                       			                        #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                 #
# LICENCIA: Este archivo es parte de REGIMED. REGIMED es un software libre; Usted lo puede redistribuir y/o #
# lo puede modificar bajo los términos de la Licencia Pública General GNU publicada por la Fundación de     #
# Software Gratuito (the Free Software Foundation ); Ya sea la versión 2 de la Licencia, o (en su opción)   #
# cualquier posterior versión. REGIMED es distribuido con la esperanza de que será útil, pero SIN CUALQUIER #
# GARANTÍA; Sin aún la garantía implícita de COMERCIABILIDAD o ADAPTABILIDAD PARA UN PROPÓSITO PARTICULAR.  #
# Vea la Licencia Pública General del GNU para más detalles. Usted debería haber recibido una copia de la   #
# Licencia  Pública General de GNU junto con REGIMED. En Caso de que No, vea <http://www.gnu.org/licenses>. #
#############################################################################################################
include('header.php');
include ('script.php');
$aftt="";
	if(isset($_POST['aftt'])){
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$aftt .= " WHERE (inv LIKE '%".$_POST['aftt']."%') OR (descrip LIKE '%".$_POST['aftt']."%') OR (categ LIKE '%".$_POST['aftt']."%') AND (idunidades='".$_COOKIE['unidades']."')";
		}else{
			$aftt .= " WHERE (inv LIKE '%".$_POST['aftt']."%') OR (descrip LIKE '%".$_POST['aftt']."%') OR (categ LIKE '%".$_POST['aftt']."%')";
		}
	}elseif (isset($_POST['cod']) AND ($_POST['cod']) !=""){
		$aftt .= "WHERE (idunidades='".$_POST['cod']."')";
	}elseif (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$aftt .= " WHERE (idunidades='".$_COOKIE['unidades']."')";
	}else{
		$querdg1 = mysqli_query($miConex, "SELECT * FROM datos_generales WHERE id_datos='1'") or die(mysql_error());
		$rowquerdg1 = mysqli_fetch_array($querdg1);
		$aftt .= " WHERE (idunidades='".$rowquerdg1['id_datos']."')";
	}

$query_Recordset1 = "SELECT * FROM aft ".$aftt." order by inv";
$Recordset1 = mysqli_query($miConex, $query_Recordset1) or die(mysql_error());
$af="";
	if(isset($_POST['af'])){
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$af .= " WHERE (inv LIKE '%".$_POST['af']."%') AND (idunidades='".$_COOKIE['unidades']."')";
		}else{
			$af .= " WHERE (inv LIKE '%".$_POST['af']."%')";
		}
	}else{
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$af .= " WHERE (idunidades='".$_COOKIE['unidades']."')";
		}
	}

$query_Recordset1s = "SELECT * FROM aft ".$af." order by inv";
$Recordset1s = mysqli_query($miConex, $query_Recordset1s) or die(mysql_error());
$rocue = mysqli_fetch_array($Recordset1s);
$custodiod = $rocue['custodio'];

if (isset($_POST['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_POST['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysqli_query($miConex, $query_Recordset1);
  $totalRows_Recordset1 = mysqli_num_rows($all_Recordset1);
}

if(isset($_GET['inv'])){
	
	$se = "select idarea from aft where inv='".$_GET['inv']."'";
	$qse = mysqli_query($miConex, $se) or die(mysqli_error());
	$rse = mysqli_fetch_array($qse);
	
	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$query_R = "SELECT nombre FROM areas where idunidades='".$_COOKIE['unidades']."'";
	}else{
		$query_R = "SELECT nombre FROM areas";
	}
	
	$Rec = mysqli_query($miConex, $query_R) or die(mysqli_error());
	$row_R = mysqli_fetch_assoc($Rec);
	$nom = $row_R['nombre'];
		
	if((@$_GET["adestino"]) !=""){
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$query_Recordset4 = "SELECT * FROM usuarios where idarea = '".base64_decode($_GET["adestino"])."' AND (idunidades='".$_COOKIE['unidades']."')";
		}elseif (isset($_GET['cod']) AND ($_GET['cod']) !=""){
			$query_Recordset4 = "SELECT * FROM usuarios where idarea = '".base64_decode($_GET["adestino"])."' AND (idunidades='".$_GET['cod']."')";
		}else{
			$query_Recordset4 = "SELECT * FROM usuarios where idarea = '".base64_decode($_GET["adestino"])."'";
		}
	}elseif (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$query_Recordset4 = "SELECT * FROM usuarios where (idarea='".$nom."') AND (idunidades='".$_COOKIE['unidades']."')";
	}elseif (isset($_GET['cod']) AND ($_GET['cod']) !=""){
		$query_Recordset4= "SELECT * FROM usuarios where (idarea='".$nom."') AND (idunidades='".$_GET['cod']."')";
	}else{
		$query_Recordset4 = "SELECT * FROM usuarios where idarea='".$nom."'";
	}
	
	$Recordset4 = mysqli_query($miConex, $query_Recordset4) or die(mysqli_error());
} 
$uu="";
	if (isset($_COOKIE['unidades'])){$uu=$_COOKIE['unidades'];}
	if (isset($_POST['cod'])){$uu=$_POST['cod'];}
	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$query_Reco = "SELECT * FROM areas WHERE idunidades='".$_COOKIE['unidades']."'";
	}elseif (isset($_POST['cod']) AND ($_POST['cod']) !=""){
		$query_Reco= "SELECT * FROM areas WHERE idunidades='".$_POST['cod']."'";
	}elseif (isset($_POST['adestino']) AND ($_POST['adestino']) !=""){
		if (isset($_COOKIE['unidades']) OR (@$_POST['cod'])){
			$query_Reco= "SELECT * FROM areas WHERE nombre='".base64_decode($_POST['adestino'])."' AND idunidades='".$uu."'";
		}else{
			$query_Reco= "SELECT * FROM areas WHERE nombre='".base64_decode($_POST['adestino'])."'";
		}
	}else{
		$querdg1 = mysqli_query($miConex, "SELECT * FROM datos_generales WHERE id_datos='1'") or die(mysql_error());
		$rowquerdg1 = mysqli_fetch_array($querdg1);
		$query_Reco = "SELECT * FROM areas WHERE idunidades='".$rowquerdg1['id_datos']."'";
	}

	$Record = mysqli_query($miConex, $query_Reco) or die(mysql_error());
    $totalRows_Records = mysqli_num_rows($Record);
 
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$query_RecUni = "SELECT * FROM datos_generales WHERE id_datos='".$_COOKIE['unidades']."'order by entidad";
}else{
	$query_RecUni = "SELECT * FROM datos_generales order by id_datos";
}

$query_udestino = "SELECT * FROM datos_generales order by id_datos";
$mysql_udest = mysqli_query($miConex, $query_udestino) or die(mysql_error());
$nuRecUdest = mysqli_num_rows($mysql_udest);

$RecUni = mysqli_query($miConex, $query_RecUni) or die(mysql_error());
$nuRecUni = mysqli_num_rows($RecUni);

$semean = mysqli_query($miConex, "select id from aft") or die(mysql_error());
$nsemean = mysqli_num_rows($semean);
?>
<style type="text/css">
<!--
.filtro {
	-moz-border-radius: 5px 5px 5px 5px;
    -webkit-border-radius: 5px 5px 5px 5px;
    border: 1px solid #B8B8B8;

    width: 150px;
	font-family: Verdana, sans-serif; 
	font-size: 12px;
	color: #333333; 
}
.Estilo2 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo3 {
	font-size: 12px;
	color: #846131;
	font-weight: bold;
	font-style: italic;
}
.Estilo1 {
	color: #000000;
	font-weight: bold;
	font-family: Tahoma, Helvetica, Arial, sans-serif;
	font-size: 18px;
}
-->
</style>
<?php include('barra.php');?>
<style type="text/css">
.progress{
	white-space: nowrap;
	color: white;
	font-size: 12px;
  overflow: hidden;
	background-color: navy;
	padding-left: 5px;
}
</style>
<script type="text/JavaScript">

/***********************************************
* Form Field Progress Bar- By Ron Jonk- http://www.euronet.nl/~jonkr/
* Modified by Dynamic Drive for minor changes
* Script featured/ available at Dynamic Drive- http://www.dynamicdrive.com
* Please keep this notice intact
***********************************************/

function textCounter(field,counter,maxlimit,linecounter) {
	// text width//
	var fieldWidth =  parseInt(field.offsetWidth);
	var charcnt = field.value.length;        

	// trim the extra text
	if (charcnt > maxlimit) { 
		field.value = field.value.substring(0, maxlimit);
	}

	else { 
	// progress bar percentage
	var percentage = parseInt(100 - (( maxlimit - charcnt) * 100)/maxlimit) ;
	document.getElementById(counter).style.width =  parseInt((fieldWidth*percentage)/100)+"px";
	document.getElementById(counter).innerHTML="Limite: "+percentage+"%"
	// color correction on style from CCFFF -> CC0000
	setcolor(document.getElementById(counter),percentage,"background-color");
	}
}

function setcolor(obj,percentage,prop){
	obj.style[prop] = "rgb(80%,"+(100-percentage)+"%,"+(100-percentage)+"%)";
}

</script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">    
	function submit_page(form){
		foundError = false;
		 if(isFieldBlank(form.invent))	 {
		  alert("El campo 'Inv' esta en blanco.");
		  foundError = true;
		 }else if(foundError == false )
		  document.form1.action="trasp.php";
		 else
		   document.form1.action="javascript:goHist(-1)";
	}

	function isFieldBlank(theField){
	 innStr = theField.value;
	 innLen = innStr.length;

	 if(theField.value == "" && innLen==0)
	  return true;
	 else
	  return false;
	}

	function ctype_digit(theField){
	 val = theField.value;
	 Len = val.length;
	 
	  for(var i=0; i<Len; i++)
	  {
	   var ch = val.substring(i,i+1)
	   if(ch < "0" || "16"< ch)
		 return true;
	  }
	}

    function validar()  {
     document.forms[0].elements[1].value = document.forms[0].elements[0].value; 
     document.forms[0].elements[1].focus;
    }
	
    function pasa(va,cod){
	  document.location="traspasos.php?inv="+va+"&af="+va+"&cod="+cod;
    }
  	var valor;
	var val="";
	area="Reparaciones";
	
		function esconde(val){
			if((val) ==true) {
		    	document.getElementById("udestino1").style.display = "block";
				document.getElementById("udestino2").style.display = "block";
			}
			if((val) ==false){
				document.getElementById("udestino1").style.display = "none";
				document.getElementById("udestino2").style.display = "none";
			}
		}

	
	function controla(){
		var valida = false;
		if((document.traspasos.invent1.value) =="-1"){
			alert('Debe seleccionar el Activo a traspasar');
			document.traspasos.invent1.focus();			
			valida = false;
		}else if((document.traspasos.area.value) =="-1"){
			alert('Debe seleccionar el Area de Destino');
			document.traspasos.area.focus();			
			valida = false;
		}else if((document.traspasos.custodio.value) ==""){
			alert('No se han declarado custodios en el \u00C1rea destino. Debe definirlos previamente, si se trata del \u00E1rea correcta.');
			document.traspasos.custodio.focus();			
			valida = false;
		}else if((document.traspasos.motivos.value) ==""){
			alert('Debe especificar el Motivo del Traspaso');
			document.traspasos.motivos.focus();			
			valida = false;
		}else{
			document.traspasos.submit();
		}
		return valida;
	}
	
</script>
<div id="buscad"> 
<fieldset class='fieldset'><legend class="vistauserx"><?php echo $bttrasp;?></legend><?php
	if(($nsemean) ==0){ ?>
		<br><div align="center"><div class="message" align="center"><?php echo $noregitro3." ".$btversion1.$bttotraspaso;?>.</div></div><?php
	}else{ ?>
		<form action="trasp.php" method="post" name="traspasos" id="traspasos" onsubmit="return controla();">
			<table width="70%" border="0" cellspacing="2" cellpadding="2" align="center">
				<tr>
					<td height="21" scope="col"><h1 align="CENTER" class="vistauser1"><?php echo strtoupper($bttrasp)." ".$btACTIVOS."-".$btAreas1;?></h1><br></td>
				</tr>
				<tr>
					<td height="21"><div style="<?php if ($nuRecUdest >1) { echo "display:block;";}else{ echo "display:none;"; } ?>"><b><?php echo strtoupper($entreunidades);?></b>&nbsp;<input name="entreunidad" type="checkbox" id="entreunidad" onclick="esconde(this.checked);" class="forn-control" style="cursor:pointer;" ><br></div></td>
				</tr>
								
				<?php	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){ ?>
							  <input name="unidades" type="hidden" id="unidades" value="<?php echo $_COOKIE['unidades'];?>"/><?php
							}else{ ?>
								<tr>
									<td><?php if(($nuRecUni) >1){ echo "<span class='vistauser1 Estilo2'>".$btdatosentidad2;}else{ echo "<span class='vistauser1 Estilo2'>".$btdatosentidad3;}?>:</span><br>&nbsp;
										<select name="unidades" class="combo_box" id="unidades" onChange="listar_aft(this.value,'');"><?php
											while ($row_Uni = mysqli_fetch_array($RecUni)){ ?>
											<option value="<?php echo $row_Uni['id_datos'];?>" <?php if(($row_Uni['id_datos']) ==@$_REQUEST['cod']){ echo "selected";} ?>><?php echo $row_Uni['entidad'];?></option><?php
											} ?>
										</select>
									</td>
							    </tr><?php 
						} ?>
				<tr>
					<td><br><span class="vistauser1 Estilo2">AFT</span></td>
				</tr>
				<tr>
					<td><div id="aft">&nbsp;
						<select class="combo_box" name="invent1" size="1" id="invent1" >
							<option value="-1" onClick="ubicar_origen(this.value);"><?php echo $seleccione.$El.ucfirst($btACTIVOS);?></option><?php 
								while ($row_Recordset1 = mysqli_fetch_array($Recordset1)) {  
									$querdg = mysqli_query($miConex, "SELECT * FROM datos_generales WHERE id_datos='".$row_Recordset1['idunidades']."'");
									$rowquerdg = mysqli_fetch_array($querdg);?>
									<option onClick="ubicar_origen(this.value);" value="<?php echo $row_Recordset1['inv'];?>" <?php if(($row_Recordset1['inv']) ==@$_REQUEST['inv']){ echo "selected";}?>  ><?php echo $row_Recordset1['inv']." -> ".$row_Recordset1['descrip'];?></option><?php
								} ?>
						</select></div>
						<input name="invent" type="text" class="imput" id="invent" placeholder="<?php echo $filtr;?>" onKeyUp="listar_aft(document.getElementById('unidades').value,this.value);">					
					</td>
				</tr>
				<tr>
					<td><br><span class="vistauser1 Estilo2"><?php echo $btAreas1." ".$btORIGEN;?></span></td>
				</tr>
				<tr>
					<td><div id="noinv"><input class="imput" readonly name="inventax" size="50" type="text" id="inventax" value="<?php if (isset($_GET['inv'])){ echo @$nom; } ?>"><div></td>
				</tr>
				<tr>
					<td><div id="udestino1" style="display:none;"><br><span class="vistauser1 Estilo2"><?php echo $btdatosentidad3." ".$btDESTINO;?></span></div></td>
				</tr>
				<tr>
					<td><div id="udestino2" style="display:none;">&nbsp;
						<select name="udestino" class="combo_box" id="udestino" onChange="u_destino(this.value);">
						<option value="-1"><?php echo $btselectenti." ".$btDESTINO;?></option><?php
							while ($row_UniDes = mysqli_fetch_array($mysql_udest)){ ?>
								<option value="<?php echo $row_UniDes['id_datos'];?>" <?php if(($row_UniDes['id_datos'])==@$_REQUEST['udes']){ echo "selected";} ?>><?php echo $row_UniDes['entidad'];?></option><?php
							} ?>
						</select></div>
					</td>
				</tr>
				<tr>
					<td><br><div id="udestino_f"><span class="vistauser1 Estilo2"><?php echo $btAreas1." ".$btDESTINO; ?></span></div></td>
				</tr>
				<tr>
				<td><div id="udestino_final">&nbsp;
					<select class="combo_box" name="area" size="1" id="area">
					<option value="-1"><?php echo $seleccione.$El.substr($btAreas,0,-1)." ".ucfirst($btDESTINO);?></option><?php  
						while ($row_R = mysqli_fetch_array($Record)) {                                						
							if(($rse['idarea']) != $row_R['nombre']){	?>
								<option onclick="dame_custodio('<?php echo base64_encode($row_R['nombre']);?>','<?php echo base64_encode($row_R['idunidades'])?>',document.getElementById('invent1').value);" value="<?php echo $row_R['nombre'];?>"<?php if(($row_R['nombre']) ==@base64_decode(@$_REQUEST["adestino"])){echo "selected";}?>><?php echo $row_R['nombre'];?></option><?php
							}
						} ?>
				    </select></div>
				</td>
				</tr>
				<tr>
			        <td><div id="labelcustodio" style="display:none;"><br><span class="vistauser1 Estilo2"><?php echo strtoupper($btCustodios1);?>:</span></div></td>
	            </tr>
				<tr>
					<td><div id="divcustodio" <?php echo 'style="display:block;"';?>>
						<?php 
							if(isset($_REQUEST["adestino"])){
								if((@base64_decode(@$_REQUEST["adestino"])) !="Reparaciones"){ ?>
									<select class="combo_box" name="custodio" size="1" id="custodio"><?php
										while ($row_Recordset4 = mysqli_fetch_array($Recordset4)) {  ?>
											<option value="<?php echo $row_Recordset4['nombre']?>" <?php if(isset($_POST['custo'])){ if((@base64_decode(@$_POST['custo'])) ==$row_Recordset4['nombre']){ echo "selected"; }	}?>><?php echo $row_Recordset4['nombre']?></option><?php
										} ?>
									</select><?php 
								}else{ echo '<input type="hidden" class="imput" id="sireparar" readonly name="custodio" value="'.$custodiod.'">';}
							}
						?>
					</td></div>
				</tr>
				<tr>
					<td><br><span class="vistauser1 Estilo2"><?php echo $btMOTIVOS;?>:</span></td>
				</tr>
				<tr>
				<td height="40" valign="top"><script>textCounter(document.getElementById("motivos"),"progressbar1",120)</script><textarea class="imputtextarea" name="motivos" id="motivos" cols="70" rows="3" onKeyDown="textCounter(this,'progressbar1',120)" onKeyUp="textCounter(this,'progressbar1',120)" onFocus="textCounter(this,'progressbar1',120)"></textarea>
				</td>
				</tr>
				<tr><td><div id="progressbar1" class="progress-bar progress-bar-info"></div></td></tr>
				<tr>
					<td height="26">
					<input type="submit" name="Submit" value="<?php echo $btaceptar;?>" class="btn"/>&nbsp;&nbsp;
					<input type="button" name="reto" value="<?php echo $btcancelar;?>" class="btn" onclick="javascript:document.location='r_traspasos.php'" /></td>
				</tr>
		  </table>
		</form><?php 
	} ?>
</fieldset><br><?php include ("version.php");?>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
