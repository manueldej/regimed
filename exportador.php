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
include ('script.php');
include('barra.php');

?>
<div id="buscad">
<fieldset class="fieldset"><legend class='vistauserx'><?php echo $impo_exp2;?></legend>
<script language="javascript">
	function ap1(m)	{
		document.getElementById("tarea").innerHTML=m;
	}
	function apx(m)	{
		document.getElementById("tarea").innerHTML=m;
	}
	function des1(f,n,zip){
		document.getElementById("descarga").innerHTML='<a class="enlace" target = "_blank" href="'+f+'" title="<?php echo $click1.$descarg;?>">'+n+'</a>';		
	}
</script>
		<fieldset class='fieldset'><legend class='vistauserx'><?php echo $otrosdet3;?></legend>
			<div id="tarea">Actual:</div><br>
		</fieldset><br>
		<fieldset class='fieldset'><legend class='vistauserx'><?php echo $descarg;?> </legend>
			<div class="descar" id="descarga"><?php echo $btspera;?></div><br>
		</fieldset><?php
 		
	class expcons1{
		public function reset($n) {
			$this->prog_total = $n;
			$this->prog_actual = 0;
		}		
		//FUNCION PARA ELIMINAR TEMPORALES
		public function elimina($que_borro){
			$roo = $_SERVER['DOCUMENT_ROOT'];
			$posicion = strripos($roo, "/");
			$ruta = substr($roo, 0, $posicion)."/tmp/"; 
			@unlink($que_borro);		
		}

		public function barra_prog($m) {
			$i="es";
			if(isset($_COOKIE['seulang'])){
				if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
			}
			if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
			echo "<script> ap1('".$m."');\n</script>";
			flush ();
		}
	//REEMPLAZAR CARACTER
		public function html_ent($tra){
			$a = str_replace('á','&aacute;',  $tra);
			$e = str_replace('é','&eacute;',  $a);
			$i = str_replace('í','&iacute;',  $e);
			$o = str_replace('ó','&oacute;',  $i);
			$u = str_replace('ú','&uacute;',  $o);
			$n = str_replace('ñ','&ntilde;',  $u);
			$A = str_replace('Á','&Aacute;',  $n);
			$E = str_replace('É','&Eacute;',  $A);
			$I = str_replace('Í','&Iacute;',  $E);
			$O = str_replace('Ó','&Oacute;',  $I);
			$U = str_replace('Ú','&Uacute;',  $O);
			$N = str_replace('Ñ','&Ntilde;',  $U);
			return $N;		
		}

		//FUNCION PARA COMPRIMIR SQL
		public function comprim($todoy1,$nomby1,$qc){
			$ruta=$todoy1.$qc;
			$fichero=$nomby1.$qc;
			$sip=$todoy1.".zip"; 
			$zip = new ZipArchive;
			if ($zip->open ( $sip, ZIPARCHIVE::CREATE ) !== TRUE) {
					exit ( "No se puede crear el archivo zip.\n" );
			} else {
				$zip->addFile($ruta,$fichero);
				$zip->close();
				echo "<script>des1('".$todoy1.".zip','".$nomby1.".zip');\n</script>";
			}
			return true;
		}
		//FUNCION PARA COMPRIMIR incidencia
		public function comprim1($todoy1,$nomby1,$qc){
			$ruta=$todoy1.$qc;
			$fichero=$nomby1.$qc;
			$sip=$todoy1.".zip"; 
			$zip = new ZipArchive;
			if ($zip->open ( $sip, ZIPARCHIVE::CREATE ) !== TRUE) {
					exit ( "No se puede crear el archivo zip.\n" );
			} else {
				$zip->addFile($ruta,$fichero);
				$zip->close();				
			}		
			return true;
		}
	}
	function creasalva($tabla1,$i){
		$tiem = time();
		
		   $i="es";
			if(isset($_COOKIE['seulang'])){
				if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
			}
			if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
		    include('connections/miConex.php');
			$bd=$database_miConex;
			$roo = $_SERVER['DOCUMENT_ROOT'];
			$posicion = strripos($roo, "/");
			$ruta = substr($roo, 0, $posicion)."/tmp/"; 
			$fecha= date("mY");
			$sedg = mysqli_query($miConex, "select * from datos_generales where id_datos='1'") or die(mysqli_error());
			$rsedg=mysqli_fetch_array($sedg);
			$nsedg = "_".$rsedg['id_datos'];
			@unlink($ruta.$fecha.$nsedg.".sql");
			@unlink("reparaciones/".$fecha.".sql");

			$arr_num=array("int", "real");
			$fp = fopen($ruta.$fecha.$nsedg.".sql", "w");

			$prog = new expcons1();
				//bloque de estructuras
				$todo="";
				$todo="";
				fwrite($fp,"SET FOREIGN_KEY_CHECKS=0;\r\n");
	
		foreach($tabla1 as $key=>$tabla){
				$prog->barra_prog ( $exptr1." ".$estructra3."s...");
				$todo="";
				$ff = "SELECT * FROM ".$tabla;
			
					$result=mysqli_query($miConex, $ff);// or die(mysqli_error());
					$trows=mysqli_num_rows($result);
					$fields = mysqli_num_fields($result);

					$tt=$tabla;
					$linea="INSERT INTO ".chr(96).$tabla.chr(96)." VALUES (";
					$num=1;
					while($row = mysqli_fetch_object($result)){
						$prog->barra_prog ( $exptr1." ".$estructra3."s".$dela.$tablasa."-> <b><font color=red>".$tabla."</font></b>");
						$i = 0;
						$datos="";
						while ($i < $fields){
							$field  = mysqli_fetch_field_direct($result, $i); 
							$name = $field->name;
							$flags = $field->flags; 
									
 							if(strpos($flags,"auto_increment")>0) {
								$dato= "NULL";
							}else{
								$dato=$row->$name;								
								if(in_array($field->type,$arr_num)){										
									if(($row->$name) ==""){ $dato="NULL";}										
								}
								if(!in_array($field->type,$arr_num)){										
									$pos=strpos($dato,chr(39));
									while(!$pos==false) {
										$dato=substr($dato,0,$pos).chr(39).substr($dato,$pos,strlen($dato));
										$pos=strpos($dato,chr(39),$pos+2);
									}										
									$dato=chr(39).$dato.chr(39);
								}
							}
											
							if ($i < $fields-1) { $dato .=",";}
							$i++;								
							$datos .=$dato;
						}
						$num++;
						$data=$linea.$datos.');';
						
						$todo.=$data."\r\n";
					}				

			fwrite($fp, $todo);
			fwrite($fp, "\r\n");			
		}
		
		flock($fp, 3);	
		fwrite($fp, "\r\nSET FOREIGN_KEY_CHECKS=1;\r\n");
		fclose($fp);
		$prog->barra_prog ( $copiando.$ficher."s...");
		copy($ruta.$fecha.$nsedg.".sql","exportar/".$fecha.$nsedg.".sql");
		$prog->barra_prog ( $exptr2." ".$ficher." .sql");
		$prog->comprim("exportar/".$fecha.$nsedg,$fecha.$nsedg,".sql");
		$prog->barra_prog ( $exptr3."sql");
		$prog->barra_prog ( $exptr3);
		$prog->elimina($ruta.$fecha.$nsedg.".sql");
		$prog->elimina("exportar/".$fecha.$nsedg.".sql");
		
		$Tim = (time()-$tiem);
		if(($Tim) < 1 ){
			$Tim = 1; 
			$prog->barra_prog ( $strproceso2."<b><font color=red>".$Tim."</font></b>".$strproceso3);
		}elseif(($Tim) < 60){					
			$prog->barra_prog ( $strproceso2."<b><font color=red>".$Tim."</font></b>".$strproceso3);
		}elseif(($Tim) >= 60){
			$Tim =($Tim/60);
			$prog->barra_prog ( $strproceso2."<b><font color=red>".round($Tim)."</font></b>".$strproceso4);
		}
		$prog->reset ( 1000 );
	}

	function restaurador($i,$DBname,$sql){
		require_once( 'common.php' );
		include('connections/miConex.php');
			if(($i) =="es"){
				include('esp.php');
			}else{ 
				include('eng.php');
			}
			$tbl=array();
			$tiem = time();
			mysqli_select_db($DBname);
			$seldg=mysqli_query($miConex, "select * from datos_generales where id_datos='1'") or die(mysqli_error());
			$rseldg = mysqli_fetch_array($seldg);
			$adtabla="esydat";
			$roo = $_SERVER['DOCUMENT_ROOT'];
			$posicion = strripos($roo, "/");
			$ruta = substr($roo, 0, $posicion)."/tmp/"; 

						$arr_num=array("int", "real");
						$tiem = time();
						
						$total_tab=0;

						$resultlist = mysql_list_tables ($DBname);
						while (@$total_tab < mysqli_num_rows ($resultlist)) {
							$tb_names[$total_tab] = mysql_tablename ($resultlist, $total_tab);
							$tbl[]= $tb_names[$total_tab];
								$total_tab++;	
						}						

						if($total_tab < 50) { 
							$step=1;
						}else{ 
							$step =Round((100/$total_tab),2);
						}
						$export=1;$paso=$step;

						$fp = fopen($ruta."salva_".$DBname.".sql", "w");
						require ('clases3.php');
						$prog = new expcons();
						$prog->reset(1);

						if (($export==1)){
							//bloque de estructuras
							@$pasado=0;
							$todo="-- Datos generados con DBSiGeX\r\n-- Fecha: ".date('d-m-Y')."\r\n\r\n".$sql.";\r\nSET FOREIGN_KEY_CHECKS=0;\r\n";

							foreach($tbl AS $key=>$tabla)	{
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
								$fields = @mysqil_num_fields($result);
								$head="\r\n-- ".$exptr1.$dela.$tablasa."-> `".$tabla."`\r\n-- ".$totalrecord.": ".$trows."\r\n-- ----------------------------------- \r\n";
								$todo .=$head;
								$tt=$tabla;
								$i1=0;
								$dato1="";
								while ($i1 < $fields){
									$field1 = mysqli_fetch_field ($result, $i1);
									$flags1 = mysql_field_flags ($result, $i1);
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
									@$pasado=@$pasado+$paso;	
									$datos="(";
									$datof= "";
									$dato ="";
									while ($i < $fields){
										$field = mysqli_fetch_field ($result, $i);
										$flags = mysql_field_flags ($result, $i);
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
						copy($ruta."salva_".$DBname.".sql","salvas/salva_".$DBname.".sql");
						$prog->elimina($ruta."salva_".$DBname.".sql");
						$filePerms = '0755';
						$dirPerms  = '0755';
						$filemode = octdec($filePerms);
						$dirmode = octdec($dirPerms);
						$chmodOk = TRUE;
							if (!chmod("salvas/salva_".$DBname.".sql", $dirmode)) {
								$chmodOk = FALSE;
							}
						if (!$chmodOk) {
							$chmod_report = 'Nota: Los permisos del directorio y de los archivos no han podido ser cambiados.<br />'.
											'Cambia los permisos de los archivos y directorios manualmente.';
						}
						
	}
		//restaurador('es', $database_miConex,"USE `".$database_miConex."`"); 

		$gh=0;
		$seldgx = mysqli_query($miConex, "select * from datos_generales where id_datos !='1'") or die(mysqli_error());
		while($Key = mysqli_fetch_array($seldgx)){

		$seldg = mysqli_query($miConex, "select * from datos_generales where id_datos='".$Key['id_datos']."'") or die(mysqli_error());
		$rseldg = mysqli_fetch_array($seldg);

		$seldselreg_claves = mysqli_query($miConex, "select * from usuarios where idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());
			while($rselreg_claves = mysqli_fetch_array($seldselreg_claves)){
				if(($rselreg_claves['idarea']) =="Inform&aacute;tica"){
					$selreg_claves = mysqli_query($miConex, "update reg_claves set idunidades='1', idarea='Inform&aacute;tica(F_".$rseldg['codigo'].")' where idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());			
				}else{
					$selreg_claves = mysqli_query($miConex, "update reg_claves set idunidades='1' where idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());					
				}
			}

			$selaftareas = mysqli_query($miConex, "update areas set idunidades='1', nombre='Inform&aacute;tica(F_".$rseldg['codigo'].")' where nombre='Inform&aacute;tica'  AND idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());			
			$selaftareas1 = mysqli_query($miConex, "update areas set idunidades='1' where idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());					

			$seldselreg_aft = mysqli_query($miConex, "select * from aft where idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());
			while($rselreg_aft = mysqli_fetch_array($seldselreg_aft)){
				if(($rselreg_aft['idarea']) =="Inform&aacute;tica"){
					$selaft1 = mysqli_query($miConex, "update aft set idunidades='1' , idarea='Inform&aacute;tica(F_".$rseldg['codigo'].")'  where  idarea='Inform&aacute;tica'  AND idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());
				}else{
					$selaft1 = mysqli_query($miConex, "update aft set idunidades='1'  where  idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());
				}
			}
			
			$seldselreg_aft1 = mysqli_query($miConex, "select * from bajas_aft where idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());
			while($rselreg_aft1 = mysqli_fetch_array($seldselreg_aft1)){
				if(($rselreg_aft1['idarea']) =="Inform&aacute;tica"){
					$selbajas_aft1 = mysqli_query($miConex, "update bajas_aft set idunidades='1' , idarea='Inform&aacute;tica(F_".$rseldg['codigo'].")'  where  idarea='Inform&aacute;tica'  AND idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());
				}else{
					$selbajas_aft1 = mysqli_query($miConex, "update bajas_aft set idunidades='1'  where  idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());
				}
			}

			$seldselreg_exp = mysqli_query($miConex, "select * from bajas_exp where idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());
			while($rselreg_exp = mysqli_fetch_array($seldselreg_exp)){
				if(($rselreg_exp['idarea']) =="Inform&aacute;tica"){
					$selbajas_exp = mysqli_query($miConex, "update bajas_exp set idunidades='1' , idarea='Inform&aacute;tica(F_".$rseldg['codigo'].")'  where  idarea='Inform&aacute;tica'  AND idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());
				}else{
					$selbajas_exp = mysqli_query($miConex, "update bajas_exp set idunidades='1'  where  idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());
				}
			}

			$seldselreg_expd = mysqli_query($miConex, "select * from exp where idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());
			while($rselreg_expd = mysqli_fetch_array($seldselreg_expd)){
				if(($rselreg_expd['idarea']) =="Inform&aacute;tica"){
					$selbajas_expd = mysqli_query($miConex, "update exp set idunidades='1' , idarea='Inform&aacute;tica(F_".$rseldg['codigo'].")'  where  idarea='Inform&aacute;tica'  AND idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());
				}else{
					$selbajas_expd = mysqli_query($miConex, "update exp set idunidades='1'  where  idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());
				}
			}

			$seltraspasos = mysqli_query($miConex, "update traspasos set idunidades='1' where idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());
			$seltraspasos1 = mysqli_query($miConex, "update traspasos set idunidades='1', origen='Inform&aacute;tica(F_".$rseldg['codigo'].")'  where origen='Inform&aacute;tica'  AND idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());

			$seldgimp = mysqli_query($miConex, "select * from inspecciones where idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());
			$rseldgimp = mysqli_fetch_array($seldgimp);
			$cadimp = str_ireplace('Inform&aacute;tica','Inform&aacute;tica(F_'.$rseldg['codigo'].')',$rseldgimp['area']);
			$selinspecciones = mysqli_query($miConex, "update inspecciones set idunidades='1', area='".$cadimp."' where idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());

			$selmtto = mysqli_query($miConex, "update mtto set idunidades='1' where idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());

			$selplan_rep = mysqli_query($miConex, "update plan_rep set idunidades='1' where idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());
			$selplan_rep1 = mysqli_query($miConex, "update plan_rep set idunidades='1', idarea='Inform&aacute;tica(F_".$rseldg['codigo'].")'  where  idarea='Inform&aacute;tica'  AND idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());

			$selpreferencias = mysqli_query($miConex, "update preferencias set idunidades='1' where idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());

			$seldgareasselusuarios = mysqli_query($miConex, "select * from usuarios where idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());
			while($rseldgareasselusuarios = mysqli_fetch_array($seldgareasselusuarios)){
				if(($rseldgareasselusuarios['idarea']) =="Inform&aacute;tica"){
					$selusuarios = mysqli_query($miConex, "update usuarios set idunidades='1', idarea='Inform&aacute;tica(F_".$rseldg['codigo'].")' where idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());			
				}else{
					$selusuarios = mysqli_query($miConex, "update usuarios set idunidades='1' where idunidades='".$rseldg['id_datos']."'") or die(mysqli_error());					
				}
			}

			$seldg = mysqli_query($miConex, "delete from datos_generales where id_datos='".$Key['id_datos']."'") or die(mysqli_error());
			$gh++;
		} 		

	$tablaa=array('datos_generales', 'areas','aft','bajas_aft','bajas_exp','exp','mtto','inspecciones','incidencias','plan_rep','preferencias','reg_claves','tipos_medios','traspasos','usuarios');
	creasalva($tablaa,$i);
	
		require_once( 'common.php' );
		require_once( 'database.php' );
		include('connections/miConex.php');
		
			$database = new database( $hostname_miConex, $username_miConex, $password_miConex, $database_miConex);
			
					function ejec_query($database,$sqlfile,$database_miConex) {
						$i="es";
						if(isset($_COOKIE['seulang'])){
							if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
						}
						if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
						$errors = array();		
						$merrors=array();
						$query = fread(fopen($sqlfile, 'r'), filesize( $sqlfile ) );
						$pieces  = split_sql($query);
           
						for ($i=0; $i<count($pieces); $i++) {
							$pieces[$i] = trim($pieces[$i]);
							if(!empty($pieces[$i]) && $pieces[$i] != "#") {
								mysqli_query($miConex, $pieces[$i]);
								if (mysqli_errno($miConex) !="") {
									$errors[] = array(mysqli_error($miConex) );
									$merrors[]= array($pieces[$i]);
								}
								
							}
						}
						$isErr = intval( count( $errors ) ); 
						if ($isErr !="") { ?>
							<fieldset class="fieldset"><legend class="vistauserx"><?php echo $impo_exp1;?></legend>
								<table width="100%" border="1" cellspacing="10" cellpadding="0"><?php
									?>
										<tr> 
											<td class="td2"><?php
												$ww=0;
												foreach($errors as $error) {
													print_r($error);
													echo $merrors[0][$ww]."\r\n";
													echo str_ireplace("\'","'","Error: ".$error[0]."\r\n- - - - - - - - - -\r\n");
													$ww++;
												} ?></td>
										</tr>
								</table>
								<br>
							</fieldset><br><?php include ("version.php");?>
							<div class="dialogoInfo"></div>
							<div class="ContenedorAlert" id="cir"> </div>
							<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
							<script type="text/javascript" src="js/bootstrap.min.js"></script>
							<script type="text/javascript" src="js/main.js"></script><?php
						}						
						$seldg = mysqli_query($miConex, "select * from datos_generales where id_datos='1'") or die(mysqli_error());
						$rseldg = mysqli_fetch_array($seldg);
						$upd = "update usuarios set tipo='usuario' where (idunidades !='".$rseldg['id_datos']."')";
						mysqli_query($miConex, $upd) or die(mysqli_error());
						exit;										
					}

					function split_sql($sql) {
						$sql = trim($sql);
						$sql = preg_replace("\n#[^\n]*\n#","\n#", $sql, -1);

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
	$roo = $_SERVER['DOCUMENT_ROOT'];
	$posicion = strripos($roo, "/");
	$fecha= date("mY");
	$sedg = mysqli_query($miConex, "select * from datos_generales where id_datos='1'") or die(mysqli_error());
	$rsedg=mysqli_fetch_array($sedg);
	$nsedg = "_".$rsedg['id_datos'];
	$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
	$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
	//$file = $roo.$pht1."salvas/salva_".$database_miConex.".sql";
	$file = $roo.$pht1."exportar/".$fecha.$nsedg.".zip";	
	
	$filemode = 0755;
	$dirmode =0755;
	$chmodOk = TRUE;
		
	if (!chmod($file, $filemode)) {
		$chmodOk = FALSE;
	}
	if ($chmodOk) {
		echo 'Se han cambiado los permisos del directorio y de los archivos a 0755 (Todo para el propietario, lectura y ejecuci&oacute;n para los otros).';
		?> 
		  <script type="text/javascript">setTimeout("document.location='expedientes.php';",1000);</script>
		<?php 
	} else {
		echo 'Los permisos del directorio y de los archivos no han podido ser cambiados.<br />Cambia los permisos de los archivos y directorios manualmente.';
	}	
	 //ejec_query( $database, $file, $database_miConex); ?>	
		
</fieldset><br>	<?php include ("version.php");?>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"></div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>