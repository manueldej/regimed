<!DOCTYPE html>
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
include('mensaje.php'); 

$arrecomp = array("COMPUTADORAS"=>array('PORT&Aacute;TIL','ESCRITORIO','SERVIDOR','CLIENTE LIGERO','SERVIDOR NAS')) ;
$arremon=array("MONITOR"=>array('LCD','LED','CRT'));
$arreboc=array("BOCINA"=>array('PLUG','USB'));
$arreplo=array("PLOTER"=>array('DE PLUMA','DE CHORRO'));
$arreSWI=array("SWITCH"=>array('CABLEADO','INAL&Aacute;MBRICO'));
$arremod=array("MODEM"=>array('EXTERNO','INTERNO'));
$arrerou=array("ROUTER"=>array('USB','INAL&Aacute;MBRICO','PUERTO COM'));
$arremou=array("MOUSE"=>array('PS2','USB','INAL&Aacute;MBRICO','PUERTO COM','DIMM'));
$arretec=array("TECLADO"=>array('PS2','USB','INAL&Aacute;MBRICO','PUERTO COM','DIMM'));
$arreimp=array("IMPRESORA"=>array('MATRICIAL','LASER','CHORRO','TERMICA','3D'));
$arreesc=array("ESCANNER"=>array('DE MESA','TRAYECTORIA','DE TAMBOR'));
$arrefot=array("FOTOCOPIADORA"=>array('A COLOR','BLANCO Y NEGRO'));
$arreups=array("UPS"=>array('CONVENSIONALES','PARA SERVIDORES'));
$arremem=array("MEMORIAS"=>array('USB'));
$fecha = date("d/m/Y");
$ff=0;	
	if (isset($_REQUEST["editar"])) {
		if(isset($_REQUEST["marcado"])){ 
		 $marcado = $_REQUEST["marcado"];
		 $cantidad = count($marcado);
		}
		if(($marcado) ==""){ echo "<br><br>";
			show_message($strerror,$plea8.$mostrar1.".","cancel","registromedios1.php");  ?>
			  <br>
				<?php include ("version.php");
			exit;
		} ?>
<link href="css/template.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
 function cambiasello(sello, estado,id,idta,talon) {
	if (estado =="Disponible") {
		document.getElementById(id).value = sello;
		document.getElementById(idta).value = talon;	
	}else{
		alert('Sello ' +sello+ ' No disponible');
	}
	 
 }
</script>
<?php include('barra.php');?>		
		<script language="JavaScript" >
			// Chequeo que no se queden campos obligatorios en blanco 
				function checkq(cantidad) {
				   	var formValid=false;
					var f = document.form1;
					var counx =0;
							
     				for (qt=0; qt<cantidad; qt++){
					    	for (i=0;i<f.elements.length;i++){
							  ids = f.elements[i].id;
							  idcomp = "serr"+(qt); 
				
							    if (ids==idcomp){
								counx = counx + 1;
								}
							} 
						 
						 if (counx!=0) {
							formValid=false;
							return false;
						 }
					}
					
					if (f.inv.value == '') {
						alert("<?php echo 'El campo Inv. est&aacute; en blanco.'; ?>");
						f.inv.focus();
						formValid=false;} 
					else if (f.desc.value == '') {
						alert("<?php echo 'El campo Descripci&oacute;n est&aacute; en blanco.'; ?>");
						f.desc.focus();
						formValid=false;} 
					else if ( f.nombre.value == '' ) {
						alert("<?php echo 'El campo &Aacuterea est&aacute; en blanco.'; ?>");
						f.nombre.focus();
						formValid=false;} 
					else if ( f.categ.value == '-1' ) {
						alert("<?php echo 'Por favor seleccione la categor&iacute;a.'; ?>");
						f.categ.focus(); 
						formValid=false; 	} 
					else if ( f.tipo.value == '' ) {
						alert("<?php echo 'El campo Tipo est&aacute; en blanco.'; ?>");
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
		<div id="buscad">
		<fieldset class='fieldset'><legend class="vistauserx"><?php echo $bteditar;?> AFT</legend>
		<form action="" method="get" name="form1" onsubmit="return checkq('<?php echo $cantidad; ?>');">
			<table width="46%" border="0" align="center" ><?php
					
		for($y=0;$y<count($marcado); $y++){
           	
			$se = "select * FROM aft WHERE id='".$marcado[$y]."'";
			$qse = mysqli_query($miConex, $se) or die(mysql_error());
			
			while($rowx=mysqli_fetch_array($qse)){ 
				$query_Recordset1 = "SELECT * FROM usuarios WHERE idunidades='".$rowx['idunidades']."' AND idarea='".$rowx['idarea']."' order by nombre";
				$Recordset1 = mysqli_query($miConex, $query_Recordset1) or die(mysql_error());
				
				$query_Recordset3 = "SELECT * FROM areas WHERE idunidades='".$rowx['idunidades']."' AND nombre='".$rowx['idarea']."' order by nombre";
				$Recordset3 = mysqli_query($miConex,$query_Recordset3) or die(mysql_error());
				$row_Recordset3 = mysqli_fetch_array($Recordset3);
		
				$query_Recordset2 = "SELECT * FROM tipos_medios";
				$Recordset2 = mysqli_query($miConex,$query_Recordset2) or die(mysql_error());
					
				$query_Recordset4 = "SELECT * FROM tipos_aft";
				$Recordset4 = mysqli_query($miConex,$query_Recordset4) or die(mysql_error()); 
				
				$query_Recordset5 = "SELECT * FROM sellos WHERE estado='Disponible'";
				$Recordset5 = mysqli_query($miConex,$query_Recordset5) or die(mysql_error());
				$damemas = mysqli_num_rows($Recordset5);
				
				$query_Recordset6 = "SELECT * FROM tipos_medios";
				$Recordset6 = mysqli_query($miConex,$query_Recordset6) or die(mysql_error());
				
				?>
				<tr> 
				  <td colspan="3"></td>
				</tr>
				<tr> 
				  <td width="72"><div align="right" class="contentheading">Inv</div></td>
				  <td colspan="2"><input required onKeyPress="return handleEnter(this, event)" name="inv[]" id="inv<?php echo $ff;?>" class="form-control" type="text" value="<?php echo $rowx['inv'];?>" onblur="return validaedit(this.value,'aft','inv','editar','<?php echo $rowx['inv'];?>','err<?php echo $ff;?>');" ><span name="err[]" id="err<?php echo $ff;?>" class="textod" style="display:none;"></span></td>
				</tr>
				<tr> 
				  <td><div align="right" class="contentheading"><?php echo $DESCRIPCION1;?></div></td>
				  <td colspan="2"><input required onKeyPress="return handleEnter(this, event)" name="desc[]" id="desc<?php echo $ff; ?>" class="form-control" type="text" size="40" value="<?php echo $rowx['descrip'];?>" onkeyup="llamaorgano(this.value,'categ','desc<?php echo $ff; ?>','catego<?php echo $ff; ?>');"><span id="catego<?php echo $ff; ?>" onClick="document.getElementById('catego<?php echo $ff; ?>').style.display ='none';" class="mstra" style="width: 316px; padding: 5px; margin-left: 200px; display:none;"></span></td>
				</tr>
				<tr> 
				  <td><div align="right" class="contentheading"><?php echo ucwords($btestado);?></div></td>
				  <td colspan="2"><label> 
					<select onkeypress="return handleEnter(this, event)" name="estado[]" class="form-control" size="1">
					  <option value="A" <?php if(($rowx['estado']) =="A"){ echo "selected";}?>><?php echo $btActivo;?></option>
					  <option value="R" <?php if(($rowx['estado']) =="R"){ echo "selected";}?>><?php echo $btRoto;?></option>
					  <option value="T" <?php if(($rowx['estado']) =="T"){ echo "selected";}?>><?php echo $btTaller;?></option>
					</select>
					</label></td>
				</tr>
				<tr> 
				  <td><div align="right" class="contentheading"><?php echo substr($btAreas,0,-1);?></div></td>
				  <td colspan="2"><input onKeyPress="return handleEnter(this, event)" type="text" readonly style="font-style: oblique; color: rgb(255, 255, 255); font-size: medium;" name="nombre[]" size="40" class="form-control" value="<?php echo $row_Recordset3['nombre'];?>"></td>
				</tr>
				<tr> 
				  <td><div align="right" class="contentheading"><?php echo ucwords(strtolower($btMARCA));?></div></td>
				  <td colspan="2"><input onKeyPress="return handleEnter(this, event)" name="marca[]" id="marca<?php echo $ff; ?>" class="form-control" type="text" size="40" value="<?php echo $rowx['marca'];?>" onKeyUp="llamaorgano(this.value,'marcas','marca<?php echo $ff; ?>','orgn<?php echo $ff; ?>');"><span id="orgn<?php echo $ff; ?>" onClick="document.getElementById('orgn<?php echo $ff; ?>').style.display ='none';" class="mstra" style="width: 325px; margin-left: 200px; display:none;"></span></td>
				</tr>
				<tr> 
				  <td><div align="right" class="contentheading">Serie</div></td>
				  <td colspan="2"><input onKeyPress="return handleEnter(this, event)" name="serie[]" class="form-control" type="text" id="t35" size="40" value="<?php echo $rowx['no_serie'];?>"></td>
				</tr>
				<tr> 
				  <td><div align="right" class="contentheading"><?php echo ucwords(strtolower($btMODELO));?></div></td>
				  <td colspan="2"><input onKeyPress="return handleEnter(this, event)" name="modelo[]" class="form-control" type="text" size="40" value="<?php echo $rowx['modelo'];?>"></td>
				</tr>
				<tr> 
				<td><div align="right" class="contentheading"><?php echo $btcategmedios1;?></div></td>
				<td colspan="2">
				  	<select onkeypress="return handleEnter(this, event)" name="categ[]" size="1" class="form-control" id="categ" onchange="llena(this.value,<?php echo $ff; ?>);">
						<option value="-1"><?php echo $seleccione.$btcategmedios1;?></option><?php
							while ($row_Recordset6 = mysqli_fetch_array($Recordset6)){ ?>
						<option value="<?php echo $row_Recordset6['nombre']?>" <?php if ($row_Recordset6['nombre']==$rowx['categ']) { echo "selected"; }?>><?php echo $row_Recordset6['nombre']; ?></option> <?php
							} ?>
					</select>
      		    </td>
				</tr>
				<tr>
				  <td><div align="right" id="tipoc<?php echo $ff;?>" style="display:block;" class="contentheading"><?php echo $bttipo;?><input name="muestra1" type="checkbox" id="muestra1" style="cursor:pointer; display:none;" onClick="" value="muestra1" />
			      <?php if($rowx['sello']=="") { ?><span manolo="Mostrar/Ocultar Sellos" id="oji0" style="background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -559px 202px; height: 21px; width: 30px; float: right; cursor: pointer; position: absolute; margin-left: 19px; margin-top: -2px;" onmouseover="this.style.cursor='pointer';" onclick="if (getElementById('muestra1').checked==false) {getElementById('muestra1').checked=true; getElementById('oji0').style='background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -113px 202px; height: 21px; width: 30px; float: right; cursor: pointer; position: absolute; margin-left: 19px; margin-top: -2px;' }else{getElementById('muestra1').checked=false; getElementById('oji0').style='background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -559px 202px; height: 21px; width: 30px; float: right; cursor: pointer; position: absolute; margin-left: 19px; margin-top: -2px;'} if(getElementById('muestra1').checked) { document.getElementById('sellito1').style.display = 'block'; document.getElementById('sellito2').style.display = 'block'; document.getElementById('sellito3').style.display = 'block';}else{document.getElementById('sellito1').style.display = 'none'; document.getElementById('sellito2').style.display = 'none'; document.getElementById('sellito3').style.display = 'none';}"></span><?php } ?></div></td>
					<td colspan="2"><div id="topic<?php echo $ff;?>" style="display:none;" >
						<input name="usb1[]" class="form-control" type="hidden" id="usb1<?php echo $ff;?>" size="20" value="<?php echo $rowx['tipo']; ?>">
						<div id="resto<?php echo $ff;?>"><select onkeypress="return handleEnter(this, event)" class="form-control" onchange="carga(this.value,usb1<?php echo $ff; ?>);" name="usb[]" id="usb<?php echo $ff;?>"><option value="-1">--</option></select></div>
						</div><div id="tipoc2<?php echo $ff;?>" style="display:block;" ><?php $tipoaa=""; 
						if(($rowx['categ']) =="COMPUTADORAS"){ $tipoaa= $arrecomp;$tt=5;}
						elseif(($rowx['categ']) =="MONITOR"){ $tipoaa= $arremon;$tt=3;}
						elseif(($rowx['categ']) =="BOCINA"){ $tipoaa= $arreboc;$tt=2;}
						elseif(($rowx['categ']) =="SWITCH"){ $tipoaa= $arreSWI;$tt=2;}
						elseif(($rowx['categ']) =="MODEM"){ $tipoaa= $arremod;$tt=2;}
						elseif(($rowx['categ']) =="ROUTER"){ $tipoaa= $arrerou;$tt=3;}
						elseif(($rowx['categ']) =="IMPRESORA"){ $tipoaa= $arreimp;$tt=5;}
						elseif(($rowx['categ']) =="MOUSE"){ $tipoaa= $arremou;$tt=5;}
						elseif(($rowx['categ']) =="TECLADO"){ $tipoaa= $arretec;$tt=5;}
						elseif(($rowx['categ']) =="ESCANNER"){ $tipoaa= $arreesc;$tt=3;}
						elseif(($rowx['categ']) =="FOTOCOPIADORA"){ $tipoaa= $arrefot;$tt=2;}
						elseif(($rowx['categ']) =="UPS"){ $tipoaa= $arreups;$tt=2;}
						elseif(($rowx['categ']) =="PLOTER"){ $tipoaa= $arreplo;$tt=2;}
						elseif(($rowx['categ']) =="MEMORIAS"){ $tipoaa= $arremem;$tt=1;}
						if(($rowx['categ']) =="CAMARA" OR ($rowx['categ']) =="ADAPTADORES" OR ($rowx['categ']) =="PINZA"){ ?>
							<input onKeyPress="return handleEnter(this, event)" name="tipo[]" id="tipo<?php echo $ff;?>" class="form-control" type="text" size="30" value="<?php echo $rowx['tipo'];?>"><?php 
						}else{ ?>
							<select onkeypress="return handleEnter(this, event)" class="form-control" name="tipo[]" id="tipo<?php echo $ff;?>" onchange="carga(this.value,usb1<?php echo $ff; ?>);"><?php
								foreach($tipoaa as $ky=>$fg){  
									for($f=0; $f<$tt;$f++){?>							
										<option value="<?php echo $fg[$f];?>" <?php if(($rowx['tipo']) ==$fg[$f]){ echo "selected"; }?>><?php echo $fg[$f];?></option><?php
									}								
								} ?>
							</select><?php
						} ?></div>
				  </td>
				</tr>
				<tr> 
				  <td><div id="sellito1" style="<?php if (($rowx['categ']=="COMPUTADORAS") OR ($rowx['sello']!="")) { ?>display:block; <?php }else{ ?>display:none;<?php } ?>"><div align="right" class="contentheading"><?php echo ucwords($btSELLO);?></div></div></td>
				  <td width="98"><div id="sellito2" style="<?php if (($rowx['categ']=="COMPUTADORAS") OR ($rowx['sello']!="")) { ?>display:block; <?php }else{ ?>display:none;<?php } ?>"><input onKeyPress="return handleEnter(this, event)" name="sello[]" id="sello<?php echo $ff;?>" style="width: 74px; height: 23px;" class="form-control" readonly type="text" size="40" value="<?php echo $rowx['sello'];?>"> <input type="hidden" name="selloviejo[]" id="selloviejo<?php echo $ff;?>" value="<?php echo $rowx['sello'];?>"></div> </td>
				  <td width="257"><div id="sellito3" style="<?php if (($rowx['categ']=="COMPUTADORAS") OR ($rowx['sello']!="")) { ?>display:block; <?php }else{ ?>display:none;<?php } ?>"><select style="height: 27px; width: 80%;" onkeypress="return handleEnter(this, event)" name="sello1[]" class="form-control" size="1">
							<option value="-1"><?php echo $nuevsello; ?></option><?php 
							while ($row_Recordset5 = mysqli_fetch_array($Recordset5)) { ?>
							   	<option value="<?php echo $row_Recordset5['numero']?>" onClick="cambiasello(this.value,'<?php echo $row_Recordset5['estado']; ?>','sello<?php echo $ff;?>','idta<?php echo $ff;?>','<?php echo $row_Recordset5['idtalon']; ?>');" <?php if(($rowx['sello']) ==$row_Recordset5['numero']){ echo "selected";}?>><?php echo $row_Recordset5['numero']?></option><?php
							} ?>
				  </select><input name="idta[]" id="idta<?php echo $ff;?>" value="" type="hidden"><?php if($damemas==0) { ?>
				  <i id="massellos<?php echo $ff; ?>" onclick="document.location='sellos.php';" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -23px; margin-left: 217px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -1px -90px;'></i><span style="cursor:pointer; margin-top: -24px; width: 21%;" manolo="<?php echo $clickmas.''; ?>"></span><?php } ?>
				  </div></td>
				</tr>
				<tr> 
				  <td><div align="right" class="contentheading"><?php echo $btCustodios;?></div></td>
				  <td colspan="2"> <select onkeypress="return handleEnter(this, event)" name="custo[]" class="form-control" size="1"><?php
								while ($row_Recordset1 = mysqli_fetch_array($Recordset1)) {  ?>
									<option value="<?php echo $row_Recordset1['nombre']?>" <?php if(($row_Recordset1['nombre']) ==$rowx['custodio']){ echo "selected";}?>><?php echo $row_Recordset1['nombre'];?></option><?php
								} ?>
					</select> </td>
				</tr>
				<tr> 
				  <td><div align="right" class="contentheading"><?php echo $bttipo;?>-AFT</div></td>
				  <td colspan="2"><select onkeypress="return handleEnter(this, event)" name="taft[]" class="form-control" size="1"><?php
							while ($row_Recordset4 = mysqli_fetch_array($Recordset4)) { ?>
								<option value="<?php echo $row_Recordset4['categoria']?>" <?php if(($rowx['t_AFT']) ==$row_Recordset4['categoria']){ echo "selected";}?>><?php echo $row_Recordset4['categoria']?></option><?php
							} ?>
					</select>
					<input onKeyPress="return handleEnter(this, event)" name="id[]" type="hidden" size="40" value="<?php echo $rowx['id'];?>" />
					<input onKeyPress="return handleEnter(this, event)" name="idunidades[]" type="hidden" size="40" value="<?php echo $rowx['idunidades'];?>" /></td>
				</tr>
				<tr>
				  <td><?php if (($rowx['categ']=="COMPUTADORAS") OR ($rowx['categ']=="IMPRESORA")) { ?><div align="right" class="contentheading"><?php echo $btenred;?></div><?php } ?></td>
					<td colspan="3"><?php if (($rowx['categ']=="COMPUTADORAS") OR ($rowx['categ']=="IMPRESORA")) { ?>
						<select onkeypress="return handleEnter(this, event)" class="form-control" onChange="if((this.value) =='n' || (this.value) =='-1'){ document.getElementById('r1<?php echo $ff;?>').style.display='none'; document.getElementById('r2<?php echo $ff;?>').style.display='none'; }else if((this.value) =='s'){  document.getElementById('r1<?php echo $ff;?>').style.display='block'; document.getElementById('r2<?php echo $ff;?>').style.display='block';  };" name="enred[]">
							<option value="-1" <?php if(($rowx['enred']) ==""){ echo "selected";} ?>>--</option>
							<option value="s" <?php if(($rowx['enred']) =="s"){ echo "selected";} ?>><?php echo $yes1;?></option>
							<option value="n"<?php if(($rowx['enred']) =="n"){ echo "selected";} ?>>No</option>
						</select><?php } ?></td>
				</tr>
				<tr>
					<td><div id="r1<?php echo $ff;?>" align="right" class="contentheading"><?php echo $btenred;?></div></td>
					<td colspan="2"><div id="r2<?php echo $ff;?>" align="right" class="contentheading">
						<select onkeypress="return handleEnter(this, event)" class="form-control" onchange="enredado(this.value);" name="enred[]" id="enred">
							<option value="s" <?php if ($rowx['enred']=='s') { echo "selected"; } ?>><?php echo $yes1;?></option>
							<option value="n" <?php if ($rowx['enred']=='n') { echo "selected"; } ?>>No</option>
						</select></div>
					</td>
				</tr>					
				<tr>
				  <td><div id="r3<?php echo $ff;?>" align="right" class="contentheading"><?php echo $btConectividad;?></div></td>
					<td colspan="3">
						<div id="r4<?php echo $ff;?>">
							<select onkeypress="return handleEnter(this, event)" class="form-control" name="conect[]">
								<option value="Intranet"<?php if(($rowx['conect']) =="Intranet"){ echo "selected";} ?>>Intranet</option>
								<option value="Internet"<?php if(($rowx['conect']) =="Internet"){ echo "selected";} ?>>Internet</option>
							</select>					
						</div>					
					</td>
				</tr>	
				<tr> 
				  <td colspan="3"><hr></td>
				</tr><?php
				if(($rowx['enred']) !="s"){ ?>
					<script type="text/javascript">
						document.getElementById("r3<?php echo $ff;?>").style.display = "none"; 
						document.getElementById("r4<?php echo $ff;?>").style.display = "none";
					</script><?php 
				}?>	    
				<script type="text/javascript">
					function enredado(t){
					if((t) =='s'){
						document.getElementById("r3<?php echo $ff;?>").style.display = "block";
						document.getElementById("r4<?php echo $ff;?>").style.display = "block";
					}else{
						document.getElementById("r3<?php echo $ff;?>").style.display = "none";
						document.getElementById("r4<?php echo $ff;?>").style.display = "none";					
					}
				}
				</script>
				<script type="text/javascript">
				var valor;
				var val="";
				var arreg = new Array("COMPUTADORAS","PLOTER","MONITOR","SWITCH","MODEM","ROUTER","IMPRESORA","TECLADO","MOUSE","ESCANNER","FOTOCOPIADORA","BOCINA","UPS","MEMORIAS","-1") ;
				
				function llena(val,ff){
	           		for(i=0; i<arreg.length; i++){
						if((arreg[i]) !=val){
							document.getElementById("resto"+ff).style.display = "block";
							document.getElementById("resto"+ff).innerHTML = '<input onblur="carga(this.value,usb1<?php echo $ff; ?>);" name="usb<?php echo $ff-1;?>" id="usb<?php echo $ff-1;?>" type="text" size="40" value="" class="form-control">';
						}			
					}
					
					if((val) !=""){	
						if (val =="-1") {
							document.getElementById("topic"+ff).style.display = "none";
							document.getElementById("tipoc2"+ff).style.display = "block";
						}else{
							document.getElementById("topic"+ff).style.display = "block";
							document.getElementById("tipoc2"+ff).style.display = "none";
						}
						if((val) =="COMPUTADORAS"){
							document.getElementById("resto"+ff).innerHTML = '<select class="form-control" onchange="carga(this.value,usb1<?php echo $ff; ?>);" name="ta10[]" id="at10<?php echo $ff;?>"><option value="-1">---</option><option value="PORT&Aacute;TIL">PORT&Aacute;TIL</option><option value="SERVIDOR NAS">SERVIDOR NAS</option><option value="ESCRITORIO">ESCRITORIO</option><option value="SERVIDOR">SERVIDOR</option><option value="CLIENTE LIGERO">CLIENTE LIGERO</option></select>';
						}else if((val) =="MONITOR"){
							document.getElementById("resto"+ff).innerHTML = '<select class="form-control" onchange="carga(this.value,usb1<?php echo $ff; ?>);" name="ta10[]" id="at10<?php echo $ff;?>"><option value="-1">---</option><option value="LCD">LCD</option><option value="LED">LED</option><option value="CRT">CRT</option></select>';
						}else if((val) =="TECLADOS"){
							document.getElementById("resto"+ff).innerHTML = '<select class="form-control" onchange="carga(this.value,usb1<?php echo $ff; ?>);" name="ta10[]" id="at10<?php echo $ff;?>"><option value="-1">---</option><option value="PS2">PS2</option><option value="USB">USB</option><option value="INAL&Aacute;MBRICO">INAL&Aacute;MBRICO</option><option value="PUERTO COM">PUERTO COM</option></select>';
						}else if((val) =="PLOTER"){
							document.getElementById("resto"+ff).innerHTML = '<select class="form-control" onchange="carga(this.value,usb1<?php echo $ff; ?>);" name="ta10[]" id="at10<?php echo $ff;?>"><option value="-1">---</option><option value="DE PLUMA">DE PLUMA</option><option value="DE CHORRO">DE CHORRO</option></select>';
						}else if((val) =="SWITCH"){
							document.getElementById("resto"+ff).innerHTML = '<select class="form-control" onchange="carga(this.value,usb1<?php echo $ff; ?>);" name="ta10[]" id="at10<?php echo $ff;?>"><option value="-1">---</option><option value="CABLEADO">CABLEADO</option><option value="INAL&Aacute;MBRICO">INAL&Aacute;MBRICO</option></select>';
						}else if((val) =="MODEM"){
							document.getElementById("resto"+ff).innerHTML = '<select class="form-control" onchange="carga(this.value,usb1<?php echo $ff; ?>);" name="ta10[]" id="at10<?php echo $ff;?>"><option value="-1">---</option><option value="EXTERNO">EXTERNO</option><option value="INTERNO">INTERNO</option></select>';
						}else if((val) =="ROUTER"){
							document.getElementById("resto"+ff).innerHTML = '<select class="form-control" onchange="carga(this.value,usb1<?php echo $ff; ?>);" name="ta10[]" id="at10<?php echo $ff;?>"><option value="-1">---</option><option value="USB">USB</option><option value="PUERTO COM">PUERTO COM</option></select>';
						}else if((val) =="MEMORIAS"){
							document.getElementById("resto"+ff).innerHTML = '<select class="form-control" onchange="carga(this.value,usb1<?php echo $ff; ?>);" name="ta10[]" id="at10<?php echo $ff;?>"><option value="-1">---</option><option value="USB">USB</option></select>';
						}else if((val) =="MOUSE"){
							document.getElementById("resto"+ff).innerHTML = '<select class="form-control" onchange="carga(this.value,usb1<?php echo $ff; ?>);" name="ta10[]" id="at10<?php echo $ff;?>"><option value="-1">---</option><option value="PS2">PS2</option><option value="USB">USB</option><option value="INAL&Aacute;MBRICO">INAL&Aacute;MBRICO</option><option value="PUERTO COM">PUERTO COM</option><option value="DIMM">DIMM</option></select>';
						}else if((val) =="TECLADO"){
							document.getElementById("resto"+ff).innerHTML = '<select class="form-control" onchange="carga(this.value,usb1<?php echo $ff; ?>);" name="ta10[]" id="at10<?php echo $ff;?>"><option value="-1">---</option><option value="PS2">PS2</option><option value="USB">USB</option><option value="INAL&Aacute;MBRICO">INAL&Aacute;MBRICO</option><option value="PUERTO COM">PUERTO COM</option><option value="DIMM">DIMM</option></select>';
						}else if((val) =="IMPRESORA"){
							document.getElementById("resto"+ff).innerHTML = '<select class="form-control" onchange="carga(this.value,usb1<?php echo $ff; ?>);" name="ta10[]" id="at10<?php echo $ff;?>"><option value="-1">---</option><option value="Matricial">Matricial</option><option value="Laser">Laser</option></select>';
						}else if((val) =="ESCANNER"){
							document.getElementById("resto"+ff).innerHTML = '<select class="form-control" onchange="carga(this.value,usb1<?php echo $ff; ?>);" name="ta10[]" id="at10<?php echo $ff;?>"><option value="-1">---</option><option value="DE MESA">DE MESA</option><option value="DE TRAYECTORIA">DE TRAYECTORIA</option><option value="DE TAMBOR">DE TAMBOR</option></select>';
						}else if((val) =="FOTOCOPIADORA"){
							document.getElementById("resto"+ff).innerHTML = '<select class="form-control" onchange="carga(this.value,usb1<?php echo $ff; ?>);" name="ta10[]" id="at10<?php echo $ff;?>"><option value="-1">---</option><option value="A COLOR">A COLOR</option><option value="BLANCO Y NEGRO">BLANCO Y NEGRO</option></select>';
						}else if((val) =="UPS"){
							document.getElementById("resto"+ff).innerHTML = '<select class="form-control" onchange="carga(this.value,usb1<?php echo $ff; ?>);" name="ta10[]" id="at10<?php echo $ff;?>"><option value="-1">---</option><option value="CONVENSIONALES">CONVENSIONALES</option><option value="PARA SERVIDORES">PARA SERVIDORES</option></select>';
						}else if((val) =="BOCINA"){
							document.getElementById("resto"+ff).innerHTML = '<select class="form-control" onchange="carga(this.value,usb1<?php echo $ff;?>);" name="ta10[]" id="at10<?php echo $ff;?>"><option value="-1">---</option><option value="PLUG">PLUG</option><option value="USB">USB</option></select>';
						}								
					}
				}
				function carga(valor,idcomp){
				  idcomp.value=valor;
				}
			</script>  
				<?php 
				$ff++;
			}
		}?>
				<tr> 
				  <td>&nbsp;</td>
				  <td colspan="2">
				   	<input type="submit" name="modificado" value="<?php echo $btaceptar;?>" class="btn"> 
					<input type="button" name="volVer" value="<?php echo $btcancelar?>" onClick="javascript:document.location='registromedios1.php?m=m';" class="btn"></td>
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
		@$selloviejo=$_REQUEST['selloviejo'];
		$pmarca=$_REQUEST['marca'];
		$pserie=$_REQUEST['serie'];
		$pmodelo=$_REQUEST['modelo'];
		$pcateg=$_REQUEST['categ'];
		@$ptipo=$_REQUEST['usb1'];
		@$idtalon=$_REQUEST['idta'];
		
		$pcusto=$_REQUEST['custo'];
		$ptaft=$_REQUEST['taft'];
		@$enred=$_REQUEST['enred'];
		$conect=$_REQUEST['conect'];
		$tidunidades=$_REQUEST['idunidades'];
		$x=0;
		$arreglo ="";
		$arreglo1 = "";
		
		foreach($idx as $key){
			$ft ="select * from aft WHERE id='".$key."'";
			$seup = mysqli_query($miConex,$ft) or die(mysql_error());
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

		// Busco el Talón qué está activo 
		$sqltal = "SELECT * FROM talones WHERE estado='Activo'"; 
		$resultal = mysqli_query($miConex, $sqltal) or die(mysql_error());
		$talonactivo =  mysqli_fetch_array($resultal);
		
		// Actualizo el estado de sello
		$sqlsello = "UPDATE sellos SET estado='En Uso' WHERE numero='".$psello[$x]."' AND idtalon='".$idtalon[$x]."'"; 
		$resultsello = mysqli_query($miConex, $sqlsello) or die(mysql_error());
	    
			// Marcar el sello viejo con Retirado
			if ($psello[$x] != $selloviejo[$x])  {
				$sqlselloviejo = "UPDATE sellos SET estado='Desechado', observ='Sustituci&oacute;n' WHERE numero='".$selloviejo[$x]."' AND idtalon='".$talonactivo['id']."'"; 
				$resultselloviejo = mysqli_query($miConex, $sqlselloviejo) or die(mysql_error());
			}elseif(($psello[$x] == $selloviejo[$x]) AND ($talonactivo['id']!=$idtalon[$x])) {
				$sqlselloviejo = "UPDATE sellos SET estado='Desechado', observ='Sustituci&oacute;n' WHERE numero='".$selloviejo[$x]."' AND idtalon='".$talonactivo['id']."'"; 
				$resultselloviejo = mysqli_query($miConex, $sqlselloviejo) or die(mysql_error());
			}
		
			if(($pcateg[$x])=='COMPUTADORAS'){
			      $sqlex = "UPDATE exp SET custodio='".htmlentities($pcusto[$x])."' WHERE inv='".$quseup['inv']."' AND  idunidades='".$quseup['idunidades']."' AND id_area='".$quseup['id_area']."'";
			      $resultex = mysqli_query($miConex, $sqlex) or die(mysql_error());
				if(($pinv[$x]) !=""){
					$arreglo .= $pinv[$x]."*";
					$arreglo1 .= $quseup['idunidades']."*";
				}
			}
			// Actualizo el estado del Talón. Si todos sus sellos han sido retirado pues inactivo el talón
				$sqltalcie = "SELECT COUNT(id) as totalse from sellos where (estado='Disponible') AND idtalon='".$talonactivo['id']."'";
				$restalcie = mysqli_query($miConex, $sqltalcie) or die(mysql_error());
				$totalse =  mysqli_fetch_array($restalcie);
				
				if($totalse['totalse']==0) {
				  $sqltalviejo = "UPDATE talones SET estado='Terminado' WHERE id='".$talonactivo['id']."'"; 
				  $resulttalonviejo = mysqli_query($miConex, $sqltalviejo) or die(mysql_error());

				  $sqltalviejo = "UPDATE talones SET estado='Activo' WHERE id='".$idtalon[$x]."'"; 
				  $resulttalonviejo = mysqli_query($miConex, $sqltalviejo) or die(mysql_error());
				}
		
			$x++;
		}
        
		if(($arreglo) !=""){ ?>
			<form name="modif" id="modif" method="post" action="modificarexp.php">
				<input name="inv" id="inv" type="hidden" value="<?php echo $arreglo;?>">
				<input name="donde" id="donde" type="hidden" value="">
				<input type="hidden" name="idunidades" value="<?php echo $arreglo1;?>">
			</form>
			<script type="text/javascript">document.modif.submit();</script><?php 
		}
		?><script type="text/javascript">document.location='registromedios1.php';</script><?php
	}
	if(isset($_REQUEST["insertar"])){
		if(isset($_REQUEST["itipo"])){
		?><script type="text/javascript">document.location='form-insertaraft.php?u';</script><?php 
		}else{
			?><script type="text/javascript">document.location='form-insertaraft.php';</script><?php 
		}
	}
	if(isset($_REQUEST["crash"]) AND ($_REQUEST["crash"]) !=""){
		if(isset($_GET["marcado"])){ $marcado = $_GET["marcado"];}
		if(isset($_REQUEST["marcado"])){ $marcado = $_REQUEST["marcado"];}
			if((@$marcado) ==""){ 
			  echo "<br><br>";
			  show_message($strerror,$plea8.$mostrar1.".","cancel","registromedios1.php");  			?>
			    <br>
				 <?php include ("version.php");
			  exit;
			} 
	$sqfk = "SET FOREIGN_KEY_CHECKS=0;";
	mysqli_query($miConex, $sqfk) or die(mysql_error());	
		foreach($marcado as $i){		
			$sql1 = "select * FROM aft WHERE id='".$i."'";
			$result = mysqli_query ($miConex, $sql1) or die(MYSQL_ERROR());
			$area = mysqli_fetch_array($result);	
			$esta=strtolower($area['categ']);
			$unidad_esta=$area['idunidades'];
			//insertar  en bajas_aft
			$sql = "insert into bajas_aft (id_area, titulo, inv, fecha, idarea, tiene, link, organo, descrip, estado, sello, marca, no_serie, modelo, categ,tipo,custodio,t_AFT,idunidades) values ('".$area['id_area']."','sin Dictamen','".$area['inv']."', '".$fecha."', '".$area['idarea']."', 'n','','', '".$area['descrip']."', 'PB', '".$area['sello']."', '".$area['marca']."','".$area['no_serie']."','".$area['modelo']."','".$area['categ']."','".$area['tipo']."','".$area['custodio']."','".$area['t_AFT']."','".$area['idunidades']."')";
			$resultv = mysqli_query($miConex, $sql) or die(mysql_error());
			//insertar  en bajas_exp
			$sql1e = "select * FROM exp WHERE inv='".$area['inv']."'";
			$resulte = mysqli_query ($miConex, $sql1e) or die(MYSQL_ERROR());
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
				 $fields = mysqli_fetch_field_direct ($resulta, $ia-1);
				 $nom_campo = $fields->name;
				
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
		mysqli_query($miConex, $sqfk1) or die(mysql_error());	?>
			<script type="text/javascript">
				window.parent.location="bajas.php";
			</script> <?php 
	}
?>
</fieldset><br>
<?php include ("version.php");?>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>