$(document).ready(function (){
    $(document).on('click','.buy-btn',function (){
        var service_id = $(this).closest(".view-simple").find(".category_service_id").val();
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
            statusCode: {
                200: function(response){
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
                },
                401: function(response){
                    window.location.href = '/login';
                },
            } 
        });
    });
 });


$(document).ready(function (){
  $(document).on('click','.reset_filter',(function () {
    let sdms = [];
    let search = "";

    if (location.search != ""){
      $("input[data-sdm]").each(function(){
        if ($(this).is(":checked")){
          $(this).prop('checked',false);
        }
      });

      $('.ui-input-search__input').val('');


      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
      url:location.pathname,
      method:"GET",
      data:{
        sdms: sdms,
        search: search
      },
      beforeSend: function()
      {
        $('.services-page__list').css("opacity", "0");
      },
      success:function(data){
        $('.services-page__list').css("opacity", "1");
        let positionParameters = location.pathname.indexOf('?');
        let url = location.pathname.substring(positionParameters,location.pathname.length);

        history.pushState({}, '',url);
        
        $(".services-page__list").html(data);
        }
      });
    }
  }));


  $('.set_filter').click(function () {
      let sdms = [];
      $("input[data-sdm]").each(function(){
        if ($(this).is(":checked")){
          sdms.push($(this).val());
        }
      });
      
      localStorage.setItem('services-sdms',sdms);
      ajax();
    });

    $('.ui-input-search__input').change(function () {
      let search =  $('.ui-input-search__input').val();
      localStorage.setItem('services-search',search);
      ajax(); 
  });

  function ajax(){
    let sdms = [];
    let search;
    let bySdms = localStorage.getItem('services-sdms');

    if (bySdms != "" && bySdms != null){
      sdms  = bySdms.split(',');
    }
    search = localStorage.getItem('services-search');

    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
    url:location.pathname,
    method:"GET",
    data:{
      sdms: sdms,
      search: search
    },
    beforeSend: function()
    {
      $('.services-page__list').css("opacity", "0");
    },
    success:function(data){
      $('.services-page__list').css("opacity", "1");
      let positionParameters = location.pathname.indexOf('?');
      let url = location.pathname.substring(positionParameters,location.pathname.length);
      let newURL = url + "?";

      if (search != "" && search != undefined && sdms.length > 0){
        newURL += 'search=' + search + '&' + 'sdm='+sdms.join(',');
      }

      else if (search != "" && search != undefined){
        newURL += 'search=' + search;
      }
      else if(sdms.length > 0){
        newURL += 'sdm='+sdms.join(',');
      }   
      else {
        newURL = location.pathname;
      }

      history.pushState({}, '',newURL);
      
      $(".services-page__list").html(data);
      }
    });
  }
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

  let sdms = [];
  let bySdms = getUrlVar('sdm');
  let search = getUrlVar('search');

  if (bySdms != null){
    sdms  = bySdms.split(',');
  }

  sdms.forEach(function(value) {
     $('input[data-sdm="' + value + '"]').prop("checked", true);
  });
  $('.ui-input-search__input').val(search);  
  }
  localStorage.removeItem('services-search');
  localStorage.removeItem('services-sdms');
});

$(window).on('popstate',function(){
  $("input[data-sdm]").each(function(){
    if ($(this).prop("checked")){
      $(this).prop("checked",false);
    }
  });
  $('.ui-input-search__input').val('');

  let sdms = [];
  let search = "";
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
    
    let bySdms = getUrlVar('sdm');
    if (bySdms != "" && bySdms != null){
      sdms  = bySdms.split(',');
    }

    search = getUrlVar('search');
 
    sdms.forEach(function(value) {
      $('input[data-sdm="' + value + '"]').prop("checked", true);
    });

    $('.ui-input-search__input').val(search);
  }

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  $.ajax({
    url:location.pathname,
    method:"GET",
    cache:false,
    data:{
        sdms: sdms,
        search: search,
    },
    beforeSend: function()
    {
      $('.services-page__list').css("opacity", "0");
    },
    success:function(data){
      $('.services-page__list').css("opacity", "1");
        $(".services-page__list").html(data);
      }
  });
  localStorage.removeItem('services-search');
  localStorage.removeItem('services-sdms');
});