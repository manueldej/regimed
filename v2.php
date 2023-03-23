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
include('mensaje.php'); 

$arrecomp = array("COMPUTADORAS"=>array('PORT&Aacute;TIL','ESCRITORIO','SERVIDOR','CLIENTE LIGERO','SERVIDOR NAS')) ;
$arremon=array("MONITOR"=>array('LCD','LED','TUBO CAT&Oacute;DICO'));
$arreboc=array("BOCINAS"=>array('PLUG','USB'));
$arreplo=array("PLOTER"=>array('DE PLUMA','DE CHORRO'));
$arreSWI=array("SWITCH"=>array('CABLEADO','INAL&Aacute;MBRICO'));
$arremod=array("MODEM"=>array('EXTERNO','INTERNO'));
$arrerou=array("ROUTER"=>array('USB','INAL&Aacute;MBRICO','PUERTO COM'));
$arremou=array("MOUSE"=>array('PS2','USB','INAL&Aacute;MBRICO','PUERTO COM','DIMM'));
$arretec=array("TECLADOS"=>array('PS2','USB','INAL&Aacute;MBRICO','PUERTO COM','DIMM'));
$arreimp=array("IMPRESORA"=>array('MATRICIAL','LASER'));
$arreesc=array("ESCANNER"=>array('USB','PUERTO COM'));
$arrefot=array("FOTOCOPIADORA"=>array('A COLOR','BLANCO Y NEGRO'));
$arreups=array("UPS"=>array('CONVENSIONALES','PARA SERVIDORES'));
$arremem=array("MEMORIAS"=>array('USB'));
$fecha = date("d/m/Y");
				if (isset($_REQUEST["editar"])) {
					if(isset($_REQUEST["marcado"])){ $marcado = $_REQUEST["marcado"];}
					if(($marcado) ==""){ echo "<br><br>";
						show_message($strerror,$plea8.$mostrar1.".","cancel","registromedios1.php"); ?>
						  <br>
							  <div id="footer" class="degradado" align="center">
								  <div class="container">
									  <p class="credit"><?php include ("version.php");?></p>
								  </div>
							  </div><?php
						exit;
					} 
					include('barra.php');
					?>
<link href="css/template.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>			
<script language="JavaScript" >
			// Chequeo que no se queden campos obligatorios en blanco 
				function check() {
					// form validation check
					var formValid=false;
					var f = document.form1;
					
					if (f.inv.value == '') {
						alert("El campo 'Inv' est� en blanco.");
						f.inv.focus();
						formValid=false;} 
					else if (f.desc.value == '') {
						alert("El campo 'Descripci�n' est� en blanco.");
						f.desc.focus();
						formValid=false;} 
					else if ( f.nombre.value == '' ) {
						alert("El campo 'Area' est� en blanco.");
						f.nombre.focus();
						formValid=false;} 
					else if ( f.categ.value == '-1' ) {
						alert("Por favor seleccione la 'Categor�a'.");
						f.categ.focus(); 
						formValid=false; 	} 
					else if ( f.tipo.value == '' ) {
						alert("El campo 'Tipo' est� en blanco.");
						f.tipo.focus();
						formValid=false;} 
					else if ( f.custo.value == '-1' ) {
						alert("Por favor seleccione el 'Custodio'.");
						f.custo.focus(); 
						formValid=false; 	} 
					else if ( confirm('Son estos los datos correctos?')) {
						formValid=true;}

					return formValid;
				}
		</script>
		<style type="text/css">
			<!--
			.Estilo2 {
				color: #0099CC;
				font-weight: bold;
			}
			.Estilo3 {color: #009999}
			.Estilo4 {color: #336666; font-weight: bold; }

			div.message {
				font-family : "Trebuchet MS", Arial, Helvetica, sans-serif;
				font-weight: bold;
				font-size : 14px;
				color : #c30;
				text-align: center;
				width: auto;
				background-color: #f9f9f9;
				border: solid 1px #d5d5d5;
				margin: 3px 0px 10px;
				padding: 3px 20px;
			}
			-->
		</style>
		<fieldset class='fieldset'><legend class="vistauserx"><?php echo $bteditar;?> AFT</legend>
		<div id="buscad"> 		
		<form action="" method="post" name="form1" onsubmit="return check();">
			<table width="50%" border="0" align="center" class="tablen"><?php
			$ff=0;			
		for($y=0;$y<count($marcado);$y++){	
			$se = "select * FROM aft WHERE id='".$marcado[$y]."'";
			$qse = mysqli_query($miConex, $se) or die(mysql_error());
			while($rowx=mysqli_fetch_array($qse)){ 
				$query_Recordset1 = "SELECT * FROM usuarios WHERE idunidades='".$rowx['idunidades']."' AND idarea='".$rowx['idarea']."' order by nombre";
				$Recordset1 = mysqli_query($miConex, $query_Recordset1) or die(mysql_error());
				$query_Recordset3 = "SELECT * FROM areas WHERE idunidades='".$rowx['idunidades']."' AND nombre='".$rowx['idarea']."' order by nombre";
				$Recordset3 = mysqli_query($miConex, $query_Recordset3) or die(mysql_error());
				$row_Recordset3 = mysqli_fetch_array($Recordset3);
		
				$query_Recordset2 = "SELECT * FROM tipos_medios";
				$Recordset2 = mysqli_query($miConex, $query_Recordset2) or die(mysql_error());
					
				$query_Recordset4 = "SELECT * FROM tipos_aft";
				$Recordset4 = mysqli_query($miConex, $query_Recordset4) or die(mysql_error()); ?>
				<tr> 
				  <td colspan="2"></td>
				</tr>
				<tr> 
				  <td width="72"><div align="right" class="contentheading">Inv</div></td>
				  <td><input onkeypress="return handleEnter(this, event)" name="inv[]" class="form-control" type="text" value="<?php echo $rowx['inv'];?>"></td>
				</tr>
				<tr> 
				  <td><div align="right" class="contentheading"><?php echo $DESCRIPCION1;?></div></td>
				  <td><input onkeypress="return handleEnter(this, event)" name="desc[]" class="form-control" type="text" size="40" value="<?php echo $rowx['descrip'];?>"></td>
				</tr>
				<tr> 
				  <td><div align="right" class="contentheading"><?php echo ucwords($btestado);?></div></td>
				  <td><label> 
					<select onkeypress="return handleEnter(this, event)" name="estado[]" class="form-control" size="1">
					  <option value="A" <?php if(($rowx['estado']) =="A"){ echo "selected";}?>><?php echo $btActivo;?></option>
					  <option value="R" <?php if(($rowx['estado']) =="R"){ echo "selected";}?>><?php echo $btRoto;?></option>
					  <option value="T" <?php if(($rowx['estado']) =="T"){ echo "selected";}?>><?php echo $btTaller;?></option>
					</select>
					</label></td>
				</tr>
				<tr> 
				  <td><div align="right" class="contentheading"><?php echo substr($btAreas,0,-1);?></div></td>
				  <td><input onkeypress="return handleEnter(this, event)" type="text" readonly name="nombre[]" size="40" class="form-control" value="<?php echo $row_Recordset3['nombre'];?>"></td>
				</tr>
				<tr> 
				  <td><?php if ($rowx['categ']=="COMPUTADORAS") { ?><div align="right" class="contentheading"><?php echo ucwords($btSELLO);?></div><?php } ?></td>
				  <td><?php if ($rowx['categ']=="COMPUTADORAS") { ?><input onkeypress="return handleEnter(this, event)" name="sello[]" class="form-control" type="text" size="40" value="<?php echo $rowx['sello'];?>"><?php } ?></td>
				</tr>
				<tr> 
				  <td><div align="right" class="contentheading"><?php echo ucwords(strtolower($btMARCA));?></div></td>
				  <td><input onkeypress="return handleEnter(this, event)" name="marca[]" id="marca" class="form-control" type="text" size="40" value="<?php echo $rowx['marca'];?>" onKeyUp="llamaorgano(this.value,'marcas');"><span id="orgn" onClick="document.getElementById('orgn').style.display ='none';" class="mstra" style="width: 348px; padding: 5px; margin-top: 224px; margin-left: 180px; display:none;"></span></td>
				</tr>
				<tr> 
				  <td><div align="right" class="contentheading">Serie</div></td>
				  <td><input onkeypress="return handleEnter(this, event)" name="serie[]" class="form-control" type="text" id="t35" size="40" value="<?php echo $rowx['no_serie'];?>"></td>
				</tr>
				<tr> 
				  <td><div align="right" class="contentheading"><?php echo ucwords(strtolower($btMODELO));?></div></td>
				  <td><input onkeypress="return handleEnter(this, event)" name="modelo[]" class="form-control" type="text" size="40" value="<?php echo $rowx['modelo'];?>"></td>
				</tr>
				<tr> 
				  <td><div align="right" class="contentheading"><?php echo $btcategmedios1;?></div></td>
				  <td> <input onkeypress="return handleEnter(this, event)" name="categ[]" class="form-control" type="text" size="20" value="<?php echo $rowx['categ'];?>" readonly></td>
				</tr>
				<tr> 
				  <td><div align="right" class="contentheading"><?php echo $bttipo;?></div></td>
					<td><?php 	$tipoaa=""; 
						if(($rowx['categ']) =="COMPUTADORAS"){ $tipoaa= $arrecomp;$tt=5;}
						elseif(($rowx['categ']) =="MONITOR"){ $tipoaa= $arremon;$tt=3;}
						elseif(($rowx['categ']) =="BOCINAS"){ $tipoaa= $arreboc;$tt=2;}
						elseif(($rowx['categ']) =="SWITCH"){ $tipoaa= $arreSWI;$tt=2;}
						elseif(($rowx['categ']) =="MODEM"){ $tipoaa= $arremod;$tt=2;}
						elseif(($rowx['categ']) =="ROUTER"){ $tipoaa= $arrerou;$tt=3;}
						elseif(($rowx['categ']) =="IMPRESORA"){ $tipoaa= $arreimp;$tt=2;}
						elseif(($rowx['categ']) =="MOUSE"){ $tipoaa= $arremou;$tt=5;}
						elseif(($rowx['categ']) =="TECLADOS"){ $tipoaa= $arretec;$tt=5;}
						elseif(($rowx['categ']) =="ESCANNER"){ $tipoaa= $arreesc;$tt=2;}
						elseif(($rowx['categ']) =="FOTOCOPIADORA"){ $tipoaa= $arrefot;$tt=2;}
						elseif(($rowx['categ']) =="UPS"){ $tipoaa= $arreups;$tt=2;}
						elseif(($rowx['categ']) =="PLOTER"){ $tipoaa= $arreplo;$tt=2;}
						elseif(($rowx['categ']) =="MEMORIAS"){ $tipoaa= $arremem;$tt=1;}
						if(($rowx['categ']) =="CAMARA" OR ($rowx['categ']) =="ADAPTADORES" OR ($rowx['categ']) =="PINZA"){ ?>
							<input onkeypress="return handleEnter(this, event)" name="tipo[]" class="form-control" type="text" size="30" value="<?php echo $rowx['tipo'];?>"><?php 
						}else{ ?>
							<select onkeypress="return handleEnter(this, event)" class="form-control" name="tipo[]" id="tipo"><?php
								foreach($tipoaa as $ky=>$fg){  
									for($f=0; $f<$tt;$f++){?>							
										<option value="<?php echo $fg[$f];?>" <?php if(($rowx['tipo']) ==$fg[$f]){ echo "selected"; }?>><?php echo $fg[$f];?></option><?php
									}								
								} ?>
							</select><?php
						} ?>
					</td>
				 </tr>
				<tr> 
				  <td><div align="right" class="contentheading"><?php echo $btCustodios;?></div></td>
				  <td> <select onkeypress="return handleEnter(this, event)" name="custo[]" class="form-control" size="1"><?php
								while ($row_Recordset1 = mysqli_fetch_array($Recordset1)) {  ?>
									<option value="<?php echo $row_Recordset1['nombre']?>" <?php if(($row_Recordset1['nombre']) ==$rowx['custodio']){ echo "selected";}?>><?php echo $row_Recordset1['nombre'];?></option><?php
								} ?>
					</select> </td>
				</tr>
				<tr> 
				  <td><div align="right" class="contentheading"><?php echo $bttipo;?>-AFT</div></td>
				  <td> <select onkeypress="return handleEnter(this, event)" name="taft[]" class="form-control" size="1"><?php
							while ($row_Recordset4 = mysqli_fetch_array($Recordset4)) { ?>
								<option value="<?php echo $row_Recordset4['categoria']?>" <?php if(($rowx['t_AFT']) ==$row_Recordset4['categoria']){ echo "selected";}?>><?php echo $row_Recordset4['categoria']?></option><?php
							} ?>
					</select>
					<input onkeypress="return handleEnter(this, event)" name="id[]" type="hidden" size="40" value="<?php echo $rowx['id'];?>" />
					<input onkeypress="return handleEnter(this, event)" name="idunidades[]" type="hidden" size="40" value="<?php echo $rowx['idunidades'];?>" /></td>
				</tr><?php
				if(($rowx['categ']) =='COMPUTADORAS'){ ?>
					<tr>
					  <td><div align="right" class="contentheading"><?php echo $btenred;?></div></td>
						<td colspan="2">
							<select onkeypress="return handleEnter(this, event)" class="form-control" onchange="if((this.value) =='n' || (this.value) =='-1'){ document.getElementById('r1<?php echo $ff;?>').style.display='none'; document.getElementById('r2<?php echo $ff;?>').style.display='none'; }else if((this.value) =='s'){  document.getElementById('r1<?php echo $ff;?>').style.display='block'; document.getElementById('r2<?php echo $ff;?>').style.display='block';  };" name="enred[]">
								<option value="-1" <?php if(($rowx['enred']) ==""){ echo "selected";} ?>>--</option>
								<option value="s" <?php if(($rowx['enred']) =="s"){ echo "selected";} ?>><?php echo $yes1;?></option>
								<option value="n"<?php if(($rowx['enred']) =="n"){ echo "selected";} ?>>No</option>
							</select>			
						</td>
						<td>&nbsp;</td>
					</tr><?php
				} 
				if(($rowx['categ']) =='COMPUTADORAS'){ ?>
					<tr>
					  <td><div id="r1<?php echo $ff;?>" align="right" class="contentheading"><?php echo $btConectividad;?></div></td>
						<td colspan="2">
							<div id="r2<?php echo $ff;?>">
								<select onkeypress="return handleEnter(this, event)" class="form-control" name="conect[]">
									<option value="Internet"<?php if(($rowx['conect']) =="Internet"){ echo "selected";} ?>>Internet</option>
									<option value="Intranet"<?php if(($rowx['conect']) =="Intranet"){ echo "selected";} ?>>Intranet</option>
								</select>					
							</div>					
						</td>
						<td>&nbsp;</td>
					</tr><?php
				} ?>				
				<tr> 
				  <td colspan="2"><hr></td>
				</tr><?php
				if(($rowx['enred']) !="s" AND ($rowx['t_AFT']) =='COMPUTADORAS'){ ?>
					<script type="text/javascript">
						document.getElementById("r1<?php echo $ff;?>").style.display = "none"; 
						document.getElementById("r2<?php echo $ff;?>").style.display = "none";
					</script><?php 
				}?>	    <?php 
				$ff++;
			}
		}?>
				<tr> 
				  <td>&nbsp;</td>
				  <td><input type="submit" name="modificado" value="<?php echo $btaceptar;?>" class="btn"> 
					<input type="button" name="volVer" value="<?php echo $btcancelar?>" onClick="window.parent.location='registromedios1.php?m=m';" class="btn"></td>
				</tr>
		  </table>
		</form><?php
	}
	if(isset($_REQUEST['modificado'])){
		$idx=$_REQUEST['id'];
		$pinv=$_REQUEST['inv'];
		$pdecr=$_REQUEST['desc'];
		$pestado=$_REQUEST['estado'];
		$pnombre=$_REQUEST['nombre'];
		@$psello=$_REQUEST['sello'];
		$pmarca=$_REQUEST['marca'];
		$pserie=$_REQUEST['serie'];
		$pmodelo=$_REQUEST['modelo'];
		$pcateg=$_REQUEST['categ'];
		@$ptipo=$_REQUEST['tipo'];
		$pcusto=$_REQUEST['custo'];
		$ptaft=$_REQUEST['taft'];
		@$enred=$_REQUEST['enred'];
		@$conect=$_REQUEST['conect'];
		$tidunidades=$_REQUEST['idunidades'];
		$x=0;
		$arreglo ="";
		$arreglo1 = "";
		foreach($idx as $key){
			$ft ="select * from aft WHERE id='".$key."'";
			$seup = mysqli_query($miConex, $ft) or die(mysql_error());
			$quseup = mysqli_fetch_array($seup);
			$upx ="update exp set inv='".$pinv[$x]."' WHERE inv='".$quseup['inv']."'";
			$qupx =mysqli_query($miConex, $upx) or die(mysql_error());
			if(($enred[$x]) =="s"){
				$enredx[$x] = "s";
				$conectx[$x] =$conect[$x];
			}else{
				$enredx[$x] ="n"; 
				$conectx[$x] = "";
			}
			$up ="update aft set conect='".$conectx[$x]."', enred='".$enredx[$x]."', inv='".$pinv[$x]."', descrip='".htmlentities($pdecr[$x])."', estado='".$pestado[$x]."', idarea='".htmlentities($pnombre[$x])."', sello='".$psello[$x]."', marca='".$pmarca[$x]."', no_serie='".$pserie[$x]."', modelo='".$pmodelo[$x]."', categ='".$pcateg[$x]."', tipo='".htmlentities($ptipo[$x])."', custodio='".htmlentities($pcusto[$x])."', t_AFT='".$ptaft[$x]."', idunidades='".$tidunidades[$x]."' WHERE id='".$key."'";
			$qup =mysqli_query($miConex, $up) or die(mysql_error());

			
			if(($pcateg[$x])=='COMPUTADORAS'){
			      $sqlex = "UPDATE exp SET custodio='".htmlentities($pcusto[$x])."' WHERE inv='".$quseup['inv']."' AND  idunidades='".$quseup['idunidades']."' AND id_area='".$quseup['id_area']."'";
			      $resultex = mysqli_query($miConex, $sqlex) or die(mysql_error());
				if(($pinv[$x]) !=""){
					$arreglo .= $pinv[$x]."*";
					$arreglo1 .= $quseup['idunidades']."*";
				}
			}
			$x++;
		}

		if(($arreglo) !=""){ 		?>
			<form name="modif" id="modif" method="post" action="modificarexp_modal.php">
				<input name="inv" id="inv" type="hidden" value="<?php echo $arreglo;?>">
				<input name="donde" id="donde" type="hidden" value="v2">
				<input type="hidden" name="idunidades" value="<?php echo $arreglo1;?>">
			</form>
			<script type="text/javascript">document.modif.submit();</script><?php 
		}?>
			<script type="text/javascript">
				document.location="registrousb.php";
			</script> 
		<?php
	}
	if(isset($_REQUEST["insertar"]))	{
		if(isset($_REQUEST["iusb"]))	{
		?><script type="text/javascript">document.location='form-insertaraft.php?u';</script><?php 
		}else{
			?><script type="text/javascript">document.location='form-insertaraft.php';</script><?php 
		}
	}
	if(isset($_REQUEST["crash"]) AND ($_REQUEST["crash"]) !=""){
		if(isset($_REQUEST["marcado"])){ $marcado = $_REQUEST["marcado"];}
		if(isset($_REQUEST["marcado"])){ $marcado = $_REQUEST["marcado"];}
			if((@$marcado) ==""){ 
			  echo "<br><br>";
			  show_message($strerror,$plea8.$mostrar1.".","cancel","registromedios1.php");  			?>
			    <br><br><div id="footer" class="degradado" align="center">
				    <div class="container">
					    <p class="credit"><?php include ("version.php");?></p>
				    </div>
			    </div><?php
			  exit;
			} 
	$sqfk = "SET FOREIGN_KEY_CHECKS=0;";
	mysqli_query($miConex, $sqfk) or die(mysql_error());	
		foreach($marcado as $i){		
			$sql1 = "select * FROM aft WHERE id='".$i."'";
			$result = mysqli_query ($sql1) or die(MYSQL_ERROR());
			$area = mysqli_fetch_array($result);	
			$esta=strtolower($area['categ']);
			$unidad_esta=$area['idunidades'];
			//insertar  en bajas_aft
			$sql = "insert into bajas_aft (id_area, titulo, inv, fecha, idarea, tiene, link, organo, descrip, estado, sello, marca, no_serie, modelo, categ,tipo,custodio,t_AFT,idunidades) values ('".$area['id_area']."','sin Dictamen','".$area['inv']."', '".$fecha."', '".$area['idarea']."', 'n','','', '".$area['descrip']."', 'PB', '".$area['sello']."', '".$area['marca']."','".$area['no_serie']."','".$area['modelo']."','".$area['categ']."','".$area['tipo']."','".$area['custodio']."','".$area['t_AFT']."','".$area['idunidades']."')";
			$resultv = mysqli_query($miConex, $sql) or die(mysql_error());

			//insertar  en bajas_exp
			$sql1e = "select * FROM exp WHERE inv='".$area['inv']."'";
			$resulte = mysqli_query ($sql1e) or die(MYSQL_ERROR());
			$areaexp = mysqli_fetch_array($resulte);	
		
			if(($esta) =="computadoras"){
				$sqlaf = "insert into bajas_exp (idarea,id_area,inv,CPU,PLACA,CHIPSET,MEMORIA,MEMORIA2,GRAFICS,DRIVE1,DRIVE2,DRIVE3,DRIVE4,SONIDO,RED,RED2,OS,custodio,n_PC, idunidades) values ('".$areaexp['idarea']."', '".$areaexp['id_area']."', '".$areaexp['inv']."', '".$areaexp['CPU']."', '".$areaexp['PLACA']."', '".$areaexp['CHIPSET']."', '".$areaexp['MEMORIA']."','".$areaexp['MEMORIA2']."','".$areaexp['GRAFICS']."','".$areaexp['DRIVE1']."','".$areaexp['DRIVE2']."','".$areaexp['DRIVE3']."','".$areaexp['DRIVE4']."','".$areaexp['SONIDO']."','".$areaexp['RED']."','".$areaexp['RED2']."','".$areaexp['OS']."','".$areaexp['custodio']."','".$areaexp['n_PC']."', '".$areaexp['idunidades']."')";	
				$resultaf = mysqli_query($miConex, $sqlaf) or die(MYSQL_ERROR());
			}
			
			if(($esta) =="computadoras"){
				$sql4 = "DELETE FROM exp WHERE inv='".$area['inv']."' AND idunidades='".$unidad_esta."'";
				$resultado4 = mysqli_query($miConex, $sql4) or die(MYSQL_ERROR());			
			}
			
			$sql3 = "DELETE FROM aft WHERE id='".$i."'";
			$resultado3 = mysqli_query($miConex, $sql3) or die(MYSQL_ERROR());
						
			 // Buscar la categoria para agregar el total
			$ff="SELECT * FROM areas";
			$resulta = mysqli_query($miConex, $ff) or die(MYSQL_ERROR());
			if (!$resulta) {
				echo 'No se puede ejecutar la Consulta: ' . mysql_error();
				exit;
			}

			$num_campo = mysqli_num_fields($resulta);
			
			
			for ($ia=1; $ia<=$num_campo;$ia++) {
				$nom_campo = @mysql_field_name($resulta, $ia-1);
				if ($nom_campo == strtolower($esta))  {
					$sql2="Select ".$esta." from areas where nombre='".$area['idarea']."' AND idunidades='".$unidad_esta."'";
					$resultado1 = mysqli_query($miConex, $sql2)  or die("La consulta fall&oacute;: " . mysql_error());
					$linea = mysqli_fetch_array($resultado1);	
					
					$valor_col =$linea[$esta]-1;				  
					$sql3="UPDATE areas SET ".$esta."='".$valor_col."' where nombre='".$area['idarea']."' AND idunidades='".$unidad_esta."'";
					$result = mysqli_query($miConex, $sql3) or die("La consulta fall&oacute;: " . mysql_error()); 
				}
			}
				
		} // end for 
		$sqfk1 = "SET FOREIGN_KEY_CHECKS=1;";
		mysqli_query($miConex, $sqfk1) or die(mysql_error());			?>
			<script type="text/javascript">
				window.parent.location="bajas.php";
			</script> 
		<?php 
	}
?>
</div>
</fieldset><br>
<?php include ("version.php");?>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<div class="dialogoInfo"></div>