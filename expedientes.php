<?php 
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                		            #
# Version:  3.1.1                                                     				                        #
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
$ordena="";
$cat_medios = Array("computadoras"=>"images/pc.png", "impresora"=>"images/impresoras.png", "monitor"=>"images/monitores.png", "escanner"=>"images/scan.png", "teclado"=>"images/teclado.png", "switch"=>"images/swicth.png", "router"=>"images/router.png", "modem"=>"images/modem.png", "ploter"=>"images/ploter.png", "camara"=>"images/camara.png", "memorias"=>"images/memoria_usb.png", "mouse"=>"images/mouse_optico.png","adaptadores"=>"images/adaptadores.png","ups"=>"images/ups.png","bocinas"=>"images/bocinas.png","fotocopiadora"=>"images/fotocopiadora.png","pinza"=>"images/pinza.png","hddinternos"=>"images/hddinterno.png","filtros"=>"images/filtros.png","hddexternos"=>"images/hddexterno.png","dvd"=>"images/dvd.png","cd"=>"images/cd.png","cartuchos"=>"images/cartucho.png","toner"=>"images/toner.png","voip"=>"images/voip.png","dataswicht"=>"images/dataswitch.png","datashow"=>"images/datashow.png");

if ($_SESSION ["valid_user"]!='invitado') {
	$selvi = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
	$qselvi = mysqli_query($miConex, $selvi) or die(mysqli_error());
	$rsel = mysqli_fetch_array($qselvi);	
}

$Uact = "";
$Uactb="";

if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$Uactb = $_COOKIE['unidades'];
	$unidades = $_COOKIE['unidades'];
	
	$sql_uactivabc = "select * from datos_generales where id_datos='".$Uactb."'";
	$result_uactivabc= mysqli_query($miConex, $sql_uactivabc) or die(mysqli_error());
	
	$scuantos = "select * from areas where idunidades='".$Uactb."' AND (nombre !='Reparaciones')";
	$qcuantos = mysqli_query($miConex, $scuantos) or die(mysqli_error());
    $porunidad = $unidades;  

	if((mysqli_num_rows($result_uactivabc)) ==0){ ?>
		<script type="text/javascript">
			document.cookie = "unidades=1;";
			document.location="expedientes.php";
		</script><?php
	}
}else{
	$sql_uactivab = "select * from datos_generales";
	$result_uactivab= mysqli_query($miConex, $sql_uactivab) or die(mysqli_error());
	$ractivab = mysqli_fetch_array($result_uactivab);
	$Uactb = $ractivab['id_datos'];
	$scuantos = "select * from areas where idunidades='".$Uactb."' AND (nombre !='Reparaciones')";
	$qcuantos = mysqli_query($miConex, $scuantos) or die(mysqli_error());
	$porunidad =1;
	
} ?>
<link href="css/template.css" rel="stylesheet">
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript">
	
	function hacer(valo){
		document.location="expedientes.php?marcado[]="+valo+"&edit=edit";

	}
	function showModalz(){
	document.location='#modal4';
	}
</script>
<?php
include('barra.php');
@include('script.php');
$i=0;
$cuantos = mysqli_num_rows($qcuantos);

if(($_SESSION ["valid_user"]!='invitado' and $rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}

$ordena=@$_REQUEST['ordena'];
   
///////navegador
		$inicio = 0; 
		$pagina = 1; 
		$registros = $cuantos;
		
	if(isset($_REQUEST["registros"])) {
		$registros = $_REQUEST["registros"];
		$inicio = 0; 
		$pagina = 1;
	}
	if(isset($_REQUEST['pagina']))  { 
		$pagina=$_REQUEST['pagina'];
		$inicio = ($pagina - 1) * $registros; 
	}
	if(isset($_REQUEST["mostrar"])) {
		$registros = $_REQUEST["mostrar"];
		if(($registros) ==0){ $registros=1;}
		$inicio = 0; 
		$pagina = 1;
	}
///////////

	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$sql_uactiva = "select * from datos_generales where id_datos='".$_COOKIE['unidades']."'";
	}else{
		$sql_uactiva = "select * from datos_generales";
	}
		
	$result_uactiva= mysqli_query($miConex, $sql_uactiva) or die(mysqli_error());
	$ractiva = mysqli_fetch_array($result_uactiva);

if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
 $resultadosS = "SELECT * FROM areas where idunidades='".$_COOKIE['unidades']."' AND (nombre !='Reparaciones')";
 $resultados = mysqli_query($miConex,$resultadosS) or die(mysqli_error());
 $total_registros = mysqli_num_rows($resultados);
 $total_paginas = ceil($total_registros / $registros);
 
 # Total de Medios en taller
 $resultaller = "SELECT * FROM areas where idunidades='".$_COOKIE['unidades']."' AND (nombre ='Reparaciones') ORDER BY nombre";
 $resutaller = mysqli_query($miConex, $resultaller) or die(mysqli_error());
 
}else{
 $resultadosS = "SELECT * FROM areas where nombre !='Reparaciones' ORDER BY nombre";
 $resultados = mysqli_query($miConex , $resultadosS) or die(mysqli_error());
 $total_registros = mysqli_num_rows($resultados);
 $total_paginas = ceil($total_registros / $registros);
 
 # Total de Medios en taller
 $resultaller = "SELECT * FROM areas where nombre ='Reparaciones' ORDER BY nombre";
 $resutaller = mysqli_query($miConex, $resultaller) or die(mysqli_error());
 
} 
function total($campo, $miConex) {
	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	  $consulta  = "SELECT SUM(".$campo.") as valor_col FROM areas where idunidades='".$_COOKIE['unidades']."'";
	}else{ 
	 $consulta  = "SELECT SUM(".$campo.") as valor_col FROM areas";
	}
	$resultado1 = mysqli_query($miConex, $consulta) or die("La consulta fall&oacute;: " . mysqli_error());
	$linea = mysqli_fetch_array($resultado1);
  	echo $linea['valor_col']."\n";
}
  
 function reparac($campo, $miConex) {
	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$consulta  = "SELECT SUM(".$campo.") as valor_col FROM areas where nombre='Reparaciones' AND idunidades='".$_COOKIE['unidades']."'";
	}else{ 
	 $consulta  = "SELECT SUM(".$campo.") as valor_col FROM areas where nombre='Reparaciones'";
	}
	$resultado1 = mysqli_query($miConex, $consulta) or die(mysqli_error());
	$linea = mysqli_fetch_array($resultado1);
  	echo $linea['valor_col']."\n";
}    
   
   // llenar la lista de unidades

	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	  $sql = "SELECT * FROM areas where idunidades='".$_COOKIE['unidades']."' AND (nombre !='Reparaciones') ORDER BY idunidades, nombre limit ".$inicio.",".$registros;
	  $contx1 = "SELECT * FROM areas where idunidades='".$_COOKIE['unidades']."' AND (nombre !='Reparaciones') kk ORDER BY nombre limit ".$inicio.",".$registros;
	  $result= mysqli_query($miConex, $sql) or die(mysqli_error());
	}else{
	  $sql = "select * from areas where (nombre !='Reparaciones') ORDER BY idunidades, nombre limit ".$inicio.",".$registros;
	  $contx1 = "select * from areas where (nombre !='Reparaciones') kk ORDER BY nombre limit ".$inicio.",".$registros;
	  $result= mysqli_query($miConex, $sql) or die(mysqli_error());	  
	}	

	$n_campos = mysqli_num_fields($result);
	$cantidaddere= mysqli_num_rows($result);
	$ggg = base64_encode($sql);
	$contx = base64_encode($contx1);
	$UNIDAD = @$_COOKIE['unidades'];

?>
<form action="q.php" method="post" name="contel" id="contel">
	<input name="calcular" value="1" type="hidden">
	<input name="marcado[]" id="marcado" type="hidden">
</form>
<form action="q.php" method="post" name="conted" id="conted">
	<input name="expediente" value="1" type="hidden">
	<input name="marcado[]" id="marcado" type="hidden">
</form>
<script type="text/javascript" src="js/scrolltopcontrol.js">
/***********************************************
* Scroll To Top Control script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Please keep this notice intact
* Visit Project Page at http://www.dynamicdrive.com for full source code
***********************************************/
</script> 
<script type="text/javascript">
    $(document).ready(function() {
	    for(r=0;r<<?php echo $total_registros;?>;r++){		
			$("#tooltip"+r).mouseover(function(){
			$("#tooltip"+r).mousemove(function(e){
			$(this).next().css({left : e.pageX , top: e.pageY});
			 });
			eleOffset = $(this).offset();
			$(this).next().fadeIn("fast").css({
				left: eleOffset.left + $(this).outerWidth(),
				top: eleOffset.top
			});
				}).mouseout(function(){
					$(this).next().fadeOut("fast");
				});
	    }
	});		
function accion(id,q){
	if((q) =="c"){
		document.contel.marcado.value=id;
		document.contel.submit();
	}else{
		document.conted.marcado.value=id;
		document.conted.submit();
	}
}
function contextual(event,id){
	var iX = event.clientX;
	var iY = event.clientY;
	event.preventDefault();
	$('#divMenu').css({
		display:	'block',
		font: '11px/1em Arial',
		left:		iX,
		top:		iY
	});

	$('#divMenu').html('<ul><li onclick="accion(\''+id+'\',\'m\');"><a style="cursor:pointer; text-decoration:none;" ><img title="<?php  echo $Sho;?>..." align="asbmiddle" src="images/mostrar.png" width="16" height="16">&nbsp;&nbsp;<?php  echo $Sho;?></a></li><li onclick="accion(\''+id+'\',\'c\');"><a style="cursor:pointer; text-decoration:none;" ><img align="asbmiddle" src="images/calcular.png" width="16" height="16" title="<?php echo $Calcular;?>...">&nbsp;&nbsp;<?php echo $Calcular;?></a></li><li onclick="showModalz();"><a style="cursor:pointer; text-decoration:none;" ><img align="asbmiddle" src="images/totalizar.png" width="16" height="16" title="<?php echo $Totalizar;?>...">&nbsp;&nbsp;<?php echo $Totalizar;?></a></li></ul>');

	$(document).on('click',function(){
		//$('#divMenu').css('display','none');
	});
}
</script>
<div id="divMenu"></div>
<div id="modal4" class="modalmask">
<div class="modalbox rotate" style="width: 40%; height: 343px; border-radius: 5px 5px 5px 5px;">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -13px; width: 566px; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2  class="pos"><?php echo $btdatosentidad1;?>: <?php echo ($ractiva['entidad']);?></h2></div>
		<p><iframe src="totalizar.php" name="b" scrolling="Auto" width="102%" height="300" frameborder="0" class="notice" border="0"></iframe></p>
	</div>
</div>
<div id="buscad"> 
<fieldset class="fieldset">
<legend class="vistauserx"><?php echo $btAREASRES;?><?php if(($unidadactiva) !=""){ echo "&nbsp;&nbsp;&nbsp;".$btdatosentidad3.": <font color='red'>".$unidadactiva."</font>"; }?></legend>
	<table width="100%" border="0" >
		<tr>
			<td width="788"><div style="position: relative; margin-top: 7px; padding-bottom: 8px;">
				<form name="mst" method="post" action="expedientes.php" id="mst">
					<span><?php echo $cantidadmost;?>:</span>
					<span style="position: absolute; margin-left: 0%; margin-top: -11px;">
	       				<span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'ascendente');" style="cursor:pointer; position: absolute; margin-left: 30px; margin-top: 5px; z-index: 999;"><img src="gfx/asc.png"></span>
						<span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'descendente');" style="cursor:pointer; position: absolute; margin-top: 17px; margin-left:30px; z-index: 999;"><img src="gfx/desc.png"></span>
						<input name="mostrar" id="vers" type="text" maxlength="3" value="<?php if (!isset($_REQUEST['mostrar'])) { if ($rowsp['visitas']>$total_registros) { echo $total_registros; }else{ echo $registros; } }else{ if ($_REQUEST['mostrar']>$total_registros) { echo $total_registros; }else{ echo $_REQUEST['mostrar'];} if($_REQUEST['mostrar']<1) { echo "1"; } } ?>" onKeyPress="return acceptNum(event);" class="mostrar" readonly>
						<img src="images/search.png" style="cursor:pointer; top: 4px; position: relative;" onclick="document.mst.submit();">
					</span>	
						<input name="pagina" type="hidden" value="<?php echo $pagina;?>">
						<input name="mo" type="hidden" value="<?php echo $btver;?>" class="btn4">
						<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
						<input name="palabra" type="hidden"  value="<?php echo @$palabra;?>">
						<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">
				</form></div>
			</td>
			<td width="130">
				<div id="imprime" style="margin: 0px 65px;">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><?php 
					if(($_SESSION['valid_user']) !="invitado" AND ($total_registros) !=0){ ?>
                      <td class="email"><a class="tooltip" href="pdf/mail.php?query=<?php echo $ggg;?>&tb=areas&gt=expedientes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($s_email);?></span></a></td><?php
					} ?>
                      <td class="pdf"><a class="tooltip" href="pdf/tuto1.php?query=<?php echo $ggg;?>&tb=areas">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($cr_pdf);?></span></a></td>
                      <td class="exel"><a class="tooltip" href="w.php?query=<?php echo $ggg;?>&tb=areas">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($cr_exel);?></span></a></td>
                      <td class="printer"><a class="tooltip" href="imprimir/index.php?inicio=<?php echo $inicio;?>&registros=<?php echo $registros;?>&tb=areas" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($sav_print);?></span></a></td>
                    </tr>
                  </table>				  
				</div>
			</td>
		</tr><?php
	if(($ractivaa) >1){ ?>
	  <tr>
		<td colspan="2">
			<form action="" method="post" name="formU"><?php echo $btdatosentidad2;?>:
				<select name="unidades" id="unidades" class="form-control" style="width:19%; margin-left:73px; margin-top: -20px;"  onchange="cambiaunidad(this.value,'expedientes.php');">
					<option value="-1"><?php echo $btmostrartodo1?></option><?php 
						while ($row1=mysqli_fetch_array($reado)){ ?>					
							<option value="<?php echo @$row1['id_datos'];?>" <?php if((@$row1['id_datos']) ==@$_COOKIE['unidades']){ echo "selected";}?>><?php echo @$row1['entidad'];?></option><?php
						} ?>
				</select>
					<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
					<input name="palabra" type="hidden"  value="<?php echo @$palabra;?>">
					<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">
				
			</form>
		</td>
	  </tr><?php
	} ?>
    </table>
	<div id="resultado">
		<form action="q.php" method="post" name="frm1" id="frm1">
    		<table border="0" class="table" align="center" id="tablestructure" cellpadding="0" cellspacing="0">
				<tr class="vistauser1" style="background: #d34d4629;">
				    <td width="20">
						<div id="cheque1" onClick="exped1('<?php echo $inicio;?>','<?php echo $registros;?>'); marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
						<div id="cheque2" onClick="exped2(); desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
					</td>
					<td width="5"></td>
					<?php 
						for($n=1; $n<=28; $n++){ 
							$fields  = mysqli_fetch_field_direct ($result, $n); 
							$name1 = $fields->name;
							$flags = $fields->flags; ?>
						  <td width="<?php if ($name1=="nombre") { echo "200px;"; }else { echo "25px;"; } ?>"><span class="Estilo4" style="margin-left: -9px; cursor:pointer;" >
						<?php if (array_key_exists($name1, $cat_medios)) { 
								 echo "<span manolo='".strtoupper($name1)."'><img src='".$cat_medios[$name1]."' width='24' height='24' border='0'></span>";
						        }else if((strlen(strtoupper($name1))) >7){ 
							           echo substr(strtoupper($name1),0,-3);
									}else { 
									  echo strtoupper($name1);
									} ?>
						 </span></td><?php 
						}?>
			    </tr>
				<?php 	
			 $id = 0;
			 $p=0;
			
			while($row=mysqli_fetch_array($result)) { $i++;	
				if(($row["nombre"]) !="Reparaciones"){ $rowidarea = $row["idarea"]; ?>
				<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#CCFFCC');" onclick="exped('<?php echo $rowidarea;?>', document.getElementById('marcado<?php echo $p;?>').checked); marca1(<?php echo $p;?>,'#ffffff')" onContextMenu="contextual(event,'<?php echo $row["idarea"]?>');"> 
					
					<td width="5"><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none; cursor:pointer;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff');" value="<?php echo $row['idarea']?>" /></td>	
					<td width="20"><span manolo="<?php echo $TOTALES." PC: ".$row['computadoras'];?>" style="background: url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -702px 202px transparent; height: 26px; width: 30px; float: right; cursor: pointer;" onmouseover="this.style.cursor='pointer';" onclick="seguro4('3');"></span></td>
				<?php 
						for($n=1; $n<=28; $n++){ 
							$field = mysqli_fetch_field_direct($result, $n);
							$name  = $field->name;
							$flags = $field->flags; 
							$id_area[$n] = $field->name;?>
							<td><?php echo $row[$name]; ?><input type="hidden" name="cant" size="4" value="<?php echo $p;?>"></td><?php 
						} 
				} $p++;	 
				
			}  ?>
			    </tr>
				<tr class="navegador dataTables_paginate paging_full_numbers">
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
					<td align="center"><h2><?php echo strtoupper($btTaller); ?></h2></td><?php 
						for($n=2; $n<=28; $n++){ 
							$name1  = mysqli_fetch_field_direct ($result, $n); ?>
							<td><h2><?php echo "<b>".reparac($name1->name, $miConex)."</b>";?></h2></td>
							<?php 
						}?>
				</tr>
				<tr class="navegador dataTables_paginate paging_full_numbers" >
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
					<td align="center"><h3><?php echo $TOTALES;?></h3><br></td><?php 
						for($n=2; $n<=28; $n++){ 
							$name1  = mysqli_fetch_field_direct($result, $n); ?>
							<td><div class="navegador dataTables_paginate paging_full_numbers"><span class="paginate_active"><h2 style="color:#000000; margin-left: -3px;"><?php echo "<b>".total($name1->name, $miConex)."</b>";?></h2></span></div></td>
							<?php 
						} 
						//return recalcula();?>
				</tr>
				<tr>
					<td colspan="16">
						<input name="expediente" type="submit" class="btn" id="expediente" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1." ".$v_ficha;?>','');"  value="<?php  echo $Sho;?>" />&nbsp;&nbsp;
						<input name="calcular" type="submit" class="btn" id="calcular" value="<?php echo $Calcular;?>" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1." ".$Calcular;?>','');" />&nbsp;&nbsp;
						<input name="totalizar" type="button" class="btn" id="totalizar"  value="<?php echo $Totalizar;?>" onclick="showModalz('<?php echo $btdatosentidad1;?>: <?php echo htmlentities($ractiva['entidad']);?>');"/>
					</td>
				</tr>	
			</table>
		</form>
	</div>
	</div>
		<div align="center">
		 <?php include('navegador.php');?>
		</div>	
<a href="#top"></a>			
<div id='detaexped'></div>
</fieldset><br>
	<?php include ("version.php");?>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"></div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
