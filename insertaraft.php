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
@session_start(); include('chequeo.php');
if (!check_auth_user()){
	header ("Location: index.php");
	exit;
}
require_once("data_valid_fns.php");
$variable = array ();
require_once('connections/miConex.php');
 	if(@$_POST["editar"]){
	   $selloviejo = $_REQUEST['selloviejo'];
	   $sql = "UPDATE aft SET inv='".$_POST['inv']."',descrip='".htmlentities($_POST['desc'])."',estado='".$_POST['estado']."',idarea='".htmlentities($_POST['narea'])."',sello='".$_POST['sello']."',marca='".$_POST['marca']."',no_serie='".$_POST['serie']."',modelo='".$_POST['modelo']."',categ='".$_POST['flash']."',tipo='".$_POST['usb']."',custodio='".htmlentities($_POST['custo'])."',t_AFT='".$_POST['taft']."' WHERE inv='".$_SESSION[id]."' ";
	   $result = mysqli_query($miConex, $sql);
       
	   // Actualizo el estado de sello
	    $sqlsello = "UPDATE sellos SET estado='En Uso' WHERE numero='".$_POST['sello']."'"; 
		$resultsello = mysqli_query($miConex, $sqlsello) or die(mysql_error());
	  
	  // Marcar el sello viejo con Retirado
	  	$sqlselloviejo = "UPDATE sellos SET estado='Desechado' WHERE numero='".$selloviejo."'"; 
		echo $sqlselloviejo;
		$resultselloviejo = mysqli_query($miConex, $sqlselloviejo) or die(mysql_error());
		
		if(($_POST["flash"])=='COMPUTADORAS') { 
			?><script type="text/javascript">document.location="modificarexp.php";</script><?php
		} else { 
			?><script type="text/javascript">document.location="registromedios1.php";</script><?php
		}
	}
	if(isset($_POST['insertar'])){
		  

		if(($_POST['enred']) =="n"){
			$enredx = "n";
			$conectx= "";
		}else{
			$enredx = $_POST['enred'];
			$conectx = $_POST['conect'];
		}

		$seleare = mysqli_query($miConex, "SELECT * FROM areas where idarea='".$_POST['narea']."'") or die(mysql_error());
		$qseleare = mysqli_fetch_array($seleare);
		
		$si_existe = mysqli_query($miConex, "SELECT * FROM aft where inv='".$_POST['inv']."'") or die(mysql_error());
		$cant_existente = mysqli_num_rows($si_existe);

		
		if ($cant_existente == 0){
			$sql = "insert into aft (id,id_area, inv, descrip, estado, idarea, sello,marca,no_serie,modelo,categ,tipo,custodio,t_AFT,enred,conect,idunidades) values (NULL,'".htmlentities($qseleare['idarea'])."', '".$_POST['inv']."', '".htmlentities($_POST['desc'])."', '".$_POST['estado']."', '".$qseleare['nombre']."', '".$_POST['sello']."','".$_POST['marca']."','".$_POST['serie']."','".$_POST['modelo']."','".$_POST['flash']."','".htmlentities($_POST['usb'])."','".htmlentities($_POST['custo'])."','".$_POST['taft']."','".$enredx."','".$conectx."','".$_POST['idunidades']."')";
		    $resultv = mysqli_query($miConex, $sql) or die(mysql_error());
		
			
  
		  // Buscar la categoria para agregar el total
			$ff="SELECT * FROM areas";
			$result1 = mysqli_query($miConex, $ff) or die (mysql_error());
			$num_campo = mysqli_num_fields($result1);
           
			
			for ($i=1; $i<= $num_campo; $i++) {
				$fields  = mysqli_fetch_field_direct($result1, $i-1);
				$nom_campo = $fields->name;
		
				$esta=strtolower($_POST['flash']);
				if ($nom_campo == strtolower($esta)) {
					$sql1="SELECT ".$esta." FROM areas where idarea='".$_POST['narea']."'";
					$resultado1 = mysqli_query($miConex, $sql1)  or die(mysql_error());
					$linea = mysqli_fetch_array($resultado1);	
					$valor_col =$linea[$esta]+1;				  
					$sql2="UPDATE areas SET ".$esta."='".$valor_col."' where idarea='".$_POST['narea']."'";
					$result = mysqli_query($miConex, $sql2) or die(mysql_error()); 
				}
			}
			
			if ($_POST['flash']=='COMPUTADORAS'){ 
			    // Actualizo el estado de sello
					if ($_POST['sello']!=""){
						$sqlsello = "UPDATE sellos SET estado='En Uso' WHERE numero='".$_POST['sello']."'"; 
						$resultsello = mysqli_query($miConex, $sqlsello) or die(mysql_error());
					}
			  ?>
			  <form name="mandaaft" method="post" action="form-insertarexp.php" >
				<input name="inv" type="hidden" value="<?php echo $_POST['inv'];?>">
				<input name="idunidades" type="hidden" value="<?php echo $_POST['idunidades'];?>">
			  </form>
			  <script type="text/javascript">document.mandaaft.submit();</script><?php
			}else {
				?><script type="text/javascript">window.parent.location="registromedios1.php";</script><?php		   
			}
			//SI LA MARCA QUE VIENE NO ESTA EN EL FICHERO, LA AGREGRO
			$roo = $_SERVER['DOCUMENT_ROOT'];
			$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
			$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
			$rutac = $roo .$pht1;
			$orga = array();
			$marcas = $_POST['marca'];
			$handle = fopen($rutac."marcas.cat", "r");
			if ($handle){
				while (!feof($handle)) {
					$txt = trim(fgets($handle));
					$orga[]= $txt;
				}
			}
			fclose($handle);
			
			$HY ="n";
			if (!in_array($marcas, $orga)) {
				$HY ="s";
			}

			if(($HY) =="s"){
				$logeo = fopen($rutac."marcas.cat", "a"); 
				fwrite($logeo,chr(10).strtoupper($marcas));
				flock($logeo, 3);
				fclose($logeo);				
			}	
		}else {
				?><script type="text/javascript">window.parent.location="form-insertaraft.php";</script><?php		   
		}		
	}
  
?>
