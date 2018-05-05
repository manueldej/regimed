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
include('barra.php');
$i="es";
if(isset($_COOKIE['seulang'])){
	if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
}
if(($i) =="es"){include('esp.php');}else{include('eng.php');} 
include('mensaje.php');
include('script.php');
?>
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
<link href="css/template.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script><?php
	include('jquery.php'); ?>
<script type="text/javascript">
	function hacer(valo){
		document.location="plan_mtto.php?marcado[]="+valo+"&edit=edit";

	}
	function mues_ano(va){
		if((va) !="-1"){
			document.getElementById('divc').style.display="";
			document.getElementById('bus_fecha').style.display="";
			document.getElementById('ano').style.display="";
		}else{ window.parent.location="plan_mtto.php"; }
	}
</script>
<div id="buscad"><?php
$msg="";
$meses = array($enero =>1,$febrero=>2,$marzo=>3,$abril=>4,$mayo=>5,$junio=>6,$julio=>7,$agosto=>8,$septiembre=>9,$octubre=>10,$noviembre=>11,$diciembre=>12);
$Aini=array("2000");
$Afin=array("2030");
$msg="";
$num_resultadosb =0;
$mes="";
$con="";
if(isset($_GET["msg"])){ $msg = base64_decode($_GET["msg"]);}
if(isset($_GET['con']) !=""){ $con = $_GET['con'];}
if(isset($_GET["msg"])){ print'<meta http-equiv="refresh" content="4;URL=plan_mtto.php"><span align="center" class="vistauser1"><em><strong><font size="2" color="red">'.$msg.'</font></strong></em></span>';}

require_once('connections/miConex.php');

	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$sql_uactiva = "select * from datos_generales where id_datos='".$_COOKIE['unidades']."'";
	}else{
		$sql_uactiva = "select * from datos_generales";
	}
	$result_uactiva= mysqli_query($sql_uactiva, $miConex) or die(mysql_error());
	$ractiva = mysqli_fetch_array($result_uactiva);
$validus = "";
if(isset($_SESSION["autentificado"])){
	$validus = " AND idunidades='".$_SESSION["autentificado"]."'";
}elseif (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$validus = " AND idunidades='".$_COOKIE['unidades']."'";
}else{
	$validus = "";
}
$us1 = mysqli_query("select * from usuarios where login='".$_SESSION ["valid_user"]."'".$validus,$miConex) or die(mysql_error());
$rus1 = mysqli_fetch_array($us1);
include('salva_rep.php');
        $sqluser = "SELECT tipo FROM usuarios where login='".$_SESSION['valid_user']."'";
		$resultuser = mysqli_query ($sqluser) or die (mysql_error());
		$resultuser = mysqli_fetch_array($resultuser); ?>
<fieldset class="fieldset"><legend class="vistauserx"><?php echo $btpmtto1;?></legend>
	<div id="openModal" class="modalDialog">
		<div>
			<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
			<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
		</div>
	</div><?php
	if(isset($_POST['crash']) AND ($_POST['crash']) !=""){
		$marcado=@$_POST['marcado'];
		if(($marcado) ==""){ 
			show_message1($strerror,$plea8.$btpmtto2.".","cancel","plan_mtto.php"); ?>
			<br><hr width="70%" align="center">
			<div id="footer" class="degradado" align="center">
				<div class="container">
					<p class="credit"><?php include ("version.php");?></p>
				</div>
			</div><?php
			exit;
		}
		foreach($marcado as$F){
			$sqld="delete from mtto where id = '".$F."'"; 
			$resultd=mysqli_query($sqld) or die(mysql_error());
		}?>
		<script type="text/javascript">document.location="plan_mtto.php";</script><?php
	} 

	if(isset($_POST['edit']) OR isset($_GET['edit'])){
		if(isset($_POST["marcado"])){ $marcado = $_POST["marcado"];}
		if(isset($_GET["marcado"])){ $marcado = $_GET["marcado"];}
		if((@$marcado) ==""){
			show_message1($strerror,$plea8.$btpmtto2.".","cancel","plan_mtto.php");?>
			<br><hr width="70%" align="center">
			<div class="Footer">
				<div class="Footer-inner">
					<div class="Footer-text"><p><?php include ("version.php");?></p></div>
				</div>
			</div><?php
			exit;
		} ?>
		<div align="center">
			<form name="mod" method="post" action="">
				<table border='1'>
					<tr>
						<td align="center" class="vistauser1"><b>INV</b></td>
						<td align="center" class="vistauser1"><b><?php echo strtoupper($Fecha);?></b></td>
						<td align="center" class="vistauser1"><b><?php echo $btestado;?></b></td>
					</tr><?php				  
					foreach($marcado as$F1){
						$sqld="select * from mtto where id='".$F1."'"; 
						$resultd=mysqli_query($sqld) or die(mysql_error());	
						$rows = mysqli_fetch_array($resultd);?>
						<tr>
							<td align="center"><?php echo $rows["inv"];?><input type="hidden" name="inv[]" value="<?php echo $rows["inv"];?>"><input type="hidden" name="id[]" value="<?php echo $rows["id"];?>"></td>
							<td align="center"><input name="fecha[]" type="text" class="boton" value="<?php echo $rows["fecha"];?>"></td>
							<td align="center">
								<select name="estado[]" class="boton">
									<option value="Realizado"><?php echo $btRealizado;?></option>
									<option value="Pendiente"><?php echo $btPendiente;?></option>
							  </select>
							</td>
						</tr><?php 
					}	?>
				</table>
				<table border='0' bordercolor="#AFCBCF" >
					<tr>
						<td>
							<input type="submit" name="modificado" value="<?php echo $btaceptar;?>" class="btn">&nbsp;&nbsp;
							<input type="button" name="retur" value="<?php echo $btcancelar;?>" class="btn" onclick="javascript:window.parent.location='plan_mtto.php';">
						</td>
					</tr>
				</table>
			</form>
		</div>
		<br>
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
	if(isset($_POST['modificado'])){
		$id    = $_POST['id'];
		$iin   = $_POST['inv'];
		$fecha = $_POST['fecha'];
		$estado = $_POST['estado'];
		$r=0;

		foreach($id as $key){
			$up = "update mtto set fecha ='".$fecha[$r]."', inv='".$iin[$r]."', estado='".$estado[$r]."'  where id ='".$key."'";
			$que = mysqli_query($up) or die(mysql_error());	
			$r++;
		} ?>
		<script type="text/javascript">
			//window.parent.location="plan_mtto.php";
		</script> <?php
	}
$quer = "";
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	if(isset($_GET['bus'])){ 
		$quer = "WHERE (inv LIKE '%".$_GET['bus']."%') OR (descrip LIKE '%".$_GET['bus']."%') AND (idunidades='".$_COOKIE['unidades']."')";
	}else{
		$quer = "WHERE (idunidades='".$_COOKIE['unidades']."')";
	}
}elseif (isset($_COOKIE['uninds']) AND ($_COOKIE['uninds']) !=""){
	$quer = "WHERE (idunidades='".$_COOKIE['uninds']."')";
}else{
	if(isset($_GET['bus'])){ 
		$quer = "WHERE (inv LIKE '%".$_GET['bus']."%') OR (descrip LIKE '%".$_GET['bus']."%')";
	}
}

$query_Recordset1 = "SELECT * FROM aft ".$quer." order by inv";
$Recordset1 = mysqli_query($query_Recordset1, $miConex) or die(mysql_error());
$totalRows_Recordset1=mysqli_num_rows($Recordset1);
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$query_RecUni = "SELECT * FROM datos_generales where id_datos='".$_COOKIE['unidades']."'order by entidad";
}else{
	$query_RecUni = "SELECT * FROM datos_generales order by entidad";
}
$RecUni = mysqli_query($query_RecUni, $miConex) or die(mysql_error());
$nuRecUni = mysqli_num_rows($RecUni);
if (isset($_SESSION["valid_user"]))  {
		if(($rus1["tipo"]) =="root" and $totalRows_Recordset1>0){  ?>
		<form name="ff" action="" method="get">
			<input type="hidden" name="bus">
		</form>
		<script type="text/javascript">
			function submit_page() {
				// form validation check
				var formValid=false;
				var f = document.form1;
				if ( f.dc2.value == '' ) {
					return alerta('<?php echo $plea;?>','<?php echo $Fecha." ".$_POST['dc2'];?>');
					f.dc2.focus();
					formValid=false;
				}else if ( confirm('<?php echo $seguro1;?>')) 
				  {	formValid=true;  }

				return formValid;
			}
			function AbrirBuscador(val){
				document.ff.bus.value=val;
				document.ff.submit();
			}
			function cambiaU(un){
				document.cookie="uninds="+un;
				window.parent.location="plan_mtto.php";
			}
		</script>
			<?php if(($con) =="m"){ ?><div align="right"></div><?php }  ?>			
				<table width="350" border="0" align="center">
					  <form action="" target="" method="post" name="form1" id="form1" onsubmit="return submit_page();">
					  <tr>
						<td><h3 align="center" class="vistauser1 Estilo3"><?php echo $btPLANIFICADOR;?></h3></td>
					  </tr>
					  <tr>
						<td><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $btInventario." -> ".$DESCRIPCION1;?>.</strong></td>
					  </tr>	  	  
					  <tr>
						<td align="center" class="mosimage_caption"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="3">
						  <tr>
							<td colspan="2" align="center"><input name="Boton1" id="Boton1" type="text" class="boton" />
							  <input name="Submit2" type="button" class="btn" onClick="AbrirBuscador(document.getElementById('Boton1').value);" value="<?php echo $filtr;?>"/></td>
						  </tr>
						  <tr>
							<td colspan="2" align="center"><hr></td>
						  </tr><?php
							if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){ ?>
							  <input name="unidades" type="hidden" id="unidades" value="<?php echo $_COOKIE['unidades'];?>"/><?php
							}else{ ?>
								<tr>
									<td width="40%" align="right"><?php if(($nuRecUni) >1){ echo $btdatosentidad2;}else{ echo $btdatosentidad3;}?>:</td>
									<td width="60%">
										<select name="unidades" class="combo_box" id="unidades" onChange="cambiaU(this.value);"><?php
											while ($row_Uni = mysqli_fetch_array($RecUni)){ ?>
												<option value="<?php echo $row_Uni['id_datos'];?>" <?php if(($row_Uni['id_datos']) ==@$_COOKIE['uninds']){ echo "selected";} ?>><?php echo $row_Uni['entidad'];?></option><?php
											} ?>
										</select>
									</td>
							  </tr><?php 
							} ?>
						  <tr>
							<td align="right"><?php echo $btregmedio1;?>s:</td>
							<td>
								<select name="invent" class="combo_box" id="invent"><?php
									while ($row_Recordset1 = mysqli_fetch_array($Recordset1)){ ?>
										<option value="<?php echo $row_Recordset1['inv'];?>"><?php echo $row_Recordset1['inv']."->".$row_Recordset1['descrip'];?></option><?php
									} ?>
								</select>
							</td>
						  </tr>
						</table></td>
					  </tr>
					  <tr>
						<td><div align="center"><strong><?php echo $btPLANIFICADOR1;?></strong></div></td>
					  </tr>
					  <tr>
						<td class="mosimage_caption">
						  <div align="center">
							<input name="dc2" class="imput" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.dc2);return false;" id="dc2" readonly value="" size="23" maxlength="10" />
							<a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.dc2);return false;" hidefocus><img name="popcal" align="absmiddle" src="images/almana.png" width="30" height="30" border="0" title="" /></a></div>		  </td>
						</tr>
					  <tr>
						<td align="center"><input name="insertx" type="submit" class="btn" value="<?php echo $btaceptar;?>" />
						<label></label>	  </td>
					  </form>
				</table>
				<iframe width=174 height=189 name="gToday:normal:js/agenda.js" id="gToday:normal:js/agenda.js" src="js/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-501px; top:0px;"></iframe><?php 
		}
	} 
		require_once("db_fns.php");  		
		if (isset($_POST['insertx']))	  {
			$fec = substr(strrchr($_POST['dc2'], "/"), 1);
			$fecac = date("Y");
			if(($fec) < $fecac){  ?>	
				<script type="text/javascript">alert('Fecha incorrecta'); document.getElementById('dc2').focus();</script><?php
			}else{ 
				$ret = "select * from mtto where fecha = '".$_POST['dc2']."' AND inv = '".$_POST['invent']."' AND idunidades='".$_POST['unidades']."'";
				$qret = mysqli_query($ret,$miConex) or die(mysql_error());
				$seaft = mysqli_query("select * from aft where inv = '".$_POST['invent']."'",$miConex) or die(mysql_error());
				$quer=mysqli_fetch_array($seaft);
				$nret = mysqli_num_rows($qret);
				if(($nret) ==0){
					$sql="insert into mtto (id, inv, fecha, estado,idunidades) values (NULL, '".$_POST['invent']."','".$_POST['dc2']."','Pendiente','".$_POST['unidades']."')"; 			
					$result1=mysqli_query($sql) or die(mysql_error());
					creasalva1('mtto');
				}else{ echo "<font color='red' size='2'>Ye el Inventrio: <b>".$_POST['invent']."</b> est&aacute; planificado para el d&iacute;a <b>".$_POST['dc2']."<b></font>"; }
			}
		} 	
$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$cuantos = 5;
if(($rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}
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
//////////
		$fe_bu = "";
		if(isset($_POST['bus_fecha'])){
			if(($_POST['mes']) !="-1"){
				if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
					$fe_bu = "where (fecha like '%".$_POST['mes']."/".$_POST['ano']."%') AND (idunidades='".$_COOKIE['unidades']."')";
				}else{
					$fe_bu = "where fecha like '%".$_POST['mes']."/".$_POST['ano']."%'";
				}
			}else{
				if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
					$fe_bu = "where (idunidades='".$_COOKIE['unidades']."')";
				}else{ 
					$fe_bu = ""; 
				}				
			}			
		}else{
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$fe_bu = "where (idunidades='".$_COOKIE['unidades']."')";
			}else{
				$fe_bu = "";
			}
		}

		$sql="SELECT * FROM mtto ".$fe_bu." order by id ASC"; 
		$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);
		$result= mysqli_query($query_limit,$miConex) or die(mysql_error());
		$num_resultados = mysqli_num_rows($result);
		$ggg = base64_encode($query_limit);	
		
		$sqlzb="SELECT * FROM mtto ".$fe_bu." order by id ASC"; 
		$resultb=mysqli_query($sqlzb,$miConex) or die(mysql_error());
		$num_resultadosb = mysqli_num_rows($resultb);
	
//NAVEGADOR inicio
	if(isset($_GET['total_registros'])){
		$total_registros=$_GET['total_registros'];
	} else {
		$all_rsDA = mysqli_query($sql,$miConex);
		$total_registros = mysqli_num_rows($all_rsDA);
	}
	$total_paginas = ceil($total_registros / $registros);
//NAVEGADOR	FIN
$semean = mysqli_query("select id from aft",$miConex) or die(mysql_error());
$nsemean = mysqli_num_rows($semean);
	if(($nsemean) ==0){ ?>
		<br><div align="center"><div class="message" align="center"><?php echo $noregitro3." ".$btversion1.$bttotraspaso1;?>.</div></div><?php
	}else{ ?>
			<br>
		<table width="951" border="0" align="center"><?php 
			if((@$num_resultados)!=0){ ?> 
				<tr align="center">
					<td align="center"><div align="center"></div></td>
					<td width="342" rowspan="3"></td>
					<td width="68" rowspan="3" align="right">
						<div id="imprime">
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr><?php 
							if(($_SESSION['valid_user']) !="invitado" AND ($total_registros) !=0){ ?>
							  <td class="email"><a class="tooltip" href="pdf/mail.php?query=<?php echo $ggg;?>&tb=mtto1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($s_email);?></span></a></td><?php
							} ?>
							  <td class="pdf"><a class="tooltip" href="pdf/tuto1.php?query=<?php echo $ggg;?>&tb=mtto">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($cr_pdf);?></span></a></td>
							  <td class="exel"><a class="tooltip" href="w.php?query=<?php echo $ggg;?>&tb=mtto">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($cr_exel);?></span></a></td>
							  <td class="printer"><a class="tooltip" href="imprimir/index.php?inicio=<?php echo $inicio;?>&registros=<?php echo $registros;?>&tb=mtto" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($sav_print);?></span></a></td>
							</tr>
						  </table>	
						</div>					
					</td>
				</tr>
				<tr align="center"> 
					<td width="470"><h1 class="vistauser1"><?php echo $btCRONOGRAMA;?></h1></td>
				</tr>
				<tr>
					<td align="center">
						<table width="343" border="0" align="center">
							<tr>
								<td width="337">
									<form action="" method="post" name="buscav" id="busca">
										<label><?php echo $btmes;?>:</label>
										  <select name="mes" size="1" id="mes" class='combo_box'>
										  <option onclick="mues_ano(this.value);" value="-1"><?php echo $btmostrartodo;?></option><?php
											$a=0;
											$ac=0;
											foreach($meses as $ms => $numeoq){ ?>
												<option onclick="mues_ano(this.value);" value="<?php if((@$ac) < 9){ $mm ="0".($ac+1); echo @$mm;}else{ $mm = $ac+1; echo $mm;}?>" <?php if(($mm) ==@$_POST['mes']){ echo "selected";}?>><?php echo $ms;?></option>
												<?php
												$ac++;
											} ?>
										  </select>
											&nbsp;&nbsp;<label id="divc"><?php echo $btano;?>:</label>
											  <select name="ano" size="1" id="ano" class='combo_box'><?php
												$kk=date('Y');
												for($it=$Aini[0];$it<=$Afin[0];$it++){ ?>
														<option value='<?php echo $it;?>' <?php if(($it) ==@$_POST['ano']){ echo "selected";}elseif(($it) ==$kk){ echo "selected"; }?>><?php echo $it;?></option>
													  <?php 
												} ?>
										  </select>                  
											  &nbsp;&nbsp;<input name="bus_fecha" type="submit" id="bus_fecha" class="btn" value='<?php echo $btver;?>' />
									</form>							</td>
							</tr>
						</table>				</td>
				</tr><?php 
			}  ?>
						<form name="form5" method="get" action="">
							<table width="73%" border="0" align="center" cellpadding="0" cellspacing="0"><?php
	if((@$num_resultados)!=0){ ?>
							  <tr>
								<td>	
									<span><?php echo $cantidadmost;?>:</span>
									<input name="pagina" type="hidden"  value="<?php echo $pagina;?>">
									<input name="mostrar" type="text" size="1" value="<?php if(isset($_GET["mostrar"])){ echo $_GET["mostrar"];}elseif(isset($_GET["registros"])){ echo $_GET["registros"];}elseif(!isset($_GET["registros"]) AND !isset($_GET['mostrar'])){ echo $rsel['visitas'];}elseif(($rsel['visitas']) ==""){ echo "5";}?>" onKeyPress="return acceptNum(event);" class="mostrar">
									<input name="mo"  type="submit" value="<?php echo $btver;?>" class="btn4">
									<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
									<input name="palabra" type="hidden"  value="<?php echo $palabra;?>">
									<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">								
									<input type="hidden" name="orderby" value="<?php echo $orderby;?>">
									<input type="hidden" name="asc" value="<?php echo $asc;?>">
									<input type="hidden" name="m" value="m">							</td>		
							  </tr><?php
	} ?>
							</table>
						</form>
			<form id="frm1" name="frm1" method="post" action="">
				<tr align="center">
					  <td> </td>
				</tr>
				<tr> 
					<td height="116" colspan="3">
						<div align="center"><?php 
							$k=0;
							if ($num_resultadosb !=0){	?>
								<table width="80%" border="0" cellspacing="0" cellpadding="0" class="table">
									<tr>
										<td>
											<table width="100%" border='0' cellpadding="0" cellspacing="0" >
												<tr><?php 
													if($rus1["tipo"] =="root") { ?>
														<td align="center" class="vistauser1">&nbsp;</td><?php 
													}?>
													<td align="center" class="vistauser1"><b><span class="Estilo4">Inv</span></b></td>
													<td align="center" class="vistauser1"><b><span class="Estilo4"><?php echo $btcategmedios1;?></span></b></td>
													<td align="center" class="vistauser1"><b><span class="Estilo4"><?php echo $Fecha;?></span></b></td>
													<td align="center" class="vistauser1"><b><span class="Estilo4"><?php echo $btAreas;?></span></b></td>
													<td align="center" class="vistauser1"><b><span class="Estilo4"><?php echo ucwords(strtolower($btestado));?></span></b></td>
													<td align="center" class="vistauser1"><b><span class="Estilo4"><?php echo $btdatosentidad3;?></span></b></td>
												</tr><?php
												$i=0;
												$p=0;
												WHILE ($row=mysqli_fetch_array($result)){$i++;
													if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
														$sqlzc=mysqli_query("SELECT categ,idarea,idunidades FROM aft where (inv ='".$row["inv"]."') AND idunidades='".$_COOKIE['unidades']."'",$miConex) or die(mysql_error()); 
													}else{
														$sqlzc=mysqli_query("SELECT categ,idarea,idunidades FROM aft where (inv ='".$row["inv"]."')",$miConex) or die(mysql_error()); 
													}
													$sqlzcx = mysqli_fetch_array($sqlzc);					
													$sqlDG=mysqli_query("SELECT * FROM datos_generales where (id_datos ='".$sqlzcx["idunidades"]."')",$miConex) or die(mysql_error()); 
													$sqlxDG = mysqli_fetch_array($sqlDG);  ?>
													<tr bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" id="cur_tr_<?php echo $p;?>" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>';colorear('<?php echo $p;?>','#DBE2D0');" onclick="marca1('<?php echo $p;?>','#ffffff')"><?php 
														if($rus1["tipo"] =="root") { ?>
															<td><input name="marcado[]" type="checkbox" class="boton" id="marcado[<?php echo $p;?>]" onclick="marca1('<?php echo $p;?>','#ffffff')" value="<?php echo $row["id"]?>" /></td><?php 
														}?>
														<td><a target="_parent" href='registromedios1.php?palabra=<?php echo $row["inv"];?>&rp=mt'><?php echo $row["inv"];?></a></td>
														<td><?php echo $sqlzcx["categ"];?></td>
														<td><?php echo $row["fecha"];?></td>
														<td><?php echo $sqlzcx["idarea"];?></td>
														<td><?php if(($row["estado"]) =="Pendiente"){ echo "<font color='blue'><b>".$row["estado"]."</b></font>"; }else{ echo $row["estado"];}?></td>
														<td><?php echo $sqlxDG["entidad"];?></td>
													</tr><?php 	$p++;												
												} ?>                                  
										  </table>
										</td>
									</tr>
									<tr>
										<td><?php if (($rus1['tipo']) =="root") { ?>
										<img src="images/check_all.png" name="marcart" id="marcart" width="17" height="17" border="0" usemap="#marcart" title="<?php echo $sel_all;?>" onClick='marcar_todo();' onMouseOver="this.style.cursor='pointer';">&nbsp;<img src="images/uncheck_all.png" name="desmarcart" width="17" height="17" id="desmarcart" title="<?php echo $des_all;?>" onClick='desmarcar_todo();' onMouseOver="this.style.cursor='pointer';"><?php } ?></td>
									</tr>
								</table><?php
								include('navegador.php');
								
								if($rus1["tipo"] =="root") { ?>
									<br>
									<input name="edit" type="submit" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');" class="btn" id="edit" value="<?php echo $bteditar;?>"/>&nbsp;&nbsp; 
									<input name="create" id="create-user" type="button" class="btn" onclick="checkLength('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>
									<input type="hidden" name="crash"><?php
								}	$k++;
								if(($rus1["tipo"]) =="root"){ ?>
									&nbsp;&nbsp;<input name="sal" id="sal" type="button" class="btn" value="<?php echo $btrestaurar;?>" onclick="javascript:window.parent.location='sal_rep.php?tb=mtto&legen=PlandeMtto.';"><?php	
								} 			
							} else {
								for ($a=1; $a<=count($meses); $a++){
									foreach ($meses as $key => $numeo) {
										$mx = str_replace("0","",@$_POST['mes']);
									   if (($mx) ==$numeo){
										 $num = $key;
										 break;
									   }	 
									}
								}?>
								<table align="center" width="70%" border="0" cellspacing="2" cellpadding="2">
									<tr> 
										<td align="center"><br><div align="center"><div class="message" align="center">
											<?php echo $noregitro3;?> <b><?php echo $btpmtto2."s".$btmantenimientos;?></b><?php if(isset($_POST['bus_fecha'])){ echo $btEN.$Fecha.": <b><font color='red'>".@$num."/".$_POST['ano']."</font></b>"; } ?>.</div></div><?php 
											if(($rus1["tipo"]) =="root"){ ?>
												<br><br>
												<input name="sal" id="sal" type="button" class="btn" value="<?php echo $btrestaurar;?>" onclick="javascript:window.parent.location='sal_mtto.php?tb=mtto&legen=Plan de Mtto.';"><?php	
											} ?>									</td>
									</tr>
								</table><?php
							} ?>
						</div>				</td>
				</tr>
			</form>
		</table><?php
	} ?>
<br>
<div id="footer" class="degradado" align="center">
	<div class="container">
		<p class="credit"><?php include ("version.php");?></p>
	</div>
</div>
</fieldset>
<div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript">
	function veo1(){
		window.parent.location="plan_mtto.php";
	}
	function veo(){
		document.getElementById('divc').style.display="none";
		document.getElementById('bus_fecha').style.display="none";
		document.getElementById('ano').style.display="none";
	}
	veo();
</script>
