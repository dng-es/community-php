(function($) {
/*
 * Add icons alerts to form inputs after submit with wrong/false response
 *
 * @name     iconsalerts
 * @param    alertClass    Css class witch indicates alert
 * @param    cssClass      Css class to aply
 * @param    icon          Css class containing font-icon
 * @param    right         Css property
 * @param    top           Css property
 * @author   David Noguera Gutierrez
 * @example  $("#myform").submit().iconsalerts();
 * @example  $("#myform").submit().iconsalerts({cssClass:"text-warning"});
 */
jQuery.fn.iconsalerts = function(options) {
   //Default options
   var configuration = {
      alertClass: "input-alert",
      cssClass: "text-danger",
      icon: "glyphicon glyphicon-remove-circle",
      right: 5,
      top: 1
   }
   jQuery.extend(configuration, options);

   this.each(function(){
      var elem = $(this),
      container_element = $('<div class="fcf-container" style="position:relative"></div>'),
      elem_alert = '<span class="' + configuration.icon + ' ' + configuration.cssClass + ' form-control-feedback faa-tada animated" aria-hidden="true"; style="position: absolute;right:' + configuration.right + 'px;top: ' + configuration.top + 'px"></span>';
      
      elem.submit(function(e){
         elem.find(".form-control-feedback").remove();
         elem.find(':input, select').each(function() {
            var elemento = this;
            if ($("#"+ elemento.id).parent().hasClass("fcf-container")) $("#"+ elemento.id).unwrap();
            if ($("#"+ elemento.id).hasClass(configuration.alertClass)) $("#"+ elemento.id).wrap(container_element).after(elem_alert);
         });
      });
   });
   return this;
};
})(jQuery);