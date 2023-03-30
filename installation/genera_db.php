<?php
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                		            #
# Version:  3.1.1                                                     				                        #
# Fecha:    01/06/2016 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada (IN MEMORIAM)							         		            #
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
if (!defined('PHP_VERSION_ID')) {
	$version = explode('.', PHP_VERSION);
	define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}
?>
<!DOCTYPE html>
<html lang="es"><?php
if(PHP_VERSION_ID < 50207 ){?>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php 
}else{ ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php 
}?>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <title>Registro de Medios - Instalador Web</title>
	<link rel="shortcut icon" href="../images/logo1.png" />
	<link rel="stylesheet" href="install.css" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {font-size: 14px}
.Estilo2 {
	color: #FF0000;
	font-weight: bold;
}

.important {
    color: #bb0000;
    background-color: #ffeeee;
    padding: 0 0.5em 0 0.5em;
}

p.important {
    border: 1px dotted #ff0000;
    padding: 0.5em;
}

p.footnote {
    margin: 0 5% 2px 7%;
    padding-top: 3em;
}

p.footnote:first-line {
    margin-left: -2%;
}
-->
</style>
</head>
<?php
	$seulang ="es";
	define( "_VALID_MOS", 1 );
	$DBhostname  = $_POST['DBhostname'];
	$DBuserName  = $_POST['DBuserName'];
	$DBpassword  = $_POST['DBpassword'];
	$DBname      = $_POST['DBname'];
	@$salva       = $_POST['salva'];
	$NombreAdmin = $_POST['NombreAdmin'];
	$LoginAdmin  = $_POST['LoginAdmin'];
	@$PassAdmin   = $_POST['PassAdmin'];
	@$CorreoAdmin = $_POST['CorreoAdmin'];
	@$sex = $_POST['sexo'];

	$entidad = $_POST['entidad'];
	$reup = $_POST['reup'];
	$sector = $_POST['sector'];
	$PROV = $_POST['provincia'];
	$smtp = $_POST['smtp'];
	$web = $_POST['web'];
	$salv="";
	$seulang = "es";
	
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){@$seulang="es"; }else{@$seulang="en";}
	}
	if((@$seulang) =="es"){include('../esp.php');} else { include('../eng.php');}	
	
	$upload_extensions = array(".png", ".jpg", ".gif", ".bmp", ".PNG", ".JPG", ".GIF", ".BMP");
	$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
	$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
	$pht = str_replace("/installation/","", $pht1);	
	
?>
<body>
   	<div id="wrapper">
		<div id="header">
			<div id="el sitio" align="center">
			<div align="center" <?php if (($seulang) =="es") { ?> class="Headeresp-jpeg" <?php }else {?>class="Headereng-jpeg" <?php }?>></div>
		</div>
	</div>

<div id="ctr" align="center">
	<div class="install">
	<h1><?php echo $preinstall; ?></h1>
<?php 
	$accion="";
	$miConex = mysqli_connect($DBhostname, $DBuserName, $DBpassword, "") or trigger_error(mysqli_error(),E_USER_ERROR);
	$k=0;
	$bf=0;
	$g=0;
	$cuentas=0;

	// obtener las tablas de la Base de Datos 
    function get_tables($miConex,$database_miConex, $u)	{
	  $result = array();
	  $res = mysqli_query($miConex, "SHOW TABLES FROM ".$database_miConex);
	  while($cRow = mysqli_fetch_array($res))
	  {
		$result[] = $cRow[0];
	  }
	   return $result[$u];
	}
	
	// Obtener listado de bases de datos 	
	function compruebaDB($DBhostname, $DBuserName, $DBpassword, $DBname) {		
		$mysqli = mysqli_init();
		$mysqli->real_connect($DBhostname, $DBuserName, $DBpassword,"");
		$resultx = mysqli_query($mysqli, "SHOW DATABASES");
		$b_names = Array();
		$existe='n';
		
			while ($row = mysqli_fetch_array($resultx)) { 
				$b_names = $row['Database'];					
				if($b_names == $DBname){
					$existe='s';
				}
			}
			
			if ($existe =='s') {				
				return true;
			}
			
			if ($existe =='n') {
				return false;
			}
		    
				  
		$mysqli->close();	
	}
	
	
	function populate_db( &$database, $sqlfile='sql.sql') {
		global $errors;

		$mqr = @get_magic_quotes_runtime();
		@set_magic_quotes_runtime(0);
		$query = fread( fopen( $sqlfile, 'r' ), filesize( $sqlfile ) );
		@set_magic_quotes_runtime($mqr);
		$pieces  = split_sql($query);

		for ($i=0; $i<count($pieces); $i++) {
			$pieces[$i] = trim($pieces[$i]);
			if(!empty($pieces[$i]) && $pieces[$i] != "#") {
				$database->setQuery( $pieces[$i] );
				if (!$database->query()) {
					$errors[] = array ( $database->getErrorMsg(), $pieces[$i] );
				}
			}
		}
	}

	// function para recortar el nombre del fichero.sql de la salva  
	function split_sql($sql) {
		$sql = trim($sql);
		$sql = @ereg_replace("\n#[^\n]*\n", "\n", $sql);

		$buffer = array();
		$ret = array();
		$in_string = false;

		for($i=0; $i<strlen($sql)-1; $i++) {
			if($sql[$i] == ";" && !$in_string) {
				$ret[] = substr($sql, 0, $i);
				$sql = substr($sql, $i + 1);
				$i = 0;
			}

			if($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\") {
				$in_string = false;
			}
			elseif(!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset($buffer[0]) || $buffer[0] != "\\")) {
				$in_string = $sql[$i];
			}
			if(isset($buffer[1])) {
				$buffer[0] = $buffer[1];
			}
			$buffer[1] = $sql[$i];
		}

		if(!empty($sql)) {
			$ret[] = $sql;
		}
		return($ret);
	}
	
	// function para salvar la base de datos 
	function salvar($i,$miConex,$DBname,$sql,$DBhostname,$DBuserName,$DBpassword){
	require_once( 'common.php' );
			if(($i) =="es"){
				include('../esp.php');
			}else{ 
				include('../eng.php');
			}
			$tbl=array();
			$tiem = time();
			if ((compruebaDB($DBhostname, $DBuserName, $DBpassword, $DBname) == true) OR (compruebaDB($DBhostname, $DBuserName, $DBpassword, "Salva_".$DBname) == true)){
				mysqli_select_db($miConex, $DBname);
				$seldg=mysqli_query($miConex, "select * from datos_generales where id_datos='1'") or die(mysqli_error());
				$rseldg = mysqli_fetch_array($seldg);
				$adtabla="esydat";
				$fecha= "salva_".$DBname;
				$roo = $_SERVER['DOCUMENT_ROOT'];
				$posicion = strripos($roo, "/");
				$ruta = substr($roo, 0, $posicion)."/tmp/"; 

				$arr_num=array("int", "real");
				$tiem = time();
				$total_tab=0; // sera el numero de tablas que traiga la base de datos
				
				//$resultlist = mysqli_list_tables($DBname); derogado en php 7.x
				$resultlist = mysqli_query($miConex, "SHOW TABLES FROM $DBname");
				$numfilas = @mysqli_num_rows($resultlist);
				
				
				while ($fila = mysqli_fetch_row($resultlist)) {
					$tb_names[$total_tab] = $fila[0];
					$tbl[]= $tb_names[$total_tab];
					$total_tab++;
				}

				// No funcional para php 8, derogado en php 7.x 
				// while (@$total_tab < $numfilas) {
					// $tb_names = mysqli_fetch_field_direct ($resultlist, $total_tab);
					
					// $tb_names[$total_tab] =  $tb_names->name;
					// $tbl[]= $tb_names[$total_tab];
						// $total_tab++;	
				// }						

				if($total_tab < 50) { 
					$step=1;
				}else{ 
					$step =Round((100/$total_tab),2);
				}
				$export=1;
				$paso=$step;

				$fp = fopen($ruta."/install.sql", "w");
				require ('clases3.php');
				$prog = new expcons();
				$prog->reset(1);

				if (($export==1)){
					// Creando el bloque de estructuras
					@$pasado=0;
					$todo="-- Datos generados con DBSiGeX\r\n-- Fecha: ".date('d-m-Y')."\r\n\r\n".$sql.";\r\nSET FOREIGN_KEY_CHECKS=0;\r\n";

					foreach($tbl AS $key=>$tabla)	{
						$prog->barra_prog ( $exptr1." ".$estructra3."s...");
						@$pasado=@$pasado+$paso;	
						$fi = "show create table ".$tabla;				
						$fiq = mysqli_query($miConex, $fi) or die(mysqli_error($miConex)); 												
						$fiq = mysqli_fetch_array($fiq);
						$o = $fiq[1];
						$fiche2= $o;
						$head="\r\n\r\n-- ".$estructra3.$dela.$tablasa."-> `".$tabla."`\r\n--\r\n";
						$todo.=@$head;
						$drop="DROP TABLE IF EXISTS ".chr(96).$tabla.chr(96)."; ".chr(10).chr(13);;
						$todo.=$drop;
						$todo.=$fiche2.';';
						
						$ff = "SELECT * FROM ".$tabla;
						$result=@mysqli_query($miConex, $ff);// or die(mysqli_error($miConex));
						$trows=@mysqli_num_rows($result);
						$fields = @mysqli_num_fields($result);
						$head="\r\n-- ".$exptr1.$dela.$tablasa."-> `".$tabla."`\r\n-- ".$totalrecord.": ".$trows."\r\n-- ----------------------------------- \r\n";
						$todo .=$head;
						$tt=$tabla;
						$i1=0;
						$dato1="";
						while ($i1 < $fields){
							$field1 = mysqli_fetch_field_direct ( $result, $i1);
							$flags1 = $field1->flags;
							$name1  = $field1->name;
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
							$prog->barra_prog ( $exptr1." ".$estructra3."s".$dela.$tablasa."-> <b><font color=red>".$tabla."</font></b>");
							@$pasado=@$pasado+$paso;	
							$datos="(";
							$datof= "";
							$dato ="";
							while ($i < $fields){
								$field = mysqli_fetch_field_direct ($result, $i);
								$flags = $field->flags;
								$name  = $field->name;
								$rempz = str_replace(chr(39),chr(39).chr(39),$row->$name);
								$dato=chr(39).$rempz.chr(39);		

								if(in_array($field->type,$arr_num)){										
									$dato=str_replace(chr(39),"",$dato);
								}
								if ($i < $fields-1) { $dato .=",";}
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
			$prog->barra_prog ( $copiando.$ficher."s...");
			copy($ruta."install.sql","../installation/".$fecha.".sql");
			$prog->barra_prog ( $exptr2." ".$ficher." .sql");
			$prog->comprim($fecha,".sql");	//
			$prog->barra_prog ( $exptr3."sql");
			$prog->barra_prog ( $exptr3);
			$prog->elimina($ruta."install.sql");
			copy("../installation/".$fecha.".zip","../salvas/".$fecha.".zip");
			$prog->elimina("../installation/".$fecha.".sql");
			$prog->elimina("../installation/".$fecha.".zip");
			$filePerms = '0777';
			$dirPerms  = '0777';
			$filemode = octdec($filePerms);
			$dirmode = octdec($dirPerms);
			$chmodOk = TRUE;
				if (!mosChmodRecursive('install.sql', $filemode, $dirmode)) {
					$chmodOk = FALSE;
				}
				if (!$chmodOk) {
					$chmod_report = 'Nota: Los permisos del directorio y de los archivos no han podido ser cambiados.<br />'.
									'Cambia los permisos de los archivos y directorios manualmente.';
				}	
			}						
	}
	
	function creasalva($miConex, $DBhostname, $DBuserName, $DBpassword, $DBname, $salva, $NombreAdmin, $LoginAdmin, $PassAdmin, $CorreoAdmin, $entidad, $reup, $sector, $PROV, $smtp, $salv,$web){
		@unlink("sql.sql");
		mysqli_select_db($miConex, $DBname);
		if(($salv) =="s"){
			if (compruebaDB($DBhostname, $DBuserName, $DBpassword, "salva_".$DBname) == true){
				$sql ="DROP DATABASE `salva_".$DBname."`";
				mysqli_query($miConex, $sql) or die(mysqli_error());			 
			}
			
			$sql="CREATE DATABASE `salva_".$DBname."` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci";
			mysqli_query($miConex, $sql);
						
			$sql="USE `salva_".$DBname."`";
			mysqli_query($miConex, $sql);
			salvar('es',$miConex, $DBname,$sql,$DBhostname,$DBuserName,$DBpassword); 
			$fichero="install.sql";
			include('clases2.php');
			$prog = new importar($miConex,$fichero,$DBname);			
		}
	}
    // Si solo es conectar a una base de datos existente.
 	if(isset($_POST['conectar'])){ 
		$resultx = @mysqli_query($miConex, "SHOW TABLES FROM ".$DBname) or die(mysqli_error());
			$i = 0;
			$estainc='n';
			while ($i < mysqli_num_rows($resultx)) {
				$tb_names[$i] = get_tables($miConex, $DBname, $i);
				if( $tb_names[$i] =="incidencias"){
					$estainc='s';
				}
				$i++;
			}
			
			$result= mysqli_query($miConex,"USE ".$DBname) or die(mysqli_error());
			
			if(($estainc) =="n"){
				$sqli="CREATE TABLE IF NOT EXISTS `incidencias` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `fecha` varchar(10) COLLATE utf8_bin NOT NULL,
						  `id_area` int(11) NOT NULL,
						  `incidencia` varchar(200) COLLATE utf8_bin NOT NULL,
						  `inv` varchar(100) COLLATE utf8_bin NOT NULL,
						  `idunidades` int(11) NOT NULL,
						  PRIMARY KEY (`id`),
						  KEY `id_area` (`id_area`),
						  KEY `idunidades` (`idunidades`)
						) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
				mysqli_query($miConex,$sqli);
				$sqlii = "ALTER TABLE `incidencias`
					  ADD CONSTRAINT `incidencias_ibfk_2` FOREIGN KEY (`idunidades`) REFERENCES `datos_generales` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE,
					  ADD CONSTRAINT `incidencias_ibfk_1` FOREIGN KEY (`id_area`) REFERENCES `areas` (`idarea`) ON DELETE CASCADE ON UPDATE CASCADE;";
				mysqli_query($miConex,$sqlii) or die(mysqli_error());
			}
			
			$result= mysqli_query($miConex,"select * from exp") or die(mysqli_error());
			$cantcampo = mysqli_num_fields($result);
			$existefuente =0;
			
			for($n=0; $n<$cantcampo; $n++){ 
				$name1 = mysqli_fetch_field_direct($result, $n);
				if(($name1->name) == "FUENTE"){ 
				   $existefuente = 1;
				}  
			}
			$resulti= mysqli_query($miConex, "select * from inspecciones") or die(mysqli_error());
			$cantcampoi = mysqli_num_fields($resulti);
			$existeorigen =0;
			$existearea =0;
			for($ni=0; $ni<$cantcampoi; $ni++){ 
				$name1i = mysqli_fetch_field_direct($resulti, $ni);
				if(($name1i->name) =="origen"){ $existeorigen =1;}  
				if(($name1i->name) =="area"){ $existearea =1;} 
			}
			
			//echo $existefuente;
			if(($existefuente) ==0){
				$sqlfuente="ALTER TABLE `".$DBname."`.`exp` ADD `FUENTE` VARCHAR(300) COLLATE utf8_bin NOT NULL AFTER `RED2`";
				$hecfuente = mysqli_query($miConex,$sqlfuente) or die(mysqli_error());
				
				$sqlfuente1="ALTER TABLE `".$DBname."`.`bajas_exp` ADD `FUENTE` VARCHAR(300) COLLATE utf8_bin NOT NULL AFTER `RED2`";
				$hecfuente1 = mysqli_query($miConex,$sqlfuente1) or die(mysqli_error());
			} 
			if(($existeorigen) ==0){			
				$sqlorig="ALTER TABLE `".$DBname."`.`inspecciones` ADD `origen` VARCHAR(100) COLLATE utf8_bin NOT NULL AFTER `observ`";
				$hecor = mysqli_query($miConex,$sqlorig) or die(mysqli_error());
			}
			if(($existearea) ==0){
				$sqlarea="ALTER TABLE `".$DBname."`.`inspecciones` ADD `area` VARCHAR(150) COLLATE utf8_bin NOT NULL AFTER `origen`";
				$hecarea = mysqli_query($miConex,$sqlarea) or die(mysqli_error());
			}
			if(isset($_POST['salva'])){	
				creasalva($miConex, $DBhostname, $DBuserName, $DBpassword, $DBname, $salva, $NombreAdmin, $LoginAdmin, $PassAdmin, $CorreoAdmin, $entidad, $reup, $sector, $PROV,$smtp,"s",$web);
		    } ?>
		<form method="post" action="install2.php" name="formx1">
			<input name="DBhostname" type="text" value="<?php echo $DBhostname;?>">
			<input name="DBuserName" type="text" value="<?php echo $DBuserName;?>">
			<input name="DBpassword" type="text" value="<?php echo $DBpassword;?>">
			<input name="DBname" type="text" value="<?php echo $DBname;?>">
			<input name="NombreAdmin" type="text" value="<?php echo $NombreAdmin;?>">
			<input name="LoginAdmin" type="text" value="<?php echo $LoginAdmin;?>">
			<input name="PassAdmin" type="text" value="<?php echo $PassAdmin;?>">
			<input name="CorreoAdmin" type="text" value="<?php echo $CorreoAdmin;?>">
			<input name="entidad" type="text" value="<?php echo $entidad;?>">
			<input name="reup" type="hidden" value="<?php echo $reup;?>">
			<input name="sector" type="hidden" value="<?php echo $sector;?>">
			<input name="sexo" type="hidden" value="<?php echo $sex;?>">
			<input name="provincia" type="hidden" value="<?php echo $PROV;?>">
			<input name="smtp" type="hidden" value="<?php echo $smtp;?>">
			<input name="web" type="hidden" value="<?php echo $web;?>">	
			<input name="conecta" type="hidden" value="s">
		</form>
		<script language="javascript">
			function hacer1(){
				document.formx1.submit();
			}
			hacer1()
		</script><?php 
	} ?>
	<form method="post" action="install1.php" name="formx2">
		<input name="DBhostname" type="hidden" value="<?php echo $DBhostname;?>">
		<input name="DBuserName" type="hidden" value="<?php echo $DBuserName;?>">
		<input name="DBpassword" type="hidden" value="<?php echo $DBpassword;?>">
		<input name="DBname" type="hidden" value="<?php echo $DBname;?>">
		<input name="NombreAdmin" type="hidden" value="<?php echo $NombreAdmin;?>">
		<input name="LoginAdmin" type="hidden" value="<?php echo $LoginAdmin;?>">
		<input name="PassAdmin" type="hidden" value="<?php echo $PassAdmin;?>">
		<input name="CorreoAdmin" type="hidden" value="<?php echo $CorreoAdmin;?>">
		<input name="entidad" type="hidden" value="<?php echo $entidad;?>">
		<input name="reup" type="hidden" value="<?php echo $reup;?>">
		<input name="sector" type="hidden" value="<?php echo $sector;?>">
		<input name="sexo" type="hidden" value="<?php echo $sex;?>">
		<input name="provincia" type="hidden" value="<?php echo $PROV;?>">
		<input name="smtp" type="hidden" value="<?php echo $smtp;?>">
		<input name="web" type="hidden" value="<?php echo $web;?>">
	</form>
<script language="javascript">
	function atras(){
		document.formx2.submit();
	}
</script>
<div class="form-block" align="justify"><strong><?php 
    
	if((!$miConex)){ ?>
		<img src="../images/cancel.png" width="40" height="36" align="absmiddle">&nbsp;&nbsp;<?php echo $errorcon;?> <a onClick="atras();" onMouseOver="this.style.cursor='pointer';"><?php echo $btverifique;?><div><?php	exit;
	}
         // Se muestra cuando comprueba que existe una base de datos con el nombre suministrado por el usuario. 
         if (compruebaDB($DBhostname, $DBuserName, $DBpassword, $DBname) == true) { ?>
			<img src="../images/warning.png" width="40" height="36" align="absmiddle">&nbsp;&nbsp;<strong><?php echo $pos_inf1; ?>.</strong><br>
		  	<form action="" method="post" name="form" id="form">
				<input type="hidden" name="DBhostname" value="<?php echo $DBhostname; ?>" />
				<input type="hidden" name="DBuserName" value="<?php echo $DBuserName; ?>" />
				<input type="hidden" name="DBpassword" value="<?php echo $DBpassword; ?>" />
				<input type="hidden" name="DBname" value="<?php echo $DBname; ?>" />
				<input name="NombreAdmin" type="hidden" value="<?php echo $NombreAdmin;?>">
				<input name="LoginAdmin" type="hidden" value="<?php echo $LoginAdmin;?>">
				<input name="PassAdmin" type="hidden" value="<?php echo $PassAdmin;?>">
				<input name="CorreoAdmin" type="hidden" value="<?php echo $CorreoAdmin;?>">
				<input name="entidad" type="hidden" value="<?php echo $entidad;?>">
				<input name="reup" type="hidden" value="<?php echo $reup;?>">
        			<input name="sector" type="hidden" value="<?php echo $sector;?>">
				<input name="provincia" type="hidden" value="<?php echo $PROV;?>">
        			<input name="smtp" type="hidden" value="<?php echo $smtp;?>">
				<input name="web" type="hidden" value="<?php echo $web;?>">
				<input name="sexo" type="hidden" value="<?php echo $sex;?>">
				<font color="#FF0000"><?php echo "&nbsp;&nbsp;&nbsp;".$scri_exp." <strong>-".$DBname."</strong>-".$yaExiste;?></font><br><br>
              	<strong>&iquest;<?php echo $btdesea;?>?</strong><br><br>
              <input class="btn" name="no" type="button" id="no" value="<?php echo $btcancelar;?>" onClick="atras();">&nbsp;<?php	
              if(($bf)==0 OR ($g) ==0){ ?>
			  <input class="btn" name="reemplazar" type="submit" id="quee" value="<?php echo $reemplazz;?>"> &nbsp;
			  <input class="btn" name="actualizar" type="submit" id="quee" value="<?php echo $upgrade;?>">
			  <input class="btn" name="conectar" type="submit" id="quee" value="<?php echo $conectarr;?>">
			  <?php } ?>
              <br><input name="salva" id="salva" type="checkbox" value="s" checked>&nbsp;<label for="salva"><?php echo $btcreasalva;?>: <strong><?php echo $DBname;?></strong></label><br><br><strong><font color="#FF0000"><?php echo $btadvierte;?>.</font></strong>
            </form>       	
		</div>
		<?php //exit;
		 } 
		
		// reemplazar para los que ya hayan instalado la aplicación y tengan datos 
		if(isset($_POST['reemplazar'])){
		
			if (compruebaDB($DBhostname, $DBuserName, $DBpassword, $DBname) == true) {
				if(isset($_POST['salva'])){
				$salv = "s";
					creasalva($miConex, $DBhostname, $DBuserName, $DBpassword, $DBname, $salva, $NombreAdmin, $LoginAdmin, $PassAdmin, $CorreoAdmin, $entidad, $reup, $sector, $PROV,$smtp,$salv,$web);
				}
				
				if((mysqli_select_db($miConex, $DBname))){
					$sql="DROP DATABASE `".$DBname."`";
					mysqli_query($miConex, $sql) or die(mysqli_error());
				}
				
				$sql="CREATE DATABASE `".$DBname."` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci";
				mysqli_query($miConex, $sql);
				
				$sql="USE `".$DBname."`";
				mysqli_query($miConex, $sql) or die(mysqli_error());			
				
				$sql ="CREATE TABLE IF NOT EXISTS `aft` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `id_area` int(11) NOT NULL,
					  `inv` varchar(15) NOT NULL,
					  `descrip` varchar(100) NOT NULL,
					  `estado` char(1) NOT NULL,
					  `idarea` varchar(100) NOT NULL,
					  `sello` varchar(20) NOT NULL,
					  `marca` varchar(50) NOT NULL,
					  `no_serie` varchar(50) NOT NULL,
					  `modelo` varchar(50) NOT NULL,
					  `categ` varchar(50) NOT NULL,
					  `tipo` varchar(70) NOT NULL,
					  `custodio` varchar(50) NOT NULL,
					  `t_AFT` varchar(3) NOT NULL,
					   `enred` varchar(1) default NULL,
					   `conect` varchar(10) default NULL,
					   `exp` varchar(11) default NULL,
					  `idunidades` int(11) NOT NULL,
					  PRIMARY KEY (`id`),
					  KEY `idunidades` (`idunidades`),
					  KEY `id_area` (`id_area`)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
				mysqli_query($miConex, $sql);
				
				///Crear tabla "sellos" 
				 $sql ="CREATE TABLE `sellos` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `numero` varchar(20) NOT NULL,
					  `estado` varchar(50) NOT NULL,
					  `observ` varchar(150) NOT NULL,
					  `idtalon` int(11) NOT NULL,
					  `inv` varchar(15) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				///Crear tabla "talones" 
				 $sql ="CREATE TABLE `talones` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `nombre` varchar(50) NOT NULL,
					  `fecha` date DEFAULT NULL,
					  `estado` varchar(150) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				$sql ="CREATE TABLE IF NOT EXISTS `bajas_aft` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `id_area` int(11) NOT NULL,
						  `titulo` varchar(200) NOT NULL,
						  `inv` varchar(15) NOT NULL,
						  `fecha` varchar(100) NOT NULL,
						  `idarea` varchar(150) NOT NULL,
						  `tiene` varchar(1) NOT NULL,
						  `link` varchar(150) NOT NULL,
						  `organo` varchar(200) NOT NULL,
						  `descrip` varchar(100) NOT NULL,
						  `estado` char(1) NOT NULL,
						  `sello` varchar(20) NOT NULL,
						  `marca` varchar(50) NOT NULL,
						  `no_serie` varchar(50) NOT NULL,
						  `modelo` varchar(50) NOT NULL,
						  `categ` varchar(50) NOT NULL,
						  `tipo` varchar(70) NOT NULL,
						  `custodio` varchar(50) NOT NULL,
						  `t_AFT` varchar(3) NOT NULL,
						  `idunidades` int(11) NOT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idunidades` (`idunidades`),
						  KEY `id_area` (`id_area`)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql);		
				
				$sql ="CREATE TABLE IF NOT EXISTS `historial_bajas` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `id_area` int(11) NOT NULL,
						  `titulo` varchar(200) NOT NULL,
						  `inv` varchar(15) NOT NULL,
						  `fecha` varchar(100) NOT NULL,
						  `idarea` varchar(150) NOT NULL,
						  `tiene` varchar(1) NOT NULL,
						  `link` varchar(150) NOT NULL,
						  `organo` varchar(200) NOT NULL,
						  `descrip` varchar(100) NOT NULL,
						  `estado` char(1) NOT NULL,
						  `sello` varchar(20) NOT NULL,
						  `marca` varchar(50) NOT NULL,
						  `no_serie` varchar(50) NOT NULL,
						  `modelo` varchar(50) NOT NULL,
						  `categ` varchar(50) NOT NULL,
						  `tipo` varchar(70) NOT NULL,
						  `custodio` varchar(50) NOT NULL,
						  `t_AFT` varchar(3) NOT NULL,
						  `idunidades` int(11) NOT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idunidades` (`idunidades`),
						  KEY `id_area` (`id_area`)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql);
				
				$sql="CREATE TABLE IF NOT EXISTS `bajas_exp` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `id_area` int(11) NOT NULL,
					  `idarea` varchar(100) CHARACTER SET utf8 NOT NULL,
					  `inv` varchar(15) COLLATE utf8_bin NOT NULL,
					  `CPU` varchar(600) COLLATE utf8_bin NOT NULL,
					  `PLACA` varchar(300) COLLATE utf8_bin NOT NULL,
					  `CHIPSET` varchar(300) COLLATE utf8_bin NOT NULL,
					  `MEMORIA` varchar(300) COLLATE utf8_bin NOT NULL,
					  `MEMORIA2` varchar(300) COLLATE utf8_bin NOT NULL,
					  `GRAFICS` varchar(300) COLLATE utf8_bin NOT NULL,
					  `DRIVE1` varchar(300) COLLATE utf8_bin NOT NULL,
					  `DRIVE2` varchar(300) COLLATE utf8_bin NOT NULL,
					  `DRIVE3` varchar(300) COLLATE utf8_bin NOT NULL,
					  `DRIVE4` varchar(300) COLLATE utf8_bin NOT NULL,
					  `SONIDO` varchar(300) COLLATE utf8_bin NOT NULL,
					  `RED` varchar(300) COLLATE utf8_bin NOT NULL,
					  `RED2` varchar(300) COLLATE utf8_bin NOT NULL,
					  `FUENTE` varchar(300) COLLATE utf8_bin NOT NULL,
					  `OS` varchar(300) COLLATE utf8_bin NOT NULL,
					  `custodio` varchar(50) COLLATE utf8_bin NOT NULL,
					  `n_PC` varchar(50) COLLATE utf8_bin NOT NULL,
					  `idunidades` int(11) DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `idunidades` (`idunidades`),
					  KEY `id_area` (`id_area`)
					) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
		        mysqli_query($miConex, $sql);	
				
				$sql= "CREATE TABLE IF NOT EXISTS `areas` (
							  `idarea` int(11) NOT NULL AUTO_INCREMENT,
							  `nombre` varchar(300) CHARACTER SET latin1 NOT NULL,
							  `teclado` int(11) NOT NULL DEFAULT '0',
							  `switch` int(11) NOT NULL DEFAULT '0',
							  `router` int(11) NOT NULL DEFAULT '0',
							  `modem` int(11) NOT NULL DEFAULT '0',
							  `computadoras` int(11) NOT NULL DEFAULT '0',
							  `adaptadores` int(11) NOT NULL DEFAULT '0',
							  `monitor` int(11) NOT NULL DEFAULT '0',
							  `ploter` int(11) NOT NULL DEFAULT '0',
							  `mouse` int(11) NOT NULL DEFAULT '0',
							  `impresora` int(11) NOT NULL DEFAULT '0',
							  `escanner` int(11) NOT NULL DEFAULT '0',
							  `camara` int(11) NOT NULL DEFAULT '0',
							  `memorias` int(11) NOT NULL DEFAULT '0',
							  `ups` int(11) NOT NULL DEFAULT '0',
							  `pinza` int(11) NOT NULL DEFAULT '0',
							  `bocinas` int(11) NOT NULL DEFAULT '0',
							  `datashow` int(11) NOT NULL DEFAULT '0',
							  `dataswitch` int(11) NOT NULL DEFAULT '0',
							  `fax` int(11) NOT NULL DEFAULT '0',
							  `fotocopiadora` int(11) NOT NULL DEFAULT '0',
							  `idunidades` int(11) NOT NULL DEFAULT '0',
						       PRIMARY KEY (`idarea`),
						       KEY `idunidades` (`idunidades`)
						)      ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;";
				mysqli_query($miConex, $sql);
				
				$sql="INSERT INTO `areas` VALUES (1,'Reparaciones',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1);";
				mysqli_query($miConex, $sql) or die(mysqli_error());
						
				$sql="DROP TABLE IF EXISTS `conectado`"; 
                mysqli_query($miConex, $sql);
				
				$sql= "CREATE TABLE `conectado` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `conectado` varchar(100) DEFAULT NULL,
					  `fecha` date DEFAULT NULL,
					  `hora` varchar(15) DEFAULT NULL,
					  `sexo` varchar(1) DEFAULT NULL,
					  `idunidades` int(11) NOT NULL,
					  PRIMARY KEY (`id`),
					  KEY `idunidades` (`idunidades`)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql);

				$sql="CREATE TABLE IF NOT EXISTS `buscador` (
					  `id` int(11) NOT NULL auto_increment,
					  `texto` varchar(100) character set utf8 default NULL,
					  `resultado` text character set utf8,
					  `link` text,
					  `tabla` text NOT NULL,
					  PRIMARY KEY  (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex,$sql);
				
				$sql = "CREATE TABLE IF NOT EXISTS `creditos` (
                       `id` int(11) NOT NULL AUTO_INCREMENT,
                       `creditos` text,
                        PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
                mysqli_query($miConex,$sql);
                $sql ="INSERT INTO `creditos` (id,creditos)  VALUES 
						(1,'<div>Para la creaci&oacute;n de esta herramienta se emplearon los siguientes programas y librer&iacute;as:</div>
<div align=justify><ol>
	<li><a href=\"http://www.php.net/\" target=\"_blank\">PHP Version 8.1.10, Linux </a></li>
				<li><a href=\"http://www.mysql.com\">MySQL Server 8.0.30</a></li>
				<li><a href=\"http://prototypejs.org\">prototype 1.7</a></li>
				<li><a href=\"http://jquery.com\">jquery</a></li>
				<li><a href=\"https://librosweb.es/libro/ajax/\">Ajax</a></li>
				<li><a href=\"http://twitter.github.io/bootstrap/\">bootstrap 3.0</a></li>
</ol><br />
Adem&aacute;s de la utilizaci&oacute;n de c&oacute;digos de:
<ol>
<li><a href=\"http://ckeditor.com/\" target=\"_blank\">CKEditor 4.1.2 (revision d6f1e0e)</a></li>
<li><a href=\"http://www.javascriptbank.com/popcalendar-33-script.html\" target=\"_blank\">Agenda file for CalendarXP 9.0</a></li>
</ol>
Registro de Medios Inform&aacute;ticos es un software&nbsp;(Freeware) con licencia <a href=\"../regimed/installation/gpl.html\" target=\"_blank\" title=\"Licencia GNU/GPL\">GNU/GPL</a>.&nbsp;</div>

<div align=justify>&nbsp;</div>

<div align=justify>
<div>Usted puede utilizar toda la informaci&oacute;n que en este Sitio aparece, siempre que mencione la fuente.</div>
</div>

<div align=justify>&nbsp;</div>

<div align=justify>
<div>Puede&nbsp;contactarnos a trav&eacute;s de nuestro E-Mail: <a href=\"email.php\">WebMaster</a></div>
</div>
						');
						";
				mysqli_query($miConex, $sql);
                 
                $sql="CREATE TABLE IF NOT EXISTS `datos_generales` (
						  `id_datos` int(11) NOT NULL AUTO_INCREMENT,
						  `entidad` varchar(100) CHARACTER SET utf8 NOT NULL,
						  `sector` varchar(50) CHARACTER SET utf8 NOT NULL,
						  `smtp` varchar(50) CHARACTER SET utf8 NOT NULL,
						  `web` varchar(150) NOT NULL,
						  `mail` varchar(50) CHARACTER SET utf8 NOT NULL,
						  `provincia` varchar(50) DEFAULT NULL,
						  `codigo` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id_datos`)
						) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql);
				
				$sql="INSERT INTO `datos_generales` VALUES (1,'".htmlentities($entidad)."','".$sector."','".$smtp."','".$web."','".$CorreoAdmin."','".htmlentities($PROV)."','".$reup."');";
				mysqli_query($miConex, $sql) or die(mysqli_error());		
				
				$sql="CREATE TABLE IF NOT EXISTS `exp` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `id_area` int(11) NOT NULL,
					  `idarea` varchar(100) CHARACTER SET utf8 NOT NULL,
					  `inv` varchar(15) COLLATE utf8_bin NOT NULL,
					  `CPU` varchar(600) COLLATE utf8_bin NOT NULL,
					  `PLACA` varchar(300) COLLATE utf8_bin NOT NULL,
					  `CHIPSET` varchar(300) COLLATE utf8_bin NOT NULL,
					  `MEMORIA` varchar(300) COLLATE utf8_bin NOT NULL,
					  `MEMORIA2` varchar(300) COLLATE utf8_bin NOT NULL,
					  `GRAFICS` varchar(300) COLLATE utf8_bin NOT NULL,
					  `DRIVE1` varchar(300) COLLATE utf8_bin NOT NULL,
					  `DRIVE2` varchar(300) COLLATE utf8_bin NOT NULL,
					  `DRIVE3` varchar(300) COLLATE utf8_bin NOT NULL,
					  `DRIVE4` varchar(300) COLLATE utf8_bin NOT NULL,
					  `SONIDO` varchar(300) COLLATE utf8_bin NOT NULL,
					  `RED` varchar(300) COLLATE utf8_bin NOT NULL,
					  `RED2` varchar(300) COLLATE utf8_bin NOT NULL,
					  `FUENTE` varchar(300) COLLATE utf8_bin NOT NULL,
					  `OS` varchar(300) COLLATE utf8_bin NOT NULL,
					  `custodio` varchar(50) COLLATE utf8_bin NOT NULL,
					  `n_PC` varchar(50) COLLATE utf8_bin NOT NULL,
					  `idunidades` int(11) DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `id_area` (`id_area`),
					  KEY `idunidades` (`idunidades`)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
				mysqli_query($miConex, $sql);
				
				$sql="CREATE TABLE `manuales` (
						  `id` int(11) NOT NULL auto_increment,
						  `manuales` text,
						  PRIMARY KEY  (`id`)
						) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql);

					$sql = "INSERT INTO `manuales` VALUES (1,'<p style=\"text-align: center\"><strong><img width=136 height=121 border=0 align=\"middle\" src=\"images/about.png\" /></strong></p>
								<p style=\"text-align: center;\"><strong>MANUAL DE USUARIO</strong></p>
									<table width=919 height=132 border=0 align=\"center\">
										<tbody>
											<tr>
												<td width=1012>
												<p style=\"text-align: justify;\">El presente manual de usuario, ha sido concebido en aras de lograr un eficaz funcionamiento de este sitio y aunque no abarca la totalidad del funcionamiento, si lo m&aacute;s escencial. A continuaci&oacute;n se relaciona una lista con los primeros pasos a seguir:</p>
												<p align=\"center\" style=\"text-align: justify;\"><strong><u>Para los que instalan en software por primeras vez:</u></strong></p>
												</td>
											</tr>
											<tr>
												<td height=84>
												<p style=\"text-align: justify;\">Al culminar el asistente de instalaci&oacute;n, el software asume que el usuario que ha acometido la instalaci&oacute;n ser&aacute; en lo sucesivo el administrador de este sitio e iniciar&aacute; una sesi&oacute;n de trabajo para los primeros pasos.&nbsp; Para ello debemos seguir la secuencia l&oacute;gica de creaci&oacute;n de los codificadores necesarios para el alta de nuestros medios inform&aacute;ticos.</p>
												</td>
											</tr>
										</tbody>
									</table>
									<p style=\"text-align: center;\">&nbsp;</p>
									<table width=934 cellspacing=2 cellpadding=2 border=0 align=\"center\">
										<tbody>
											<tr>
												<td width=30 valign=\"top\" style=\"text-align: justify;\">1</td>
												<td width=890>
												<div style=\"text-align: justify;\">Creaci&oacute;n de las &ldquo;<strong>&Aacute;reas de Responsabilidad&rdquo;. </strong>Son aquellos locales, unidades o departamentos en los cuales existan medios inform&aacute;ticos. Estas &aacute;reas funcionar&aacute;n como contenedores, logrando un control eficiente de los medios inform&aacute;ticos  por &aacute;reas de responsabilidad.</div>
												</td>
											</tr>
											<tr>
												<td valign=\"top\" style=\"text-align: justify;\">2</td>
												<td>
												<div style=\"text-align: justify;\">Crear los &quot;<strong>Usuarios del Sitio</strong>&quot;. No se trata de usuarios al azar, ni visitantes transitorios. Usuarios de este sitio, son considerados aquellas personas que tengan alg&uacute;n activo bajo su custodia, en tal sentido se le ha asignado la denominaci&oacute;n de <strong>custodios. </strong>Estos custodios pertenecen a un &aacute;rea de responsabilidad. No obstante el sistema ha creado un usuario donominado &quot;Invitado&quot;, que podr&aacute; ser utilizado por personal externo o interno de la entidad con la finalidad de realizar consultas, inspecciones u&nbsp; otro&nbsp; tipo de acci&oacute;n.</div>
												</td>
											</tr>
											<tr>
												<td valign=\"top\" style=\"text-align: justify;\">3</td>
												<td>
												<div style=\"text-align: justify;\">Crear las &quot;<strong>Categor&iacute;as de Medios.</strong>&quot; El sistema crea 20&nbsp; categor&iacute;as de medios inform&aacute;ticos, por lo general de las m&aacute;s gen&eacute;ricas y comunes, pero el usuario s&uacute;per-administrador de este sitio las podr&aacute; modificar y/o agregar seg&uacute;n sus necesidades muy particulares.</div>
												</td>
											</tr>
											<tr>
												<td valign=\"top\" style=\"text-align: justify;\">4</td>
												<td>
												<div style=\"text-align: justify;\">Crear los &quot;<strong>Talones de Sellos</strong>&quot;. Usted deber&aacute; crear un nuevo tal&oacute;n de sellos para el sellado posterior de sus activos. El consecutivo se generar&aacute; en correspondencia a su valor inicial y la cantidad especificada.</div>
												</td>
											</tr>
											<tr>
												<td valign=\"top\" style=\"text-align: justify;\">5</td>
												<td>
												<div style=\"text-align: justify;\">Dar el Alta de los Medios Inform&aacute;ticos. Se significa que el software tiene como principal objetivo: mostrar desde el &aacute;rea de responsabilidad los diferentes Expedientes que demandan los medios inform&aacute;ticos, pero en el caso particular de este software solo se ha contemplado expedientes para las Computadoras, los dem&aacute;s perif&eacute;ricos ser&aacute;n denominados accesorios y no llevar&aacute;n expediente.</div>
												</td>
											</tr>
											<tr>
												<td valign=\"top\" style=\"text-align: justify;\">&nbsp;</td>
												<td>
												<div align=\"center\"><a target=\"_blank\" href=\"Manual.pdf\">Desargar Manual de Usuario</a></div>
												</td>
											</tr>
										</tbody>
									</table>')";
				mysqli_query($miConex, $sql);

				$sql="CREATE TABLE IF NOT EXISTS `incidencias` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `fecha` varchar(10) COLLATE utf8_bin NOT NULL,
						  `id_area` int(11) NOT NULL,
						  `incidencia` varchar(200) COLLATE utf8_bin NOT NULL,
						  `inv` varchar(100) COLLATE utf8_bin NOT NULL,
						  `idunidades` int(11) NOT NULL,
						  PRIMARY KEY (`id`),
						  KEY `id_area` (`id_area`),
						  KEY `idunidades` (`idunidades`)
						) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
				mysqli_query($miConex, $sql);

				$sql="CREATE TABLE IF NOT EXISTS `inspecciones` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `fecha` varchar(11) COLLATE utf8_bin NOT NULL,
						  `estado` varchar(50) COLLATE utf8_bin NOT NULL,
						  `observ` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
						  `origen` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
						  `area` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
						  `idunidades` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idunidades` (`idunidades`)
						) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
				mysqli_query($miConex, $sql);
				
				$sql="CREATE TABLE IF NOT EXISTS `mtto` (
						  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
						  `inv` varchar(15) NOT NULL,
						  `fecha` varchar(10) NOT NULL,
						  `estado` varchar(20) DEFAULT NULL,
						  `idunidades` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idunidades` (`idunidades`)
						) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
										
				mysqli_query($miConex, $sql);
			
            	$sql="CREATE TABLE IF NOT EXISTS `plan_rep` (
						  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
						  `id_area` int(11) NOT NULL,
						  `inv` varchar(15) COLLATE utf8_bin NOT NULL,
						  `fecha` date NOT NULL,
						  `observ` varchar(100) COLLATE utf8_bin NOT NULL,
						  `idarea` varchar(100) COLLATE utf8_bin NOT NULL,
						  `custodio` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
						  `idunidades` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idunidades` (`idunidades`),
						  KEY `id_area` (`id_area`)
						) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
				mysqli_query($miConex, $sql);
				
				$sql="CREATE TABLE IF NOT EXISTS `preferencias` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `usuario` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
						  `salva` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
						  `pass` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
						  `visitas` varchar(11) CHARACTER SET utf8 DEFAULT NULL,
						  `columnas` int(2) NOT NULL DEFAULT '14',
						  `acceso` char(1) NOT NULL DEFAULT 's',
						  `busca` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
						  `idunidades` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idunidades` (`idunidades`)
						) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql);
                
				$sql="INSERT INTO `preferencias` VALUES (null,'".$LoginAdmin."','s','s',7,14,'s','s',1);";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				$sql="CREATE TABLE `provincia` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `nombre` varchar(250) DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql) or die(mysqli_error());

				$sql="INSERT INTO `provincia` (id,nombre)  VALUES 
					(1,'Pinar del R&iacute;o'),
					(2,'Ciudad Habana'),
					(3,'Mayabeque'),
					(4,'Artemisa'),
					(5,'Matanzas'),
					(6,'Cienfuegos'),
					(7,'Villa Clara'),
					(8,'Santi sp&iacute;ritus '),
					(9,'Ciego de &Aacute;vila '),
					(10,'Camag&uuml;ey'),
					(11,'Las Tunas'),
					(12,'Holgu&iacute;n'),
					(13,'Granma'),
					(14,'Santiago de Cuba'),
					(15,'Guant&aacute;namo'),
					(16,'Isla de la Juventud');";
				mysqli_query($miConex, $sql) or die(mysqli_error());				
				
				$sql="CREATE TABLE IF NOT EXISTS `reg_claves_soft` (
						  `id` int(10) unsigned NOT NULL,
						  `equipo` varchar(50) NOT NULL,
						  `software` varchar(150) NOT NULL,
						  `usuario` varchar(50) NOT NULL,
						  `login` varchar(50) NOT NULL,
						  `passwd` varchar(15) NOT NULL,
						  `idunidades` int(11) DEFAULT NULL
						) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=armscii8;";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				$sql="ALTER TABLE `reg_claves_soft`
						ADD PRIMARY KEY (`id`), ADD KEY `idunidades` (`idunidades`);";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				$sql="ALTER TABLE `reg_claves_soft`
					MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				$sql="CREATE TABLE `componentes` (
						  `id` int(11) NOT NULL,
						  `idexp` varchar(15) NOT NULL,
						  `nombre` varchar(150) NOT NULL,
						  `marca` varchar(150) NOT NULL,
						  `modelo` varchar(150) NOT NULL,
						  `no_serie` varchar(150) NOT NULL,
						  `fabricante` varchar(150) NOT NULL,
						  `capacidad` varchar(150) NOT NULL,
						  `tasa` varchar(150) NOT NULL,
						  `frecuencia` varchar(50) NOT NULL,
						  `cache` varchar(10) NOT NULL,
						  `rpm` varchar(10) NOT NULL,
						  `interfaz` varchar(4) NOT NULL,
						  `tipo` varchar(10) NOT NULL,
						  `cpuid` varchar(16) NOT NULL,
						  `cpucores` varchar(2) NOT NULL,
						  `cpulogicos` varchar(2) NOT NULL,
						  `socket` varchar(50) NOT NULL
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
					mysqli_query($miConex, $sql) or die(mysqli_error());			
					
				$sql="ALTER TABLE `componentes`
							ADD PRIMARY KEY (`id`);";
					mysqli_query($miConex, $sql) or die(mysqli_error());
					
				$sql="ALTER TABLE `componentes`
						MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;";
					mysqli_query($miConex, $sql) or die(mysqli_error());
					
				$sql="CREATE TABLE IF NOT EXISTS `reg_claves` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `id_area` int(11) NOT NULL,
					  `equipo` varchar(50) NOT NULL,
					  `login` varchar(50) NOT NULL,
					  `usuario` varchar(50) NOT NULL,
					  `setup` varchar(50) NOT NULL,
					  `sistema` varchar(50) NOT NULL,
					  `idarea` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
					  `idunidades` int(11) DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `idunidades` (`idunidades`),
					  KEY `id_area` (`id_area`)
					) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=armscii8;";
				mysqli_query($miConex, $sql);

				$sql="CREATE TABLE `tipos_aft` (
					  `id` int(3) unsigned NOT NULL auto_increment,
					  `categoria` varchar(50) NOT NULL,
					  `descrip` varchar(150) NOT NULL,
					  PRIMARY KEY  (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;";
				mysqli_query($miConex, $sql);
			   
			   $sql="INSERT INTO `tipos_aft` (`id`, `categoria`,`descrip`) VALUES
				(1, 'MB','Medios B&aacute;sicos'),
				(2, 'U/H','&Uacute;til/Herramientas'),
				(3, 'MC', 'Consumibles')";
				
				mysqli_query($miConex, $sql) or die(mysqli_error());

				$sql="CREATE TABLE `resoluciones` (
					  `id` int(11) NOT NULL auto_increment,
					  `titulo` varchar(200) character set utf8 default NULL,
					  `descripcion` text,
					  `tiene` varchar(1) character set utf8 default NULL,
					  `link` varchar(200) character set utf8 default NULL,
					  `organo` varchar(200) character set utf8 default NULL,
					  `fecha` varchar(100) character set utf8 default NULL,
					  PRIMARY KEY  (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql);
				
				$sql="CREATE TABLE `tipos_medios` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `nombre` varchar(50) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ";
				mysqli_query($miConex, $sql);
				
				$sql="INSERT INTO `tipos_medios` (`id`, `nombre`) VALUES
				(1, 'COMPUTADORAS'),
				(2, 'PLOTER'),
				(3, 'MOUSE'),
				(4, 'BOCINA'),
				(5, 'SWITCH'),
				(6, 'MODEM'),
				(7, 'ROUTER'),
				(8, 'CAMARA'),
				(9, 'ESCANNER'),
				(10, 'ADAPTADORES'),
				(11, 'UPS'),
				(12, 'IMPRESORA'),
				(13, 'MEMORIAS'),
				(14, 'PINZA'),
				(15, 'MONITOR'),
				(16, 'TECLADO'),
				(17, 'FAX'),
				(18, 'DATASWITCH'),
				(19, 'DATASHOW'),
				(20, 'FOTOCOPIADORA');";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				$sql="CREATE TABLE IF NOT EXISTS `traspasos` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `id_area` int(11) NOT NULL,
					  `fecha` varchar(30) NOT NULL,
					  `inv` varchar(15) NOT NULL,
					  `descrip` varchar(150) NOT NULL,
					  `motivo` text NOT NULL,
					  `origen` varchar(100) NOT NULL,
					  `destino` varchar(100) NOT NULL,
					  `idunidades` int(11) DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `idunidades` (`idunidades`),
					  KEY `id_area` (`id_area`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ";
				mysqli_query($miConex, $sql);
			
            	$sql="CREATE TABLE IF NOT EXISTS `usuarios` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `id_area` int(11) NOT NULL,
						  `nombre` varchar(50) NOT NULL,
						  `login` varchar(16) NOT NULL,
						  `passwd` tinytext NOT NULL,
						  `email` varchar(50) NOT NULL,
						  `cargo` varchar(50) NOT NULL,
						  `tipo` varchar(50) NOT NULL,
						  `idarea` varchar(250) NOT NULL,
						  `sexo` varchar(1) DEFAULT NULL,
						  `idunidades` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idunidades` (`idunidades`),
						  KEY `id_area` (`id_area`)
						) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2";
				mysqli_query($miConex, $sql);

				$sql="CREATE TABLE `visitas` (
						  `id` int(11) NOT NULL auto_increment,
						  `ip` varchar(100) default NULL,
						  `hora` varchar(15) default NULL,
						  `fecha` date NOT NULL,
						  `user` varchar(100) NOT NULL,
						  PRIMARY KEY  (`id`)
						) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
				
				mysqli_query($miConex, $sql);
				
				$sql="CREATE TABLE IF NOT EXISTS `upgrade` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `exp` varchar(11) NOT NULL,
						  `componente` varchar(150) NOT NULL,
						  `tipo` varchar(250) NOT NULL,
						  `remplazado_por` varchar(150) NOT NULL,
						  `fecha` date NOT NULL,
						  `n_pc` varchar(150) NOT NULL,
						  `idunidades` int(11) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45;";
					mysqli_query($miConex, $sql) or die(mysqli_error());
				
				?>
				<form method="post" action="install2.php" name="formx">
				<input name="DBhostname" type="hidden" value="<?php echo $DBhostname;?>">
				<input name="DBuserName" type="hidden" value="<?php echo $DBuserName;?>">
				<input name="DBpassword" type="hidden" value="<?php echo $DBpassword;?>">
				<input name="DBname" type="hidden" value="<?php echo $DBname;?>">
				<input name="NombreAdmin" type="hidden" value="<?php echo $NombreAdmin;?>">
				<input name="LoginAdmin" type="hidden" value="<?php echo $LoginAdmin;?>">
				<input name="PassAdmin" type="hidden" value="<?php echo $PassAdmin;?>">
				<input name="sexo" type="hidden" value="<?php echo $sex;?>">
				<input name="CorreoAdmin" type="hidden" value="<?php echo $CorreoAdmin;?>">
				<input name="entidad" type="hidden" value="<?php echo $entidad;?>">
				<input name="reup" type="hidden" value="<?php echo $reup;?>">
        			<input name="sector" type="hidden" value="<?php echo $sector;?>">
				<input name="provincia" type="hidden" value="<?php echo $PROV;?>">
        			<input name="smtp" type="hidden" value="<?php echo $smtp;?>">
				<input name="conecta" type="hidden" value="n">
				<input name="reemplazar" type="hidden">
				</form>
				<script language="javascript">
				function hacer(){
					document.formx.submit();
				}
				hacer();
				</script><?php
				agrega_relaciones($miConex);
			} 
		}	
			// Crear Base de Datos para instalaciones nuevas.	
			if (compruebaDB($DBhostname, $DBuserName, $DBpassword, $DBname) != true) {
				$sql="CREATE DATABASE `".$DBname."` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci";
				mysqli_query($miConex, $sql);
				
				$sql="USE `".$DBname."`";
				mysqli_query($miConex, $sql) or die(mysqli_error());			
				
				$sql ="CREATE TABLE IF NOT EXISTS `aft` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `id_area` int(11) NOT NULL,
					  `inv` varchar(15) NOT NULL,
					  `descrip` varchar(100) NOT NULL,
					  `estado` char(1) NOT NULL,
					  `idarea` varchar(100) NOT NULL,
					  `sello` varchar(20) NOT NULL,
					  `marca` varchar(50) NOT NULL,
					  `no_serie` varchar(50) NOT NULL,
					  `modelo` varchar(50) NOT NULL,
					  `categ` varchar(50) NOT NULL,
					  `tipo` varchar(70) NOT NULL,
					  `custodio` varchar(50) NOT NULL,
					  `t_AFT` varchar(3) NOT NULL,
					   `enred` varchar(1) default NULL,
					   `conect` varchar(10) default NULL,
					   `exp` varchar(11) default NULL,
					  `idunidades` int(11) NOT NULL,
					  PRIMARY KEY (`id`),
					  KEY `idunidades` (`idunidades`),
					  KEY `id_area` (`id_area`)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
				mysqli_query($miConex, $sql);
				
				///Crear tabla "sellos" 
				 $sql ="CREATE TABLE `sellos` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `numero` varchar(20) NOT NULL,
					  `estado` varchar(50) NOT NULL,
					  `observ` varchar(150) NOT NULL,
					  `idtalon` int(11) NOT NULL,
					  `inv` varchar(15) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				///Crear tabla "talones" 
				 $sql ="CREATE TABLE `talones` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `nombre` varchar(50) NOT NULL,
					  `fecha` date DEFAULT NULL,
					  `estado` varchar(150) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				$sql ="CREATE TABLE IF NOT EXISTS `bajas_aft` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `id_area` int(11) NOT NULL,
						  `titulo` varchar(200) NOT NULL,
						  `inv` varchar(15) NOT NULL,
						  `fecha` varchar(100) NOT NULL,
						  `idarea` varchar(150) NOT NULL,
						  `tiene` varchar(1) NOT NULL,
						  `link` varchar(150) NOT NULL,
						  `organo` varchar(200) NOT NULL,
						  `descrip` varchar(100) NOT NULL,
						  `estado` char(1) NOT NULL,
						  `sello` varchar(20) NOT NULL,
						  `marca` varchar(50) NOT NULL,
						  `no_serie` varchar(50) NOT NULL,
						  `modelo` varchar(50) NOT NULL,
						  `categ` varchar(50) NOT NULL,
						  `tipo` varchar(70) NOT NULL,
						  `custodio` varchar(50) NOT NULL,
						  `t_AFT` varchar(3) NOT NULL,
						  `idunidades` int(11) NOT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idunidades` (`idunidades`),
						  KEY `id_area` (`id_area`)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql);		
				
				$sql ="CREATE TABLE IF NOT EXISTS `historial_bajas` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `id_area` int(11) NOT NULL,
						  `titulo` varchar(200) NOT NULL,
						  `inv` varchar(15) NOT NULL,
						  `fecha` varchar(100) NOT NULL,
						  `idarea` varchar(150) NOT NULL,
						  `tiene` varchar(1) NOT NULL,
						  `link` varchar(150) NOT NULL,
						  `organo` varchar(200) NOT NULL,
						  `descrip` varchar(100) NOT NULL,
						  `estado` char(1) NOT NULL,
						  `sello` varchar(20) NOT NULL,
						  `marca` varchar(50) NOT NULL,
						  `no_serie` varchar(50) NOT NULL,
						  `modelo` varchar(50) NOT NULL,
						  `categ` varchar(50) NOT NULL,
						  `tipo` varchar(70) NOT NULL,
						  `custodio` varchar(50) NOT NULL,
						  `t_AFT` varchar(3) NOT NULL,
						  `idunidades` int(11) NOT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idunidades` (`idunidades`),
						  KEY `id_area` (`id_area`)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql);
				
				$sql="CREATE TABLE IF NOT EXISTS `bajas_exp` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `id_area` int(11) NOT NULL,
					  `idarea` varchar(100) CHARACTER SET utf8 NOT NULL,
					  `inv` varchar(15) COLLATE utf8_bin NOT NULL,
					  `CPU` varchar(600) COLLATE utf8_bin NOT NULL,
					  `PLACA` varchar(300) COLLATE utf8_bin NOT NULL,
					  `CHIPSET` varchar(300) COLLATE utf8_bin NOT NULL,
					  `MEMORIA` varchar(300) COLLATE utf8_bin NOT NULL,
					  `MEMORIA2` varchar(300) COLLATE utf8_bin NOT NULL,
					  `GRAFICS` varchar(300) COLLATE utf8_bin NOT NULL,
					  `DRIVE1` varchar(300) COLLATE utf8_bin NOT NULL,
					  `DRIVE2` varchar(300) COLLATE utf8_bin NOT NULL,
					  `DRIVE3` varchar(300) COLLATE utf8_bin NOT NULL,
					  `DRIVE4` varchar(300) COLLATE utf8_bin NOT NULL,
					  `SONIDO` varchar(300) COLLATE utf8_bin NOT NULL,
					  `RED` varchar(300) COLLATE utf8_bin NOT NULL,
					  `RED2` varchar(300) COLLATE utf8_bin NOT NULL,
					  `FUENTE` varchar(300) COLLATE utf8_bin NOT NULL,
					  `OS` varchar(300) COLLATE utf8_bin NOT NULL,
					  `custodio` varchar(50) COLLATE utf8_bin NOT NULL,
					  `n_PC` varchar(50) COLLATE utf8_bin NOT NULL,
					  `idunidades` int(11) DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `idunidades` (`idunidades`),
					  KEY `id_area` (`id_area`)
					) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
		        mysqli_query($miConex, $sql);	
				
				$sql= "CREATE TABLE IF NOT EXISTS `areas` (
							  `idarea` int(11) NOT NULL AUTO_INCREMENT,
							  `nombre` varchar(300) CHARACTER SET latin1 NOT NULL,
							  `teclado` int(11) NOT NULL DEFAULT '0',
							  `switch` int(11) NOT NULL DEFAULT '0',
							  `router` int(11) NOT NULL DEFAULT '0',
							  `modem` int(11) NOT NULL DEFAULT '0',
							  `computadoras` int(11) NOT NULL DEFAULT '0',
							  `adaptadores` int(11) NOT NULL DEFAULT '0',
							  `monitor` int(11) NOT NULL DEFAULT '0',
							  `ploter` int(11) NOT NULL DEFAULT '0',
							  `mouse` int(11) NOT NULL DEFAULT '0',
							  `impresora` int(11) NOT NULL DEFAULT '0',
							  `escanner` int(11) NOT NULL DEFAULT '0',
							  `camara` int(11) NOT NULL DEFAULT '0',
							  `memorias` int(11) NOT NULL DEFAULT '0',
							  `ups` int(11) NOT NULL DEFAULT '0',
							  `pinza` int(11) NOT NULL DEFAULT '0',
							  `bocinas` int(11) NOT NULL DEFAULT '0',
							  `datashow` int(11) NOT NULL DEFAULT '0',
							  `dataswitch` int(11) NOT NULL DEFAULT '0',
							  `fax` int(11) NOT NULL DEFAULT '0',
							  `fotocopiadora` int(11) NOT NULL DEFAULT '0',
							  `idunidades` int(11) NOT NULL DEFAULT '0',
						       PRIMARY KEY (`idarea`),
						       KEY `idunidades` (`idunidades`)
						)      ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;";
				mysqli_query($miConex, $sql);
				
				$sql="INSERT INTO `areas` VALUES (1,'Reparaciones',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1);";
				mysqli_query($miConex, $sql) or die(mysqli_error());
						
				$sql="DROP TABLE IF EXISTS `conectado`"; 
                mysqli_query($miConex, $sql);
				
				$sql= "CREATE TABLE `conectado` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `conectado` varchar(100) DEFAULT NULL,
					  `fecha` date DEFAULT NULL,
					  `hora` varchar(15) DEFAULT NULL,
					  `sexo` varchar(1) DEFAULT NULL,
					  `idunidades` int(11) NOT NULL,
					  PRIMARY KEY (`id`),
					  KEY `idunidades` (`idunidades`)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql);

				$sql="CREATE TABLE IF NOT EXISTS `buscador` (
					  `id` int(11) NOT NULL auto_increment,
					  `texto` varchar(100) character set utf8 default NULL,
					  `resultado` text character set utf8,
					  `link` text,
					  `tabla` text NOT NULL,
					  PRIMARY KEY  (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex,$sql);
				
				$sql = "CREATE TABLE IF NOT EXISTS `creditos` (
                       `id` int(11) NOT NULL AUTO_INCREMENT,
                       `creditos` text,
                        PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
                mysqli_query($miConex,$sql);
                $sql ="INSERT INTO `creditos` (id,creditos)  VALUES 
						(1,'<div>Para la creaci&oacute;n de esta herramienta se emplearon los siguientes programas y librer&iacute;as:</div>
<div align=justify><ol>
	<li><a href=\"http://www.php.net/\" target=\"_blank\">PHP Version 8.1.10</a></li>
				<li><a href=\"http://www.mysql.com\">MySQL Server 8.0.30</a></li>
				<li><a href=\"http://prototypejs.org\">prototype 1.7</a></li>
				<li><a href=\"http://jquery.com\">jquery</a></li>
				<li><a href=\"https://librosweb.es/libro/ajax/\">Ajax</a></li>
				<li><a href=\"http://twitter.github.io/bootstrap/\">bootstrap 3.0</a></li>
</ol><br />
Adem&aacute;s de la utilizaci&oacute;n de c&oacute;digos de:
<ol>
<li><a href=\"http://ckeditor.com/\" target=\"_blank\">CKEditor 5 (revision d6f1e0e)</a></li>
<li><a href=\"http://www.javascriptbank.com/popcalendar-33-script.html\" target=\"_blank\">Agenda file for CalendarXP 9.0</a></li>
</ol>
Registro de Medios Inform&aacute;ticos es un software&nbsp;(Freeware) con licencia <a href=\"../regimed/installation/gpl.html\" target=\"_blank\" title=\"Licencia GNU/GPL\">GNU/GPL</a>.&nbsp;</div>

<div align=justify>&nbsp;</div>

<div align=justify>
<div>Usted puede utilizar toda la informaci&oacute;n que en este Sitio aparece, siempre que mencione la fuente.</div>
</div>

<div align=justify>&nbsp;</div>

<div align=justify>
<div>Puede&nbsp;contactarnos a trav&eacute;s de nuestro E-Mail: <a href=\"email.php\">WebMaster</a></div>
</div>
						');
						";
				mysqli_query($miConex, $sql);
                 
                $sql="CREATE TABLE IF NOT EXISTS `datos_generales` (
						  `id_datos` int(11) NOT NULL AUTO_INCREMENT,
						  `entidad` varchar(100) CHARACTER SET utf8 NOT NULL,
						  `sector` varchar(50) CHARACTER SET utf8 NOT NULL,
						  `smtp` varchar(50) CHARACTER SET utf8 NOT NULL,
						  `web` varchar(150) NOT NULL,
						  `mail` varchar(50) CHARACTER SET utf8 NOT NULL,
						  `provincia` varchar(50) DEFAULT NULL,
						  `codigo` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id_datos`)
						) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql);
				
				$sql="INSERT INTO `datos_generales` VALUES (1,'".htmlentities($entidad)."','".$sector."','".$smtp."','".$web."','".$CorreoAdmin."','".htmlentities($PROV)."','".$reup."');";
				mysqli_query($miConex, $sql) or die(mysqli_error());		
				
				$sql="CREATE TABLE IF NOT EXISTS `exp` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `id_area` int(11) NOT NULL,
					  `idarea` varchar(100) CHARACTER SET utf8 NOT NULL,
					  `inv` varchar(15) COLLATE utf8_bin NOT NULL,
					  `CPU` varchar(600) COLLATE utf8_bin NOT NULL,
					  `PLACA` varchar(300) COLLATE utf8_bin NOT NULL,
					  `CHIPSET` varchar(300) COLLATE utf8_bin NOT NULL,
					  `MEMORIA` varchar(300) COLLATE utf8_bin NOT NULL,
					  `MEMORIA2` varchar(300) COLLATE utf8_bin NOT NULL,
					  `GRAFICS` varchar(300) COLLATE utf8_bin NOT NULL,
					  `DRIVE1` varchar(300) COLLATE utf8_bin NOT NULL,
					  `DRIVE2` varchar(300) COLLATE utf8_bin NOT NULL,
					  `DRIVE3` varchar(300) COLLATE utf8_bin NOT NULL,
					  `DRIVE4` varchar(300) COLLATE utf8_bin NOT NULL,
					  `SONIDO` varchar(300) COLLATE utf8_bin NOT NULL,
					  `RED` varchar(300) COLLATE utf8_bin NOT NULL,
					  `RED2` varchar(300) COLLATE utf8_bin NOT NULL,
					  `FUENTE` varchar(300) COLLATE utf8_bin NOT NULL,
					  `OS` varchar(300) COLLATE utf8_bin NOT NULL,
					  `custodio` varchar(50) COLLATE utf8_bin NOT NULL,
					  `n_PC` varchar(50) COLLATE utf8_bin NOT NULL,
					  `idunidades` int(11) DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `id_area` (`id_area`),
					  KEY `idunidades` (`idunidades`)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
				mysqli_query($miConex, $sql);
				
				$sql="CREATE TABLE `manuales` (
						  `id` int(11) NOT NULL auto_increment,
						  `manuales` text,
						  PRIMARY KEY  (`id`)
						) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql);

					$sql = "INSERT INTO `manuales` VALUES (1,'<p style=\"text-align: center\"><strong><img width=136 height=121 border=0 align=\"middle\" src=\"images/about.png\" /></strong></p>
								<p style=\"text-align: center;\"><strong>MANUAL DE USUARIO</strong></p>
									<table width=919 height=132 border=0 align=\"center\">
										<tbody>
											<tr>
												<td width=1012>
												<p style=\"text-align: justify;\">El presente manual de usuario, ha sido concebido en aras de lograr un eficaz funcionamiento de este sitio y aunque no abarca la totalidad del funcionamiento, si lo m&aacute;s escencial. A continuaci&oacute;n se relaciona una lista con los primeros pasos a seguir:</p>
												<p align=\"center\" style=\"text-align: justify;\"><strong><u>Para los que instalan en software por primeras vez:</u></strong></p>
												</td>
											</tr>
											<tr>
												<td height=84>
												<p style=\"text-align: justify;\">Al culminar el asistente de instalaci&oacute;n, el software asume que el usuario que ha acometido la instalaci&oacute;n ser&aacute; en lo sucesivo el administrador de este sitio e iniciar&aacute; una sesi&oacute;n de trabajo para los primeros pasos.&nbsp; Para ello debemos seguir la secuencia l&oacute;gica de creaci&oacute;n de los codificadores necesarios para el alta de nuestros medios inform&aacute;ticos.</p>
												</td>
											</tr>
										</tbody>
									</table>
									<p style=\"text-align: center;\">&nbsp;</p>
									<table width=934 cellspacing=2 cellpadding=2 border=0 align=\"center\">
										<tbody>
											<tr>
												<td width=30 valign=\"top\" style=\"text-align: justify;\">1</td>
												<td width=890>
												<div style=\"text-align: justify;\">Creaci&oacute;n de las &ldquo;<strong>&Aacute;reas de Responsabilidad&rdquo;. </strong>Son aquellos locales, unidades o departamentos en los cuales existan medios inform&aacute;ticos. Estas &aacute;reas funcionar&aacute;n como contenedores, logrando un control eficiente de los medios inform&aacute;ticos  por &aacute;reas de responsabilidad.</div>
												</td>
											</tr>
											<tr>
												<td valign=\"top\" style=\"text-align: justify;\">2</td>
												<td>
												<div style=\"text-align: justify;\">Crear los &quot;<strong>Usuarios del Sitio</strong>&quot;. No se trata de usuarios al azar, ni visitantes transitorios. Usuarios de este sitio, son considerados aquellas personas que tengan alg&uacute;n activo bajo su custodia, en tal sentido se le ha asignado la denominaci&oacute;n de <strong>custodios. </strong>Estos custodios pertenecen a un &aacute;rea de responsabilidad. No obstante el sistema ha creado un usuario donominado &quot;Invitado&quot;, que podr&aacute; ser utilizado por personal externo o interno de la entidad con la finalidad de realizar consultas, inspecciones u&nbsp; otro&nbsp; tipo de acci&oacute;n.</div>
												</td>
											</tr>
											<tr>
												<td valign=\"top\" style=\"text-align: justify;\">3</td>
												<td>
												<div style=\"text-align: justify;\">Crear las &quot;<strong>Categor&iacute;as de Medios.</strong>&quot; El sistema crea 20&nbsp; categor&iacute;as de medios inform&aacute;ticos, por lo general de las m&aacute;s gen&eacute;ricas y comunes, pero el usuario s&uacute;per-administrador de este sitio las podr&aacute; modificar y/o agregar seg&uacute;n sus necesidades muy particulares.</div>
												</td>
											</tr>
											<tr>
												<td valign=\"top\" style=\"text-align: justify;\">4</td>
												<td>
												<div style=\"text-align: justify;\">Crear los &quot;<strong>Talones de Sellos</strong>&quot;. Usted deber&aacute; crear un nuevo tal&oacute;n de sellos para el sellado posterior de sus activos. El consecutivo se generar&aacute; en correspondencia a su valor inicial y la cantidad especificada.</div>
												</td>
											</tr>
											<tr>
												<td valign=\"top\" style=\"text-align: justify;\">5</td>
												<td>
												<div style=\"text-align: justify;\">Dar el Alta de los Medios Inform&aacute;ticos. Se significa que el software tiene como principal objetivo: mostrar desde el &aacute;rea de responsabilidad los diferentes Expedientes que demandan los medios inform&aacute;ticos, pero en el caso particular de este software solo se ha contemplado expedientes para las Computadoras, los dem&aacute;s perif&eacute;ricos ser&aacute;n denominados accesorios y no llevar&aacute;n expediente.</div>
												</td>
											</tr>
											<tr>
												<td valign=\"top\" style=\"text-align: justify;\">&nbsp;</td>
												<td>
												<div align=\"center\"><a target=\"_blank\" href=\"Manual.pdf\">Desargar Manual de Usuario</a></div>
												</td>
											</tr>
										</tbody>
									</table>')";
				mysqli_query($miConex, $sql);

				$sql="CREATE TABLE IF NOT EXISTS `incidencias` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `fecha` varchar(10) COLLATE utf8_bin NOT NULL,
						  `id_area` int(11) NOT NULL,
						  `incidencia` varchar(200) COLLATE utf8_bin NOT NULL,
						  `inv` varchar(100) COLLATE utf8_bin NOT NULL,
						  `idunidades` int(11) NOT NULL,
						  PRIMARY KEY (`id`),
						  KEY `id_area` (`id_area`),
						  KEY `idunidades` (`idunidades`)
						) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
				mysqli_query($miConex, $sql);

				$sql="CREATE TABLE IF NOT EXISTS `inspecciones` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `fecha` varchar(11) COLLATE utf8_bin NOT NULL,
						  `estado` varchar(50) COLLATE utf8_bin NOT NULL,
						  `observ` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
						  `origen` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
						  `area` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
						  `idunidades` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idunidades` (`idunidades`)
						) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
				mysqli_query($miConex, $sql);
				
				$sql="CREATE TABLE IF NOT EXISTS `mtto` (
						  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
						  `inv` varchar(15) NOT NULL,
						  `fecha` varchar(10) NOT NULL,
						  `estado` varchar(20) DEFAULT NULL,
						  `idunidades` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idunidades` (`idunidades`)
						) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
										
				mysqli_query($miConex, $sql);
			
            	$sql="CREATE TABLE IF NOT EXISTS `plan_rep` (
						  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
						  `id_area` int(11) NOT NULL,
						  `inv` varchar(15) COLLATE utf8_bin NOT NULL,
						  `fecha` date NOT NULL,
						  `observ` varchar(100) COLLATE utf8_bin NOT NULL,
						  `idarea` varchar(100) COLLATE utf8_bin NOT NULL,
						  `custodio` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
						  `idunidades` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idunidades` (`idunidades`),
						  KEY `id_area` (`id_area`)
						) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
				mysqli_query($miConex, $sql);
				
				$sql="CREATE TABLE IF NOT EXISTS `preferencias` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `usuario` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
						  `salva` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
						  `pass` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
						  `visitas` varchar(11) CHARACTER SET utf8 DEFAULT NULL,
						  `columnas` int(2) NOT NULL DEFAULT '14',
						  `acceso` char(1) NOT NULL DEFAULT 's',
						  `busca` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
						  `idunidades` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idunidades` (`idunidades`)
						) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql);
                
				$sql="INSERT INTO `preferencias` VALUES (null,'".$LoginAdmin."','s','s',7,14,'s','s',1);";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				$sql="CREATE TABLE `provincia` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `nombre` varchar(250) DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql) or die(mysqli_error());

				$sql="INSERT INTO `provincia` (id,nombre)  VALUES 
					(1,'Pinar del R&iacute;o'),
					(2,'Ciudad Habana'),
					(3,'Mayabeque'),
					(4,'Artemisa'),
					(5,'Matanzas'),
					(6,'Cienfuegos'),
					(7,'Villa Clara'),
					(8,'Santi sp&iacute;ritus '),
					(9,'Ciego de &Aacute;vila '),
					(10,'Camag&uuml;ey'),
					(11,'Las Tunas'),
					(12,'Holgu&iacute;n'),
					(13,'Granma'),
					(14,'Santiago de Cuba'),
					(15,'Guant&aacute;namo'),
					(16,'Isla de la Juventud');";
				mysqli_query($miConex, $sql) or die(mysqli_error());				
				
				$sql="CREATE TABLE IF NOT EXISTS `reg_claves_soft` (
						  `id` int(10) unsigned NOT NULL,
						  `equipo` varchar(50) NOT NULL,
						  `software` varchar(150) NOT NULL,
						  `usuario` varchar(50) NOT NULL,
						  `login` varchar(50) NOT NULL,
						  `passwd` varchar(15) NOT NULL,
						  `idunidades` int(11) DEFAULT NULL
						) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=armscii8;";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				$sql="ALTER TABLE `reg_claves_soft`
						ADD PRIMARY KEY (`id`), ADD KEY `idunidades` (`idunidades`);";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				$sql="ALTER TABLE `reg_claves_soft`
					MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				$sql="CREATE TABLE `componentes` (
						  `id` int(11) NOT NULL,
						  `idexp` varchar(15) NOT NULL,
						  `nombre` varchar(150) NOT NULL,
						  `marca` varchar(150) NOT NULL,
						  `modelo` varchar(150) NOT NULL,
						  `no_serie` varchar(150) NOT NULL,
						  `fabricante` varchar(150) NOT NULL,
						  `capacidad` varchar(150) NOT NULL,
						  `tasa` varchar(150) NOT NULL,
						  `frecuencia` varchar(50) NOT NULL,
						  `cache` varchar(10) NOT NULL,
						  `rpm` varchar(10) NOT NULL,
						  `interfaz` varchar(4) NOT NULL,
						  `tipo` varchar(10) NOT NULL,
						  `cpuid` varchar(16) NOT NULL,
						  `cpucores` varchar(2) NOT NULL,
						  `cpulogicos` varchar(2) NOT NULL,
						  `socket` varchar(50) NOT NULL
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
					mysqli_query($miConex, $sql) or die(mysqli_error());			
					
				$sql="ALTER TABLE `componentes`
							ADD PRIMARY KEY (`id`);";
					mysqli_query($miConex, $sql) or die(mysqli_error());
					
				$sql="ALTER TABLE `componentes`
						MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;";
					mysqli_query($miConex, $sql) or die(mysqli_error());
					
				$sql="CREATE TABLE IF NOT EXISTS `reg_claves` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `id_area` int(11) NOT NULL,
					  `equipo` varchar(50) NOT NULL,
					  `login` varchar(50) NOT NULL,
					  `usuario` varchar(50) NOT NULL,
					  `setup` varchar(50) NOT NULL,
					  `sistema` varchar(50) NOT NULL,
					  `idarea` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
					  `idunidades` int(11) DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `idunidades` (`idunidades`),
					  KEY `id_area` (`id_area`)
					) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=armscii8;";
				mysqli_query($miConex, $sql);

				$sql="CREATE TABLE `tipos_aft` (
					  `id` int(3) unsigned NOT NULL auto_increment,
					  `categoria` varchar(50) NOT NULL,
					  `descrip` varchar(150) NOT NULL,
					  PRIMARY KEY  (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;";
				mysqli_query($miConex, $sql);
			   
			   $sql="INSERT INTO `tipos_aft` (`id`, `categoria`,`descrip`) VALUES
				(1, 'MB','Medios B&aacute;sicos'),
				(2, 'U/H','&Uacute;til/Herramientas'),
				(3, 'MC', 'Consumibles')";
				
				mysqli_query($miConex, $sql) or die(mysqli_error());

				$sql="CREATE TABLE `resoluciones` (
					  `id` int(11) NOT NULL auto_increment,
					  `titulo` varchar(200) character set utf8 default NULL,
					  `descripcion` text,
					  `tiene` varchar(1) character set utf8 default NULL,
					  `link` varchar(200) character set utf8 default NULL,
					  `organo` varchar(200) character set utf8 default NULL,
					  `fecha` varchar(100) character set utf8 default NULL,
					  PRIMARY KEY  (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql);
				
				$sql="CREATE TABLE `tipos_medios` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `nombre` varchar(50) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ";
				mysqli_query($miConex, $sql);
				
				$sql="INSERT INTO `tipos_medios` (`id`, `nombre`) VALUES
				(1, 'COMPUTADORAS'),
				(2, 'PLOTER'),
				(3, 'MOUSE'),
				(4, 'BOCINA'),
				(5, 'SWITCH'),
				(6, 'MODEM'),
				(7, 'ROUTER'),
				(8, 'CAMARA'),
				(9, 'ESCANNER'),
				(10, 'ADAPTADORES'),
				(11, 'UPS'),
				(12, 'IMPRESORA'),
				(13, 'MEMORIAS'),
				(14, 'PINZA'),
				(15, 'MONITOR'),
				(16, 'TECLADO'),
				(17, 'FAX'),
				(18, 'DATASWITCH'),
				(19, 'DATASHOW'),
				(20, 'FOTOCOPIADORA');";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				$sql="CREATE TABLE IF NOT EXISTS `traspasos` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `id_area` int(11) NOT NULL,
					  `fecha` varchar(30) NOT NULL,
					  `inv` varchar(15) NOT NULL,
					  `descrip` varchar(150) NOT NULL,
					  `motivo` text NOT NULL,
					  `origen` varchar(100) NOT NULL,
					  `destino` varchar(100) NOT NULL,
					  `idunidades` int(11) DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `idunidades` (`idunidades`),
					  KEY `id_area` (`id_area`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ";
				mysqli_query($miConex, $sql);
			
            	$sql="CREATE TABLE IF NOT EXISTS `usuarios` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `id_area` int(11) NOT NULL,
						  `nombre` varchar(50) NOT NULL,
						  `login` varchar(16) NOT NULL,
						  `passwd` tinytext NOT NULL,
						  `email` varchar(50) NOT NULL,
						  `cargo` varchar(50) NOT NULL,
						  `tipo` varchar(50) NOT NULL,
						  `idarea` varchar(250) NOT NULL,
						  `sexo` varchar(1) DEFAULT NULL,
						  `idunidades` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idunidades` (`idunidades`),
						  KEY `id_area` (`id_area`)
						) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2";
				mysqli_query($miConex, $sql);

				$sql="CREATE TABLE `visitas` (
						  `id` int(11) NOT NULL auto_increment,
						  `ip` varchar(100) default NULL,
						  `hora` varchar(15) default NULL,
						  `fecha` date NOT NULL,
						  `user` varchar(100) NOT NULL,
						  PRIMARY KEY  (`id`)
						) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
				
				mysqli_query($miConex, $sql);
				
				$sql="CREATE TABLE IF NOT EXISTS `upgrade` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `exp` varchar(11) NOT NULL,
						  `componente` varchar(150) NOT NULL,
						  `tipo` varchar(250) NOT NULL,
						  `remplazado_por` varchar(150) NOT NULL,
						  `fecha` date NOT NULL,
						  `n_pc` varchar(150) NOT NULL,
						  `idunidades` int(11) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45;";
					mysqli_query($miConex, $sql) or die(mysqli_error());
				
				?>
				<form method="post" action="install2.php" name="formx">
				<input name="DBhostname" type="hidden" value="<?php echo $DBhostname;?>">
				<input name="DBuserName" type="hidden" value="<?php echo $DBuserName;?>">
				<input name="DBpassword" type="hidden" value="<?php echo $DBpassword;?>">
				<input name="DBname" type="hidden" value="<?php echo $DBname;?>">
				<input name="NombreAdmin" type="hidden" value="<?php echo $NombreAdmin;?>">
				<input name="LoginAdmin" type="hidden" value="<?php echo $LoginAdmin;?>">
				<input name="PassAdmin" type="hidden" value="<?php echo $PassAdmin;?>">
				<input name="sexo" type="hidden" value="<?php echo $sex;?>">
				<input name="CorreoAdmin" type="hidden" value="<?php echo $CorreoAdmin;?>">
				<input name="entidad" type="hidden" value="<?php echo $entidad;?>">
				<input name="reup" type="hidden" value="<?php echo $reup;?>">
        			<input name="sector" type="hidden" value="<?php echo $sector;?>">
				<input name="provincia" type="hidden" value="<?php echo $PROV;?>">
        			<input name="smtp" type="hidden" value="<?php echo $smtp;?>">
				<input name="conecta" type="hidden" value="n">
				<input name="reemplazar" type="hidden">
				</form>
				<script language="javascript">
				function hacer(){
					document.formx.submit();
				}
				hacer();
				</script><?php
				agrega_relaciones($miConex);
			} 
							
			// se existe la base de datos y la version de php en la que se creo es menor a la 7.x, actualizar estructura.
			if(isset($_POST['actualizar']) AND (PHP_VERSION_ID < 50207)){

       			$sql="USE `".$DBname."`";
				mysqli_query($miConex, $sql) or die(mysqli_error());

				//Borrar campo "pop" de la tabla datos_generales
				
				$sql ="ALTER TABLE `datos_generales` DROP `pop`";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				//Agregar campo "provincia" después de "mail" en la tabla datos_generales
				$sql ="ALTER TABLE `datos_generales` ADD `provincia` VARCHAR(150) COLLATE utf8_bin NULL AFTER `mail`";
				mysqli_query($miConex, $sql) or die(mysqli_error());
								
				//Agregar campo "web" después de "smtp" en la tabla datos_generales
				$sql ="ALTER TABLE `datos_generales` ADD `web` VARCHAR(150) COLLATE utf8_bin NULL AFTER `smtp`";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				// Elimar campo "fecha_act" de la tabla "conectado" 				
				$sql ="ALTER TABLE `conectado` DROP `fecha_act`";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				//Crear campo "idunidades" de la tabla conectado
				$sql ="ALTER TABLE `conectado` ADD `idunidades` int(11) COLLATE utf8_bin NOT NULL AFTER `lang`";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				//Crear campo "idunidades" de la tabla traspasos
				$sql ="ALTER TABLE `traspasos` ADD `idunidades` int(11) COLLATE utf8_bin NOT NULL AFTER `destino`";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				//Agregar campo "idunidades" al final de la tabla "inspecciones"
				$sql ="ALTER TABLE `inspecciones` ADD `idunidades` int(11) NOT NULL AFTER `observ`";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
			
				//Agregar campo "idunidades" al final de la tabla "mtto"
				$sql ="ALTER TABLE `mtto` ADD `idunidades` int(11) COLLATE utf8_bin NOT NULL AFTER `estado`";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				//Agregar campo "custodio" al final de la tabla "plan_rep"
				$sql ="ALTER TABLE `plan_rep` ADD `custodio` int(11) COLLATE utf8_bin NOT NULL AFTER `idarea`";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				//Agregar campo "idunidades" al final de la tabla "plan_rep"
				$sql ="ALTER TABLE `plan_rep` ADD `idunidades` int(11) COLLATE utf8_bin NOT NULL AFTER `custodio`";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				//Agregar campo "idunidades" al final de la tabla "preferencias"
				$sql ="ALTER TABLE `preferencias` ADD `idunidades` int(11) COLLATE utf8_bin NOT NULL AFTER `busca`";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				//Agregar campo "idunidades" al final de la tabla "reg_claves"
				$sql ="ALTER TABLE `reg_claves` ADD `idunidades` int(11) COLLATE utf8_bin NOT NULL   AFTER `sistema`";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				//Borrar el registro 3 de la tabla "tipos_aft"
				$sql ="DELETE FROM $DBname.`tipos_aft` WHERE `tipos_aft`.`id` =3";
				      
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				//Actualizar registro de la tabla "tipos_aft"
				$sql ="UPDATE $DBname.`tipos_aft` SET `descrip` = 'Medios B&aacute;sicos ' WHERE `tipos_aft`.`id` =1;";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				////Actualizar registro de la tabla "tipos_aft"
				$sql ="UPDATE $DBname.`tipos_aft` SET `descrip` = '&Uacute;tiles/Herramientas' WHERE `tipos_aft`.`id` =2;";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				//Mover el campo mail después de web
                $sql ="ALTER TABLE `datos_generales` CHANGE `mail` `mail` VARCHAR(50) COLLATE utf8_bin NOT NULL   AFTER `web`";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				//Eliminar tabla 'unidades' 
				$sql ="DROP TABLE `unidades`";
				mysqli_query($miConex, $sql) or die(mysqli_error());
	
				//Camciar tamaño al campo "estado" de las tablas "aft"
				$sql ="ALTER TABLE `aft` CHANGE `estado` `estado` CHAR( 2 )  COLLATE utf8_general_ci NOT NULL";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				///Crear tabla "sellos" 
				 $sql ="CREATE TABLE `sellos` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `numero` varchar(20) NOT NULL,
					  `estado` varchar(50) NOT NULL,
					  `observ` varchar(150) NOT NULL,
					  `idtalon` int(11) NOT NULL,
					  `inv` varchar(15) NOT NULL,
					  PRIMARY KEY (`id`) COMMENT 'id'
					) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql) or die(mysqli_error()); 
				
				///Crear tabla "talones" 
				 $sql ="CREATE TABLE `talones` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `nombre` varchar(50) NOT NULL,
					  `fecha` date DEFAULT NULL,
					  `estado` varchar(150) NOT NULL,
					  PRIMARY KEY (`id`) COMMENT 'id'
					) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				//Crear tabla "bajas_aft" 
				$sql ="CREATE TABLE IF NOT EXISTS `bajas_aft` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `id_area` int(11) NOT NULL,
						  `titulo` varchar(200) NOT NULL,
						  `inv` varchar(15) NOT NULL,
						  `fecha` varchar(100) NOT NULL,
						  `idarea` varchar(150) NOT NULL,
						  `tiene` varchar(1) NOT NULL,
						  `link` varchar(150) NOT NULL,
						  `organo` varchar(200) NOT NULL,
						  `descrip` varchar(100) NOT NULL,
						  `estado` char(1) NOT NULL,
						  `sello` varchar(20) NOT NULL,
						  `marca` varchar(50) NOT NULL,
						  `no_serie` varchar(50) NOT NULL,
						  `modelo` varchar(50) NOT NULL,
						  `categ` varchar(50) NOT NULL,
						  `tipo` varchar(70) NOT NULL,
						  `custodio` varchar(50) NOT NULL,
						  `t_AFT` varchar(3) NOT NULL,
						  `idunidades` int(11) NOT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idunidades` (`idunidades`),
						  KEY `id_area` (`id_area`)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql);	
				
				//Crear tabla "historial_bajas" 
				$sql ="CREATE TABLE IF NOT EXISTS `historial_bajas` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `id_area` int(11) NOT NULL,
						  `titulo` varchar(200) NOT NULL,
						  `inv` varchar(15) NOT NULL,
						  `fecha` varchar(100) NOT NULL,
						  `idarea` varchar(150) NOT NULL,
						  `tiene` varchar(1) NOT NULL,
						  `link` varchar(150) NOT NULL,
						  `organo` varchar(200) NOT NULL,
						  `descrip` varchar(100) NOT NULL,
						  `estado` char(1) NOT NULL,
						  `sello` varchar(20) NOT NULL,
						  `marca` varchar(50) NOT NULL,
						  `no_serie` varchar(50) NOT NULL,
						  `modelo` varchar(50) NOT NULL,
						  `categ` varchar(50) NOT NULL,
						  `tipo` varchar(70) NOT NULL,
						  `custodio` varchar(50) NOT NULL,
						  `t_AFT` varchar(3) NOT NULL,
						  `idunidades` int(11) NOT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idunidades` (`idunidades`),
						  KEY `id_area` (`id_area`)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql);	
				
				///Crear tabla "bajas_exp" 
				 $sql ="CREATE TABLE IF NOT EXISTS `bajas_exp` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `id_area` int(11) NOT NULL,
						  `idarea` varchar(100) CHARACTER SET utf8 NOT NULL,
						  `inv` varchar(15) COLLATE utf8_bin NOT NULL,
						  `CPU` varchar(600) COLLATE utf8_bin NOT NULL,
						  `PLACA` varchar(300) COLLATE utf8_bin NOT NULL,
						  `CHIPSET` varchar(300) COLLATE utf8_bin NOT NULL,
						  `MEMORIA` varchar(300) COLLATE utf8_bin NOT NULL,
						  `MEMORIA2` varchar(300) COLLATE utf8_bin NOT NULL,
						  `GRAFICS` varchar(300) COLLATE utf8_bin NOT NULL,
						  `DRIVE1` varchar(300) COLLATE utf8_bin NOT NULL,
						  `DRIVE2` varchar(300) COLLATE utf8_bin NOT NULL,
						  `DRIVE3` varchar(300) COLLATE utf8_bin NOT NULL,
						  `DRIVE4` varchar(300) COLLATE utf8_bin NOT NULL,
						  `SONIDO` varchar(300) COLLATE utf8_bin NOT NULL,
						  `RED` varchar(300) COLLATE utf8_bin NOT NULL,
						  `RED2` varchar(300) COLLATE utf8_bin NOT NULL,
						  `FUENTE` varchar(300) COLLATE utf8_bin NOT NULL,
						  `OS` varchar(300) COLLATE utf8_bin NOT NULL,
						  `custodio` varchar(50) COLLATE utf8_bin NOT NULL,
						  `n_PC` varchar(50) COLLATE utf8_bin NOT NULL,
						  `idunidades` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idunidades` (`idunidades`),
						  KEY `id_area` (`id_area`)
						) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				///Crear tabla "sellos" 
				 $sql ="CREATE TABLE `sellos` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `numero` varchar(20) NOT NULL,
					  `estado` varchar(50) NOT NULL,
					  `observ` varchar(150) NOT NULL,
					  `idtalon` int(11) NOT NULL,
					  `inv` varchar(15) NOT NULL,
					  PRIMARY KEY (`id`) COMMENT 'id'
					) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				///Crear tabla "talones" 
				 $sql ="CREATE TABLE `talones` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `nombre` varchar(50) NOT NULL,
					  `fecha` date DEFAULT NULL,
					  `estado` varchar(150) NOT NULL,
					  PRIMARY KEY (`id`) COMMENT 'id'
					) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;";
				mysqli_query($miConex, $sql) or die(mysqli_error());
				
				//Crear tabla "provincia"
				$sql="CREATE TABLE `provincia` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `nombre` varchar(250) DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;";
				 
				  mysqli_query($miConex, $sql) or die(mysqli_error());

					$sql="INSERT INTO `provincia` (id,nombre)  VALUES 
						(1,'Pinar del R&iacute;o'),
						(2,'Ciudad Habana'),
						(3,'Mayabeque'),
						(4,'Artemisa'),
						(5,'Matanzas'),
						(6,'Cienfuegos'),
						(7,'Villa Clara'),
						(8,'Santi sp&iacute;ritus '),
						(9,'Ciego de &Aacute;vila '),
						(10,'Camag&uuml;ey'),
						(11,'Las Tunas'),
						(12,'Holgu&iacute;n'),
						(13,'Granma'),
						(14,'Santiago de Cuba'),
						(15,'Guant&aacute;namo'),
						(16,'Isla de la Juventud');";
					mysqli_query($miConex, $sql) or die(mysqli_error());
					
					$sql="CREATE TABLE IF NOT EXISTS `reg_claves_soft` (
						  `id` int(10) unsigned NOT NULL,
						  `equipo` varchar(50) NOT NULL,
						  `software` varchar(150) NOT NULL,
						  `usuario` varchar(50) NOT NULL,
						  `login` varchar(50) NOT NULL,
						  `passwd` varchar(15) NOT NULL,
						  `idunidades` int(11) DEFAULT NULL
						) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=armscii8;";
					mysqli_query($miConex, $sql) or die(mysqli_error());
					
					$sql="ALTER TABLE `reg_claves_soft`
							ADD PRIMARY KEY (`id`), ADD KEY `idunidades` (`idunidades`);";
					mysqli_query($miConex, $sql) or die(mysqli_error());
					
					$sql="ALTER TABLE `reg_claves_soft`
						MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;";
					mysqli_query($miConex, $sql) or die(mysqli_error());
								
					$sql="CREATE TABLE `componentes` (
						  `id` int(11) NOT NULL,
						  `idexp` varchar(15) NOT NULL,
						  `nombre` varchar(150) NOT NULL,
						  `marca` varchar(150) NOT NULL,
						  `modelo` varchar(150) NOT NULL,
						  `no_serie` varchar(150) NOT NULL,
						  `fabricante` varchar(150) NOT NULL,
						  `capacidad` varchar(150) NOT NULL,
						  `tasa` varchar(150) NOT NULL,
						  `frecuencia` varchar(50) NOT NULL,
						  `cache` varchar(10) NOT NULL,
						  `rpm` varchar(10) NOT NULL,
						  `interfaz` varchar(4) NOT NULL,
						  `tipo` varchar(10) NOT NULL,
						  `cpuid` varchar(16) NOT NULL,
						  `cpucores` varchar(2) NOT NULL,
						  `cpulogicos` varchar(2) NOT NULL,
						  `socket` varchar(50) NOT NULL
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
					mysqli_query($miConex, $sql) or die(mysqli_error());
					
					$sql="CREATE TABLE IF NOT EXISTS `upgrade` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `exp` varchar(11) NOT NULL,
						  `componente` varchar(150) NOT NULL,
						  `tipo` varchar(250) NOT NULL,
						  `remplazado_por` varchar(150) NOT NULL,
						  `fecha` date NOT NULL,
						  `n_pc` varchar(150) NOT NULL,
						  `idunidades` int(11) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45;";
					mysqli_query($miConex, $sql) or die(mysqli_error());			
					
					$sql="ALTER TABLE `componentes`
							ADD PRIMARY KEY (`id`);";
					mysqli_query($miConex, $sql) or die(mysqli_error());
					
					$sql="ALTER TABLE `componentes`
						MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;";
					mysqli_query($miConex, $sql) or die(mysqli_error());
					
					
				?>
				<form method="post" action="install2.php" name="formx">
				<input name="DBhostname" type="hidden" value="<?php echo $DBhostname;?>">
				<input name="DBuserName" type="hidden" value="<?php echo $DBuserName;?>">
				<input name="DBpassword" type="hidden" value="<?php echo $DBpassword;?>">
				<input name="DBname" type="hidden" value="<?php echo $DBname;?>">
				<input name="NombreAdmin" type="hidden" value="<?php echo $NombreAdmin;?>">
				<input name="LoginAdmin" type="hidden" value="<?php echo $LoginAdmin;?>">
				<input name="PassAdmin" type="hidden" value="<?php echo $PassAdmin;?>">
				<input name="sexo" type="hidden" value="<?php echo $sex;?>">
				<input name="CorreoAdmin" type="hidden" value="<?php echo $CorreoAdmin;?>">
				<input name="entidad" type="hidden" value="<?php echo $entidad;?>">
				<input name="reup" type="hidden" value="<?php echo $reup;?>">
        			<input name="sector" type="hidden" value="<?php echo $sector;?>">
				<input name="provincia" type="hidden" value="<?php echo $PROV;?>">
        			<input name="smtp" type="hidden" value="<?php echo $smtp;?>">
				<input name="conecta" type="hidden" value="n">
				<input name="actualiza" type="hidden" value="act">
				</form>
				<script language="javascript">
				function hacer(){
				   document.formx.submit();
				}
				hacer();
				</script><?php
				agrega_relaciones($miConex);
	        }else{
				echo "La actualizaci&oacute;n solo es aplicable para las versiones de Php anterior a la PHP_VERSION_ID < 50207";
				return false;
			}
		
		//AGREGAR RELACIONES
		function agrega_relaciones($miConex){
	        
			$sql = "SET FOREIGN_KEY_CHECKS=0;";
			mysqli_query($miConex, $sql) or die(mysqli_error($miConex));
			
			$sql = "ALTER TABLE `aft`
					ADD CONSTRAINT `aft_ibfk_2` FOREIGN KEY (`id_area`) REFERENCES `areas` (`idarea`) ON DELETE CASCADE ON UPDATE CASCADE,
					ADD CONSTRAINT `aft_ibfk_1` FOREIGN KEY (`idunidades`) REFERENCES `datos_generales` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE;";
			mysqli_query($miConex, $sql) or die(mysqli_error($miConex));
			
			$sql = "ALTER TABLE `areas`
					ADD CONSTRAINT `areas_ibfk_1` FOREIGN KEY (`idunidades`) REFERENCES `datos_generales` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE;";
			mysqli_query($miConex, $sql) or die(mysqli_error($miConex));
			
			$sql = "ALTER TABLE `bajas_aft`
				  ADD CONSTRAINT `bajas_aft_ibfk_2` FOREIGN KEY (`id_area`) REFERENCES `areas` (`idarea`) ON DELETE CASCADE ON UPDATE CASCADE,
				  ADD CONSTRAINT `bajas_aft_ibfk_1` FOREIGN KEY (`idunidades`) REFERENCES `datos_generales` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE;";
			mysqli_query($miConex, $sql) or die(mysqli_error($miConex));
			
			$sql = "ALTER TABLE `bajas_exp`
				  ADD CONSTRAINT `bajas_exp_ibfk_2` FOREIGN KEY (`id_area`) REFERENCES `areas` (`idarea`) ON DELETE CASCADE ON UPDATE CASCADE,
				  ADD CONSTRAINT `bajas_exp_ibfk_1` FOREIGN KEY (`idunidades`) REFERENCES `datos_generales` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE;";
			mysqli_query($miConex, $sql) or die(mysqli_error($miConex));
			
			$sql = "ALTER TABLE `conectado`
				  ADD CONSTRAINT `conectado_ibfk_1` FOREIGN KEY (`idunidades`) REFERENCES `datos_generales` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE;";
			mysqli_query($miConex, $sql) or die(mysqli_error($miConex));
			
			$sql = "ALTER TABLE `exp`
				  ADD CONSTRAINT `exp_ibfk_1` FOREIGN KEY (`id_area`) REFERENCES `areas` (`idarea`) ON DELETE CASCADE ON UPDATE CASCADE,
				  ADD CONSTRAINT `exp_ibfk_2` FOREIGN KEY (`idunidades`) REFERENCES `datos_generales` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE;";
			mysqli_query($miConex, $sql) or die(mysqli_error($miConex));
			
			$sql = "ALTER TABLE `incidencias`
						  ADD CONSTRAINT `incidencias_ibfk_2` FOREIGN KEY (`idunidades`) REFERENCES `datos_generales` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE,
						  ADD CONSTRAINT `incidencias_ibfk_1` FOREIGN KEY (`id_area`) REFERENCES `areas` (`idarea`) ON DELETE CASCADE ON UPDATE CASCADE;";
			mysqli_query($miConex, $sql) or die(mysqli_error());
			
			$sql = "ALTER TABLE `inspecciones`
				  ADD CONSTRAINT `inspecciones_ibfk_2` FOREIGN KEY (`idunidades`) REFERENCES `datos_generales` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE,
				  ADD CONSTRAINT `inspecciones_ibfk_1` FOREIGN KEY (`idunidades`) REFERENCES `datos_generales` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE;";
			mysqli_query($miConex, $sql) or die(mysqli_error());
			
			$sql = "ALTER TABLE `mtto`
				  ADD CONSTRAINT `mtto_ibfk_1` FOREIGN KEY (`idunidades`) REFERENCES `datos_generales` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE;";
			mysqli_query($miConex, $sql) or die(mysqli_error());
			
			$sql = "ALTER TABLE `plan_rep`
				  ADD CONSTRAINT `plan_rep_ibfk_2` FOREIGN KEY (`id_area`) REFERENCES `areas` (`idarea`) ON DELETE CASCADE ON UPDATE CASCADE,
				  ADD CONSTRAINT `plan_rep_ibfk_1` FOREIGN KEY (`idunidades`) REFERENCES `datos_generales` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE;";
			mysqli_query($miConex, $sql) or die(mysqli_error());
			
			$sql = "ALTER TABLE `preferencias`
				  ADD CONSTRAINT `preferencias_ibfk_1` FOREIGN KEY (`idunidades`) REFERENCES `datos_generales` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE;";
			mysqli_query($miConex, $sql) or die(mysqli_error());
			
			$sql = "ALTER TABLE `reg_claves`
				  ADD CONSTRAINT `reg_claves_ibfk_2` FOREIGN KEY (`id_area`) REFERENCES `areas` (`idarea`) ON DELETE CASCADE ON UPDATE CASCADE,
				  ADD CONSTRAINT `reg_claves_ibfk_1` FOREIGN KEY (`idunidades`) REFERENCES `datos_generales` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE;";
			mysqli_query($miConex, $sql) or die(mysqli_error());
			
			$sql = "ALTER TABLE `reg_claves_soft`
				  ADD CONSTRAINT `reg_claves_soft_ibfk_1` FOREIGN KEY (`idunidades`) REFERENCES `datos_generales` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE;";
			mysqli_query($miConex, $sql) or die(mysqli_error());
			
			$sql = "ALTER TABLE `traspasos`
				  ADD CONSTRAINT `traspasos_ibfk_2` FOREIGN KEY (`id_area`) REFERENCES `areas` (`idarea`) ON DELETE CASCADE ON UPDATE CASCADE,
				  ADD CONSTRAINT `traspasos_ibfk_1` FOREIGN KEY (`idunidades`) REFERENCES `datos_generales` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE;";
			mysqli_query($miConex, $sql) or die(mysqli_error());
			
			$sql = "ALTER TABLE `usuarios`
				  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_area`) REFERENCES `areas` (`idarea`) ON DELETE CASCADE ON UPDATE CASCADE,
				  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idunidades`) REFERENCES `datos_generales` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE;";
			mysqli_query($miConex, $sql) or die(mysqli_error());
			
			$sql = "SET FOREIGN_KEY_CHECKS=1;";
			mysqli_query($miConex, $sql) or die(mysqli_error());	
		}
		?>
	</div>	
</div>
</body>
</html>
