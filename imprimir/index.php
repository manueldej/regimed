<?php
############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                		            #
# Version:  3.1.1                                                     				                        #
# Fecha:    01/06/2016 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada											         		            #
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

@session_start(); include('../chequeo.php');
if (!check_auth_user()){
	?><script type="text/javascript">window.parent.location="../index.php";</script><?php
	exit;
}
require_once('../connections/miConex.php');
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('../esp.php');}else{ include('../eng.php');}
	
if (isset($_GET['inicio'])) { $inicio= $_GET['inicio'];}
	if (isset($_GET['tb']) AND $_GET['tb']!="") {
		$tb = $_GET['tb'];
	}
if (isset($_GET['registros'])) { $registros= $_GET['registros']; }
if (isset($_REQUEST['query'])) { $query=base64_decode($_REQUEST['query']);}

$Uactb="";
$Uactb1="";
$idunidad="";

$selvi = "select * from preferencias where usuario='".$_SESSION['valid_user']."'";
$qselvi = mysqli_query($miConex, $selvi) or die(mysqli_error($miConex));
$rsel = mysqli_fetch_array($qselvi);

if((@$rsel['columnas']) !=""){
	$columnas = $rsel['columnas'];
}else{
  $columnas = 14;	
}

if(isset($_GET['area']) AND ($_GET['area']) !=""){
	$idunidad=" where idarea =".$_GET['area'];
	if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	  $Uactb = " AND idunidades='".$_COOKIE['unidades']."'";
	  $Uactb1 = " WHERE id_datos='".$_COOKIE['unidades']."'";
    }
}elseif(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	 $Uactb = " WHERE idunidades='".$_COOKIE['unidades']."'";
	 $Uactb1 = " WHERE id_datos='".$_COOKIE['unidades']."'";
}else{
	 $Uactb = "";
	 $Uactb1 = "";
	
}

$sqlD = "SELECT * FROM datos_generales".$Uactb1;
$resultD= mysqli_query($miConex, $sqlD) or die (mysqli_error($miConex));
$DatosG = mysqli_fetch_array($resultD);

?>
<html><title>Regimed -<?php echo $btversion;?>-</title>
<link rel="shortcut icon" href="../images/logo_10814142.png" />
<link href="../css/template.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {
	color: #000000;
	font-weight: bold;
	font-family: Tahoma, Helvetica, Arial, sans-serif;
	font-size: 18px;
}
-->
</style>
<body onLoad="javascript:print()"><?php
    echo "<div align='center'><img src='../images/RegimedLogoVerticalBlack.png' style='margin-top:9px; margin-left: -814px; padding: 11px;' width='200' height='72'></div>";
	echo "<div align='center'>". $DatosG['entidad'].".<br></div>".
				  "<div align='center'><a href='". $DatosG['web']."'>". $DatosG['web']."</a></div></font><br>";
	
	if(isset($_GET['query'])){
		$kk= base64_decode($_GET['query']);
		if(stristr($kk,'kk') !=""){
			$se = str_ireplace('kk',$idunidad,$kk);
		}else{
			$se =$kk;
		}
		$sql= mysqli_query($miConex, $se) or die(mysqli_error($miConex));
	}else{
		$sq = "SELECT * FROM ".$tb.$idunidad.$Uactb;
		$sql =  mysqli_query($miConex, $sq) or die(mysqli_error($miConex));
	}
		
	if(($tb) =="aft"){ 
		$cusa = mysqli_fetch_array($sql);
			
	echo "<div align='left' class='article_column Estilo1'>&nbsp;&nbsp;".$btAREASRES.": ".$cusa['idarea']."</div><hr>"; 
	}
	
	if(($tb) =="areas"){
		$sql = "SELECT * FROM ".$tb.$idunidad.$Uactb." ORDER BY nombre limit ".$inicio.",".$registros;;
		$result= mysqli_query($miConex, $sql);
  
		function total($campo, $miConex) {
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			  $consulta  = "SELECT SUM(".$campo.") as valor_col FROM areas where idunidades='".$_COOKIE['unidades']."'";
			}else{ 
			 $consulta  = "SELECT SUM(".$campo.") as valor_col FROM areas";
			}
			
			$resultado1 = mysqli_query($miConex, $consulta) or die("La consulta fall&oacute;: " . mysqli_error($miConex));
			$linea = mysqli_fetch_array($resultado1);
			echo $linea['valor_col']."\n";
		}
		
		?>
		<table width="100" border="0" cellpadding="1" cellspacing="1" class="table">
			<tr><?php 
				for($n=1; $n<=$columnas;  $n++){ 
					$field = mysqli_fetch_field_direct($result, $n);
					$name1  = $field->name;
					?>
					<td><b><?php if((strlen(strtoupper($name1))) >7){ echo substr(strtoupper($name1),0,8);}else { echo strtoupper($name1);} ?></b></td><?php 
				}?>
			</tr><?php 	
			while($row= mysqli_fetch_array($result)) {
				$i++;
				//if(($row["nombre"]) !="Reparaciones"){ ?>
				<tr><?php 
					for($n=1; $n<=$columnas;  $n++){  
						$field = mysqli_fetch_field_direct($result, $n);
						$name1  = $field->name;?>
						<td><?php echo $row[$name1];?></td><?php 
					}
				//}
			} ?>
			    </tr><?php 
			if(!isset($_GET['area'])){ ?>
				<tr>
					<td align="center"><font color="red"><b>TOTALES</b></font><br></td><?php 
						for($n=1; $n<=$columnas;  $n++){  
						$name = mysqli_fetch_field_direct($result, $n); if ($name->name!="nombre") { ?>
							<td><font color='red'><?php echo "<b>".total($name->name,$miConex)."</b>"; ?></font></td><?php 
						} } ?>
				</tr><?php
			} ?>
		</table><?php
	}
	if(($tb) == "aft"){
		$Uactb="";
		$idunidad="";
		if(isset($_GET['area']) AND ($_GET['area']) !=""){
			$idunidad=" where id =".$_GET['area'];
		}
		if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$Uactb = " AND idunidades='".$_COOKIE['unidades']."'";
		}			

		if(isset($_GET['query'])){
			$kk= base64_decode($_GET['query']);
			if(stristr($kk,'kk') !=""){
				$se = str_ireplace('kk',$idunidad,$kk);
			}else{
				$se =$kk;
			}
			$sql= mysqli_query($miConex, $se) or die(mysqli_error($miConex));
		}else{
			$sq = "SELECT * FROM ".$tb.$idunidad.$Uactb;
			$sql =  mysqli_query($miConex, $sq) or die(mysqli_error($miConex));
		}
		
		
		if((mysqli_num_rows($sql)) !=0){ ?>
			<table width="95%" border="0" align="center" cellpadding="0" cellspacing="4">
				<tr>
				    <td><div align="left"><b>INV</b></div></td>
					<td><div align="left"><b><?php echo $DESCRIPCION;?></b></div></td>
					<td><div align="left"><b><?php echo strtoupper($btestado);?></b></div></td>
					<td><div align="left"><b><?php echo $btSELLO?></b></div></td>
					<td><div align="left"><b><?php echo $btMARCA;?></b></div></td>
					<td><div align="left"><b><?php echo $btcategmedios2;?></b></div></td>
					<td><div align="left"><b><?php echo strtoupper($bttipo);?></b></div></td>
					<td><div align="left"><b><?php echo $CUSTODIO;?></b></div></td>
				</tr>
				<?php 		
				while($row=mysqli_fetch_array($sql)) {
					
						$i++; ?>
						<tr>
							<td><?php echo $row["inv"];?></td>
							<td><?php echo $row["descrip"];?></td>
							<td><div align="center"><?php echo $row["estado"];?></div></td>
							<td><?php echo $row["sello"];?></td>
							<td><?php echo $row["marca"];?></td>
							<td><?php echo $row["categ"];?></td>
							<td><?php echo $row["tipo"];?></td>
							<td><?php echo $row["custodio"];?></td>
						</tr><?php
				}?> 
			</table>
<?php   echo "<div style='position:absolute;float: right;margin-left: 31px;margin-top: 12px;'><b>Total: </b>".mysqli_num_rows($sql)."</div>";	
		}else{ ?> <b><font color="black">No existen Medios registrados.</font></b> <?php }		
	}
	if(($tb) =="manuales"){
		$query_man = "SELECT * FROM ".$tb;
		$RSD_man = mysqli_query($miConex, $query_man);
		$row_man = mysqli_fetch_assoc($RSD_man);
		echo '<div align="justify">'.$row_man['manuales'].'</div>';
	}
	if(($tb) =="visitas"){
		class cdate{
			function formatDate($adate, $currTab, $futTab){
				if (!is_null($adate)){
					$sep = array();
					$sep = explode($currTab, $adate);
					return $sep[2].$futTab.$sep[1].$futTab.$sep[0];
				}else{
					return "";
				}
			}
		}
		$myDate = new cdate();?>
		<table width="630" border="0" align="center">
			<tr>
				<td valign="top">
				  <span class="sgf1">  <?php 
					$sql="SELECT * FROM visitas order by fecha, hora DESC limit ".$inicio.",".$registros;
					$result=mysqli_query($miConex, $sql);
					$num_resultados = mysqli_num_rows($result);
					// Si hay resultados crea una tabla y los muestra
					if ($row= mysqli_fetch_array($result)){ ?>
						<table width="775" BORDER='0' cellpadding="1" cellspacing="1" bordercolor='#D2D2D2' class="sgf1"> 
							<tr> 
								<td width="154" bgcolor="#D2D2D2"><span class="sgf1"><b><?php echo substr($btusuario,0,-1);?></b></span></td>
								<td width="140" bgcolor="#D2D2D2"><span class="sgf1"><b><?php echo strtoupper($Fecha);?></b></span></td>
								<td width="129" bgcolor="#D2D2D2"><span class="sgf1"><b><?php echo strtoupper($h_hora);?></b></span></td> 
								<td width="339" bgcolor="#D2D2D2"><span class="sgf1"><b><?php echo $dir2;?></b> </span></td>
							</tr><?php
							$i=0;
							do{ ?>
								<tr id="cur_tr_<?php echo $i;?>" onMouseOver="this.style.color='#FF151C'; this.style.cursor='pointer';" onMouseOut="this.style.color='#2861A4';"  onclick="marca1(<?php echo $i;?>,'#ffffff')"> 
									<td><span class="sgf1"><?php echo $row["user"];?></span></td> 
									<td><span class="sgf1"><?php echo $myDate->formatDate($row['fecha'],"-","/");?></span></td>
									<td><span class="sgf1"><?php echo $row["hora"];?></span></td>
									<td><span class="sgf1"><?php echo $row["ip"];?></span></td>
								</tr><?php 
								$i++;
							}while ($row=mysqli_fetch_array($result)); ?>
						</TABLE><?php
					}?>
				  </span>
				</td>
			</tr>
		</table><?php echo "<div style='position:absolute;float: right;margin-left: 31px;margin-top: 12px;'><b>Total:</b>".$num_resultados."</div>";
	}
	if(($tb) =='mtto'){
		$sqlz = "SELECT * FROM ".$tb.$Uactb;
		$result=mysqli_query($miConex, $sqlz) or die(mysqli_error($miConex));
		$num_resultados = mysqli_num_rows($result);	?>
		<table width="100%" border="0" cellpadding="4" cellspacing="4">
					<tr>
					  <td colspan="6" align="center"><b><font size="4"><?php echo $btpmtto1;?></font></b></td>
					</tr>
					<tr>
						<td><b>Inv</b></td>
						<td><b><?php echo $btcategmedios1;?></b></td>
						<td><b><?php echo $Fecha;?></b></td>
						<td><b><?php echo $btAreas;?></b></td>
						<td><b><?php echo ucwords(strtolower($btestado));?></b></td>
						<td><b><?php echo $btdatosentidad3;?></b></td>
					</tr>
					<?php
					while($row=mysqli_fetch_array($result)){ @$i++;
						if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
							$sqlzc=mysqli_query($miConex, "SELECT categ,idarea,idunidades FROM aft where (inv ='".$row["inv"]."') AND idunidades='".$_COOKIE['unidades']."'") or die(mysqli_error($miConex)); 
						}else{
							$sqlzc=mysqli_query($miConex, "SELECT categ,idarea,idunidades FROM aft where (inv ='".$row["inv"]."')") or die(mysqli_error($miConex)); 
						}
						$sqlzcx = mysqli_fetch_array($sqlzc);					
						$sqlDG=mysqli_query($miConex, "SELECT * FROM datos_generales where (id_datos ='".$sqlzcx["idunidades"]."')") or die(mysqli_error($miConex)); 
						$sqlxDG = mysqli_fetch_array($sqlDG);?>
					<tr>
						<td><?php echo $row["inv"];?></td>
						<td><?php echo $sqlzcx["categ"];?></td>
						<td><?php echo $row["fecha"];?></td>
						<td><?php echo $sqlzcx["idarea"];?></td>
						<td><?php if(($row["estado"]) =="Pendiente"){ echo "<font color='blue'><b>".$row["estado"]."</b></font>"; }else{ echo $row["estado"];}?></td>
						<td><?php echo $sqlxDG["entidad"];?></td>
					</tr>
					<?php
					} ?>
		</table><?php
	}
	if(($tb) =='plan_rep'){
		$sqlz = "SELECT * FROM ".$tb.$Uactb;
		$result=mysqli_query($miConex, $sqlz);
		$num_resultados = mysqli_num_rows($result);	?>
		<TABLE width="100%" BORDER='0' align='center' cellpadding="1" cellspacing="1" >
			<tr>				
				<td width='131'><b>INV</b></td>
				<td width="90"><b><?php echo strtoupper($Fecha);?></b></td>
				<td width="274"><b>&nbsp;&nbsp;&nbsp;<?php echo $btPERTENECE.$btAreas1?></b></td>
				<td width="191"><b><?php echo $btOBSERVACIONES;?></b></td>
				<td width="270"><b><?php echo $btdatosentidad3;?></b></td>
			</tr><?php
			while ($row=mysqli_fetch_array($result)){ 			
				$sqlDG=mysqli_query($miConex, "SELECT * FROM datos_generales where (id_datos ='".$row["idunidades"]."')") or die(mysqli_error($miConex)); 
				$sqlxDG = mysqli_fetch_array($sqlDG);?>
			<tr>
				<td width='131'><?php echo $row["inv"];?></td>
				<td><?php echo $row["fecha"];?></td>
				<td>&nbsp;&nbsp;<?php echo $row["idarea"];?></td>
				<td><?php echo $row["observ"];?></td>
				<td><?php echo $sqlxDG["entidad"];?></td>
			</tr><?php
			}?>
		</TABLE><?php  echo "<div style='position:absolute;float: right;margin-left: 31px;margin-top: 12px;'><b>Total:</b>".$num_resultados."</div>";
	}elseif(($tb) =='traspasos'){ 
		$sqlz = "SELECT * FROM ".$tb.$Uactb;
		$result=mysqli_query($miConex, $sqlz);
		$num_resultados = mysqli_num_rows($result);	?>
		<table width="817" border='0' align="center" cellpadding="0" cellspacing="0">
			<tr >
				<td colspan="5" align="center"><font size="4"><b><?php echo $btREGISTROTRASPASOS;?></b></font></td>
			</tr>
			<tr>
				<td><b>INV</b></td>
				<td width="107"><b><?php echo strtoupper($Fecha);?></b></td>
				<td width="194"><b><?php echo $btORIGEN;?></b></td>
				<td width="202"><b><?php echo $btDESTINO;?></b></td>
				<td width="207"><b><?php echo substr($btMOTIVOS,0,-1);?></b></td>
			</tr> <?php				
			WHILE ($row=mysqli_fetch_array($result))	{ ?>
				<tr>
					<td width="107"><?php echo $row["fecha"];?></td>
					<td><?php echo $row["inv"];?></td>
					<td><?php echo $row["origen"];?></td>
					<td><?php echo $row["destino"];?></td>
					<td><?php if(($row["motivo"]) !="-") { echo $row["motivo"];}else{ echo '&nbsp;&nbsp;&nbsp;&nbsp;-'; }?></td>
				</tr> <?php
			} ?>
		</table><?php echo "<div style='position:absolute;float: right;margin-left: 31px;margin-top: 12px;'><b>Total:</b>".mysqli_num_rows($result)."</div>";
	}elseif(($tb) =='usuarios'){
		$sqlz = "SELECT * FROM ".$tb.$Uactb;
		$result=mysqli_query($miConex, $sqlz) or die(mysqli_error($miConex)); ?>
		<TABLE width="100%" BORDER='0' cellpadding="3" cellspacing="3">
			<tr>
				<td><b><div align="left"><b>&nbsp;</b>Login</div></b></td>
				<td width="244" align='center'><div align="left"><b><?php echo $btNombre;?></b></div></td>
				<td width="161" align='center'><div align="left"><b><?php echo $btnCargo;?></b></div></td>
				<td width="198" align='center'><div align="left"><b>E-mail</b></div></td>
				<td width="205" align='center'><div align="left"><b><?php echo $btAreas;?></b></div></td>
				<td width="87" align='center'><div align="center"><b><?php echo $Sexo;?></b></div></td>
			</tr>  <?php  
			while($row=mysqli_fetch_array($result))    {  $i++;
				$selent=mysqli_query($miConex, "SELECT * FROM datos_generales where id_datos='".$row['idunidades']."'") or die(mysqli_error($miConex)); 
				$rselun=mysqli_fetch_array($selent);
				$idf = $row["id"]; ?>
				<tr>
					<td width="46"><?php echo $row["login"];?></td>
					<td><?php echo $row["nombre"];?></td>
					<td><?php echo $row["cargo"];?></td>
					<td><?php echo $row["email"];?></td>
					<td><?php echo $row["idarea"];?></td>
					<td align="center"><?php if(($row["sexo"]) =="m"){ echo "Femenino";} elseif(($row["sexo"]) =="h"){ echo "Masculino";}else{ echo "-";}?> </td>						
				</tr><?php 
			} ?>
		</table><?php echo "<div style='position:absolute;float: right;margin-left: 31px;margin-top: 12px;'><b>Total:</b>".mysqli_num_rows($result)."</div>";
	}elseif(($tb) =='tipos_medios'){
		$result = mysqli_query($miConex, "SELECT * FROM ".$tb);  ?>
		<TABLE width="100%" BORDER="0" cellpadding="3" cellspacing="3">
			<tr>
				<td>&nbsp;<b><?php echo $btcategmedios;?></b></td> 
			</tr> <?php  
			while($row=mysqli_fetch_array($result))    {	 ?>
				<tr>	
					<td>&nbsp;&nbsp;<?php echo $row["nombre"];?></td>
				</tr><?php  		
			}	?>
		</table><?php echo "<div style='position:absolute;float: right;margin-left: 31px;margin-top: 12px;'><b>Total:</b>".mysqli_num_rows($result)."</div>";
	}elseif(($tb) =='reg_claves'){ 
		$sqlz = "SELECT * FROM ".$tb.$Uactb;
		$result=mysqli_query($miConex, $sqlz) or die(mysqli_error($miConex));?>
		<table width="70%" border="0" align="center">
			<tr>
				<td width="671"><b><?php echo substr($mostrar1,0,-1).$de.$btpassw1;?></b></td>
			</tr>
			<tr>
				<td align="center">
					<table width="827" border='0' cellspacing="4" cellpadding="4" class="table">
						<tr>								
							<td width="240"><b><?php echo strtoupper($btCustodios);?></b></td>
							<td width="120"><b>PC</b></td>
							<td width="160"><b>LOGIN</b></td>
							<td width="140"><b>SETUP</b></td>
							<td width="113"><b><?php echo strtoupper($btSistema);?></b></td>
						</tr><?php $p=0;
						while($row=mysqli_fetch_array($result)){	$i++;?>
							<tr>								
								<td><?php echo $row["usuario"];?></td>
								<td><?php echo $row["equipo"];?></td>
								<td><?php echo $row["login"];?></td>
								<td><?php echo base64_decode($row["setup"]);?></td>
								<td><?php echo base64_decode($row["sistema"]);?></td>
							</tr><?php $p++;
						} ?>						   
					</table>
				</td>
			</tr>
		</table><?php 
	}elseif(($tb) =='reg_claves_soft'){ echo "<div style='position:absolute;float: right;margin-left: 31px;margin-top: 12px;'><b>Total:</b>".mysqli_num_rows($result)."</div>"; 
		$sqlz = "SELECT * FROM ".$tb.$Uactb;
		$result=mysqli_query($miConex, $sqlz) or die(mysqli_error($miConex));?>
		<table width="70%" border="0" align="center">
			<tr>
				<td width="671"><b><?php echo substr($mostrar1,0,-1).$de.$pass5;?></b></td>
			</tr>
			<tr>
				<td align="center">
					<table width="827" border='0' cellspacing="4" cellpadding="4" class="table">
						<tr>								
							<td width="120"><b>EQUIPO</b></td>
							<td width="160"><b>SOFTWARE</b></td>
							<td width="160"><b>USUARIO</b></td>
							<td width="160"><b>LOGIN</b></td>
							<td width="140"><b>PASSWORD</b></td>
						</tr><?php $p=0;
						while($row=mysqli_fetch_array($result)){	$i++;?>
							<tr>								
								<td><?php echo $row["equipo"];?></td>
								<td><?php echo $row["software"];?></td>
								<td><?php echo $row["usuario"];?></td>
								<td><?php echo $row["login"];?></td>
								<td><?php echo base64_decode($row["passwd"]);?></td>
							</tr><?php $p++;
						} ?>						   
					</table>
				</td>
			</tr>
		</table><?php echo "<div style='position:absolute;float: right;margin-left: 31px;margin-top: 12px;'><b>Total:</b>".mysqli_num_rows($result)."</div>";
	}elseif(($tb) =='bajas_aft'){ 
		$sqlz = "SELECT * FROM ".$tb.$Uactb;
		$result=mysqli_query($miConex, $sqlz) or die(mysqli_error($miConex)); ?>
		<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">	
			<tr> 
				<td><b><span>Inv.</span></b></td>
				<td><b><span><?php echo $btAreas;?></span></b></td>
				<td><b><span><?php echo $Fecha;?></span></b></td>
				<td><b><span><?php echo $btAprueba;?></span></b> </td>
				<td><b><span>&nbsp;&nbsp;<?php echo $DESCRIPCION1;?></span></b></td>
			    <td><b><span><?php echo $btdatosentidad3;?></span></b></td>				    
			</tr><?php
			while($rows=mysqli_fetch_array($result)){ $i++; 
				$sedge=mysqli_query($miConex, "SELECT entidad FROM datos_generales where id_datos='".$rows['idunidades']."'") or die(mysqli_error($miConex));
				$rsedge=mysqli_fetch_array($sedge); ?>
				<tr>
					<td width="73"><?php echo $rows['inv'];?></td>
					<td width="200"><?php echo $rows['idarea'];?></td>
					<td width="85"><?php echo $rows['fecha'];?></td>
					<td width="100"><?php if(!empty($rows['organo'])){ echo $rows['organo']; }else{ echo "<div align='center'>-</div>"; }?></td>
					<td width="158">&nbsp;&nbsp;<?php echo $rows['titulo'];?></td>
			    	<td width="212"><?php echo $rsedge['entidad'];?></td>						     
				</tr>  <?php
			} ?>
		</table><?php echo "<div style='position:absolute;float: right;margin-left: 31px;margin-top: 12px;'><b>Total:</b>".mysqli_num_rows($result)."</div>";
	}elseif(($tb) =='inspecciones'){ 
		$sqlz = "SELECT * FROM ".$tb.$Uactb;
		$result=mysqli_query($miConex, $sqlz) or die(mysqli_error($miConex)); ?>
		<TABLE width="100%" BORDER='0' align="center" cellpadding="3" cellspacing="3"> 
	 	 	<tr> 				
				<td width="92"><span><b><?php echo strtoupper($Fecha);?></b></span></td>
				<td width="109"><span><b><?php echo strtoupper($btestado);?></b></span></td>
				<td width="127"><span><b><?php echo $btORIGEN;?></b></span></td>
				<td width="144"><span><b><?php echo $btAreas1;?></b></span></td>
		        	<td width="218" align="left"><span><b><?php echo $btdatosentidad3;?></b></span></td>
	  		</tr><?php
			while($row=mysqli_fetch_array($result)){ 
				$seentid=mysqli_query($miConex, "SELECT entidad FROM datos_generales where id_datos='".$row["idunidades"]."'") or die(mysqli_error($miConex));
				$rseentid=mysqli_fetch_array($seentid);?>
				<tr>
					<td><?php echo $row["fecha"];?></td> 
					<td><?php echo $row["estado"];?></td>
					<td><?php echo $row["origen"];?></td>
					<td><?php echo $row["area"];?></td>
				    <td><?php echo $rseentid["entidad"];?></td>
				</tr><?php 			
			} ?>		
		</TABLE><?php echo "<div style='position:absolute;float: right;margin-left: 31px;margin-top: 12px;'><b>Total:</b>".mysqli_num_rows($result)."</div>";
	}elseif(($tb) =='sellos'){ 
		$sqlz = $query;
		$result=mysqli_query($miConex, $sqlz) or die(mysqli_error($miConex)); 
		$row=mysqli_fetch_array($result);
		?>
		<table width="<?php if ($row["estado"]!='Disponible') { echo "100%"; }else { echo "50%"; } ?>" border='0' align="center" cellpadding="2" cellspacing="2"> 
	 	 	<tr><?php if ($row["estado"]!= 'Disponible') { ?> 				
			    <td width="109"><span><b>INV</b></span></td>
	            <td width="209"><span><b>ACTIVO</b></span></td><?php } ?>
				<td width="109"><span><b>SELLO</b></span></td>
				<td width="127"><span><b>ESTADO</b></span></td><?php if ($row["estado"]!= 'Disponible') { ?>
				<td width="144"><span><b>OBSERV</b></span></td><?php } ?>
	  		</tr><?php
			while($row=mysqli_fetch_array($result)){ ?>
				<tr><?php if ($row["estado"]!='Disponible') { ?>
					<td><?php echo $row["inv"]; ?></td>
					<td><?php echo $row["descrip"]; ?></td><?php } ?>
					<td><?php echo $row["numero"];?></td>
					<td><?php echo $row["estado"];?></td><?php if ($row["estado"]!='Disponible') { ?>
					<td><?php echo $row["observ"];?></td><?php } ?>
				</tr><?php 			
			} ?>		
		</table><?php echo "<div style='position:absolute;float: right;margin-left: 31px;margin-top: 12px;'><b>Total:</b>".mysqli_num_rows($result)."</div>";
	}elseif(($tb) =='resoluciones'){ 
		$sqlz = "SELECT * FROM ".$tb;
		$result=mysqli_query($miConex, $sqlz) or die(mysqli_error($miConex)); ?>
		<table width="100%" border='0' align="center" cellpadding="3" cellspacing="3"> 
	 	 	<tr> 				
				<td><strong><span class="Estilo4"><?php echo $title3;?></span></strong></td>
				<td><strong><span class="Estilo4"><?php echo $DESCRIPCION;?></span></strong></td>
				<td><strong><span class="Estilo4"><?php echo $btorganoemi2;?></span></strong></td>
				<td><strong><span class="Estilo4"><?php echo strtoupper($Fecha);?></span></strong></td>
	  		</tr><?php
			while($row=mysqli_fetch_array($result)){ ?>
				<tr>
					<td width="275"><?php echo htmlentities($row['titulo']);?></td>
					<td width="402"><?php echo htmlentities($row['descripcion']);?></td>
					<td width="128"><?php echo $row['organo'];?></td>
					<td width="87"><?php echo $row['fecha'];?></td>
				</tr><?php 			
			} ?>		
		</table><?php 
	}elseif(($tb) =='defec'){ 
		if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$sqlz = "SELECT * FROM aft WHERE estado!='A' AND idunidades='".$_COOKIE['unidades']."'";
		}else{
			$sqlz = "SELECT * FROM aft WHERE estado!='A'";
		}
		
		$result=mysqli_query($miConex, $sqlz) or die(mysqli_error($miConex)); ?>
		<table width="100%" border="0" class="table" cellspacing="0" cellpadding="0">						
			<tr><td colspan="6"><b><?php echo strtoupper($btListado1);?></b><div>&nbsp;</div></td></tr>	
			<tr>									
				<td><span><b><strong>INV</b></span></td> 
				<td width="270"><span><b><strong><?php echo $DESCRIPCION;?></b></span></td> 
				<td width="116"><span><b><strong><?php echo $btAreas1;?></b></span></td> 
				<td width="105"><span><b><strong><?php echo $btMARCA;?></b></span></td> 
				<td width="122"><span><b><strong><?php echo $btMODELO;?></b></span></td> 
				<td width="163"><span><b><?php echo strtoupper($btdatosentidad3);?></b></span></td>								    
			</tr><?php
			while($row=mysqli_fetch_array($result)){ $i++;
				$sqlpertenece ="SELECT * FROM usuarios where nombre='".$row['custodio']."'";
				$resultpertenece= mysqli_query($miConex, $sqlpertenece) or die(mysqli_error($miConex));
				$rowresultpertenece=mysqli_fetch_array($resultpertenece);
				$sqlDG1=mysqli_query($miConex, "SELECT * FROM datos_generales where (id_datos ='".$row["idunidades"]."')") or die(mysqli_error($miConex)); 
				$sqlxDG1 = mysqli_fetch_array($sqlDG1);?>
				<tr>
					<td width="75"><?php echo $row["inv"];?></td>
					<td><?php echo $row["descrip"];?></td>
					<td><?php echo $row["idarea"];?></td>
					<td><?php echo $row["marca"];?></td>
					<td><?php echo $row["modelo"];?></td>
					<td><?php echo $sqlxDG1["entidad"];?></td></td>
				</tr>   <?php 								
			}  ?>								
		</table><?php 
	}elseif(($tb) =='inci'){ 		
		$gestorx = @fopen("../incidencias.irm", "r");
		if ($gestorx) { ?>
			<TABLE width="100%" BORDER='0' align="center" cellpadding="0" cellspacing="0"  class="table"> 
				<tr class="vistauser1">
					<td width="106"><span class="Estilo4"><b>INV.</b></span></td> 
					<td width="95"><span class="Estilo4"><b><?php echo strtoupper($Fecha);?></b></span></td>
					<td width="177"><span class="Estilo4"><b><?php echo $btAreas1;?></b></span></td>
					<td width="275"><span class="Estilo4"><b><?php echo strtoupper($Incidencias);?></b></span></td>
					<td width="224" align="left"><span class="Estilo4"><b><?php echo strtoupper($btdatosentidad3);?></b></span></td>
				</tr><?php
				while (!feof($gestorx)) {
					$bufer = fgets($gestorx, 4096);
					$explot = explode('*',$bufer);
					$seldg=mysqli_query($miConex, "SELECT * FROM datos_generales where id_datos='".trim($explot[4])."'") or die(mysqli_error($miConex));
					$redg = mysqli_fetch_array($seldg);  ?>
					<tr >
						<td><?php echo trim($explot[5]);?></td> 
						<td><?php echo trim($explot[1]);?></td> 
						<td><?php echo trim($explot[2]);?></td>
						<td><?php echo trim($explot[3]);?></td>
						<td><?php echo $redg['entidad'];?></td>
					</tr><?php 	
				} ?>
			</TABLE><?php
		}
		fclose ($gestorx);
	}elseif(($tb) =='aftt'){ 
		$sqlz = base64_decode($_GET['qr']);
		$result=mysqli_query($miConex, $sqlz) or die(mysqli_error($miConex)); ?>
		<table width="100%" BORDER="0" class="table" align="center" cellpadding="3" cellspacing="3">
			<tr> 
			  <td width="18"><b> </b></td>
			  <td width="111"><div align="center"><b><font color="black">INV.</font></b></div></td>
			  <td width="270"><div align="center"><b><font color="black"><?php echo $DESCRIPCION;?></font></b></div></td>
			  <td width="80"><b><font color="black"><?php echo strtoupper($btestado);?></font></b></td>
			  <td width="101"><div align="center"><b><font color="black"><?php echo $btAreas1;?></font></b></div></td>
			  <td width="64"><div align="center"><b><font color="black"><?php echo $btSELLO;?></font></b></div></td>
			  <td width="77"><div align="center"><b><font color="black"><?php echo $btMARCA;?></font></b></div></td>
			  <td width="59"><div align="center"><b><font color="black">SERIE</font></b></div></td>
			  <td width="91"><div align="center"><b><font color="black"><?php echo $btMODELO;?></font></b></div></td>
			  <td width="73"><div align="center"><b><font color="black">CATEG.</font></b></div></td>
			  <td width="65"><div align="center"><b><font color="black"><?php echo strtoupper($bttipo);?></font></b></div></td>
			  <td width="119"><div align="center"><b><font color="black"><?php echo strtoupper($bttipo)."-AFT";?></font></b></div></td>
			</tr><?php 	
			while($row=mysqli_fetch_array($result))    {	$i++; ?>
				<tr>
					<td>
						<div align="center"><?php 
							if((strtoupper($row["categ"])) =="COMPUTADORA" OR (strtoupper($row["categ"])) =="COMPUTADORAS" OR (strtoupper($row["categ"])) =="PC"){ ?>
								<img src="../images/pc.png" width="18" height="18" align="absmiddle"><?php 
							}?>				
						</div>
					</td>
					<td><div align="center"><?php  echo $row["inv"];?></div>					</td>
					<td> <?php  echo $row["descrip"];?></td>
					<td> <div align="center"><?php  echo $row["estado"];?></div></td>
					<td><?php  echo $row["idarea"];?></td>
					<td><div align="center"><?php  echo $row["sello"];?></div></td>
					<td ><?php  echo $row["marca"];?></td>
					<td ><?php  echo $row["no_serie"];?></td>
					<td ><?php  echo $row["modelo"];?></td>
					<td ><?php  echo $row["categ"];?></td>
					<td > <?php  echo $row["tipo"];?></td>
				  <td width="119" ><div align="center"><?php  echo $row["t_AFT"];?></div></td>
				</tr><?php
			}?>
		</table><?php 
	}	?>
<hr>
<div align="center"><?php include ("version1.php");?></div>
