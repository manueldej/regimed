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
$bd=$database_miConex;
if(isset($_GET['tb'])){$tb= $_GET['tb'];}
$sql2 = $sql2 = "SHOW TABLE STATUS FROM ".$bd." LIKE '".$tb."'";
$db_info_result = mysqli_query($miConex, $sql2);
if((mysql_error($miConex)) !=""){
	$Mensaje = mysql_error($miConex);
	show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
}
$tmp = mysqli_fetch_array($db_info_result); 

	if(isset($_GET['anade'])){
		$nom_cap = $_GET['nomb'];
		$sqlx = 'SELECT '.$nom_cap.' FROM  '.$tb; 
		$info_result = mysqli_query($miConex, $sqlx);
		if((mysql_error($miConex)) !=""){
			$Mensaje = mysql_error($miConex);
			show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
		}
			$fields  = mysqli_fetch_field_direct ($info_result, 0); 
			$flags = $fields->flags;
			$metaa  = mysqli_fetch_field_direct ($info_result, 0); 
		if((stristr ($flags, 'primary_key')) =="primary_key" ){
			$sq = 'ALTER TABLE `'.$tb.'`  CHANGE `'.$nom_cap.'` `'.$nom_cap.'` INT(11) COLLATE utf8_general_ci NOT NULL';
			$rsq = mysqli_query($miConex, $sq);
			if((mysql_error($miConex)) !=""){
				$Mensaje = mysql_error($miConex);
				show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
			}
			$sq1 = 'ALTER TABLE `'.$tb.'`  ADD PRIMARY KEY ( `'.$nom_cap.'` ) ';
			$rsq1 = mysqli_query($miConex, $sq1);
			if((mysql_error($miConex)) !=""){
				$Mensaje = mysql_error($miConex);
				show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
			}
		}elseif((stristr ($flags, 'primary_key')) =="" ){
			if(($metaa->type) !="int"){
			 $Mensaje = sprintf($t_usuario, htmlspecialchars($metaa->name), htmlspecialchars($metaa->type));
			 show_message2($strerror,"<strong>".$add_k."</strong>",$Mensaje,"cancel",$strOK,"javascript:history.go(-1);","#026CAE","");exit;
			}
			$sq1 = 'ALTER TABLE `'.$tb.'`ADD PRIMARY KEY ( `'.$nom_cap.'` ) ';
			$rsq1 = mysqli_query($miConex, $sq1);
			if((mysql_errno($miConex)) =="1068"){
				$sq1 = 'ALTER TABLE `'.$tb.'`DROP PRIMARY KEY, ADD PRIMARY KEY ( `'.$nom_cap.'` ) ';
				$rsq1 = mysqli_query($miConex, $sq1);	
			}
		}
	}
	if(isset($_GET['aunico'])){
		$nom_cap = $_GET['nomb'];	
		$sqlx = 'SELECT '.$nom_cap.' FROM  '.$tb; 
		$info_result = mysqli_query($miConex, $sqlx);
		if((mysql_error($miConex)) !=""){
			$Mensaje = mysql_error($miConex);
			show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
		}
		
		$fields  = mysqli_fetch_field_direct($info_result, 0); 
		$flags = $fields->flags;
		if((stristr ($flags, 'unique_key')) !="unique_key" AND (stristr ($flags, 'auto_increment')) !="auto_increment"){
			$sq = 'ALTER TABLE `'.$tb.'` ADD UNIQUE (`'.$nom_cap.'`)';
			$rsq = mysqli_query($miConex, $sq);
			if((mysql_error($miConex)) !=""){
				$Mensaje = mysql_error($miConex);
				show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
			}
		}
	}
	if(isset($_GET['quita'])){
		$nom_cap = $_GET['nomb'];
		$sqlx = 'SELECT '.$nom_cap.' FROM  '.$tb; 
		$info_result = mysqli_query($miConex, $sqlx);
		if((mysql_error($miConex)) !=""){
			$Mensaje = mysql_error($miConex);
			show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
		}
		$fields  = mysqli_fetch_field_direct($info_result, 0); 
		$flags = $fields->flags;
		
			if((stristr ($flags, 'primary_key')) =="primary_key" ){
				$sq = 'ALTER TABLE `'.$tb.'`  CHANGE `'.$nom_cap.'` `'.$nom_cap.'` INT(11) COLLATE utf8_general_ci NOT NULL';
				$rsq = mysqli_query($miConex, $sq);
			if((mysql_error($miConex)) !=""){
				$Mensaje = mysql_error($miConex);
				show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
			}
				$sq1 = 'ALTER TABLE `'.$tb.'`  DROP PRIMARY KEY';
				$rsq1 = mysqli_query($miConex, $sq1);
			if((mysql_error($miConex)) !=""){
				$Mensaje = mysql_error($miConex);
				show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
			}
		}
	}
	if(isset($_GET['qunico'])){
		$nom_cap = $_GET['nomb'];
		$tbz = $_GET['tb'];
		//////  
		//mysql_select_db("information_schema");
		$infe = "SHOW COLUMNS FROM ".$bd.".".$tbz." where Field = '".$nom_cap."'";
		$infe_query = mysqli_query($miConex, $infe);
		if((mysql_error($miConex)) !=""){
			$Mensaje = mysql_error($miConex);
			show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
		}
		$infe_row = mysqli_fetch_assoc($infe_query);

		$sql2 = "SHOW TABLE STATUS FROM ".$bd." LIKE '".$tb."'";
		$db_info_result = mysqli_query($miConex, $sql2);
		if((mysql_error($miConex)) !=""){
			$Mensaje = mysql_error($miConex);
			show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
		}
		$tmp = mysqli_fetch_array($db_info_result);
		//////
		mysql_select_db($bd);
		$sqlx = 'SELECT '.$nom_cap.' FROM  '.$tb; 
		$info_result = mysqli_query($miConex, $sqlx);
		if((mysql_error($miConex)) !=""){
			$Mensaje = mysql_error($miConex);
			show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
		}
		$fields  = mysqli_fetch_field_direct ($info_result, 0); 
		$flags = $fields->flags;
		$metas  = mysqli_fetch_field_direct ($info_result, 0); 
			
		
		if((stristr ($flags, 'unique_key')) =="unique_key" AND ($metas->primary_key) ==0){
			$sq = 'ALTER TABLE `'.$tb.'`  CHANGE `'.$nom_cap.'` `'.$nom_cap.'` '.$infe_row['DATA_TYPE'].'('.$metas->max_length.')';
			echo $sq;
			$rsq = mysqli_query($miConex, $sq);
			if((mysql_error($miConex)) !=""){
				$Mensaje = mysql_error($miConex);
				show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
			}
		}
	}
$MainTableSql = "select * from ".$tb;

$rsDA = mysqli_query($miConex, $MainTableSql);

if((mysql_error($miConex)) !=""){
	$Mensaje = mysql_error($miConex);
	show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
}

$fields = mysqli_num_fields($rsDA);
$rows   = mysqli_num_rows($rsDA);
$ncpos = mysql_fetch_field($rsDA, 0);
?>
	<script type="text/javascript">
		var nav4 = window.Event ? true : false;
		function acceptNum(evt){	
			var key = nav4 ? evt.which : evt.keyCode;	
			return (key <= 13 || (key >= 48 && key <= 57));
		}
		function anade(nomb){
			document.location="paginas.php?id=11&tb=<?php echo $tb;?>&bd=<?php echo $bd;?>&anade=si&nomb=" + nomb;
		}
		function quita(nomb){
			document.location="paginas.php?id=11&tb=<?php echo $tb;?>&bd=<?php echo $bd;?>&quita=si&nomb=" + nomb;
		}
		function qunico(nomb){
			document.location="paginas.php?id=11&tb=<?php echo $tb;?>&bd=<?php echo $bd;?>&tb=<?php echo $tb;?>&qunico=si&nomb=" + nomb;
		}
		function aunico(nomb){
			if(confirm("<?php echo $seguro5;?>")){ 
				document.location="paginas.php?id=11&tb=<?php echo $tb;?>&bd=<?php echo $bd;?>&aunico=si&nomb=" + nomb;
			}
		}
	</script>
		<form onKeyUp="highlight(event)" onClick="highlight(event)" method="post" action="save/index.php" name="formy" target="_blank">
			<input name="query1" type="hidden" value="<?php echo $MainTableSqup;?>">
			<input name="bd" type="hidden" value="<?php echo $bd;?>">
			<input name="prim" type="hidden" value="s">
			<input name="rprim" type="hidden" value="n">
			<input name="tb" type="hidden" value="<?php echo $tb;?>">
		</form>
		<script language="javascript">
			function hacer(){
				document.formy.submit();
			}
		</script>
<?php include('barra.php'); ?>
		<div id="buscad">
<fieldset class='fieldset'><legend class='vistauserx'><?php echo $btdatabase.":&nbsp;<font color=red>".$bd."</font>&nbsp;&nbsp;".$tablasa.": <font color=red>".$tb."</font>&nbsp;&nbsp;&nbsp;&nbsp;(".$estructra3.")";?></legend>
	<table width='100%' border='0' cellspacing='0' cellpadding='0' class="table">
		<form id="frm1" name="frm1" method="post" action="edita_estruc.php" enctype="multipart/form-data">
			<tr class="vistauser1">
				<td width="40">
					<div id="cheque1" onClick="marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
					<div id="cheque2" onClick="desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
				</td> 
				<td><b><span class="Estilo4"><?php echo strtoupper($btCampo);?></span></b></td>
				<td><b><span class="Estilo4"><?php echo strtoupper($bttipo);?></span></b></td>
				<td><b><span class="Estilo4"><?php echo strtoupper($collat);?></span></b></td>
				<td><b><span class="Estilo4"><?php echo strtoupper($nulo);?></span></b></td>
				<td><b><span class="Estilo4">EXTRA</span></b></td>
				<td><b><span class="Estilo4"><?php echo strtoupper($llave);?></span></b></td>
				<td align="center"><b><span class="Estilo4"><?php echo strtoupper($motor);?></span></b></td>
			</tr><?php
			 $i=0;
			 $p=0;
				while ($i < $fields) {
					$fields  = mysqli_fetch_field_direct ($rsDA, $i); 
					$flags = $fields->flags;
					$name = $fields->name;
					$meta  = mysqli_fetch_field_direct ($rsDA, $i); 
					
					$infe = "SHOW COLUMNS FROM ".$bd.".".$meta ->table." WHERE Field = '".$meta ->name."'";
					$infe_query = mysqli_query($miConex, $infe);
					if((mysql_error($miConex)) !=""){
						$Mensaje = mysql_error($miConex);
						show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
					}
					$infe_row = mysqli_fetch_assoc($infe_query);
					$colla="SHOW TABLE STATUS FROM ".$bd." LIKE '".$meta ->table."'";
					$qcolla=mysqli_query($miConex, $colla) or die(mysql_error($miConex));
					$rcolla = mysqli_fetch_assoc($qcolla);?>
					<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="exped('<?php echo $name; ?>'); marca1(<?php echo $p;?>,'#ffffff')" onContextMenu="contextual(event,'<?php echo $name; ?>');"> 
				        <td width="5"><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff'); " value="<?php echo $name; ?>" style="cursor:pointer;" /></td>
						<td width='17%'><?php echo $name;?></td>
						<td width='14%'> <?php echo $infe_row['Type']; ?> </td>
						<td width='14%'> 
							<?php if(($rcolla['Collation']) ==""){ echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - "; }else{ echo $rcolla['Collation'];} ?>						  </td>
						<td width='7%'> 
						<?php 
						  if(($infe_row['Null']) =="NO"){ echo "No"; }
						  if(($infe_row['Null']) =="YES"){ echo $yes1; }
						  ?>
						</td>
						  <td width='13%'> <?php echo $infe_row['Extra'];?> </td> 
						  <td width='13%'> 
							<?php
							if(($infe_row['Key']) =="" ){ ?>
							&nbsp;&nbsp;<a href='javascript:anade("<?php echo $name;?>");'><img align='absmiddle' src='images/llave.png' border='0' name='llave' width='17' height='17' title='<?php echo $add_k;?>'></a> 
							<?php }
							else{ ?>
							&nbsp;&nbsp;<a href='javascript:quita("<?php echo $name;?>");'><img align='absmiddle' src='images/quita_llave.png' border='0' name='llave' width='17' height='17' title='<?php echo $quit.$llave;?>'></a> 
							<?php }
							if(($infe_row['Key']) =="" AND ($infe_row['Extra']) ==""){ ?>
							&nbsp;&nbsp;<a href='#'><img align='absmiddle' src='images/unico.png' border='0' name='llave' width='17' height='17' title='<?php echo $add_k1;?>' onclick='javascript:return aunico("<?php echo $name;?>");'></a> 
							<?php }
						  ?>						  </td>
						  <td width='18%' align="center"><?php echo $tmp['Engine'];?></td>
		  </tr>
						<?php
						$i++; $p++;
				}	?>
				<tr> 
				  <td colspan="8" valign='middle'>					 
					<hr>
					<input name="edita" type="submit" class="btn" value="<?php  echo $bteditar;?>" onClick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');" title="<?php echo $editamarca;?>...">
					<input type="button" class="btn" name="cancel" value="<?php echo $btcancelar;?>" onclick="javascript:document.location='optimizar.php';"/>	
					<input type="hidden" name="bd" value="<?php echo $bd;?>"/> <input type="hidden" name="tb" value="<?php echo $tb;?>"/> 
				  </td>
				</tr>
		</form> 
	</table>
</fieldset><br><?php include ("version.php");?>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>