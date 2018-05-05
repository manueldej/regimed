var time_ent;
var Usuar;
function objetoAjax(){
	var xmlhttp=false;
	try{
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}catch(e){
		try{
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}catch(E){
			xmlhttp = false;
  		}
	}

	if(!xmlhttp && typeof XMLHttpRequest!='undefined'){
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}
function reemplazacadena(t){
	do {
		t = t.replace('%E1','&aacute;');
	} while(t.indexOf('%E1') >= 0);
	do {
		t = t.replace('%E9','&eacute;');
	} while(t.indexOf('%E9') >= 0);
	do {
		t = t.replace('%ED','&icute;');
	} while(t.indexOf('%ED') >= 0);
	do {
		t = t.replace('%F3','&oacute;');
	} while(t.indexOf('%F3') >= 0);
	do {
		t = t.replace('%FA','&uacute;');
	} while(t.indexOf('%FA') >= 0);
	do {
		t = t.replace('%F1','&ntilde;');
	} while(t.indexOf('%F1') >= 0);
	do {
		t = t.replace('%C1','&Aacute;');
	} while(t.indexOf('%C1') >= 0);
	do {
		t = t.replace('%C9','&Eacute;');
	} while(t.indexOf('%C9') >= 0);
	do {
		t = t.replace('%CD','&Iacute;');
	} while(t.indexOf('%CD') >= 0);
	do {
		t = t.replace('%D3','&Oacute;');
	} while(t.indexOf('%D3') >= 0);
	do {
		t = t.replace('%DA','&Uacute;');
	} while(t.indexOf('%DA') >= 0);
	do {
		t = t.replace('%D1','&Ntilde;');
	} while(t.indexOf('%D1') >= 0);
	do {
		t = t.replace('%DC','&Uml;');
	} while(t.indexOf('%DC') >= 0);
	do {
		t = t.replace('%FC','&uml;');
	} while(t.indexOf('%FC') >= 0);
	return t;
}
function insp(vi){
	divResultainsp = document.getElementById('inspe');
	ajaxinsp=objetoAjax();
	ajaxinsp.open("GET", "detalleinsp.php?insp="+vi,true);
	ajaxinsp.onreadystatechange=function() {
		if (ajaxinsp.readyState==4) {
			divResultainsp.innerHTML=ajaxinsp.responseText;
			var datosinsp=ajaxinsp.responseXML.documentElement;	
		}		
	}
	ajaxinsp.send(null)
}
function onlin(){
	divResultaonlin = document.getElementById('online');
	ajaxonlin=objetoAjax();
	ajaxonlin.open("GET", "online.php",true);
	ajaxonlin.onreadystatechange=function() {
		if (ajaxonlin.readyState==4) {
			divResultaonlin.innerHTML=ajaxonlin.responseText;
			var datosonlin=ajaxonlin.responseXML.documentElement;	
		}		
	}
	ajaxonlin.send(null)
	setTimeout("onlin();",2000);
}
function Nuevos(){
	divResultaN = document.getElementById('ctado');
	ajaxN=objetoAjax();
	ajaxN.open("GET", "conect.php",true);
	ajaxN.onreadystatechange=function() {
		if (ajaxN.readyState==4) {
			divResultaN.innerHTML=ajaxN.responseText;
			var datosN=ajaxN.responseXML.documentElement;	
		}
		
	}
	ajaxN.send(null)
	setTimeout("Nuevos();",4000);
}
function Nuevos1(){
	divResultaN1 = document.getElementById('ctado');
	ajaxN1=objetoAjax();
	ajaxN1.open("GET", "conect1.php",true);
	ajaxN1.onreadystatechange=function() {
		if (ajaxN1.readyState==4) {
			divResultaN1.innerHTML=ajaxN1.responseText;
			var datosN1=ajaxN1.responseXML.documentElement;	
		}
		
	}
	ajaxN1.send(null)
	//setTimeout("Nuevos1();",4000);
}
function valida(h,tb,campo){
 if (campo=='inv') {
    divValida = document.getElementById('inv11');
 }if (campo=='descrip') {
    divValida = document.getElementById('inv12');
 }
 ajaxva=objetoAjax();
 ajaxva.open("GET", "valid.php?val="+h+"&tb="+tb+"&campo="+campo,true);
 ajaxva.onreadystatechange=function() {
		if (ajaxva.readyState==4) {
			divValida.innerHTML=ajaxva.responseText;
			var datosm=ajaxva.responseXML.documentElement;	
		}		
	}
	ajaxva.send(null)
}

function validaedit(h,tb,campo,accion,valantes,idcomp){
 if (campo=='inv') {
    divValida = document.getElementById(idcomp);
	divValida.style.display='block';
 }if (campo=='descrip') {
    divValida = document.getElementById(idcomp);
	divValida.style.display='block';
 }

 ajaxvam=objetoAjax();
 ajaxvam.open("GET", "valid.php?val="+h+"&tb="+tb+"&campo="+campo+"&accion="+accion+"&valantes="+valantes+"&idcomp="+idcomp,true);
 ajaxvam.onreadystatechange=function() {
		if (ajaxvam.readyState==4) {
			divValida.innerHTML=ajaxvam.responseText;
			var datosman=ajaxvam.responseXML.documentElement;	
		}		
	}
	ajaxvam.send(null)
}
function insp1(ini,reg){
	divResultainsp2 = document.getElementById('inspe');
	ajaxinsp2=objetoAjax();
	ajaxinsp2.open("GET", "detalleinsp.php?ini="+ini+"&reg="+reg,true);
	ajaxinsp2.onreadystatechange=function() {
		if (ajaxinsp2.readyState==4) {
			divResultainsp2.innerHTML=ajaxinsp2.responseText;
			var datosinsp2=ajaxinsp2.responseXML.documentElement;	
		}		
	}
	ajaxinsp2.send(null)
}
function oculin(){
	divResultain21 = document.getElementById('inspe');
	ajaxin21=objetoAjax();
	ajaxin21.open("GET", "detalleinsp.php?l1",true);
	ajaxin21.onreadystatechange=function() {
		if (ajaxin21.readyState==4) {
			divResultain21.innerHTML=ajaxin21.responseText;
			var datosin21=ajaxin21.responseXML.documentElement;	
		}		
	}
	ajaxin21.send(null)
}
function adjs(valo,comp){
	divResultadoc = document.getElementById('paginac');
	ajax=objetoAjax();
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divResultadoc.innerHTML=ajax.responseText;
			var datos=ajax.responseXML.documentElement;	
		}		
	}
	valores1="ent="+reemplazacadena(valo);
	valores2="ent="+reemplazacadena(valo)+"&m=m&comp=n";
	if((comp) =="s"){ 
		ajax.open("POST", "detalleexp.php", true);
		ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		ajax.send(valores1);
	}else{
		ajax.open("POST", "visita.php", true);
		ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		ajax.send(valores2);
	}
}
function memorias(valo){
	divmemo = document.getElementById('buscamem');
	ajax=objetoAjax();
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divmemo.innerHTML=ajax.responseText;
			var datos=ajax.responseXML.documentElement;	
		}		
	}
	valores1="custo="+valo;
	ajax.open("POST", "buscamem.php", true);
	ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	ajax.send(valores1);
}

function vertantos(dato){
	resul = document.getElementById('resultado');
	cuantos=dato;

	ajaxvt=objetoAjax();
	ajaxvt.onreadystatechange=function() {
		if (ajaxvt.readyState==4) {
			resul.innerHTML = ajaxvt.responseText
		}
	}
	ajaxvt.open("POST", "busqueda1.php",true);
	ajaxvt.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajaxvt.send("mostrar="+cuantos)

}
function legal(lega){
	divResultalega = document.getElementById('paginac');
	ajaxlega=objetoAjax();
	ajaxlega.open("GET", "lega.php?ent="+reemplazacadena(lega)+"&m=m",true);
	ajaxlega.onreadystatechange=function() {
		if (ajaxlega.readyState==4) {
			divResultalega.innerHTML=ajaxlega.responseText;
			var datoslega=ajaxlega.responseXML.documentElement;	
		}		
	}
	ajaxlega.send(null)
}
 function marcaP(r1,co1)  { 
	if ((document.getElementById("marcado["+r1+"]").type=="checkbox")&&(document.getElementById("marcado["+r1+"]").checked==false))	 { 
		document.getElementById("cur_tr_"+r1).style.backgroundColor='#DBE2D0';
		document.getElementById("marcado["+r1+"]").checked=true;
	}    else     { 
		document.getElementById("cur_tr_"+r1).style.backgroundColor=co1;
		document.getElementById("marcado["+r1+"]").checked=false;
	}
 }

function det(valor){
	ajaxdet=objetoAjax();
	divResultadet = document.getElementById('deta');
	ajaxdet.onreadystatechange=function() {
		if (ajaxdet.readyState==4) {
			divResultadet.innerHTML=ajaxdet.responseText;
			var datosdet=ajaxdet.responseXML.documentElement;	
		}		
	}
	ajaxdet.open("GET", "detallemedio.php?det="+valor,true);
	ajaxdet.send(null)
}

function detdef(valor){
	divResultadet = document.getElementById('detadef');
	ajaxdet=objetoAjax();
	ajaxdet.open("GET", "detallemediodef.php?det="+reemplazacadena(valor),true);
	ajaxdet.onreadystatechange=function() {
		if (ajaxdet.readyState==4) {
			divResultadet.innerHTML=ajaxdet.responseText;
			var datosdet=ajaxdet.responseXML.documentElement;	
		}		
	}
	ajaxdet.send(null)
}
function detexp(valorexp){
	divResultadetexp = document.getElementById('deta');
	ajaxdetexp=objetoAjax();
	ajaxdetexp.open("GET", "det_exp.php?det="+valorexp,true);
	ajaxdetexp.onreadystatechange=function() {
		if (ajaxdetexp.readyState==4) {
			divResultadetexp.innerHTML=ajaxdetexp.responseText;
			var datosdetexp=ajaxdetexp.responseXML.documentElement;	
		}		
	}
	ajaxdetexp.send(null)
}
function det1(ini,reg,orderby,asc){
	divResultadet2 = document.getElementById('deta');
	ajaxdet2=objetoAjax();
	ajaxdet2.open("GET", "detallemedio.php?ini="+ini+"&reg="+reg+"&orderby="+orderby+"&asc="+asc,true);
	ajaxdet2.onreadystatechange=function() {
		if (ajaxdet2.readyState==4) {
			divResultadet2.innerHTML=ajaxdet2.responseText;
			var datosdet2=ajaxdet2.responseXML.documentElement;	
		}		
	}
	ajaxdet2.send(null)
}
function det2(quer){
	divResultadet22 = document.getElementById('deta');
	ajaxdet22=objetoAjax();
	ajaxdet22.onreadystatechange=function() {
		if (ajaxdet22.readyState==4) {
			divResultadet22.innerHTML=ajaxdet22.responseText;
			var datosdet22=ajaxdet22.responseXML.documentElement;	
		}		
	}
	ajaxdet22.open("GET", "detallemedio.php?quer="+quer,true);
	ajaxdet22.send(null)
}
function detde(quer){
	divResultadet22 = document.getElementById('detadef');
	ajaxdet22=objetoAjax();
	ajaxdet22.open("GET", "detallemediodef.php?quer="+quer,true);
	ajaxdet22.onreadystatechange=function() {
		if (ajaxdet22.readyState==4) {
			divResultadet22.innerHTML=ajaxdet22.responseText;
			var datosdet22=ajaxdet22.responseXML.documentElement;	
		}		
	}
	ajaxdet22.send(null)
}
function ocul(){
	divResultadet21 = document.getElementById('deta');
	ajaxdet21=objetoAjax();
	ajaxdet21.open("GET", "detallemedio.php?l1",true);
	ajaxdet21.onreadystatechange=function() {
		if (ajaxdet21.readyState==4) {
			divResultadet21.innerHTML=ajaxdet21.responseText;
			var datosdet21=ajaxdet21.responseXML.documentElement;	
		}		
	}
	ajaxdet21.send(null)
}
function ocultar(){
	divResultadet21 = document.getElementById('detadef');
	ajaxdet21=objetoAjax();
	ajaxdet21.open("GET", "detallemediodef.php?l1",true);
	ajaxdet21.onreadystatechange=function() {
		if (ajaxdet21.readyState==4) {
			divResultadet21.innerHTML=ajaxdet21.responseText;
			var datosdet21=ajaxdet21.responseXML.documentElement;	
		}		
	}
	ajaxdet21.send(null)
}

function mand(va){
	divusua = document.getElementById('vistausua');
	ajaxusua=objetoAjax();
	ajaxusua.open("GET", "vusuario.php?ent="+reemplazacadena(va),true);
	ajaxusua.onreadystatechange=function() {
		if (ajaxusua.readyState==4) {
			divusua.innerHTML=ajaxusua.responseText;
			var datosusua=ajaxusua.responseXML.documentElement;	
		}		
	}
	ajaxusua.send(null)
}
function busc(bu){
	ajaxbusc=objetoAjax();
	divbusc = document.getElementById('buscad');
	
	ajaxbusc.open("GET", "busc.php?palabra="+reemplazacadena(bu),true);
	ajaxbusc.onreadystatechange=function() {
		if (ajaxbusc.readyState==4) { 
			if((bu) !=''){
				divbusc.innerHTML=ajaxbusc.responseText;
			}
			var datosbusc=ajaxbusc.responseXML.documentElement;	
		}		
	}
	ajaxbusc.send(null)
}
function visitas(vi){
	ajaxvisitas=objetoAjax();
	divvisitas = document.getElementById('visitas');
	ajaxvisitas.onreadystatechange=function() {
		if (ajaxvisitas.readyState==4) {
			divvisitas.innerHTML=ajaxvisitas.responseText;
			var datosvisitas=ajaxvisitas.responseXML.documentElement;	
		}		
	}
	ajaxvisitas.open("GET", "visitas1.php?ent="+reemplazacadena(vi),true);
	ajaxvisitas.send(null)
}
function detalles(v){
	divdetalle = document.getElementById('detalle');
	ajaxdetalle=objetoAjax();
	ajaxdetalle.open("GET", "detalle.php?id="+v,true);
	ajaxdetalle.onreadystatechange=function() {
		if (ajaxdetalle.readyState==4) {
			divdetalle.innerHTML=ajaxdetalle.responseText;
			var datosdetalle=ajaxdetalle.responseXML.documentElement;	
		}		
	}
	ajaxdetalle.send(null)
}
function detalles1(ini,reg){
	divdetallea = document.getElementById('detalle');
	ajaxdetallea=objetoAjax();
	ajaxdetallea.open("GET", "detalle.php?ini="+ini+"&reg="+reg,true);
	ajaxdetallea.onreadystatechange=function() {
		if (ajaxdetallea.readyState==4) {
			divdetallea.innerHTML=ajaxdetallea.responseText;
			var datosdetallea=ajaxdetallea.responseXML.documentElement;	
		}		
	}
	ajaxdetallea.send(null)
}
function oculb(){
	divResultb = document.getElementById('detalle');
	ajaxb=objetoAjax();
	ajaxb.open("GET", "detalle.php?l1",true);
	ajaxb.onreadystatechange=function() {
		if (ajaxb.readyState==4) {
			divResultb.innerHTML=ajaxb.responseText;
			var datosb=ajaxb.responseXML.documentElement;	
		}		
	}
	ajaxb.send(null)
}
function exped(valor, marcado){
  if (marcado == false){
	divResultaex = document.getElementById('detaexped');
	ajaxex=objetoAjax();
	ajaxex.open("GET", "detalleareas.php?exped="+valor+"&marca"+marcado,true);
	ajaxex.onreadystatechange=function() {
		if (ajaxex.readyState==4) {
			divResultaex.innerHTML=ajaxex.responseText;
			var datosex=ajaxex.responseXML.documentElement;	
		}		
	}
	 ajaxex.send(null)
	}else{
	  divResultaex.innerHTML="";
	  //ajaxex.send(null)
	}
 
}

function exped1(ini,reg){
	divResultaex1 = document.getElementById('detaexped');
	ajaxex1=objetoAjax();
	ajaxex1.open("GET", "detalleareas.php?ini="+ini+"&reg="+reg,true);
	ajaxex1.onreadystatechange=function() {
		if (ajaxex1.readyState==4) {
			divResultaex1.innerHTML=ajaxex1.responseText;
			var datosex1=ajaxex1.responseXML.documentElement;	
		}		
	}
	ajaxex1.send(null)
}
function exped2(){
	divResultaex2 = document.getElementById('detaexped');
	ajaxex2=objetoAjax();
	ajaxex2.open("GET", "detalleareas.php?a",true);
	ajaxex2.onreadystatechange=function() {
		if (ajaxex2.readyState==4) {
			divResultaex2.innerHTML=ajaxex2.responseText;
			var datosex2=ajaxex2.responseXML.documentElement;	
		}		
	}
	ajaxex2.send(null)
}

function expedient(){
	divexp = document.getElementById('exped');
	ajaxexp=objetoAjax();
	ajaxexp.open("GET", "exped1.php",true);
	ajaxexp.onreadystatechange=function() {
		if (ajaxexp.readyState==4) {
			divexp.innerHTML=ajaxexp.responseText;
			var datosexp=ajaxexp.responseXML.documentElement;	
		}		
	}
	ajaxexp.send(null)
}

function Claves(cl,sist){
	divcla = document.getElementById('claves');
	ajaxcla=objetoAjax();
	if (sist=="sistema") {
		ajaxcla.open("GET", "claves.php?ent="+cl,true);
	}else{
		ajaxcla.open("GET", "claves_so.php?ent="+cl,true);
	}
	
	ajaxcla.onreadystatechange=function() {
		if (ajaxcla.readyState==4) {
			divcla.innerHTML=ajaxcla.responseText;
			var datoscla=ajaxcla.responseXML.documentElement;	
		}		
	}
	ajaxcla.send(null)
}
function usuars(usus){
	divusus = document.getElementById('usux');
	ajaxusus=objetoAjax();
	ajaxusus.open("GET", "compusus.php?ent="+usus,true);
	ajaxusus.onreadystatechange=function() {
		if (ajaxusus.readyState==4) {
			divusus.innerHTML=ajaxusus.responseText;
			var datosusus=ajaxusus.responseXML.documentElement;	
		}		
	}
	ajaxusus.send(null)
}
function reupx(reu){
	divreup = document.getElementById('reux');
	ajaxreup=objetoAjax();
	ajaxreup.open("GET", "reup.php?ent="+reu,true);
	ajaxreup.onreadystatechange=function() {
		if (ajaxreup.readyState==4) {
			divreup.innerHTML=ajaxreup.responseText;
			var datosreup=ajaxreup.responseXML.documentElement;	
		}		
	}
	ajaxreup.send(null)
}
function muestraentidad(ide){
	diventd = document.getElementById('muestraent');
	ajaxentd=objetoAjax();
	ajaxentd.open("GET", "entd.php?ent="+ide,true);
	ajaxentd.onreadystatechange=function() {
		if (ajaxentd.readyState==4) {
			diventd.innerHTML=ajaxentd.responseText;
			var datosentd=ajaxentd.responseXML.documentElement;	
		}		
	}
	ajaxentd.send(null)
}
function fusiona(b){
	divedifusion = document.getElementById('muestra_ent');
	ajaxedifusion=objetoAjax();
	ajaxedifusion.open("POST", "configura.php",true);
	ajaxedifusion.onreadystatechange=function() {
	if (ajaxedifusion.readyState==4) {
			divedifusion.innerHTML=ajaxedifusion.responseText;			
			var datosedifusion=ajaxedifusion.responseXML.documentElement;	
		}		
	}
	ajaxedifusion.send('fusionar=&fus='+b)
}			

function delentidad(idde){
	divdelentd = document.getElementById('muestra_ent');
	ajaxdelentd=objetoAjax();
	ajaxdelentd.open("GET", "delentd.php?ent="+idde,true);
	ajaxdelentd.onreadystatechange=function() {
	if (ajaxdelentd.readyState==4) {
			divdelentd.innerHTML=ajaxdelentd.responseText;			
			var datosdelentd=ajaxdelentd.responseXML.documentElement;	
		}		
	}
	ajaxdelentd.send(null)
}
function editaentidad(i){
	divedi = document.getElementById('muestra_ent');
	ajaxedi=objetoAjax();
	ajaxedi.open("POST", "configura.php",true);
	ajaxedi.onreadystatechange=function() {
	if (ajaxedi.readyState==4) {
			divedi.innerHTML=ajaxedi.responseText;			
			var datosedi=ajaxedi.responseXML.documentElement;	
		}		
	}
	ajaxedi.send('editar=&marcad='+i)
}

function insertaent(entidad,sector,reup,NombreAdmin,LoginAdmin,PassAdmin,sex,mail,web,provincia,smtp){

	divinserta = document.getElementById('muestra_ent');
	ajaxinserta=objetoAjax();
	ajaxinserta.open("GET", "delentd.php?entidad="+reemplazacadena(entidad)+"&sector="+sector+"&reup="+reup+"&NombreAdmin="+reemplazacadena(NombreAdmin)+"&LoginAdmin="+LoginAdmin+"&PassAdmin="+PassAdmin+"&sex="+sex+"&mail="+mail+"&web="+web+"&provincia="+provincia+"&smtp="+smtp,true);
	ajaxinserta.onreadystatechange=function() {
	if (ajaxinserta.readyState==4) {
			divinserta.innerHTML=ajaxinserta.responseText;			
			var datosinserta=ajaxinserta.responseXML.documentElement;	
		}		
	}
	ajaxinserta.send(null)

}
function novas(){
	divnov = document.getElementById('buscad');
	ajaxnov=objetoAjax();
	ajaxnov.open("GET", "nueva.php",true);
	ajaxnov.onreadystatechange=function() {
	if (ajaxnov.readyState==4) {
			divnov.innerHTML=ajaxnov.responseText;			
			var datosnov=ajaxnov.responseXML.documentElement;	
		}		
	}
	ajaxnov.send(null)
}
function llamaorgano(tx,quecosa,idcomp,iddiv){
	divarre = document.getElementById(iddiv);
	ajaxarre=objetoAjax();
	ajaxarre.open("GET", "arreglo.php?tx="+tx+"&quecosa="+quecosa+"&idcomp="+idcomp+"&iddiv="+iddiv,true);
	ajaxarre.onreadystatechange=function() {
	if (ajaxarre.readyState==4) {
			divarre.innerHTML=ajaxarre.responseText;			
			document.getElementById(iddiv).style.display='block';
		}		
	}
	ajaxarre.send(null)
}
	function __editcompo(campo,id,valor,idcomp){
		ajaxcomp =objetoAjax();
		var divfcha = document.getElementById(idcomp);
		ajaxcomp.onreadystatechange=function() {
			if (ajaxcomp.readyState==4) {
				divfcha.value = valor;
			}
		}
		vald="campo="+campo+"&id="+id+"&valor="+valor;		
		ajaxcomp.open("POST", "editcomp.php", true);
		ajaxcomp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		ajaxcomp.send(vald);	
	}
	function __insertcompo(compon,exp,nombre,marc,model,nser,fab,capac,tas,frecuencia,cach,rpm,intz,tipo,cpuid,cpucores,cpulogicos,socket){
		if(marc=="" && model=="") {
		 return false;
		}
		ajaxcompins =objetoAjax();
		var divfcha = document.getElementById('c5');
		ajaxcompins.onreadystatechange=function() {
			if (ajaxcompins.readyState==4) {
				divfcha.innerHTML=ajaxcompins.responseText;
			}
		}
		vald="compon="+compon+"&exp="+exp+"&nombre="+nombre+"&marc="+marc+"&model="+model+"&nser="+nser+"&fab="+fab+"&capac="+capac+"&tas="+tas+"&frecuencia="+frecuencia+"&cach="+cach+"&rpm="+rpm+"&intz="+intz+"&tipo="+tipo+"&cpuid="+cpuid+"&cpucores="+cpucores+"&cpulogicos="+cpulogicos+"&socket="+socket;		
		ajaxcompins.open("POST", "insertcomp.php", true);
		ajaxcompins.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		ajaxcompins.send(vald);	
	}
	
	function __deletecompo(id){
		ajaxcompins =objetoAjax();
		//var divfcha = document.getElementById('c4');
			ajaxcompins.onreadystatechange=function() {
			if (ajaxcompins.readyState==4) {
				//divfcha.innerHTML=ajaxcompins.responseText;	
			}
		}
		vald="id="+id		
		ajaxcompins.open("POST", "deletecomp.php", true);
		ajaxcompins.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		ajaxcompins.send(vald);	
	}
	
	function __deletecomponentes(exp){
		ajaxcompins =objetoAjax();
			ajaxcompins.onreadystatechange=function() {
		}
		valexp="exp="+exp		
		ajaxcompins.open("POST", "deletecomp.php", true);
		ajaxcompins.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		ajaxcompins.send(valexp);	
	}
	
	function __upgrade(compon,exp,tipo,nuevo,iduni,n_pc){
		if(exp=="" && compon=="") {
		 return false;
		}
		ajaxcompins =objetoAjax();
		//var divfcha = document.getElementById('c5');
		ajaxcompins.onreadystatechange=function() {
			if (ajaxcompins.readyState==4) {
				//divfcha.innerHTML=ajaxcompins.responseText;
			}
		}
		vald="compon="+compon+"&exp="+exp+"&tipo="+tipo+"&nuevo="+nuevo+"&n_pc="+n_pc+"&iduni="+iduni;		
		ajaxcompins.open("POST", "upgrade.php", true);
		ajaxcompins.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		ajaxcompins.send(vald);	
	}
window.onload = function (){
	//onlin();
}
