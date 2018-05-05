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
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
<?php 
 $i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}

	if ($i=="es") {
	  include('esp.php');
	}else{
	  include('eng.php');
	}
include('header.php'); 
require("mensaje.php");
include("script.php");
include('barra.php');
?>
<div id="buscad">
<script type="text/javascript" src="js/jquery1.min.js"></script>
<script type="text/javascript" src="js/scrolltopcontrol.js">

/***********************************************
* Scroll To Top Control script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Please keep this notice intact
* Visit Project Page at http://www.dynamicdrive.com for full source code
***********************************************/

</script> 
<?php
   
$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());	
$rsel = mysqli_fetch_array($qsel);
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !="") { 
	$sql_uactiva = "select * from datos_generales WHERE id_datos='".$_COOKIE['unidades']."'";
} else {
	$sql_uactiva = "select * from datos_generales";
}
$result_uactiva= mysqli_query($miConex, $sql_uactiva) or die(mysql_error());	
$ractiva = mysqli_fetch_array($result_uactiva);

$cuantos = 5;
if(($rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}
		$palab="";
		$inicio = 0; 
		$pagina = 1; 
		$registros = $cuantos;
		$TG = 0;
		$porunidad =1;
		$paracontar4 = 0;
		$paracontar = 0;
		
	if(isset($_REQUEST["registros"])) {
		$registros = $_REQUEST["registros"];
		$inicio = 0; 
		$pagina = 1;
	}
	if(isset($_REQUEST['pagina']))  { 
		$pagina=$_REQUEST['pagina'];
		$inicio = ($pagina - 1) * $registros; 
	}
	if(isset($_REQUEST["expediente"]) OR isset($_REQUEST['busca'])){
		if(isset($_REQUEST["marcado"])){$marcado = $_REQUEST["marcado"] ;}
		if(isset($_REQUEST["marcado1"])){
			$marcado = $_REQUEST["marcado1"];
			$marcado = explode("*",substr($marcado,0,-1)); 
		}

		if(empty($marcado) AND !isset($_REQUEST['busca'])){	echo "<br><br>";
			show_message($strerror,$plea1." ".$v_ficha,"cancel","expedientes.php"); ?>
			 <br><br>
				    <?php include ("version.php");
			exit;
		}
		if(($marcado) ==""){
			$seas = mysqli_query($miConex, "SELECT * FROM areas") or die(mysql_error());
			$num = mysqli_num_rows($seas);
			$marcado = array();
			while($en = mysqli_fetch_array($seas)){
				$marcado[] = $en['idarea'];
			}
		} ?>
	
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
		<fieldset class="fieldset"><legend class="vistauserx"><?php if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !="") {  echo $btdatosentidad1;?>: <font color="red"><?php echo $ractiva['entidad']."</font>"; }else{ echo $otrosdet2;}?></legend>
		<script type="text/javascript">
			function marca2(r1)  {
				if ((document.getElementById("n"+r1).value ==""))	 { 
					document.getElementById("cur_tr_"+r1).style.backgroundColor='#D5DBDD';
					document.getElementById("n"+r1).value='1';
				}else{
					document.getElementById("cur_tr_"+r1).style.backgroundColor='#ffffff';
					document.getElementById("n"+r1).value='';
				}
				
			}
			function ir(inv,idun,ini,donde){
				document.location="et.php?inv="+inv+"&idunidades="+idun+"&palabra="+ini+"&dde="+donde;
			}
		</script>
			
		<?php
		for($m=0; $m<count($marcado); $m++){
				@$marca .= $marcado[$m]."*";
				$sea = mysqli_query($miConex, "SELECT * FROM areas where idarea='".$marcado[$m]."'") or die(mysql_error());
				$retdo = mysqli_fetch_array($sea);
				
				if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
					$resultados = mysqli_query($miConex, "SELECT inv FROM aft where idarea='".$retdo['nombre']."' and idunidades='".$_COOKIE['unidades']."'");
					$sql = "select * from aft where idarea='".$retdo['nombre']."' and idunidades='".$_COOKIE['unidades']."'";
					$result= mysqli_query($miConex, $sql) or die(mysql_error());	
				}else {
					$resultados = mysqli_query($miConex, "SELECT inv FROM aft where idarea='".$retdo['nombre']."' and idunidades='".$retdo['idunidades']."' order by inv");
				    $sql = "select * from aft where idarea='".$retdo['nombre']."' and idunidades='".$retdo['idunidades']."' order by inv";
					$result= mysqli_query($miConex, $sql) or die(mysql_error());	
				}
				
				$u_activa=$retdo['nombre'];
				$total_registros = mysqli_num_rows($resultados);	
				$ggg=base64_encode($sql);
				
			if(($total_registros) !=0){ ?>
				<table width="980" border="0" align="center" id="CABECERA">
				  <tr>
					<td>
						<div align="center">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr><td><font size="3"><b><?php echo $btAREASRES;?>: <font color="red"><?php echo $retdo['nombre'];?></font></b></font></td><?php 
								if(($_SESSION['valid_user']) !="invitado" AND ($total_registros) !=0){ ?>
								  <td class="email"><a class="tooltip" href="pdf/mail.php?query=<?php echo $ggg;?>&tb=aft">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($s_email);?></span></a></td><?php
								} ?>
								  <td class="pdf"><a class="tooltip" href="pdf/tuto1.php?query=<?php echo $ggg;?>&tb=aft">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($cr_pdf);?></span></a></td>
								  <td class="exel"><a class="tooltip" href="expregmedios.php?query=<?php echo $ggg;?>&tb=aft">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($cr_exel);?></span></a></td>
								  <td class="printer"><a class="tooltip" href="imprimir/index.php?query=<?php echo $ggg;?>&tb=aft" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($sav_print);?></span></a></td>
								</tr>
							</table>								
						</div>
					</td>
				  </tr>
				  <tr><td></td></tr>
				</table>
				<table width="100%" border="0" class="table" align="center" cellpadding="0" cellspacing="0">
					<tr class="vistauser1">
						<td><b></b></td>
						<td align="center" ><b>INV</b></td>
						<td align="center"><b><?php echo $DESCRIPCION;?></b></td>
						<td align="center"><b><?php echo strtoupper($btestado);?></b></td>
						<td align="center"><b><?php echo $btSELLO?></b></td>
						<td align="center"><b><?php echo $btMARCA;?></b></td>
						<td align="center"><b><?php echo $btcategmedios2;?></b></td>
						<td align="center"><b><?php echo strtoupper($bttipo);?></b></td>
						<td align="center"><b><?php echo $CUSTODIO;?></b></td>
					</tr><?php  	
					$id = 0;  
					$p=0;					
					while($row=mysqli_fetch_array($result)){
						@$i++;?>
						<tr bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" id="cur_tr_<?php echo $id+1;?>" bgcolor="#ffffff" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>';colorear('<?php echo $p;?>','#DBE2D0');"  onclick="marca2(<?php echo $id+1;?>)">
							<td><input type="hidden" name="n<?php echo $id+1;?>" id="n<?php echo $id+1;?>"><?php 
								if((strtoupper($row["categ"])) =="COMPUTADORA" OR (strtoupper($row["categ"])) =="COMPUTADORAS" OR (strtoupper($row["categ"])) =="PC"){ ?>
									  &nbsp;&nbsp;&nbsp;<a href="javascript:ir('<?php echo $row["inv"];?>','<?php echo $row["idunidades"];?>','<?php echo $palab;?>','rm');" class="tooltip"><img src="images/pc.png" width="24" height="24" align="absmiddle"><span onmouseover="this.style.cursor='pointer';"><?php echo $verdetalles1.$row["inv"];?></span></a><?php 
									} ?>			
							</td>			
							<td class="Estilo2"><?php echo $row["inv"];?></td>
							<td class="Estilo2"><?php echo $row["descrip"];?></td>
							<td class="Estilo2"><?php echo $row["estado"];?></td>
							<td class="Estilo2"><?php echo $row["sello"];?></td>
							<td class="Estilo2"><?php echo $row["marca"];?></td>
							<td class="Estilo2"><?php echo $row["categ"];?></td>
							<td class="Estilo2"><?php echo $row["tipo"];?></td>
							<td class="Estilo2"><?php echo $row["custodio"];?></td>
						</tr><?php
						$id++;	$p++;
					} ?>
				</table>	
				<table width="100%" border="0" align='center'>
					<tr>
						<td class="navegador" align="center"><?php echo $bttotalreg.": <font color='red'><b>".$total_registros."</b></font>"; ?></td>
					</tr>
				</table><?php 
				
			} else{ ?> 
			  <table width="75%" border="0" align='center'>
					<tr>
						<td align="center"><div class="message"><?php echo $btnoregistro.$btAreas4."<font color='red'><strong>".@$u_activa."</strong></font></span>"; ?></div></td>
					</tr>
				</table>
			<?php  }			
		}	?>
	<input name="Retornar" value="Retornar" onclick="document.location='expedientes.php';" type="button" class="btn btn-default">	
</fieldset><br>
<?php include ("version.php");
	} 
	if(@$_REQUEST["calcular"]){
		$src2="gfx/icons/small/folder.png";
	    $src1="gfx/icons/small/folder-open.png";
		?>
	
	<script type="text/javascript">
	  var imagenc='<?php echo $src1; ?>';
	    function cambiaimagen(que,id){
		  if (que=="abre"){
		   document.getElementById(id).src=imagenc;
		  }else{
			document.getElementById(id).src='<?php echo $src2; ?>';
		  }
	    }
	  </script>	
	<?php	
	    if(isset($_COOKIE["unidades"])){$unidades = $_COOKIE["unidades"] ;}
		if(isset($_REQUEST["marcado"])){$marcado = $_REQUEST["marcado"] ;}
		$marca = $marcado;
		if(empty($marcado)){ echo "<br><br>";
			show_message($strerror,$plea1." ".$Calcular,"cancel","expedientes.php"); ?>
			 <br>
			      <div id="footer" class="degradado" align="center">
				      <div class="container">
					      <p class="credit"><?php include ("version.php");?></p>
				      </div>
			      </div><?php
			exit;
		}?>
		<fieldset class="fieldset"><legend class="vistauserx"><?php echo $bttmecateg;?></legend>
		<?php
 
		function recalcula($unidad,$marcado,$campo) {
		  include('connections/miConex.php');
		    for ($i=0; $i<count($marcado); $i++){
			   $sql12 = "SELECT COUNT(id) as total FROM aft WHERE id_area='".$marcado."' AND estado='A' AND idunidades='".$unidad."' AND categ='".$campo."' AND idarea!='Reparaciones'";
			   $resul12 = mysqli_query ($miConex, $sql12) or die (mysql_error());
			   $row1 = mysqli_fetch_array ($resul12);		  
		
			   if ($campo!="idarea" AND $campo!="nombre" AND $campo!="idunidades") {
				$sql11 = "UPDATE areas SET ".$campo."='".$row1['total']."' WHERE idarea='".$marcado."' AND idunidades='".$unidad."'";
				$resul11 = mysqli_query ($miConex, $sql11) or die (mysql_error());
			   }
			   
		    }
		} 

		if(isset($_COOKIE["unidades"])){
		 $porunidad =$unidades;  
		}else{
		 $porunidad =1;
		}
		$nom_campo = array();
		$totales = array();
		$areas= array();
		$toa = array();				
		$suma = 0;
		$ttgr = 0;
		for($x=0; $x<count($marcado); $x++){
			$i = 0;
			$seleaft = mysqli_query($miConex, "select idunidades from areas where idarea ='".$marcado[$x]."' ") or die(mysql_error());
			$rseleaft = mysqli_fetch_array($seleaft);
			$seledgral= mysqli_query($miConex, "select entidad from datos_generales where id_datos ='".$rseleaft['idunidades']."' ") or die(mysql_error());
			$rseledgral = mysqli_fetch_array($seledgral);

			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$selec = "SELECT * FROM areas where idarea='".$marcado[$x]."' and idunidades='".$_COOKIE['unidades']."' order by nombre";
				$result = mysqli_query($miConex, $selec) or die(mysql_error());
				$fields = mysqli_num_fields($result);
			    $rows   = mysqli_num_rows($result);
			    $ar = mysqli_fetch_array($result);
				$unidad =$_COOKIE['unidades'];
		    }else {
			  $selec = "SELECT * FROM areas where idarea='".$marcado[$x]."' and idunidades='".$rseleaft['idunidades']."' order by nombre";
			  $result = mysqli_query($miConex, $selec) or die(mysql_error());
			  $fields = mysqli_num_fields($result);
			  $rows   = mysqli_num_rows($result);
			  $ar = mysqli_fetch_array($result);
			  $unidad =$rseleaft['idunidades'];
			}  ?>	
			<table width="70%" height="24" border='0' align="center" cellpadding="0" cellspacing="0" class="table">
				<tr>
					<td colspan="3"><h3 align="center" class="vistauser1"> <?php echo $btAREASRES;?>: <font color="red"><?php echo $ar["nombre"];?></font> <?php if (!isset($_COOKIE['unidades'])){ echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>".$btdatosentidad3.":&nbsp;<font color='red'>".$rseledgral['entidad']."</font></b>";}?></h3></td>
				</tr>
				<tr class="well">
					<td><h3><?php echo $btcategmedios2;?></h3></td>
				    <td><h3><?php echo $btACTIVOS;?></h3></td>
					<td><h3><?php echo strtoupper($btRoto);?>S</h3></td>
				</tr>
			<?php
				$tf = array();
				while ($i < $fields) { 
					$metaf  = mysqli_fetch_field_direct ($result, $i);
					$flags = $metaf->flags;
					$nom_campo[$i] = $metaf->name;
					$tot=0;
					
					if (($metaf->name) !='idarea' and ($metaf->name) !='idunidades' and ($metaf->name) !='nombre')  {
						// Totalizar
						if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
						 $sql="SELECT SUM(".$metaf->name.") as total FROM areas Where idarea='".$marcado[$x]."' and idunidades='".$_COOKIE['unidades']."'";
						 $resultado = mysqli_query($miConex, $sql) or die("La consulta fall&oacute;: " . mysql_error());
						}else {
						 $sql="SELECT SUM(".$metaf->name.") as total FROM areas Where idarea='".$marcado[$x]."' and idunidades='".$rseleaft['idunidades']."'";
						 $resultado = mysqli_query($miConex, $sql) or die("La consulta fall&oacute;: " . mysql_error());
						}
					
									
						while ($linea = mysqli_fetch_array($resultado)) {
						    recalcula($porunidad,$marcado[$x],$metaf->name); 
							if(($linea["total"]) !=0){
								$tf[] = $linea["total"]; 
								$TG = $TG + $linea["total"];
														
								$sqlar="SELECT * FROM areas Where idarea='".$marcado[$x]."' and idunidades='".$rseleaft['idunidades']."'";
								$resul4 = mysqli_query($miConex, $sqlar) or die("La consulta fall&oacute;: " . mysql_error());
								$conresul4 = mysqli_fetch_array($resul4);
								
								$sql2="SELECT COUNT(inv) as totalarea FROM aft Where idarea='".$conresul4['nombre']."' AND estado='A' AND idunidades='".$rseleaft['idunidades']."'";
								$resultado4 = mysqli_query($miConex, $sql2) or die("La consulta fall&oacute;: " . mysql_error());
								$paracontar = mysqli_fetch_array($resultado4);
				                $toa[$x] = $paracontar['totalarea'];
								
								$sql3="SELECT COUNT(inv) as totalarear FROM aft Where idarea='".$conresul4['nombre']."' AND categ='".$metaf->name."' AND estado='R' AND idunidades='".$rseleaft['idunidades']."'";
								$resultado3 = mysqli_query($miConex, $sql3) or die("La consulta fall&oacute;: " . mysql_error());
								$paracontar3 = mysqli_fetch_array($resultado3);
								
								$sql4="SELECT COUNT(inv) as totalarear4 FROM aft Where idarea='".$conresul4['nombre']."' AND estado='R' AND idunidades='".$rseleaft['idunidades']."'";
								$resultado4 = mysqli_query($miConex, $sql4) or die("La consulta fall&oacute;: " . mysql_error());
								$paracontar4 = mysqli_fetch_array($resultado4);
								$suma++;?>
							<form name="catego" id="catego<?php echo $suma;?>" method="post" action="registromedios1.php">
								<input type="hidden" name="palabra" value="<?php echo strtoupper($nom_campo[$i]); ?>">
								<input type="hidden" name="idunida" value="<?php echo $unidad; ?>">
								<input type="hidden" name="id_are" value="<?php echo $marcado[$x]; ?>">
							</form>	
								<tr>
									<td width="20%" height="20" align="right"><?php echo strtoupper($nom_campo[$i]); ?></td>
									<td width="10"><span class="badge" onClick="document.getElementById('catego<?php echo $suma;?>').palabra.value='<?php echo strtoupper($nom_campo[$i]); ?>'; document.getElementById('catego<?php echo $suma;?>').idunida.value='<?php echo $unidad; ?>'; document.getElementById('catego<?php echo $suma;?>').id_are.value='<?php echo $marcado[$x];?>'; document.getElementById('catego<?php echo $suma;?>').submit();" style="cursor:pointer;" onMouseOver="cambiaimagen('abre','imagen<?php echo $i; ?>');" onMouseOut="cambiaimagen('cierra','imagen<?php echo $i; ?>');"><img id="imagen<?php echo $i; ?>" src="<?php echo $src2; ?>" width="12" height="12" onMouseOver="cambiaimagen('abre','imagen<?php echo $i; ?>');" onMouseOut="cambiaimagen('cierra','imagen<?php echo $i; ?>');" width="12" height="12">&nbsp;<?php echo $linea["total"];?></span></td>
									<td width="10"><?php if ($paracontar3["totalarear"]!=0) { ?><span class="badge" onClick="document.getElementById('catego<?php echo $suma;?>').palabra.value='<?php echo strtoupper($nom_campo[$i]); ?>'; document.getElementById('catego<?php echo $suma;?>').idunida.value='<?php echo $unidad; ?>'; document.getElementById('catego<?php echo $suma;?>').id_are.value='<?php echo $marcado[$x];?>'; document.getElementById('catego<?php echo $suma;?>').submit();" style="cursor:pointer;" onMouseOver="cambiaimagen('abre','imagen<?php echo $i; ?>');" onMouseOut="cambiaimagen('cierra','imagen<?php echo $i; ?>');"><img id="imagen<?php echo $i; ?>" src="<?php echo $src2; ?>" width="12" height="12" onMouseOver="cambiaimagen('abre','imagen<?php echo $i; ?>');" onMouseOut="cambiaimagen('cierra','imagen<?php echo $i; ?>');" width="12" height="12">&nbsp;<?php } if ($paracontar3["totalarear"]!=0) { echo "<font color=red>".$paracontar3["totalarear"]."</font>";}else{ echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- - -"; }?></td>
								</tr>
								<?php 
							}
							
						} 
					}
					$i++; 
				}
				if(($linea["total"])==0) { ?>  
								<tr> 
									<td width="20%" align="center">&nbsp;</td>
									<td width="10" align="center">&nbsp;</td>
									<td width="10" align="center">&nbsp;</td>
								</tr>
				<?php } 
				//if(($linea["total"]) !=0){
				$ttgr = $ttgr + $paracontar4['totalarear4'];?>
				               	<tr class="well">
									<td><b>&nbsp;&nbsp;TOTAL:</b></td>
									<td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span manolo ="<?php echo "Total ".$Por1.$btAreas1; ?>" style="cursor:pointer;"><?php if (@$toa[$x]!=0) { echo @$toa[$x]; }else {echo "---"; } ?></span></b></td>
									<td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if ($paracontar4["totalarear4"]!=0) { echo $paracontar4["totalarear4"]; }else{ echo "- - -"; } ?></b></td>
								</tr>
								
				<?php if(empty($tf)){ ?>
					<tr>
						<td align="center" colspan="3"><div align="center"><div class="message"><?php echo $no_log;?></div></div></td>
					</tr><?php
				}	
		}
		 if ($x> 1) {  ?>
					<tr class="well">
						<td><font color="red"><b>&nbsp;&nbsp;TOTAL DE MEDIOS:</b></font></td>
						<td><font color="red"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span manolo ="<?php echo $btenuso; ?>" style="cursor:pointer;"><?php print_r($TG); ?></span></b></font></td>
						<td><font color="red"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span manolo ="Rotos"><?php if ($ttgr!=0) { echo $ttgr; }else{ echo "- - -"; } ?></span></b></font></td>
					</tr>
			<?php } ?>
		</table>
<a href="#top"></a>
<input name="Retornar" value="Retornar" onclick="document.location='expedientes.php';" type="button" class="btn btn-default">
</fieldset><br>
	<?php include ("version.php");?>
</div>
<?php	
	}
	if (!isset($_REQUEST["expediente"]) and !isset($_REQUEST["calcular"]) and !isset($_REQUEST['busca'])) { ?>
<script language="javascript">document.location='expedientes.php';</script>
<?php	}
?>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>