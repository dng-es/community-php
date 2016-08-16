(function($) {
/*
 * Bootstrap Modal for textareas
 *
 * @name     bootstrapTextArea
 * @param    title     Modal title
 * @param    rows      Textarea rows
 * @author   David Noguera Gutierrez
 * @example  $("textarea").bootstrapTextArea();
 * @example  $("textarea").bootstrapTextArea({title: "My title", lblSave: "Save changes", lblZoom: "Zoom", rows: 20});
 */
jQuery.fn.bootstrapTextArea = function(options) {
   //Default options
   var configuration = {
      title: "Content",
      lblSave: "Save changes",
      lblZoom: "Zoom",
      rows: 15
   }
   jQuery.extend(configuration, options);
   this.each(function(){
      var elem = $(this),
          container_element = $('<div style="position:relative"></div>'),
          menu_element = $('<span title="' + configuration.lblZoom + '" style="position:absolute; right: 10px; bottom: 5px"><span style="cursor:pointer" class="glyphicon glyphicon-pencil text-muted" aria-hidden="true"></span></span>'),
          modal_element = $('<div class="modal modal-wide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title" id="myModalLabel">' + configuration.title + '</h4></div><div class="modal-body"><textarea class="form-control" rows="' + configuration.rows + '"></textarea><div class="modal-footer"><button type="button" class="btn btn-primary btn-save">' + configuration.lblSave + '</button></div></div></div></div></div>'),
          showModal = function(e){
            $(modal_element).modal().find("textarea").val(elem.val());
          }

      elem.css({"resize" : "none"})
          .wrap(container_element)
          .after(menu_element)
          .dblclick(function(e){
            showModal();
          })
      
      menu_element.click(function(e){
        showModal();
      });

      modal_element.find(".btn-save").click(function(event) {
        $(modal_element).modal("hide");
        elem.val($(modal_element).find("textarea").val());
      });
      
      $("body").append(modal_element);
   });
   return this;
};
})(jQuery);