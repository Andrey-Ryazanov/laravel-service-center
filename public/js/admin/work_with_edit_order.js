      
$(document).ready(function (){     
    $(".count-buttons__input").blur(function() {
      if($(this).val() == "") {
        $(this).val("1");
      }
    });
    
     $(document).on("keydown input", ".ui-input-cost__input", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
        }
     });
    
   $(document).on("keydown input", ".count-buttons__input", function(event) {
    let inputValue = $(this).val();
    let cost = $('#cost').val();

    if (event.key === "Enter") {
        event.preventDefault();
    }
    if(inputValue > 99){
        $(this).val(99);
    }
    else if(inputValue < 1 && inputValue != ""){
        $(this).val(1);
    }
    else if(isNaN(inputValue)){
        $(this).val(1);
    }
    else if(inputValue.indexOf('.') != -1){
        $(this).val(Math.floor(inputValue));
    }
    else if(inputValue.indexOf('-') != -1){
        $(this).val(inputValue.replace('-', ''));
    }
    else if(inputValue.indexOf('e') != -1){
        $(this).val(1);
    }
    else if(inputValue.indexOf('+') != -1){
        $(this).val(1);
    }
    
    if (1 <= inputValue && inputValue <= 99){
        $('#price').val(cost * inputValue);
    }
});

    $(document).on('click','.count-buttons__button_plus', function(){
        var plus_value = $(this).parents(".count-buttons").find(".count-buttons__input").val();
        var value = parseInt(plus_value,10);

        value = isNaN(value) ? 0 : value;
        if (value < 99){
            value++;
            $(this).parents(".count-buttons").find(".count-buttons__input").val(value);
        }
        $('.count-buttons__input').trigger('input');
    });
    $(document).on('click','.count-buttons__button_minus', function(){
        var plus_value = $(this).parents(".count-buttons").find(".count-buttons__input").val();
        var value = parseInt(plus_value,10);
    
        value = isNaN(value) ? 0 : value;
        if(value > 1){
            value--;
        }
        $(this).parents(".count-buttons").find(".count-buttons__input").val(value);
        $('.count-buttons__input').trigger('input');
    });
    
}); 


