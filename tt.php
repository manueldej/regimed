<?php 
############################################################################################################
# Software: Regimed                                                                                        #
#(Registro de Medios Informáticos)     					                                		           #
# Version:  3.0.1                                                     				                       #
# Fecha:    01/06/2016 - 03/04/2018                                             					       #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			           #
#          	Msc. Carlos Pollan Estrada											         		           #
# Licencia: Freeware                                                				                       #
#                                                                       			                       #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                #
############################################################################################################

include('header.php');
include ('script.php');
include('barra.php');?>
<div id="buscad">
<fieldset class="fieldset"><legend class='vistauserx'><?php echo $impo_exp2;?></legend>
		<script language="javascript">
			function ap1(m)		{
				document.getElementById("tarea").innerHTML=m;
			}
			function apx(m)		{
				document.getElementById("tarea").innerHTML=m;
			}
			function des1(f,n,zip)		{
					document.getElementById("descarga").innerHTML='<a class="enlace" target = "_blank" href="'+f+'" title="<?php echo $click1.$descarg;?>">'+n+'</a>';		
			}
		</script>
		<fieldset class='fieldset'><legend class='vistauserx'><?php echo $otrosdet3;?></legend>
			<div id="tarea">Actual:</div><br>
		</fieldset><br>
				<fieldset class='fieldset'>
					<legend class='vistauserx'><?php echo $descarg;?> </legend>
					<div class="descar" id="descarga"><?php echo $spera;?></div><br>
				</fieldset> <?php
 		
	class expcons{
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

		//FUNCION PARA COMPRIMIR
		public function comprim($todoy1,$nomby1,$qc){
			$ruta=$todoy1.$qc;
			$fichero=$nomby1.$qc;
			$sip=$todoy1.".zip"; 
			$zip = new ZipArchive;
			if ($zip->open ( $sip, ZIPARCHIVE::OVERWRITE ) !== TRUE) {
					exit ( "No se puede crear el archivo zip.\n" );
			} else {
				$zip->addFile($ruta,$fichero);
				$zip->close();
				echo "<script>des1('".$todoy1.".zip','".$nomby1.".zip');\n</script>";
			}
			return true;
		}
	}
	function creasalva($tabla1,$i){
		$tiem = time();
			if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
		include('connections/miConex.php');
			$bd=$database_miConex;
			$roo = $_SERVER['DOCUMENT_ROOT'];
			$posicion = strripos($roo, "/");
			$ruta = substr($roo, 0, $posicion)."/tmp/"; 
			$fecha= date("mY");
			$sedg = mysqli_query($miConex, "select * from datos_generales where id_datos='1'") or die(mysql_error());
			$rsedg=mysqli_fetch_array($sedg);
			$nsedg = "_".$rsedg['id_datos'];
			@unlink($ruta.$fecha.$nsedg.".sql");
			@unlink("reparaciones/".$fecha.".sql");

			$arr_num=array("int", "real");
			$fp = fopen($ruta.$fecha.$nsedg.".sql", "w");

			$prog = new expcons();
				//bloque de estructuras
				$todo="";
				$todo="";
				fwrite($fp,"SET FOREIGN_KEY_CHECKS=0;\r\n");
				
		foreach($tabla1 as $key=>$tabla){
				$prog->barra_prog ( $exptr1." ".$estructra3."s...");
				$todo="";		
				if(($tabla) =="datos_generales"){
					$FF = "SELECT * FROM ".$tabla." ORDER BY id_datos DESC";
				}elseif(($tabla) =="areas"){
					$FF = "SELECT * FROM ".$tabla." ORDER BY idarea DESC";
				}else{
					$FF = "SELECT * FROM ".$tabla." ORDER BY id DESC";
				}
				$RESULT=mysqli_query($miConex, $FF);
				$ROW = mysqli_fetch_array($RESULT);		
		
				if(($tabla) =="datos_generales"){
					$ff = "SELECT * FROM ".$tabla." WHERE id_datos='".$rsedg['id_datos']."'";
				}else{
					$ff = "SELECT * FROM ".$tabla." WHERE idunidades='".$rsedg['id_datos']."'";
				}					
					$result=mysqli_query($miConex, $ff);// or die(mysql_error());
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
							$field  = mysqli_fetch_field_direct ($result, $i); 
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
		@copy($ruta.$fecha.$nsedg.".sql","exportar/".$fecha.$nsedg.".sql");
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
	$tablaa=array('datos_generales','aft', 'areas','bajas_aft','bajas_exp','exp','mtto','inspecciones','plan_rep','preferencias','reg_claves','traspasos','usuarios');
	creasalva($tablaa,$i);
?>	
	<script type="text/javascript">
		function cierrx(){
				window.parent.location="configura.php";
		}
		document.getElementById('cira').innerHTML='<div class="alert negro"><button class="close" type="button" onclick="cierrx();">x</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div align="center"><b><?php echo $selectscript1;?>.</b></div></div>';
	</script>
    <br> <br>
			<div id="footer" class="degradado" align="center">
				<div class="container">
					<p class="credit"><?php include ("version.php");?></p>
				</div>
			</div>
</fieldset>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="js/main.js"></script>
