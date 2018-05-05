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
?>
<script type='text/javascript'>
function handleEnter (field, event) { 
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode; 
	if (keyCode == 13) { 
		var i; 
		for (i = 0; i < field.form.elements.length; i++) 
			if (field == field.form.elements[i]) break; 
			i = (i + 1) % field.form.elements.length; 
			field.form.elements[i].focus(); 
		return false; 
	} else 
		return true; 
} 

	var NS4 = (document.layers); 
	var IE4 = (document.all);
	var win = window;
	var n   = 0;
	
	function findInPage(str) { 
		var txt, i, found;
		if (str == '')
		return false; 
		if (!win.find(str)) 
		while(win.find(str, false, true)) 
			n++; 
		else 
			n++; 
		if (n == 0) 
			//alert('Not found.'); 
		return false; 
	} 
	

    function alerta(err,men,tipo) { 
	var counx=0;
	document.getElementById('cir').style.display="";
		for (i=0;i<frm1.elements.length;i++){
			if ((frm1.elements[i].type=="checkbox")&&(frm1.elements[i].checked==true)) {
				counx = counx +1;
			}
		} 
		if((counx) >0){
			if((tipo) =="d"){
				if(confirm('<?php echo $seguro2;?>')){
					document.frm1.submit();
				}else{
					return false;
				}
			}else{
				document.frm1.submit();
			}		
		}else{ 
			showAlert(5000,'<div class="alert negro" style="display: none"><button class="closex" type="button" onclick="cierr();">X</button><div align="center"><font color="#FFDCA8" size="3"><b>'+err+'</b></font></div><div align="center"><b>'+men+'.</b></div></div>');
			return false;
		}	
    }
 function alertaradio(err,men,tipo) { 
	var counx=0;
	document.getElementById('cir').style.display="";
	for (i=0;i<frm1.elements.length;i++)   {
		if ((frm1.elements[i].type=="radio")&&(frm1.elements[i].checked==true))	 {
			counx = counx +1;
		}
	} 
	if((counx) >0){
		if((tipo) =="d"){
			if(confirm('<?php echo $seguro2;?>')){
				document.frm1.submit();
			}else{
				return false;
			}
		}else{
			document.frm1.submit();
		}		
	}else{
		showAlert(5000,'<div class="alert negro" style="display: none"><button class="closex" type="button" onclick="cierr();">X</button><div align="center"><font color="#FFDCA8" size="3"><b>'+err+'</b></font></div><div align="center"><b>'+men+'.</b></div></div>');
		return false;
	}	
}

	function selecciona(){
		if ((document.getElementById("componente").type=="checkbox")&&(document.getElementById("componente").checked==false)) {
			document.getElementById("componente").checked=true;
			document.getElementById("chequeaderax").style.background='url(gfx/checkbox.gif) no-repeat scroll 0 4px transparent';
			document.getElementById("chequeaderax").style.marginTop='-31px';
		}else {
			document.getElementById("componente").checked=false;
			document.getElementById("chequeaderax").style.background='url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent';
			document.getElementById("chequeaderax").style.marginTop='-26px';
		}
	}
	
	function marca1(r1,co1){
		if ((document.getElementById("marcado"+r1).type=="checkbox")&&(document.getElementById("marcado"+r1).checked==false)) {
			document.getElementById("cur_tr_"+r1).style.backgroundColor='#FCF8E2';
			document.getElementById("marcado"+r1).checked=true;
			document.getElementById("chequeadera"+r1).style.background='url(gfx/checkbox.gif) no-repeat scroll 0 4px transparent';
		}else {
			document.getElementById("cur_tr_"+r1).style.backgroundColor=co1;
			document.getElementById("marcado"+r1).checked=false;
			document.getElementById("chequeadera"+r1).style.background='url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent';
		}
	}
	    function colorear(r1,co1) {
			if ((document.getElementById("marcado"+r1).type=="checkbox")&&(document.getElementById("marcado"+r1).checked==true)){
				document.getElementById("cur_tr_"+r1).style.backgroundColor=co1;
			 }
	    }
	    function marcar_todo() {
			document.getElementById("cheque1").style.display='none';
			document.getElementById("cheque1").style.background='url(gfx/checkbox.gif) no-repeat scroll 0 4px transparent';
			document.getElementById("cheque2").style.display='block';
			document.getElementById("cheque2").style.background='url(gfx/checkbox.gif) no-repeat scroll 0 4px transparent';
			var couna=0;
			for (i=0;i<frm1.elements.length;i++){
		   		if ((document.getElementById("marcado"+i).type=="checkbox") && (document.getElementById("marcado"+i).checked==false)) {
					document.getElementById("cur_tr_"+i).style.backgroundColor='#FCF8E2';
					document.getElementById("marcado"+i).checked=true;
   				    document.getElementById("chequeadera"+i).style.background='url(gfx/checkbox.gif) no-repeat scroll 0 4px transparent';
					couna = couna +1;
				}
			}
			
			for (is=0;is<frm1.elements.length;is++)	 {
			  document.getElementById("cur_tr_"+is).style.backgroundColor='#FCF8E2';
			}
	    }
		function desmarca_todo()  {
				document.getElementById("cheque2").style.display='none';
				document.getElementById("cheque2").style.background='url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent';
				document.getElementById("cheque1").style.display='block';
				document.getElementById("cheque1").style.background='url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent';
				var couna=0;
				for (i=0;i<frm1.elements.length;i++){
					if ((document.getElementById("marcado"+i).type=="checkbox")&&(document.getElementById("marcado"+i).checked==true))	   {
						document.getElementById("cur_tr_"+i).style.backgroundColor='';
						document.getElementById("marcado"+i).checked=false;
						document.getElementById("chequeadera"+i).style.background='url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent';
						couna = couna +1;
					}
				}
				for (is=0;is<frm1.elements.length;is++)	 {
					document.getElementById("cur_tr_"+is).style.backgroundColor='';
				}
			 }
		 
	function checke() {
		var formValid=false;
		var f = document.form1;
		
        if (f.inv.value == '') {
			document.getElementById('cira').innerHTML='<div class="alert negro" style="margin-left: -220px;"><button class="closex" type="button" onclick="cierr1();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $advierte;?></b></font></div><div align="center"><b>El campo -Inv- esta en blanco.".</b></div></div>';
			f.inv.focus();
			formValid=false;
		}else if ( f.desc.value == '' ) {
			document.getElementById('cira').innerHTML='<div class="alert negro" style="margin-left: -220px;"><button class="closex" type="button" onclick="cierr1();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $advierte;?></b></font></div><div align="center"><b>Por favor seleccione la -Descripcion-.".</b></div></div>';
			f.desc.focus(); 
			formValid=false; 	
		}else if ((f.estado.value) == '' || (f.estado.value) == '') {
			document.getElementById('cira').innerHTML='<div class="alert negro" style="margin-left: -220px;"><button class="closex" type="button" onclick="cierr1();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $advierte;?></b></font></div><div align="center"><b>Por favor seleccione o escriba el -Estado-.".</b></div></div>';
			f.estado.focus(); 
			formValid=false; 	
		}else if ( f.marca.value == '' ) {
			document.getElementById('cira').innerHTML='<div class="alert negro" style="margin-left: -220px;" ><button class="closex" type="button" onclick="cierr1();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $advierte;?></b></font></div><div align="center"><b>Por favor seleccione el -Marca-.".</b></div></div>';
			f.marca.focus(); 
			formValid=false;
		}else if ( f.flash.value == '-1' ) {
			document.getElementById('cira').innerHTML='<div class="alert negro" style="margin-left: -220px;"><button class="closex" type="button" onclick="cierr1();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $advierte;?></b></font></div><div align="center"><b>Por favor seleccione el -Categoria-.".</b></div></div>';
			f.flash.focus(); 
			formValid=false;
		}else if ( (f.custo.value =='-1') || (f.custo.value =='') ) {
			document.getElementById('cira').innerHTML='<div class="alert negro" style="margin-left: -220px;"><button class="closex" type="button" onclick="cierr1();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $advierte;?></b></font></div><div align="center"><b>Por favor seleccione el -Custodio-.".</b></div></div>';
			f.custo.focus(); 
			formValid=false;
		}else if (confirm('Son estos los datos correctos?')) {
			formValid=true;
		}

		if (formValid !=true)  { 
		  return false; 
		}
	}
 function alertax()  { 
	var fs = document.formulario;
	if (fs.login.value == '') {
		document.getElementById('cira').innerHTML='<div class="alert negro"><button class="closex" type="button" onclick="cierr1();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $advierte;?></b></font></div><div align="center"><b><?php echo $plea2." Login";?>.</b></div></div>';
		fs.login.focus();
		return false;
	}else if (fs.clave.value == '') {
		document.getElementById('cira').innerHTML='<div class="alert negro"><button class="closex" type="button" onclick="cierr1();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $advierte;?></b></font></div><div align="center"><b><?php echo $plea2." clave Setup";?>.</b></div></div>';
		fs.clave.focus();
		return false;
	}else if (fs.clave1.value == '') {
		document.getElementById('cira').innerHTML='<div class="alert negro"><button class="closex" type="button" onclick="cierr1();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $advierte;?></b></font></div><div align="center"><b><?php echo $plea2." Clave Sistema";?>.</b></div></div>';
		fs.clave1.focus();
		return false;
	} else{
		return true;
	}
	return false;
}
function alertab()  { 
	var fs1 = document.form1x1;
	if (fs1.quy1x.value == '') {
		document.getElementById('cira').innerHTML='<div class="alert negro"><button class="closex" type="button" onclick="cierr1();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div align="center"><b><?php echo $btcertifica;?>.</b></div></div>';
		fs1.quy1x.focus();
		return false;
	}else if (fs1.fechax.value == '') {
		document.getElementById('cira').innerHTML='<div class="alert negro"><button class="closex" type="button" onclick="cierr1();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div align="center"><b><?php echo $plea2." ".$Fecha;?>.</b></div></div>';
		fs1.fechax.focus();
		return false;
	}else if (fs1.organox.value == '') {
		document.getElementById('cira').innerHTML='<div class="alert negro"><button class="closex" type="button" onclick="cierr1();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div align="center"><b><?php echo $plea2." ".$btdatosentidad3;?>.</b></div></div>';
		fs1.organox.focus();
		return false;
	} else{
		return true;
	}
	return false;
}
	function alerta1(err,men,tipo)  { 
		var counx=0;
		document.getElementById('cir').style.display="";
		for (i=0;i<formd.elements.length;i++)   {
			if ((formd.elements[i].type=="checkbox")&&(formd.elements[i].checked==true))	 {
				counx = counx +1;
			}
		}
		if((counx) >0){
			if((tipo) =="d"){
				if(confirm('<?php echo $seguro2;?>')){
					document.frm1.submit();
				}else{
					return false;
				}
			}else{
				document.frm1.submit();
			}		
		}else{
			buscar(err,men);
			return false;
		}	
	}
	function cierr(){
		document.getElementById('cir').innerHTML="";
	}
	function buscar(err,men){ 
			showAlert(5000,'<div class="alert negro" style="display: none"><button class="closex" type="button" onclick="cierr();">X</button><div align="center"><font color="#FFDCA8" size="3"><b>'+err+'</b></font></div><div align="center"><b>'+men+'.</b></div></div>');
	}
	function toltip(){	
		$('.toolTipL').tooltip({title:'Ver mas información', placement:'left', delay: { show: 500, hide: 100 }});
	}	
	function showAlert(time, alert){
		$('.ContenedorAlert').html(alert);
		$('.alert').fadeIn('slow');
		setTimeout(function(){$('.alert').fadeOut('slow') }, time);
	}
	function showAlertx(alert){
		$('.ContenedorAlert').html(alert);
		$('.alert').fadeIn('slow');
	}
	function cierr1(){
		document.getElementById('cira').innerHTML="";
	}
	 

	var nav4 = window.Event ? true : false;
	function acceptNum(evt){
		var key = nav4 ? evt.which : evt.keyCode;	
		return (key <= 13 || (key >= 48 && key <= 57));
	}	
	function acceptNum1(evt){	
		var key = nav4 ? evt.which : evt.keyCode;	
		return (key <= 13 || (key >= 47 && key <= 57));
	}	
</script>

