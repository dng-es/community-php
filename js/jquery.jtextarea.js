(function($) {
/*
 * Count characters introduced in a textarea and limits the numbers of
 * characters user can type down. A counter DIV is added wich CSS can be
 * set up through options parameters.
 *
 * @name     jtextarea
 * @param    maxSizeElement      Max characters can be introduced. 0 = No limit
 * @param    cssElement      Counter DIV css
 * @param    textElement      Counter DIV text
 * @author   David Noguera Gutierrez
 * @example  $(".jtextarea").jtextarea();
 * @example  $(".jtextarea").jtextarea({maxSizeElement: 30, 
 			 cssElement: { display: "inline-block",color: "#660000",background: "#ffcc00"}});
 */
jQuery.fn.jtextarea = function(options) {
   //Default options
   var configuration = {
      maxSizeElement: 140,
	  textElement: "Caracteres",
	  cssElement: {
         display: "block",
         color: "#000000"
      }
   }
   jQuery.extend(configuration, options);

   this.each(function(){
      var elem = $(this);
      var counter_element = $('<div class="textarea-message">' + configuration.textElement + ': ' + elem.val().length + ' (max. '+configuration.maxSizeElement+')</div>');
	  counter_element.css(configuration.cssElement);
      elem.after(counter_element);
      elem.data("counter_field", counter_element);
      
      elem.keydown(function(e){
		  if (elem.val().length>=configuration.maxSizeElement && configuration.maxSizeElement>0)
		  {
			 if (e.which!=8 && e.which!=37 && e.which!=38 && e.which!=46) { return false;}
		  }
      });

      elem.keyup(function(){
		 var counter_field = elem.data("counter_field");
		 counter_field.text(configuration.textElement + ': ' + elem.val().length+ ' (max. '+configuration.maxSizeElement+')');
      });
   });
   return this;
};
})(jQuery);