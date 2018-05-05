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
require("mensaje.php");
	function tamano($size,$digits) {
		$kb=1024; $mb=1024*$kb; $gb=1024*$mb; $tb=1024*$gb;
		if (($size==0)) { 
			return "0 Byte"; 
		}elseif ($size<$kb) { 
			return $size." Byte"; 
		}elseif ($size<$mb) { 
			return round($size/$kb,$digits)." Kb"; 
		}elseif ($size<$gb) { 
			return round($size/$mb,$digits)." Mb"; 
		}elseif ($size<$tb) { 
			return round($size/$gb,$digits)." Gb"; 
		}else { 
			return round($size/$tb,$digits)." Tb"; 
		}
	}
?>
<div id="cira"></div>
<?php
include('barra.php'); ?>
<div id="buscad">
<?php
 $p=0;	
 $sql = "SHOW TABLES FROM ".$database_miConex; 
 $result = mysqli_query($miConex, $sql);

if (!$result) {
    echo "DB Error, no se han podido listar las tablas\n";
    echo 'MySQL Error: '.mysql_error();
    exit;
}
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
	
    if(isset($_REQUEST["optim"])){
		if(isset($_REQUEST["marcado"])){$marcado = $_REQUEST["marcado"] ;}
		if(empty($marcado)){
			show_message($strerror,$plea1." ".$btoptimizar,"cancel","optimizar.php"); ?>
			  <br><hr width="70%" align="center">
				 <?php include ("version.php");
			exit;
		}else{ $optm="";
			 foreach ($marcado as $u) {
			   $sqloptm = "OPTIMIZE TABLE ".$database_miConex.".`".$u."`"; 
			   $reult = mysqli_query($miConex, $sqloptm) or die(mysql_error());
			   $optm .= $u.",";
			 }
			 $expl = explode(",",$optm);
			 $expl1="";
			 if((count($expl) >2)){
				$expl1 = $msgoptim1;
			 }else{
				$expl1 = sprintf($msgoptim,substr($optm,0,-1));
			}?>
			<script type="text/javascript">
				document.getElementById('cira').innerHTML='<div class="alert negro"><button class="close" style="top: 226px; right: 279px;" type="button" onclick="cierr1();">x</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo  strtoupper($btoptimizar);?></b></font></div><div align="center"><b><?php echo $expl1;?>.</b></div></div>';
			</script> <?php 			
		} 	 
    }
	if(isset($_REQUEST["repar"])){
			if(isset($_REQUEST["marcado"])){$marcado = $_REQUEST["marcado"] ;}
			if(empty($marcado)){
				show_message($strerror,$plea1." ".$btrepara,"cancel","optimizar.php"); ?>
				  <br><hr width="70%" align="center">
					<?php include ("version.php");
				exit;
			}else{ $optm1="";
				 foreach ($marcado as $u1) {
				   $sqloptm1 = "REPAIR TABLE ".$database_miConex.".`".$u1."`"; 
				   $reult1 = mysqli_query($miConex, $sqloptm1) or die(mysql_error());
				   $optm1 .= $u1.",";
				 }
				 $explq = explode(",",$optm1);
				 $expl1q="";
				 if((count($explq) >2)){
					$expl1q = $repara2;
				 }else{
					$expl1q = sprintf($repara1,substr($optm1,0,-1));
				}?>
				<script type="text/javascript">
					document.getElementById('cira').innerHTML='<div class="alert negro"><button class="close" style="top: 226px; right: 279px;" type="button" onclick="cierr1();">x</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo strtoupper($btrepara);?></b></font></div><div align="center"><b><?php echo $expl1q;?>.</b></div></div>';
				</script> <?php 			
			} 	 
	}		
		
?>
<fieldset class="fieldset">
<legend class="vistauserx"><img src="images/reparadb.png" width="25" height="25" border="0" align="absmiddle">
				<?php echo $SQLversion.": "."<font color=red>"; printf(mysql_get_server_info())."</font>";?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000000">
				<?php echo $btdatabase; ?>:&nbsp;</font><?php echo "<font color=red>".strtoupper($database_miConex); ?>

</legend>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    <form action="" method="post" name="frm1" id="frm1">
		<tr class="vistauser1"> 
		        <td width="20">
					<div id="cheque1" onClick="marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
					<div id="cheque2" onClick="desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
				</td>
				<td><span><b><?php echo $tb_bd;?>&nbsp;&nbsp;<?php echo @$resultcuenta; ?></b></span></td>
				<td align="center"><span ><b>&nbsp;<?php echo $btrecords; ?></b></span></td>
				<td align="center"><div align="center"><span ><b>&nbsp;<?php echo $motor; ?></b></span></div></td>
				<td ><div align="center"><span ><b>&nbsp;&nbsp;<?php echo $t_rfd; ?>&nbsp;(Bytes)</b></span></div></td> 
		        <td ><span >&nbsp;&nbsp;&nbsp;<b><?php echo $bteditar." ".$estructra3;?></b></span></td>
		</tr><?php  
		while ($row = mysqli_fetch_row($result)) { 
			$i++;
			$sqlcuenta = "SELECT COUNT(*) FROM ".$database_miConex.".$row[0]"; 
            $resultcuenta = mysqli_query($miConex, $sqlcuenta);
			$sqleschema ="SELECT * FROM information_schema.TABLES where TABLE_Schema = '".$database_miConex."' and Table_name='".$row[0]."' ORDER BY TABLE_CATALOG ASC   LIMIT 0, 5";
			$ressqleschema = mysqli_query($miConex, $sqleschema);
			$estet = mysqli_fetch_array ($ressqleschema);
			$suma1 = "SHOW TABLE STATUS FROM ".$database_miConex." LIKE '".$row[0]."'";
			$qsuma1 = mysqli_query($miConex, $suma1) or die (mysql_error());
			$rsuma1 = mysqli_fetch_assoc($qsuma1);
			@$sumatotal = @$sumatotal + $rsuma1['Data_length'];			
			while ($row1 = mysqli_fetch_row($resultcuenta)) { ?>
				<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="marca1(<?php echo $p;?>,'#ffffff')" onContextMenu="contextual(event,'<?php echo $row[0]?>');"> 
				    <td width="5"><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff'); " value="<?php echo $row[0]?>" style="cursor:pointer;" /></td>
					<td width="20%"> &nbsp;<?php echo $row[0]."\n"; ?> <input type="hidden" name="cant" size="4" value="<?php echo $p?>"></td> 
					<td width="10%"><div align="center"><?php echo $row1[0]."\n"; @$tr = @$tr+$row1[0];?></div> </td>
					<td width="19%"><div align="center"><?php echo $estet['ENGINE'];?> </div></td>
					<td width="8%" align="right"><div align="center"><?php echo tamano($rsuma1['Data_length'],2);?></div></td>
					<td width="38%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="estruc.php?tb=<?php echo $row[0];?>"><img src="images/b_props.png" width="16" height="16" title="<?php echo strtoupper($bteditar." ".$estructra3." ".$tablasa.": ").$row[0];?>" border="0"></a></td>
				</tr><?php 
			} $p++;
		} ?>
		<tr class="vistauser1">
			<td>&nbsp;</td>
			<td colspan="1"><span><b>TOTAL<?php echo @$totatabla; ?></b></span></td>
			<td><div align="center"><span><b><?php echo $tr; ?></b></span></div></td>
			<td><div align="center"></div></td>
			<td><div align="center"><span><b><?php echo tamano($sumatotal,2);?></b></span></div></td>
		    <td>&nbsp;</td>
		</tr>
	    <tr> 
		    <td colspan="6">&nbsp;</td>
		</tr>
		<tr> 
			<td height="28" colspan="6"> 
				<input name="bd" type="hidden" value="<?php echo $database_miConex; ?>"> 
				<input type="submit" class="btn" name="optim" onClick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$btoptimizar;?>','');" value="<?php echo $btoptimizar;?>"> 
				<input type="submit" class="btn" name="repar" onClick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$btrepara;?>','');" value="<?php echo $btrepara;?>">
			</td>
		</tr>
	</form>
</table>
</fieldset><font color="black"><br><?php include("version.php"); ?></font>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>