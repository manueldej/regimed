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
function compruebabd(h,u,p,b){
	divResultainsp = document.getElementById('comp');
	ajaxinsp=objetoAjax();
	ajaxinsp.open("GET", "compbd.php?h="+h+"&u="+u+"&p="+p+"&b="+b,true);
	ajaxinsp.onreadystatechange=function() {
		if (ajaxinsp.readyState==4) {
			divResultainsp.innerHTML=ajaxinsp.responseText;			
			var datosinsp=ajaxinsp.responseXML.documentElement;	
		}		
	}
	ajaxinsp.send(null)
}
function compruebasql(ho,us,pa){
	divResultasql = document.getElementById('compsq');
	ajaxsql=objetoAjax();
	ajaxsql.open("GET", "compsql.php?h="+ho+"&u="+us+"&p="+pa,true);
	ajaxsql.onreadystatechange=function() {
		if (ajaxsql.readyState==4) {
			divResultasql.innerHTML=ajaxsql.responseText;			
			var datossql=ajaxsql.responseXML.documentElement;	
		}		
	}
	ajaxsql.send(null)
}