   $(document).ready(function (){     
   
    $(document).on('click','.count-buttons__button_plus', function(){
        var plus_value = $(this).parents(".count-buttons").find(".count-buttons__input").val();
        var value = parseInt(plus_value,10);

        value = isNaN(value) ? 0 : value;
        if (value < 99){
            value++;
            $(this).parents(".count-buttons").find(".count-buttons__input").val(value);
        }

    });
    $(document).on('click','.count-buttons__button_minus', function(){
        var plus_value = $(this).parents(".count-buttons").find(".count-buttons__input").val();
        var value = parseInt(plus_value,10);

        value = isNaN(value) ? 0 : value;
        value--;
        $(this).parents(".count-buttons").find(".count-buttons__input").val(value);
    });
    
    $(document).on('click','.remove-button', function(){
    var service_id = $(this).closest(".cart-items__content-container").find(".service_id").val();
    var order_id = $(this).closest(".cart-items__content-container").find(".order_id").val();
    var data = {
        'service_id':service_id,
        'order_id':order_id,
    }
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        method: "POST",
        url:'/administration/remove-orderItem',
        data:data,
        success: function (response){
            window.location.reload();
        }
    });
    });
    
    $(document).on('click','.count-buttons__button', function(){
        var quantity = $(this).closest(".count-buttons").find(".count-buttons__input").val();
        var service_id = $(this).closest(".count-buttons").find(".service_id").val();
        var order_id = $(this).closest(".count-buttons").find(".order_id").val();
        var cost = $(this).closest(".count-buttons").find(".cost_service").val();

        if (quantity>99){
            quantity = 99;
        }

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        data = {
            'quantity' :quantity,
            'service_id':service_id,
            'cost' : cost,
            'order_id':order_id,
        }

        $.ajax({
            method: "POST",
            url: "/administration/update-orderItemsCount",
            data: data,
            success: function(response){
                window.location.reload();
            }
        });              
    });
    
    function validateInterval(start,end){
    if (start.val()!= "" && end.val() != ""){
      if (start.val() > end.val()){
        t = start.val();
        start.val(end.val());
        end.val(t);
          }
        }
      }
    
    $(document).on('change', '.deadline', function() {
        var start_date = $("#start");
        var end_date =  $("#end");
        validateInterval(start_date,end_date);
    });

    $('.deadline_calculate').on('click', function() {
        var order_id = $(this).closest(".deadline__container").find(".order_id").val();
        var start_date = $("#start").val();
        var end_date =  $("#end");
        if (start_date != ""){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        data = {
            'order_id':order_id,
            'start_date':start_date,
        }
            
        $.ajax({
            url: "/administration/calculate-deadline",
            type: 'POST',
            data: data,
            success: function(response) {
                end_date.val(response.result);
            }
        });
        }
    });
    
        $('.deadline_install').on('click', function() {
        var order_id = $(this).closest(".deadline__container").find(".order_id").val();
        var start_date = $("#start").val();
        var end_date =  $("#end").val();
        
        if (start_date != "" && end_date!=""){
             $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        data = {
            'order_id':order_id,
            'start_date':start_date,
            'end_date':end_date,
        }
            
        $.ajax({
            url: "/administration/update-deadline",
            type: 'POST',
            data: data,
            success: function(response) {
                 window.location.reload();
            }
        });
        }
    });
    
    
        $('.order-select-status').on('change', function() {
        var status_id = $(this).val();
        var order_id = $(this).closest(".status-value__container").find(".order_id").val();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        data = {
            'order_id':order_id,
            'status_id':status_id
        }
            
        $.ajax({
            url: "/administration/update-status",
            type: 'POST',
            data: data,
            success: function(response) {
                 window.location.reload();
            }
        });
    });

    $(document).on('change','.count-buttons__input', function(){                                              
        var quantity = $(this).closest(".count-buttons").find(".count-buttons__input").val();
        var service_id = $(this).closest(".count-buttons").find(".service_id").val();
        var order_id = $(this).closest(".count-buttons").find(".order_id").val();
        var cost = $(this).closest(".count-buttons").find(".cost_service").val();
        
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        if (quantity>99){
            quantity = 99;
        }

        data = {
            'quantity' :quantity,
            'cost' : cost,
            'service_id':service_id,
            'order_id':order_id,
        }

        $.ajax({
            method: "POST",
            url: "/administration/update-orderItemsCount",
            data: data,
            success: function(response){
                window.location.reload();
            }
        });              
    });
});
