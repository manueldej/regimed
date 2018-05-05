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
include ('script.php'); ?>
<style type="text/css">
<!--
.Estilo1 {
	color: #000000;
	font-weight: bold;
	font-family: Tahoma, Helvetica, Arial, sans-serif;
	font-size: 18px;
}
-->
</style><?php 
include('barra.php'); 
include('mensaje.php');?>
<div id="buscad"> <?php
@define( "_VALID_MOS", 1 );
@define( "_VALID_MOS", 1 );

require_once( 'common.php' );
require_once( 'database.php' );
$tb="";
$tb = @$_REQUEST['tb'];
if(($tb) =="plan_rep"){ $target = "rep.php";}
if(($tb) =="mtto"){ $target = "plan_mtto.php";}
if(($tb) =="traspasos"){ $target = "r_traspasos.php";}
if(($tb) =="todo"){ $target = "expedientes.php";}

$roo = $_SERVER['DOCUMENT_ROOT'];
$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
if(isset($_REQUEST['carpeta'])){
	$carpeta= $roo.$pht1."reparaciones/";
}else{
	$carpeta= $roo.$pht1."salvas/";
}

		$fecha=date("dmY");
		$fichero = $_REQUEST['marcado'];
		$queimporta = explode('_',$fichero);

if(isset($_REQUEST['crash']) AND ($_REQUEST['crash']) !=""){
	@unlink($carpeta.$fichero); ?>
	<fieldset class='fieldset'><legend class="vistauserx"><?php echo $Eliminasalva;?></legend>
		<table width="100%" border="0" cellspacing="10" cellpadding="0">				<tr> 
					<td><br><div align="center"><div class="message" align="center">
						<?php echo sprintf($elimino, $_REQUEST['marcado']);?></div></div>
					</td>
				</tr>
		</table>
	</fieldset><br><?php include ("version.php");?>
	<script type="text/javascript">
		setTimeout(document.location="<?php echo $_REQUEST['origen']?>", 5000);
	</script>
	<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<?php
	exit;
}
		if(($queimporta[0]) =="estrut" AND !isset($_REQUEST['mens'])){ 
			show_messagex($advierte,$seguro3." ".$seguro2,"warning","imprt.php",$tb,$_REQUEST['marcado'],''); ?>
			 <br>
<?php include ("version.php");?>
			<div class="ContenedorAlert" id="cir"> </div>
			<script type="text/javascript" src="js/bootstrap.min.js"></script>
			<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script><?php
			exit;
		}
		if(($queimporta[0]) =="dats" AND !isset($_REQUEST['mens'])){ 
			show_messagex($advierte,$seguro4,"warning","imprt.php",$tb,$_REQUEST['marcado'],"t"); ?>
			 <br>
<?php include ("version.php");?>
			<div class="ContenedorAlert" id="cir"> </div>
			<script type="text/javascript" src="js/bootstrap.min.js"></script>
			<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script><?php
			exit;
		}		
		$upload_ext = strrchr($fichero,".");
		$nomfichero = substr($fichero,0,-4);
		if(isset($_REQUEST['trunca']) AND ($_REQUEST['trunca']) !=""){
			$sqlz = "SHOW TABLES FROM ".$database_miConex; 
			$resultz = mysqli_query($miConex, $sqlz) or die(mysql_error());	
			while ($rowz = mysqli_fetch_row($resultz)) {
				$trunz = mysqli_query($miConex, "TRUNCATE `".$rowz[0]."`") or die(mysql_error());				
			}
		}
		if(($upload_ext) ==".zip"){
			$zip = new ZipArchive;
			if ($zip->open($carpeta.$fichero) === TRUE) {
				$nomre_act = $zip->getNameIndex(0);
				$zip->close();
			} else {
				echo 'failed';
			}
			$zip = new ZipArchive;
			if ($zip->open($carpeta.$fichero) === TRUE) {
				$zip->renameName($nomre_act,$nomfichero.'.sql');
				$zip->close();
			} else {
				echo 'failed';
			}
			$zip = new ZipArchive;
			if ($zip->open($carpeta.$fichero) === TRUE) {
				$zip->extractTo($carpeta);
				$zip->close();
			} else {
				echo 'failed';
			}
		}else{
			rename($carpeta.$fichero,$carpeta.$nomfichero.'.sql');
		}
$ctas=1;
if(!isset($_REQUEST['carpeta'])){		
$gestor = @fopen($carpeta.$nomfichero.'.sql', "r");
$ctas=0;
while(!feof($gestor)){
	$dato = fgets($gestor, 4096);
	$findme   = 'bajas_aft';
	$pos = strstr($dato, $findme);
	if(($pos) !=""){ $ctas++; fclose ($gestor); break;}
}
@fclose ($gestor);
}
	if(($ctas) !=0){	
		$DBhostname = $hostname_miConex;
		$DBuserName = $username_miConex;
		$DBpassword = $password_miConex;
		$DBname  	= $database_miConex;
		$DBDel  	= "1";
		$DBBackup  	= "1";
		$DBUpdate  	= "1";
		$DBSample	= "1";
		$DBcreated	= "1";
		$destin = "expedientes.php";
		$configArray['sitename'] = trim( mosGetParam( $_REQUEST, 'sitename', '' ) );

		$database = null;

		$errors = array();
		
		function db_err($step, $alert, $idi) {
			global $DBhostname,$DBuserName,$DBpassword,$DBDel,$DBname, $lng;
			//echo '<script>alert("'.$alert.'"); document.location="javascript:history.go(-1)";</script>';  
			exit();
		}
			if (!$DBhostname || !$DBuserName || !$DBname) {
				db_err("stepBack3",$no_deta, $lng);
			}

			$database = new database($DBhostname, $DBuserName, $DBpassword, $DBname, '', false );
			$test = $database->getErrorMsg();

			if (!$database->_resource) {
				db_err('stepBack2',$strnousuario, $lng);
			}

			if($DBname == '') {
				db_err('stepBack','El nombre de la base de datos esta vacio.', $lng);
			}
			
			$configArray['DBhostname'] = $DBhostname;
			$configArray['DBuserName'] = $DBuserName;
			$configArray['DBpassword'] = $DBpassword;
			$configArray['DBname']	 = $DBname;

			$sql = "CREATE DATABASE `$DBname`";
			$database->setQuery( $sql );
			$database->query();
			$test = $database->getErrorNum();

			if ($test != 0 && $test != 1007) {
				db_err( 'stepBack', 'Se ha producido un error en la base de datos: ' . $database->getErrorMsg(), $lng );
			}
		
				
		function populate_db( &$database, $sqlfile, $carpeta, $miConex) {
			global $errors;

			$mqr = @get_magic_quotes_runtime();
			@set_magic_quotes_runtime(0);
			$query = fread( fopen( $carpeta.$sqlfile, 'r' ), filesize( $carpeta.$sqlfile ) );
			@set_magic_quotes_runtime($mqr);
			$pieces  = split_sql($query);
			for ($i=0; $i<count($pieces); $i++) {
				$pieces[$i] = trim($pieces[$i]);
				if(!empty($pieces[$i]) && $pieces[$i] != "#") {
					mysqli_query($miConex, $pieces[$i]);
					if (mysql_errno() !="") {
						$errors[] = array(mysql_error($miConex) );
						$merrors[]= array($pieces[$i]);
					}
				}
			}
		}

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
			$database = new database( $DBhostname, $DBuserName, $DBpassword, $DBname );
			populate_db( $database, $nomfichero.'.sql', $carpeta, $miConex );			
			$DBcreated = 1;

		$isErr = intval( count( @$errors ) );
		echo "<?xml Version=\"1.0\" encoding=\"iso-8859-1\"?".">";		?>
		<fieldset class='fieldset'><legend class="vistauserx"><?php echo $btrestaurar.$exte;?></legend>
			<table width="100%" border="0" cellspacing="10" cellpadding="0"><?php 
				if ($isErr) { ?>
					<tr> 
						<td class="td2"><?php echo @$strerror;?>:</td>
					</tr>
					<tr> 
						<td><?php echo @$strerror2;?></td>
					</tr>
					<tr> 
						<td>
							<textarea rows="10" cols="66" class="combo_box"><?php 
								foreach($errors as $error) {
									echo "SQL=$error[0]:\n- - - - - - - - - -\n$error[1]\n= = = = = = = = = =\n\n";
								} ?>
							</textarea>
						</td>
					</tr><?php  
				} else{
					if(isset($_REQUEST['mens'])){
						mysqli_query($miConex, "DROP DATABASE `".$database_miConex."`") or die(mysql_error());
						unlink('connections/miConex.php');
					}
					if(isset($_REQUEST['carpeta'])){
						$mensaje = $message1.$fichero."</strong></font>";
						unlink($carpeta.$nomfichero.'.sql');
					}else{
						$mensaje = $message2.@$DBname."-</strong>".$message3.$queimporta[2];
						unlink($carpeta.$nomfichero.'.sql');
					} ?>
				
					<tr> 
						<td align="center"><br><div class="message" align="center"><?php echo $mensaje;?></div><br></td>
					</tr><?php 
				} ?>
			</table><?php
			@unlink($roo.$pht1."reparaciones/".$nomfichero.".sql");
	}else{ ?>
			<fieldset class='fieldset'><legend class="vistauserx"><?php echo $btrestaurar.$exte;?></legend>
				<table width="100%" border="0" cellspacing="10" cellpadding="0">				
						<tr> 
						  <td><img src="images/warning.png" width="39" height="44" border="0" align="absmiddle" />&nbsp;&nbsp;<?php echo @$mensajex;?><br></td>
						</tr>
				</table><?php
	} ?>
</fieldset><br><?php include("version.php");?>
		</div>
<meta http-equiv="refresh" content="3;URL=<?php echo $target;?>">
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
