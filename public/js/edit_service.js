$(document).ready(function (){  

    $('.form-control-deadline').on('input', function() {
      var input = $(this);
      var value = input.attr('id');
      var checkbox_block = $(this).parent().parent();
      var check = checkbox_block.find('.ui-checkbox__input');

      console.log(check.attr('id'));
      if (input.val() != "" && check.attr('id',value)){
          check.attr("checked","checked");
      }
      if (input.val().length = 0 && check.prop('checked') && check.attr('id',value)){
          check.removeAttr('checked');
      }

      if (check.prop('checked')){
        input.attr("required", "true");
      }

      });

    //var blocks = $('[data-rubric]');
    $('.ui-checkbox-container :checkbox').click(function() {
    var value = $(this).attr('id');
    var checkbox = $('.ui-checkbox-container :checkbox:checked').length;
    var block = $('[data-rubric='+ value +']');
    var input = block.find('.form-control-deadline');
    if (checkbox >= 1){
        if($(this).prop('checked')) {
          if (input.attr('id',value)){
            input.attr("required", "true");
          }
          block.show();
        }
        else {
          if (input.attr('id',value)){
            $(this).removeAttr("checked");
            input.removeAttr("required");
            input.val('');
          }
        block.hide();
        }
    }
    else {
      if($(this).prop('checked')) {
          if (input.attr('id',value)){
            input.attr("required", "true");
          }
          block.show();
        }
        else {
          if (input.attr('id',value)){
            $(this).removeAttr("checked");
            input.removeAttr("required");
            input.val('');
          }
          block.hide();
        }
    }
    });
  }); 
