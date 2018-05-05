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
include('header.php');
include ('script.php');
$aftt="";
	if(isset($_GET['aftt'])){
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$aftt .= " WHERE (inv LIKE '%".$_GET['aftt']."%') OR (descrip LIKE '%".$_GET['aftt']."%') AND (idunidades='".$_COOKIE['unidades']."')";
		}else{
			$aftt .= " WHERE (inv LIKE '%".$_GET['aftt']."%') OR (descrip LIKE '%".$_GET['aftt']."%')";
		}
	}elseif (isset($_GET['cod']) AND ($_GET['cod']) !=""){
		$aftt .= "WHERE (idunidades='".$_GET['cod']."')";
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
	if(isset($_GET['af'])){
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$af .= " WHERE (inv LIKE '%".$_GET['af']."%') AND (idunidades='".$_COOKIE['unidades']."')";
		}else{
			$af .= " WHERE (inv LIKE '%".$_GET['af']."%')";
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

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysqli_query($miConex, $query_Recordset1);
  $totalRows_Recordset1 = mysqli_num_rows($all_Recordset1);
}


if(isset($_GET['inv'])){
	$se = "select idarea from aft WHERE inv='".$_GET['inv']."'";
	$qse = mysqli_query($miConex, $se) or die(mysql_error());
	$rse = mysqli_fetch_array($qse);

	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$query_R = "SELECT nombre FROM areas WHERE idunidades='".$_COOKIE['unidades']."'";
	}else{
		$query_R = "SELECT nombre FROM areas";
	}
	$Rec = mysqli_query($miConex, $query_R) or die(mysql_error());
	$row_R = mysqli_fetch_assoc($Rec);
	$nom = $row_R['nombre'];
	if((@$_GET["adestino"]) !=""){
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$query_Recordset4 = "SELECT * FROM usuarios WHERE idarea = '".base64_decode($_GET["adestino"])."' AND (idunidades='".$_COOKIE['unidades']."')";
		}elseif (isset($_GET['cod']) AND ($_GET['cod']) !=""){
			$query_Recordset4 = "SELECT * FROM usuarios WHERE idarea = '".base64_decode($_GET["adestino"])."' AND (idunidades='".$_GET['cod']."')";
		}else{
			$query_Recordset4 = "SELECT * FROM usuarios WHERE idarea = '".base64_decode($_GET["adestino"])."'";
		}
	}elseif (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$query_Recordset4 = "SELECT * FROM usuarios WHERE (idarea='".$nom."') AND (idunidades='".$_COOKIE['unidades']."')";
	}elseif (isset($_GET['cod']) AND ($_GET['cod']) !=""){
		$query_Recordset4= "SELECT * FROM usuarios WHERE (idarea='".$nom."') AND (idunidades='".$_GET['cod']."')";
	}else{
		$query_Recordset4 = "SELECT * FROM usuarios WHERE idarea='".$nom."'";
	}
	$Recordset4 = mysqli_query($miConex, $query_Recordset4) or die(mysql_error());
} $uu="";
	if (isset($_COOKIE['unidades'])){$uu=$_COOKIE['unidades'];}
	if (isset($_GET['cod'])){$uu=$_GET['cod'];}
	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$query_Reco = "SELECT * FROM areas WHERE idunidades='".$_COOKIE['unidades']."'";
	}elseif (isset($_GET['cod']) AND ($_GET['cod']) !=""){
		$query_Reco= "SELECT * FROM areas WHERE idunidades='".$_GET['cod']."'";
	}elseif (isset($_GET['adestino']) AND ($_GET['adestino']) !=""){
		if (isset($_COOKIE['unidades']) OR (@$_GET['cod'])){
			$query_Reco= "SELECT * FROM areas WHERE nombre='".base64_decode($_GET['adestino'])."' AND idunidades='".$uu."'";
		}else{
			$query_Reco= "SELECT * FROM areas WHERE nombre='".base64_decode($_GET['adestino'])."'";
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
	$query_RecUni = "SELECT * FROM datos_generales order by entidad";
}
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
//------------------------- funciones -------------------------------------------//
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
   //alert(document.forms[0].elements[0].value);
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
			document.getElementById("custodio").style.display = "none";
			
			 if((val) !=area) {
		    		 document.getElementById("custodio").style.display = "block";
		 		}else 
	    			document.getElementById("custodio").style.display = "none";	
			if((val) =area){
				document.getElementById(val).style.display = "block";
			}else if((val) ==""){
				document.getElementById("-1").style.display = "block";
			}
		}

	function llena(valor){
		document.getElementById('custodio').style.display="block";
		esconde(valor);
	}
	function envia(key){
		document.location='traspasos.php?inv=<?php echo @$_GET['inv'];?>&adestino='+key+'&cod=<?php echo @$_GET['cod']?>';
	}
	function manda(man){
		document.location="traspasos.php?aftt="+man;
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
		}else if((document.traspasos.motivos.value) ==""){
			alert('Debe especificar el Motivo del Traspaso');
			document.traspasos.motivos.focus();			
			valida = false;
		}else{
			document.traspasos.submit();
		}
		return valida;
	}
	function cambiaU(un){
		document.location="traspasos.php?cod="+un;
	}
</script>
<div id="buscad"> 
<fieldset class='fieldset'><legend class="vistauserx"><?php echo $bttrasp;?></legend><?php
	if(($nsemean) ==0){ ?>
		<br><div align="center"><div class="message" align="center"><?php echo $noregitro3." ".$btversion1.$bttotraspaso;?>.</div></div><?php
	}else{ ?>
		<form action="trasp.php" method="post" name="traspasos" id="traspasos" onsubmit="return controla();">
			<table width="619" height="292" border="0" align="center">
				<tr>
					<td height="21" scope="col"><h1 align="CENTER" class="vistauser1"><?php echo strtoupper($bttrasp)." ".$btACTIVOS."-".$btAreas1;?></h1></td>
				</tr><?php
							if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){ ?>
							  <input name="unidades" type="hidden" id="unidades" value="<?php echo $_COOKIE['unidades'];?>"/><?php
							}else{ ?>
								<tr>
									<td><?php if(($nuRecUni) >1){ echo $btdatosentidad2;}else{ echo $btdatosentidad3;}?>:&nbsp;
										<select name="unidades" class="combo_box" id="unidades" onChange="cambiaU(this.value);"><?php
											while ($row_Uni = mysqli_fetch_array($RecUni)){ ?>
												<option value="<?php echo $row_Uni['id_datos'];?>" <?php if(($row_Uni['id_datos']) ==@$_GET['cod']){ echo "selected";} ?>><?php echo $row_Uni['entidad'];?></option><?php
											} ?>
										</select>
									</td>
							  </tr><?php 
							} ?>
				<tr>
					<td><span class="vistauser1 Estilo2">AFT</span></td>
				</tr>
				<tr>
					<td>
						<select class="combo_box" name="invent1" size="1" id="invent1" >
							<option value="-1"><?php echo $seleccione.$El.ucfirst($btACTIVOS);?></option><?php 
								while ($row_Recordset1 = mysqli_fetch_array($Recordset1)) {  
									$querdg = mysqli_query($miConex, "SELECT * FROM datos_generales WHERE id_datos='".$row_Recordset1['idunidades']."'");
									$rowquerdg = mysqli_fetch_array($querdg);?>
									<option onClick="pasa(this.value,'<?php echo $rowquerdg['id_datos'];?>');" value="<?php echo $row_Recordset1['inv'];?>" <?php if(($row_Recordset1['inv']) ==@$_GET['inv']){ echo "selected";}?>  ><?php echo $row_Recordset1['inv']." -> ".$row_Recordset1['descrip'];?></option><?php
								} ?>
						</select><br><br>
						<input name="invent" type="text" class="imput" id="invent">					
						<input name="Submit2" type="button" class="btn" onclick="manda(document.getElementById('invent').value);" value="<?php echo $filtr;?>"/>
					</td>
				</tr>
				<tr>
					<td><br><span class="vistauser1 Estilo2"><?php echo $btAreas1." ".$btORIGEN;?></span></td>
				</tr>
				<tr>
					<td><input class="imput" readonly name="inventx" size="<?php if(isset($_GET['inv'])){ echo strlen($rse['idarea']);}?>" type="text" id="inventx" value="<?php if(isset($_GET['inv'])){ echo $rse['idarea'];}else{ echo "-";}?>"></td>
				</tr>
				<tr>
					<td><span class="vistauser1 Estilo2"><?php echo $btAreas1." ".$btDESTINO; ?></span></td>
				</tr>
				<tr>
				<td>
					<select class="combo_box" name="area" size="1" id="area" onchange="llena(this.value);">
					<option value="-1"><?php echo $seleccione.$El.substr($btAreas,0,-1)." ".ucfirst($btDESTINO);?></option><?php
					while ($row_R = mysqli_fetch_array($Record)) {  
						if((@$rse['idarea']) !=$row_R['nombre']){	?>
							<option onclick="envia('<?php echo base64_encode($row_R['nombre'])?>');" value="<?php echo $row_R['nombre'];?>"<?php if(($row_R['nombre']) ==base64_decode(@$_GET["adestino"])){echo "selected";}?>><?php echo $row_R['nombre'];?></option><?php
						}
					} ?>
				  </select>
				  </td>
				</tr>
				<tr>
					<td><span class="vistauser1 Estilo2"><?php echo $btMOTIVOS;?>:</span></td>
				</tr>
				<tr>
				<td height="40" valign="top"><script>textCounter(document.getElementById("motivos"),"progressbar1",120)</script><textarea class="imputtextarea" name="motivos" id="motivos" cols="70" rows="3" onKeyDown="textCounter(this,'progressbar1',120)" onKeyUp="textCounter(this,'progressbar1',120)" onFocus="textCounter(this,'progressbar1',120)"></textarea>
					<div id="custodio" 
						<?php if((@$_GET['inv']) !=""){ echo 'style="display:"';}else{ echo 'style="display:none;"';}?>><?php 
							if(isset($_GET["adestino"])){
								if((base64_decode(@$_GET["adestino"])) !="Reparaciones"){ ?>
									<select class="combo_box" name="custodio" size="1" id="custodio"><?php
									
										while ($row_Recordset4 = mysqli_fetch_array($Recordset4)) {  ?>
											<option value="<?php echo $row_Recordset4['nombre']?>" <?php if(isset($_GET['custo'])){ if((base64_decode($_GET['custo'])) ==$row_Recordset4['nombre']){ echo "selected"; }	}?>><?php echo $row_Recordset4['nombre']?></option><?php
										} ?>
									</select><?php 
								}else{ echo '<input type="hidden" name="custodio" value="'.$custodiod.'">';}
							}?>
					</div>
				</td>
				</tr>
				<tr><td><div id="progressbar1" class="progress-bar progress-bar-info"></div></td></tr>
				<tr>
					<td height="26"><input name="idunidades" type="hidden" value="<?php echo @$_GET['cod'];?>">
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
