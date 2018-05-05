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
		function bValid1(v) {
			document.location="bajas.php?d="+v;
		}			
		
	</script>