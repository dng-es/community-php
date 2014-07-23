// JavaScript Document
function Confirma(Mensaje,Destino)
{
		var respuesta=confirm(Mensaje);        
		if (respuesta==true)
				location.href=Destino;
}

function validateEmail(email)
{
	if(email.length <= 0)
	{
	  return false;
	}
	var splitted = email.match('^(.+)@(.+)$');
	if(splitted == null) return false;
	if(splitted[1] != null )
	{
	  var regexp_user=/^\'?[\w-_\.]*\'?$/;
	  if(splitted[1].match(regexp_user) == null) return false;
	}
	if(splitted[2] != null)
	{
	  var regexp_domain=/^[\w-\.]*\.[A-Za-z]{2,4}$/;
	  if(splitted[2].match(regexp_domain) == null) 
	  {
		var regexp_ip =/^\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\]$/;
		if(splitted[2].match(regexp_ip) == null) return false;
	  }// if
	  return true;
	}
return false;
}

function esFechaValida(fecha){
	if (fecha != undefined && fecha.value != "" ){
		fecha=fecha.replace(/-/g,'/');
		var expreg = /^([0-9]{4})\/([0-9]{2})\/([0-9]{2})$/;
		if (!expreg.test(fecha)){
			return false;
		}
		var anio =  parseInt(fecha.substring(0,4));			
		var dia  =  fecha.substring(8,10);	
		var mes  =  fecha.substring(5,7);
		 
	switch(mes){
		case "01":
		case "03":
		case "05":
		case "07":
		case "08":
		case "10":
		case "12":
			numDias=31;
			break;
		case "04": case "06": case "09": case "11":
			numDias=30;
			break;
		case "02":
			if (comprobarSiBisisesto(anio)){ numDias=29 }else{ numDias=28};
			break;
		default:
			return false;
	}
 
		if (dia>numDias || dia==0){
			return false;
		}
		return true;
	}
}
 
function comprobarSiBisisesto(anio){
if ( ( anio % 100 != 0) && ((anio % 4 == 0) || (anio % 400 == 0))) {
	return true;
	}
else {
	return false;
	}
}

function prettyDate(now, time){
	var date = new Date(time || ""),
		diff = (((new Date(now)).getTime() - date.getTime()) / 1000),
		day_diff = Math.floor(diff / 86400);
	if ( isNaN(day_diff) || day_diff < 0 || day_diff >= 31 )
		return;

	return day_diff == 0 && (
		diff < 60 && "ahora mismo" ||
		diff < 120 && "hace 1 minuto" ||
		diff < 3600 && "hace " + Math.floor( diff / 60 ) + " minutos" ||
		diff < 7200 && "hace una hora" ||
		diff < 86400 && "hace " + Math.floor( diff / 3600 ) + " horas") ||
		day_diff == 1 && "ayer" ||
		day_diff < 7 && "hace " + day_diff + " dias" ||
		day_diff < 31 && "hace " + Math.ceil( day_diff / 7 ) + " semanas";
}

function check_nif_cif_nie(cif) {
	//Returns: 1 = NIF ok, 2 = CIF ok, 3 = NIE ok, -1 = NIF bad, -2 = CIF bad, -3 = NIE bad, 0 = ??? bad
	cif = cif.toUpperCase();
	var num = [], i, n, letras = "TRWAGMYFPDXBNJZSQVHLCKE",suma,n,valor;
				   
	for ( i = 0; i < 9; i ++){
		  num[i] = cif.substring(i,i+1);
	}

	//si no tiene un formato valido devuelve error
	if (!cif.match('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)')){
		  return 0;
	}

	//comprobacion de NIFs estandar
	if (cif.match('(^[0-9]{8}[A-Z]{1}$)')){
				   if (num[8] == letras.substring(cif.substring(0,8) % 23,(cif.substring(0,8) % 23)+1)){
								   return 1;
				   }else {
								   return -1;
				   }
	}

	//algoritmo para comprobacion de codigos tipo CIF
	suma = parseInt(num[2]) + parseInt(num[4]) + parseInt(num[6]);
	for (i = 1; i < 8; i += 2){
				   valor = 2 * num[i];
				   valor = valor.toString();
		suma += parseInt(valor.substring(0,1)) + (valor.substring(1,2)==="" ? 0 : parseInt(valor.substring(1,2)));
	}
	n = 10 - parseInt(suma.toString().substring(suma.toString().length-1,suma.toString().length));

	//comprobacion de NIFs especiales (se calculan como CIFs)
	if (cif.match('^[KLM]{1}')){
				   if (num[8] == String.fromCharCode(64 + n)){
			 return 1;
				   }else{
			 return -1;
				   }
	}

	//comprobacion de CIFs
	if (cif.match('^[ABCDEFGHJNPQRSUVW]{1}')){
				   if (num[8] == String.fromCharCode(64 + n) || num[8] == n.toString().substring(n.toString().length-1,n.toString().length)){
								   return 2;
				   }else{
								   return -2;
				   }
	}
	//comprobacion de NIEs
	//T
	if (cif.match('^[T]{1}')){
				   if (num[8] == cif.match('^[T]{1}[A-Z0-9]{8}$')){
								   return 3;
				   }else{
								   return -3;
				   }
	}

	//X
	if (cif.match('^[X]{1}')){
				   var cadena1 = cif.replace("X", "0").substring(0,8);
				   if (num[8] == letras.substring(cadena1 % 23,(cadena1 % 23) + 1)){
								   return 3;
				   }else{
								   return -3;
				   }
	}

	//Y
	if (cif.match('^[Y]{1}')){
				   var cadena1 = cif.replace("Y", "1").substring(0,8);
				   if (num[8] == letras.substring(cadena1 % 23,(cadena1 % 23) + 1)){
								   return 3;
				   }else{
								   return -3;
				   }
	}              

	//Z
	if (cif.match('^[Z]{1}')){
				   var cadena1 = cif.replace("Z", "2").substring(0,8);
				   if (num[8] == letras.substring(cadena1 % 23,(cadena1 % 23) + 1)){
								   return 3;
				   }else{
								   return -3;
				   }
	}                              

	//si todavia no se ha verificado devuelve error
	return 0;
}
