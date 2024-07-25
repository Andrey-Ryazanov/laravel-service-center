
$(document).ready(function (){
  $("input[data-interval]").change(function () {   
    if ($(this).data('interval') == "start"){
      start = $(this);
    }
    else{
      end = $(this);
    }
    if (start && end){
        validateInterval(start,end);  
    }
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

  $(document).on('click','.pagination a, .set_filter', function () {
    let intervals = [];
    $("input[data-interval]").each(function(){  
    if ($(this).val() != ""){
      intervals.push($(this).val()); 
    }
    });
    
    if(intervals.length != 2)
    {
      intervals.splice(0, intervals.length);
      $("input[data-interval]").val('');
    }
    
    let statuses = [];
    $("input[data-check]").each(function(){
      if ($(this).is(":checked")){
        statuses.push($(this).val());
      }
    });
    
    let newURL = $(this).attr("href");
    let append = newURL.indexOf("?") == -1 ? "?" : "&";

    if (statuses.length > 0 && intervals.length == 2){
        newURL += append + 'status='+statuses.join(',') + "&"+'interval='+intervals.join(',');
    }
    else if(statuses.length > 0){
        newURL += append + 'status='+statuses.join(',');
    }
    else if (intervals.length == 2){
        newURL += append + 'interval='+intervals.join(',');
    }
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
     $.ajax({
      url: newURL,
      data:{
          statuses:statuses,
          intervals:intervals,
      },
      cache: false,
      beforeSend: function() {
        $("section[data-widget]").css("opacity", 0);
      },
      success: function(data) {
        window.history.pushState({ url: newURL }, null, newURL);
        $("section[data-widget]").html(data.page).animate({opacity: 1}, 500);
      }
    });

  return false;
});
});

$(document).ready(function (){
  $(document).on('click','.reset_filter', function () {
    let statuses = [];
    let intervals = [];

    if (location.search != ""){
      $("input[data-check]").each(function(){
        if ($(this).is(":checked")){
          $(this).prop('checked',false);
        }
      });

      $('input[data-interval]').val('');


      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
      url:location.pathname,
      method:"GET",
      data:{
        statuses: statuses,
        intervals: intervals
      },
      beforeSend: function()
      {
        $('.order__list').css("opacity", "0");
      },
      success:function(data){
        let positionParameters = location.pathname.indexOf('?');
        let url = location.pathname.substring(positionParameters,location.pathname.length);

        history.pushState({}, '',url);
        $("section[data-widget]").html(data.page).animate({opacity: 1}, 500);
        }
      });
    }
  });
});


$(document).ready(function (){   
 function  getUrlVars(){
  let vars = [], hash;
  let hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
  for(let i = 0; i < hashes.length; i++)
  {
    hash = hashes[i].split('=');
    vars.push(hash[0]);
    vars[hash[0]] = decodeURIComponent(hash[1].split('#')[0]);
  }
  return vars;
  }
 function getUrlVar(name){
    return getUrlVars()[name];
  }

let statuses = [];
let byStatus = getUrlVar('status');
if (byStatus != null){
  statuses = byStatus.split(',');
}
statuses.forEach(function(value) {
   $('input[data-check="' + value + '"]').prop("checked", true);
});

let intervals = [];
let byInterval = getUrlVar('interval');
if (byInterval != null){
    intervals = byInterval.split(',');
}

$("input[data-interval]").each(function(){  
  if ($(this).data('interval') == "start"){
    start = $(this).val(intervals[0]);
  }
  if ($(this).data('interval') == "end"){
    end = $(this).val(intervals[1]);
  }
});
});

$(window).on('popstate', function(event) {
  $("input[data-check]").each(function(){
    if ($(this).prop("checked")){
      $(this).prop("checked",false);
    }
  });
  $("input[data-interval]").each(function(){
    if ($(this).val() != ""){
      $(this).val('');
    }
  });
  let newURL = location.href;
    $.ajax({
    url: newURL,
      beforeSend: function() {
        $("section[data-widget]").css("opacity", 0);
      },
      success: function(data) {
        $("section[data-widget]").html(data.page).animate({opacity: 1}, 500);
      }
    });
    
  if (event.originalEvent.state) {    

  let url = event.originalEvent.state.url;
  let params = url.split('?')[1];
  let intervals = params.match(/interval=([^&]*)/);
  let statuses = params.match(/status=([^&]*)/);
  if (intervals) {
    let intervalValues = intervals[1].split(',');
    $("input[data-interval]").each(function(index) {
      $(this).val(intervalValues[index]);
    });
  }
  if (statuses) {
    let statusValues = statuses[1].split(',');
    $("input[data-check]").each(function() {
      if (statusValues.includes($(this).val())) {
        $(this).prop("checked", true);
      } else {
        $(this).prop("checked", false);
      }
    });
  }
}
});


/*
$(window).on('popstate',function(){

  $("input[data-check]").each(function(){
    if ($(this).prop("checked")){
      $(this).prop("checked",false);
    }
  });

  $("input[data-interval]").each(function(){
    if ($(this).val() != ""){
      $(this).val('');
    }
  });

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

    let statuses = [];
    let byStatus = getUrlVar('status');
    if (byStatus != null){
      statuses = byStatus.split(',');
    }
    statuses.forEach(function(value) {
       $('input[data-check="' + value + '"]').prop("checked", true);
    });
    
    let intervals = [];
    let byInterval = getUrlVar('interval');
    if (byInterval != null){
        intervals = byInterval.split(',');
    }
    
    $("input[data-interval]").each(function(){  
      if ($(this).data('interval') == "start"){
        start = $(this).val(intervals[0]);
      }
      if ($(this).data('interval') == "end"){
        end = $(this).val(intervals[1]);
      }
    });


  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url:location.pathname,
    method:"GET",
    data:{
        statuses:statuses,
        intervals:intervals
    },
    beforeSend: function() {
      $('.order__list').css("opacity", "0");
    },
    success:function(data){
      $('.order__list').css("opacity", "1");
      $("section[data-widget]").html(data);
      }
  });
}

});*/
 /* $(document).ready(function (){   
    $.extend({
    getUrlVars: function(){
    let vars = [], hash;
    let hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(let i = 0; i < hashes.length; i++)
    {
      hash = hashes[i].split('=');
      vars.push(hash[0]);
      vars[hash[0]] = decodeURIComponent(hash[1].split('#')[0]);
    }
    return vars;
    },
    getUrlVar: function(name){
      return $.getUrlVars()[name];
    }
  });
  let statuses = [];
  let byStatus = $.getUrlVar('status');
  if (byStatus != null){
    statuses = byStatus.split(',');
  }
  statuses.forEach(function(value) {
     $('input[data-check="' + value + '"]').prop("checked", true);
  });

  let intervals = [];
  let byInterval = $.getUrlVar('interval');
  if (byInterval != null){
      intervals = byInterval.split(',');
  }

  $("input[data-interval]").each(function(){  
    if ($(this).data('interval') == "start"){
      start = $(this).val(intervals[0]);
    }
    if ($(this).data('interval') == "end"){
      end = $(this).val(intervals[1]);
    }
  });

    
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $.ajax({
      url:"myorders",
      method:"GET",
      data:{
        statuses: statuses,
        intervals: intervals
      },
      beforeSend: function()
      {
        $('.order__list').css("opacity", "0");
      },
      success:function(data){
        $('.order__list').css("opacity", "1");
          $("section[data-widget]").html(data);
        }
    });
  }); */