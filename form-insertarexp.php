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
include('header.php');
include('jquery.php');
$i="es";
$memo0="";
$memo1="";
$memo2="";
$memo3="";
$indice="";
$compo = "";
$varCPU = array('marca','cpuid','frecuencia','fabricante','socket','cpucores','cpulogicos');
$varMemorias = array('marca','modelo','no_serie','fabricante','capacidad','tasa','frecuencia');
$varDiscoDuro = array('marca','modelo','no_serie','fabricante','capacidad','tasa','cache','rpm');
$varTarjetaGrafica = array('marca','modelo','no_serie','fabricante','capacidad','frecuencia');
$varcomponente = array($varCPU,$varMemorias,$varDiscoDuro,$varTarjetaGrafica);
$sistema_operativo = array('Microsoft Windows Server 2008','Microsoft Windows 11','Microsoft Windows 10','Microsoft Windows 8.1','Microsoft Windows 8','Microsoft Windows 7','Microsoft Windows XP','Unix','GNU/Linux','Solaris','Google Ghrome','IO OS');

//Para importar datos de expedientes 

$roo = $_SERVER['DOCUMENT_ROOT'];
$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
$upload_extensions = array(".txt", ".TXT");
    function tamano($size,$digits) {
		$kb=1024; $mb=1024*$kb; $gb=1024*$mb; $tb=1024*$gb;
		if (($size==0)) { 
			return "0 Byte"; 
		}elseif ($size<$kb) { 
			return $size." Byte"; 
		}elseif ($size<$mb) { 
			return round($size/$kb,$digits)." Kb"; 
		}elseif ($size<$gb) { 
			return round($size/$mb,$digits)." Mb"; 
		}elseif ($size<$tb) { 
			return round($size/$gb,$digits)." Gb"; 
		}else { 
			return round($size/$tb,$digits)." Tb"; 
		}
	}
    $carpeta= $roo.$pht1."importar/";
    $fecha=date("dmY");
	
	if (isset($_REQUEST['marcado'])) {
      $fichero = $_REQUEST['marcado'];
	}

	if(isset($_POST['crash']) AND ($_POST['crash']) !=""){	
		if (isset($_REQUEST['marcado'])) {
          $fichero = $_REQUEST['marcado'];
	    }
		if (isset($_REQUEST['inv'])) {
		  $invent = $_REQUEST['inv'];
		}

		@unlink($carpeta.$fichero); ?>
		<script type="text/javascript">
		    //document.location="javascript:history.go(-2)"
       		document.location="form-insertarexp.php?impor=kbpimpirt&inv=<?php echo $invent?>";
		</script>
		<?php
	}
	
// fin importar 	

if(isset($_COOKIE['seulang'])){
   if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
}
	
if(($i) =="es"){include('esp.php');}else{ include('eng.php');}

if (isset($_REQUEST['idunidades'])) {
  $unidad = $_REQUEST['idunidades'];
}else{
  $unidad =1;  
}

$unidadE = $unidad;

if (isset($_REQUEST['inv'])) {
  $invent = $_REQUEST['inv'];
}
if (isset($_REQUEST['impor'])) {
  $impor = $_REQUEST['impor'];
}

if (isset($_REQUEST['q'])){
 $q= $_REQUEST['q'];
}else{
 $q="";
}

	if (isset($_REQUEST['memo0'])) {
	   $memo0 = $_REQUEST['memo0'];
	   $indice =0;
	}
	if(isset($_REQUEST['memo1'])) {
	   $memo1 = $_REQUEST['memo1'];
	   $indice =1;
	}
	if(isset($_REQUEST['memo2'])) {
	   $memo2 = $_REQUEST['memo2'];
	   $indice =2;
	}
	if(isset($_REQUEST['memo3'])) {
	   $memo3 = $_REQUEST['memo3'];
	   $indice =3;
	}
	if (isset($_REQUEST['cpux'])) {
	  $cpux = $_REQUEST['cpux'];
	}else{
	  $cpux="";
	}
	if (isset($_REQUEST['placax'])) {
	  $placax = $_REQUEST['placax'];
	}else{
	  $placax="";
	}
	if (isset($_REQUEST['chipsetx'])) {
	  $chipsetx = $_REQUEST['chipsetx'];
	}else{
	  $chipsetx="";
	}
	if (isset($_REQUEST['tgraficax'])) {
	  $tgraficax = $_REQUEST['tgraficax'];
	}else{
	  $tgraficax="";
	}
	if (isset($_REQUEST['hdd0x'])) {
	  $hdd0x = $_REQUEST['hdd0x'];
	}else{
	  $hdd0x="";
	}
	if (isset($_REQUEST['hdd1x'])) {
	  $hdd1x = $_REQUEST['hdd1x'];
	}else{
	  $hdd1x="";
	}
	if (isset($_REQUEST['lector0x'])) {
	  $lector0x = $_REQUEST['lector0x'];
	}else{
	  $lector0x="";
	}
	if (isset($_REQUEST['lector1x'])) {
	  $lector1x = $_REQUEST['lector1x'];
	}else{
	  $lector1x="";
	}
	if (isset($_REQUEST['sonidox'])) {
	  $sonidox = $_REQUEST['sonidox'];
	}else{
	  $sonidox="";
	}
	if (isset($_REQUEST['red0x'])) {
	  $red0x = $_REQUEST['red0x'];
	}else{
	  $red0x="";
	}
	if (isset($_REQUEST['red1x'])) {
	  $red1x = $_REQUEST['red1x'];
	}else{
	  $red1x="";
	}
	if (isset($_REQUEST['red2x'])) {
	  $red2x = $_REQUEST['red2x'];
	}else{
	  $red2x="";
	}
	if (isset($_REQUEST['fuentex'])) {
	  $fuentex = $_REQUEST['fuentex'];
	}else{
	  $fuentex="";
	}
	if (isset($_REQUEST['osx'])) {
	  $osx = $_REQUEST['osx'];
	}else{
	  $osx="";
	}
	if (isset($_REQUEST['npcx'])) {
	  $npcx = $_REQUEST['npcx'];
	}else{
	  $npcx="";
	}
	if (isset($_REQUEST['compon'])) {
	  $compon = $_REQUEST['compon'];
	}else{
	  $compon="";
	}
	if (isset($_REQUEST['compo'])) {
	  $compo = $_REQUEST['compo'];
	}else{
	  $compo="";
	}

	if (isset($_REQUEST['comp'])) {
       $inv = $_REQUEST['inv']; 
	   $compo = $_REQUEST['compo'];
	   $comp = $_REQUEST['comp'];
	   $marc= $_REQUEST['marca'];
	   $model= $_REQUEST['modelo'];
	   $nser= $_REQUEST['no_serie'];
	   $fab= $_REQUEST['fabricante'];
	   $capac= $_REQUEST['capacidad'];
	   $tasa= $_REQUEST['tasa'];
	   $frecuencia= $_REQUEST['frecuencia'];
	   $cache= $_REQUEST['cache'];
	   $rpm= $_REQUEST['rpm'];
	   $cpuid= $_REQUEST['cpuid'];
	   $cpucores= $_REQUEST['cpucores'];
	   $cpulogicos= $_REQUEST['cpulogicos'];
	   $socket= $_REQUEST['socket'];
	   $interfaz= $_REQUEST['interfaz'];
	   $taip= $_REQUEST['taip'];
	   
	   $sql1 ="SELECT * FROM componentes WHERE nombre ='".$compo."' AND idexp='".$inv."'";
	   $result1 = mysqli_query($miConex, $sql1) or die (mysql_error());
	   $rows1 = mysqli_fetch_array($result1); 
	   $cantrows = mysqli_num_rows($result1);
   
	   if ($cantrows==0) {
	    $sql = "insert into componentes (id,idexp,nombre,marca,modelo,no_serie,fabricante,capacidad,tasa,frecuencia,cache,rpm,interfaz,tipo,cpuid,cpucores,cpulogicos,socket) values (NULL,'".$inv."','".$compo."','".$marc."','".$model."','".$nser."','".$fab."','".$capac."','".$tasa."','".$frecuencia."','".$cache."','".$rpm."','".$interfaz."','".$taip."','".$cpuid."','".$cpucores."','".$cpulogicos."','".$socket."')";
	   }else{
	     $sql = "UPDATE componentes set idexp='".$inv."', nombre='".$compo."',marca='".$marc."',modelo='".$model."',no_serie='".$nser."',fabricante='".$fab."',capacidad='".$capac."',tasa='".$tasa."',frecuencia='".$frecuencia."',cache='".$cache."',rpm='".$rpm."',interfaz='".$interfaz."',tipo='".$taip."',cpuid='".$cpuid."',cpucores='".$cpucores."',cpulogicos='".$cpulogicos."',socket='".$socket."' WHERE id='".$rows1['id']."'";
	   }
	   $resultcomp = mysqli_query($miConex, $sql) or die (mysql_error());
	}else{
	   $sql1 ="SELECT * FROM componentes WHERE nombre ='".$compo."' AND idexp='".@$invent."'";
	   $result1 = mysqli_query($miConex, $sql1) or die (mysql_error());
	   $rows1 = mysqli_fetch_array($result1); 
	   $cantrows = mysqli_num_rows($result1);
	}

$consul = "SELECT * from aft where inv='".@$invent."' AND idunidades='". $unidad."'";
$result = mysqli_query($miConex, $consul) or die(mysql_error());
$row = mysqli_fetch_array ($result);
$resultx = mysqli_query($miConex, "SELECT * from datos_generales where id_datos='". $unidad."'") or die(mysql_error());
$rowx = mysqli_fetch_array ($resultx);

@$query_Recordset1 = "SELECT usuarios.nombre FROM usuarios where nombre ='".$row['custodio']."' AND idunidades='".$unidad."'";
$Recordset1 = mysqli_query($miConex, @$query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysqli_fetch_array($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

?>
<script language="JavaScript" >

// CHEQUEO QUE NINGUN CAMPO QUEDE EN BLANCO 

	function submit_page(){
	  foundError = false;
	  var form=form1;
		if(isFieldBlank(form.t2)) {
		  alert("El campo 'Inv' está en blanco.");
		  form.t2.focus();
		  foundError = true;
		}else
		 if(isFieldBlank(form.t3)) {
		  alert("El campo 'CPU' está en blanco.");
		  form.t3.focus();
		  foundError = true;
		}else
		 if(isFieldBlank(form.t4)) {
		  alert("El campo 'PLACA' está en blanco.");
		  form.t4.focus();
		  foundError = true;
		}else
		 if(isFieldBlank(form.t5)) {
		  alert("El campo 'CHIPSET' está en blanco.");
		  form.t5.focus();
		  foundError = true;
		}else
		 if(isFieldBlank(form.t6)) {
		  alert("El campo 'MEMORIA' está en blanco.");
		  form.t6.focus();
		  foundError = true;
		}else
		 if(isFieldBlank(form.t8)) {
		  alert("El campo 'GRAFICS' está en blanco.");
		  form.t8.focus();
		  foundError = true;
		}else
		 if(isFieldBlank(form.t9)) {
		  alert("El campo 'DRIVE-1' está en blanco.");
		  form.t9.focus();
		  foundError = true;
		}else
		 if(isFieldBlank(form.t16)) {
		  alert("El campo 'SO' está en blanco.");
		  foundError = true;
		}else
	   
		if(foundError == false ){
		  return true; 
		}
	    return false;
	}

	function retornar(form){
	 document.form1.action="registromedios1.php";
	}

	function isFieldBlank(theField){
	 innStr = theField.value;
	 innLen = innStr.length;

	 if(theField.value == "" && innLen==0)
	  return true;
	 else
	  return false;

	}

	function ctype_digit(theField){
	 val = theField.value;
	 Len = val.length;
	 
	  for(var i=0; i<Len; i++)
	  {
	   var ch = val.substring(i,i+1)
	   if(ch < "0" || "16"< ch)
		 return true;
	  }
	}

	function ci(theField){
	 val = theField.value;
	 Len = val.length;

	  for(var i=0; i<Len; i++)
		var chh = val.substring(i,i+1)
		
	  if(i < "16")
		return true;
	}

	function masmemo(id,nuevoid,nuevoid2) {
	  document.getElementById(id).style.display ='none';
	  document.getElementById(nuevoid).style.display ='block';
	  document.getElementById(nuevoid2).style.display ='block';
	}
	
	function menmemo(id,nuevoid,nuevoid2,idvalor) {
	  document.getElementById(id).style.display ='none';
	  document.getElementById(idvalor).value ='';
	  document.getElementById(nuevoid).style.display ='none';
	  document.getElementById(nuevoid2).style.display ='none';
	}

	function seguro4(invent,idunidades,memo0,memo1,memo2,memo3,cpu,placa,chipset,tgrafica,hdd0,hdd1,lector0,lector1,sonido,red0,red1,red2,fuente,os,npc,indice,compon,compo){
		if (compo!=="") {
			document.regresa.inv.value = invent;
			document.regresa.unidad.value = idunidades;
			document.regresa.indice.value = indice;
			document.regresa.memo0.value = memo0;
			document.regresa.memo1.value = memo1;
			document.regresa.memo2.value = memo2;
			document.regresa.memo3.value = memo3;
			document.regresa.cpux.value = cpu;
			document.regresa.placax.value = placa;
			document.regresa.chipsetx.value = chipset;
			document.regresa.tgraficax.value = tgrafica;
			document.regresa.hdd0x.value = hdd0;
			document.regresa.hdd1x.value = hdd1;
			document.regresa.lector0x.value = lector0;
			document.regresa.lector1x.value = lector1;
			document.regresa.sonidox.value = sonido;
			document.regresa.red0x.value = red0;
			document.regresa.red1x.value = red1;
			document.regresa.red2x.value = red2;
			document.regresa.fuentex.value = fuente;
			document.regresa.osx.value = os;
			document.regresa.npcx.value = npc;
			document.regresa.compon.value = compon;
			document.regresa.compo.value = compo;
			document.regresa.action ='#modal6';
			document.regresa.submit();
		 }else{
			document.regresa.memo0.value = memo0;
			document.regresa.memo1.value = memo1;
			document.regresa.memo2.value = memo2;
			document.regresa.memo3.value = memo3;
		   return false; 
		 } 
	}
    function acepta(invent,idunidades,memo0,memo1,memo2,memo3,cpu,placa,chipset,tgrafica,hdd0,hdd1,lector0,lector1,sonido,red0,red1,red2,fuente,os,npc,marca,modelo,no_serie,fabricante,capacidad,tasa,frecuencia,cache,rpm,interfaz,taip,indice,compon,compo,cpuid,cpucores,cpulogicos,socket){
	    var aceptaEntrar = window.confirm("Realmente desea continuar.?");
		if (aceptaEntrar) {
			document.componente.inv.value = invent;
			document.componente.compon.value = compon;
			document.componente.compo.value = compo;
			document.componente.marca.value = marca;
			document.componente.modelo.value = modelo;
			document.componente.no_serie.value = no_serie;
			document.componente.fabricante.value = fabricante;
			document.componente.capacidad.value = capacidad;
			document.componente.tasa.value = tasa;
			document.componente.frecuencia.value = frecuencia;
			document.componente.cache.value = cache;
			document.componente.rpm.value = rpm;
			document.componente.interfaz.value = interfaz;
			document.componente.taip.value = taip;
			document.componente.cpuid.value = cpuid;
			document.componente.cpucores.value = cpucores;
			document.componente.cpulogicos.value = cpulogicos;
			document.componente.socket.value = socket;
			document.componente.unidad.value = idunidades;
			document.componente.indice.value = indice;
			document.componente.memo0.value = memo0;
			document.componente.memo1.value = memo1;
			document.componente.memo2.value = memo2;
			document.componente.memo3.value = memo3;
			document.componente.cpux.value = cpu;
			document.componente.placax.value = placa;
			document.componente.chipsetx.value = chipset;
			document.componente.tgraficax.value = tgrafica;
			document.componente.hdd0x.value = hdd0;
			document.componente.hdd1x.value = hdd1;
			document.componente.lector0x.value = lector0;
			document.componente.lector1x.value = lector1;
			document.componente.sonidox.value = sonido;
			document.componente.red0x.value = red0;
			document.componente.red1x.value = red1;
			document.componente.red2x.value = red2;
			document.componente.fuentex.value = fuente;
			document.componente.osx.value = os;
			document.componente.npcx.value = npc;
			document.componente.submit();
	    }else {
		 return false;
		} 
    }

	function cierra(){
		document.regresa.action ='form-insertarexp.php';
		document.regresa.submit();
	}
 
	function __ir(donde){
	    var aceptaEntrar = window.confirm("Desea realmente cancelar.?");
			if (aceptaEntrar) {
			  document.ir.dde.value = donde;
			  document.ir.submit();
			}else {
			 return false;
			}  
	}	
	
	function cierrz(){
		document.getElementById('cir').innerHTML="";
	}
	function chequea(){
		var tt= document.frm1;
		var cuenta=0;
		for (i=0;i<frm1.elements.length;i++)   {
			if ((frm1.elements[i].type=="radio")&&(frm1.elements[i].checked==true))	 {
				cuenta++;
			}	
		}
		
		if((cuenta) ==0){
			showAlert(4000,'<div class="alert negro" style="display: none"><button class="closex" type="button" onclick="cierrz();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div align="center"><b><?php echo $plea8.$ficher;?>.</b></div></div>');
			return false;		
		}
	}
</script>
	<link href="css/template.css" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="ajax.js"></script> 
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
<?php include('barra.php'); ?>
<form method="post" name="regresa" id="regresa" action="" enctype="multipart/form-data">
	<input name="inv" type="hidden" id="invent" value="<?php echo $invent; ?>"> 
	<input name="unidad" type="hidden" id="unidad" value="<?php echo $unidad; ?>">
	<input name="memo0" type="hidden" id="memo0x" value="<?php echo $memo0; ?>">
	<input name="memo1" type="hidden" id="memo1x" value="<?php echo $memo1; ?>">
	<input name="memo2" type="hidden" id="memo2x" value="<?php echo $memo2; ?>">
	<input name="memo3" type="hidden" id="memo3x" value="<?php echo $memo3; ?>">
	<input name="cpux" type="hidden" id="cpux" value="<?php echo $cpux; ?>">
	<input name="placax" type="hidden" id="placax" value="<?php echo $placax; ?>">
	<input name="chipsetx" type="hidden" id="chipsetx" value="<?php echo $chipsetx; ?>">
	<input name="tgraficax" type="hidden" id="tgraficax" value="<?php echo $tgraficax; ?>">
	<input name="hdd0x" type="hidden" id="hdd0x" value="<?php echo $hdd0x; ?>">
	<input name="hdd1x" type="hidden" id="hdd1x" value="<?php echo $hdd1x; ?>">
	<input name="lector0x" type="hidden" id="lector0x" value="<?php echo $lector0x; ?>">
	<input name="lector1x" type="hidden" id="lector1x" value="<?php echo $lector1x; ?>">
	<input name="sonidox" type="hidden" id="sonidox" value="<?php echo $sonidox; ?>">
	<input name="red0x" type="hidden" id="red0x" value="<?php echo $red0x; ?>">
	<input name="red1x" type="hidden" id="red1x" value="<?php echo $red1x; ?>">
	<input name="red2x" type="hidden" id="red2x" value="<?php echo $red2x; ?>">
	<input name="fuentex" type="hidden" id="fuentex" value="<?php echo $fuentex; ?>">
	<input name="osx" type="hidden" id="osx" value="<?php echo $osx; ?>">
	<input name="npcx" type="hidden" id="npcx" value="<?php echo $npcx; ?>">
	<input name="indice" type="hidden" id="indice" value="<?php echo $indice; ?>">
	<input name="compon" type="hidden" id="compon" value="<?php echo $compon; ?>">
	<input name="compo" type="hidden" id="compo" value="<?php echo $compo; ?>">
</form>
<div id="modal6" class="modalmask" style="background: rgba(50, 48, 48, 0.7);">
	<div class="modalbox resize" style="width: 400px; <?php if($compon=="Disco Duro") { ?>height: 390px;<?php }elseif($compon=="Memorias"){ ?>height: 353px;<?php }elseif($compon=="Tarjeta Grafica"){ ?>height: 319px;<?php }elseif($compon=="Microprocesador"){ ?>height: 335px;<?php } ?>border: 1px solid rgb(194, 35, 16); border-radius: 5px 5px 5px 5px; left: 4%; top: 45px; background: rgb(244, 251, 251) none repeat scroll 0% 0%;">
		<div style="height: 15px; text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.25); background-color: rgb(196, 84, 60); background-image: linear-gradient(to bottom, rgb(#3C85C4), rgb(#3C85C4)); background-repeat: repeat-x; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25); color: rgb(251, 238, 238); padding: 1px 0px 16px 9px; margin-left: -19px; width: 429px; vertical-align: middle; border-radius: 4px 4px 0px 0px; margin-top: -3px;"><span class="btn" onclick="cierra();" style="text-decoration:none; cursor:pointer; color: rgb(194, 35, 16); float:right; width: 15px; top: 0px; margin-right:2px;">X</span>
			<div class="panel-title" style="margin-top: 5px;"><b>ACTUALIZAR COMPONENTE:&nbsp;<?php if (strlen($compo)>=15) { echo substr($compo,0,15)."..."; } else { echo $compo; }?></b></div>
		</div><br>
	<form action="form-insertarexp.php" method="post" name="componente" id="componente">
        <table width="47%" align="center" class="table"><?php 
		 if ($compon!=""){ 
		    if($compon == "Memorias") {
		        foreach ($varcomponente[1] as $clave => $valor) { 
				   $nombcampo[] = $valor; 
				}
			}elseif(($compon == "Microprocesador")) {
		        foreach ($varcomponente[0] as $clave => $valor) { 
				   $nombcampo[] = $valor; 
				}
		    }elseif(($compon == "Tarjeta Grafica")) {
		        foreach ($varcomponente[3] as $clave => $valor) { 
				   $nombcampo[] = $valor; 
				}
		    }elseif(($compon == "Disco Duro")) {
		        foreach ($varcomponente[2] as $clave => $valor) { 
				   $nombcampo[] = $valor; 
				}
		    }
		  
		   for ($a=0; $a<count($nombcampo); $a++) { 
		?>
		<tr>
		  <td width="46%" align="center"><div align="center"><b><?php echo strtoupper($nombcampo[$a]); ?></b></div></td>
		  <td width="54%" align="center"><div align="center"><input name="<?php echo $nombcampo[$a]; ?>1" id="<?php echo $nombcampo[$a]; ?>1" type="text" onkeypress="return handleEnter(this, event);" value="<?php echo $rows1[$nombcampo[$a]]; ?>" class="form-control" onblur="componente.<?php echo $nombcampo[$a]; ?>.value=this.value;"></div></td>
		 </tr><?php } } ?>
		<tr><input name="interfaz" id="interfaz" type="hidden" value="<?php echo $rows1['interfaz'];?>"><?php if($compon!="Microprocesador" and $compon!="Memorias") { ?>
		  <td width="46%" align="center"><div align="center"><b>INTERFAZ</b></div></td>
		  <td width="54%" align="center"><div align="center">
		    <select name="interf" id="interf" class="form-control" onchange="componente.interfaz.value=this.value;">
			  <option value="AGP" <?php if($rows1['interfaz']=="AGP") { ?> selected <?php } ?>>AGP</option>
			  <option value="IDE" <?php if($rows1['interfaz']=="IDE") { ?> selected <?php } ?>>IDE</option>
			  <option value="PCI" <?php if($rows1['interfaz']=="PCI") { ?> selected <?php } ?>>PCI</option>
			  <option value="PCI-X" <?php if($rows1['interfaz']=="PCI-X") { ?> selected <?php } ?>>PCI-X</option>
			  <option value="PCIe" <?php if($rows1['interfaz']=="PCIe") { ?> selected <?php } ?>>PCIe</option>
			  <option value="SATA" <?php if($rows1['interfaz']=="SATA") { ?> selected <?php } ?>>SATA</option>
			  <option value="SCSI" <?php if($rows1['interfaz']=="SCSI") { ?> selected <?php } ?>>SCSI</option>
			  <option value="SAS" <?php if($rows1['interfaz']=="SAS") { ?> selected <?php } ?>>SAS</option>
			  <option value="USB" <?php if($rows1['interfaz']=="USB") { ?> selected <?php } ?>>USB</option>
	        </select></div></td><?php } ?>
		</tr>
		<tr><input name="taip" id="taip" type="hidden" value="<?php echo $rows1['tipo'];?>"><?php if($compon=="Memorias") { ?>
		  <td width="46%" align="center"><div align="center" id="tmem1"><b>TIPO</b></div></td>
		  <td width="54%" align="center"><div align="center" id="tmem2" >
		    <select name="tai" id="tai" class="form-control" onchange="componente.taip.value=this.value;">
			  <option value="SDR SDRAM" <?php if($rows1['tipo']=="SDR SDRAM") {?> selected <?php } ?>>SDR SDRAM</option>
			  <option value="RDRAM" <?php if($rows1['tipo']=="RDRAM") {?> selected <?php } ?>>RDRAM</option>
			  <option value="DDR SDRAM" <?php if($rows1['tipo']=="DDR SDRAM") {?> selected <?php } ?>>DDR SDRAM</option>
			  <option value="DDR2 SDRAM" <?php if($rows1['tipo']=="DDR2 SDRAM") {?> selected <?php } ?>>DDR2 SDRAM</option>
			  <option value="DDR3 SDRAM" <?php if($rows1['tipo']=="DDR3 SDRAM") {?> selected <?php } ?>>DDR3 SDRAM</option>
			  <option value="DDR4 SDRAM" <?php if($rows1['tipo']=="DDR4 SDRAM") {?> selected <?php } ?>>DDR4 SDRAM</option>
	        </select></div></td><?php } ?>
		</tr>
		<tr>
		  <td colspan="2"><input name="inv" type="hidden" value="<?php echo $invent; ?>"><input name="ingresar" onclick="__insertcompo('<?php echo $compon; ?>','<?php echo $row['inv']; ?>','<?php echo $compo; ?>',document.getElementById('marca').value,document.getElementById('modelo').value,document.getElementById('no_serie').value,document.getElementById('fabricante').value,document.getElementById('capacidad').value,document.getElementById('tasa').value,document.getElementById('frecuencia').value,document.getElementById('cache').value,document.getElementById('rpm').value,document.getElementById('interfaz').value,document.getElementById('tipo').value,document.getElementById('cpuid').value,document.getElementById('cpucores').value,document.getElementById('cpulogicos').value,document.getElementById('socket').value); acepta('<?php echo $invent; ?>','<?php echo $unidad; ?>',document.getElementById('mem').value,document.getElementById('mem2').value,document.getElementById('mem3').value,document.getElementById('mem4').value,document.getElementById('cpu').value,document.getElementById('placa').value,document.getElementById('chipset').value,document.getElementById('grafic').value,document.getElementById('drive1').value,document.getElementById('drive2').value,document.getElementById('drive3').value,document.getElementById('drive4').value,document.getElementById('sonido').value,document.getElementById('red0').value,document.getElementById('red1').value,document.getElementById('red2').value,document.getElementById('fuente').value,document.getElementById('so').value,document.getElementById('npc').value,document.getElementById('marca').value,document.getElementById('modelo').value,document.getElementById('no_serie').value,document.getElementById('fabricante').value,document.getElementById('capacidad').value,document.getElementById('tasa').value,document.getElementById('frecuencia').value,document.getElementById('cache').value,document.getElementById('rpm').value,document.getElementById('interfaz').value,document.getElementById('taip').value,'<?php echo $indice;?>','<?php echo $compon; ?>','<?php echo $compo; ?>',document.getElementById('cpuid').value,document.getElementById('cpucores').value,document.getElementById('cpulogicos').value,document.getElementById('socket').value);" value="<?php echo $btaceptar;?>" class="btn btn-primary" style="float: right;" type="button"></td>
		</tr>
		</table><br>
		<input name="unidad" type="hidden" id="unidad" value="<?php echo $unidad; ?>">
		<input name="memo0" type="hidden" id="memo0x" value="<?php echo $memo0; ?>">
		<input name="memo1" type="hidden" id="memo1x" value="<?php echo $memo1; ?>">
		<input name="memo2" type="hidden" id="memo2x" value="<?php echo $memo2; ?>">
		<input name="memo3" type="hidden" id="memo3x" value="<?php echo $memo3; ?>">
		<input name="cpux" type="hidden" id="cpux" value="<?php echo $cpux; ?>">
		<input name="placax" type="hidden" id="placax" value="<?php echo $placax; ?>">
		<input name="chipsetx" type="hidden" id="chipsetx" value="<?php echo $chipsetx; ?>">
		<input name="tgraficax" type="hidden" id="tgraficax" value="<?php echo $tgraficax; ?>">
		<input name="hdd0x" type="hidden" id="hdd0x" value="<?php echo $hdd0x; ?>">
		<input name="hdd1x" type="hidden" id="hdd1x" value="<?php echo $hdd1x; ?>">
		<input name="lector0x" type="hidden" id="lector0x" value="<?php echo $lector0x; ?>">
		<input name="lector1x" type="hidden" id="lector1x" value="<?php echo $lector1x; ?>">
		<input name="sonidox" type="hidden" id="sonidox" value="<?php echo $sonidox; ?>">
		<input name="red0x" type="hidden" id="red0x" value="<?php echo $red0x; ?>">
		<input name="red1x" type="hidden" id="red1x" value="<?php echo $red1x; ?>">
		<input name="red2x" type="hidden" id="red2x" value="<?php echo $red2x; ?>">
		<input name="fuentex" type="hidden" id="fuentex" value="<?php echo $fuentex; ?>">
		<input name="osx" type="hidden" id="osx" value="<?php echo $osx; ?>">
		<input name="npcx" type="hidden" id="npcx" value="<?php echo $npcx; ?>">
		<input name="indice" type="hidden" id="indice" value="<?php echo $indice; ?>">
		<input name="compon" type="hidden" id="compon" value="<?php echo $compon; ?>">
		<input name="compo" type="hidden" id="compo" value="<?php echo $compo; ?>">
		<input name="marca" id="marca" type="hidden">
		<input name="modelo" id="modelo" type="hidden">
		<input name="no_serie" id="no_serie" type="hidden">
		<input name="fabricante" id="fabricante" type="hidden">
		<input name="capacidad" id="capacidad" type="hidden">
		<input name="tasa" id="tasa" type="hidden">
		<input name="frecuencia" id="frecuencia" type="hidden">
		<input name="cache" id="cache" type="hidden">
		<input name="rpm" id="rpm" type="hidden">
		<input name="interfaz" id="interfaz" type="hidden">
		<input name="tipo" id="tipo" type="hidden">
		<input name="cpuid" id="cpuid" type="hidden">
		<input name="cpucores" id="cpucores" type="hidden">
		<input name="cpulogicos" id="cpulogicos" type="hidden">
		<input name="socket" id="socket" type="hidden">
	</form>
	</div>
</div>
<form action="registromedios1.php" method="post" name="ir" id="ir">
	<input name="dde" id="dde" type="hidden">
</form>
<div id="buscad">
<fieldset class='fieldset'>
<legend class="vistauserx"><?php echo strtoupper($btregmedio);?><?php if(($unidadactiva) !=""){ echo "&nbsp;&nbsp;&nbsp;".$btdatosentidad3.": <font color='red'>".$unidadactiva."</font>"; } ?></legend>
<form method="post" name="importa" id="importa" action="">
	<input name="inv" type="hidden" id="invent" value="<?php echo @$invent; ?>"> 
	<input name="unidad" type="hidden" id="unidad" value="<?php echo $unidad; ?>">
	<input name="id_area" type="hidden" id="id_area" value="<?php echo @$row['idarea']; ?>">
	<input name="custodio" type="hidden" id="unidad" value="<?php echo @$row_Recordset1['nombre']; ?>">
	<input name="impor" type="hidden" id="impor" value="">
	<input name="crash" type="hidden" id="crash" value="">
	<input name="marcado" type="hidden" id="marcado" value="">
</form>	
<?php 
	if(isset($_POST['subir'])){
		if(isset($_POST['filea'])) {	
  			$upload_ext = strrchr($_POST['filea'],".");
			
			if (in_array($upload_ext, $upload_extensions) AND ($upload_ext) !="") { ?>
				<script type="text/javascript">
				   document.getElementById("subir").style.visibility='visible';
			    </script>
			<?php 
				@copy($roo.$pht1."tmp/".$_POST['filea'],$roo.$pht1."importar/".$_POST['filea']);
			    @unlink($roo.$pht1."tmp/".$_POST['filea']);
				
				if(($upload_ext) ==".zip" OR ($upload_ext) ==".ZIP"){
					$zip = new ZipArchive;
					if ($zip->open($roo.$pht1."importar/".$_POST['filea']) === TRUE) {
						$zip->extractTo($roo.$pht1."importar/");
						$zip->close();
						@rename($roo.$pht1."importar/".$_FILES['filea']['name'],$roo.$pht1."importar/import_exp.txt");
						@unlink($roo.$pht1."importar/".$_POST['filea']);
					} else { 
					   echo 'Intento fallido';
					}				
				}else{
					@rename($roo.$pht1."importar/".$_POST['filea'],$roo.$pht1."importar/import_exp.txt");			
				}
			}else{ ?>
			  <script type="text/javascript">
				alert("El fichero: <?php echo $_POST['file'];?>, tiene una extesion no valida");
			  </script> <?php
			} ?>
            
			<script type="text/javascript">
			   document.importa.impor.value="kbpimpirt";
			   document.importa.inv.value="<?php echo @$invent; ?>";
			   document.importa.submit(); 
			</script>
			
	 <?php } 
			 		
	}?>
		<div id="openModal" class="modalDialog">
			<div>
				<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
				<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid2(document.frm1.marcado.value);" value="<?php echo$btaceptar;?>"></div></div>	
			</div>
		</div><br>
	<?php if (@$impor == "kbpimpirt" ){ ?>	
		<table border="0" align="center" cellpadding="2" cellspacing="2" class="table" style="width:70%">
			<tr><td><?php include("js/droparea.php"); ?>
				<div id="areas"><br>
					<form name="form1a" method="post" action="" enctype="multipart/form-data">
						<div id="arras">&nbsp;&nbsp;&nbsp;<?php echo $arrastrar;?></div>
							<input type="file" class="droparea spot" style="font-size:12px;" name="ficheroX" data-post="uploadexp.php" data-width="220" data-height="345" data-crop="true"/><input type="hidden" name="filea">&nbsp;&nbsp;<span id="nambr"></span><hr>
							<input name="subir" type="submit" id="subir" value="<?php echo $cargar2;?>" class="btn" style="visibility:hidden">
							<script type="text/javascript">
									function checkFile(fileUrl) {			
										var xmlHttpReq = false;
										var self = this;
										// Mozilla/Safari
										if (window.XMLHttpRequest) {
											self.xmlHttpReq = new XMLHttpRequest();
										}
										// IE
										else if (window.ActiveXObject) {
											self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
										}

										self.xmlHttpReq.open('HEAD', fileUrl, true);
										self.xmlHttpReq.onreadystatechange = function() {
											if (self.xmlHttpReq.readyState == 4) {
												if (self.xmlHttpReq.status == 200) {
													alert('El fichero no existe');
												} else if (self.xmlHttpReq.status == 404) {
													document.getElementById('nambr').innerHTML='';
													document.form1a.filea.value='';
													alert('El fichero no existe');
												}
											}
										}
										self.xmlHttpReq.send();
									}

									function quit(file_name,q){						
										$.ajax({
											url: 'quitaresolu.php',
											data: {'file' : "<?php echo dirname(__FILE__) . '/importar/'?>" + file_name },
											success: function (response) {
												if((q) =="s"){
													checkFile("<?php echo dirname(__FILE__) . '/importar/'?>" + file_name);
													document.getElementById('nambr').innerHTML='';		
													document.form1a.subir.style.visibility='hidden';										
												}
												// do something
											},
											  error: function () {
												// do something
											  }
										});						
									}
									extArray = new Array(".txt", ".TXT");
									extArray1 = new Array(".sql", ".zip");
									
									function LimitAttach(file) {
										allowSubmit = false;
										if (!file) return;
										while (file.indexOf("\\") != -1)
										file = file.slice(file.indexOf("\\") + 1);
										ext = file.slice(file.indexOf(".")).toLowerCase();
										for (var i = 0; i < extArray.length; i++) {
											if (extArray[i] == ext) { allowSubmit = true; break; }
										}
										if (allowSubmit) {
											document.getElementById('nambr').innerHTML= ' &nbsp;&nbsp;&nbsp;'+file+' &nbsp;<a title="Quitar '+file+'..." onmouseover="this.style.cursor=\'pointer\'" onclick="quit(\''+file+'\',\'s\');"><img src="images/quitar.png" width="20" height="20" border="0" align="absmiddle" ></a>'; 
											document.form1a.filea.value=file;
											document.form1a.subir.style.visibility='visible';				
										}else{
											document.getElementById('nambr').innerHTML= "<font color='red'><b>ERROR.</b></font> Solo Se permiten archivos con la extenci&oacute;n: " + (extArray1.join("  ")) + "\nPor favor, seleccione otro archivo.";
											quit(file,'n');
										}
									}
										// Calling jQuery "droparea" plugin
										$('.droparea').droparea({
											'instructions': '',
											'init' : function(result){
												//console.log('custom init',result);
											},
											'start' : function(area){
												area.find('.error').remove(); 
											},
											'error' : function(result, input, area){
												$('<div class="error">').html(result.error).prependTo(area); 
												return 0;
												//console.log('custom error',result.error);
											},
											'complete' : function(result, file, input, area){
												var tld = file.name.toLowerCase().split(/\./);
												tld = tld[tld.length -1];
												LimitAttach(file.name);
											}
										});
							</script>
						<input name="inv" type="hidden" id="invent" value="<?php echo $invent; ?>">
						<input name="unidad" type="hidden" id="unidad" value="<?php echo $unidadE; ?>">
						<input name="id_area" type="hidden" id="id_area" value="<?php echo $row['idarea']; ?>">
	                    <input name="custodio" type="hidden" id="unidad" value="<?php echo @$row_Recordset1['nombre']; ?>">
					</form>
				</div>
				</td>
			</tr>
		</table>	  	
		<form name="frm1" method="post" action="imprt_exp.php" onsubmit="return chequea();">
			<table border="0" align="center" cellpadding="2" cellspacing="2" class="table" style="width:70%">
				<tr>
					<td><?php 
						$handle=opendir('./importar');
						$r=0;
						while ($file = readdir($handle)) { 
							if ($file != "." && $file != "..") {
								$upload_extx = strrchr($file,".");
								if(($upload_extx) ==".txt"){ 
									$estadisticas = stat($roo.$pht1."importar/".$file); ?>
									<label class='Estilo3' style="cursor:pointer;"><input name='marcado' type='radio' class="boton" id='<?php echo $r;?>' value='<?php echo $file;?>' />
									&nbsp;<?php echo $file."&nbsp;&nbsp;(<font color='red' size='2'>".tamano($estadisticas['size'],2)."</font>)";?></label><br><?php
									$r++;									
								}
							} 
						}
						closedir($handle); ?>
					</td>
				</tr>
				<?php if(($r) ==0){ ?>
				<tr>
					<td align="center"><br><div class="message" align="center"><?php echo $noregitro3." ".strtolower($para_import);?>.</div>
				  </td>
				</tr><?php 
				}
				if(($r) >0){ ?>
				<tr>
					<td><input type="submit" class="btn" name="importar" value="<?php echo $btImportar;?>"/>
						&nbsp;&nbsp;<input name="elimina" id="elimina" type="button" class="btn" onclick="checkLengthr('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>
						<input name="crash" type="hidden" >
						<input name="inv" type="hidden" id="invent" value="<?php echo $invent; ?>">
						<input name="unidad" type="hidden" id="unidad" value="<?php echo $unidadE; ?>">
						<input name="id_area" type="hidden" id="id_area" value="<?php echo $row['idarea']; ?>">
	                    <input name="custodio" type="hidden" id="unidad" value="<?php echo @$row_Recordset1['nombre']; ?>">
					</td>
				</tr><?php
				} ?>				
			</table>	
				<input name="tb" type="hidden" value="todo">
				<input name="origen" type="hidden" value="form-insertarexp.php">			  
		</form>  
	<?php }else{  ?>		
	
	<table border="0" align="center" cellspacing="0" cellpadding="0" class="table" style="width:58%;">
        <form name="form1" action="insertarexp.php" method="post" enctype="multipart/form-data" onSubmit="return submit_page();">          
          <tr>
            <td colspan="4"><div align="center"></div></td>
          </tr>
          <tr>
            <td width="61"><div align="right"><img src="images/idarea.png" width="45" height="30" /></div></td>
            <td width="127"><div align="left"><strong><?php echo strtoupper($btdatosentidad3);?></strong></div></td>
            <td width="271" colspan="2"> <input onKeyPress="return handleEnter(this, event)" name="bentidad" class="form-control" type="text" readonly id="t1" size="40" value="<?php echo $rowx['entidad']; ?>"></td>
          </tr>
          <tr>
            <td width="61"><div align="right"><img src="images/unidades.png" width="38" height="30" /></div></td>
            <td width="127"><div align="left"><strong><?php echo substr($btAreas,0,-1);?></strong></div></td>
            <td colspan="2"> <input onKeyPress="return handleEnter(this, event)" name="id_area" id="id_area" class="form-control" type="text" readonly size="40" value="<?php echo @$row['idarea']; ?>"></td>
          </tr>
          <tr>
            <td><div align="right"><img src="images/inv.png"  width="53" height="30"  /></div></td>
            <td><div align="left"><strong>INV</strong></div></td>
            <td colspan="2"><label>
            <input onKeyPress="return handleEnter(this, event)" name="inv" type="text" id="inv" class="form-control" readonly value="<?php echo @$row['inv']; ?>">
            </label></td>
          </tr>
          <tr>
            <td><div align="right"><img src="images/cpu.png"  width="53" height="30"  /></div></td>
            <td><div align="left"><strong>CPU</strong></div></td>
            <td colspan="2"><input onKeyPress="return handleEnter(this, event)" name="cpu" value="<?php if (isset($_POST['cpu'])) { echo $_POST['cpu']; }else{ echo $cpux; } ?>" class="form-control" type="text" id="cpu" ><input value="" name="editmen0" class="art-edit-button" id="editmen0" onClick="seguro4('<?php echo $row['inv'];?>','1',document.getElementById('mem').value,document.getElementById('mem2').value,document.getElementById('mem3').value,document.getElementById('mem4').value,document.getElementById('cpu').value,document.getElementById('placa').value,document.getElementById('chipset').value,document.getElementById('grafic').value,document.getElementById('drive1').value,document.getElementById('drive2').value,document.getElementById('drive3').value,document.getElementById('drive4').value,document.getElementById('sonido').value,document.getElementById('red0').value,document.getElementById('red1').value,document.getElementById('red2').value,document.getElementById('fuente').value,document.getElementById('so').value,document.getElementById('npc').value,0,'Microprocesador',document.getElementById('cpu').value);"></td>
          </tr>
          <tr>
            <td><div align="right"><img src="images/placa.png" alt="Board" width="54" height="37" /></div></td>
            <td><div align="left"><strong><?php echo $btPLACA;?></strong></div></td>
            <td colspan="2"><input onKeyPress="return handleEnter(this, event)" name="placa" value="<?php if (isset($_POST['placa'])) { echo $_POST['placa']; }else{ echo $placax; } ?>"  type="text" id="placa" class="form-control"></td>
          </tr>
          <tr>
		  <td><div align="right"><img src="images/chipset.png" alt="Chipset" width="55" height="38" /></div></td>
            <td><div align="left"><strong>CHIPSET</strong></div></td>
            <td colspan="2"><input onKeyPress="return handleEnter(this, event)" name="chipset" value="<?php if (isset($_POST['chipset'])) { echo $_POST['chipset']; }else{ echo $chipsetx; } ?>" type="text" id="chipset" class="form-control"></td>
          </tr>
          <tr>
		  <td><div align="right"><img src="images/ram.png" width="55" height="35" /></div></td>
            <td><div align="left"><strong><?php echo $Memorias1;?></strong></div></td>
            <td colspan="2"><i id="editmen0" onClick="seguro4('<?php echo $row['inv'];?>','1',document.getElementById('mem').value,document.getElementById('mem2').value,document.getElementById('mem3').value,document.getElementById('mem4').value,document.getElementById('cpu').value,document.getElementById('placa').value,document.getElementById('chipset').value,document.getElementById('grafic').value,document.getElementById('drive1').value,document.getElementById('drive2').value,document.getElementById('drive3').value,document.getElementById('drive4').value,document.getElementById('sonido').value,document.getElementById('red0').value,document.getElementById('red1').value,document.getElementById('red2').value,document.getElementById('fuente').value,document.getElementById('so').value,document.getElementById('npc').value,0,'Memorias',document.getElementById('mem').value);" style="height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 2px; margin-left: 563px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><input onKeyPress="return handleEnter(this, event)" name="mem" value="<?php if (isset($_POST['memoria'])) { echo $_POST['memoria']; }else{ echo @$mem0; } ?>" type="text" id="mem" class="form-control"><i id="masmem1" onClick="document.getElementById('menmem1').style.display='block'; masmemo(this.id,'divmem1','divmem2');" style='<?php if($memo1!="") { ?>display:none; <?php } ?>height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -26px; margin-left: 583px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -1px -90px;'></i></td>
          </tr>
          <tr>
            <td colspan="2"><div id="divmem1" style="<?php if ($memo1=="") { ?>display:none;<?php } ?>"><div align="right"><strong><?php echo $Memorias1;?></strong></div></div></td>
            <td colspan="2"><div id="divmem2" style="<?php if ($memo1=="") { ?>display:none;<?php } ?>"><i id="editmen2" onClick="seguro4('<?php echo $row['inv'];?>','1',document.getElementById('mem').value,document.getElementById('mem2').value,document.getElementById('mem3').value,document.getElementById('mem4').value,document.getElementById('cpu').value,document.getElementById('placa').value,document.getElementById('chipset').value,document.getElementById('grafic').value,document.getElementById('drive1').value,document.getElementById('drive2').value,document.getElementById('drive3').value,document.getElementById('drive4').value,document.getElementById('sonido').value,document.getElementById('red0').value,document.getElementById('red1').value,document.getElementById('red2').value,document.getElementById('fuente').value,document.getElementById('so').value,document.getElementById('npc').value,1,'Memorias',document.getElementById('mem2').value);" style="height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 2px; margin-left: 563px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><input onKeyPress="return handleEnter(this, event)" name="mem2" value="<?php echo $memo1;?>" type="text" id="mem2" class="form-control"><i id="masmem2" onClick="document.getElementById('menmem2').style.display='block'; masmemo(this.id,'divmem3','divmem4'); " style='<?php if($memo2!="") { ?>display:none; <?php } ?>height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -26px; margin-left: 583px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -1px -90px;'></i><i id="menmem1" onClick="document.getElementById('masmem1').style.display='block'; menmemo(this.id,'divmem1','divmem2','mem2'); document.getElementById('tipo1').value='';" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -26px; margin-left: 442px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -23px -90px;'></i></div></td>
          </tr>
          <tr>
            <td colspan="2"><div id="divmem3" style="<?php if ($memo2=="") { ?>display:none;<?php } ?>"><div align="right"><strong><?php echo $Memorias1;?></strong></div></div></td>
            <td colspan="2"><div id="divmem4" style="<?php if ($memo2=="") { ?>display:none;<?php } ?>"><i id="editmen3" onClick="seguro4('<?php echo $row['inv'];?>','1',document.getElementById('mem').value,document.getElementById('mem2').value,document.getElementById('mem3').value,document.getElementById('mem4').value,document.getElementById('cpu').value,document.getElementById('placa').value,document.getElementById('chipset').value,document.getElementById('grafic').value,document.getElementById('drive1').value,document.getElementById('drive2').value,document.getElementById('drive3').value,document.getElementById('drive4').value,document.getElementById('sonido').value,document.getElementById('red0').value,document.getElementById('red1').value,document.getElementById('red2').value,document.getElementById('fuente').value,document.getElementById('so').value,document.getElementById('npc').value,2,'Memorias',document.getElementById('mem3').value);" style="height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 2px; margin-left: 563px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><input onKeyPress="return handleEnter(this, event)" name="mem3" value="<?php echo $memo2; ?>" type="text" id="mem3" class="form-control" /><i id="masmem3" onClick="document.getElementById('menmem3').style.display='block'; masmemo(this.id,'divmem5','divmem6');" style='<?php if($memo3!="") { ?>display:none; <?php } ?>height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -26px; margin-left: 583px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -1px -90px;'></i><i id="menmem2" onClick="document.getElementById('masmem2').style.display='block'; menmemo(this.id,'divmem3','divmem4','mem3'); document.getElementById('tipo2').value='';" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -26px; margin-left: 442px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -23px -90px;'></i></div></td>
          </tr>
          <tr>
            <td colspan="2"><div id="divmem5" style="<?php if ($memo3=="") { ?>display:none;<?php } ?>"><div align="right"><strong><?php echo $Memorias1;?></strong></div></div></td>
            <td colspan="2"><div id="divmem6" style="<?php if ($memo3=="") { ?>display:none;<?php } ?>"><i id="editmen4" onClick="seguro4('<?php echo $row['inv'];?>','1',document.getElementById('mem').value,document.getElementById('mem2').value,document.getElementById('mem3').value,document.getElementById('mem4').value,document.getElementById('cpu').value,document.getElementById('placa').value,document.getElementById('chipset').value,document.getElementById('grafic').value,document.getElementById('drive1').value,document.getElementById('drive2').value,document.getElementById('drive3').value,document.getElementById('drive4').value,document.getElementById('sonido').value,document.getElementById('red0').value,document.getElementById('red1').value,document.getElementById('red2').value,document.getElementById('fuente').value,document.getElementById('so').value,document.getElementById('npc').value,3,'Memorias',document.getElementById('mem4').value);" style="height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 2px; margin-left: 563px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><input onKeyPress="return handleEnter(this, event)" name="mem4" value="<?php echo $memo3; ?>" type="text" id="mem4" class="form-control" /><i id="menmem3" onClick="document.getElementById('masmem3').style.display='block'; menmemo(this.id,'divmem5','divmem6','mem4'); document.getElementById('tipo3').value='';" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -26px; margin-left: 442px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -23px -90px;'></i></div></td>
          </tr>
          <tr>
		  <td><div align="right"><img src="images/video.png" alt="Video" width="45" height="38" /></div></td>
            <td><div align="left"><strong><?php echo $bttargeta;?></strong></div></td>
            <td colspan="2"><i id="editmen01" onClick="seguro4('<?php echo $row['inv'];?>','1',document.getElementById('mem').value,document.getElementById('mem2').value,document.getElementById('mem3').value,document.getElementById('mem4').value,document.getElementById('cpu').value,document.getElementById('placa').value,document.getElementById('chipset').value,document.getElementById('grafic').value,document.getElementById('drive1').value,document.getElementById('drive2').value,document.getElementById('drive3').value,document.getElementById('drive4').value,document.getElementById('sonido').value,document.getElementById('red0').value,document.getElementById('red1').value,document.getElementById('red2').value,document.getElementById('fuente').value,document.getElementById('so').value,document.getElementById('npc').value,0,'Tarjeta Grafica',document.getElementById('grafic').value);" style="height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 2px; margin-left: 563px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><input onKeyPress="return handleEnter(this, event)" name="grafic" type="text" id="grafic" value="<?php if (isset($_POST['grafics'])) { echo $_POST['grafics']; }else{ echo $tgraficax; } ?>" class="form-control"></td>
          </tr>
          <tr>
		  <td><div align="right"><img src="images/HDD.png" width="40" height="40"  /></div></td>
            <td><div align="left"><strong>HDD</strong></div></td>
            <td colspan="2"><i id="editmen02" onClick="seguro4('<?php echo $row['inv'];?>','1',document.getElementById('mem').value,document.getElementById('mem2').value,document.getElementById('mem3').value,document.getElementById('mem4').value,document.getElementById('cpu').value,document.getElementById('placa').value,document.getElementById('chipset').value,document.getElementById('grafic').value,document.getElementById('drive1').value,document.getElementById('drive2').value,document.getElementById('drive3').value,document.getElementById('drive4').value,document.getElementById('sonido').value,document.getElementById('red0').value,document.getElementById('red1').value,document.getElementById('red2').value,document.getElementById('fuente').value,document.getElementById('so').value,document.getElementById('npc').value,0,'Disco Duro',document.getElementById('drive1').value);" style="height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 2px; margin-left: 563px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><input onKeyPress="return handleEnter(this, event)" name="drive1" type="text" id="drive1" value="<?php if (isset($_POST['driver1'])) { echo $_POST['driver1']; }else{ echo $hdd0x; } ?>" class="form-control"><i id="mashdd" onClick="document.getElementById('menhdd').style.display='block'; masmemo(this.id,'divhdd1','divhdd2');" style='<?php if ($hdd1x!="") { ?>display:none; <?php } ?>height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -26px; margin-left: 583px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -1px -90px;'></i></td>
          <tr>
	        <td colspan="2"><div id="divhdd1" style="<?php if ($hdd1x=="") { ?>display:none; <?php } ?>"><div align="right"><strong>HDD</strong></div></div></td>
            <td colspan="2"><div id="divhdd2" style="<?php if ($hdd1x=="") { ?>display:none; <?php } ?>"><i id="editmen03" onClick="seguro4('<?php echo $row['inv'];?>','1',document.getElementById('mem').value,document.getElementById('mem2').value,document.getElementById('mem3').value,document.getElementById('mem4').value,document.getElementById('cpu').value,document.getElementById('placa').value,document.getElementById('chipset').value,document.getElementById('grafic').value,document.getElementById('drive1').value,document.getElementById('drive2').value,document.getElementById('drive3').value,document.getElementById('drive4').value,document.getElementById('sonido').value,document.getElementById('red0').value,document.getElementById('red1').value,document.getElementById('red2').value,document.getElementById('fuente').value,document.getElementById('so').value,document.getElementById('npc').value,0,'Disco Duro',document.getElementById('drive2').value);" style="height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: 2px; margin-left: 563px; background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -1px -226px;"></i><input onKeyPress="return handleEnter(this, event)" name="drive2" type="text" id="drive2" value="<?php echo $hdd1x; ?>" class="form-control"><i id="menhdd" onClick="document.getElementById('mashdd').style.display='block'; menmemo(this.id,'divhdd1','divhdd2','drive2');" style="height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -26px; margin-left: 583px; background: transparent url('images/glyphicons-halflings.png') repeat scroll -23px -90px;"></i></div></td>
          <tr>
		  <td><div align="right"><img src="images/DriveDVD.png" alt="drive" width="40" height="40" /></div></td>
            <td><div align="left"><strong><?php echo $btdevice;?></strong></div></td>
            <td colspan="2"><input onKeyPress="return handleEnter(this, event)" name="drive3" type="text" id="drive3" value="<?php if (isset($_POST['driver2'])) { echo $_POST['driver2']; }else{ echo $lector0x; } ?>" class="form-control"><i id="masdvd" onClick="document.getElementById('mendvd').style.display='block'; masmemo(this.id,'divdvd1','divdvd2');" style='<?php if ($lector1x!="") { ?>display:none; <?php } ?> height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -26px; margin-left: 583px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -1px -90px;'></i></td>
          <tr>
            <td colspan="2"><div id="divdvd1" style="<?php if ($lector1x=="") { ?>display:none; <?php } ?>"><div align="right"><strong><?php echo $btdevice;?></strong></div></div></td>
            <td colspan="2"><div id="divdvd2" style="<?php if ($lector1x=="") { ?>display:none; <?php } ?>"><input onKeyPress="return handleEnter(this, event)" name="drive4" value="<?php echo $lector1x;?>" type="text" id="drive4" class="form-control"><i id="mendvd" onClick="document.getElementById('masdvd').style.display='block'; menmemo(this.id,'divdvd1','divdvd2','drive4');" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -26px; margin-left: 583px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -23px -90px;'></i></div></td>
          <tr>
		  <td><div align="right"><img src="images/sonido.png" alt="sonido" width="49" height="37" /></div></td>
            <td><div align="left"><strong><?php echo $btSONIDO;?></strong></div></td>
            <td colspan="2"><input onKeyPress="return handleEnter(this, event)" name="sonido" type="text" id="sonido" value="<?php if (isset($_POST['sonido'])) { echo $_POST['sonido']; }else{ echo $sonidox; } ?>" class="form-control"></td>
          <tr>
		  <td><div align="right"><img src="images/Ethernet card Vista.png" alt="Red" width="40" height="40" /></div></td>
            <td><div align="left"><strong><?php echo $btRED;?></strong></div></td>
            <td colspan="2"><input onKeyPress="return handleEnter(this, event)" name="red0" type="text" id="red0" value="<?php if (isset($_POST['red'])) { echo $_POST['red']; }else{ echo $red0x; } ?>" class="form-control"><i id="masred" onClick="document.getElementById('menred').style.display='block'; masmemo(this.id,'divred1','divred2');" style='<?php if ($red1x!="") { ?>display:none;<?php } ?> height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -26px; margin-left: 583px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -1px -90px;'></i></td>
          <tr>
            <td colspan="2"><div id="divred1" style="<?php if ($red1x=="") { ?>display:none;<?php } ?>"><div align="right"><strong><?php echo $btRED;?></strong></div></div></td>
            <td colspan="2"><div id="divred2" style="<?php if ($red1x=="") { ?>display:none;<?php } ?>"><input onKeyPress="return handleEnter(this, event)" name="red1" type="text" id="red1" value="<?php echo $red1x;?>" class="form-control"><i id="masred2" onClick="document.getElementById('menred3').style.display='block'; masmemo(this.id,'divred3','divred4');" style='<?php if ($red2x!="") { ?>display:none;<?php } ?> height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -26px; margin-left: 583px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -1px -90px;'></i><i id="menred" onClick="document.getElementById('masred').style.display='block'; menmemo(this.id,'divred1','divred2','red1');" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -26px; margin-left: 442px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -23px -90px;'></i></div></td>
          <tr>
            <td colspan="2"><div id="divred3" style="<?php if ($red2x=="") { ?>display:none;<?php } ?>"><div align="right"><strong><?php echo $btRED;?></strong></div></div></td>
            <td colspan="2"><div id="divred4" style="<?php if ($red2x=="") { ?>display:none;<?php } ?>"><input onKeyPress="return handleEnter(this, event)" name="red2" type="text" id="red2" value="<?php echo $red2x;?>" class="form-control" /><i id="menred3" onClick="document.getElementById('masred2').style.display='block'; menmemo(this.id,'divred3','divred4','red2');" style='height: 26px; width: 16px; float: left; position: absolute; cursor:pointer; margin-top: -26px; margin-left: 442px; background: transparent url("images/glyphicons-halflings.png") repeat scroll -23px -90px;'></i></div></td>
          <tr>
          <td><div align="right"><img src="images/fuente1.jpg" width="40" height="40" /></div></td>
            <td><div align="left"><strong><?php echo $btFUENTE;?></strong></div></td>
            <td colspan="2"><input onKeyPress="return handleEnter(this, event)" name="fuente" type="text" id="fuente" value="<?php echo $fuentex; ?>" class="form-control"></td>
          <tr>
		  <td><div align="right"><img src="images/SO.png" width="40" height="40" /></div></td>
            <td><div align="left"><strong>OS</strong></div></td>
            <td colspan="2">
			<select name="os" id="os" class="form-control" onChange="return handleEnter(this, event)">
			    <?php for ($i=0; $i<count($sistema_operativo);  $i++) { ?>    
				   <option value="<?php echo $sistema_operativo[$i]; ?>" <?php if (isset($_POST['os']) AND $_POST['os'] == strstr($_POST['os'], $sistema_operativo[$i])) { echo "selected"; } else { echo $sistema_operativo[$i]; } ?>><?php echo $sistema_operativo[$i]; ?></option>
				<?php } ?>
			</select>
			</td>
          <tr>
		  <td><div align="right"><img src="images/custodios.png" width="40" height="40" /></div></td>
            <td><div align="left"><strong><?php echo $btCustodios;?></strong></div></td>
            <td colspan="2"><input onKeyPress="return handleEnter(this, event)" name="custodio" readonly type="text" id="custodio" class="form-control" value="<?php echo @$row_Recordset1['nombre']?>" size="40"></td>
		  <tr>
		  <td><div align="right"></div></td>
            <td><div align="left"><strong><?php echo strtoupper($btNombre);?> PC </strong></div></td>
            <td colspan="2"><input onKeyPress="return handleEnter(this, event)" name="npc" type="text" id="npc" value="<?php if (isset($_POST['computer'])) { echo $_POST['computer']; }else{ echo $npcx; } ?>" class="form-control"><input name="idunidades" type="hidden" value="<?php echo $row['idunidades'];?>"></td>
          <tr>
            <td colspan="4" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center"><div align="center">
              <input type="submit" class="btn" name="insertar" value="<?php echo $btaceptar;?>">&nbsp;<input type="button" class="btn" name="cancel" onClick="__deletecomponentes('<?php echo $row['inv']; ?>'); __ir('rm');" value="<?php echo $btcancelar;?>">
            </div>
			</td>	
	      </tr>	 
        </form>	
    </table>
	<?php } ?>
</fieldset><br><?php include('version.php'); ?>	
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"></div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
