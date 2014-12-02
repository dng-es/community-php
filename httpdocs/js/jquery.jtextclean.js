(function($) {
/*
 * Count characters introduced in a textarea and limits the numbers of
 * characters user can type down. A counter DIV is added wich CSS can be
 * set up through options parameters.
 *
 * @name     jsearch
 * @param    initValue      input-text ini value
 * @author   David Noguera Gutierrez
 * @example  $("#searchInput").jtextclean();
 * @example  $("#searchInput").jtextclean({initValue: 'Search now!',cssElement: { color: "#660000",background: "#ffcc00"}});
 */
jQuery.fn.jtextclean = function(options) {
   //Default options
   var configuration = {
	  initValue: "Búsqueda",
	  cssClass: "alertinput"
   }
   jQuery.extend(configuration, options);

   this.each(function(){
      var elem = $(this);    
	  elem.attr({"value": configuration.initValue});
	  elem.addClass(configuration.cssClass);
	  
	  elem.click(function(evento){
		   elem.removeClass(configuration.cssClass);
		   if (elem.val()==configuration.initValue){elem.val('');}
	  });
		
	  elem.focusout(function(evento){
		   if (elem.val()==''){
			   elem.val(configuration.initValue);
			   elem.addClass(configuration.cssClass);
		   }
	  });
	  
   });
   return this;
};
})(jQuery);