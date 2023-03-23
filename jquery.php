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
$i="es";
		if(isset($_COOKIE['seulang'])){
			if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
		}
		if(($i) =="es"){include('esp.php');}else{ include('eng.php');} 
?>
	<script type="text/javascript">
		function showAlert(time, alert){
			$('.ContenedorAlert').html(alert);
			$('.alert').fadeIn('slow');
			setTimeout(function(){$('.alert').fadeOut('slow') }, time);
		}
		function checkLength(err,men,tipo) {
			var counx=0;
			for (i=0;i<frm1.elements.length;i++)   {
				if ((frm1.elements[i].type=="checkbox")&&(frm1.elements[i].checked==true))	 {
					counx = counx +1;
				}
			}
			if((counx) >0){
				document.location="#openModal";
			}else{
				showAlert(3000,'<div class="alert negro"><button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.getElementById(\'cir\').innerHTML=\'\';">X</button><div align="center"><font color="#FFDCA8" size="3"><b>'+err+'</b></font></div><div align="center"><b>'+men+'.</b></div></div>');
			}
		}
		function checkLengthr(err,men,tipo) {	
			var counx=0;
			for (i=0;i<frm1.elements.length;i++)   {
				if ((frm1.elements[i].type=="radio")&&(frm1.elements[i].checked==true))	 {
					counx = counx +1;
				}
			}
			if((counx) >0){
				document.location="#openModal";
			}else{
				showAlert(3000,'<div class="alert negro"><button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.getElementById(\'cir\').innerHTML=\'\';">X</button><div align="center"><font color="#FFDCA8" size="3"><b>'+err+'</b></font></div><div align="center"><b>'+men+'.</b></div></div>');
			}
		}
		
		function checkLength1(err,men,tipo1,val) {
			if((tipo1) =='d'){
				document.location="?v="+val+"&#openModal";
			}
		}
		
		function bValid() {
			document.frm1.crash.value="1";
			document.frm1.submit();
		}
		
		function bValid2(file, area, inv) {
			var marcado = file;	
			document.importa.crash.value="1";
			document.importa.marcado.value=marcado;	
			
			document.importa.submit();
		}
		
		function bValid1(v) {
			document.location="bajas.php?d="+v;
		}			
		
	</script>