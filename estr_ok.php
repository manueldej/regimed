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

if(isset($_POST['field_name'])){$field_name=$_POST['field_name'];}
if(isset($_POST['field_type'])){$field_type=$_POST['field_type'];}
if(isset($_POST['field_length'])){$field_length=$_POST['field_length'];}
if(isset($_POST['field_collation'])){$field_collation=$_POST['field_collation'];}
if(isset($_POST['field_null'])){$field_null=$_POST['field_null'];}
if(isset($_POST['field_extra'])){$field_extra=$_POST['field_extra'];}
if(isset($_POST['field_key'])){$field_key=$_POST['field_key'];}
if(isset($_POST['Primaria'])){$Primaria=$_POST['Primaria'];}
if(isset($_POST['tbl_type'])){$tbl_type=$_POST['tbl_type'];}
if(isset($_POST['nombre_tabla'])){$nombre_tabla=$_POST['nombre_tabla'];}
$bd= $database_miConex;
if(isset($_POST['campo'])){$campo=$_POST['campo'];}
if(isset($_POST['campo1'])){$campo1=$_POST['campo1'];}
if(isset($_POST['num_campo'])){$num_campo=$_POST['num_campo'];}
if(isset($_POST['new'])){$new=$_POST['new'];}
if(isset($_POST['orden'])){$orden=$_POST['orden'];}
if(isset($_POST['field_default'])){$field_default=$_POST['field_default'];}

mysql_select_db($bd);
$MainTableSql = "select * from ".$nombre_tabla;
$rsDA = mysqli_query($MainTableSql);
if((mysql_error($miConex)) !=""){
	$Mensaje = mysql_error($miConex);
	show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"optimizar.php","#026CAE",$bd);exit;	
}
	for($j=0; $j<$num_campo; $j++)	{
		if(($field_default[$j]) !=""){ $field_default[$j] = "DEFAULT '".$field_default[$j]."'"; }
		$field_length[$j] = str_replace ("-", "", $field_length[$j]);
		$char_seX = @explode("_", @$field_collation[$j]);
		$colla =$field_collation[$j];
		$char_se = $char_seX[0];
		$tipo_da_num = array('TINYINT', 'MEDIUMINT', 'SMALLINT', 'BIGINT', 'DECIMAL', 'FLOAT', 'DOUBLE', 'REAL', 'BIT', 'BOOLEAN', 'SERIAL', 'DATE', 'TEXT', 'TIME', 'TIMESTAMP', 'DATETIME', 'YEAR', 'POINT', 'GEOMETRY', 'POLYGON', 'MULTIPOLYGON', 'LINESTRING', 'MULTIPOINT', 'MULTILINESTRING', 'GEOMETRYCOLLECTION');

		$meta  = @mysql_fetch_field ($rsDA, $j);
		$flags = @mysql_field_flags ($rsDA, $j);
		if(($meta->primary_key) ==@$field_key[$j]){
			@$field_key[$j]="";
		}
		if((stristr ($flags, 'auto_increment')) !="" ){ $aut = "AUTO_INCREMENT";}
		
		if((@$new) =="new"){			
			if(($field_collation[$j]) ==""){ $field_collation[$j] ="latin1_swedish_ci"; $char_se = "latin1";}
			if((@$field_key[$j]) =="1" OR ($field_extra[$j]) =="AUTO_INCREMENT"){$firtx = " PRIMARY KEY";}else{ $firtx ="";}
			if(($orden[$j]) =="1"){ $firt = ""; }
			elseif(($orden[$j]) =="0"){ $firt = "FIRST"; }
			elseif(($orden[$j]) !="1" AND ($orden[$j]) !="0"){ $firt = 'AFTER `'.$orden[$j].'`'; }
			if(($field_extra[$j]) =="AUTO_INCREMENT"){
				$sql1 = 'ALTER TABLE `'.$nombre_tabla.'` ADD `'.trim($field_name[$j]).'` '.$field_type[$j].'('.str_replace ("\'", "'", $field_length[$j]).') '.$field_null[$j].' '.$field_default[$j].' '.$field_extra[$j].' '.$firtx.' '.$firt;
			}elseif (in_array ($field_type[$j], $tipo_da_num)){
				$sql1 = 'ALTER TABLE `'.$nombre_tabla.'` ADD `'.trim($field_name[$j]).'` '.$field_type[$j].' '.$field_null[$j].' '.$firt;
			}elseif(($field_type[$j]) =="INT" AND ($field_extra[$j]) !="AUTO_INCREMENT" AND ($field_length[$j]) !=""){
				$sql1 = 'ALTER TABLE `'.$nombre_tabla.'` ADD `'.trim($field_name[$j]).'` '.$field_type[$j].'('.str_replace ("\'", "'", $field_length[$j]).') '.$field_null[$j].' '.$field_default[$j].' '.$firt;
			}elseif(($field_type[$j]) =="INT" AND ($field_extra[$j]) !="AUTO_INCREMENT" AND ($field_length[$j]) ==""){
				$sql1 = 'ALTER TABLE `'.$nombre_tabla.'` ADD `'.trim($field_name[$j]).'` '.$field_type[$j].'  '.$field_null[$j].' '.$firt;
			}else{
				$sql1 = 'ALTER TABLE `'.$nombre_tabla.'` ADD `'.trim($field_name[$j]).'` '.$field_type[$j].'('.str_replace ("\'", "'", $field_length[$j]).') CHARACTER SET '.$char_se.' COLLATE '.$colla.' '.$field_null[$j].' '.$field_default[$j].' '.$field_extra[$j].' '.$firt.''; 
			}
				$r_crea1 = mysqli_query($sql1);
			if((mysql_error($miConex)) !=""){
				$Mensaje = mysql_error($miConex);
				show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"optimizar.php","#026CAE",$bd);exit;	
			}
		}else{
			if(($orden[$j]) =="1"){ $firt = ""; }
			elseif(($orden[$j]) =="0"){ $firt = "FIRST"; }
			elseif(($orden[$j]) !="1" AND ($orden[$j]) !="0"){ $firt = "AFTER `".$orden[$j]."`"; }

			if (in_array ($field_type[$j], $tipo_da_num)){
				$sql1 = 'ALTER TABLE `'.$nombre_tabla.'` CHANGE `'.$campo[$j].'` `'.trim($field_name[$j]).'` '.str_replace ("\'", "'", $field_type[$j]).' '.$field_null[$j].' '.$field_default[$j].' '.$firt;
			}elseif(($field_extra[$j]) =="AUTO_INCREMENT"){
				$sql1 = 'ALTER TABLE `'.$nombre_tabla.'` CHANGE `'.$campo[$j].'` `'.trim($field_name[$j]).'` '.str_replace ("\'", "'", $field_type[$j]).'('.str_replace ("\'", "'", $field_length[$j]).') '.$field_null[$j].' '.$field_default[$j].' '.$field_extra[$j].' '.$firt;
			}elseif(($field_type[$j]) =="INT" AND ($field_extra[$j]) !="AUTO_INCREMENT" AND ($field_length[$j]) ==""){
				$sql1 = 'ALTER TABLE `'.$nombre_tabla.'` CHANGE `'.$campo[$j].'` `'.trim($field_name[$j]).'` '.str_replace ("\'", "'", $field_type[$j]).'  '.$field_null[$j].' '.$field_default[$j].' '.$field_extra[$j].' '.$firt;
			}elseif(($field_type[$j]) =="INT" AND ($field_extra[$j]) !="AUTO_INCREMENT"){
				$sql1 = 'ALTER TABLE `'.$nombre_tabla.'` CHANGE `'.$campo[$j].'` `'.trim($field_name[$j]).'` '.str_replace ("\'", "'", $field_type[$j]).'('.str_replace ("\'", "'", $field_length[$j]).')  '.$field_null[$j].' '.$field_default[$j].' '.$field_extra[$j].' '.$firt;
			}else{
				$sql1 = 'ALTER TABLE `'.$nombre_tabla.'` CHANGE `'.$campo[$j].'` `'.trim($field_name[$j]).'` '.str_replace ("\'", "'", $field_type[$j]).'('.str_replace ("\'", "'", $field_length[$j]).') CHARACTER SET '.$char_se.' COLLATE '.$colla.' '.$field_null[$j].' '.$field_default[$j].' '.$field_extra[$j].' '.$firt;
			}
			$r_crea1 = mysqli_query($sql1);
			if((mysql_error($miConex)) !=""){
				$Mensaje = mysql_error($miConex);
				show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"optimizar.php","#026CAE",$bd);exit;	
			}
		
			if(($campo[$j]) ==trim($field_name[$j])){
				if(($field_extra[$j]) =="AUTO_INCREMENT"){
					$sqx = 'ALTER TABLE `'.$nombre_tabla.'` DROP PRIMARY KEY, ADD PRIMARY KEY ( `'.trim($field_name[$j]).'` )';			
					$rsqx = mysqli_query($sqx);
					if((mysql_error($miConex)) !=""){
						$Mensaje = mysql_error($miConex);
						show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"optimizar.php","#026CAE",$bd);exit;	
					}			
				}
			}
			if((@$field_key[$j]) =="1"){
				if(($meta->primary_key) ==1){
					$sq1 = 'ALTER TABLE `'.$nombre_tabla.'` DROP PRIMARY KEY';
					$rsq1 = mysqli_query($sq1);
					if((mysql_error($miConex)) !=""){
						$Mensaje = mysql_error($miConex);
						show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"optimizar.php","#026CAE",$bd);exit;	
					}
				}
			}  
			$r_crea1 = mysqli_query($sql1);
			if((mysql_error($miConex)) !=""){
				$Mensaje = mysql_error($miConex);
				show_message2($strerror,"<strong>".$strError1."</strong>",$Mensaje,"cancel",$strOK,"optimizar.php","#026CAE",$bd);exit;	
			}
		}
		@$queryx .=@$sql1.",\r\n";
	}
		if((stristr ($queryx, $bd)) =="" ){$queryx = str_ireplace("from ", "FROM ".$bd.".", $queryx);}else{ $queryx = str_ireplace("FROM", "FROM", $queryx); }
		$queryx = str_ireplace("select", "SELECT", $queryx);
		$queryx = str_ireplace("update", "UPDATE", $queryx);
		$queryx = str_ireplace("delete", "DELETE", $queryx);
		$queryx = str_ireplace("rename", "RENAME", $queryx);
		$queryx = str_ireplace("optimize", "OPTIMIZE", $queryx);
		$queryx = str_ireplace("repair", "REPAIR", $queryx);
		$queryx = str_ireplace("truncate", "TRUNCATE", $queryx);
		$queryx = str_ireplace("drop", "DROP", $queryx);
		$queryx = str_ireplace("count", "COUNT", $queryx);
		$queryx = str_ireplace("limit", "LIMIT", $queryx); ?>
	<script language="javascript">
			document.location="estruc.php?tb=<?php echo $nombre_tabla;?>";
	</script>