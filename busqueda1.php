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
$ordena="";
$selvi = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";

include('chequeo.php');
class colores {
	public function ColorFila($i,$color1,$color2){
		if (($i % 2)== 0) {
			$this->ColorFondo = $color1;
		}else {
			$this->ColorFondo = $color2;
		}
		return $this->ColorFondo;
	}
}
$color1="#F1F2F3";
$color2="#E9EAEB";

$uCPanel = new colores();
		if (!check_auth_user()){
			?><script type="text/javascript">window.parent.location="index.php";</script><?php
			exit;
		}
	if (!file_exists('connections/miConex.php')){ ?>
		<script type="text/javascript">window.parent.location="installation/index.php";</script><?php
		return;
	}else{
	 require_once('connections/miConex.php');
	} 
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}

	   if ($i=="es") {
	    include('esp.php');
	   }else{
		include('eng.php');
	   }

include('script.php');
$qselvi = mysqli_query($selvi,$miConex) or die(mysql_error());
$rsel = mysqli_fetch_array($qselvi);
$cuantos = 5;
if(($rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}
$Uact = "";
$Uactb="";
if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$Uactb = $_COOKIE['unidades'];
	$sql_uactivabc = "select * from datos_generales where id_datos='".$Uactb."'";
	$result_uactivabc= mysqli_query($sql_uactivabc,$miConex) or die(mysql_error());
	if((mysqli_num_rows($result_uactivabc)) ==0){ ?>
		<script type="text/javascript">
			document.cookie = "unidades=1;";
			document.location="expedientes.php";
		</script><?php
	}
}else{
	$sql_uactivab = "select * from datos_generales";
	$result_uactivab= mysqli_query($sql_uactivab,$miConex) or die(mysql_error());
	$ractivab = mysqli_fetch_array($result_uactivab);
	$Uactb = $ractivab['id_datos'];
} 


?>
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript">
	
	function hacer(valo){
		document.location="expedientes.php?marcado[]="+valo+"&edit=edit";

	}
	function showModalz(){
	//	$('.dialogoInfo').html('<div id="myModal" class="modal hide fade" ><div class="modal-header rojo">'+pos+'<button class="close" type="button" data-dismiss="modal" aria-hidden="true">x</button></div><div class="modal-body"><p align="center"><iframe src="totalizar.php" name="b" scrolling="Auto" width="100%" height="300" frameborder="0" class="notice" border="0"></iframe></p></div><div class="modal-footer"><button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button></div></div>');
	//	$('#myModal').modal();
	document.location='#modal4';
	}
</script>
<?php
@include('script.php');
$i=0;
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
		
	$result_uactiva= mysqli_query($sql_uactiva, $miConex) or die(mysql_error());
	$ractiva = mysqli_fetch_array($result_uactiva);

if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
 $resultadosS = "SELECT * FROM areas where idunidades='".$_COOKIE['unidades']."' AND (nombre !='Reparaciones')";
 $resultados = mysqli_query($resultadosS, $miConex) or die(mysql_error());
 $total_registros = mysqli_num_rows($resultados);
 $total_paginas = ceil($total_registros / $registros);
}else{
 $resultadosS = "SELECT * FROM areas where nombre !='Reparaciones'";
 $resultados = mysqli_query($resultadosS, $miConex) or die(mysql_error());
 $total_registros = mysqli_num_rows($resultados);
 $total_paginas = ceil($total_registros / $registros);
} 
function total($campo) {
	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$consulta  = "SELECT SUM(".$campo.") as valor_col FROM areas where idunidades='".$_COOKIE['unidades']."'";
	}else{ 
	 $consulta  = "SELECT SUM(".$campo.") as valor_col FROM areas";
	// echo $consulta;
	}
	$resultado1 = mysqli_query($consulta) or die("La consulta fall&oacute;: " . mysql_error());
	$linea = mysqli_fetch_array($resultado1);
   
	echo $linea['valor_col']."\n";
	/* Liberar conjunto de resultados */
	
	//echo $consulta;
	//mysqli_free_result($resultado);
}
  
     
// llenar la lista de unidades

	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	  $sql = "SELECT * FROM areas where idunidades='".$_COOKIE['unidades']."' AND (nombre !='Reparaciones') ORDER BY nombre limit ".$inicio.",".$registros;
	  $contx1 = "SELECT * FROM areas where idunidades='".$_COOKIE['unidades']."' AND (nombre !='Reparaciones') kk ORDER BY nombre limit ".$inicio.",".$registros;
	  $result= mysqli_query($sql, $miConex) or die(mysql_error());
	}else{
	  $sql = "select * from areas where (nombre !='Reparaciones') ORDER BY nombre limit ".$inicio.",".$registros;
	  $contx1 = "select * from areas where (nombre !='Reparaciones') kk ORDER BY nombre limit ".$inicio.",".$registros;
	  $result= mysqli_query($sql, $miConex) or die(mysql_error());	  
	}	
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
<div class="modalbox rotate" style="width: 54%; height: 343px; border-radius: 5px 5px 5px 5px;">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -13px; width: 563px; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2  class="pos"><?php echo $btdatosentidad1;?>: <?php echo ($ractiva['entidad']);?></h2></div>
		<p><iframe src="totalizar.php" name="b" scrolling="Auto" width="102%" height="300" frameborder="0" class="notice" border="0"></iframe></p>
	</div>
</div>
	<form action="q.php" method="post" name="frm1" id="frm1">
    		<table border="0" class="table" align="center" id="tablestructure" cellpadding="0" cellspacing="0">
				<tr class="vistauser1">
				    <td width="20">
						<div id="cheque1" onClick="marcar_todo();"  style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
						<div id="cheque2" onClick="desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
					</td>
					<td width="5"></td>
					<?php 
						for($n=1; $n<=14; $n++){ 
							$name1  = mysql_field_name  ($result, $n); 
							$flags = mysql_field_flags  ($result, $n); ?>
						  <td><span class="Estilo4">
							<?php if((strlen(strtoupper($name1))) >7){ echo substr(strtoupper($name1),0,-3);}else { echo strtoupper($name1);}?>
						 </span></td><?php 
						}?>
			    </tr>
				<?php 	
			 $id = 0;
			 $p=0;
			 while($row=mysqli_fetch_array($result))	{ $i++;	
				if(($row["nombre"]) !="Reparaciones"){ $rowidarea = $row["idarea"]; ?>
				<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="exped('<?php echo $rowidarea;?>'); marca1(<?php echo $p;?>,'#ffffff')" onContextMenu="contextual(event,'<?php echo $row["idarea"]?>');"> 
					<td width="5"><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none; cursor:pointer;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff'); " value="<?php echo $row['idarea']?>" /></td>	
					<td width="20"><span manolo="<?php echo $TOTALES." PC: ".$row['computadoras'];?>" style="background: url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -702px 202px transparent; height: 26px; width: 30px; float: right; cursor: pointer;" onmouseover="this.style.cursor='pointer';" onclick="seguro4('3');"></span></td>
				<?php 
						for($n=1; $n<=14; $n++){ 
							$name1  = mysql_field_name  ($result, $n); 
							$flags = mysql_field_flags  ($result, $n); ?>
							<td><?php echo $row[$name1];?><input type="hidden" name="cant" size="4" value="<?php echo $p;?>"></td><?php 
						} 
				} $p++;	 
			 }  ?>
			    </tr>
				<tr class="well">
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
					<td align="center"><h3><?php echo $TOTALES;?></h3><br></td><?php 
						for($n=2; $n<=14; $n++){ 
							$name1  = mysql_field_name  ($result, $n); ?>
							<td><h2  style="color:#000000;"><?php echo "<b>".total($name1)."</b>";?></h2></td>
							<?php 
						}?>
				</tr>
				<tr>
					<td colspan="16">
						<input name="expediente" type="submit" class="btn" id="expediente" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1." ".$v_ficha;?>','');"  value="<?php  echo $Sho;?>" />&nbsp;&nbsp;
						<input name="calcular" type="submit" class="btn" id="calcular"  value="<?php echo $Calcular;?>" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1." ".$Calcular;?>','');" />&nbsp;&nbsp;
						<input name="totalizar" type="button" class="btn" id="totalizar"  value="<?php echo $Totalizar;?>" onclick="showModalz('<?php echo $btdatosentidad1;?>: <?php echo htmlentities($ractiva['entidad']);?>');"/>
					</td>
				</tr>	
			</table>
		</form>
<a href="#top"></a>			
<div id='detaexped'></div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>