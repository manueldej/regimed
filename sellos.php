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
include('script.php');

function genera_talon() {
 include('connections/miConex.php');
	$fecha = date( 'Y-m-d' );
	$sql = "SELECT COUNT(id) as total FROM talones";
	$result = mysqli_query($miConex, $sql) or die(mysql_error());
	$rwe = mysqli_fetch_array($result);
	$total = $rwe['total'];
	if ($total !=0) {
	   $consecutivo = "Tal&oacute;n ".($total+1);
	   $sqlin ="insert into talones (id, nombre, fecha, estado) values (NULL, '".$consecutivo."','".$fecha."','Inactivo')";
	}else{
	   $consecutivo = "Tal&oacute;n 1";
	   $sqlin ="insert into talones (id, nombre, fecha, estado) values (NULL, '".$consecutivo."','".$fecha."','Activo')";
	}
 	$resultin = mysqli_query($miConex, $sqlin) or die(mysql_error());
}

if(($rus["tipo"]) =="root") { 
$cuantos = 5;
$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);

if(($rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}
$ordena=@$_REQUEST['ordena'];
    $i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if ($i=="es") {
	  include('esp.php');
	}else{
	  include('eng.php');
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
if(isset($_POST['insertar'])){
	$vinicial= strtoupper ($_POST["vinicial"]);
	$vfinal= strtoupper ($_POST["vfinal"]);
	$digitos= $_REQUEST["digitos"];
	$prefijo= $_REQUEST["prefijo"];
	$fecha = date( 'Y-m-d' );

	if (isset($_REQUEST["separador"]) and ($_REQUEST["separador"]!='-1') and ($_REQUEST["prefijo"]!='')) {
	 $separador= $_REQUEST["separador"];
	}else{
	 $separador= "";
	}
	genera_talon();
	
	$sql = "SELECT * FROM talones order by id DESC";
	$result = mysqli_query($miConex, $sql) or die(mysql_error());
	$rwe = mysqli_fetch_array($result);
	$idTalo = $rwe['id'];
	
	for ($i=$vinicial; $i<=$vfinal; $i++) {
		$cadena =$prefijo.$separador.$i;
		$sql = "insert into sellos (id, numero, estado,idtalon) values (NULL, '".$cadena."','Disponible','".$idTalo."')";
		$result = mysqli_query($miConex, $sql) or die(mysql_error());
	}
	
}
$rowsella =0;	
$qus = mysqli_query($miConex, "select login,tipo from usuarios where login ='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$rus = mysqli_fetch_array($qus);
$ta="";

$sqltalo ="SELECT * FROM talones where estado='Activo'";
$resultalo = mysqli_query($miConex, $sqltalo) or die (mysql_error());
$talon_act = mysqli_fetch_array($resultalo);
$total_registros =0;
$prefijo ="";

if(isset($_REQUEST['ta'])) { 
	$ta=$_REQUEST['ta'];
	$sql4 = "select * from sellos where idtalon='".$ta."' limit $inicio, $registros";
	//$sellaje = "select * from sellos where estado='Disponible' and idtalon='".$ta."' limit $inicio, $registros";
	$esta = $_REQUEST['est'];
	$sqlsello ="SELECT * FROM sellos WHERE idtalon='".$ta."'";
	$resultados = mysqli_query($miConex, $sqlsello) or die (mysql_error());
}else{
   $sql4 = "select * from sellos WHERE idtalon='".$talon_act['id']."' limit $inicio, $registros";
   //$sellaje = "select * from sellos where estado='Disponible' limit $inicio, $registros";
   $esta ="Activo";
   $sqlsello ="SELECT * FROM sellos WHERE idtalon='".$talon_act['id']."'";
   $resultados = mysqli_query($miConex, $sqlsello) or die (mysql_error());
}

//Verificar si existen sellos disponibles, sino creo talones
//$qsellaje = mysqli_query($miConex, $sellaje) or die(mysql_error());
//$rowsella = mysqli_num_rows($qsellaje);


$total_registros = mysqli_num_rows($resultados);
$total_paginas = ceil($total_registros / $registros);

$sqltalones ="SELECT * FROM talones";
$resultalon = mysqli_query($miConex, $sqltalones) or die (mysql_error());

$sqlsess ="SELECT * FROM sellos WHERE estado='Disponible'";
$ressess = mysqli_query($miConex, $sqlsess) or die (mysql_error());
$rowsess = mysqli_num_rows($ressess);

$result= mysqli_query($miConex, $sql4);
$totalsellos = mysqli_num_rows($result);
$ggg= base64_decode($sql4);

?>
<form action="" method="post" name="contel" id="contel">
	<input name="crash" value="1" type="hidden">
	<input name="marcado[]" id="marcado" type="hidden">
</form>
<form action="sellos.php" method="post" name="talona">
	<input name="ta" value="" type="hidden">
	<input name="est" value="" type="hidden">
</form>
<form action="" method="post" name="conted" id="conted">
	<input name="edit" value="1" type="hidden">
	<input name="marcado[]" id="marcado" type="hidden">
</form>
<form action="" method="post" name="nuevo" id="nuevo">
	<input name="insert" value="1" type="hidden">
</form>
<?php include('barra.php');?>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script><?php
	include('jquery.php'); ?>
<SCRIPT language='javascript'>
	function cierrz(){
		document.getElementById('cir').innerHTML="";
	}
	
</script>
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
<fieldset class="fieldset"><legend class="vistauserx"><?php echo $btgensello;?></legend>
	<div id="openModal" class="modalDialog">
		<div>
			<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
			<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
		</div>
	</div>
<?php
	if(isset($_REQUEST['er'])){
		$dd = $strerror;
		$txtms = $noareac;?>
<div class="ContenedorAlert" id="cir"><div class="alert negro"><button class="close" type="button" onclick="cierrz();">x</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $dd;?></b></font></div><div align="center"><b><?php echo $txtms;?>.</b></div></div></div>
<script language="javascript">
	$('.alert').fadeIn('slow');
	setTimeout(function(){$('.alert').fadeOut('slow')}, 3000);
</script>
<?php
}	?>
<script language="javascript">
	function cambiasello(estado,id,idobv) {
		if (estado=="Desechado") {
		  if (document.getElementById(id).style.display=='none') { 
			document.getElementById(id).style.display='block';
			document.getElementById(idobv).focus();
		  }else{
			document.getElementById(id).style.display='none';  
		  }		
	    }
	}
	function manda(valor,estado) {
	  document.talona.ta.value=valor;
	  document.talona.est.value=estado;
	  document.talona.submit();
	}
</script>
<?php 
    if(isset($_REQUEST['modificado'])){
		$idx=$_REQUEST['id'];
		$pestado=$_REQUEST['estado'];
		$observ=$_REQUEST['obsv'];
		$x=0;
		foreach($idx as $key){
			$upx ="update sellos set estado='".$pestado[$x]."',observ='".$observ[$x]."' WHERE id='".$key."'";
			$qupx =mysqli_query($miConex, $upx) or die(mysql_error());
			$x++;
		}
		?><script type="text/javascript">document.location='sellos.php';</script><?php
	}
?>
    <div id="general">
	<?php if($rowsess>0) { ?>
	<table width="90%" border="0" align="center">
		<tr>
			<td>
				<div style="position: relative; margin-top: 7px; padding-bottom: 8px;">
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
							<br><br><label>&nbsp;&nbsp;Talones</label>
							<select name="talon" class="form-control" style="width: 19%; position: absolute; margin-left: 64px; margin-top: -22px;">
							  <?php while ($rowt = mysqli_fetch_array($resultalon)) { ?>
							  <option value="<?php echo $rowt['id'];?>" onclick="manda(this.value,'<?php echo $rowt['estado'];?>');" <?php if(isset($_REQUEST['ta']) and $_REQUEST['ta']==$rowt['id']) { ?> selected <?php }elseif (!isset($_REQUEST['ta']) AND $rowt['estado']=='Activo') { ?> selected <?php } ?>><?php echo $rowt['nombre']; ?></option>
							  <?php }  ?>
							</select><label style="position:absolute; margin-left:183px; margin-top:-1px; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Estado:&nbsp;<b><?php echo $esta; ?></b></label>
					</form>
				</div>
				<form name="frm1" method="post" action="">        
					<table width="90%" height="71" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
						<tr>
						   <td width="27" align="center">&nbsp;</td>
						   <td width="145" align="center"><b>N&Uacute;MERO</b></td>
						   <td width="803" align="center">&nbsp;&nbsp;<b>ESTADO</b></td>
						   <td width="803" align="center">&nbsp;&nbsp;<b>OBSERVACIONES</b></td>						   
						</tr> <?php 
						$p=0; 
						$i=0;
						while($row=mysqli_fetch_array($result)) { $i++;  ?>
							<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="marca1(<?php echo $p;?>,'#ffffff');"> 
				                <td width="5"><?php if(($rus['tipo'] =="root") AND ($row['estado']!="Desechado") AND ($row['estado']!="En Uso")){ ?><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none;" id="marcado<?php echo $p; ?>" onClick="marca1(<?php echo $p;?>,'#ffffff'); " value="<?php echo $row['id']?>" style="cursor:pointer;" /><?php }else{ echo "&nbsp;"; } ?></td>	
								<td>&nbsp;&nbsp;<?php if ($row['estado']=="En Uso") { ?><font color="red"><?php }elseif ($row['estado']=="Desechado") {?><font color="grey"><?php }else{ ?><font color="black"> <?php } echo $row['numero'];?></td>
								<td><?php echo $row['estado'];?></td>
								<td><?php echo $row['observ']; ?></td>
							</tr><?php $p++; 
						} if($rus['tipo'] =="root"){ ?>
							<tr align="center">
							    <td colspan="4" valign="top"><hr>
								   <input name="edit" type="submit" class="btn" id="edit" value="<?php echo $bteditar;?>" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');" />&nbsp;&nbsp;
								</td> 
							</tr><?php 
						} ?>
					</table>
				</form>			
			</td>
		</tr>
		<tr>
			<td><?php include('navegador.php');?></td>
				</tr>
	</table><?php  }else{ ?>
	                    <div align="center"><div class="message">Es preciso generar un nuevo tal&oacute;n de Sellos.</div></div> 
						<form name="frm1" method="post" action="">        
							<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
									<tr>
									  <td width="90" align="center">Sin Prefijo<input name="nros" id="nros" type="radio" value="<?php echo $nros;?>" style="cursor:pointer;" checked onclick="document.getElementById('mixto').checked=false; document.getElementById('digitos').style.display='none';"></td> 
									  <td width="70" align="center">Con prefijo<input name="mixto" id="mixto" type="radio" value="<?php echo $mixto;?>" style="cursor:pointer;" onclick="document.getElementById('nros').checked=false; document.getElementById('digitos').style.display='block';"></td>
									  <td width="400">
									    <span id="digitos" style="width:29%; position: absolute; margin-left: -1%; margin-top: 1px; display:none;">
										<input name="prefijo" id="prefijo" type="text" class="form-control" style="width: 30px; height:18px;" maxlength="5" value="" placeholder="Prefijo">
										<select name="separador" id="separador" class="form-control" style="margin-top: -23px; width: 66px; margin-left: 54px;">
										  <option value="-1">---</option>
										  <option value="-">-</option>
										  <option value=".">.</option>
										</select>
										</span>
									  </td>
									</tr>
									<tr>	
									    <td><b>Valor Inicial</b></td>
									    <td><b>Valor Final</b></td>
										<td>&nbsp;</td>
									</tr>
									<tr>
									  <td width="147" class="Estilo2"><input name="vinicial" id="vinicial" type="text" maxlength="4" class="form-control" value="1" onblur="if(this.value =='') {this.value='1';}" onkeypress="return acceptNum(event); return handleEnter(this, event);" onclick="this.value='';" /></td>
									  <td width="145" height="21"><input name="vfinal" id="vfinal" type="text" maxlength="4" class="form-control" value="" onkeyup="document.frm1.digitos.value=(this.value.length); return acceptNum(event);" onclick="this.value='';" /></td>
									  <td><input name="digitos" id="vea" type="text" style="margin-top: -1px; width: 3%; background: rgb(77, 94, 108) none repeat scroll 0% 0%; color: rgb(246, 252, 252); padding: 0px 0px 0px 10px;" maxlength="3" value="4" class="mostrar" readonly>D&iacute;gitos</td>
									</tr>
									<tr align="center">
										<td colspan="3" valign="top"><hr>
											<input name="insertar" type="submit" class="btn"  value="<?php echo $btinsertar;?>" />
										</td> 
									</tr>
							</table>
						</form>		
					<?php	} ?>
</div>					
<?php 
    if(isset($_REQUEST['edit']) AND !isset($_REQUEST['modificado'])){
	if(isset($_REQUEST['marcado'])) {$marcado=$_REQUEST['marcado'];} ?>
	<form name="frm1" method="post" action="">        
		<table width="70%" height="71" border="0" cellpadding="0" cellspacing="0" class="table">
			<tr>
				<td width="4" align="center">&nbsp;</td>
				<td width="144" align="center"><b>N&Uacute;MERO</b></td>
				<td width="200" align="center">&nbsp;&nbsp;<b>ESTADO</b></td>
				<td width="354" align="center">&nbsp;&nbsp;<b>MOTIVOS</b></td>				
			</tr> <?php 
				$p=0; 
				$i=0;
				foreach ($marcado as $key) { $i++; 
				  $sql = "select * from sellos where id='".$key."'";
				  $result= mysqli_query($miConex, $sql);
				  $row = mysqli_fetch_array($result);
				?>
			<tr> 
				<td width="4"></td>	
				<td><input name="id[]" type="hidden" value="<?php echo $key; ?>"><input name="numero[]" type="text" maxlength="7" class="form-control" value="<?php echo $row['numero'];?>" readonly /></td>
				<td><select name="estado[]" class="form-control" style="height:28px;" <?php if ($row['estado']=="En Uso" OR ($row['estado']=="Desechado")) { ?> disabled <?php } ?>>
				      <option value="Disponible" onClick="cambiasello(this.value,'nuevosello<?php echo $p;?>','obsv<?php echo $p;?>');" <?php if ($row['estado']=="Disponible") { echo "selected"; }?>>Disponible</option>
					  <option value="Desechado" onClick="cambiasello(this.value,'nuevosello<?php echo $p;?>','obsv<?php echo $p;?>');" <?php if ($row['estado']=="Desechado") { echo "selected"; }?>>Desechado</option> 					  
				    </select>				</td>
				<td><div id="nuevosello<?php echo $p;?>" style="display:none;"><input name="obsv[]" id="obsv<?php echo $p;?>" type="text" placeholder="Ecriba el motivo del retiro..." class="form-control" value="" onClick="this.value='';" /></div></td>
			</tr><?php $p++; 		
				} if(($rus['tipo']) =="root"){	?>
			<tr align="center">
				<td colspan="4" valign="top"><hr>
					<input type="submit" name="modificado" value="<?php echo $btaceptar;?>" class="btn">&nbsp;&nbsp;
					<input type="button" name="retur" value="<?php echo $btcancelar;?>" class="btn" onClick="document.location='sellos.php';">				</td>
			</tr><?php 
				} ?>
		</table>
	</form>	<?php } ?>	
	 <?php if(isset($_REQUEST['edit']) OR isset($_REQUEST['med'])){ ?>
		<script type="text/javascript">
			document.getElementById('general').style.display='none';
		</script><?php
	} 	?>	
</fieldset><br>
<?php include ("version.php");?>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<?php } else { ?>
 <script type="text/javascript">document.location="expedientes.php";</script>
<?php } ?>