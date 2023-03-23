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
include('barra.php');
?>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript">
	var nav4 = window.Event ? true : false;
	function acceptNum(evt){	
		var key = nav4 ? evt.which : evt.keyCode;	
		return (key <= 13 || (key >= 48 && key <= 57));
	}
</script>
<script type="text/javascript" src="ajax.js"></script>
<div id="buscad"><?php
include('jquery.php');
$rooa = $_SERVER['DOCUMENT_ROOT'];
$posiciona = strripos($rooa, "/");
$rutaa= substr($rooa, 0, $posiciona)."/tmp/";
$leyenda = array($Codificadores,$Preferencias,$bthmtas,$Opciones,$Memorias); 
$validus = "";

$contx1 = "SELECT * FROM areas";
$result_area= mysqli_query($miConex, $contx1) or die(mysql_error());	
$cantidaddecampos= mysqli_num_fields($result_area);
	  
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$validus = " AND idunidades='".$_COOKIE['unidades']."'";
	$uni = $_COOKIE['unidades'];
}else{
	$validus = "";
	$uni = 1;
}

$resprov = mysqli_query($miConex, "SELECT * FROM provincia ORDER BY nombre") or die(mysql_error());
$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));

$reup = mysqli_query($miConex, "SELECT * FROM datos_generales") or die(mysql_error());
$rreup = mysqli_fetch_array($reup);
$cod = $rreup['id_datos'];

//Extraer nombres del admin y el rsi
$dsi = mysqli_query($miConex, "SELECT * FROM usuarios") or die(mysqli_error());
while ($rdsi = mysqli_fetch_array($dsi)){ 
 if (($rdsi['tipo']=="root") OR ($rdsi['tipo']=="rsi")){
	$tipouser[] = $rdsi['nombre']; 
	$sexuser[] = $rdsi['sexo']; 
 }
}


if (@$rus['tipo']=="root") {
   if ((isset($_REQUEST['t'])) AND ($_REQUEST['t']='t')) {
      $consulta ="SELECT * FROM preferencias WHERE usuario='".$_SESSION['valid_user']."'";
   }else if(!isset($_REQUEST['t'])){
     $consulta ="SELECT * FROM preferencias";
   }
	$resultado = mysqli_query($miConex, $consulta) or die(mysql_error());
	$cantconf=mysqli_num_rows($resultado);
}else{
	$consulta ="SELECT * FROM preferencias WHERE usuario='".$_SESSION['valid_user']."'";
	$resultado = mysqli_query($miConex, $consulta) or die(mysql_error());
	$cantconf=mysqli_num_rows($resultado);
}

if ($cantconf ==0) {
  $sqlin = "INSERT INTO preferencias (usuario,salva,pass,visitas,columnas,acceso, busca,idunidades) VALUES ('".$_SESSION['valid_user']."','s','s','7','14','s','s','".$uni."')";
  $resulin = mysqli_query ($miConex, $sqlin) or die (mysql_error());
  
  $consulta ="SELECT * FROM preferencias WHERE usuario='".$_SESSION['valid_user']."'";
  $resultado = mysqli_query($miConex, $consulta) or die(mysql_error());
  $cantconf=mysqli_num_rows($resultado);
}


////


$cons="SELECT * FROM datos_generales";
$resulta = mysqli_query ($miConex, $cons);
$existenciadt = mysqli_num_rows($resulta);
	
	if (isset($_POST['modifica'])){
		$entidad = $_POST['entidad'];
		$id_datos = $_POST['id_datos'];
		$cod = $_POST['codigo'];
		$sector = $_POST['sector'];
		$smtp = $_POST['smtp'];
		$web = $_POST['web'];
		$prov = $_POST['provincia'];
		$reup = $_POST['codigo']; 
		$b=0;

		$upload_extensions = array(".png", ".jpeg", ".jpg", ".gif", ".bmp", ".PNG", ".JPEG", ".JPG", ".GIF", ".BMP");
		foreach($id_datos as $iddatos){
	
				$guarda = "update datos_generales set entidad='".htmlentities($entidad[$b])."', sector='".$sector[$b]."', smtp='".$smtp[$b]."', codigo='".$reup[$b]."', web='".$web[$b]."', provincia='".$prov[$b]."' where id_datos='".$iddatos."'";
				$result = mysqli_query ($miConex, $guarda) or die (mysql_error()); 				
			$b++;
		}			?>
		<script type="text/javascript">document.location="configura.php?p=d";</script><?php   
	}

	if(isset($_POST['guardar'])){ 
		$marcado= @$_POST['marcado'];
		$salvac= @$_POST['salva'];
		$passc= @$_POST['pass'];
		$visitasc= @$_POST['visitas'];
		$buscac= @$_POST['busca'];
		$columnas= @$_POST['columnas'];
		$acceso= @$_POST['acceso'];
		
		$f=0;
		foreach($marcado as $Key){
			$inner = mysqli_query($miConex, "SELECT * FROM preferencias INNER JOIN (usuarios) ON (preferencias.usuario = usuarios.login) WHERE preferencias.id='".$Key."'") or die(mysql_error());
            $inner_row = mysqli_fetch_array($inner);
			
			if($inner_row['tipo']=='root'){
			  $upd="update preferencias set salva='".$salvac[$f]."', pass='".$passc[$f]."', visitas='".$visitasc[$f]."', columnas='".$columnas[$f]."', acceso='s',busca='".$buscac[$f]."' where id='".$Key."'";	
			}else {
			  $upd="update preferencias set salva='".$salvac[$f]."', pass='".$passc[$f]."', visitas='".$visitasc[$f]."', columnas='".$columnas[$f]."', acceso='".$acceso[$f]."',busca='".$buscac[$f]."' where id='".$Key."'";
			}
  
			mysqli_query($miConex, $upd) or die(mysql_error());	
			$f++;
		} if (isset($_REQUEST['t'])) { ?>
		<script type="text/javascript">document.location="configura.php?p=p&t=t";</script><?php } else { ?>
		<script type="text/javascript">document.location="configura.php?p=p";</script>
  <?php } 
	}
	
	if(isset($_POST['ok'])){ 
		$userdf= explode('*',$_POST['usuario']);
		$usupref = $userdf[0];
		$idunida = $userdf[1];
		$salvac= @$_POST['salva'];
		$passc= @$_POST['pass'];
		$visitasc= @$_POST['visitas'];
		$buscac= @$_POST['busca'];
		$columnas= @$_POST['columnas'];
		$acceso= @$_POST['acceso'];
		
		$queus =mysqli_query($miConex, "SELECT usuario FROM preferencias where usuario='".$usupref."' AND idunidades='".$idunida."'") or die(mysql_error());
		$numus= mysqli_num_rows($queus);
		
		if(($numus) ==0){
		  $inpd="insert into preferencias (id,usuario,salva,pass,visitas,columnas, acceso, busca,idunidades) values(NULL,'".$usupref."','".$salvac."','".$passc."','".$visitasc."','".$columnas."','".$acceso."','".$buscac."','".$idunida."')";
		  mysqli_query($miConex, $inpd) or die(mysql_error()); ?>
		   <script type="text/javascript">document.location="configura.php?p=p";</script><?php
		}else{?>
			<div class="ContenedorAlert" id="cir1"> </div>
			<script type="text/javascript">
				function cierrm(){
					document.getElementById('cir1').innerHTML='';
					document.location="configura.php?p=p";
				}
				showAlert(5000,'<div class="alert negro"><button class="closex" type="button" onclick="cierrm();">X</button><div align="center"><font color="#FFDCA8" size="3"><b>ERROR</b></font></div><div><b><?php echo sprintf($scri_imp6,$usupref)?>.</b></div></div>');
			</script><?php
		} 
	}
	if(isset($_POST['crash']) AND ($_POST['crash']) =="1"){ 
		$marcado= @$_POST['marcado'];
		foreach($marcado as $Key){
			$upd="delete FROM preferencias where id='".$Key."'";
			mysqli_query($miConex, $upd) or die(mysql_error());
		} ?>
		<script type="text/javascript">document.location="configura.php?p=p";</script><?php
	}
?>
<style>
.imputs {
    color: #757373;
    margin: 6px 6px 0.4em;
    width: 30%;
    height: 20px;
    background: linear-gradient(to left, transparent 60%, rgba(0, 0, 0, 0.09) 100%) repeat scroll 0% 0% transparent;
    border-bottom: 1px solid #ACAAAA;
    border-radius: 3px;
	border: 1px solid #B8B8B8;
	padding: 3px;
	font-family: Verdana,sans-serif;
	font-size: 12px;
}	
</style>
<form name="fusio" method="post" action="">
	<input type="hidden" name="fusionar">
	<input type="hidden" name="fus">
</form>
	<script type="text/javascript">
		function alertacon(err,men,tipo,num)  { 
			var counx=0;
			document.getElementById('cir').innerHTML="";
			for (i=0;i<num;i++)   {
			 if ((document.getElementById("marcado"+i).type=="checkbox")&&(document.getElementById("marcado"+i).checked==true))	 {
					counx = counx +1;
				}
			} 

			if((counx) >0){
				if((tipo) =="d"){
						document.location="#openModal";
				}else{
					document.frm1.submit();
				}		
			}else{
				showAlert(5000,'<div class="alert negro" style="display: none"><button class="closex" type="button" onclick="cierr();">X</button><div align="center"><font color="#FFDCA8" size="3"><b>'+err+'</b></font></div><div><b>'+men+'.</b></div></div>');
				return false;
			}	
		}
		function fusion(valor){
			document.fusio.fus.value=valor;
			document.fusio.submit();
		}	
		
		function marca_edit(r1,tipo){ 
			if ((document.getElementById("marcado"+r1).type=="checkbox")&&(document.getElementById("marcado"+r1).checked==true)) {
				document.getElementById("salva["+r1+"]").disabled = "";
				document.getElementById("pass["+r1+"]").disabled = "";
				document.getElementById("visitas["+r1+"]").disabled = "";
				document.getElementById("columnas["+r1+"]").disabled = "";
				if(tipo !='root'){
				  document.getElementById("acceso["+r1+"]").disabled = "";	
				}
				
				document.getElementById("busca["+r1+"]").disabled = "";
				document.getElementById("colum["+r1+"]").style.display ="block";
				document.getElementById("registros["+r1+"]").style.display ="none";
				document.getElementById("visi["+r1+"]").style.display ="block";
				document.getElementById("vis["+r1+"]").style.display ="none";
			}else{
				document.getElementById("salva["+r1+"]").disabled = 'disabled';
				document.getElementById("pass["+r1+"]").disabled = 'disabled';
				document.getElementById("visitas["+r1+"]").disabled = 'disabled';
				document.getElementById("columnas["+r1+"]").disabled = 'disabled';
				document.getElementById("busca["+r1+"]").disabled = 'disabled';
				if(tipo !='root'){
					document.getElementById("acceso["+r1+"]").disabled = 'disabled';
				}
				document.getElementById("colum["+r1+"]").style.display ="none";
				document.getElementById("registros["+r1+"]").style.display ="block";
				document.getElementById("visi["+r1+"]").style.display ="none";
				document.getElementById("vis["+r1+"]").style.display ="block";
			}
	    }
	
		
	</script>
	<div id="crpo">
<fieldset class='fieldset'><?php if(isset($_POST['fusionar'])){  echo '<legend class="vistauserx">'.strtoupper($btfusionar).'</legend>';}
	if(isset($_REQUEST["p"]) AND ($_REQUEST["p"]) =='p' AND !isset($_REQUEST['nuevo'])){	?>
		<legend class="vistauserx"><?php echo $leyenda[1]."--> ".$btdatabase.":&nbsp;<font color=red>".$database_miConex."</font>";?></legend>
		    <div id="openModal" class="modalDialog">
			<div>
				<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
				<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
			</div>
	        </div>
			<form name="frm1" method="post" action="">
				<table border="0" width="100%" class="table" cellspacing="0" cellpadding="0">
					<tr class="vistauser1">
					  <td colspan="2"><span class="Estilo4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $btusuario;?>s</b></span></td>
					  <td width="8%"><div align="center"><b><span class="Estilo4"><?php echo $btRealizarSalvar;?></span></b></div></td>
					  <td width="8%"><div align="center"><b><span class="Estilo4"><?php echo $btEnviarEMail;?></span></b></div></td>
					  <td width="10%"><div align="center"><b><span class="Estilo4"><?php echo $btvis;?></span></b> </div></td>
					  <td width="8%"><div align="center"><b><span class="Estilo4"><?php echo $btcolumnas; ?></span></b> </div></td>
					  <td width="8%"><div align="center"><b><span class="Estilo4"><?php echo $btGuardadBusqueda;?></span></b></div></td>
					  <?php if($rus['tipo']=="root") { ?>
					  <td width="8%"><div align="center"><b><span class="Estilo4"><?php echo $btPermitirAcceso;?></span></b></div></td>
					  <?php } ?>
					  <td width="24%"><b><span class="Estilo4">&nbsp;&nbsp;<?php echo $btdatosentidad3;?></span></b></td>
					</tr> <?php  
					$p=0;
					$r=0;
				while ($MainTableValues= mysqli_fetch_array($resultado)) { 
					$us1 = mysqli_query($miConex, "SELECT * FROM datos_generales where id_datos='".$MainTableValues["idunidades"]."'") or die(mysqli_error($miConex));
					$rus1 = mysqli_fetch_array($us1); $i++; 
					
					$dquien = mysqli_query($miConex, "SELECT * FROM usuarios where login ='".$MainTableValues["usuario"]."'") or die(mysqli_error($miConex));
					$rw_tipo = mysqli_fetch_array($dquien);
					
					?>
						<tr bgcolor="<?php echo $uCPanel->ColorFila($p,$color1,$color2);?>" id="cur_tr_<?php echo $p;?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC');" onMouseOut="this.style.background='<?php echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#DBE2D0');" style="cursor:pointer;">  
							<td width="2%"><div onclick="marca1(<?php echo $p;?>,'#ffffff'); marca_edit('<?php echo $p;?>','<?php echo $rw_tipo['tipo']; ?>');" id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input onclick="marca1(<?php echo $p;?>,'#ffffff'); marca_edit('<?php echo $p;?>','<?php echo $rw_tipo['tipo']; ?>');" type="checkbox" style="display:none; cursor:pointer;" id="marcado<?php echo $p;?>"  name="marcado[]" value="<?php  echo $MainTableValues['id'];?>"></td>
							<td width="20%"><?php echo $MainTableValues["usuario"];?></td>
							<td><div align="center"><input disabled="disabled" style="cursor:pointer;" name="salva[]" id="salva[<?php echo $p;?>]" type="checkbox" class="form-control" <?php if(($MainTableValues["salva"]) =="s"){ echo "checked"; } ?> value="s" size="17"></div></td>
							<td><div align="center"><input disabled="disabled" style="cursor:pointer;" name="pass[]" id="pass[<?php echo $p;?>]" class="form-control" type="checkbox" <?php  if(($MainTableValues["pass"]) =="s"){ echo "checked"; } ?>  value="s"></div></td>
							<td><div align="center" id="visi[<?php echo $p;?>]" style="display:none;">
								<span>
								<span onClick="mueve('visitas[<?php echo $p;?>]',getElementById('visitas[<?php echo $p;?>]').value,'100','ascendente');" style="cursor:pointer; position: absolute; margin-left: 30px; margin-top: 5px; z-index: 999;"><img src="gfx/asc.png"></span>
								<span onClick="mueve('visitas[<?php echo $p;?>]',getElementById('visitas[<?php echo $p;?>]').value,'100','descendente');" style="cursor:pointer; position: absolute; margin-top: 17px; margin-left:30px; z-index: 999;"><img src="gfx/desc.png"></span>
								<input disabled="disabled" name="visitas[]" id="visitas[<?php echo $p;?>]" type="text" maxlength="3" value="<?php echo $MainTableValues["visitas"]; ?>" onKeyPress="return acceptNum(event);" class="mostrar" readonly>
								</span></div><div align="center" id="vis[<?php echo $p;?>]" style="display:block;">
								<input name="total_registros" id="muestra[<?php echo $p;?>]" disabled="disabled" class="form-control" type="text"  value="<?php echo $MainTableValues['visitas'];?>" size="3" style="width:12%;"></div>
						    </td>
							<td><div align="center" id="colum[<?php echo $p;?>]" style="display:none;">
								<span>
								<span onClick="mueve('columnas[<?php echo $p;?>]',getElementById('columnas[<?php echo $p;?>]').value,<?php echo $cantidaddecampos-2; ?>,'ascendente');" style="cursor:pointer; position: absolute; margin-left: 30px; margin-top: 5px; z-index: 999;"><img src="gfx/asc.png"></span>
								<span onClick="mueve('columnas[<?php echo $p;?>]',getElementById('columnas[<?php echo $p;?>]').value,<?php echo $cantidaddecampos-2; ?>,'descendente');" style="cursor:pointer; position: absolute; margin-top: 17px; margin-left:30px; z-index: 999;"><img src="gfx/desc.png"></span>
								<input disabled="disabled" name="columnas[]" id="columnas[<?php echo $p;?>]" type="text" maxlength="3" value="<?php echo $MainTableValues["columnas"]; ?>" onKeyPress="return acceptNum(event);" class="mostrar" readonly>
								</span></div><div align="center" id="registros[<?php echo $p;?>]" style="display:block;">
								<input name="total_registros" id="muestra1[<?php echo $p;?>]" disabled="disabled" class="form-control" type="text"  value="<?php echo $MainTableValues['columnas'];?>" size="3" style="width:12%;"></div>
						    </td>
							<td><div align="center"><input disabled="disabled" name="busca[]" id="busca[<?php echo $p;?>]" type="checkbox" <?php  if(($MainTableValues["busca"]) =="s"){ echo "checked"; } ?> value="s" class="form-control" size="3" style="width: 12%;"></div></td>
							<?php if($rus['tipo']=="root") { ?>
							<td><div align="center"><input disabled="disabled" name="acceso[]" id="acceso[<?php echo $p;?>]" type="checkbox" <?php  if(($MainTableValues["acceso"]) =="s"){ echo "checked"; } ?> value="s" class="form-control" size="1" style="width: 12%;"></div></td>
							<?php } ?>
							<td>&nbsp;&nbsp;<?php echo $rus1['entidad'];?></td>
						</tr>
						
						<?php 	
						$p++;  $r++;  
					} ?>
					<tr> 
						<td colspan="8">
							<input name="guardar" class="btn" type="submit" id="guardar" value="<?php echo $upgrade;?>" onclick="return alertacon('<?php echo $strerror;?>','<?php echo $plea1.$upgrade;?>','','<?php echo $cantconf;?>');">&nbsp;&nbsp;
							<input name="create" id="create-user" type="button" class="btn" onclick="alertacon('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d','<?php echo $cantconf;?>');" value="<?php echo $bteliminar;?>"/>&nbsp;&nbsp;
							<input class="btn" type="submit" name="nuevo" value="<?php echo $btinsertar;?>"> 
							<input type="hidden" name="crash"/> 
						</td>
					</tr>
				</table>
			</form><?php 
	}
	if(isset($_POST['nuevo'])){	?>
		<legend class="vistauserx"><?php echo $leyenda[1]."--> ".$btdatabase.":&nbsp;<font color=red>".$database_miConex."</font>";?></legend> 
			<form name="frm1" method="post" action="">
				<table border="0" width="100%" class="table" cellspacing="0" cellpadding="0">
					<tr> 
						<td class="vistauser1"><span class="Estilo4"><b><?php echo $btusuario;?>s</b></span></td>
						<td width="12%" class="vistauser1"><div align="center"><b><span class="Estilo4"><?php echo $btRealizarSalvar;?></span></b></div></td>
						<td width="12%" class="vistauser1"><div align="center"><b><span class="Estilo4"><?php echo $btEnviarEMail;?></span></b></div></td>
						<td width="15%" class="vistauser1"><div align="center"><b><span class="Estilo4"><?php echo $btvis;?></span></b> </div></td>
						<td width="15%" class="vistauser1"><div align="center"><b><span class="Estilo4"><?php echo $btcolumnas;?></span></b> </div></td>
						<td width="15%" class="vistauser1"><div align="center"><b><span class="Estilo4"><?php echo $btPermitirAcceso;?></span></b> </div></td>
						<td width="15%" class="vistauser1"><div align="center"><b><span class="Estilo4"><?php echo $btGuardadBusqueda;?></span></b></div></td>
					</tr> <?php 					
						$us1 = mysqli_query($miConex, "SELECT * FROM datos_generales") or die(mysql_error());?>
						<tr>  
							<td width="20%">
								<SELECT class="boton" name="usuario"><?php
									while($rus1 = mysqli_fetch_array($us1)){
										$selusu=mysqli_query($miConex, "SELECT * FROM usuarios where idunidades='".$rus1["id_datos"]."'order by nombre,idunidades") or die(mysql_error());
										$MainTableValues= mysqli_fetch_array($resultado); ?>
										<optgroup label="<?php echo $rus1["entidad"];?>"><?php
											while($rowusu = mysqli_fetch_array($selusu)){ ?>											
													<option value="<?php echo $rowusu["login"]."*".$rowusu["idunidades"];?>"><?php echo $rowusu["nombre"];?></option>
												<?php
											} ?></optgroup>
										<?php
									}?>
								</SELECT>
							</td>
							<td><div align="center"><input name="salva" type="checkbox" class="form-control" value="s"></div></td>
							<td><div align="center"><input name="pass" class="form-control" type="checkbox" value="s"></div></td>
							<td><div align="center"><input name="visitas" class="form-control" style="width: 8%;" type="text" onKeyPress="return acceptNum(event);" size="3"></div></td>
							<td><div align="center"><input name="columnas" class="form-control" style="width: 8%;" type="text" onKeyPress="return acceptNum(event);" size="3"></div></td>
							<td><div align="center"><input name="acceso" type="checkbox" value="s" class="form-control" id="acceso"></div></td>
							<td><div align="center"><input name="busca" type="checkbox" value="s" class="form-control" id="busca"></div></td>
						</tr>
					<tr> 
						<td colspan="7"></td>
					</tr>
					<tr> 
						<td colspan="7">
							<input name="ok" class="btn" type="submit" id="ok" value="<?php  echo $btaceptar;?>">&nbsp;&nbsp;
							<input class="btn" type="button" name="cancela" value="<?php echo $btcancelar;?>" onclick="document.location='configura.php?p=p';"> 
						</td>
					</tr>
				</table>
			</form><?php 
	} 
	if(isset($_GET["mc"]) ){
			$marcad=$_GET['mc']; 
			$resultar = mysqli_query($miConex, "SELECT * FROM datos_generales where id_datos='".$marcad."'") or die(mysql_error());
			$row = mysqli_fetch_array ($resultar); ?>
			<legend class="vistauserx"><?php echo $stmodificar."--> <font color=red>".$row['entidad'].".</font> ".$btdatabase.":&nbsp;<font color=red>".$database_miConex."</font>";?></legend>
		<table width="100%" border="0" align="center" clase="table">
		  <form id="frm_entidad" name="frm_entidad" method="post" action="" enctype="multipart/form-data" >
		  <tr>
			<td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $btdatosentidad;?></b></td>
		  </tr>
			  <tr>
				<td width="198" height="26" align="right"><?php echo $btNombre;?>:</td>
				<td width="326">
			     <input onkeypress="return handleEnter(this, event)" name="entidad[]" type="text" id="entidad" class="imput"  value="<?php echo $row['entidad'];?>" size="50"/> </td>
			    <td width="143" align="right">
				&nbsp;&nbsp;<a class='tooltip' href='#'><span><?php echo $ared; ?></span><?php if(( $sexuser[0]) =="m"){ echo "<img src='images/female.png' width='16' height='18'>";} elseif(($sexuser[0]) =="h"){ echo "<img src='images/admin.png' width='16' height='18'>";}else{ echo "-";}?></a>&nbsp; <?php echo $ared; ?>:
			    <td width="414"><input readonly name="inf[]" type="text" id="inf" class="imput" value="<?php echo $tipouser[0]; ?>" size="20" style="width: 305px;"/></td>
			  </tr>
			  <tr>
				<td height="26" align="right">Sector:</td>
				<td><input onkeypress="return handleEnter(this, event)"  name="sector[]" type="text" class="imput" id="sector" value="<?php echo $row['sector'];?>" size="20"/></td>
				<td align="right"><?php echo "&nbsp;<a class='tooltip' href='#'><span>".$rsi."</span><img title='".$rsi."' src='images/rsi.png' width='20' height='20'></a>"; ?>&nbsp;&nbsp;<?php echo $respsi; ?>:</td>
				<td><input readonly name="rsi[]" type="text" id="rsi" class="imput" value="<?php echo @$tipouser[1]; ?>" size="20" style="width: 305px;"/><div style="margin-left: -1px; font-style:italic;  color: #e86110; <?php if (@$tipouser[1]!=""){ echo "display:none"; }?>"><b>(<?php echo $debe; ?>)</b></div></td>
			  </tr>
			  <tr>
				<td height="24" align="right">E-Mail:</td>
				<td colspan="3"><input onkeypress="return handleEnter(this, event)" name="mail[]" type="email" class="imputs" id="mail" size="20" value="<?php echo $row['mail'];?>"/></td>
				</tr>
			  <tr>
				<td height="24" align="right"><?php echo $btCodigo1;?>:</td>
				<td colspan="3"><input onkeypress="return handleEnter(this, event)"  name="codigo[]" type="text" class="imput" id="codigo" size="20" value="<?php echo $row['codigo'];?>"/></td>
				</tr>
			  <tr>
				<td height="26" align="right"><?php echo $SITIO1;?>:</td>
				<td colspan="3"><input onkeypress="return handleEnter(this, event)"  name="web[]" type="text" id="web" class="imput" value="<?php echo $row['web'];?>" size="40"/></td>
			  </tr>
			  <tr>
				<td align="right"><?php echo $provincia;?>:</td>
				<td colspan="3"><select onkeypress="return handleEnter(this, event)"  name="provincia[]" class="SELECTuno" style="margin-left: 5px;"><?php		
					while($rowa=mysqli_fetch_array($resprov)){ ?>
					<option value="<?php echo $rowa['id'];?>" <?php if(($rowa['id']) ==$row['provincia']){ echo "SELECTed"; }?>><?php echo $rowa['nombre'];?></option><?php
					} ?>
				</select></td>				
			  </tr>  
			  <tr>
				<td align="right">SMTP:</td>
				<td colspan="3"><input name="id_datos[]" type="hidden" value="<?php echo $row['id_datos'];?>"/><input onkeypress="return handleEnter(this, event)"  name="smtp[]" type="text" value="<?php echo $row['smtp'];?>" class="imput" id="smtp" size="30"/></td>
			  </tr>
		  <tr>
			<td colspan="4">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input name="modifica" type="submit" class="btn" id="modifica" onMouseOVer="this.style.cursor='pointer';" value="<?php echo $btaceptar;?>" />&nbsp;&nbsp;	
				<input class="btn" type="button" name="cancela" value="<?php echo $btcancelar;?>" onclick="document.location='configura.php?p=d';">			</td>
		  </tr></form>
		</table><?php 
	} ?>
	<div id="muestra_ent"><?php
	if(isset($_POST['fusionar']) OR isset($_GET['fus'])){ 
		if(isset($_POST['fus'])){ $fus = $_POST['fus']; }
		if(isset($_GET['fus'])){ $fus = $_GET['fus']; }
		$seldgr = "SELECT * FROM datos_generales where id_datos !='1'  AND id_datos !='".$fus."' ORDER BY entidad";
		$qseldgr = mysqli_query($miConex, $seldgr) or die(mysql_error());
		$seldgr1 = "SELECT * FROM datos_generales where id_datos ='".$fus."'";
		$qseldgr1 = mysqli_query($miConex, $seldgr1) or die(mysql_error());
		$rqseldgr1= mysqli_fetch_array($qseldgr1);?> 
		<div align="center"><div class="message"><?php echo $recomendable;?><b><a href="salva.php" style="cursor:poniter;"><?php echo $btsalvas;?></a></b></div></div>
		<form name="busca" method="post" action="">
			<table width="100%" border="0" cellpadding="1" cellspacing="1" class="sgf1">
				<tr>
					<td>
						<?php echo $seleccione." ".$btfusionar2;?><br>
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table"><?php 
								$p1=0;
								while ($rqseldgr= mysqli_fetch_array($qseldgr)) { $i++; ?>						
									<tr bgcolor="<?php  echo $uCPanel->ColorFila($p1,$color1,$color2);?>" id="cur_tr_<?php echo $p1;?>" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p1;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p1,$color1,$color2);?>';colorear('<?php echo $p1;?>','#DBE2D0');" onClick="marca1(<?php echo $p1;?>,'#ffffff')" >								 
										<td width="4%"><input name="marcado[]" id="marcado[<?php echo $p1;?>]" onClick="marca1(<?php echo $p1;?>,'#ffffff')"  type="checkbox" value="<?php  echo $rqseldgr['id_datos'];?>"></td>
										<td width="96%"><label for="marcado[]"><?php  echo $rqseldgr['entidad'];?></label></td>
									</tr><?php
									$p1++;
								} ?>
								<tr> 
									<td colspan="2"><?php if((mysqli_num_rows($qseldgr)) > 1){ ?><img src="images/check_all.png" name="marcart" width="17" height="17" border="0" usemap="#marcart" id="marcart" title="Seleccionar Todos" onClick='marcar_todoz();' onMouseOver="this.style.cursor='pointer';">&nbsp;<img src="images/uncheck_all.png" name="desmarcart" width="17" height="17" id="desmarcart" title="Desmarcar Todos" onClick='desmarcar_todoz();' onMouseOver="this.style.cursor='pointer';"><?php } ?></td>
								</tr>
								 <tr> 
								<td colspan="2"><input name="salva" type="hidden" value="<?php echo $salv;?>"><input type="checkbox" class="btn" name="salva" value="s" checked="checked" />&nbsp;<?php echo "<b>".$btsalvas."</b>";?></td>
                                 </tr>	
								<tr> 
									<td colspan="2"><input name="vieja" type="hidden" value="<?php echo $fus;?>"><input type="submit" class="btn" name="funcionar" value="<?php echo $btfusionar1;?>" />&nbsp;<input type="button" onclick="document.location='configura.php?p=d';" class="btn" name="cancela" value="<?php echo $btcancelar;?>" /></td>
								</tr>
                              								
							</table>
					</td>
				</tr>
			</table>
		</form>	<?php
	}
	if(isset($_POST['funcionar'])){
		@$marcado=$_POST['marcado'];
		@$viejaent = $_POST['vieja'];
		
		function get_tables($miConex,$database_miConex, $u)
		{
		  $result = array();
		  $res = mysqli_query($miConex, "SHOW TABLES FROM ".$database_miConex);
		  while($cRow = mysqli_fetch_array($res))
		  {
			$result[] = $cRow[0];
		  }
		   return $result[$u];
		}
		
		function salvar($i,$DBname,$sql,$miConex){
			require_once( 'common.php' );
				if(($i) =="es"){
					include('esp.php');
				}else{ 
					include('eng.php');
				}
				$tbl=array();
				$tiem = time();
				mysqli_SELECT_db($miConex, $DBname);
				$seldg= mysqli_query($miConex, "SELECT * FROM datos_generales where id_datos='1'") or die(mysql_error());
				$rseldg = mysqli_fetch_array($seldg);
				$adtabla="esydat";
				$roo = $_SERVER['DOCUMENT_ROOT'];
				$posicion = strripos($roo, "/");
				$ruta = substr($roo, 0, $posicion)."/tmp/"; 

							$arr_num=array("int", "real");
							$tiem = time();
							
							$total_tab=0;
							
							$sql_cant_tablas = mysqli_query($miConex, "SHOW TABLES FROM ". $DBname);
							$cant_tablas = mysqli_num_rows ($sql_cant_tablas);
  											
							while (@$total_tab < $cant_tablas) {
								$tb_names[$total_tab] = get_tables($miConex,$DBname, $total_tab);
								$tbl[]= $tb_names[$total_tab];
									$total_tab++;	
							}						

							if($total_tab < 50) { 
								$step=1;
							}else{ 
								$step =Round((100/$total_tab),2);
							}
							$export=1;$paso=$step;

							$fp = fopen($ruta."salva_".$DBname.".sql", "w");
							require ('clases3.php');
							$prog = new expcons();
							$prog->reset(1);

							if (($export==1)){
								//bloque de estructuras
								@$pasado=0;
								$todo="-- Datos generados con Regimed\r\n-- Fecha: ".date('d-m-Y')."\r\n\r\n".$sql.";\r\nSET FOREIGN_KEY_CHECKS=0;\r\n";

								foreach($tbl AS $key=>$tabla)	{
									@$pasado=@$pasado+$paso;	
									$fi = "show create table ".$tabla;				
									$fiq = mysqli_query($miConex, $fi) or die(mysql_error()); 												
									$fiq = mysqli_fetch_array($fiq);
									$o = $fiq[1];
									$fiche2= $o;
									$head="\r\n\r\n-- ".$estructra3.$dela.$tablasa."-> `".$tabla."`\r\n--\r\n";
									$todo.=@$head;
									$drop="DROP TABLE IF EXISTS ".chr(96).$tabla.chr(96)."; ".chr(10).chr(13);;
									$todo.=$drop;
									$todo.=$fiche2.';';
									
									$ff = "SELECT * FROM ".$tabla;
									$result=@mysqli_query($miConex, $ff) or die(mysql_error()); 
									$trows=@mysqli_num_rows($result);
									$campos = @mysqli_num_fields($result);
									$head="\r\n-- ".$exptr1.$dela.$tablasa."-> `".$tabla."`\r\n-- ".$totalrecord.": ".$trows."\r\n-- ----------------------------------- \r\n";
									$todo .=$head;
									$tt=$tabla;
									$i1=0;
									$dato1="";
									while ($i1 < $campos){
										$fields  = mysqli_fetch_field_direct ($result, $i1); 
										$name1 = $fields->name;
										$flags = $fields->flags;
										
										$dato1 .=$name1.",";
											$i1++;								
									}
									$linea="INSERT INTO ".chr(96).$tabla.chr(96). " (".substr($dato1,0,-1).")  VALUES \r\n";
									$num=1;
									if(($trows) !=0){
										$todo .=$linea;
									}
									while($row = @mysqli_fetch_object($result)){
										$i = 0;
										@$pasado=@$pasado+$paso;	
										$datos="(";
										$datof= "";
										$dato ="";
										while ($i < $campos){
											$fields  = mysqli_fetch_field_direct ($result, $i); 
											$name = $fields->name;
											$flags = $fields->flags;
											$rempz = str_replace(chr(39),chr(39).chr(39),$row->$name);
											$dato=chr(39).$rempz.chr(39);		

											if(in_array($fields->type,$arr_num)){										
												$dato=str_replace(chr(39),"",$dato);
											}
											if ($i < $campos-1) { $dato .=",";}
											$i++;								
											$datos .=$dato;
											$datof= "";
										}
										
										if(($trows) ==$num ){
											$data=$datos.');';
										}else{
											$data=$datos.'),';										
										}								

										$todo.=$data."\r\n";	
										@$num++;
										@$num1++;
										if (@$pasado < 48){
											@$pasado=48-@$pasado;
										}
									}
								}
								fwrite($fp, $todo);		
								fwrite($fp, "\r\n\r\nSET FOREIGN_KEY_CHECKS=1;\r\n");
								flock($fp, 3);
							}

							fclose($fp);
							@copy($ruta."salva_".$DBname.".sql","salvas/salva_".$DBname.".sql");
							$prog->elimina($ruta."salva_".$DBname.".sql");
							$filePerms = '0777';
							$dirPerms  = '0777';
							$filemode = octdec($filePerms);
							$dirmode = octdec($dirPerms);
							$chmodOk = TRUE;
								if (!mosChmodRecursive("salvas/salva_".$DBname.".sql", $filemode, $dirmode)) {
									$chmodOk = FALSE;
								}
							if (!$chmodOk) {
								$chmod_report = 'Nota: Los permisos del directorio y de los archivos no han podido ser cambiados.<br />'.
												'Cambia los permisos de los archivos y directorios manualmente.';
							}
							
		}
		if(($marcado) ==""){ ?>
			<div class="ContenedorAlert" id="cir"> </div>
			<script type="text/javascript">
				showAlert(4000,'<div class="alert negro" style="display: none"><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div><b><?php echo $plea0;?>.</b></div></div>');
			</script> <br>
				<?php include ("version.php");?>
				<script type="text/javascript" src="js/bootstrap.min.js"></script>
				<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script><?php
			exit;
		}

		if(isset($_POST['salva']) AND ($_POST['salva']) =="s"){
			salvar('es', $database_miConex,"USE `salva_".$database_miConex."`",$miConex); 
		}
		$gh=0;
		foreach($marcado as $Key){
			$seldg = mysqli_query($miConex, "SELECT * FROM datos_generales where id_datos='".$Key."'") or die(mysql_error());
			$rseldg = mysqli_fetch_array($seldg);

		$seldselreg_claves = mysqli_query($miConex, "SELECT * FROM usuarios where idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
			while($rselreg_claves = mysqli_fetch_array($seldselreg_claves)){
				if(($rselreg_claves['idarea']) =="Inform&aacute;tica"){
					$selreg_claves = mysqli_query($miConex, "update reg_claves set idunidades='".$viejaent."', idarea='Inform&aacute;tica(F_".$rseldg['codigo'].")' where idunidades='".$rseldg['id_datos']."'") or die(mysql_error());			
				}else{
					$selreg_claves = mysqli_query($miConex, "update reg_claves set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'") or die(mysql_error());					
				}
			}

	$selaftareas = mysqli_query($miConex, "update areas set idunidades='".$viejaent."', nombre='Inform&aacute;tica(F_".$rseldg['codigo'].")' where nombre='Inform&aacute;tica'  AND idunidades='".$rseldg['id_datos']."'") or die(mysql_error());			

	$selaftareas1 = mysqli_query($miConex, "update areas set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
	$seldselreg_aft = mysqli_query($miConex, "SELECT * FROM aft where idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
		while($rselreg_aft = mysqli_fetch_array($seldselreg_aft)){
			if(($rselreg_aft['idarea']) =="Inform&aacute;tica"){
			$selaft1 = mysqli_query($miConex, "update aft set idunidades='".$viejaent."' , idarea='Inform&aacute;tica(F_".$rseldg['codigo'].")'  where  idarea='Inform&aacute;tica'  AND idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
			}else{
			$selaft1 = mysqli_query($miConex, "update aft set idunidades='".$viejaent."'  where  idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
			}
		}
			
			$seldselreg_aft1 = mysqli_query($miConex, "SELECT * FROM bajas_aft where idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
			while($rselreg_aft1 = mysqli_fetch_array($seldselreg_aft1)){
				if(($rselreg_aft1['idarea']) =="Inform&aacute;tica"){
					$selbajas_aft1 = mysqli_query($miConex, "update bajas_aft set idunidades='".$viejaent."' , idarea='Inform&aacute;tica(F_".$rseldg['codigo'].")'  where  idarea='Inform&aacute;tica'  AND idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
				}else{
					$selbajas_aft1 = mysqli_query($miConex, "update bajas_aft set idunidades='".$viejaent."'  where  idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
				}
			}

			$seldselreg_exp = mysqli_query($miConex, "SELECT * FROM bajas_exp where idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
			while($rselreg_exp = mysqli_fetch_array($seldselreg_exp)){
				if(($rselreg_exp['idarea']) =="Inform&aacute;tica"){
					$selbajas_exp = mysqli_query($miConex, "update bajas_exp set idunidades='".$viejaent."' , idarea='Inform&aacute;tica(F_".$rseldg['codigo'].")'  where  idarea='Inform&aacute;tica'  AND idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
				}else{
					$selbajas_exp = mysqli_query($miConex, "update bajas_exp set idunidades='".$viejaent."'  where  idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
				}
			}

			$seldselreg_expd = mysqli_query($miConex, "SELECT * FROM exp where idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
			while($rselreg_expd = mysqli_fetch_array($seldselreg_expd)){
				if(($rselreg_expd['idarea']) =="Inform&aacute;tica"){
					$selbajas_expd = mysqli_query($miConex, "update exp set idunidades='".$viejaent."' , idarea='Inform&aacute;tica(F_".$rseldg['codigo'].")'  where  idarea='Inform&aacute;tica'  AND idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
				}else{
					$selbajas_expd = mysqli_query($miConex, "update exp set idunidades='".$viejaent."'  where  idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
				}
			}

			$seltraspasos = mysqli_query($miConex, "update traspasos set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
			$seltraspasos1 = mysqli_query($miConex, "update traspasos set idunidades='".$viejaent."', origen='Inform&aacute;tica(F_".$rseldg['codigo'].")'  where origen='Inform&aacute;tica'  AND idunidades='".$rseldg['id_datos']."'") or die(mysql_error());

			$seldgimp = mysqli_query($miConex, "SELECT * FROM inspecciones where idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
			$rseldgimp = mysqli_fetch_array($seldgimp);
			$cadimp = str_ireplace('Inform&aacute;tica','Inform&aacute;tica(F_'.$rseldg['codigo'].')',$rseldgimp['area']);
			$selinspecciones = mysqli_query($miConex, "update inspecciones set idunidades='".$viejaent."', area='".$cadimp."' where idunidades='".$rseldg['id_datos']."'") or die(mysql_error());

			$selmtto = mysqli_query($miConex, "update mtto set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'") or die(mysql_error());

			$selplan_rep = mysqli_query($miConex, "update plan_rep set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
			$selplan_rep1 = mysqli_query($miConex, "update plan_rep set idunidades='".$viejaent."', idarea='Inform&aacute;tica(F_".$rseldg['codigo'].")'  where  idarea='Inform&aacute;tica'  AND idunidades='".$rseldg['id_datos']."'") or die(mysql_error());

			$selpreferencias = mysqli_query($miConex, "update preferencias set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'") or die(mysql_error());

			$seldgareasselusuarios = mysqli_query($miConex, "SELECT * FROM usuarios where idunidades='".$rseldg['id_datos']."'") or die(mysql_error());
			
			while($rseldgareasselusuarios = mysqli_fetch_array($seldgareasselusuarios)){
				if(($rseldgareasselusuarios['idarea']) =="Inform&aacute;tica"){
					$selusuarios = mysqli_query($miConex, "update usuarios set idunidades='".$viejaent."', idarea='Inform&aacute;tica(F_".$rseldg['codigo'].")' where idunidades='".$rseldg['id_datos']."'") or die(mysql_error());			
				}else{
					$selusuarios = mysqli_query($miConex, "update usuarios set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'") or die(mysql_error());					
				}
			}

			$seldg = mysqli_query($miConex, "delete FROM datos_generales where id_datos='".$Key."'") or die(mysql_error());
			$gh++;
		} ?>
		<script type="text/javascript">document.cookie = "unidades=;"; window.parent.location='configura.php?p=d';</script><?php
	}
	if(isset($_GET["p"]) AND ($_GET["p"]) =='d' AND !isset($_POST['nuevo']) AND !isset($_POST['fusionar']) AND !isset($_GET['fus'])){ ?>
		<script type="text/javascript">
			function novax(){
				document.getElementById('entidad').value="";
				document.getElementById('sector').value="";
				document.getElementById('reup').value="";
				document.getElementById('NombreAdmin').value="";
				document.getElementById('LoginAdmin').value="";
				document.getElementById('PassAdmin').value="";
				document.getElementById('mail').value="";
				document.getElementById('web').value="";
				document.getElementById('smtp').value="";
				document.getElementById('crpo').style.display='none';
				document.getElementById('nova').style.display='block';
			}
			function novax1(){
				document.getElementById('crpo').style.display='block';
				document.getElementById('nova').style.display='none';
			}

		</script>
		<legend class="vistauserx"><?php echo $leyenda[3]."--> ".$btdatabase.":&nbsp;<font color=red>".$database_miConex."</font>";?></legend> 
		<table width="100%" border="0" align="center" class="table">
		  <form id="frm_entidad" name="frm_entidad" method="post" action="configura.php" enctype="multipart/form-data" >
		  <tr>
			<td colspan="2"><b><?php echo $Opciones;?></b></td>
		  </tr><?php
		  while($vale = mysqli_fetch_array ($resulta)){
			$iddentid=$vale['id_datos']; ?>
		  <tr>
			<td width="99%"><div align="left" title="<?php echo $mostrar6." ".$Opciones.": ". $vale['entidad'];?>"><span onclick="muestraentidad('<?php echo $iddentid;?>');"><?php echo $vale['entidad'];?></span> &nbsp;&nbsp;&nbsp;<?php if(($existenciadt) >1 AND ($vale['id_datos']) ==1){ ?><img align="absmiddle" src="images/fusionar.png" name="fusionar" width="24" height="17" border="0" id="fusionar" title="<?php echo $btfusionar;?>" onClick="fusion('<?php echo $vale['id_datos'];?>');" onMouseOver="this.style.cursor='pointer';"><?php }else{ ?><img align="absmiddle" src="images/fusionaroff.png" name="fusionar" width="24" height="17" border="0" id="fusionar" title="<?php echo $btfusionar;?>"><?php } ?>&nbsp;&nbsp;&nbsp;<img onclick="window.parent.location='configura.php?mc=<?php echo $vale['id_datos'];?>';" title='<?php echo $stmodificar." ".$vale['entidad'];?>' style='cursor:pointer' src='images/file-edit.png' width='16' height='16' align='absmiddle' /><?php if(($vale['id_datos']) !='1'){ ?>&nbsp;&nbsp;&nbsp;<img onclick="if(confirm('<?php echo $cuidado;?>')){ delentidad('<?php echo $vale['id_datos'];?>'); }" title='<?php echo $steliminar1." ".$vale['entidad'];?>' style='cursor:pointer' src='images/quitar.png' width='15' height='15' align='absmiddle' /><?php } ?></div></td>				
		  </tr>
		  <?php
		  } ?>
		  <tr>
			<td colspan="2"><br>&nbsp;&nbsp;&nbsp;<input name="nuevaentidad" type="button" class="btn" id="nuevaentidad" onMouseOVer="this.style.cursor='pointer';" onclick="novax(); " value="<?php echo $n_entidad;?>" />
			</td>
		  </tr>
</form>
		</table>
		<div id="muestraent"></div>
		<?php
	}	 ?>
</fieldset>
</div>
</div>
<script type="text/javascript">
	function chequea(){
		var f= document.frm_entidad;
		var valido = false;
		if((document.getElementById('entidad').value) ==""){
			showAlert(4000,'<div class="alert negro" style="display: none"><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div><b>Falta el nombre de la Entidad.</b></div></div>');			
			document.getElementById('entidad').focus();
			return false;
		}else if((document.getElementById('sector').value) ==""){
			showAlert(4000,'<div class="alert negro" style="display: none"><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div><b>Falta el Sector de la Entidad.</b></div></div>');
			document.getElementById('sector').focus();	
			return false;
		}else if((document.getElementById('reup').value) ==""){
			showAlert(4000,'<div class="alert negro" style="display: none"><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div><b>Falta el Codigo Reup de la Entidad.</b></div></div>');
			document.getElementById('entidad').focus();
			return false;
		}else if((document.getElementById('NombreAdmin').value) ==""){
			showAlert(4000,'<div class="alert negro" style="display: none"><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div><b>Falta el nombre del Administrador del Sitio Web.</b></div></div>');
			document.getElementById('NombreAdmin').focus();
			return false;
		}else if((document.getElementById('LoginAdmin').value) ==""){
			showAlert(4000,'<div class="alert negro" style="display: none"><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div><b>Falta el Login del Administrador la Entidad.</b></div></div>');
			document.getElementById('LoginAdmin').focus();
			return false;
		}else if((document.getElementById('PassAdmin').value) ==""){
			showAlert(4000,'<div class="alert negro" style="display: none"><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div><b>Falta la Clave del Administrador la Entidad.</b></div></div>');
			document.getElementById('PassAdmin').focus();
			return false;
		}else if((document.getElementById('mail').value) ==""){
			showAlert(4000,'<div class="alert negro" style="display: none"><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div><b>Falta el E-Mail del Administrador de la Entidad.</b></div></div>');
			document.getElementById('mail').focus();
			return false;
		}else if (document.getElementById('mail').value.indexOf('@', 0) == -1 || document.getElementById('mail').value.indexOf('.', 0) == -1){
			showAlert(4000,'<div class="alert negro" style="display: none"><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div><b>El E-Mail del Administrador no es correcto.</b></div></div>');
			document.getElementById('mail').focus();
			return false;
		}else if((document.getElementById('smtp').value) ==""){
			showAlert(4000,'<div class="alert negro" style="display: none"><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div><b>Falta el Servidor SMTP.</b></div></div>');
			document.getElementById('smtp').focus();
			return false;
		}else{
			novax1();
			insertaent(document.getElementById('entidad').value,document.getElementById('sector').value,document.getElementById('reup').value,document.getElementById('NombreAdmin').value,document.getElementById('LoginAdmin').value,document.getElementById('PassAdmin').value,document.getElementById('sex').value,document.getElementById('mail').value,document.getElementById('web').value,document.getElementById('provincia').value,document.getElementById('smtp').value);
		}
	}
</script>
<div id="nova" style="display:none;">
	<fieldset class='fieldset'><legend class="vistauserx"><?php echo $n_entidad."--> ".$btdatabase.":&nbsp;<font color=red>".$database_miConex."</font>";?></legend>	
		<form id="frm_entidad" name="frm_entidad" method="post" action="" enctype="multipart/form-data" >
		<fieldset class='fieldset'><legend class="vistauserx1"><?php echo $n_entidad;?></legend>	
			<table width="100%" border="0" align="center">
				<tr>
					<td>&nbsp;</td>
					<td width="819"><b><?php echo $btdatosentidad;?></b></td>
				</tr>
				<tr>
					<td width="144" height="26" align="right"><?php echo $btNombre;?>:</td>
					<td>
					  <input name="entidad" type="text" id="entidad" autofocus class="imput" placeholder="<?php echo $btdatosentidad5;?>" size="50"/>      </td>
				</tr>
				<tr>
					<td height="26" align="right">Sector:</td>
					<td><input name="sector" type="text" class="imput" id="sector" placeholder="<?php echo $perteneciente1;?>" size="20"/></td>
			    </tr>
				<tr>
					<td height="24" align="right">REUP:</td>
					<td><input name="reup" type="text" class="imputs" id="reup" onKeyPress="return acceptNum(event);" placeholder="<?php echo $btCodigo1;?>" size="20" onBlur="reupx(this.value);"/><span id="reux"></span></td>
				</tr>
			</table>
		</fieldset>
		<fieldset class='fieldset'><legend class="vistauserx1"><?php echo $datosdelamin;?></legend>	
			<table width="100%" border="0" align="center">
					<td width="15%" height="26" align="right"><?php echo $nombreapel2;?></td>
					<td width="85%" colspan="2"><input onkeypress="return handleEnter(this, event)" name="NombreAdmin" type="text" placeholder="<?php echo $name_admin;?>" id="NombreAdmin" class="imput" size="40"/></td>
				</tr>
				<tr>
					<td height="26" align="right"><?php echo $nick;?>:</td>
					<td colspan="2"><input onkeypress="return handleEnter(this, event)" name="LoginAdmin" placeholder="<?php echo $nick1;?>" type="text" id="LoginAdmin" class="imput" size="40" onBlur="usuars(this.value);" /><span id="usux"></span></td>
				</tr>
				<tr>
					<td height="26" align="right"><?php echo $btpassw;?>:</td>
					<td colspan="2"><input onkeypress="return handleEnter(this, event)" name="PassAdmin" placeholder="<?php echo $btpassw2;?>" type="text" id="PassAdmin" class="imput" size="40"/></td>
				</tr>
				<tr>
					<td height="26" align="right"><?php echo $Sexo;?>:</td>
					<td colspan="2"><SELECT onkeypress="return handleEnter(this, event)" name="sex" class="SELECTuno" id="sex"/>
						<option value="h"><?php echo $Hombre;?></option>
						<option value="m"><?php echo $Mujer;?></option>
						</SELECT></td>
				</tr>
				<tr>
					<td height="26" align="right"><?php echo $electron;?>:</td>
					<td colspan="2"><input onkeypress="return handleEnter(this, event)" name="mail" placeholder="<?php echo $electron;?>" type="email" id="mail" class="imputs" size="40"/></td>
				</tr>
				<tr>
					<td height="26" align="right"><?php echo $web;?>:</td>
					<td><input onkeypress="return handleEnter(this, event)"  name="web" type="url" placeholder="<?php echo $web;?> Ej: http://www.miweb.com" id="web" class="imputs" size="50"/></td>
				</tr>
				<tr>
					<td align="right"><?php echo $provincia;?>:</td>
					<td><SELECT  onkeypress="return handleEnter(this, event)" name="provincia" id="provincia" class="SELECTuno"><?php		
						while($rowa=mysqli_fetch_array($resprov)){ ?>
						<option value="<?php echo $rowa['id'];?>" <?php if(($rowa['id']) ==$vale['provincia']){ echo "SELECTed"; }?>><?php echo $rowa['nombre'];?></option><?php
						} ?>
					</SELECT></td>
				</tr>  
				<tr>
					<td align="right">SMTP:</td>
					<td><input  onkeypress="return handleEnter(this, event)" name="smtp" placeholder="<?php echo $serv1?>" type="text" class="imput" id="smtp" size="30"/></td>			
				</tr>
			</table>
		</fieldset>
			<table width="100%" border="0" align="center">
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input name="newva" type="button" class="btn" onClick="return chequea();" id="newva" value="<?php echo $btaceptar;?>" />&nbsp;&nbsp;
						<input class="btn" type="button" name="cancela" value="<?php echo $btcancelar;?>" onClick="novax1();"> 
					</td>
				</tr>
			</table>
		</form>
	
</fieldset>
</div>
<br>
<?php include ("version.php");?>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/main.js"></script>