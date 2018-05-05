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
@session_start();
require_once('connections/miConex.php');
		include('chequeo.php');
 	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
include ('script.php');
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
require_once("data_valid_fns.php");

$query_Recordset1 = "SELECT * FROM datos_generales WHERE id_datos='1'";
$Recordset1 = mysqli_query($miConex, $query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysqli_fetch_array($Recordset1);
$m_Priority = 3; // 1 Urgente, 3 Normal
$m_r_Greeting = "Estimado(a): ";
$m_Thanks = "Con toda consideracion, ";
$mailserVer = $row_Recordset1['smtp'];//172.26.11.1
$m_From_Adress =$row_Recordset1['mail'];
$m_Signature = "Equipo Desarrollador. RegiMed.\nRegistro de Medios Inform&aacute;ticos.\nCuba. ".date('Y').".";
$validus = "";
if(isset($_SESSION["autentificado"])){
	$validus = " AND idunidades='".$_SESSION["autentificado"]."'";
}elseif (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$validus = " AND idunidades='".$_COOKIE['unidades']."'";
}else{
	$validus = "";
}
$us1 = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$rus1 = mysqli_fetch_array($us1);

$id= $_POST["id"];
$t1= $_POST["t1"];
$t2= $_POST["t2"];
$t3= $_POST["t3"];
$t4= $_POST["t4"];
$t5= $_POST["t5"];
$t6= $_POST["t6"];
$tipo= $_POST["tipo"];
$o  = $_POST['o'];
$viej  = $_POST['viej'];
$aviej  = $_POST['aviej'];
$tviej  = @$_POST['tviej'];
$Uviejo  = $_POST['Uviejo'];
$sexo  = $_POST['sexo'];
$loginviejo  = $_POST['loginviejo'];
?>
<div id="buscad"> <?php
if($_POST["editar"]){  
	for($j=0; $j< count($id); $j++){
		if (!empty($id[$j]))  {
		if(($tipo[$j]) =="-1"){ $tipo[$j]= $tviej[$j];}			
			$sql = "UPDATE usuarios SET login='".htmlentities($t1[$j])."',passwd='".base64_encode($t2[$j])."',idarea='".htmlentities($t6[$j])."',tipo='".$tipo[$j]."',email='".$t3[$j]."',cargo='".htmlentities($t4[$j])."',nombre='".htmlentities($t5[$j])."',sexo='".$sexo[$j]."' WHERE id='".$id[$j]."'";
			$result = mysqli_query($miConex, $sql) or die(mysql_error());
			//echo $sql."<br>";			
			$sqlaft = "UPDATE aft SET idarea='".htmlentities($t6[$j])."',custodio='".htmlentities($t5[$j])."' WHERE custodio='".htmlentities($viej[$j])."'";
			$result1 = mysqli_query($miConex, $sqlaft) or die(mysql_error());
			//echo $sqlaft."<br>";
			$sqlexp = "UPDATE exp SET idarea='".htmlentities($t6[$j])."',custodio='".htmlentities($t5[$j])."' WHERE custodio='".htmlentities($viej[$j])."'";
			$result2 = mysqli_query($miConex, $sqlexp) or die(mysql_error());
			//echo $sqlexp."<br>";
			$sqlpre = "UPDATE plan_rep SET idarea='".htmlentities($t6[$j])."' WHERE idarea='".htmlentities($aviej[$j])."'";
			$result3 = mysqli_query($miConex, $sqlpre) or die(mysql_error());

			$sqlrc = "UPDATE reg_claves SET usuario='".htmlentities($t5[$j])."' WHERE usuario='".htmlentities($viej[$j])."'";
			//echo $sqlrc;
			$result4 = mysqli_query($miConex, $sqlrc) or die(mysql_error());		
			if(($_SESSION ["valid_user"]) ==$loginviejo[$j]){ $_SESSION ["valid_user"] = $t1[$j]; }			
		}		
	}
	//Send confirmation mail.... Esto solo funciona si el apache está en el mismo servidor SMTP.

    // $cuta=0;				
	// for($k=0; $k<count($id); $k++){
		// $query="select* from usuarios where id='".$id[$k]."'";
		// $result=mysqli_query($miConex, $query) or die(mysql_error());
		// $row = mysqli_fetch_assoc ($result);	
	
		// $cuerpo1 = $m_r_Greeting.$row["nombre"]."\n\nEste correo es para informarle que sus datos han sido modificado.\n\nNombre y Apellidos: ".$row["nombre"]."\nUsuario: ".$row["login"]."\nClave: ".base64_decode($row["passwd"])."\nCargo: ".$row["cargo"]."\nE-Mail: ".$row["email"]."\n&Aacute;rea: : ".$row["idarea"]."\n\n\n".$m_Thanks."\n\n".$m_Signature;
	
		// $a = str_replace('&aacute;', chr(225), $cuerpo1);
		// $e = str_replace('&eacute;', chr(233), $a);
		// $i = str_replace('&iacute;', chr(237), $e);
		// $o = str_replace('&oacute;', chr(243), $i);
		// $u = str_replace('&uacute;', chr(250), $o);
		// $n = str_replace('&ntilde;', chr(241), $u);
		// $A = str_replace('&Aacute;', chr(193), $n);
		// $E = str_replace('&Eacute;', chr(201), $A);
		// $I = str_replace('&Iacute;', chr(205), $E);
		// $O = str_replace('&Oacute;', chr(211), $I);
		// $U = str_replace('&Uacute;', chr(218), $O);
		// $uN = str_replace('&uuml;', chr(252), $U);	
		// $uN1 = str_replace('&Uuml;', chr(220), $uN);	
		// $cuerpo = str_replace('&Ntilde;', chr(209), $uN1);		

		// $destino = array($row["email"]) ;
		// $asunto = $btregisusuario ;
		// $encabezados = 'From: Equipo Desarrollador <'.$m_From_Adress.'>' ;
			
			// for($r=0; $r<count($destino);$r++){
				// if((mail($destino[$r], $asunto, $cuerpo, $encabezados))){
					// $cuta++;
				// }
			// }

	// }
	// if(($cuta) ==0)	{			
	  // echo '<br><div align="center"><div class="message" align="center">'.$n_mail.'</div></div>';	  
	// }else{
	  // echo '<br><div align="center"><div class="message" align="center">'.$sol_registr1.'</div></div>';
	// } 	?>
	<?php   if (!isset($_POST['o'])) { ?>
				<script type="text/javascript">
					document.location='ej1.php';
				</script><?php
	        }else { ?>

			<script type="text/javascript">
					window.parent.location='ej1.php';
				</script>
			<?php }			
}
?>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>