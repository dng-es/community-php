(function($) {
/*
 * Bootstrap Modal for textareas
 *
 * @name     bootstrapTextArea
 * @param    title     Modal title
 * @param    rows      Textarea rows
 * @author   David Noguera Gutierrez
 * @example  
 *      $("textarea").bootstrapTextArea();
 * @example  
 *      $("textarea").bootstrapTextArea({
 *           title: "My title", 
 *           saveText: "Save changes", 
 *           zoomText: "Zoom", 
 *           rows: 20, 
 *           autoexpand: true
 *       });
 */
jQuery.fn.bootstrapTextArea = function(options) {
   //Default options
    var configuration = {
        title: "Content",
        saveText: "Save changes",
        zoomText: "Zoom",
        rows: 5,
        icon: "glyphicon glyphicon-pencil",
        autoexpand: false,
        maxSizeElement: 99999,
        counter: false,
        counterText: "Characters",
        counterCss: {
            display: "inline-block",
            color: "#000000"
        }
    }

   jQuery.extend(configuration, options);
    this.each(function(){
        var elem = $(this),
        container_element = $('<div style="position:relative"></div>'),
        menu_element = $('<span title="' + configuration.zoomText + '" style="position:absolute; right: 10px; bottom: 5px"><span style="cursor:pointer" class="' + configuration.icon + ' text-muted" aria-hidden="true"></span></span>'),
        modal_element = $('<div class="modal modal-wide fade" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">' + configuration.title + '</h4></div><div class="modal-body"><textarea class="form-control" rows="' + configuration.rows + '"></textarea><div class="modal-footer"><button type="button" class="btn btn-primary btn-save">' + configuration.saveText + '</button></div></div></div></div></div>'),
        counter_element = $('<div class="textarea-message">' + configuration.counterText + ': ' + elem.val().length + ' ('+configuration.maxSizeElement+')</div>');     



        showModal = function(e){
            $(modal_element).modal().find("textarea").val(elem.val());
        }

        autosize = function(e){
            setTimeout(function(){
                elem[0].style.cssText = 'height:auto;';
                elem[0].style.cssText = 'height:' + (elem[0].scrollHeight + 2) + 'px';
            },0);
        }

        elem.css({"resize" : "none"})
            .wrap(container_element)
            .after(menu_element)     
            //.after(counter_element)
            .data("counter_field", counter_element)
            .attr("maxlength", configuration.maxSizeElement)
            .dblclick(function(e){
                showModal();
            })
            .keydown(function(e){
                if (configuration.autoexpand){
                    autosize();
                }

                if (elem.val().length>=configuration.maxSizeElement && configuration.maxSizeElement>0){
                    if (e.which!=8 && e.which!=37 && e.which!=38 && e.which!=46) { return false;}
                }
            })
            .keyup(function(){
                var counter_field = elem.data("counter_field");
                counter_field.text(configuration.counterText + ': ' + elem.val().length+ ' ('+configuration.maxSizeElement+')');
            });

        menu_element.click(function(e){
            showModal();
        });

        modal_element.find(".btn-save").click(function(event) {
            $(modal_element).modal("hide");
            elem.val($(modal_element).find("textarea").val());
            autosize();
        });


        if (configuration.counter){
            elem.after(counter_element);
            counter_element.css(configuration.counterCss);
        }

        $("body").append(modal_element);
    });
    return this;
};
})(jQuery);