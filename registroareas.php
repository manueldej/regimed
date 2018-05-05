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
if(isset($_POST["eliminar"])){
	$marcado = $_POST['marcado'];
	foreach($marcado as $key){		
		$satf = "select * from areas where idarea='".$key."'";
		$qsatf = mysqli_query($miConex, $satf) or die(mysql_error());
		$rsatf = mysqli_fetch_array($qsatf);
		
		$sqld = "DELETE FROM areas WHERE idarea='".$key."'";			
		$result = mysqli_query($miConex, $sqld) or die(mysql_error());	
	}
}
$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$cuantos = 5;
if(($rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}
$qus = mysqli_query($miConex, "select login,tipo from usuarios where login ='".$_SESSION ["valid_user"]."' AND idunidades='1'") or die(mysql_error());
$rusx = mysqli_fetch_array($qus);
?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><?php
$i=0;
$ordena=@$_REQUEST['ordena'];
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
$query ="";
   
	if(isset($_REQUEST["palabra"])) {
	   	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$sql = "select * from areas  WHERE nombre !='Reparaciones'  AND idunidades='".$_COOKIE['unidades']."'  limit ".$inicio.",".$registros;
			$result= mysqli_query($miConex, $sql) or die(mysql_error());	
		}else{
			$sql = "select * from areas WHERE nombre !='Reparaciones'  limit ".$inicio.",".$registros;
			$result= mysqli_query($miConex, $sql) or die(mysql_error());		
		}
	}else{
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$sql = "select * from areas WHERE nombre !='Reparaciones' AND idunidades='".$_COOKIE['unidades']."' limit ".$inicio.",".$registros;
			$result= mysqli_query($miConex, $sql) or die(mysql_error());
		}else{
			$sql = "select * from areas WHERE nombre !='Reparaciones'  limit ".$inicio.",".$registros;
			$result= mysqli_query($miConex, $sql) or die(mysql_error());
		}	   
	} 
	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$resultados = mysqli_query($miConex, "SELECT idarea FROM areas WHERE (nombre !='Reparaciones') AND (idunidades='".$_COOKIE['unidades']."')");
	}else{
		$resultados = mysqli_query($miConex, "SELECT idarea FROM areas WHERE nombre !='Reparaciones'");
	}
$total_result = mysqli_num_rows($result);
$total_registros = mysqli_num_rows($resultados);
$total_paginas = ceil($total_registros / $registros);  

 include('barra.php');?>
 <form action="" method="post" name="contel" id="contel">
	<input name="eliminar" value="1" type="hidden">
	<input name="marcado[]" id="marcado" type="hidden">
</form>
<form action="#modal5" method="post" name="conted" id="conted">
	<input name="editar" value="1" type="hidden">
	<input name="marcado" id="marcado" type="hidden">
</form>
<script type="text/javascript">
function accion(id,q){
	if((q) =="el"){
		if(confirm('Desea eliminar esta Area?')){
			document.contel.marcado.value=id;
			document.contel.submit();
		}
	}else{
		document.conted.marcado.value=id;
		document.conted.submit();
	}
}
function contextual(event,id){
		var iX = event.clientX;
		var iY = event.clientY;
		event.preventDefault();
		$('#divMenu').css({
			display:	'block',
			left:		iX,
			top:		iY
		});

		$('#divMenu').html('<ul><li onclick="accion(\''+id+'\',\'ed\');"><a style="cursor:pointer; text-decoration:none;" ><img title="Editar..." align="asbmiddle" src="images/editar.png" width="16" height="16">&nbsp;&nbsp;Editar</a></li><li onclick="accion(\''+id+'\',\'el\');"><a style="cursor:pointer; text-decoration:none;" ><img align="asbmiddle" src="images/delete.png" width="16" height="16" title="Eliminar...">&nbsp;&nbsp;Eliminar</a></li></ul>');

	$(document).on('click',function(){
		//$('#divMenu').css('display','none');
	});
}
</script>
<div id="divMenu"></div>
<div id="modal4" class="modalmask">
<div class="modalbox resize" style="width: 543px; height: 243px; border-radius: 5px 5px 5px 5px;">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -16px; width: 105%; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2  class="pos"><?php echo $stregistro.$btAreas;?></h2></div>
		<p><iframe src="form-insertarareas.php" name="b" scrolling="Auto" width="102%" height="200" frameborder="0" class="notice" border="0"></iframe></p>
	</div>
</div>
<div id="modal5" class="modalmask">
<div class="modalbox resize" style="width: 543px; height: 243px; border-radius: 5px 5px 5px 5px;">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -16px; width: 105%; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2  class="pos"><?php echo $stregistro.$btAreas;?></h2></div>
		<p><iframe src="v51.php?marcado[]=<?php echo $_POST['marcado'];?>&editar" name="b" scrolling="Auto" width="102%" height="200" frameborder="0" class="notice" border="0"></iframe></p>
	</div>
</div>
<div id="buscad"> 
<fieldset class="fieldset"><legend class="vistauserx"><?php echo $stregistro.$btAreas;?><?php if(($unidadactiva) !=""){ echo "&nbsp;&nbsp;&nbsp;".$btdatosentidad3.": <font color='red'>".$unidadactiva."</font>"; }?></legend><?php 
      
		   if(($total_filas) >1){ ?>
				<td>
					<form action="" method="post" name="formU"><?php echo $btdatosentidad2;?>:
						<select name="unidades" id="unidades" class="form-control" style="margin-top: -20px; margin-left:73px; width:19%;" onchange="cambiaunidad(this.value,'registroareas.php');">
							<option value="-1"><?php echo $btmostrartodo1?></option><?php 
							while ($row1=mysqli_fetch_array($reado)){ ?>					
								<option value="<?php echo @$row1['id_datos'];?>" <?php if((@$row1['id_datos']) ==@$_COOKIE['unidades']){ echo "selected";}?>><?php echo @$row1['entidad'];?></option><?php
							} ?>
						</select>
						<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
						<input name="palabra" type="hidden"  value="<?php echo $palabra;?>">
						<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">				
					</form>
				</td><?php 
			} 
			if(isset($_REQUEST['m'])){
			$dd = "";
			$txtms = "";
				if(($_REQUEST['m']) =="1"){ 
					$dd= $strerror;
					$txtms = $noarea;
				?>
<div class="ContenedorAlert" id="cir"><div class="alert negro"><button class="close" type="button" onclick="cierrz();">x</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $dd;?></b></font></div><div align="center"><b><?php echo $txtms;?>.</b></div></div></div>
	<?php 	
	} ?>

<script language="javascript">
	function cierrz(){
		document.getElementById('cir').innerHTML="";
	}
	$('.alert').fadeIn('slow');
	setTimeout(function(){$('.alert').fadeOut('slow') }, 4000);
</script>
<?php
}
	if(($total_registros) >1){ ?>
	<table width="100%" border="0" >
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
					<input type="hidden" name="orderby" value="<?php echo $orderby;?>">
					<input type="hidden" name="asc" value="<?php echo $asc;?>">
					<input type="hidden" name="m" value="m">
				</form></div>
			</td><?php 
	} ?>
	    </tr>
	</table>	
	<form name="frm1" method="post" action="v5.php">
		<table width="751" height="71" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
			<tr>
			  <td colspan="4"><div align="center" class="vistauser1"><h1><?php echo $btAREASRES;?></h1></div></td>
			</tr>
			<tr class="vistauser1">
				<td width="40">&nbsp;</td>
				<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b><?php echo $btAreas1?></b></span></td>
				<td><span><b><?php echo strtoupper($btdatosentidad3);?></b></span></td>
		  	</tr>			
			<?php  
			$nob=0; $p=0;
			$edatz = mysqli_query($miConex, "select * from datos_generales") or die(mysql_error());
			$redatz = mysqli_fetch_array($edatz);
			while($row=mysqli_fetch_array($result))    {	
				if(($row["nombre"]) !="Reparaciones"){ $i++; 
					$edat = mysqli_query($miConex, "select * from datos_generales where id_datos='".$row["idunidades"]."'") or die(mysql_error());
					$redat = mysqli_fetch_array($edat);?>
					<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="marca1(<?php echo $p;?>,'#ffffff')" onContextMenu="<?php if (($rus['tipo']) =="root") {  ?>contextual(event,'<?php echo $row["idarea"]?>'); <?php } ?>"> 
			          <td width="5"><?php if(($rus['tipo']) =="root"){ if(($row['idarea']) >2){ ?><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff'); " value="<?php echo $row['idarea']?>" style="cursor:pointer;" /><?php } }else{ echo "&nbsp;"; } ?></td>
					  <td width="250" class="Estilo2">&nbsp;&nbsp;<?php echo $row["nombre"];?></td>
					  <td colspan="2" width="534" class="Estilo2"><?php echo $redat['entidad'];?><input type="hidden" name="id[<?php echo $p;?>]" value="<?php echo $row["idarea"];?>"></td>
					</tr><?php  		$p++;
				}
			} if(($rusx['tipo']) =="root"){ ?>
				<tr align="center">
				  <td height="26" colspan="4" valign="top"><?php if(($total_registros) !=0){ 
						if(($total_result ) >1){ ?>
							<input name="eliminar" type="submit" class="btn"  value="<?php echo $bteliminar;?>" onClick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');"/>&nbsp; &nbsp;
						<input name="editar" onClick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');" type="submit" class="btn" value="<?php echo $bteditar;?>" />&nbsp; &nbsp;<?php 
						}
					} ?>
					<input name="insertar" type="button" onclick="document.location='#modal4';" class="btn"  value="<?php echo $btinsertar;?>" />				  </td>
				</tr><?php
			} ?>
			<tr><td colspan="4">&nbsp;</td></tr>
		</table>
	</form>
		<?php include('navegador.php');?>
</fieldset><br>
<?php include ("version.php");?>
<div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
