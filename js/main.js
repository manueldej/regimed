/**
 * Js Principal
 * Descipción: Contiene las llamadas librerias externas y funciones básicas*
 * @autor: Ing. Roberto Hamlet Leyva Ramos *
 * @copyright: GPL v3
 * @versión: 1.0 *
 * */

/*Variables*/

var paginado = 0,
	partido = 0,
	total = 0,
	real = 0,
	extra = 0;
	tmpArray = new Array();

$(document).ready(startEvents); 

function startEvents(){
	//Muestra la categoria seleccionada
	//showCategorias(dataApp, 'Aplicaciones');
	//contruye sub-etiquetas dinamicamente
	showEtiquetas();	
	//muestra mensaje de bienvenida

	var nombresArray = nombreApp.concat(nombreProd);
	$('.search-query').typeahead({source: nombresArray});
	
	//cambiar cantidad de elementos a mostrar por pagina
	$('.pag .btn').on('click', function () {
		partido = parseInt($(this).text());
		paginado = 1;
		showData(0, partido);
		cantReal();
		$('.pager .next').removeClass('disabled');
		$('.pager .previous').addClass('disabled');
   });
    
    //Paginado
    $('.pager .next').on('click', function (){
    	
    	if(paginado < real-1)
    	{
    		ini = (paginado*partido);
    		paginado++;
    		$('.pager .previous').removeClass('disabled');
    		showData(ini, (paginado*partido));
    	}
    	else if(paginado < real)
    	{
    		ini = ((paginado)*partido);
    		showData(ini, ini+extra);
    		paginado++;
    		$('.pager .previous').removeClass('disabled');
    		$('.pager .next').addClass('disabled');
    	}
    });
    
    $('.pager .previous').on('click', function (){
    	if(paginado !=1)
    		{
    			paginado--;
    			fin = (paginado*partido);
    			showData(fin-partido, fin);
    			$('.pager .next').removeClass('disabled');
    		}
    	if(paginado == 1)
    		$('.pager .previous').addClass('disabled');
    })
	
}

function mainPage(n){
	if((n) =="1a"){
	document.getElementById('1a').style.display="block";
	document.getElementById('1b').style.display="none";
	}else{
	document.getElementById('1b').style.display="block";
	document.getElementById('1a').style.display="none";	
	}
	document.getElementById('resto').style.display="none";
}
function buscar1(err,men){ 
	showAlert(5000,'<div class="alert negro" style="display: none"><button class="close" type="button" onclick="cierr();">x</button><div align="center"><font color="#FFDCA8" size="3"><b>'+err+'</b></font></div><div align="center"><b>'+men+'.</b></div></div>');
}
function buscar(){
	nom = $('.search-query').val();
	if(nom != ''){
		tmp1 = nombreApp.indexOf(nom);
		tmp2 = nombreProd.indexOf(nom);
		if(tmp1 == -1 && tmp2 == -1){
			showAlert(5000,'<div class="alert negro" style="display: none"><button class="close" data-dismiss="alert" type="button">×</button><strong>¡Lo sentimos! </strong>No se encuentra el término "'+nom+'".</div>');
		}
		else
			$('.search-query').val('');
			
		if(tmp1 != -1)
			showModal(tmp1, dataApp);
		else if(tmp2 != -1)
			showModal(tmp2, dataProd);
	}
}

function showSubcategoria(texto){
	t = texto;
	if(texto.length >20)
		t = texto.substring(0,19)+'...'
	$('.nombreCategoria').html('<i class="icon-tags"></i> '+t+' <span class="caret"></span>');
}

function showCategorias(array, categoria){
	$('.nombreCategoria').html('<i class="icon-tags"></i> '+categoria+' <span class="caret"></span>');
	$('.pager .previous').addClass('disabled');
	tmpArray = array;
	total = tmpArray.length;
	paginado = 1;
	partido = 5;
	
	if(partido>=total){
		partido = total;
		$('.pager .next').addClass('disabled');
	}
	else
		$('.pager .next').removeClass('disabled');
		
	$radio = $('.pag .btn');
	$radio.removeAttr('disabled');
	$radio.removeClass('active');
	$radio.eq(0).addClass('active');
		
	if(total<=5)
		$radio.eq(0).attr('disabled','disabled');
	if(total<=10)
		$radio.eq(1).attr('disabled','disabled');
	if(total<=15)
		$radio.eq(2).attr('disabled','disabled');
		
	$('.badge').text(total);
	
	//realizar calculo paginado
	cantReal();
	
	//Mostrar tabla de datos
	showData(0, partido);
}

function cantReal(){
	tmp = parseInt(total/partido);
	resto = total%partido;
	if(resto !=0)
	{
		tmp++;
		extra = resto;
	}
	real = tmp;
}

function showData(ini, cant){
	var cadena = '';
	for(var i =ini; i<cant; i++){
		cadena += '<tr><td>'+(i+1)+'</td><td><div class="logoApp"></div></td><td>'+tmpArray[i][1]+'</td><td>'+tmpArray[i][2]+'</td><td>'+tmpArray[i][4]+'</td><td><a data-toggle="tooltip" class="btn btn-mini toolTipL btn-primary" onclick="javascript:showModal('+i+', tmpArray)"><i class="icon-info-sign icon-white"></i></a>  <a data-toggle="tooltip" class="btn btn-mini toolTipR btn-primary"><i class="icon-download icon-white"></i></a></td></tr>';
	}
	$(".dataTable").html(cadena);
	
	$('.toolTipL').tooltip({title:'Ver más información', placement:'left', delay: { show: 500, hide: 100 }});
	$('.toolTipR').tooltip({title:'Descargar', placement:'right', delay: { show: 500, hide: 100 }});
}



//Mostrar Alerta

function showAlert(time, alert){
	$('.ContenedorAlert').html(alert);
	$('.alert').fadeIn('slow');
	setTimeout(function(){$('.alert').fadeOut('slow') }, time);
}
//mostrar información ampliada
function showModal(pos, array){
	array1 = new Array();
	if(array)
		array1 = array;
	else
		array1 = tmpArray;
	i = parseInt(pos);
	$('.dialogoInfo').html('<div id="myModal" class="modal hide fade"><div class="modal-header rojo"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3>'+array[i][1]+'</h3></div><div class="modal-body"><p><strong>Versión:</strong> '+array[i][2]+'</p><p><strong>Autor:</strong> '+array[i][5]+'</p><p><strong>Correo:</strong> '+array[i][6]+'</p><p><strong>Descripción:</strong></p><p>'+array[i][7]+'</p></div><div class="modal-footer"><a href="#" class="btn btn-success">Descargar</a><a href="#" data-dismiss="modal" class="btn btn-primary">Cerrar</a></div></div>');
	$('#myModal').modal();
}
