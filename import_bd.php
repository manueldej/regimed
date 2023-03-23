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
include('header.php');
require("mensaje.php");
?>
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

<?php
include('barra.php');
include('script.php'); ?>
<div id="buscad">
<fieldset class="fieldset"><legend class='vistauserx'><?php echo $impo_exp2;?></legend>
<?php
$roo = $_SERVER['DOCUMENT_ROOT'];
$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
$carpeta = $roo.$pht1."importar/";

	if(isset($_POST['crash']) AND ($_POST['crash']) !=""){
		$marcado=$_POST['marcado'];
		unlink($carpeta.$marcado);
		$fih= $marcado; ?>
		<fieldset class='fieldset'><legend class="vistauserx"><?php echo $bteliminar." ".$ficher." ".$btsalvare;?></legend>
			<table width="100%" border="0" cellspacing="10" cellpadding="0">				<tr> 
						<td align="center"><div class="message"><?php echo sprintf($bteliminado,$fih);?>.<br></div></td>
					</tr>
			</table>
		</fieldset><br><?php include ("version.php");?>
		<div class="ContenedorAlert" id="cir"> </div>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript">
			setTimeout("document.location='importa.php';",3000);
		</script>
		<?php
		exit;
	}
	
	if(isset($_POST['impo']) OR isset($_POST['reemp'])){
		$marcado=$_POST['marcado'];
		if(empty($marcado)){	
			show_message($strerror,$selectscript,"cancel","importa.php"); ?>
			  <br><hr width="70%" align="center">
					<?php include ("version.php");
			exit;
		}
		@define( "_VALID_MOS", 1 );
		@session_start(); 

		if (!check_auth_user()){
			header ("Location: index.php");
			exit;
		}
		$roo = $_SERVER['DOCUMENT_ROOT'];
		$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
		$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
		$ruta = $roo .$pht1."importar/";

		require('connections/miConex.php');
		require_once( 'common.php' );
		require_once( 'database.php' );
		$database = new database( $hostname_miConex, $username_miConex, $password_miConex, $database_miConex);
		
     		function ejec_query(&$database,$sqlfile,$miConex,$database_miConex) {
				$i="es";
						if(isset($_COOKIE['seulang'])){
							if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
						}
						if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
						$errors = array();		
						$merrors=array();
						if (version_compare(PHP_VERSION, '5.3.0', '<')) {
							$mqr = get_magic_quotes_runtime();
							set_magic_quotes_runtime(0);
							$query = fread(fopen($sqlfile, 'r' ), filesize($sqlfile));
							set_magic_quotes_runtime($mqr);
						}else{
							$query = fread(fopen($sqlfile, 'r' ), filesize($sqlfile));
						}
			
						$pieces  = split_sql($query);

						for ($i=0; $i<count($pieces); $i++) {
							$pieces[$i] = trim($pieces[$i]);
							if(!empty($pieces[$i]) && $pieces[$i] != "#") {
								mysqli_query($miConex, $pieces[$i]);
								if (mysqli_errno($miConex) !=0) {
									$errors[] = array(mysqli_error($miConex) );
									$merrors[]= array($pieces[$i]);
								}
								
							}
						}
						$isErr = intval(count($errors)); ?>
						<fieldset class="fieldset"><legend class="vistauserx"><?php echo $impo_exp1;?></legend>
							<table width="100%" border="0" cellspacing="10" cellpadding="0"><?php
								if ($isErr !=0) { ?>
									<tr> 
										<td class="td2"><?php echo $strerror;?>:</td>
									</tr>
									<tr> 
										<td><?php echo $strerror2; ?></td>
									</tr><?php
								} ?>
								<tr> 
									<td align="center"><?php 
										if ($isErr !=0) { 
											$ww=0;
											foreach($errors as $error) {
												print_r($error);
												echo $merrors[0][$ww]."\r\n";
												echo str_ireplace("\'","'","Error: ".$error[0]."\r\n- - - - - - - - - -\r\n");
												$ww++;
											}
										}else{ 
											echo "<div class='message'>".sprintf($scri_imp5,$database_miConex)."</div>"; 
											//@unlink($sqlfile);
										}	?>
									</td>
								</tr>
							</table>
							<br><br>
							<?php include ("version.php");?>
						</fieldset>
						<div class="dialogoInfo"></div>
						<div class="ContenedorAlert" id="cir"> </div>
						<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
						<script type="text/javascript" src="js/bootstrap.min.js"></script>
							
						<script type="text/javascript" src="js/main.js"></script><?php 						
						$seldg = mysqli_query($miConex, "select * from datos_generales where id_datos='1'") or die(mysql_error());
						$rseldg = mysqli_fetch_array($seldg);
						$upd = "update usuarios set tipo='usuario' where (idunidades !='".$rseldg['id_datos']."')";
						mysqli_query($miConex, $upd) or die(mysqli_error()); ?>
						<script type="text/javascript">
							setTimeout("document.location='expedientes.php';",1000);
						</script><?php
						exit;										
			}

			function split_sql($sql) {
				$sql = trim($sql);
				//$sql = @ereg_replace("\n#[^\n]*\n", "\n", $sql);  (derogado en php 8)
				$sql = preg_replace("/\n#[^\n]*\n/", "\n", $sql);

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
			$MainTableSqup = "USE ".chr(96).$database_miConex.chr(96).";\r\n";
			$tmp=0;
			$dato="";
			
			$SELA= mysqli_query($miConex, "select idarea from areas ORDER BY idarea DESC") or die(mysqli_error());
			$QSELA = mysqli_fetch_array($SELA);
			$NUMCAMH = mysqli_num_fields($SELA);
			$SELDG= mysqli_query($miConex, "select id_datos from datos_generales") or die(mysql_error());
			$NUMCAMHDG = mysqli_num_fields($SELDG);
			
			$TIPOQ = mysqli_query($miConex, "select id from tipos_medios") or die(mysql_error());
			$QSELAN = mysqli_num_rows($TIPOQ);
			$NUMCAMI = mysqli_num_fields($TIPOQ);
			$tiposmediosz=0;
			$Altert = "";
			$arr_num=array("int", "real");	
		
	//	foreach($marcado as $fchz){
			$fdtmza = fopen ($ruta.$marcado, "r");
				while(!feof($fdtmza)){
					$buffermtza=fgets($fdtmza,4096);
					if((strstr($buffermtza,"INSERT INTO `datos_generales`"))){									
						$buffermtzad = $buffermtza;						    
					}
					
				}
				@fclose ($fdtmza);	
				if(isset($_POST['reemp'])){
					$pedazoX = substr(strrchr($buffermtzad,','),1,-4);
					$SELDX= mysqli_query($miConex, "delete from datos_generales WHERE codigo='".$pedazoX."'") or die(mysql_error());
				}
			 $seld= mysqli_query($miConex, "select codigo,entidad from datos_generales") or die(mysql_error());
			 while($QSELDS = mysqli_fetch_array($seld)){
				$pedazo = substr(strrchr($buffermtzad,','),1,-4);
				if((@$QSELDS['codigo']) ==$pedazo){ echo "<br>";  ?>
					<div  align='center'>
					<div  class='message'>
						<table width='100%' align='center' >
							<tr>
								<td>
									<form name="remp" action="" method="post">
										<table width='100%' height='76' border='0' align='center' cellpadding='0' cellspacing='0'>
												<tr>
													<td colspan='4'><div align='center'><font size=4><strong><?php echo $advierte;?></strong></font></div></td>
												</tr>
												<tr>
													<td width='25%' align='center' valign='middle'><label><img src='images/warning.png' width='42' height='42'></label>				</td>
													<td colspan='3' class='quote'><div align='justify'><?php echo sprintf($yaexiste1,$QSELDS['entidad'])."<font color='#000000'>".$pedazo."</font>";?>. <br><?php echo $upgrade0;?></div></td>
												</tr>
												<tr>
													<td align='right'>&nbsp;</td>
													<td colspan="2" width='56%'>
															<input name="marcado" type="hidden" value="<?php echo $marcado;?>">
															<input type="submit" class="btn" name="reemp" value="<?php echo $btaceptar;?>">&nbsp;&nbsp;
															<input type="button" class="btn" name="canc" value="<?php echo $btcancelar;?>" onclick="document.location='importa.php';"></td>
													<td width='8%'>&nbsp;&nbsp;</td>
											  </tr>
										</table>
									</form>
								</td>
							</tr>
						</table>		
					</div>
					</div>
					<br><?php include ("version.php");?>
					<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
					<script type="text/javascript" src="js/bootstrap.min.js"></script>
					<script type="text/javascript" src="js/main.js"></script><?php
					exit;
				}
			}

			$fdtmz = @fopen ($ruta.$marcado, "r");
			while(!feof($fdtmz)){
				$buffermtz=fgets($fdtmz,4096);								
				if((strstr($buffermtz,"INSERT INTO `tipos_medios` VALUES ("))){									
					$tiposmediosz++;					
				}				
			}
			@fclose ($fdtmz);						
			$fdtma = @fopen ($ruta.$marcado, "r");
			$querymt = fread( $fdtma, filesize( $ruta.$marcado ) );
			$Altert = strstr($querymt,"(NULL,'DATASHOW');");	

			@fclose ($fdtma);
         
			if(($QSELAN) < $tiposmediosz){
				$posicion1 = strpos($Altert,"INSERT INTO `traspasos` VALUES (");
				$posicion2 = substr($Altert,strlen("(NULL,'DATASHOW');"));
				$posicion3 = substr($posicion2,0,($posicion1-18));
				$explotar = explode(');',$posicion3);
				$deletemt = mysqli_query($miConex, "delete from tipos_medios where nombre ='FOTOCOPIADORAS'") or die(mysql_error());

				array_pop ($explotar);
				$arreglomt=array();

				foreach($explotar as $as1){ 
					$arreglomt = substr(strstr($as1,"'"),1,-1);		
					$sqlALTER2 = @mysqli_query($miConex,"ALTER TABLE `areas` ADD `".strtolower($arreglomt)."` int(11) DEFAULT '0' AFTER `bocinas`");				
				}
				
				array_push($explotar,"INSERT INTO `tipos_medios` (id,nombre) VALUES (NULL,'FOTOCOPIADORAS')");
					foreach($explotar as $as){					//	echo $as."<br>";
					$sqlALTER = @mysqli_query($miConex,$as);
				}
			}
		
			if(($QSELAN) > $tiposmediosz){ echo "<br>";
				show_message($strerror,$noimportar.".","cancel","expedientes.php"); ?>
				<br><?php include ("version.php");?>					
				<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
				<script type="text/javascript" src="js/bootstrap.min.js"></script>
				<script type="text/javascript" src="js/main.js"></script><?php
				exit;
			}
	//	}
	   
						$kk=1;
						$kk1=1;
						$FINAL="";
						$FINAL1="";
						$lolo="";
						$gestor = @fopen($ruta.$marcado, "r");
						for($k=1; $k<3; $k++){
							$dato .= fgets($gestor, 4096);
						}

						fclose ($gestor);
						$dir = substr (strrchr ($dato, ","), 1);
						$compar =  substr(substr($dir,0,-2),0,-2);	
					
						$secom = mysqli_query($miConex,"select codigo from datos_generales where codigo=".$compar." AND id_datos='1'") or die(mysql_error());
						$rseco = mysqli_num_rows($secom);
	           
						$infoes= mysqli_query($miConex,"select AUTO_INCREMENT from information_schema.TABLES WHERE TABLE_SCHEMA='".$database_miConex."' AND TABLE_NAME='datos_generales' ") or die(mysql_error());
						$rinfoes = mysqli_fetch_array($infoes);
						$iddgen = $rinfoes['AUTO_INCREMENT'];
						$tiposmedios=0;
						
						if(($rseco) ==0){								
							$fdtm = @fopen ($ruta.$marcado, "r");
							while(!feof($fdtm)){
								$buffermt=fgets($fdtm,4096);							
								if((strstr($buffermt,"INSERT INTO `tipos_medios` VALUES (NULL"))){									
									$tiposmedios++;
								}
							}
							@fclose ($fdtm);						
	
							$fd1 = @fopen ($ruta.$marcado, "r");
							$fg=0;
							$bufferdd="";
							$contador=0;
							
							while(!feof($fd1)){
								$contador++;
								$buffer=fgets($fd1,4096);
								$estoA = ($QSELA['idarea'] + $kk);
								$estoDG = ($NUMCAMHDG + 1);
														
								if((strstr($buffer,"INSERT INTO `datos_generales` VALUES (NULL,"))){
									$FINAL1 .=   str_replace("INSERT INTO `datos_generales` VALUES (NULL,","INSERT INTO `datos_generales` VALUES (".$estoDG.",",$buffer);									
									//$kk=0;					
								}elseif((strstr($buffer,"INSERT INTO `areas` VALUES (NULL"))){
									$FINAL12 = str_replace("INSERT INTO `areas` VALUES (NULL,","INSERT INTO `areas` VALUES (".$estoA.",",$buffer);
									$bufferdd = $buffer;
									$pedazo1 = substr(strrchr($bufferdd,','),1,-4);
									$FINAL1 .=   str_replace(",".$pedazo1.");",",".$estoDG.");",$FINAL12);									
									$kk++;
								}else{ 
								   	if(strstr($buffer,"INSERT INTO `aft`") OR strstr($buffer,"INSERT INTO `exp`") OR strstr($buffer,"INSERT INTO `reg_claves`") OR strstr($buffer,"INSERT INTO `usuarios`") OR strstr($buffer,"INSERT INTO `plan_rep`") OR strstr($buffer,"INSERT INTO `traspasos` VALUES (")){											
										if (strstr($buffer, "INSERT INTO ")){
											$explod = explode(',',$buffer);	
											//$lolo = intval($explod[1]) + intval($QSELA['idarea']); //valor OK original
											$lolo = $estoA+1; // agregado
											$pos1 = strpos($buffer, $explod[1]);
											$cadena1 = substr($buffer,0,$pos1); //principio OK 
											$cadena2 = substr($buffer,$pos1);
											$pos2 = strpos(substr($buffer,$pos1),',');										
											$cadena3 = substr($cadena2,$pos2); //final OK
											$FINAL13 =$cadena1.$lolo.$cadena3;			
											$bufferdd = $buffer;
											$pedazo1 = substr(strrchr($bufferdd,','),1,-4);
											$FINAL1 .=   str_replace(",".$pedazo1.");",",".$estoDG.");",$FINAL13);	
										}
									
									}elseif(strstr($buffer,"INSERT INTO `tipos_medios`")){
										$FINAL1 .="";
									}else{
										$FINAL1 .=$buffer;	
									}
									
								}	
							}
							@fclose ($fd1);				
		
                            $iddgen = "'".$iddgen."'";  //se agrega					
							$esto ="VALUES (NULL,";
							$otra =",'0'";
							//$FINAL1 =   str_replace("',1);","',".$iddgen.");",$FINAL1); // el viejo 
					
							//Agrega el nuevo id de la nueva unidad 
							for ($pp=0; $pp<$contador; $pp++) {
								if(str_replace("VALUES ('".$pp."',"," ".$esto,$FINAL1)){ 
								  $FINAL1 = str_replace("VALUES ('".$pp."',"," ".$esto,$FINAL1);  
								}
							}
													
							// Agrega el valor del id de la nueva unidad a (idunidades) de la tabla areas
							for ($w=0; $w<$contador; $w++) {								
								if(str_replace("','".$w."');","',".$iddgen.");",$FINAL1)){ 							
								  $FINAL1 = str_replace("','".$w."');","',".$iddgen.");",$FINAL1);
								}	
							}
																						
							$fp1 = fopen($ruta.$marcado, "wb");
							flock($fp1, 2);
							if (!$fp1){ exit; }
							fwrite($fp1, $MainTableSqup.$FINAL1);
							flock($fp1, 3);
							fclose($fp1);			

							ejec_query( $database, $ruta.$marcado, $miConex, $database_miConex); 							
						}else{ 
						   exit(); 
						}	?>
				   <script type="text/javascript">document.location="expedientes.php";</script><?php
	}else{
		show_message($strerror,$selectscript,"cancel","importa.php"); 
		exit;
	}
	
?>
</fieldset><br> <?php include ("version.php");?>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>