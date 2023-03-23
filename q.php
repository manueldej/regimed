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
   
$sel = "select visitas from preferencias WHERE usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysqli_error($miConex));	
$rsel = mysqli_fetch_array($qsel);
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !="") { 
	$sql_uactiva = "select * from datos_generales WHERE id_datos='".$_COOKIE['unidades']."'";
} else {
	$sql_uactiva = "select * from datos_generales";
}
$result_uactiva= mysqli_query($miConex, $sql_uactiva) or die(mysqli_error($miConex));	
$ractiva = mysqli_fetch_array($result_uactiva);

$cuantos = 5;
if((@$rsel['visitas']) !=""){
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
			$seas = mysqli_query($miConex, "SELECT * FROM areas") or die(mysqli_error($miConex));
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
				$sea = mysqli_query($miConex, "SELECT * FROM areas WHERE idarea='".$marcado[$m]."'") or die(mysqli_error($miConex));
				$retdo = mysqli_fetch_array($sea);
				
				if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
					$resultados = mysqli_query($miConex, "SELECT inv FROM aft WHERE idarea='".$retdo['nombre']."' and idunidades='".$_COOKIE['unidades']."'");
					$sql = "select * from aft WHERE idarea='".$retdo['nombre']."' and idunidades='".$_COOKIE['unidades']."'";
					$result= mysqli_query($miConex, $sql) or die(mysqli_error($miConex));	
				}else {
					$resultados = mysqli_query($miConex, "SELECT inv FROM aft WHERE idarea='".$retdo['nombre']."' and idunidades='".$retdo['idunidades']."' order by inv");
				    $sql = "select * from aft WHERE idarea='".$retdo['nombre']."' and idunidades='".$retdo['idunidades']."' order by inv";
					$result= mysqli_query($miConex, $sql) or die(mysqli_error($miConex));	
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
						@$i++; 
						
						// Saber nombre de la PC 
						$sqlexp = "select * from exp WHERE inv = '".$row['inv']."'";
						$result_exp= mysqli_query($miConex, $sqlexp) or die(mysqli_error($miConex));
						$row_exp=mysqli_fetch_array($result_exp);
						?>
						<tr bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" id="cur_tr_<?php echo $id+1;?>" bgcolor="#ffffff" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>';colorear('<?php echo $p;?>','#DBE2D0');"  onclick="marca2(<?php echo $id+1;?>)">
							<td><input type="hidden" name="n<?php echo $id+1;?>" id="n<?php echo $id+1;?>"><?php 
								if((strtoupper($row["categ"])) =="COMPUTADORA" OR (strtoupper($row["categ"])) =="COMPUTADORAS" OR (strtoupper($row["categ"])) =="PC"){ ?>
									  &nbsp;&nbsp;&nbsp;<a href="javascript:ir('<?php echo $row["inv"];?>','<?php echo $row["idunidades"];?>','<?php echo $palab;?>','rm');" class="tooltip" style="margin-left:34px;"><img src="images/pc.png" width="24" height="24" align="absmiddle"><span onmouseover="this.style.cursor='pointer';"><?php echo $verdetalles1.$row["inv"]." (".$row_exp["n_PC"].")";?></span></a><?php 
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
	if(@$_REQUEST["calcular"]) {
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
	    if(isset($_COOKIE["unidades"])){$unidades = $_COOKIE["unidades"];}
		if(isset($_REQUEST["marcado"])){$marcado = $_REQUEST["marcado"];}
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
		function recalcula($marcado,$campo) {
		  include('connections/miConex.php');
		    $sql_uni = mysqli_query($miConex, "SELECT id_datos FROM datos_generales") or die(mysqli_error($miConex));									
			for ($i=0; $i<$marcado; $i++){
			    if ($campo!="idarea" AND $campo!="nombre" AND $campo!="idunidades") {
				    while ($row_uni = mysqli_fetch_array($sql_uni)) {
					   $unid = $row_uni['id_datos'];
					   $sql12 = "SELECT COUNT(id) as total FROM aft WHERE id_area='".$marcado."' AND estado='A' AND idunidades='".$unid."' AND categ='".$campo."' AND idarea!='Reparaciones'";
					   $resul12 = mysqli_query ($miConex, $sql12) or die (mysqli_error($miConex));
					   $row1 = mysqli_fetch_array ($resul12);		  
		            
					   $sql11 = "UPDATE areas SET ".$campo."='".$row1['total']."' WHERE idarea='".$marcado."' AND idunidades='".$unid."'";
				       $resul11 = mysqli_query ($miConex, $sql11) or die (mysqli_error($miConex)); 
				    } 
				}	   
		    }	
		} 
        
		function a_repaciones($marcado,$campo) {
		  include('connections/miConex.php');
		    $sql_uni = mysqli_query($miConex, "SELECT id_datos FROM datos_generales") or die(mysqli_error($miConex));									
			for ($i=0; $i<$marcado; $i++){
			    if ($campo!="idarea" AND $campo!="nombre" AND $campo!="idunidades") {
				    while ($row_uni = mysqli_fetch_array($sql_uni)) {
					   $unid = $row_uni['id_datos'];
					   $sql12 = "SELECT COUNT(id) as total FROM aft WHERE id_area='".$marcado."' AND estado='R' AND idunidades='".$unid."' AND categ='".$campo."' AND idarea='Reparaciones'";
					   $resul12 = mysqli_query ($miConex, $sql12) or die (mysqli_error($miConex));
					   $row1 = mysqli_fetch_array ($resul12);		  
		               if ($row1['total']!=0)
					   {
						 $sql11 = "UPDATE areas SET ".$campo."='".$row1['total']."' WHERE idarea='1' AND idunidades='".$unid."'";
				         $resul11 = mysqli_query ($miConex, $sql11) or die (mysqli_error($miConex));   
					   }
					   
				    } 
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
		$cdu = array();
		$suma = 0;
		$ttgr = 0;
		$ttgb = 0;
		
		for($x=0; $x<count($marcado); $x++){
			$i = 0;
			$toa = array();	
			$tor = 0;		
			$tob = 0;
			$seleaft = mysqli_query($miConex, "select idunidades from areas WHERE idarea ='".$marcado[$x]."' ") or die(mysqli_error($miConex));
			$rseleaft = mysqli_fetch_array($seleaft);
			$seledgral= mysqli_query($miConex, "select entidad from datos_generales WHERE id_datos ='".$rseleaft['idunidades']."' ") or die(mysqli_error($miConex));
			$rseledgral = mysqli_fetch_array($seledgral);

			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$selec = "SELECT * FROM areas WHERE idarea='".$marcado[$x]."' and idunidades='".$_COOKIE['unidades']."'  ORDER BY nombre";
				$result = mysqli_query($miConex, $selec) or die(mysqli_error($miConex));
				$fields = mysqli_num_fields($result);
			    $rows   = mysqli_num_rows($result);
			    $ar = mysqli_fetch_array($result);
				$unidad =$_COOKIE['unidades'];
		    }else {
			  $selec = "SELECT * FROM areas WHERE idarea='".$marcado[$x]."' and idunidades='".$rseleaft['idunidades']."' ORDER BY nombre";
			  $result = mysqli_query($miConex, $selec) or die(mysqli_error($miConex));
			  $fields = mysqli_num_fields($result);
			  $rows   = mysqli_num_rows($result);
			  $ar = mysqli_fetch_array($result);
			  $unidad =$rseleaft['idunidades'];
			}  ?>	
		<table width="90%" border='0' align="center" cellpadding="0" cellspacing="0" class="table">
			<tr>
				<td colspan="4"><h3 align="center" class="vistauser1"> <?php echo $btAREASRES;?>: <font color="red"><?php echo $ar["nombre"];?></font> <?php if (!isset($_COOKIE['unidades'])){ echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>".$btdatosentidad3.":&nbsp;<font color='red'>".$rseledgral['entidad']."</font></b>";}?></h3></td>
			</tr>
			<tr class="">
				<td><h3><?php echo $btcategmedios2;?></h3></td>
			    <td><h3><?php echo $btACTIVOS;?></h3></td>
				<td><h3><?php echo strtoupper($btRoto);?>S</h3></td>
			    <td><h3><?php echo strtoupper($btbajas);?></h3></td>
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
						 $sql="SELECT SUM(".$metaf->name.") as total FROM areas WHERE idarea='".$marcado[$x]."' and idunidades='".$_COOKIE['unidades']."'";
						 $resultado = mysqli_query($miConex, $sql) or die(mysqli_error($miConex));
						}else {
						 $sql="SELECT SUM(".$metaf->name.") as total FROM areas WHERE idarea='".$marcado[$x]."' and idunidades='".$rseleaft['idunidades']."'";
						 $resultado = mysqli_query($miConex, $sql) or die(mysqli_error($miConex));
						 
						 $obt_idarea = "SELECT * FROM areas WHERE idarea='".$marcado[$x]."' and idunidades='".$rseleaft['idunidades']."' ORDER BY nombre";
						 $result_idarea = mysqli_query($miConex, $obt_idarea) or die(mysqli_error($miConex));
						 $row_a = mysqli_fetch_array($result_idarea);
						
						 $sql_r="SELECT COUNT(inv) as total FROM aft WHERE idarea='Reparaciones' and id_area='".$row_a['idarea']."' and idunidades='".$rseleaft['idunidades']."'";
						 $result_r = mysqli_query($miConex, $sql_r) or die(mysqli_error($miConex));
						 $l_r = mysqli_fetch_array($result_r);
						 $cdu[$i] = $l_r['total'];
		
						}
				
				        $sqlar="SELECT * FROM areas WHERE idarea='".$marcado[$x]."' and idunidades='".$rseleaft['idunidades']."'";
						$resul4 = mysqli_query($miConex, $sqlar) or die(mysqli_error($miConex));
						$conresul4 = mysqli_fetch_array($resul4);
								
				        $sql3="SELECT COUNT(id) as totalrotas FROM aft WHERE id_area='".$conresul4['idarea']."' AND categ='".StrtoUpper($metaf->name)."' AND estado='R' AND idunidades='".$rseleaft['idunidades']."'";
						$resultado3 = mysqli_query($miConex, $sql3) or die(mysqli_error($miConex));
						$paracontar3 = mysqli_fetch_array($resultado3);
		         
						if($paracontar3['totalrotas']!=0){
							$tor ++;
						}
						
						$sql_bajastec="SELECT COUNT(inv) as totalbajas FROM historial_bajas WHERE idarea='".$conresul4['nombre']."' AND categ='".$metaf->name."' AND estado='B' AND idunidades='".$rseleaft['idunidades']."'";
						$result_bajast = mysqli_query($miConex, $sql_bajastec) or die(mysqli_error($miConex));
						$row_bt = mysqli_fetch_array($result_bajast);
													
						if($row_bt['totalbajas']!=0){
							$tob ++;
						}
								
						while ($linea = mysqli_fetch_array($resultado)) {
						    recalcula($marcado[$x],$metaf->name);
				            a_repaciones($marcado[$x], $metaf->name);
							
							if(($linea["total"]!=0) OR ($row_bt['totalbajas']!=0) OR ($paracontar3['totalrotas']!=0)){
								$tf = $linea["total"]; 
								$TG = $TG + $linea["total"];
														
								$sqlar="SELECT * FROM areas WHERE idarea='".$marcado[$x]."' and idunidades='".$rseleaft['idunidades']."'";
								$resul4 = mysqli_query($miConex, $sqlar) or die(mysqli_error($miConex));
								$conresul4 = mysqli_fetch_array($resul4);
								
								$sql2="SELECT COUNT(inv) as totalarea FROM aft WHERE idarea='".$conresul4['nombre']."' AND estado='A' AND idunidades='".$rseleaft['idunidades']."'";
								$resultado4 = mysqli_query($miConex, $sql2) or die(mysqli_error($miConex));
								$paracontar = mysqli_fetch_array($resultado4);
				              	
                                							
								if($paracontar['totalarea']!=0){
									$toa[$x] = $paracontar['totalarea'];
								}			
								
								$sql4="SELECT COUNT(inv) as totalareare FROM aft WHERE idarea='".$conresul4['nombre']."' AND estado='R' AND idunidades='".$rseleaft['idunidades']."'";
								$resultado4 = mysqli_query($miConex, $sql4) or die(mysqli_error($miConex));
								$paracontar4 = mysqli_fetch_array($resultado4);
				
								$suma++;?>
					<form name="catego" id="catego<?php echo $suma;?>" method="post" action="registromedios1.php">
						<input type="hidden" name="palabra" value="<?php echo strtoupper($nom_campo[$i]); ?>">
						<input type="hidden" name="idunida" value="<?php echo $unidad; ?>">
						<input type="hidden" name="id_are" value="<?php echo $marcado[$x]; ?>">
					</form>	
					<form name="defect" id="defect<?php echo $suma;?>" method="post" action="defectuosos.php">
						<input type="hidden" name="palabra" value="<?php echo strtoupper($nom_campo[$i]); ?>">
						<input type="hidden" name="idunida" value="<?php echo $unidad; ?>">
						<input type="hidden" name="id_are" value="<?php echo $marcado[$x]; ?>">
					</form>
					<form name="hbajas" id="hbajas<?php echo $suma;?>" method="post" action="destinobajas.php">
						<input type="hidden" name="palabra" value="<?php echo strtoupper($nom_campo[$i]); ?>">
						<input type="hidden" name="idunida" value="<?php echo $unidad; ?>">
						<input type="hidden" name="id_are" value="<?php echo $marcado[$x]; ?>">
					</form>	
			<tr>
				<td width="20%" height="20" align="left"><?php if (($linea["total"]!=0) OR ($tob!=0) OR ($tor!=0) ) { echo strtoupper($nom_campo[$i]); }?></td>
				<td width="10"><?php if(($linea["total"]!=0) OR ($tob!=0) OR ($tor!=0)) { ?><span class="badge" onClick="document.getElementById('catego<?php echo $suma;?>').palabra.value='<?php echo strtoupper($nom_campo[$i]); ?>'; document.getElementById('catego<?php echo $suma;?>').idunida.value='<?php echo $unidad; ?>'; document.getElementById('catego<?php echo $suma;?>').id_are.value='<?php echo $marcado[$x];?>'; document.getElementById('catego<?php echo $suma;?>').submit();" style="cursor:pointer;" onMouseOver="cambiaimagen('abre','imagen<?php echo $i; ?>');" onMouseOut="cambiaimagen('cierra','imagen<?php echo $i; ?>');"><img id="imagen<?php echo $i; ?>" src="<?php echo $src2; ?>" width="12" height="12" onMouseOver="cambiaimagen('abre','imagen<?php echo $i; ?>');" onMouseOut="cambiaimagen('cierra','imagen<?php echo $i; ?>');" width="12" height="12">&nbsp;<?php echo $linea["total"];?></span><?php } ?></td>
				<td width="10"><?php if ($paracontar3["totalrotas"]!=0) { ?><span class="badge" onClick="document.getElementById('catego<?php echo $suma;?>').palabra.value='<?php echo strtoupper($nom_campo[$i]); ?>'; document.getElementById('catego<?php echo $suma;?>').idunida.value='<?php echo $unidad; ?>'; document.getElementById('catego<?php echo $suma;?>').id_are.value='<?php echo $marcado[$x];?>'; document.getElementById('defect<?php echo $suma;?>').submit();" style="cursor:pointer;" onMouseOver="cambiaimagen('abre','imagen1<?php echo $i; ?>');" onMouseOut="cambiaimagen('cierra','imagen1<?php echo $i; ?>');"><img id="imagen1<?php echo $i; ?>" src="<?php echo $src2; ?>" width="12" height="12" onMouseOver="cambiaimagen('abre','imagen1<?php echo $i; ?>');" onMouseOut="cambiaimagen('cierra','imagen1<?php echo $i; ?>');" width="12" height="12">&nbsp;<?php } if ($paracontar3["totalrotas"]!=0) { echo $paracontar3["totalrotas"];}else{ echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; }?></td>
			    <td width="10"><?php if ($row_bt["totalbajas"]!=0) { ?><span class="badge" onClick="document.getElementById('hbajas<?php echo $suma;?>').palabra.value='<?php echo strtoupper($nom_campo[$i]); ?>'; document.getElementById('hbajas<?php echo $suma;?>').idunida.value='<?php echo $unidad; ?>'; document.getElementById('hbajas<?php echo $suma;?>').id_are.value='<?php echo $marcado[$x];?>'; document.getElementById('hbajas<?php echo $suma;?>').submit();" style="cursor:pointer;" onMouseOver="cambiaimagen('abre','imagen2<?php echo $i; ?>');" onMouseOut="cambiaimagen('cierra','imagen2<?php echo $i; ?>');"><img id="imagen2<?php echo $i; ?>" src="<?php echo $src2; ?>" width="12" height="12" onMouseOver="cambiaimagen('abre','imagen2<?php echo $i; ?>');" onMouseOut="cambiaimagen('cierra','imagen2<?php echo $i; ?>');" width="12" height="12">&nbsp;<?php } if ($row_bt["totalbajas"]!=0) { echo $row_bt["totalbajas"];}else{ echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; }?></td>
			</tr>
				<?php 
						}
						 $ttgr = $ttgr + $paracontar3['totalrotas'];   
					     $ttgb = $ttgb + $row_bt['totalbajas'];  	
						} 
					
						
					}
					$i++; 
				}
				if((@$linea["total"])==0) { ?>  
			<tr> 
				<td width="20%" align="center">&nbsp;</td>
				<td width="10" align="center">&nbsp;</td>
				<td width="10" align="center">&nbsp;</td>
				<td width="10" align="center">&nbsp;</td>
			</tr>
				<?php } ?>
		    <tr class="navegador">
				<td><b>&nbsp;&nbsp;<?php echo $bttmecateg2; ?> :</b></td>
				<td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span manolo ="<?php echo "Total AFT ".$Por1.$btAreas1; ?>" style="cursor:pointer;"><?php if (@$toa[$x]!=0) { echo @$toa[$x]; }else {  echo "0"; } ?></span></b></td>
				<td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span manolo ="<?php echo "Total Rotas ".$Por1.$btAreas1; ?>" style="cursor:pointer;"><?php if (@$tor!=0) {  echo @$tor; } else { echo "0"; } ?></span></b></td>
				<td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span manolo ="<?php echo "Total Bajas ".$Por1.$btAreas1; ?>" style="cursor:pointer;"><?php if (@$tob!=0) { echo @$tob; } else { echo "0"; } ?></span></b></td>
			</tr><?php  if(empty($tf)){ ?>
			<tr>
				<td align="center" colspan="4"><div align="center"><div class="message"><?php echo $no_log;?></div></div></td>
			</tr><?php 
				    }	
		}
		 if ($x> 1) {  ?>
			<tr class="navegador">
				<td><font color="red"><b>&nbsp;&nbsp;<?php echo $bttmecateg1; ?>:</b></font></td>
				<td><font color="red"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span manolo ="<?php echo $btenuso; ?>" style="cursor:pointer;"><?php print_r($TG); ?></span></b></font></td>
				<td><font color="red"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span manolo ="Rotos"><?php if ($ttgr!=0) { echo $ttgr; }else{ echo "0"; } ?></span></b></font></td>
				<td><font color="red"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span manolo ="Bajas"><?php if ($ttgb!=0) { echo $ttgb; }else{ echo "0"; } ?></span></b></font></td>
			</tr>
			<?php } ?>
		</table>
<a href="#top"></a>
<input name="Retornar" value="<?php echo $retor; ?>" onclick="document.location='expedientes.php';" type="button" class="btn btn-default">
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