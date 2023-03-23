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
@session_start();
require_once('connections/miConex.php');
require_once("data_valid_fns.php");
include('chequeo.php');
include ('script.php');
 	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}

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

	$consulta ="SELECT * FROM preferencias WHERE usuario='".$_SESSION['valid_user']."'";
	$resultado = mysqli_query($miConex, $consulta) or die(mysql_error());
	$que_quiero=mysqli_fetch_array($resultado);
	
	function rerecalcula() {
		include('connections/miConex.php');
		$i=0;
		$n=0;
		$sql = "SELECT * FROM areas";
		$result= mysqli_query($miConex, $sql) or die(mysql_error());	  
	   	$n_campos = mysqli_num_fields($result);
        
		while ($rower = mysqli_fetch_array($result)) { $i++; 
			for($n=1; $n<$n_campos; $n++){
				$field = mysqli_fetch_field_direct($result, $n);
				$name  = $field->name;
				$flags = $field->flags;
			   
					if ($name!="idarea" AND $name!="nombre" AND $name!="idunidades") {
					   $sql_cont = "SELECT COUNT(id) as total FROM aft WHERE id_area='".$rower['idarea']."' AND estado='A' AND categ='".$name."'";
					   $resul_cont = mysqli_query($miConex, $sql_cont) or die(mysql_error());	  
					   $row1 = mysqli_fetch_array($resul_cont);	
        			   
					    
						if (mysqli_num_rows($resul_cont)!=0){ 
					     $sql11 = "UPDATE areas SET ".$name."='".$row1['total']."' WHERE idarea='".$rower['idarea']."'";
					     $resul11 = mysqli_query ($miConex, $sql11) or die (mysql_error());
					    }
					}
			}
		}
	}
    if(isset($_POST["id"])){ $id= $_POST["id"]; }   
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
		$codifica  =@$_POST['codifa'];
      
?>
<div id="buscad"> <?php
	if($_POST["editar"]){
			
	for($j=0; $j< count($id); $j++){
		if (!empty($id[$j]))  {
		if ($t2[$j] != $codifica[$j]){  // Si la clave ha sido cambiada 
			$n_clave[$j] = base64_encode($t2[$j]); 
		}else{
			$n_clave[$j] =  $t2[$j]; // se queda ident
		}	
		
		$sql_area ="SELECT * FROM areas WHERE nombre='".htmlentities($t6[$j])."'";
		$result_area = mysqli_query($miConex, $sql_area) or die(mysql_error());
		$row_area=mysqli_fetch_array($result_area);
	
		if(($tipo[$j]) =="-1"){ $tipo[$j]= $tviej[$j]; }			
			
			$sql = "UPDATE usuarios SET login='".htmlentities($t1[$j])."',passwd='".$n_clave[$j]."',id_area='".$row_area['idarea']."', idarea='".htmlentities($t6[$j])."',tipo='".$tipo[$j]."',email='".$t3[$j]."',cargo='".htmlentities($t4[$j])."',nombre='".htmlentities($t5[$j])."',sexo='".$sexo[$j]."' WHERE id='".$id[$j]."'";
			$result = mysqli_query($miConex, $sql) or die(mysql_error());
	
			$sqlaft = "UPDATE aft SET id_area='".$row_area['idarea']."',idarea='".htmlentities($t6[$j])."',custodio='".htmlentities($t5[$j])."' WHERE custodio='".htmlentities($viej[$j])."'";
			$result1 = mysqli_query($miConex, $sqlaft) or die(mysql_error());

			$sqlexp = "UPDATE exp SET id_area='".$row_area['idarea']."',idarea='".htmlentities($t6[$j])."',custodio='".htmlentities($t5[$j])."' WHERE custodio='".htmlentities($viej[$j])."'";
			$result2 = mysqli_query($miConex, $sqlexp) or die(mysql_error());

			$sqlpre = "UPDATE plan_rep SET id_area='".$row_area['idarea']."',idarea='".htmlentities($t6[$j])."' WHERE idarea='".htmlentities($aviej[$j])."'";
			$result3 = mysqli_query($miConex, $sqlpre) or die(mysql_error());

			$sqlrc = "UPDATE reg_claves SET usuario='".htmlentities($t5[$j])."' WHERE usuario='".htmlentities($viej[$j])."'";
			$result4 = mysqli_query($miConex, $sqlrc) or die(mysql_error());		
			if(($_SESSION ["valid_user"]) ==$loginviejo[$j]){ $_SESSION ["valid_user"] = $t1[$j]; }	
            rerecalcula();

		}
  	
	}
	//Send confirmation mail.... Esto solo funciona si el apache está en el mismo servidor SMTP.
		if ($que_quiero['pass']=='s'){
			$cuta=0;				
			for($k=0; $k<count($id); $k++){
				$query="select* from usuarios where id='".$id[$k]."'";
				$result=mysqli_query($miConex, $query) or die(mysql_error());
				$row = mysqli_fetch_assoc ($result);	
			
				$cuerpo1 = $m_r_Greeting.$row["nombre"]."\n\nEste correo es para informarle que sus datos han sido modificado.\n\nNombre y Apellidos: ".$row["nombre"]."\nUsuario: ".$row["login"]."\nClave: ".base64_decode($row["passwd"])."\nCargo: ".$row["cargo"]."\nE-Mail: ".$row["email"]."\n&Aacute;rea: : ".$row["idarea"]."\n\n\n".$m_Thanks."\n\n".$m_Signature;
			
				$a = str_replace('&aacute;', chr(225), $cuerpo1);
				$e = str_replace('&eacute;', chr(233), $a);
				$i = str_replace('&iacute;', chr(237), $e);
				$o = str_replace('&oacute;', chr(243), $i);
				$u = str_replace('&uacute;', chr(250), $o);
				$n = str_replace('&ntilde;', chr(241), $u);
				$A = str_replace('&Aacute;', chr(193), $n);
				$E = str_replace('&Eacute;', chr(201), $A);
				$I = str_replace('&Iacute;', chr(205), $E);
				$O = str_replace('&Oacute;', chr(211), $I);
				$U = str_replace('&Uacute;', chr(218), $O);
				$uN = str_replace('&uuml;', chr(252), $U);	
				$uN1 = str_replace('&Uuml;', chr(220), $uN);	
				$cuerpo = str_replace('&Ntilde;', chr(209), $uN1);		

				$destino = array($row["email"]) ;
				$asunto = $btregisusuario ;
				$encabezados = 'From: Equipo Desarrollador <'.$m_From_Adress.'>' ;
					
					for($r=0; $r<count($destino);$r++){
						if((mail($destino[$r], $asunto, $cuerpo, $encabezados))){
							$cuta++;
						}
					}

			}
		
		/*	if(($cuta) ==0)	{			
			  echo '<br><div align="center"><div class="message" align="center">'.$n_mail.'</div></div>';	  
			}else{
			 echo '<br><div align="center"><div class="message" align="center">'.$sol_registr1.'</div></div>';
			}
		*/ 	
		}	
		
		
		?>
		<?php  if (!isset($_POST['o'])) { ?>
			<script type="text/javascript">
				document.location='ej1.php';
			</script><?php
	        }else { ?>

			<script type="text/javascript">
				window.parent.location='ej1.php';
			</script>
			<?php }			
	} ?>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>