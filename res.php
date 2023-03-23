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
include('script.php');
$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysqli_error());
$rsel = mysqli_fetch_array($qsel);
$cuantos = 5;
$es="";
	if(isset($_REQUEST['es'])){ $es=$_REQUEST['es']; }
	if($_SESSION ["valid_user"]!='invitado' and $rsel['visitas'] !=""){
		$cuantos = $rsel['visitas'];
	}
	$Uactbx=1;
if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$Uactbx=$_COOKIE['unidades'];	
}
include('barra.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/scrolltopcontrol.js">

/***********************************************
* Scroll To Top Control script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Please keep this notice intact
* Visit Project Page at http://www.dynamicdrive.com for full source code
***********************************************/

</script> 
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <script src="js/jquery.min.js"></script>
   	<script src="js/jquery-ui.min.js"></script>
	<link href="css/jqueryui.css" type="text/css" rel="stylesheet"/>
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
	</style><?php
	include('jquery.php'); 

$pendientes ="";
if(isset($_REQUEST['noti']) !=""){ $pendientes = $_REQUEST['noti']; }

$qusua = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION['valid_user']."'") or die(mysqli_error());
$rusua = mysqli_fetch_array($qusua);
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
$palabra="";
if(isset($_REQUEST['titulo'])){ 
	$palabra=$_REQUEST['titulo'];
	$sql = "select * from resoluciones where (titulo like '%".$palabra."%') OR (descripcion like '%".$palabra."%') OR (organo like '%".$palabra."%')";
	$contx1 = "SELECT * FROM resoluciones where (titulo like '%".$palabra."%') OR (descripcion like '%".$palabra."%') OR (organo like '%".$palabra."%')  kk ORDER BY titulo ASC limit ".$inicio.",".$registros;
}else{
	$sql = "select * from resoluciones";
	$contx1 = "SELECT * FROM resoluciones kk ORDER BY titulo ASC limit ".$inicio.",".$registros;
}

if ($pendientes !="") {
	$sql ="select * from resoluciones WHERE tiene='n' ";
}

$query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, "titulo", "ASC", $inicio, $registros);
$i=0;
$result= mysqli_query($miConex, $query_limit);
$ggg = base64_encode($query_limit);
$contx = base64_encode($contx1);

//NAVEGADOR inicio
	if(isset($_REQUEST['total_registros'])){
		$total_registros=$_REQUEST['total_registros'];
	} else {
		$all_rsDA = mysqli_query($miConex, $sql);
		$total_registros = mysqli_num_rows($all_rsDA);
	}
	$total_paginas = ceil($total_registros / $registros);
	$idf = @$_REQUEST['i'];
	?>
<form action="inserta_res.php" method="post" name="conted" id="conted">
	<input name="crash" value="1" type="hidden">
	<input name="marcado[]" id="marcado" type="hidden">
</form>
<form action="#modal5" method="post" name="contel" id="contel">
	<input name="editar" value="1" type="hidden">
	<input name="idunidades" type="hidden" value="<?php echo $Uactbx;?>">
	<input name="marcado" id="marcado" type="hidden">
</form>
<div id="openModals" class="modalDialog">
	<div>
		<div align="justify"><?php echo $seguro;?><hr><div align="center"><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="document.conted.marcado.value='<?php echo @$idf;?>';document.conted.submit();" value="<?php echo $btaceptar;?>"></div></div>			
	</div>
</div>
<script type="text/javascript">
	      	$(document).ready(function(){ 	
				$( "#titulo" ).autocomplete({
      				source: "buscarresol.php",
      				minLength: 2
    			});
    			
    			$("#titulo").focusout(function(){
    				$.ajax({
    					url:'resol.php',
    					type:'POST',
    					dataType:'json',
    					data:{ titulo:$('#titulo')}
    				}).done(function(respuesta){
    					$("#titulo").val(respuesta.titulo);
    				});
    			});    			    		
			});
 </script>
<script type="text/javascript">
function accion(id,q){
	if((q) =="ed"){
		document.contel.marcado.value=id;
		document.contel.submit();
	}else{
		document.location="?i="+id+"#openModals";
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
<div id="modal5" class="modalmask">
<div class="modalbox resize" style="width: 54%; height: 343px; border-radius: 5px 5px 5px 5px;">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -13px; width: 563px; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2  class="pos"><?php echo strtoupper($bteditar.' '.$btResoluciones);?></h2></div>
		<p><iframe src="inserta_res.php?marcado[]=<?php echo $_POST['marcado'];?>&idunidades=<?php echo $_POST['idunidades'];?>&editar" name="b" scrolling="Auto" width="102%" height="300" frameborder="0" class="notice" border="0"></iframe></p>
	</div>
</div>
<div id="modal4" class="modalmask">
<div class="modalbox resize" style="width: 543px; height: 343px; border-radius: 5px 5px 5px 5px;">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -13px; width: 563px; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2  class="pos">Nueva Resoluci&oacute;n</h2></div>
		<p><iframe src="inserta_res.php?n" name="b" scrolling="Auto" width="102%" height="300" frameborder="0" class="notice" border="0"></iframe></p>
	</div>
</div>
<div id="buscad"> 
<fieldset class='fieldset'>
<legend class="vistauserx"><?php echo strtoupper($btResoluciones);?></legend>
<?php
if((@$msg) !=""){ echo "<div class='vistauser1'><font size='2' color ='red'>".@$msg."</font></div>"; } ?>
	<script type="text/javascript">
		function limpia(){
			document.header.palabra.value ="";
			prueba();
		}	
	</script><?php

	if(($total_registros) !=0){ ?>
		<div id="openModal" class="modalDialog">
			<div>
				<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
				<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
			</div>
		</div>
		<table width="100%" border="0">
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
				<td width="55%">
					<form action="" method="get" name="header" id="header" onSubmit=" return escribe();">
					   <div><strong class="componentheading"><?php echo $filtr.substr($Por1,0,-1);?>: </strong>
						<input name="titulo" style="width: 57%;" type="text" id="titulo" size="20" autocomplete="off" class="imput" align="middle" placeholder="<?php echo $bttextobuscar;?>..." onClick="this.value='';"/>&nbsp;<input type="button" class="btn" style="margin-top: -6px;" value="<?php echo $strOK;?>" onclick="document.header.submit();">
						</div>
					</form>
				</td>
				<td width="10%">
					<div id="imprime" style="margin: 0px 65px;">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr><td class="pdf"><a class="tooltip" href="pdf/tuto1.php?query=<?php echo $ggg;?>&tb=resoluciones">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($cr_pdf);?></span></a></td>
							  <td class="printer"><a class="tooltip" href="imprimir/index.php?tb=resoluciones&consulta=<?php echo $ggg;?>" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($sav_print);?></span></a></td>
							</tr>
						 </table>	
					</div>
				</td>
			</tr>
		</table><?php 
	} ?>
	<div id="paginac">
		<table width="100%" border="0" align="center" class='table' cellpadding="0" cellspacing="0"><?php 
			if(($total_registros) !=0){ ?>			
				<form name="frm1" action="inserta_res.php" method="post">
					    <tr class="vistauser1"> 
							<td colspan="2" width="50"><?php if($_SESSION ["valid_user"]!='invitado' and @$rus['tipo'] =="root"){ ?>
								<div id="cheque1" onClick="marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
								<div id="cheque2" onClick="desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div><?php } else{ echo "&nbsp;"; }?>
					        </td>
							<td><strong><span class="Estilo4"><?php echo $title3;?></span></strong></td>
							<td><strong><span class="Estilo4"><?php echo $DESCRIPCION;?></span></strong></td>
							<td><strong><span class="Estilo4"><?php echo $btorganoemi2;?></span></strong></td>
							<td><strong><span class="Estilo4"><?php echo strtoupper($Fecha);?></span></strong></td>
						</tr><?php
						$p=0;
						$i=0;
						while($rows= mysqli_fetch_array($result)){ $i++;?>
						<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="marca1(<?php echo $p;?>,'#ffffff')" onContextMenu="contextual(event,'<?php echo $rows["id"]?>');"> 
				            <td width="8"><?php if($_SESSION ["valid_user"]!='invitado' and $rusua['tipo'] =="root"){ ?><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff'); " value="<?php echo $rows['id']?>" style="cursor:pointer;" /><?php }else{ echo "&nbsp;"; } ?></td>	
							</td>
							<td width="20"><?php if(($rows['link']) !=""){ ?><a href="res/<?php echo $rows['link'];?>" target="_blank"><img src="images/file_f2.png" width="20" height="20" border="0" title="Descargar Resoluci&oacute;n..."/></a><?php }else { ?><img src="images/file.png" width="20" height="20" border="0" title="Descargar Resoluci&oacute;n..."/><?php }  ?></td>
							<td width="275"><?php echo $rows['titulo'];?></td>
							<td width="402"><?php echo $rows['descripcion'];?><input name="link[]" type="hidden" value="<?php echo $rows['link'];?>"></td>
							<td width="128"><?php echo $rows['organo'];?></td>
							<td width="87"><?php echo $rows['fecha'];?></td>
						</tr>  <?php $p++;
						} 
						if($_SESSION ["valid_user"]!='invitado' and @$rus['tipo'] =="root"){ ?>
							<tr> 
								<td colspan="6">
									<input name="edit" type="submit" value="<?php echo $bteditar;?>" class="btn" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');">&nbsp;&nbsp;&nbsp;
									<input name="create" id="create-user" type="button" class="btn" onclick="checkLength('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>&nbsp;&nbsp;&nbsp;									
									<input name="new" type="button" onclick="document.location='#modal4';" class="btn" id="new" value="<?php echo $btinsertar;?>" /><input type="hidden" name="crash"></td>
							</tr><?php
						} ?><tr> 
								<td colspan="6">&nbsp;</td>
							</tr>		
				</form><?php
				include('navegador.php');
			}else{ ?>
				<tr> 
					<td colspan="6"><div  align="center">
						<form name="news" action="inserta_res.php" method="post">
							<br><div align="center"><div class="message" align="center"><?php if(($palabra) !=""){ echo $noart." ".$quecoin." -->".$palabra; }else{  echo $noart; }?>.</div></div><br><?php 
							if(($rusua['tipo']) =="root" AND !isset($_POST['new'])){ ?>
								<div align="center"><input name="new" type="button" onclick="document.location='#modal4';" class="btn" id="new" value="<?php echo $btinsertar;?>" /></div><?php 
							} ?>
						</form></div>
					</td>
				</tr>  <?php	
			}  ?>
		</table>
	</div>
<a href="#top"></a>		
</fieldset><br>
<?php include ("version.php");?>
<div>
<div class="ContenedorAlert" id="cir"></div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
