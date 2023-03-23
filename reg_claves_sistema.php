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
include ('header.php');
include ('script.php');
include('mensaje.php');
$mens="";
$i=0;
$consul_aft ="SELECT * FROM aft";
$resul_aft = mysqli_query($miConex, $consul_aft) or die(mysql_error());

if (isset($_REQUEST['us']) AND !isset($_REQUEST['aceptar'])){
	$explu = explode('*',$_REQUEST['us']);
	$sedu = mysqli_query($miConex, "select * from usuarios where login='".$explu[0]."' AND idunidades='".$explu[1]."'") or die(mysql_error());
	$rsedu=mysqli_fetch_array($sedu);
	$consul_dg ="SELECT * FROM reg_claves where usuario='".htmlentities($explu[2])."' AND equipo='".$_REQUEST['med']."' AND idunidades='".$explu[1]."'";
	$resul_dg = mysqli_query($miConex, $consul_dg) or die(mysql_error());
	$rsdfg = mysqli_num_rows($resul_dg);
	if(($rsdfg) !=0){ $mens=sprintf($btnomedio1,$explu[2],$_REQUEST['med']); }
}
if (isset($_REQUEST['user']) AND !isset($_REQUEST['aceptar'])){
	$explu = explode('*',$_REQUEST['user']);
	$sedu = mysqli_query($miConex, "select * from usuarios where login='".$explu[0]."' AND idunidades='".$explu[1]."'") or die(mysql_error());
	$rsedu=mysqli_fetch_array($sedu);
	$consul_dg ="SELECT * FROM aft where custodio='".$rsedu['nombre']."' AND categ='COMPUTADORAS' AND idunidades='".$explu[1]."'";
	$resul_dg = mysqli_query($miConex, $consul_dg) or die(mysql_error());
	$rsdfg = mysqli_num_rows($resul_dg);
	if(($rsdfg) ==0){ $mens=sprintf($btnomedio,$explu[0]); }
}
		$queryu="select* from usuarios where login='".$_SESSION ["valid_user"]."'";
		$resultu=mysqli_query($miConex, $queryu) or die(mysql_error());
		$rowu = mysqli_fetch_array ($resultu);


	 if (isset($_REQUEST['aceptar'])){	
		$explu1 = explode('*',$_REQUEST['user2']);	 
		$tt="select* from usuarios where login='".$explu1[0]."' AND idunidades='".$_REQUEST['idunidades']."'";
		$rtt=mysqli_query($miConex, $tt) or die(mysql_error());
		$rott = mysqli_fetch_array ($rtt);
		
		$sql_inser="insert into reg_claves (id_area, equipo, login, usuario, setup, sistema,idunidades,idarea) values ('".$rott['id_area']."','".$_REQUEST['pc']."','".$_REQUEST['login']."','".$rott['nombre']."','".base64_encode($_REQUEST['clave'])."','".base64_encode($_REQUEST['clave1'])."','".$rott['idunidades']."','".$rott['idarea']."')"; 
		$resultadof = mysqli_query($miConex, $sql_inser) or die(mysql_error()); ?>
		<script type="text/javascript">document.location="reg_claves_sistema.php";</script><?php
	} 

include('barra.php');?>
<style type="text/css">
	.email{
		background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
		height: 16px;
		background-position: 0 -37px;
	}
	.pdf{
		background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
		height: 16px;
		background-position: 0 -117px;
	}
	.exel{
		background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
		height: 16px;
		background-position: 0 -97px;
	}
	.printer{
		background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
		height: 16px;
		background-position: 0 -17px;
	}
</style>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script><?php
	include('jquery.php'); ?>
<div id="buscad"> 
<script type="text/javascript">
function checa(setupq,viejaq,valor){
    var de = valor 
	 if (de.length  ==0) {
	 	document.getElementById(setupq).value = document.getElementById(viejaq).value; 
	}
}
function muestraclave(setup,clavevieja) {
    if (document.getElementById(setup).style.display="none") {
      document.getElementById(clavevieja).style.display="none";
	  document.getElementById(setup).style.display="block";
	  document.getElementById(setup).focus();
	}else{
	  document.getElementById(clavevieja).style.display="block";
	  document.getElementById(setup).style.display="none";
	}
 }
function decodifica(estado,codif,decodif,id,idcodif){
    if (estado==true){
	  document.getElementById(id).value=decodif;
	}else{
	 document.getElementById(id).value=document.getElementById(idcodif).value;
	}
 }
 
function submit_page() {
	// form validation check
	var formValid=false;
	var f = document.formulario;
	if ( f.clave.value == '' ) {
		alert('Por favor, debe especificar una clave para el Setup.');
		f.clave.focus();
		formValid=false;
	}else if ( f.clave1.value == '' ) {
		alert('Por favor, debe especificar una clave para el Sistema Operativo.');
		f.clave1.focus();
		formValid=false;
	} else if ( confirm('Son estos datos correctos?')) 
	  {	formValid=true;  }

	return formValid;
}
	function cambiauser(ud){
		if((ud) !="-1"){
			document.formularioU.submit();
		}else{
			document.location="reg_claves_sistema.php";
		}
	}
	function cambiauser1(ud1){
		if((ud1) !="-1"){
			<?php if(isset($_REQUEST['us'])){ $ud1=$_REQUEST['us'];} if(isset($_REQUEST['user'])){ $ud1=$_REQUEST['user'];}?>
			document.location="reg_claves_sistema.php?med="+ud1+"&us=<?php echo @$ud1;?>";
		}else{
			document.getElementById('login').disabled=true;
			document.getElementById('clave1').disabled=true;
			document.getElementById('clave').disabled=true;
		}
	}
	function cambiapc(){
		var emptyForm2 = true;
		with (document2.formularioPC){      
			emptyForm2 = (pc.value == "");		
			if (!emptyForm2)	{
				submit();	
			}	
		}
	}
	function hacer(valo){
		document.location="reg_claves_sistema.php?marcado[]="+valo+"&edit=edit";

	}
	function limpia(){
		document.getElementById("palabraa").value ="";
	}
</script>
<form action="" method="post" name="contel" id="contel">
	<input name="crash" value="1" type="hidden">
	<input name="marcado[]" id="marcado" type="hidden">
</form>
<form action="" method="post" name="conted" id="conted">
	<input name="edit" value="1" type="hidden">
	<input name="marcado[]" id="marcado" type="hidden">
</form>
<form action="" method="post" name="nuevo" id="nuevo">
	<input name="insert" value="1" type="hidden">
</form>
<script type="text/javascript">
function accion(id,q){
	if((q) =="el"){
		if(confirm('Realmente desea Eliminar este registro?')){
			document.contel.marcado.value=id;
			document.contel.submit();
		}
	}else if((q) =="nu"){
		document.getElementById('nclaves').style.display='block';
		document.getElementById('claves').style.display='none';
		document.getElementById('bus').style.display='none';
	}else{
		document.conted.marcado.value=id;
		document.conted.submit();
	}
}
function contextual(event,id){
 		var iX = event.clientX;
		var iY = event.clientY;
		event.preventDefault();
		$('#divMenu').css ({
			display:	'block',
			left:		iX,
			top:		iY
		});

		$('#divMenu').html('<ul><a style="cursor:pointer; text-decoration:none;" onclick="accion(\''+id+'\',\'nu\');"><li><img title="Nuevo..." align="asbmiddle" src="images/mostrar.png" width="16" height="16">&nbsp;&nbsp;Nuevo</li></a><a style="cursor:pointer; text-decoration:none;" onclick="accion(\''+id+'\',\'ed\');"><li><img title="Editar..." align="asbmiddle" src="images/editar.png" width="16" height="16">&nbsp;&nbsp;Editar</li></a><a style="cursor:pointer; text-decoration:none;" onclick="accion(\''+id+'\',\'el\');"><li><img align="asbmiddle" src="images/delete.png" width="16" height="16" title="Eliminar...">&nbsp;&nbsp;Eliminar</li></a></ul>');
}
</script>
<body onload="<?php if (isset($_REQUEST['user']) AND $_REQUEST['user']!="-1") { echo $_REQUEST['user']; ?>document.getElementById('bus').style.display='none';<?php } ?>">
<div id="divMenu"></div>
<div id="cira"> </div>
<script type="text/javascript" src="ajax.js"></script>
<fieldset class="fieldset"><legend class="vistauserx"><?php echo substr($mostrar1,0,-1).$de.$btpassw1;?><?php if(($unidadactiva) !=""){ echo "&nbsp;&nbsp;&nbsp;".$btdatosentidad3.": <font color='red'>".$unidadactiva."</font>"; }?></legend>
	<div id="openModal" class="modalDialog">
		<div>
			<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
			<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
		</div>
	</div>
<?php 
    if(($total_filas) >1){  ?>
				<form action="" method="post" name="formU"><?php echo $btdatosentidad2;?>:
					<select name="unidades" id="unidades" class="boton" onchange="cambiaunidad(this.value,'reg_claves_sistema.php');">
						<option value="-1"><?php echo $btmostrartodo1?></option><?php 
						while ($row1=mysqli_fetch_array($reado)){ ?>					
							<option value="<?php echo @$row1['id_datos'];?>" <?php if((@$row1['id_datos']) ==@$_COOKIE['unidades']){ echo "selected";}?>><?php echo @$row1['entidad'];?></option><?php
						} ?>
					</select>
					<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
					<input name="palabra" type="hidden"  value="<?php echo $palabra;?>">
					<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">			
				</form><br><?php 
	}
	if(empty($resul_aft)){
		show_message("Mensaje de Error","No se han creado a&uacute;n Medios para asignarle claves de Usuarios.","warning","configura.php"); 
		exit;
	}
	if(isset($_REQUEST['total_paginas'])){ $total_paginas = $_REQUEST['total_paginas'];}
	if(isset($_REQUEST['crash']) AND ($_REQUEST['crash']) !=""){
		$marcado=@$_REQUEST['marcado'];
		if(empty($marcado)){
			show_message("Mensaje de Error","Por favor seleccione al menos un elemento para Modificar.","warning","reg_claves_sistema.php"); 
		exit;
		}		
		foreach($marcado as $F){
			$sqld="delete from reg_claves where id = '".$F."'"; 
			$resultd=mysqli_query($miConex, $sqld) or die(mysql_error());
		} ?>
		<script type="text/javascript">document.location="reg_claves_sistema.php";</script><?php
		
	} 

	if(isset($_REQUEST['edit']) OR isset($_REQUEST['edit']) AND !isset($_REQUEST['modificado'])){
		if(isset($_REQUEST['marcado'])) {$marcado=$_REQUEST['marcado'];}
		if(isset($_REQUEST['marcado'])) {$marcado=$_REQUEST['marcado'];} ?>	
	 	
			<form name="mod" method="get" action="">
				<table width="100%" border='0' align="center" class="table">
					<tr class="vistauser1">
					    <td width="280" align="center"><b><?php echo strtoupper($btCustodios1);?></b></td>
					    <td width="163" align="center"><b>PC</b></td>
					    <td width="150" align="center"><b>LOGIN</b></td>
					    <td width="177" align="center"><b>SETUP</b></td>
						<td width="162" align="center"><b><?php echo strtoupper($btSistema);?></b></td>
					</tr><?php	
					$w =0;
					foreach($marcado as $f1){ $w++;
						$sqld="select * from reg_claves where id ='".$f1."'"; 
						$resultd=mysqli_query($miConex, $sqld) or die(mysql_error());	
						$rows = mysqli_fetch_array($resultd); ?>
						<tr>
						  <td>&nbsp;&nbsp;<?php echo $rows["usuario"];?><input type="hidden" name="usuario[]" value="<?php echo $rows["usuario"];?>"><input type="hidden" name="id[]" value="<?php echo $rows["id"];?>"></td>
							<td>&nbsp;&nbsp;<?php echo $rows["equipo"];?><input name="equipo[]" readonly type="hidden" value="<?php echo $rows["equipo"];?>"></td>
							<td align="center"><input class="imput" name="login[]" type="text" value="<?php echo $rows["login"];?>">
							</td>
							<td align="center">
								<input name="setup[]" id="setup<?php echo $w;?>" class="imput" style="display:none;" type="text" value="" size="50" maxlength="50">
								<input name="clavevieja[]" id="clavevieja<?php echo $w;?>" class="imput" type="text" value="<?php echo $rows['setup'];?>" onclick="muestraclave('<?php echo 'setup'.$w; ?>','<?php echo 'clavevieja'.$w; ?>'); document.getElementById('muestram<?php echo $w;?>').style.display='none';">
								<input name="decodif[]" id="decodif<?php echo $w;?>" type="hidden" value="<?php echo base64_decode($rows['setup']);?>">
								<input name="codif[]" id="codif<?php echo $w;?>" type="hidden" value="<?php echo $rows['setup'];?>">
								<div id="muestram<?php echo $w;?>" style="display:block;"><input name="muestra[]" type="checkbox" id="muestra<?php echo $w;?>" style="cursor:pointer; display:none;" value="muestra" />
							    <span manolo='Mostrar/Ocultar Contrase&ntilde;a' id="ojo<?php echo $w;?>" style="background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -113px 202px; height: 26px; width: 30px; float: right; cursor: pointer; position: absolute; margin-left: 183px; margin-top: -30px;" onmouseover="this.style.cursor='pointer';" onclick="if (getElementById('muestra<?php echo $w;?>').checked==false) {getElementById('muestra<?php echo $w;?>').checked=true; }else{getElementById('muestra<?php echo $w;?>').checked=false;} decodifica(getElementById('muestra<?php echo $w;?>').checked,getElementById('codif<?php echo $w;?>').value,getElementById('decodif<?php echo $w;?>').value, 'clavevieja<?php echo $w;?>','codif<?php echo $w;?>'); if(getElementById('muestra<?php echo $w;?>').checked) { getElementById('ojo<?php echo $w;?>').style='background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -559px 202px; height: 26px; width: 30px; float: right; cursor:pointer; position: absolute; margin-left: 183px; margin-top: -30px;'}else{ getElementById('ojo<?php echo $w;?>').style='background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -113px 202px; height: 26px; width: 30px; float: right; cursor:pointer; position: absolute; margin-left: 183px; margin-top: -30px;'} "></span></div>
							</td>
							</td>
							<td align="center">
								<input name="sistema[]" id="sistema<?php echo $w; ?>" class="imput" style="display:none;" type="text" value="">
								<input name="clavevieja1[]" id="clavevieja1<?php echo $w;?>" class="imput" type="text" value="<?php echo $rows['sistema'];?>" onclick="muestraclave('<?php echo 'sistema'.$w; ?>','<?php echo 'clavevieja1'.$w; ?>'); document.getElementById('muestram1<?php echo $w;?>').style.display='none';">
								<input name="decodifa[]" id="decodifa<?php echo $w;?>" type="hidden" value="<?php echo base64_decode($rows['sistema']);?>">
								<input name="codifa[]" id="codifa<?php echo $w;?>" type="hidden" value="<?php echo $rows['sistema'];?>">
								<div id="muestram1<?php echo $w;?>" style="display:block;"><input name="muestra1[]" type="checkbox" id="muestra1<?php echo $w;?>" style="cursor:pointer; display:none;" onClick="decodifica(getElementById('muestra1<?php echo $w;?>').checked,getElementById('codifa<?php echo $w;?>').value,getElementById('decodifa<?php echo $w;?>').value, 'clavevieja1<?php echo $w;?>','codifa<?php echo $w;?>');" value="muestra1" />
							    <span manolo='Mostrar/Ocultar Contrase&ntilde;a' id="oji<?php echo $w;?>" style="background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -113px 202px; height: 26px; width: 30px; float: right; cursor: pointer; position: absolute; margin-left: 183px; margin-top: -30px;" onmouseover="this.style.cursor='pointer';" onclick="if (getElementById('muestra1<?php echo $w;?>').checked==false) {getElementById('muestra1<?php echo $w;?>').checked=true; }else{getElementById('muestra1<?php echo $w;?>').checked=false;} decodifica(getElementById('muestra1<?php echo $w;?>').checked,getElementById('codifa<?php echo $w;?>').value,getElementById('decodifa<?php echo $w;?>').value, 'clavevieja1<?php echo $w;?>','codifa<?php echo $w;?>'); if(getElementById('muestra1<?php echo $w;?>').checked) { getElementById('oji<?php echo $w;?>').style='background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -559px 202px; height: 26px; width: 30px; float: right; cursor:pointer; position: absolute; margin-left: 183px; margin-top: -30px;'}else{ getElementById('oji<?php echo $w;?>').style='background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -113px 202px; height: 26px; width: 30px; float: right; cursor:pointer; position: absolute; margin-left: 183px; margin-top: -30px;'} "></span></div>
								<input name="idunidades[]" type="hidden" value="<?php echo $rows["idunidades"];?>">
							</td>
						</tr>
						<tr><td colspan="5"><hr></td></tr><?php
					}	  
					?>
						<tr>
							<td colspan="2">
								<input type="submit" name="modificado" value="<?php echo $btaceptar;?>" class="btn">&nbsp;&nbsp;
								<input type="button" name="retur" value="<?php echo $btcancelar;?>" class="btn" onClick="document.location='reg_claves_sistema.php';">
							</td>
						</tr>
				</table>
			</form></fieldset><br>
<br><?php include ("version.php");?>
<?php exit;
	}
	if(isset($_REQUEST['modificado'])){
		$id = $_REQUEST['id'];
		$login = $_REQUEST['login'];
		$setup = $_REQUEST['setup'];
		$sistema = $_REQUEST['sistema'];
		$clavevieja = $_REQUEST['clavevieja'];
		$clavevieja1 = $_REQUEST['clavevieja1'];
		$r=0; 	
	
		foreach($id as $key){
			if($setup[$r] =='') {
			  $setup[$r] = base64_decode($clavevieja[$r]);
			}

			if ($sistema[$r] =='') {
			   $sistema[$r] = base64_decode($clavevieja1[$r]);
			}
			if (($setup[$r] !=="") AND ($sistema[$r] !=="")) {
			  $up = "update reg_claves set login ='".htmlentities($login[$r])."', setup='".base64_encode($setup[$r])."', sistema='".base64_encode($sistema[$r])."' where id ='".$key."'";
			  $que = mysqli_query($miConex, $up) or die(mysql_error());	
			}
			$r++;
		} ?>
		<script type="text/javascript">document.location="reg_claves_sistema.php";</script><?php
	}
?>
<?php
	// SQL para la b�squeda
	$quer = "";
	$qq = "-1";
	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$consulta ="SELECT * FROM usuarios where idunidades='".$_COOKIE['unidades']."' ORDER BY nombre";
	}else{
		$consulta ="SELECT * FROM usuarios ORDER BY nombre";
	}
	$resultado = mysqli_query($miConex, $consulta) or die(mysql_error());
	$totalRows = mysqli_num_rows($resultado);

	$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
	$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
	$rsel = mysqli_fetch_array($qsel);
	$cuantos = 15;
	if(($rsel['visitas']) !=""){
		$cuantos = $rsel['visitas'];
	}
///////navegador
		$inicio = 0;
		$pagina = 1;
		$registros = $cuantos;
	if(isset($_REQUEST["registros"])) {
		$registros = $_REQUEST["registros"];
		$inicio = 0;
		$pagina = 1;
	}
	if(isset($_REQUEST['pagina']))  {
		$pagina=$_REQUEST['pagina'];
		$inicio = ($pagina - 1) * $registros;
	}
	if(isset($_REQUEST["mostrar"])) {
		$registros = $_REQUEST["mostrar"];
		if(($registros) ==0){ $registros=1;}
		$inicio = 0;
		$pagina = 1;
	}
///////////
	$explu2[0]="";
	$explu3[0]="";
	if(isset($_REQUEST['us']) OR isset($_REQUEST['user'])){
		if(isset($_REQUEST['us'])){	$explu2 = explode('*',$_REQUEST['us']);	}
		if(isset($_REQUEST['user'])){	$explu2 = explode('*',$_REQUEST['user']);	}
		$sus = "select * from usuarios where login='".htmlentities($explu2[0])."' AND idunidades='".$explu2[1]."'";
		$seu = mysqli_query($miConex, $sus) or die(mysql_error());
		$qseu = mysqli_fetch_array($seu);

		if(($qseu['tipo']) =="root"){
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$quer=" where idunidades='".$_COOKIE['unidades']."'";
			}else{
				$quer="";
			}
		}elseif(($qseu['tipo']) =="usuario"){
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$quer=" where custodio='".$qseu['nombre']."' AND (idunidades='".$_COOKIE['unidades']."')";
			}else{
				$quer=" where custodio='".$qseu['nombre']."'";
			}
		}
		if(isset($_REQUEST['us'])){	$explu3 = explode('*',$_REQUEST['us']);	}
		if(isset($_REQUEST['user'])){	$explu3 = explode('*',$_REQUEST['user']);	}
		
		$qq = $explu3[0];
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$qus = mysqli_query($miConex, "select tipo from usuarios where nombre ='".htmlentities($explu2[2])."' AND idunidades='".$explu2[1]."'") or die(mysql_error());
			$rusx = mysqli_fetch_array($qus);		
			if(($rusx['tipo']) =="root"){
				$quer=" where idunidades='".$_COOKIE['unidades']."'";
			}else{
				$quer=" where custodio ='".htmlentities($explu2[2])."' and idunidades='".$_COOKIE['unidades']."'";
			}			
		}elseif(($explu2[1]) !=""){
			$qus = mysqli_query($miConex, "select tipo from usuarios where nombre ='".htmlentities($explu2[2])."' AND idunidades='".$explu2[1]."'") or die(mysql_error());
			$rusx = mysqli_fetch_array($qus);		
			if(($rusx['tipo']) =="root"){
				$quer=" where idunidades='".$explu2[1]."'";
			}else{
				$quer=" where custodio ='".htmlentities($explu2[2])."' and idunidades='".$explu2[1]."'";
			}			
		}else{
			$quer="";
		}
	}
	$consulta1 ="SELECT * FROM exp ".$quer." ORDER BY n_PC";
	$resultado1 = mysqli_query($miConex, $consulta1) or die(mysql_error());
	$totalRows1 = mysqli_num_rows($resultado1);
	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$sql="SELECT * FROM reg_claves where idunidades='".$_COOKIE['unidades']."'";
	}else{
		$sql="SELECT * FROM reg_claves";
	}
	$query_limit = sprintf("%s ORDER BY usuario	LIMIT %d, %d",$sql, $inicio, $registros);
	$result=mysqli_query($miConex, $query_limit) or die(mysql_error());
	$num_resultados = mysqli_num_rows($result);
	
	//NAVEGADOR inicio
	if(isset($_REQUEST['total_registros']))  {  
		$total_registros=$_REQUEST['total_registros'];
	} else { 
		$all_rsDA = mysqli_query($miConex, $sql) or die(mysql_error());
		$total_registros = mysqli_num_rows($all_rsDA);	
	}
	if ($registros != 0) {
	 $total_paginas = ceil($total_registros / $registros);
	}
	$ggg = base64_encode($query_limit); ?>
	<?php if(($rus["tipo"]) =="root") { ?>
	<div id="nclaves" <?php if(isset($_REQUEST['user']) OR isset($_REQUEST['med'])){ ?> style="display:block;"<?php }else{ ?> style="display:none;"<?php }?>>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table">  
			<tr class="vistauser1">
				<td width="200"><strong><?php echo substr($new6,0,-1);?></strong></td>
				<td width="173"><strong>PC</strong></td>
				<td width="173" ><strong>Login</strong></td>
				<td width="156"><strong><?php echo $clave;?>Setup</strong></td>
				<td width="156"><strong><?php echo $clave.$btSistema;?></strong></td>
			</tr>
			<tr>
				<td>
					<form action="" method="post" name="formularioU">
						<select name="user" id="user" class="form-control" style="width:100%" onChange="cambiauser(this.value);" >
							<option value="-1"><?php echo $selectusr1;?></option><?php 
							if(isset($_REQUEST['us'])){ $explupu = explode('*',$_REQUEST['us']);}
							if(isset($_REQUEST['user'])){ $explupu = explode('*',$_REQUEST['user']);}
							while ($row1=mysqli_fetch_array($resultado)){ ?>					
								<option value="<?php echo $row1['login']."*".$row1['idunidades']."*".$row1['nombre'];?>" <?php  if(($row1['login']) ==htmlentities(@$explupu[0])){ echo "selected";} ?>><?php echo $row1['nombre'];?></option><?php
							} ?>
						</select>
					</form>			
				</td>
				<form action="" method="post" name="formulario" onSubmit="return alertax();"><?php 
					if(($mens) !=""){  ?>
						<td colspan="5"><div style="position: absolute; top: 290px; left: 380px;"><?php echo $mens;?>&nbsp;&nbsp;</div></td><?php
					}else{  ?>	
					<td>
							<select name="pc" id="pc" class="form-control" style="width:100%" <?php if(!isset($_REQUEST['us']) AND !isset($_REQUEST['user'])){ echo "disabled='disabled'";}?> onChange="cambiauser1(this.value);  document.getElementById('bus').style.display='none';">
								<option value="-1"><?php echo $seleccione.$LA;?> PC</option><?php 
								  if(isset($_REQUEST['us'])){$explu7 = explode('*',$_REQUEST['us']);}
								  if(isset($_REQUEST['user'])){$explu7 = explode('*',$_REQUEST['user']);}							
								  if(isset($_REQUEST['us']) OR isset($_REQUEST['user'])){								
									while ($row2=mysqli_fetch_array($resultado1)){ ?>
										<option value="<?php echo $row2['n_PC'];?>" <?php if(($row2['n_PC']) ==@$_REQUEST['med']){ echo "selected";}?>><?php echo $row2['n_PC'];?></option><?php 
									} 
								}?>
				            </select><?php 						
							if(isset($_REQUEST['us'])){ $explu5 = explode('*',$_REQUEST['us']);	 }
							if(isset($_REQUEST['user'])){ $explu5 = explode('*',$_REQUEST['user']);	 }?>
					</td>
				    <td><?php 
						if(($mens) ==""){ 
							if(isset($_REQUEST['med'])){
								$sclc=mysqli_query($miConex, "select setup from reg_claves where equipo='".$_REQUEST['med']."'") or die(mysql_error());
								$qsclc =mysqli_fetch_array($sclc);
							} ?>
				        <input name="clave" id="clave" type="text" class="form-control" <?php if((@$qsclc["setup"]) !=""){ echo "readonly";} ?> value="<?php echo @base64_decode($qsclc["setup"]);?>" size="15" <?php if(!isset($_REQUEST['us'])){ echo "disabled='disabled'";}?> />
					</td>
					<td>
						 <input name="login" type="text" <?php if(!isset($_REQUEST['us'])){ echo "disabled='disabled'";}?> class="form-control" id="login" size="15">
					</td>
					<td>
					    <input name="clave1" type="text" class="form-control" id="clave1" value="" size="15" <?php if(!isset($_REQUEST['us'])){ echo "disabled='disabled'";}?> />
					<?php } ?>
					</td> <?php 
					} ?>
			</tr>
			<tr>
			  <td colspan="5"><?php if(($mens) ==""){ ?>
			    <input type="submit" name="aceptar" value="<?php echo $btaceptar;?>" class="btn" <?php if(!isset($_REQUEST['us'])){ echo "disabled='disabled'";}?>/>
		        <?php } ?>
		        <input name="user2" type="hidden" value="<?php echo @$explu5[0];?>" />
		        <input name="idunidades" type="hidden" value="<?php echo @$explu5[1];?>" />
		        <input name="cancela2" type="button" value="<?php echo $btcancelar;?>" class="btn" onClick="document.location='reg_claves_sistema.php';" />
			  </td>
            </tr></form>
		</table>
	</div>
	<?php 
	if((mysqli_num_rows($resul_aft)) ==0){ ?>
			<br><div align="center"><div class="message" align="center"><?php echo $noregitro3." PC ".$enlinea1;?>. Antes de hacer esta operaci&oacute;n, debe registrar al menos una.</div></div><?php
			if(($rus["tipo"]) =="root") {  ?>
				<div align="center"><input type="button" name="nuevo" value="<?php echo $registroclave;?>" class="btn" onclick="document.location='form-insertaraft.php';">	</div><?php
			}
	}elseif($num_resultados ==0){ ?>
			<br><div align="center"><div class="message" align="center"><?php echo $noregitro3.$pass1."s".$enlinea1;?>.</div></div>
			<div align="center"><input type="button" name="nuevo" value="<?php echo $registroclave;?>" class="btn" onclick="document.getElementById('nclaves').style.display='block';document.getElementById('claves').style.display='none';">	</div><?php
	}else{ ?>
	<div id="bus" <?php if (isset($_REQUEST['us']) OR (isset($_REQUEST['med'])) OR (isset($_REQUEST['user']))) { ?> style="display:none;" <?php } ?>>
	<table width="795" border="0" align="center">
	  <tr>
		<td width="611" align="center"><strong><?php echo $filtr.substr($Por1,0,-1);?>: </strong>
		   <input name="palabra" type="text" id="palabraa" autocomplete="off" class="imput" align="middle" value="<?php echo $bttextobuscar;?>..." onKeyUp="Claves(this.value,'sistema');" onClick="limpia();"/>
		</td>
		<td width="174">
			<div id="imprime">
				<table align="right" width="64%" border="0" cellspacing="0" cellpadding="0">
					<tr><?php 
						if(($_SESSION['valid_user']) !="invitado" AND ($total_registros) !=0){ ?>
					      <td class="pdf"><a class="tooltip" href="pdf/tuto1.php?query=<?php echo $ggg;?>&tb=reg_claves">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($cr_pdf);?></span></a></td>
						  <td class="exel"><a class="tooltip" href="expclavesistema.php?query=<?php echo $ggg;?>&tb=reg_claves">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($cr_exel);?></span></a></td>
						  <td class="printer"><a class="tooltip" href="imprimir/index.php?inicio=<?php echo $inicio;?>&registros=<?php echo $registros;?>&tb=reg_claves" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($sav_print);?></span></a></td>
							  <?php
						} ?>
						</tr>
				</table>				  
			</div>
		</td>
	  </tr>
	</table><?php
	}
	if ($num_resultados !=0){ ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="788"><div style="position: relative; margin-top: 7px; padding-bottom: 8px;">
						<form name="mst" method="post" action="" id="mst">
							<span><?php echo $cantidadmost;?>:</span>
							<span style="position: absolute; margin-left: 0%; margin-top: -11px;">
								<span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'ascendente');" style="cursor:pointer; position: absolute; margin-left: 30px; margin-top: 5px; z-index: 999;"><img src="gfx/asc.png"></span>
								<span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'descendente');" style="cursor:pointer; position: absolute; margin-top: 17px; margin-left:30px; z-index: 999;"><img src="gfx/desc.png"></span>
								<input name="mostrar" id="vers" type="text" maxlength="3" value="<?php if (!isset($_REQUEST['mostrar'])) { if ($rowsp['visitas']>$total_registros) { echo $total_registros; }else{ echo $registros; } }else{ if ($_REQUEST['mostrar']>$total_registros) { echo $total_registros; }else{ echo $_REQUEST['mostrar'];} if($_REQUEST['mostrar']<1) { echo "1"; } } ?>" onKeyPress="return acceptNum(event);" class="mostrar">
								<img src="images/search.png" style="cursor:pointer; top: 4px; position: relative;" onclick="document.mst.submit();">
							</span>	
								<input name="pagina" type="hidden" value="<?php echo $pagina;?>">
								<input name="mo" type="hidden" value="<?php echo $btver;?>" class="btn4">
								<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
								<input name="palabra" type="hidden"  value="<?php echo @$palabra;?>">
								<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">
						</form></div>
					</td>
				</tr>
		</table>
	</div>	
		<?php
	} ?>
	 
		<div id="claves">	
	    <form id="frm1" name="frm1" method="post" action=""><?php if ($num_resultados !=0){	?>
			<table width="100%" border='0' cellspacing="0" cellpadding="0" class="table">
				<tr class="vistauser1"><?php if(($rus["tipo"]) =="root") { ?>
				    <td width="20">
						<div id="cheque1" onClick="marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
						<div id="cheque2" onClick="desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
					</td><?php }?>
					<td width="216" align="center"><b><span class="Estilo4"><?php echo strtoupper($btCustodios);?></span></b></td>
					<td width="112" align="center"><b><span class="Estilo4">PC</span></b></td>
					<td width="144" align="center"><b><span class="Estilo4">LOGIN</span></b></td>
					<td width="138" align="center"><b><span class="Estilo4">SETUP</span></b></td>
					<td width="130" align="center"><b><span class="Estilo4"><?php echo strtoupper($btSistema);?></span></b></td>
					<td width="214" align="center"><b><span class="Estilo4"><?php echo strtoupper($btdatosentidad3);?></span></b></td>
				</tr><?php $p=0;
				while ($row=mysqli_fetch_array($result)){ $i++;
					$sela = mysqli_query($miConex, "select * from datos_generales where id_datos='".$row['idunidades']."'") or die(mysql_error());
					$rowsa = mysqli_fetch_array($sela);?>
					<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="marca1(<?php echo $p;?>,'#ffffff')" onContextMenu="contextual(event,'<?php echo $row["id"]?>');"> 
				        <td width="5"><?php if(($rus["tipo"]) =="root") { ?><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff'); " value="<?php echo $row['id']?>" style="cursor:pointer;" /><?php }?></td>	
						<td><?php echo $row["usuario"];?></td>
						<td><?php echo $row["equipo"];?></td>
						<td><?php echo $row["login"];?></td>
						<td><?php echo $row["setup"];?></td>
						<td><?php echo $row["sistema"];?></td>
						<td><?php echo $rowsa["entidad"];?></td>
					</tr><?php $p++;
				} 
				if(($rus["tipo"]) =="root") {  ?>
					<tr>
						<td colspan="7">&nbsp;
						    <input name="edit" type="submit" class="btn" id="edit" value="<?php echo $bteditar;?>" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');" />&nbsp;&nbsp;
							<input name="create" id="create-user" type="button" class="btn" onclick="checkLength('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>&nbsp;&nbsp;
							<input type="hidden" name="crash">
							<input type="button" name="nuevo" value="<?php echo $registroclave;?>" class="btn" onclick="document.getElementById('nclaves').style.display='block';document.getElementById('claves').style.display='none'; document.getElementById('bus').style.display='none';">
						</td>
					</tr><?php
				}?>
			</table><?php 
		} ?>
	    </form>
    <?php if ($num_resultados !=0){ include ("navegador.php");}
	if(isset($_REQUEST['user']) OR isset($_REQUEST['med'])){ ?>
		<script type="text/javascript">
			document.getElementById('claves').style.display='none';
		</script><?php
	} 	?>	
</div>
<?php } else { ?>
 <script type="text/javascript">document.location="expedientes.php";</script>
<?php } ?>
</fieldset><br><?php include ("version.php");?>
<div>
</body>
<div class="ContenedorAlert" id="cir"></div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>