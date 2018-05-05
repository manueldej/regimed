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
include('clases.php');

$bd= $database_miConex;
if(isset($_POST['tb'])){$tb= $_POST['tb'];}
if(isset($_POST['marcado'])){$campo= $_POST['marcado'];}
$nombre_tabla = $tb;
$sql2 = "SHOW TABLE STATUS FROM ".$bd." LIKE '".$tb."'";
$db_info_result = mysqli_query($sql2);
if((mysql_error($miConex)) !=""){
	$Mensaje = mysql_error($miConex);
	show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
}
$tmp = mysqli_fetch_array($db_info_result);

$tot = count($campo);
$MainTableSql = "select * from ".$tb;
$rsDA = mysqli_query($MainTableSql);
if((mysql_error($miConex)) !=""){
	$Mensaje = mysql_error($miConex);
	show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
}

$fields = mysqli_num_fields($rsDA);
$rows   = mysqli_num_rows($rsDA);
//$ncpos = mysql_fetch_field($rsDA, 0);

		if(empty($campo)){
			$Mensaje = $plea1.$modificas."...";
			show_message21($strerror,"<strong>".$modificas." ".$regiss."</strong>",$Mensaje,"cancel",$strOK,"paginas.php","#026CAE",$bd,"get","11",$tb);exit;
		}
include('barra.php'); ?>
		<script language="JavaScript">
		function verif(){
			var emt =true;
			var ff=document.form1;	
			for (i=0;i<ff.elements.length;i++){
				if ((ff.elements[i].type=="text")&&(ff.elements[i].value=="")){
					if ((ff.elements[i].type=="text")&&(ff.elements[i].value=="")){
						if((ff.elements[i].name) =="field_default["+i+"]"){
							alert("<?php echo $falt1;?>: "+ff.elements[i].name);
							ff.elements[i].focus();
							return false;
						}
					}
				}
			}
		}
		</script>
		<div id="buscad">
		  <fieldset class='fieldset'><legend class='vistauserx'><?php echo $btdatabase.":&nbsp;<font color=red>".$bd."</font>&nbsp;&nbsp;".$tablasa.": <font color=red>".$tb."</font>&nbsp;&nbsp;&nbsp;&nbsp;(".$bteditar." ".$btCampo."s)";?></legend>
		  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
			<form method="post" action="estr_ok.php" name="form1" onsubmit="return verif();"> 
					<tr class="vistauser1"> 
					  <td width="15%"><span><b><?php echo strtoupper($btCampo);?></b></span></td>
					  <td width="13%"><span>&nbsp;&nbsp;&nbsp;<b><?php echo strtoupper($bttipo);?></b></span></td>
					  <td width="12%"><span><b><?php echo strtoupper($campos_para3);?><b/><font color="red"><strong>*<sup>1</sup></strong></font></span></td>
					  <td width="15%"><span>&nbsp;&nbsp;&nbsp;<b><?php echo strtoupper($nulo);?></b></span></td>
					  <td width="14%"><span>&nbsp;&nbsp;&nbsp;&nbsp;<b>EXTRA</b></span></td>
					  <td width="8%"><span><b><?php echo strtoupper($llave);?></b></span></td>
					  <td width="9%"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo strtoupper($motor);?></b></span></td>
					  <td width="14%"><span>&nbsp;&nbsp;&nbsp;<b><?php echo strtoupper($rden);?></b></span></td>
					</tr>
					<?php 
					$a=0;	
					while ($a<$tot) {
						$sw="select ".$campo[$a]." from ".$tb;
						$q_sw = mysqli_query($sw);
						if((mysql_error($miConex)) !=""){
							$Mensaje = mysql_error($miConex);
							show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
						}
							$type  = mysql_field_type  ($q_sw, 0);
							$name  = mysql_field_name  ($q_sw, 0);
							$len   = mysql_field_len   ($q_sw, 0);
							$flags = mysql_field_flags ($q_sw, 0);
							$meta = mysql_fetch_field($q_sw, 0);	
							//mysql_select_db("information_schema");
						$tamanocampo = "SHOW TABLE STATUS FROM ".$bd." LIKE '".$meta ->table."'";
						$qtamanocampo = mysqli_query($tamanocampo);
						$rtamanocampo = mysqli_fetch_assoc($qtamanocampo);
						$infe = "SHOW COLUMNS FROM ".$bd.".".$rtamanocampo['Name']." where Field = '".$meta ->name."'";
						$infe_query = mysqli_query($infe);
						if((mysql_error($miConex)) !=""){
							$Mensaje = mysql_error($miConex);
							show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;	
						}
						$infe_row = mysqli_fetch_assoc($infe_query);
						//mysql_select_db($bd);
						$Arr_tipo = array (	"M&Aacute;S COMUNES" => array("INT", "VARCHAR", "TEXT", "DATE"),
											"NUM&Eacute;RICOS"   => array("TINYINT", "SMALLINT", "MEDIUMINT", "INT", "BIGINT", "DECIMAL", "FLOAT", "DOUBLE", "REAL", "BIT", "BOOLEAN", "SERIAL"),
											"FECHAS Y TIEMPO"    => array("DATE", "DATETIME", "TIMESTAMP", "TIME", "YEAR"),
											"CADENAS"   		 => array("CHAR", "VARCHAR", "TYNITEXT", "TEXT", "MEDIUMTEXT", "LONGTEXT", "BINARY", "VARBINARY", "MEDIUMBLOB", "BLOB", "LONGBLOB", "ENUM", "SET"),
											"ESPACIALES"   		 => array("GEOMETRY", "POINT", "LINESTRING", "POLYGON", "MULTIPOINT", "MULTILINESTRING", "MULTIPOLYGON", "GEOMETRYCOLLECTION"));
						if((stristr ($infe_row['Type'], '(')) !="" ){
							$dto = strlen(stristr($infe_row['Type'], '('));
							$datoX=substr($infe_row['Type'],0,-$dto);//coges el resto 
						}else{
							$datoX = $infe_row['Type'];
						}?>
						<tr onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $i;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='';colorear('<?php echo $i;?>','#FFD784');"> 
						  <td valign="middle"><input class="boton" type="text" id="namev" name="field_name[<?php echo $a;?>]" size="10" value="<?php echo $campo[$a];?>" title="Campo" /></td>
							<td valign="middle">
								<select class="boton" name="field_type[<?php echo $a;?>]" id="typex" onchange="if (this.value == 'DATETIME') { document.getElementById('field_length[<?php echo $a;?>]').value='-' ; } else if (this.value == 'TIME') { document.getElementById('field_length[<?php echo $a;?>]').value='-' ; } else if (this.value == 'GEOMETRY') { document.getElementById('field_length[<?php echo $a;?>]').value='-' ; } else if (this.value == 'POINT') { document.getElementById('field_length[<?php echo $a;?>]').value='-' ; } else if (this.value == 'POLYGON') { document.getElementById('field_length[<?php echo $a;?>]').value='-' ; } else if (this.value == 'MULTIPOLYGON') { document.getElementById('field_length[<?php echo $a;?>]').value='-' ; } else if (this.value == 'LINESTRING') { document.getElementById('field_length[<?php echo $a;?>]').value='-' ; } else if (this.value == 'MULTIPOINT') { document.getElementById('field_length[<?php echo $a;?>]').value='-' ; } else if (this.value == 'MULTILINESTRING') { document.getElementById('field_length[<?php echo $a;?>]').value='-' ; } else if (this.value == 'GEOMETRYCOLLECTION') { document.getElementById('field_length[<?php echo $a;?>]').value='-' ; }">>
									<option value="<?php 	echo strtoupper($datoX);?>"><?php echo strtoupper($datoX); ?></option><?php
									foreach($Arr_tipo as $key => $val){
										echo '<optgroup label="'.$key.'">';
										for($i=0; $i<count($val); $i++){
											echo '<option value="'.$val[$i].'">'.$val[$i].'</option>';
										}
										echo "</optgroup>";
									}			?>
								</select>
						  </td>
							<td valign="middle"><input class="boton" type="text" id="field_length[<?php echo $a;?>]" name="field_length[<?php echo $a;?>]" size="8" value="<?php if((strtoupper($infe_row['Type'])) =="TEXT"){ echo "65535"; }elseif((strtoupper($rtamanocampo['Data_length'])) ==""  AND (strtoupper($infe_row['Type'])) =="INT"){ echo str_replace('(','',substr(strrchr ($infe_row['Type'], "("), 0, -1));}elseif((strtoupper($rtamanocampo['Data_length'])) ==""){ echo "-"; }else{echo str_replace('(','',substr(strrchr ($infe_row['Type'], "("), 0, -1));}?>"/>      </td>
							<td valign="middle">
								<select class="boton" name="field_null[<?php echo $a;?>]">
									<option value="<?php	  if(($meta->not_null) ==1){echo "NOT NULL";}  if(($meta->not_null) ==0){echo "default NULL";} ?>" ><?php if(($meta->not_null) ==1){echo "not null";} if(($meta->not_null) ==0){echo "null";}  ?></option>
									<option value="NOT NULL">not null</option>
									<option value="NULL">null</option>
								</select>
						  </td><?php 
								$colus = "SHOW COLUMNS FROM ".$bd.".".$tb." WHERE Field ='".$meta->name."'";
								$qcolus = mysqli_query($colus) or die(mysql_error($miConex));
								$rcolus = mysqli_fetch_array($qcolus); ?>
							<td valign="middle">
								<select class="boton" name="field_extra[<?php echo $a;?>]" id="field_extra[<?php echo $a;?>]">
									<option value="<?php if((stristr ($flags, 'auto_increment')) !="" ){echo "AUTO_INCREMENT";}?>"><?php if((stristr ($flags, 'auto_increment')) !="" ){ echo "auto_increment"; }?></option>
									<option value="AUTO_INCREMENT">auto_increment</option>
								</select>
						  </td>
							<td valign="middle"><input type="checkbox" name="field_key[<?php echo $a;?>]" value="1" title="Primaria" <?php if((stristr ($flags, 'primary_key')) =="primary_key" ){ echo "checked";}  ?> /></td>
							<td valign="middle">
								<select class="boton" name="tbl_type[<?php echo $a;?>]">
									<option value="<?php echo $tmp['Engine'];?>" selected="selected"><?php echo $tmp['Engine'];?></option><?php 
									$m = "SHOW ENGINES";
									$qm = mysqli_query($m);
									if((mysql_error($miConex)) !=""){

										$Mensaje = mysql_error($miConex);
										show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"paginas.php?id=2","#026CAE",$bd);exit;
									}
									while($rowcp=mysqli_fetch_array($qm)){
										if(($rowcp['Support']) !="NO"){ ?>
											<option  onMouseOver="this.style.cursor='pointer';" value="<?php echo strtolower($rowcp['Engine']);?>" title="<?php echo traduce($rowcp['Comment'],$_COOKIE["leng"])?>" <?php if(($rowcp['Engine']) =="MyISAM"){ echo ' selected="selected"'; }?>><?php echo $rowcp['Engine'];?></option><?php 
										} 
									} 
									mysql_select_db($bd); ?>
								</select>
						  </td>
							<td valign="middle">
								<select class="boton" name="orden[<?php echo $a;?>]">
									<option value="1"><?php echo $fina1;?></option>
									<option value="0"><?php echo $fina;?></option>
									<optgroup label="<?php echo $fina2;?>"><?php
										mysql_select_db($bd);
										$rest = mysqli_query($miConex, "SELECT * FROM ".$tb);
										$hay = @mysqli_num_fields($rest);
										$i=0;
										while ($i < mysqli_num_fields($rest)) {
											$tb_names = mysql_fetch_field ($rest, $i); ?>
											<option value="<?php  echo $tb_names->name;?>"><?php  echo $tb_names->name;?></option><?php   
											$i++;
										} ?>
									</optgroup>
								</select>
								<input id="field_default[<?php echo $a;?>]" type="hidden" name="field_default[<?php echo $a;?>]" value="<?php echo $rcolus['Default'];?>" />
								<input type="hidden" name="field_collation[<?php echo $a;?>]" id="field_collation[<?php echo $a;?>]" value="<?php echo $rtamanocampo['Collation'];?>">
						  </td>
						</tr>
								<input type="hidden" name="campo[<?php echo $a;?>]" value="<?php echo $campo[$a];?>" />
								<?php     	$a++;
					} ?>
				<tr>
					<td colspan="10" class="Estilo2">
					    <hr>
						<input type="submit" class="btn" name="grava" value="<?php echo $btaceptar;?>"/> 
						<input type="button" class="btn" name="cancel" value="<?php echo $btcancelar;?>" onclick="javascript:document.location='estruc.php?tb=<?php echo $tb;?>';"/>
						<input type="hidden" name="bd" value="<?php echo $bd;?>" /> <input type="hidden" name="num_campo" value="<?php echo $tot;?>" /> 
						<input type="hidden" name="nombre_tabla" value="<?php echo $nombre_tabla;?>" /> 
						<input type="hidden" name="campo1" value="<?php echo $campo;?>" />
					</td>
				</tr>
			</form>
		  </table>
</fieldset><br><?php include ("version.php");?>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>

