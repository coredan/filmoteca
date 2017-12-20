$(document).ready(function(){

  $('#yearRange').on('input',function() {    
    $('label[for='+$(this).attr('id')+']').text($(this).val());    
  });

  // MENU DESPLEGABLE
  $('label.title').on('click', function(){
      
      if($(this).next().hasClass('desplegado')){        
        $(this).children('i').attr('class','fa fa-folder');
        $(this).next().removeClass('desplegado');
      }else{                
        $(this).children('i').attr('class','fa fa-folder-open');        
         $(this).next().addClass('desplegado');
      }
   });
    
  // BUTTON ADD NEW LINK TO LIST:  
  $('#online_link').on('input', function(){
    var val = $(this).val();
    $('#addLinkButton').attr('disabled', !/^(f|ht)tps?:\/\//i.test(val));    
  });

  $('#addLinkButton').on('click', function(){
    var val = $('#online_link').val();
    $('#linksList').append(
      $('<li>').append($('<span>').text(val))
      .append($('<button>').attr('type','button').addClass('btn btn-danger btn-xs pull-right').text('Remove')));
      $('.links-place').append($('<input type="hidden" name="Films[links][]">').val(val))
  });

  $('#linksList').on('click', 'button', function(){    
    $(this).closest('li').remove();
  });

  // NEWFILMS FORM SUBMIT:
  $("form#newfilmForm").submit(function(e) {    
    e.preventDefault();
    
    var formData = new FormData(this);      
    swal({
      title: "New Film",
      text: "Save this new film?",
      type: "info",
      showCancelButton: true,
      confirmButtonClass: "btn-success",
      confirmButtonText: "Yes, save",
      cancelButtonText: "Cancel",
      closeOnConfirm: false
    },
    function(){
      $("#saveFilmButton").children('i').removeClass('hidden').end().children('span').text("Saving... wait");
      $.ajax({
        url: '/films/save',
        type: 'POST',
        data: formData,
        success: function (data) {
             console.dir(data);
            if(data.status === "success"){  

              swal("Film Saved!", "The film has been saved", "success");
              $("#saveFilmButton").children('i').addClass('hidden').end().children('span').text("Save");
            } else {
              var errors = "";
              $.each(data.errors, function(index, val) {
                  errors += "<p>" + val + "</p>";
              });
              swal({
                title: "Error while saving",               
                text: errors, 
                type: "error"
              });
            }
        },
        cache: false,
        contentType: false,
        processData: false
      });      
    });
  });

  // FILMS UPDATE FORM SUBMIT:
  $("form#frmUpdateFilm").submit(function(e) {    
    e.preventDefault();    

    var formData = new FormData(this);

    $.ajax({
        url: '/films/update',
        type: 'POST',
        data: formData,
        success: function (data) {
            console.dir(data);
            if(data.success === true){               
              
            }
        },
        cache: false,
        contentType: false,
        processData: false       
      });     
    
  });

  $('#editFilmButton').on('click',function(){
    var $button = $(this);
    var showForm = !$button.children('i').hasClass('fa-ban');
    var text = $(this).text();
    var content = "";
    
    // $('.row.update').toggleClass("hidden");
    if(showForm){
      $button.children('i').removeClass('fa-pencil-square').addClass('fa-ban');
      $('.row.update').fadeIn("normal");
      //console.log($button.children('i').attr('class'));      
      //$('.row.details').removeClass("hidden");
    } else {
      $button.children('i').removeClass('fa-ban').addClass('fa-pencil-square');      
      $('.row.update').fadeOut("normal");
      //$('.row.details').addClass("hidden");
    }      

  });

  function showUpdateForm(show, toHide, toShow, content) {
    $toHide.removeClass('last').addClass('hidden');
    $toShow.removeClass('hidden').addClass('last');

    $toShow.children('input, textarea').val(content);
  }
  

  $('.newfilms_slider').slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow:10,
    slidesToScroll: 10,
    variableWidth: true,
    responsive: [
     {
        breakpoint: 1200,
        settings: {
          slidesToShow: 8,
          slidesToScroll: 8,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 6,
          slidesToScroll: 6,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 700,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 4
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ]
  });

  $('input').iCheck({
    checkboxClass: 'icheckbox_futurico',
    radioClass: 'iradio_futurico',
    increaseArea: '20%' // optional
  }).on('ifChecked', function(event){
    console.dir(event);
    $("label[for="+event.currentTarget.id+"]").addClass('checked');
  }).on('ifUnchecked', function(event){
    console.dir(event);
    $("label[for="+event.currentTarget.id+"]").removeClass('checked');
  });


  $('[data-toggle="popover"]').popover({
    container: 'body',
    html: true,
    trigger: "hover",
    placement: "auto",
    content: function () {
        var clone = $($(this).data('popover-content')).clone(true).removeClass('hidden');
        return clone;
    }
  });

  $( "#year-slider-range" ).slider({
    range: true,
    min: 1970,
    max: 2017,
    values: [ $( "#year-slider-range" ).attr("first"), $( "#year-slider-range" ).attr("last") ],
    slide: function( event, ui ) {
      $( "#amount" ).val( "De " + ui.values[ 0 ] + " a " + ui.values[ 1 ] );
    }
  });
  
  $( "#amount" ).val( "De " + $( "#year-slider-range" ).slider( "values", 0 ) +
    " a " + $( "#year-slider-range" ).slider( "values", 1 ) );  

});