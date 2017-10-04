// JavaScript Document
jQuery(document).ready(function(){

	string_search = $.getURLParam("search");
	mod = $.getURLParam("mod");

	getSearchResults(string_search);

	function getSearchResults(string_search){
		$("#cargando").css("display", "inline");
		$("#destino").load("app/modules/core/pages/search-results-ajax.php?search=" + string_search + "&mod=" + mod + "&ms=" + new Date().getTime(), function(){
			$("#cargando").css("display", "none");
		});
	}	
});