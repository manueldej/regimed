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
include('mensaje.php');	
$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($sel, $miConex) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$selpr = "select * from provincia ORDER BY nombre";
$qselpr = mysqli_query($selpr, $miConex) or die(mysql_error());
$cuantos = 5;
if(($rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}
$resprov = mysqli_query("select * from provincia",$miConex) or die(mysql_error());
$orga = array("COPEXTEL","DATAZUCAR");
$i=0;
?>

<?php include('barra.php');?>
<div id="buscad">
<form name="fusio" method="post" action="">
	<input type="hidden" name="fusionar">
	<input type="hidden" name="fus">
</form>
<script type="text/javascript">
	function cierrt(){
		document.getElementById('cir').innerHTML="";
	}
	function doSubmit(){	
		var cuta=0;
		for (i=0; i<document.busca.elements.length; i++){				
			if((busca.elements[i].type=="checkbox")&&(busca.elements[i].checked==true)){
				cuta = cuta + 1;
			}
		}
		if((cuta) !=0){
			submit();
		}else{
			showAlert(2000,'<div class="alert negro"><button class="closex" type="button" onclick="cierrt();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div align="center"><b><?php echo $plea1.$btfusionar1;?>.</b></div></div>');
			return false;
		}
	}
	function fusion(valor){
		document.fusio.fus.value=valor;
		document.fusio.submit();
	}	
	function marcar_todoz()  { 
		var coun=0;
		for (i=0;i<busca.elements.length;i++)   {
			if ((busca.elements[i].type=="checkbox")&&(busca.elements[i].checked==false))	 {
				busca.elements[i].checked=true;
				document.getElementById("cur_tr_"+coun).style.backgroundColor='#DBE2D0';
				coun = coun +1;
			}
		} 
	}
	 function desmarcar_todoz()  {
		var couna=0;
		for (i=0;i<busca.elements.length;i++)	 {
			if ((busca.elements[i].type=="checkbox")&&(busca.elements[i].checked==true))	   {
				document.getElementById("cur_tr_"+couna).style.backgroundColor='';
				busca.elements[i].checked=false;
				couna = couna +1;
			}		
		}for (is=0;is<busca.elements.length;is++)	 {
			document.getElementById("cur_tr_"+is).style.backgroundColor='';
		}
	 }
</script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script><?php
	include('jquery.php'); ?>
<div class="ContenedorAlert" id="cirx"> </div>
<fieldset class='fieldset'><legend class="vistauserx"><?php if(isset($_POST['fusionar'])){  echo strtoupper($btfusionar);}else{ echo strtoupper($bteditar."  ".$btdatosentidad2);  }?></legend>
		<div id="openModal" class="modalDialog">
			<div>
				<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
				<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
			</div>
		</div><?php
	if(isset($_POST['crash']) AND ($_POST['crash']) !=""){
		@$marcado = @$_POST['marcado'];
		if(($marcado) ==""){
			show_message($strerror,$plea8.$btdatosentidad2.".","cancel","editaunidad.php"); ?>
			  <br><hr width="70%" align="center">
			<div class="Footer">
				  <div class="Footer-inner">
					 <div class="Footer-text"><p><?php include ("version.php");?></p></div>
			  </div>
			</div><?php
			exit;
		}	
		foreach($marcado as $key){		
			$delp = "delete from datos_generales where id_datos='".$key."'";
			$qdelm = mysqli_query($delp) or die(mysql_error());
		}?>
		<script type="text/javascript">document.location="editaunidad.php";</script><?php
	}
	if(isset($_POST['fusionar'])){ 
		@$fus = @$_POST['fus'];
		$seldgr = "select * from datos_generales where id_datos !='1'  AND id_datos !='".$fus."' ORDER BY entidad";
		$qseldgr = mysqli_query($seldgr, $miConex) or die(mysql_error());
		$seldgr1 = "select * from datos_generales where id_datos ='".$fus."'";
		$qseldgr1 = mysqli_query($seldgr1, $miConex) or die(mysql_error());
		$rqseldgr1= mysqli_fetch_array($qseldgr1); ?>
		<form name="busca" method="post" action="" onsubmit="return doSubmit();">
			<table width="100%" border="0" cellpadding="1" cellspacing="1" class="sgf1">
				<tr>
					<td>
						<fieldset class='fieldset'><legend class="vistauserx"><?php echo $seleccione." ".$btfusionar2;?></legend>
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
									<td colspan="2"><input name="vieja" type="hidden" value="<?php echo $fus;?>"><input type="submit" class="btn" name="funcionar" value="<?php echo $btfusionar1;?>" />&nbsp;<input type="button" onclick="document.location='editaunidad.php';" class="btn" name="cancela" value="<?php echo $btcancelar;?>" /></td>
								</tr>						
							</table>
						</fieldset>
					</td>
				</tr>
			</table>
		</form>	<?php
	}
	if(isset($_POST['funcionar'])){
		@$marcado=$_POST['marcado'];
		@$viejaent = $_POST['vieja'];
		$gh=0;
		if(($marcado) ==""){
			show_message($strerror,$plea8.$btdatosentidad2.".","cancel","editaunidad.php"); ?> <br>
			<div id="footer" class="degradado" align="center">
				<div class="container">
					<p class="credit"><?php include ("version.php");?></p>
				</div>
			</div>
			<div class="ContenedorAlert" id="cir"> </div>
				<script type="text/javascript" src="js/bootstrap.min.js"></script>
				<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script><?php
			exit;
		}
		foreach($marcado as $Key){
			$seldg = mysqli_query("select * from datos_generales where id_datos='".$Key."'", $miConex) or die(mysql_error());
			$rseldg = mysqli_fetch_array($seldg);

			$selaft = mysqli_query("update areas set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'", $miConex) or die(mysql_error());

			$selaft = mysqli_query("update aft set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'", $miConex) or die(mysql_error());

			$selbajas_aft = mysqli_query("update bajas_aft set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'", $miConex) or die(mysql_error());

			$selexp = mysqli_query("update exp set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'", $miConex) or die(mysql_error());

			$selbajas_exp = mysqli_query("update bajas_exp set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'", $miConex) or die(mysql_error());

			$seltraspasos = mysqli_query("update traspasos set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'", $miConex) or die(mysql_error());

			$selinspecciones = mysqli_query("update inspecciones set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'", $miConex) or die(mysql_error());

			$selmtto = mysqli_query("update mtto set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'", $miConex) or die(mysql_error());

			$selplan_rep = mysqli_query("update plan_rep set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'", $miConex) or die(mysql_error());

			$selpreferencias = mysqli_query("update preferencias set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'", $miConex) or die(mysql_error());
			
			$selreg_claves = mysqli_query("update reg_claves set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'", $miConex) or die(mysql_error());

			$selusuarios = mysqli_query("update usuarios set idunidades='".$viejaent."' where idunidades='".$rseldg['id_datos']."'", $miConex) or die(mysql_error());

			$seldg = mysqli_query("delete from datos_generales where id_datos='".$Key."'", $miConex) or die(mysql_error());

			$gh++;
		} ?>
		<script type="text/javascript">document.cookie = "unidades=1;expires=" + d.toGMTString() + ";" + ";";document.location='editaunidad.php';</script><?php
	}
	if(isset($_POST['edit'])){
		$marcado = @$_POST['marcado'];
		if(($marcado) ==""){
			show_message($strerror,$plea8.$btbajas.".","cancel","editaunidad.php"); ?>
			  <br><hr width="70%" align="center">
			<div class="Footer">
				  <div class="Footer-inner">
					 <div class="Footer-text"><p><?php include ("version.php");?></p></div>
			  </div>
			</div><?php 
			exit;
		}	
		?>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table">
				<form id="frm1" name="frm1" method="post" action="">
					<tr>
						<td class="vistauser1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="Estilo4"><strong><?php echo strtoupper($btNombre);?></strong></span></td>
						<td class="vistauser1"><span class="Estilo4"><strong>SECTOR</strong></span></td>
						<td class="vistauser1"><span class="Estilo4"><strong>REUP</strong></span></td>
						<td class="vistauser1"><span class="Estilo4"><strong><?php echo strtoupper($SITIO1);?></strong></span></td>
						<td class="vistauser1"><span class="Estilo4"><b><?php echo strtoupper($provincia);?></b></span></td>
						<td class="vistauser1"><span class="Estilo4"><strong>MAIL</strong></span></td>
						<td class="vistauser1"><span class="Estilo4"><strong>SMTP</strong></span></td>
					</tr><?php
					$p=0;
					foreach($marcado as $key){
						$sql = "select * from datos_generales where id_datos='".$key."'";
						$resultv= mysqli_query($sql,$miConex) or die(mysql_error());
						$vale=mysqli_fetch_array($resultv); ?>
							<tr bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" id="cur_tr_<?php echo $p;?>" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>';colorear('<?php echo $p;?>','#DBE2D0');">								
								<td valign="top" width="197"><input class="boton" name="entidad[]" type="text" size="25" value="<?php echo $vale['entidad'];?>"></td>
								<td valign="top" width="92"><input class="boton" name="sector[]" type="text" size="10" value="<?php echo $vale['sector'];?>"></td>
								<td valign="top" width="89"><input class="boton" name="reup[]" type="text" size="10" value="<?php echo $vale['codigo'];?>"></td>
								<td valign="top" width="203"><input class="boton" name="web[]" type="text" size="35" value="<?php echo $vale['web'];?>"></td>
								<td width="93" valign="middle">
									<select class="boton" name="provincia[]"><?php
										while($valepr=mysqli_fetch_array($qselpr)){ ?>
											<option value="<?php echo $valepr['nombre'];?>" <?php if(($valepr['nombre']) ==$vale['provincia']){ echo "selected";}?>><?php echo $valepr['nombre'];?></option><?php
										} ?>
									</select>
									</td>
								<td width="162"><input class="boton" name="mail[]" type="text" value="<?php echo $vale['mail'];?>"></td>
								<td width="119"><input class="boton" name="smtp[]" type="text" value="<?php echo $vale['smtp'];?>"><input name="ida[]" type="hidden" value="<?php echo $vale['id_datos'];?>"></td>
							</tr>
							<tr>
								<td colspan="8"><hr></td>    
							</tr><?php
							$p++;
					} ?>
					<tr>
						<td colspan="7">
							<input name="editado" type="submit" class="btn" id="editado" value="<?php echo $btaceptar;?>"/>			
						</td>
					</tr>
				</form>
			</table>
 <?php 		
	}
	if(isset($_POST['editado'])){
		$ida = $_POST['ida'];
		$entidadx = $_POST['entidad'];
		$sectorx = $_POST['sector'];
		$reupx = $_POST['reup'];
		$webx = $_POST['web'];
		$smtpx = $_POST['smtp'];
		$mailx = $_POST['mail'];
		$provinc = $_POST['provincia'];
		$k=0;
		foreach($ida as $key){
			$delp = "update datos_generales set provincia = '".htmlentities($provinc[$k])."',mail = '".$mailx[$k]."',entidad = '".htmlentities($entidadx[$k])."', codigo = '".$reupx[$k]."', sector = '".$sectorx[$k]."', web = '".$webx[$k]."', smtp = '".$smtpx[$k]."' where id_datos='".$key."'";
			$qdelm = mysqli_query($delp) or die(mysql_error());
			$k++;
		} ?>
		<script type="text/javascript">document.location='editaunidad.php';</script>;<?php
	}
$qusua = mysqli_query("select * from usuarios where login='".$_SESSION['valid_user']."'") or die(mysql_error());
$rusua = mysqli_fetch_array($qusua);
///////navegador
		$inicio = 0; 
		$pagina = 1; 
		$registros = $cuantos;
		
	if(isset($_GET["registros"])) {
		$registros = $_GET["registros"];
		$inicio = 0; 
		$pagina = 1;
	}
	if(isset($_GET['pagina']))  { 
		$pagina=$_GET['pagina'];
		$inicio = ($pagina - 1) * $registros; 
	}
	if(isset($_GET["mostrar"])) {
		$registros = $_GET["mostrar"];
		if(($registros) ==0){ $registros=1;}
		$inicio = 0; 
		$pagina = 1;
	}
///////////
$resultados = mysqli_query("SELECT * FROM datos_generales") or die(mysql_error());
$total_registros = mysqli_num_rows($resultados);
$total_paginas = ceil($total_registros / $registros);

$sql1 = "select * from datos_generales limit ".$inicio.",".$registros;
$result1= mysqli_query($sql1,$miConex) or die(mysql_error());
?>
			<script type="text/javascript">
				function check1(){
					var formValid = false;
					var f = document.form1;
					if((f.titulo.value) ==""){
						alert("Por favor escriba el Titulo de la Resolucion.");
						f.titulo.focus();
						formValid = false;;
					} else if((f.descripcion.value) ==""){
						alert('Por favor esciba una peueña descripcion sobre la Resolucion');
						f.descripcion.focus();
						formValid = false;;
					} else { formValid =true;}
					return formValid;
				}
			</script>
		<div>
 </div>
<?php if((@$msg) !=""){ echo "<div class='vistauser1'><font size='2' color ='red'>".@$msg."</font></div>"; }
	if(!isset($_POST['edit']) AND !isset($_POST['fusionar'])){ 
		if(($total_registros) > 1){ ?>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table">
				<form id="frm1" name="frm1" method="post" action="">
					<tr>
						<td colspan="2" class="vistauser1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="Estilo4"><strong><?php echo strtoupper($btNombre);?></strong></span></td>
						<td class="vistauser1"><span class="Estilo4"><strong>SECTOR</strong></span></td>
						<td class="vistauser1"><span class="Estilo4"><strong>REUP</strong></span></td>
						<td class="vistauser1"><span class="Estilo4"><strong><?php echo strtoupper($SITIO1);?></strong></span></td>
						<td class="vistauser1"><span class="Estilo4"><b><?php echo strtoupper($provincia);?></b></span></td>
						<td class="vistauser1"><span class="Estilo4"><strong>MAIL</strong></span></td>
						<td class="vistauser1"><span class="Estilo4"><strong>SMTP</strong></span></td>
					    <td class="vistauser1"><span class="Estilo4"><strong><?php echo strtoupper($btfusionar1);?></strong></span></td>
					</tr><?php
					$p=0;
					while($vale=mysqli_fetch_array($result1)){ $i++;?>
							<tr bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" id="cur_tr_<?php echo $p;?>" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>';colorear('<?php echo $p;?>','#DBE2D0');"  onclick="marca1(<?php echo $p;?>,'#ffffff')">
								<td width="20" valign="top"><?php if(($vale['id_datos']) !=1){ ?><input name="marcado[]" type="checkbox" id="marcado[<?php echo $p?>]" onClick="marca1(<?php echo $p;?>,'#ffffff')" value="<?php echo $vale['id_datos'];?>"><?php } ?></td>
								<td width="169"><?php echo $vale['entidad'];?></td>
								<td width="117"><?php echo $vale['sector'];?></td>
								<td width="87"><?php echo $vale['codigo'];?></td>
								<td width="178"><?php echo $vale['web'];?></td>
								<td width="83"><?php echo $vale['provincia'];?></td>
								<td width="134"><?php echo $vale['mail'];?></td>
								<td width="118"><?php echo $vale['smtp'];?></td>
							    <td width="69"><div  align="center"><?php if(($total_registros) >2 OR ($vale['id_datos']) ==1){ ?><img align="absmiddle" src="images/fusionar.png" name="fusionar" width="24" height="17" border="0" id="fusionar" title="<?php echo $btfusionar;?>" onClick="fusion('<?php echo $vale['id_datos'];?>');" onMouseOver="this.style.cursor='pointer';"><?php }else{ ?><img align="absmiddle" src="images/fusionaroff.png" name="fusionar" width="24" height="17" border="0" id="fusionar" title="<?php echo $btfusionar;?>" onMouseOver="this.style.cursor='pointer';"><?php } ?></div></td>
							</tr>	<?php
							$p++;
					} ?>
					<tr>
						<td colspan="9"><hr><?php if(($total_registros) > 2){ ?><img src="images/check_all.png" name="marcart" width="17" height="17" border="0" usemap="#marcart" id="marcart" title="Seleccionar Todos" onClick='marcar_todo();' onMouseOver="this.style.cursor='pointer';">&nbsp;<img src="images/uncheck_all.png" name="desmarcart" width="17" height="17" id="desmarcart" title="Desmarcar Todos" onClick='desmarcar_todo();' onMouseOver="this.style.cursor='pointer';"><?php } ?></td>    
					</tr>
					<tr>
						<td colspan="9">
							<input name="edit" type="submit" class="btn" id="edit" value="<?php echo $bteditar;?>" onClick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');" />&nbsp;&nbsp;
							<input name="create" id="create-user" type="button" class="btn" onclick="checkLength('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>
							<input type="hidden" name="crash">
						</td>
					</tr>
				</form>
			</table> <?php 
		} else{ echo '<br><div align="center"><div class="message" align="center">'.$noregitro3.$btdatosentidad2.' '.$enlinea2.'</div></div>';}
	}	?>
<br>
<div id="footer" class="degradado" align="center">
	<div class="container">
		<p class="credit"><?php include ("version.php");?></p>
	</div>
</div>
</fieldset>
<iframe width="174" height="189" name="gToday:normal:js/agenda.js" id="gToday:normal:js/agenda.js" src="js/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-501px; top:0px;"></iframe>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
