// JavaScript Document
jQuery(document).ready(function(){
	$(".table-open-content").css({"display": "none"})
	$(".table-open").click(function(e){
		e.preventDefault();
		$(this).next(".table-open-content").slideToggle();
	})
});