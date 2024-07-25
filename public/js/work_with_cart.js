$(document).ready(function (){
    $(document).on('click','.buy-btn',function (){
        var service_id = $(this).closest(".view-simple").find(".service_id").val();
        var quantity = $(this).closest(".view-simple").find(".quantity").val();
        var mainmenu = $('.navbar-nav').find('.notification');
        var submenu = $('.notification').find('.dropdown-menu-end');       
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $.ajax({
            method: "POST",
            url: "/add-to-cart",
            data: {
                'service_id':service_id,
                'quantity':quantity,
            },
            success: function(response){
                setTimeout(function(){
                    mainmenu.attr("aria-expanded","true");
                    submenu.attr("data-bs-popper","none");
                    mainmenu.addClass('show');
                    submenu.addClass('show');

                    var path = '/uploads/services/' + response.image;
                    var cost = response.cost + '₽';
                    var name = response.name;
                    var message = "Добавлена услуга";

                    img = submenu.find('.service__img');
                    img.attr('src',path);

                    title = submenu.find('.modal-header-title');
                    title.text(message);

                    price = submenu.find('.service__price');
                    price.text(cost);

                    service_name = submenu.find('.modal-service__name');
                    service_name.text(name);

                    body = submenu.find('.modal__body');
                    body.css("display", "block");            
                },1000);

                setTimeout(function(){
                    mainmenu.attr("aria-expanded","false");
                    submenu.attr("data-bs-popper","none");
                    mainmenu.removeClass('show');
                    submenu.removeClass('show');
                },2000);
            } 
        });
    });


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
});


$(document).ready(function (){       
    $(document).on('click','.count-buttons__button', function(){
        var quantity = $(this).closest(".count-buttons").find(".count-buttons__input").val();
        var service_id = $(this).closest(".count-buttons").find(".service_id").val();

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
        }

        $.ajax({
            method: "POST",
            url: "/update-cart",
            data: data,
            success: function(response){
                window.location.reload();
            }
        });              
    });

    $(document).on('change','.count-buttons__input', function(){                                              
        var quantity = $(this).closest(".count-buttons").find(".count-buttons__input").val();
        var service_id = $(this).closest(".count-buttons").find(".service_id").val();
        
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
            'service_id':service_id,
        }

        $.ajax({
            method: "POST",
            url: "/update-cart",
            data: data,
            success: function(response){
                window.location.reload();
            }
        });              
    });
});
$(document).ready(function (){       
    $(document).on('click','.remove-button', function(){
    var service_id = $(this).closest(".cart-items__content-container").find(".service_id").val();
    var data = {
        '_token':$('input[name=_token]').val(),
        'service_id':service_id,
    }

    $.ajax({
        method: "POST",
        url:'/remove-cart',
        data:data,
        success: function (response){
            window.location.reload();
        }
    });
    });
});


$(document).ready(function (){       
    $(".base-ui-toggle__icon").click(function (e){
        e.preventDefault();
        
    let obj;
        
    if (!$(this).hasClass('base-ui-toggle__icon_checked')){
         obj = $(this).addClass('base-ui-toggle__icon_checked');
    }
    else {
         obj = $(this).removeClass('base-ui-toggle__icon_checked');
    }
    });
});


$(document).ready(function (){
    $(document).on('click','.base-ui-toggle__icon', function (){
        let sdm = 0;

        if ($('.base-ui-toggle__icon').hasClass('base-ui-toggle__icon_checked')){
          sdm = 2;
        }
        else {
          sdm = 1;
        }
        
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
        url:location.pathname,
        method:"GET",
        data: {
          sdm:sdm
        },
        success:function(data){
            let positionParameters = location.pathname.indexOf('?');
            let url = location.pathname.substring(positionParameters,location.pathname.length);
            let newURL = url + '?';

            if(sdm > 0){
              newURL += 'sdm='+sdm;
            }   
            else {
              newURL = location.pathname;
            }

            history.pushState({}, '',newURL);
          
            $(".cart-tab-services-list").html(data.content);
            $(".total-amount__summary-section").html(data.total);
          }
        });
    });
});


$(document).ready(function (){
  
  if(location.search != ""){
    function getUrlVars(){
      let vars = [], hash;
      let hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
      for(let i = 0; i < hashes.length; i++)
      {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        if (hash[1] != ""){
          vars[hash[0]] = decodeURIComponent(hash[1].split('#')[0]);
        }
      }
      return vars; 
    }

    function getUrlVar(name){
      return getUrlVars()[name];
    } 

  let sdm = 0;
  let bySdm = getUrlVar('sdm');
  if (bySdm != null){
    sdm  = parseInt(bySdm);
  } 

  if (sdm == 2){
     $('.base-ui-toggle__icon').addClass('base-ui-toggle__icon_checked');
  }
}
});

$(window).on('popstate',function(){
  if(location.search != ""){
    function getUrlVars(){
      let vars = [], hash;
      let hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
      for(let i = 0; i < hashes.length; i++)
      {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        if (hash[1] != ""){
          vars[hash[0]] = decodeURIComponent(hash[1].split('#')[0]);
        }
      }
      return vars; 
    }

    function getUrlVar(name){
      return getUrlVars()[name];
    } 

    let sdm = 0;
    let bySdm = getUrlVar('sdm');
    if (bySdm != null){
      sdm  = parseInt(bySdm);
    } 

  if (sdm == 2){
     $('.base-ui-toggle__icon').addClass('base-ui-toggle__icon_checked');
  }
  else {
    $('.base-ui-toggle__icon').removeClass('base-ui-toggle__icon_checked');
  }

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url:location.pathname,
    method:"GET",
    data:{
        sdm: sdm,
    },
    success:function(data){
        $(".cart-tab-services-list").html(data.content);
        $(".total-amount__summary-section").html(data.total);
      }
  });
}

});

