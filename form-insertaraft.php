<?php 
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Inform�ticos)     					                                		            #
# Version:  3.1.1                                                    				                        #
# Fecha:    24/03/2011 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jes�s N��ez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada	(IN MEMORIAN)							         		            #
# Licencia: Freeware                                                				                        #
#                                                                       			                        #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                 #
# LICENCIA: Este archivo es parte de REGIMED. REGIMED es un software libre; Usted lo puede redistribuir y/o #
# lo puede modificar bajo los t�rminos de la Licencia P�blica General GNU publicada por la Fundaci�n de     #
# Software Gratuito (the Free Software Foundation ); Ya sea la versi�n 2 de la Licencia, o (en su opci�n)   #
# cualquier posterior versi�n. REGIMED es distribuido con la esperanza de que ser� �til, pero SIN CUALQUIER #
# GARANT�A; Sin a�n la garant�a impl�cita de COMERCIABILIDAD o ADAPTABILIDAD PARA UN PROP�SITO PARTICULAR.  #
# Vea la Licencia P�blica General del GNU para m�s detalles. Usted deber�a haber recibido una copia de la   #
# Licencia  P�blica General de GNU junto con REGIMED. En Caso de que No, vea <http://www.gnu.org/licenses>. #
#############################################################################################################
@session_start();
require_once('connections/miConex.php');
include('header.php');
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
if(($i) =="es"){include('esp.php');}else{ include('eng.php');}

include ('script.php');
include('mensaje.php');
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$sql_uactiva = "select * from datos_generales where id_datos='".$_COOKIE['unidades']."'";
}else{
	$sql_uactiva = "select * from datos_generales";
}
$result_uactiva= mysqli_query($miConex, $sql_uactiva);


if(isset($_POST['tt'])){
	$query_Recordset1 = "SELECT * FROM usuarios where id_area='".$_POST['tt']."' AND idunidades='".$_POST['idunidades']."'";
}else{
	$query_Recordset1 = "SELECT * FROM usuarios";
}

$Recordset1 = mysqli_query($miConex, $query_Recordset1) or die(mysql_error());
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$validus = "";
if(isset($_SESSION["autentificado"])){
	$validus = " AND idunidades='".$_SESSION["autentificado"]."'";
}elseif (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$validus = " AND idunidades='".$_COOKIE['unidades']."'";
}else{
	$validus = "";
}
$us1 = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$rselu = mysqli_fetch_array($us1);
$rowrselu =$rselu['idunidades'];
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$query_R = "SELECT * FROM areas where idunidades='".$_COOKIE['unidades']."'";
}elseif (isset($_POST['idunidades'])){
	$query_R = "SELECT * FROM areas where idunidades='".$_POST['idunidades']."'";
}else{
	$query_R = "SELECT * FROM areas";
}

$Record = mysqli_query($miConex, $query_R) or die(mysql_error());
$query_Recordset2 = "SELECT * FROM tipos_medios ORDER BY id";
$Recordset2 = mysqli_query($miConex, $query_Recordset2) or die(mysql_error());
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$query_Recordset3 = "SELECT * FROM tipos_medios ORDER BY nombre";
$Recordset3 = mysqli_query($miConex, $query_Recordset3) or die(mysql_error());
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$query_Recordset4 = "SELECT * FROM tipos_aft";
$Recordset4 = mysqli_query($miConex, $query_Recordset4) or die(mysql_error());
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);

$query_Recordset5 = "SELECT * FROM sellos WHERE estado='Disponible'";
$Recordset5 = mysqli_query($miConex, $query_Recordset5) or die(mysql_error());
$damemas = mysqli_num_rows($Recordset5);

				
?>
	<link href="css/template.css" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="ajax.js"></script> 
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
<script language="JavaScript1.2" type="text/javascript">
 var highlightcolor="lightyellow"
 var ns6=document.getElementById&&!document.all
 var previous=''
 var eventobj

 //Regular expression to highlight only form elements
 var intended=/INPUT|TEXTAREA|SELECT|OPTION/

 //Function para chequear cuales elementos han sido clickeado 
 function checkel(which){
 if (which.style&&intended.test(which.tagName)){
 if (ns6&&eventobj.nodeType==3)
 eventobj=eventobj.parentNode.parentNode
 return true
 }
 else
 return false
 }

 //Function to highlight form element
 function highlight(e){
	 eventobj=ns6? e.target : event.srcElement
	 if (previous!=''){
	 if (checkel(previous))
	 previous.style.backgroundColor=''
	 previous=eventobj
	 if (checkel(eventobj))
	 eventobj.style.backgroundColor=highlightcolor
	 }
	 else{
		 if (checkel(eventobj))
		 eventobj.style.backgroundColor=highlightcolor
		 previous=eventobj
	 }
 }

 function cambiasello(sello, estado,id) {
	if (estado =="Disponible") {
		document.getElementById(id).value = sello; 
	}else{
		alert('Sello ' +sello+ ' No disponible');
	}
	 
 }
    
</script>
<?php include('barra.php'); ?>
<script type="text/javascript">
				var valor;
				var val="";
				var arreg = new Array("COMPUTADORAS","MONITOR","IMPRESORA","TECLADOS","MOUSE","ESCANNER","BOCINA","-1") ;
				function conex(t){
					if((t) =='s'){
						document.getElementById("resto3").style.display = "block";
						document.getElementById("resto4").style.display = "block";
					}else{
						document.getElementById("resto3").style.display = "none";
						document.getElementById("resto4").style.display = "none";					
					}
				}
				function llena(val){		
					for(i=0; i<arreg.length; i++){
						if((arreg[i]) !=val){
							document.getElementById("resto").style.display = "block";
							document.getElementById("resto").innerHTML = '<input onblur="carga(this.value);" name="usb" id="usb" type="text" size="40">';
						}			
					}
					
					if((val) !=""){	
						if((val) =="COMPUTADORAS"){
							document.getElementById("resto1").style.display = "block";
							document.getElementById("resto2").style.display = "block";
							document.getElementById("sellito1").style.display = "block";
							document.getElementById("sellito2").style.display = "block";
							document.getElementById("tipoc").style.display = "block";
							document.getElementById("tipoc1").style.display = "block";
						}else{
							document.getElementById("resto1").style.display = "none";
							document.getElementById("resto2").style.display = "none";
							document.getElementById("sellito1").style.display = "none";
							document.getElementById("sellito2").style.display = "none";
							document.getElementById("tipoc").style.display = "block";
							document.getElementById("tipoc1").style.display = "block";
						}
						if (val=="-1") {
						    document.getElementById("tipoc").style.display = "none";
							document.getElementById("tipoc1").style.display = "none";
						}
						if((val) =="COMPUTADORAS"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option>--</option><option value="PORT&Aacute;TIL">PORT&Aacute;TIL</option><option value="SERVIDOR NAS">SERVIDOR NAS</option><option value="ESCRITORIO">ESCRITORIO</option><option value="SERVIDOR">SERVIDOR</option><option value="CLIENTE LIGERO">CLIENTE LIGERO</option></select>';
						}else if((val) =="MONITOR"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option>--</option><option value="LCD">LCD</option><option value="LED">LED</option><option value="CRT">CRT</option></select>';
						}else if((val) =="TECLADOS"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option>--</option><option value="PS2">PS2</option><option value="USB">USB</option><option value="INAL&Aacute;MBRICO">INAL&Aacute;MBRICO</option><option value="PUERTO COM">PUERTO COM</option></select>';
						}else if((val) =="PLOTER"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option>--</option><option value="DE PLUMA">DE PLUMA</option><option value="DE CHORRO">DE CHORRO</option></select>';
						}else if((val) =="SWITCH"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option>--</option><option value="CABLEADO">CABLEADO</option><option value="INAL&Aacute;MBRICO">INAL&Aacute;MBRICO</option></select>';
						}else if((val) =="MODEM"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option>--</option><option value="INTERNOEXTERNO">EXTERNO</option><option value="INTERNO">INTERNO</option></select>';
						}else if((val) =="ROUTER"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option>--</option><option value="USB">USB</option><option value="PUERTO COM">PUERTO COM</option></select>';
						}else if((val) =="MEMORIAS"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option>--</option><option value="USB">USB</option></select>';
						}else if((val) =="MOUSE"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option>--</option><option value="PS2">PS2</option><option value="USB">USB</option><option value="INAL&Aacute;MBRICO">INAL&Aacute;MBRICO</option><option value="PUERTO COM">PUERTO COM</option><option value="DIMM">DIMM</option></select>';
						}else if((val) =="TECLADO"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option>--</option><option value="PS2">PS2</option><option value="USB">USB</option><option value="INAL&Aacute;MBRICO">INAL&Aacute;MBRICO</option><option value="PUERTO COM">PUERTO COM</option><option value="DIMM">DIMM</option></select>';
						}else if((val) =="IMPRESORA"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option>--</option><option value="Matricial">Matricial</option><option value="Laser">L&aacute;ser</option><option value="Chorro">Chorro de tinta</option><option value="T&eacute;rmica">T&eacute;rmica</option><option value="3d">3D</option></select>';
						}else if((val) =="ESCANNER"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option>--</option><option value="DE MESA">DE MESA</option><option value="DE TRAYECTORIA">DE TRAYECTORIA</option><option value="DE TAMBOR">DE TANBOR</option></select>';
						}else if((val) =="FOTOCOPIADORA"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option>--</option><option value="A COLOR">A COLOR</option><option value="BLANCO Y NEGRO">BLANCO Y NEGRO</option></select>';
						}else if((val) =="UPS"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option>--</option><option value="CONVENSIONALES">CONVENSIONALES</option><option value="PARA SERVIDORES">PARA SERVIDORES</option></select>';
						}else if((val) =="BOCINA"){
							document.getElementById("resto").innerHTML = '<select class="form-control" onchange="carga(this.value);" name="ta10" id="at10"><option>--</option><option value="PLUG">PLUG</option><option value="USB">USB</option></select>';
						}								
					}
				}
				function carga(valor){
					document.form1.usb.value=valor;
				}
				function showModalz(){
				  document.location='#modal4';
				}
			</script> 
<div id="cira"></div>
<div id="modal4" class="modalmask">
<div class="modalbox resize" style="width: 40%; height: 30%; border-radius: 5px 5px 5px 5px; margin-top:218px;">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -16px; width: 563px; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2 class="pos"><?php echo "Generar Talones de Sellos"; ?> </h2></div>
		<p><iframe src="sellos1.php" name="b" scrolling="Auto" width="102%" height="305" frameborder="0" class="notice" border="0"></iframe></p>
	</div>
</div>
<div id="buscad"> 
<fieldset class='fieldset'>
<legend class="vistauserx"><?php echo strtoupper($btregmedio);?><?php if(($unidadactiva) !=""){ echo "&nbsp;&nbsp;&nbsp;".$btdatosentidad3.": <font color='red'>".$unidadactiva."</font>"; }?></legend>	
	<table border="0" align="center" cellpadding="0" cellspacing="0" class="table" style="width:80%">
        <tr>
            <td colspan="4"></td>
        </tr>
		<form action="insertaraft.php" method="post" name="form1" onsubmit="return checke();" onKeyUp="highlight(event)" onClick="highlight(event)";><?php
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){ ?>
		 <input name="idunidades" type="hidden" id="idunidades" value="<?php echo $_COOKIE['unidades'];?>"><?php
		  } else{ ?>
		 <tr>
           <td width="175"><div align="right" class="contentheading"><?php echo strtoupper($btdatosentidad2);?></div></td>
            <td width="384">
				<select onkeypress="return handleEnter(this, event)" name="idunidades" class="form-control" size="1" id="idunidades" onchange="if((this.value) !='-1'){ verareas(this.value) }else{document.location='form-insertaraft.php';}">
					<option value="-1"><?php echo $seleccione.$LA.$btdatosentidad3;?></option><?php
					while($rowent = mysqli_fetch_array($result_uactiva)) {?>
							<option value="<?php echo $rowent['id_datos'];?>" <?php if(($rowent['id_datos']) ==@$_POST['idunidades']){ echo "selected";} ?>><?php echo $rowent['entidad']?></option><?php
					} ?>
				</select>
		   </td>
          </tr>		  
		  <?php } ?>
           <tr>
            <td><div align="right" class="contentheading"><?php echo substr($btAreas,0,-1);?></div></td>
            <td colspan="2"><div id="buscaarea">
				<select name="tt" class="form-control" size="1" id="tt" onchange="if((this.value) !='-1'){ verusuarios(this.value, document.getElementById('idunidades').value) }else{document.location='form-insertaraft.php';}"><?php
					if(isset($_POST['idunidades']) OR isset($_COOKIE['unidades'])){ ?>
						<option value="-1"><?php echo $plea8.substr($btAreas,0,-1);?></option><?php
						while ($row_R = mysqli_fetch_array($Record)) {
							if(($row_R['nombre']) !="Reparaciones"){?>
								<option value="<?php echo $row_R['idarea'];?>" <?php if((@$_POST['tt']) ==$row_R['idarea']){ echo "selected";}?>><?php echo $row_R['nombre']?></option><?php
							}
						} 
					}?>
              </select></div>
		    </td>
	      </tr>
		  <tr>
            <td width="175"><div align="right" class="contentheading">INV</div></td>
            <td colspan="2"><input onkeypress="return handleEnter(this, event)" name="inv" class="form-control" type="text" id="inv" value="<?php echo @$_POST['inv'];?>" onblur="return valida(this.value,'aft','inv');" onkeyup="return valida(this.value,'aft','inv');"><span id="inv11" class="textod"></span></td>
          </tr>
          <tr>
            <td><div align="right" class="contentheading"><?php echo $DESCRIPCION;?></div></td>
            <td colspan="2"><div><input onkeypress="llamaorgano(this.value,'categ','desc','catego'); return handleEnter(this, event);" name="desc" class="form-control" type="text" id="desc" value="<?php echo @$_POST['desc'];?>" size="40" onblur="return valida(this.value,'aft','descrip');" onkeyup="return valida(this.value,'aft','descrip');"><span id="inv12" class="textod"></span><span id="catego" onClick="document.getElementById('catego').style.display ='none';" class="mstra"></span></div></td>
          </tr>
          <tr>
            <td><div align="right" class="contentheading"><?php echo strtoupper($btestado);?></div></td>
            <td colspan="2"><label>
              <select onkeypress="return handleEnter(this, event)" name="estado" size="1" id="estado" class="form-control">
                <option value="A"><?php echo $btActivo;?></option>
                <option value="R"><?php echo $btRoto;?></option>
                <option value="T"><?php echo $btTaller;?></option>
              </select>
            </label></td>
          </tr>         
		  <tr>
            <td><div align="right" class="contentheading"><?php echo strtoupper(strtolower($btMARCA));?></div></td>
            <td colspan="2"><input onkeypress="return handleEnter(this, event)" name="marca" class="form-control" type="text" id="marca" size="40" onKeyUp="llamaorgano(this.value,'marcas','marca','orgn');"><span id="orgn" onClick="document.getElementById('orgn').style.display ='none';" class="mstra" ></span>
		    </td>
		 </tr>
          <tr>
		  <td><div align="right" class="contentheading">SERIE</div></td>
           <td colspan="2"><input onkeypress="return handleEnter(this, event)" name="serie" class="form-control" type="text" id="serie" size="40"></td>
		  </tr>
          <tr>
		  <td><div align="right" class="contentheading"><?php echo strtoupper(strtolower($btMODELO));?></div></td>
            <td colspan="2">
			  <input onkeypress="return handleEnter(this, event)" name="modelo" class="form-control" type="text" id="modelo" size="40">
			</td>
		  </tr>
          <tr>
		  <td><div align="right" class="contentheading"><?php echo $btcategmedios2;?></div></td>
            <td colspan="2"><?php
				if(isset($_GET['u'])){ ?>
					<input name="flash" class="form-control" readonly type="text" id="flash" size="20" value="MEMORIAS" onKeyup="document.getElementById('isert').style.display='block;';"><?php
				}else{ ?>
				  <select onkeypress="return handleEnter(this, event)" name="flash" size="1" class="form-control" id="flash" onchange="llena(this.value); if (this.value !=-1) { document.getElementById('isert').style.display='block'; }else{ document.getElementById('isert').style.display='none'; }">
					  <option value="-1"><?php echo $seleccione.$btcategmedios1;?></option>   <?php
					while ($row_Recordset3 = mysqli_fetch_array($Recordset3)){  ?>
					  <option value="<?php echo $row_Recordset3['nombre']?>"><?php echo $row_Recordset3['nombre']?></option> <?php
					} ?>
				  </select><?php
				 } ?>
            </td>
		  </tr>
			<tr>
			  <td><div align="right" id="tipoc" style="display:none;" class="contentheading"><?php echo strtoupper($bttipo);?><input name="muestra1" type="checkbox" id="muestra1" style="cursor:pointer; display:none;" onClick="" value="muestra1" />
			  <span manolo="Mostrar/Ocultar Sellos" id="oji0" style="background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -379px 180px; height: 21px; width: 30px; float: right; cursor: pointer; position: absolute; margin-left: 19px; margin-top: -2px; color: blue; font-style: italic; font-size: smaller;" onmouseover="this.style.cursor='pointer';" onclick="if (getElementById('muestra1').checked==false) {getElementById('muestra1').checked=true; }else{getElementById('muestra1').checked=false;} if(getElementById('muestra1').checked) { document.getElementById('sellito1').style.display = 'block'; document.getElementById('sellito2').style.display = 'block';}else{document.getElementById('sellito1').style.display = 'none'; document.getElementById('sellito2').style.display = 'none';}"></span></div></td>
				<td colspan="2"><div id="tipoc1" style="display:none;" ><?php
					if(isset($_GET['u'])){ ?>								
						<input name="usb" class="form-control" readonly type="text" id="usb" size="20" value="USB"><?php
					}else{ ?>
						<div id="resto"><select onkeypress="return handleEnter(this, event)" class="form-control" onchange="carga(this.value);" name="usb" id="usb"><option value="-1">--</option></select></div><?php
					} ?></div>
			  </td>
			</tr>
			<tr>
            <td><div id="sellito1" style="display:none;"><div align="right" class="contentheading"><?php echo strtoupper($btSELLO);?></div></div></td>
           	<td colspan="2"><div id="sellito2" style="display:none;">
			    <input type="text" readonly class="form-control" name="sello" id="sello" style="width:30%; height:19px;" value="">
			    <select style="height: 23px; width: 24%; margin-top: -23px; margin-left: 258px; position: absolute;" onkeypress="return handleEnter(this, event)" name="sellos" id="sellos" class="form-control" size="1">
				<option value="-1"><?php echo $nuevsello; ?></option><?php 
					while ($row_Recordset5 = mysqli_fetch_array($Recordset5)) { ?>
						<option value="<?php echo $row_Recordset5['numero']?>" onClick="cambiasello(this.value,'<?php echo $row_Recordset5['estado']; ?>','sello');"><?php echo $row_Recordset5['numero']?></option><?php
					} ?>
				</select><?php if($damemas==0) { ?>
				  <i id="massellos<?php echo "1"; ?>" onclick="showModalz();" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -23px; margin-left: 590px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -1px -90px;'></i><span style="cursor: pointer; margin-top: -22px; width: 24%; margin-left: 193px;" manolo="<?php echo $clickmas.''; ?>"></span><?php } ?></div>
			</td>
		    </tr>
		  <tr>
		  <td><div align="right" class="contentheading"><?php echo strtoupper($btCustodios);?></div></td>
            <td colspan="2"><div id="vistauser">
              <select onkeypress="return handleEnter(this, event)" name="custod" onchange="document.getElementById('custo').value=this.value" class="form-control" id="custod"><?php
				if(isset($_POST['tt'])){ ?>
				  <option value="-1"><?php echo $seleccione.$btCustodios;?></option><?php
					while ($row_Recordset1 = mysqli_fetch_array($Recordset1)){   ?>
						<option value="<?php echo $row_Recordset1['nombre']?>"><?php echo $row_Recordset1['nombre']?></option><?php
					} 
				}?> 
              </select></div>
            </td>
		  </tr>
          <tr>
		  <td><div align="right" class="contentheading"><?php echo strtoupper($bttipo);?>-AFT</div></td>
            <td colspan="2"><label>
              <select onkeypress="return handleEnter(this, event)" name="taft" size="1" class="form-control" id="taft"><?php
				while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4)){ ?>
					<option value="<?php echo $row_Recordset4['categoria']?>"><?php echo $row_Recordset4['descrip']?></option><?php
				} ?>
              </select>
            </label></td>
		  </tr>
			<tr>
			  <td><div id="resto1" align="right" class="contentheading"><?php echo $btenred;?></div></td>
				<td colspan="2">
					<div id="resto2">
						<select onkeypress="return handleEnter(this, event)" class="form-control" onchange="conex(this.value);" name="enred" id="enred">
							<option value="s"><?php echo $yes1;?></option>
							<option value="n" selected >No</option>
						</select>
					</div>					
				</td>
			</tr>			
			<tr>
			  <td><div id="resto3" align="right" class="contentheading"><?php echo $btConectividad;?></div></td>
				<td colspan="2">
					<div id="resto4">
						<select onkeypress="return handleEnter(this, event)" class="form-control" name="conect" id="conect">
							<option value="-1">---</option>
							<option value="Intranet">Intranet</option>
							<option value="Internet">Internet</option>
						</select>					
					</div>					
				</td>
			</tr>	
            <tr>
              <td colspan="2"><div id="isert" style="display:block;">
			    <input type="submit" name="insertar" value="<?php echo $btinsertar?>" class="btn">
				<input type="button" onclick="document.location='registromedios1.php';" name="cancelar" value="<?php echo $btcancelar; ?>" class="btn">
				<input name="usb" id="usb" type="hidden" value="<?php echo @$_POST['usb'];?>">
				<input name="narea" id="narea" type="hidden" value="<?php echo @$_POST['tt'];?>">
				<input name="custo" id="custo" type="hidden" value="<?php echo @$_POST['custod'];?>">
				<input name="idunid" id="idunid" type="hidden" value="<?php echo @$_POST['idunidades'];?>"></div>
			  </td>
			</tr>         
        </form>	
    </table>
</div>
</fieldset><br><?php include('version.php'); ?>
<script type="text/javascript">
	var val1="";
	document.getElementById("resto1").style.display = "none";
	document.getElementById("resto2").style.display = "none";
	document.getElementById("resto3").style.display = "none";
	document.getElementById("resto4").style.display = "none";
	esconde(val1);
</script>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>