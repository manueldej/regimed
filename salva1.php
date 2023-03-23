<?php 
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Inform�ticos)     					                                		            #
# Version:  3.1.1                                                    				                        #
# Fecha:    24/03/2011 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jes�s N��ez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada	(IN MEMORIAN)							         		            #
# Licencia: Freeware                                                				                        #
#                                                                       			                        #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                 #
# LICENCIA: Este archivo es parte de REGIMED. REGIMED es un software libre; Usted lo puede redistribuir y/o #
# lo puede modificar bajo los t�rminos de la Licencia P�blica General GNU publicada por la Fundaci�n de     #
# Software Gratuito (the Free Software Foundation ); Ya sea la versi�n 2 de la Licencia, o (en su opci�n)   #
# cualquier posterior versi�n. REGIMED es distribuido con la esperanza de que ser� �til, pero SIN CUALQUIER #
# GARANT�A; Sin a�n la garant�a impl�cita de COMERCIABILIDAD o ADAPTABILIDAD PARA UN PROP�SITO PARTICULAR.  #
# Vea la Licencia P�blica General del GNU para m�s detalles. Usted deber�a haber recibido una copia de la   #
# Licencia  P�blica General de GNU junto con REGIMED. En Caso de que No, vea <http://www.gnu.org/licenses>. #
#############################################################################################################
include('header.php');
$k=0;

//@$result = mysql_list_tables ($database_miConex);
	$i="es";
	$bd=$database_miConex;
	if(isset($_POST['tbl'])){$tbl=$_POST['tbl'];}
	if(isset($_POST['adtabla'])){$adtabla=$_POST['adtabla'];}
	if(isset($_POST['sip'])){$sip=$_POST['sip'];}

	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
?>
 <link rel="stylesheet" href="css/pace-theme-loading-bar.css" />
		  <script>
		    paceOptions = {
		      elements: true
		    };
		  </script>
		  <script src="js/pace.js"></script>
		  <script>
		    function load(){
		      var x = new XMLHttpRequest()
		      //x.open('GET', "http://localhost/webmail/", true);
		     // x.send();
		    };

		    load();
		    setTimeout(function(){
		      Pace.ignore(function(){
			load();
		      });
		    }, 700);

		    Pace.on('hide', function(){
		      console.log('done');
		    });

		  </script>
<style type="text/css">
<!--
.Estilo3 {
	font-size: 12px;
	color: #846131;
	font-weight: bold;
	font-style: italic;
}
.Estilo1 {
	color: #000000;
	font-weight: bold;
	font-family: Tahoma, Helvetica, Arial, sans-serif;
	font-size: 18px;
}
-->
</style><?php 
include('barra.php');
include('salvar.php');?>
<div id="buscad"> 
<fieldset class="fieldset"><legend class='vistauserx'><?php echo $impo_exp2;?></legend>
		<script language="javascript">
			function ap1(m){
				document.getElementById("tarea").innerHTML=m;
			}
			function apx(m){
				document.getElementById("tarea").innerHTML=m;
			}
			function des1(f,n,zip){
				if((zip) =="s"){
					document.getElementById("descarga").innerHTML='<a class="enlace" target = "_blank" href="'+f+'" title="<?php echo $click1.$descarg;?>">'+n+'</a>';
				}else{
					document.getElementById("descarga").innerHTML='<a target="_blank" class="enlace" href="'+f+'" title="<?php echo $click1.$descarg;?>">'+n+'</a>';
				}
			}
		</script><br> 
		<fieldset class='fieldset'><legend class='vistauserx'><?php echo $otrosdet3;?></legend>
			<div id="tarea">Actual:</div><br>
		</fieldset><br>  <?php
			if((@$sip) =="s"){ ?>
				<fieldset class='fieldset'>
					<legend class='vistauserx'><?php echo $descarg;?> </legend>
					<div class="descar" id="descarga"><?php echo $btspera;?></div><br>
				</fieldset> <?php
			}else{  ?>
				<fieldset class='fieldset'>
					<legend class='vistauserx'><?php echo $v_ficha;?> .sql </legend>
					<div class="descar" id="descarga"><?php echo $btspera;?></div><br>
				</fieldset> <?php 
			} 
    @salvar($i,@$tbl,@$adtabla,@$sip);
?>	
 <br><br>
</fieldset><br>
<?php include ("version.php");?>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>