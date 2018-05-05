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
include ('script.php');
$nombreqty = "";
$cargoqty = "";
$loginqty = "";
$emailqty = "";
$idarea =""; 
$UNIDAD ="1"; 
if(isset($_GET['t'])){ $t=$_GET['t']; }
if(isset($_POST['nombreqty'])){ $nombreqty=$_POST['nombreqty']; }
if(isset($_POST['cargoqty'])){ $cargoqty =$_POST['cargoqty'];}
if(isset($_POST['loginqty'])){ $loginqty = $_POST['loginqty'];}
if(isset($_POST['mailqty'])){ $emailqty = $_POST['mailqty'];}
if(isset($_POST['idarea'])){ $idarea = $_POST['idarea'];}
if(isset($_POST['sexo'])){ $sexo = $_POST['sexo'];}

if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$query_RecUni = "SELECT * FROM datos_generales where id_datos='".$_COOKIE['unidades']."'order by entidad";
}else{
	$query_RecUni = "SELECT * FROM datos_generales order by entidad";
}
$RecUni = mysqli_query($miConex, $query_RecUni) or die(mysql_error());
$nuRecUni = mysqli_num_rows($RecUni);
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$qarea=mysqli_query($miConex, "select * from areas where (nombre!='Reparaciones') AND (idunidades='".$_COOKIE['unidades']."')") or die(mysql_error());
	$qareau=mysqli_query($miConex, "select * from datos_generales where (id_datos='".$_COOKIE['unidades']."')") or die(mysql_error());
}elseif (isset($_COOKIE['uninds']) AND ($_COOKIE['uninds']) !=""){
	$qarea=mysqli_query($miConex, "select * from areas where (nombre!='Reparaciones') AND (idunidades='".$_COOKIE['uninds']."')") or die(mysql_error());
	$qareau=mysqli_query($miConex, "select * from datos_generales where (id_datos='".$_COOKIE['uninds']."')") or die(mysql_error());
}else{
	$qarea=mysqli_query($miConex, "select * from areas where nombre!='Reparaciones' AND idunidades='1'") or die(mysql_error());
	$qareau=mysqli_query($miConex, "select * from datos_generales") or die(mysql_error());
}
?>
	<link href="css/template.css" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="ajax.js"></script> 
 <SCRIPT LANGUAGE="JavaScript">
	 function validar() {
		var formValid=false;
		var f = document.usua;
		var porfa = "Por favor debe escribir";
		var re=/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/ 
		if (f.idarea.value == '-1') {
			alert('Debe seleccionar el Area');
			f.idarea.focus();
			formValid=false;} 
		else if (f.loginqty.value == '') {
			alert(porfa + ' el Login');
			f.loginqty.focus();
			formValid=false;} 
		else if (f.nombreqty.value == '') {
			alert(porfa + ' el Nombre y Apellidos');
			f.nombreqty.focus();
			formValid=false;} 
		else if ( f.cargoqty.value == '' ) {
			alert(porfa + ' el Cargo');
			f.cargoqty.focus();
			formValid=false;} 
		else if (f.passwdqty.value == '') {
			alert(porfa + ' la Clave');
			f.passwdqty.focus();
			formValid=false;} 
		else if ( f.emailqty.value == '' ) {
			alert(porfa + ' el E-Mail');
			f.emailqty.focus();
			formValid=false;} 
		else if (!re.exec(f.emailqty.value)){
			alert(porfa + ' un E-Mail valido');
			f.emailqty.value="";
			f.emailqty.focus(); 
			formValid=false; 	} 
		else if (f.idarea.value == '-1') {
			alert(porfa + ' el Area');
			f.idarea.focus();
			formValid=false;} 
		else if (f.sexo.value == '-1') {
			alert(porfa + ' el Sexo');
			f.sexo.focus();
			formValid=false;} 
		else if ( confirm('Son estos los datos correcto?')) {
			formValid=true;}	
		return formValid;
	}
	
	var keylist="abcdefghijklmnopqrstuvwxyz123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var temp="";

	function generatepass(plength){
		temp="";
		for (i=0;i<plength;i++){
			temp +=keylist.charAt(Math.floor(Math.random()*keylist.length));
		}
		return temp;
	}
	
	function populateform(enterlength){
		document.usua.passwdqty.value=generatepass(enterlength);
	}
	function cambiaU(un){
		document.cookie="uninds="+un;
		document.location="registro2.php";
	}
  </SCRIPT>
<style type="text/css">
<!--
.Estilo2 {font-size: 12px}
.Estilo5 {font-size: 12px; font-weight: bold; color: #6699CC; }
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
<script type="text/javascript" src="ajax.js"></script>
<div id="buscad"> 
<script type="text/javascript">
	function mira(m,n){
		var h = document.frmAf;
		switch (n)	{
			case 1 : 
				if((m.length) <4){
					document.getElementById("ll").innerHTML="<b><em><font color=>El m&iacute;nimo de caracteres para el Login es de 4.</em></b>";
					h.txtLogin.value="";
					h.txtLogin.focus();
					return false;
				}else if((m.length) >15){
					document.getElementById("ll").innerHTML="<b><em>El m&aacute;ximo de caracteres para el Login es de 15.</em></b>";
					h.txtLogin.value="";
					h.txtLogin.focus();
					return false;
				}else{document.getElementById("ll").innerHTML="<b><em>Ok</em></b>";}
				break ;
			case 2 : 
				if((m.length) <6){
					document.getElementById("cc").innerHTML="<b><em><font color='red'>El m&iacute;nimo de caracteres para la Clave es de 6.</font></em></b>";
					h.password.value="";
					h.password.focus();
					return false;
				}else if((m.length) >15){
					document.getElementById("cc").innerHTML="<b><em><font color='red'>El m&aacute;ximo de caracteres para la Clave es de 15.</font></em></b>";
					h.password.value="";
					h.password.focus();
					return false;
				}else{document.getElementById("cc").innerHTML="<b><em><font color='red'>Ok</font></em></b>";}
				break ;
	   }
	}
	function verem(valor){	
	 // Cortesía de http://aprendeenlinea.udea.edu.co/lms/ova/mod/resource/view.php?id=1671 
		if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(valor))) {
			document.getElementById('veem').innerHTML="&nbsp;&nbsp;<font color='red'><em><b><?php echo $no_addres;?></b></em></font>&nbsp;&nbsp;";
			document.usua.emailqty.focus();
			return false; 
		}else{ 
			document.getElementById('veem').innerHTML="&nbsp;&nbsp;<font color='red'><em><b>Ok</b></em></font>&nbsp;&nbsp;";
		} 
	}
	function compru(c){
		if((c) !="Ok"){
			document.usua.pedido.disabled=true;
		}else{
			document.usua.pedido.disabled=false;
		}
	}
</script>
	<FORM action="insertaruser.php" method="post" target="_self" onSubmit="return validar();" name="usua" id="usua">
		<table border="0" class="table"><?php
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){ ?>
				<input name="unidades" type="hidden" id="unidades" value="<?php echo $_COOKIE['unidades'];?>"/><?php
			}else{ ?>
				<tr>
					<td width="30%"><div align="right"><b><?php if(($nuRecUni) >1){ echo $btdatosentidad2;}else{ echo $btdatosentidad3;}?>:</b></div></td>
					<td width="70%">
						<select name="unidades" class="form-control" id="unidades" onChange="cambiaU(this.value);"><?php
							while ($row_Uni = mysqli_fetch_array($RecUni)){ ?>
								<option value="<?php echo $row_Uni['id_datos'];?>" <?php if(($row_Uni['id_datos']) ==@$_COOKIE['uninds'] OR (($row_Uni['id_datos'])) ==$UNIDAD){ echo "selected";} ?>><?php echo $row_Uni['entidad'];?></option><?php
							} ?>
						</select>
					</td>
				</tr><?php 
			} ?>
			<tr>
                <td width="30%"><div align="right"><b><?php echo $btAreas;?>:</b></div></td>
			    <td width="70%">
					<select name="idarea" class="form-control" id="idarea">
						<option value="-1"><?php echo $seleccione.$El.$btAreas;?></option><?php
						while($rarea=mysqli_fetch_array($qarea)){?>
							<option value="<?php echo htmlentities($rarea['nombre']);?>"<?php  if(($rarea['nombre']) ==$idarea){ echo "selected";}?>><?php echo $rarea['nombre'];?></option><?php
						} ?>
                    </select>
				</td>
			</tr>
            <tr> 
				<td><div align="right"><b>Login: </b></div></td>
				<td><input class="form-control" name="loginqty" id="loginqty" size="16" maxLength="16" value="<?php echo $loginqty;?>" onblur="return valida(this.value,'usuarios'); compru(this.form.s.value);" onkeyup="return valida(this.value,'usuarios');"><span id="ll"><input name="s" id="s" class="textod"></span></td>
			</tr>
			<tr> 
				<td><div align="right"><b><?php echo $nombreapell;?> </b></div></td>
				<td><input class="form-control" name="nombreqty" id="nombreqty" size="45" maxLength="45" value="<?php echo $nombreqty;?>"></td>
			</tr>
			<tr> 
				<td><div align="right"><b><?php echo $btnCargo;?>:</b></div></td>
				<td><input name="cargoqty" id="cargoqty" size="40" maxLength="40" class="form-control" value="<?php echo $cargoqty;?>"></td>
			</tr>
			<tr> 
				<td><div align="right"><b><?php echo $btpassw;?>: </b></div></td>
				<td align="middle"><div>
					<input name="passwdqty" class="form-control" type="text" id="passwdqty" size='16' maxLength='20' onBlur="return mira(this.value,2);">
					&nbsp;&nbsp;
					<input  class="boton" onClick="populateform(this.form.thelength.value)" type="button" value="<?php echo $gnrar." ".$btpassw;?>" name="button" />
					<input type="hidden"  value="7" name="thelength" />
					<input type="hidden"   name="output" /><span id="cc"></span>
				  </div></td>
			</tr>
			<tr> 
				<td><div align="right"><b><?php echo $electron;?>:</b></div></td>
				<td><input class="form-control" name="emailqty" type="text" id="emailqty" size="40" maxLength="40" value="<?php echo $emailqty;?>" onBlur="return verem(this.value);"><span id="veem"></span></td>
			</tr><?php
			if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){ ?><input type="hidden" name="unidades" value="<?php echo $_COOKIE['unidades'];?>">
			<?php
			}else{ ?><?php } ?>
			<tr>
				<td><div align="right"><b><?php echo $Sexo;?>:</b></div></td>
				<td><select class="form-control" name="sexo" id="sexo">
					<option value="-1"><?php echo $seleccione.$El.$Sexo;?></option>
					<option value="h"<?php  if((@$sexo) =="h"){ echo "selected";}?>><?php echo $Hombre;?></option>
					<option value="m"<?php  if((@$sexo) =="m"){ echo "selected";}?>><?php echo $Mujer;?></option>
				  </select></td>
			</tr>
			<tr> 
				<td valign="middle"  colspan='2' align="center"><hr>
					<input class="btn" type="submit" name="pedido" id="pedido" value="<?php echo $btaceptar;?>">&nbsp;&nbsp;
					<input class="btn" type="button" value="<?php echo $btcancelar;?>" onClick="window.parent.location='ej1.php';">
				</td>
			</tr>
		</TABLE>
	</FORM>    
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="js/main.js"></script>