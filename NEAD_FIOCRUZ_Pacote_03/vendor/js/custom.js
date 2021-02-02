function calculateTotalValue(length) {
  var minutes = Math.floor(length / 60),
    seconds_int = length - minutes * 60,
    seconds_str = seconds_int.toString(),
    seconds = seconds_str.substr(0, 2),
    time = minutes + ':' + seconds

  return time;
}

function calculateCurrentValue(currentTime) {
  var current_hour = parseInt(currentTime / 3600) % 24,
    current_minute = parseInt(currentTime / 60) % 60,
    current_seconds_long = currentTime % 60,
    current_seconds = current_seconds_long.toFixed(),
    current_time = (current_minute < 10 ? "0" + current_minute : current_minute) + ":" + (current_seconds < 10 ? "0" + current_seconds : current_seconds);

  return current_time;
}

function initProgressBar(id) {
  var player = document.getElementById('player_'+id);
  var length = player.duration
  var current_time = player.currentTime;

  // calculate total length of value
  var totalLength = calculateTotalValue(length)
  jQuery("#end-time_"+id).html(totalLength);

  // calculate current value time
  var currentTime = calculateCurrentValue(current_time);
  jQuery("#start-time_"+id).html(currentTime);

  var progressbar = document.getElementById('seekObj_'+id);
  progressbar.value = (player.currentTime / player.duration);
  progressbar.addEventListener("click", seek);

  if (player.currentTime == player.duration) {
    $('#play-btn').attr('src','img/play.png');
  }

  function seek(evt) {
    var percent = evt.offsetX / this.offsetWidth;
    player.currentTime = percent * player.duration;
    progressbar.value = percent / 100;
  }
};

function initPlayers(num) {
  // pass num in if there are multiple audio players e.g 'player' + i
  for (var i = 1; i <=num; i++) {
    (function() {
      // Variables
      // ----------------------------------------------------------
      // audio embed object
      var playerContainer = document.getElementById('player-container_'+i),
        player = document.getElementById('player_'+i),
        isPlaying = false,
        playBtn = document.getElementById('play-btn_'+i);
      // Controls Listeners
      // ----------------------------------------------------------
      if (playBtn != null) {
        playBtn.addEventListener('click', function() {
          togglePlay(this.id)
        });
      }

      // Controls & Sounds Methods
      // ----------------------------------------------------------
      function togglePlay(n) {
        if (player.paused === false) {
          player.pause();
          isPlaying = false;
          $('#'+n).attr('src','img/play.png');

        } else {
          player.play();
          $('#'+n).attr('src','img/pause.png');
          isPlaying = true;
        }
      }
    }());
  }
}

$(document).ready(function(){

  $("body").keydown(function(e) {
    if (e.which == 39) { 
       $(".stepFoward").click();
       $(".stepFoward2").click();
        closeNav();
    }else if (e.which == 37) { 
       $(".stepBack").click();
       $(".stepBack2").click();
       closeNav();
    }
  });

  function findElement(element, id){
    var pagination; 
    if (element=='c') {pagination= id.substr(1,id.length-1);}else{pagination=id;}
    $('#side_module_pagination').text(pagination);

   $('page').load(id+'.php', function(){
         $('.highlight').each(function(){
            setTimeout('$(".highlight").addClass("highlighted")', 300);
       }); 
   });
   $(document).scrollTop(0);
   // $("#pagination_itens li").removeClass('active_mark');
   $("#mySidenav li").removeClass('active');
   // $('#'+this.id).addClass('active_mark');

  }

  $('#mySidenav li').click( function(){
    var id = this.id;

    let div = $(event.target).closest("div");

    /** Apresentação do Sistema **/

    if ((div.attr("id") === 'menu01_1')) {
      $('#menu01_1 li i').toggleClass('fa-angle-right fa-angle-down')
      $('#menu01_1').toggleClass('choosed');
    } else {
      $('#menu01_1 li i').removeClass('fa-angle-down');
      $('#menu01_1').removeClass('choosed');
      $('#menu01_1 li i').addClass('fa-angle-right');
    }
    if ((div.attr("id") === 'submenu01_1')) {
      $('#menu01_1 li i').removeClass('fa-angle-right');
      $('#menu01_1 li i').addClass('fa-angle-down');
      $('#menu01_1').addClass('choosed');
    }

    if ((div.attr("id") === 'menu01_2')) {
      $('#menu01_2 li i').toggleClass('fa-angle-right fa-angle-down')
      $('#menu01_2').toggleClass('choosed');
    } else {
      $('#menu01_2 li i').removeClass('fa-angle-down');
      $('#menu01_2').removeClass('choosed');
      $('#menu01_2 li i').addClass('fa-angle-right');
    }
    if ((div.attr("id") === 'submenu01_2')) {
      $('#menu01_2 li i').removeClass('fa-angle-right');
      $('#menu01_2 li i').addClass('fa-angle-down');
      $('#menu01_2').addClass('choosed');
    }

    /** Módulo Administrativo **/

    if ((div.attr("id") === 'menu02_1')) {
      $('#menu02_1 li i').toggleClass('fa-angle-right fa-angle-down')
      $('#menu02_1').toggleClass('choosed');
    } else {
      $('#menu02_1 li i').removeClass('fa-angle-down');
      $('#menu02_1').removeClass('choosed');
      $('#menu02_1 li i').addClass('fa-angle-right');
    }
    if ((div.attr("id") === 'submenu02_1')) {
      $('#menu02_1 li i').removeClass('fa-angle-right');
      $('#menu02_1 li i').addClass('fa-angle-down');
      $('#menu02_1').addClass('choosed');
    }

    if ((div.attr("id") === 'menu02_2')) {
      $('#menu02_2 li i').toggleClass('fa-angle-right fa-angle-down')
      $('#menu02_2').toggleClass('choosed');
    } else {
      $('#menu02_2 li i').removeClass('fa-angle-down');
      $('#menu02_2').removeClass('choosed');
      $('#menu02_2 li i').addClass('fa-angle-right');
    }
    if ((div.attr("id") === 'submenu02_2')) {
      $('#menu02_2 li i').removeClass('fa-angle-right');
      $('#menu02_2 li i').addClass('fa-angle-down');
      $('#menu02_2').addClass('choosed');
    }

    if ((div.attr("id") === 'menu02_3')) {
      $('#menu02_3 li i').toggleClass('fa-angle-right fa-angle-down')
      $('#menu02_3').toggleClass('choosed');
    } else {
      $('#menu02_3 li i').removeClass('fa-angle-down');
      $('#menu02_3').removeClass('choosed');
      $('#menu02_3 li i').addClass('fa-angle-right');
    }
    if ((div.attr("id") === 'submenu02_3')) {
      $('#menu02_3 li i').removeClass('fa-angle-right');
      $('#menu02_3 li i').addClass('fa-angle-down');
      $('#menu02_3').addClass('choosed');
    }


    if ((div.attr("id") === 'menu02_4')) {
      $('#menu02_4 li i').toggleClass('fa-angle-right fa-angle-down')
      $('#menu02_4').toggleClass('choosed');
    } else {
      $('#menu02_4 li i').removeClass('fa-angle-down');
      $('#menu02_4').removeClass('choosed');
      $('#menu02_4 li i').addClass('fa-angle-right');
    }
    if ((div.attr("id") === 'submenu02_4')) {
      $('#menu02_4 li i').removeClass('fa-angle-right');
      $('#menu02_4 li i').addClass('fa-angle-down');
      $('#menu02_4').addClass('choosed');
    }

    if ((div.attr("id") === 'menu02_5')) {
      $('#menu02_5 li i').toggleClass('fa-angle-right fa-angle-down')
      $('#menu02_5').toggleClass('choosed');
    } else {
      $('#menu02_5 li i').removeClass('fa-angle-down');
      $('#menu02_5').removeClass('choosed');
      $('#menu02_5 li i').addClass('fa-angle-right');
    }
    if ((div.attr("id") === 'submenu02_5')) {
      $('#menu02_5 li i').removeClass('fa-angle-right');
      $('#menu02_5 li i').addClass('fa-angle-down');
      $('#menu02_5').addClass('choosed');
    }

    /** Módulo Atendimento **/

    if ((div.attr("id") === 'menu03_1')) {
      $('#menu03_1 li i').toggleClass('fa-angle-right fa-angle-down')
      $('#menu03_1').toggleClass('choosed');
    } else {
      $('#menu03_1 li i').removeClass('fa-angle-down');
      $('#menu03_1').removeClass('choosed');
      $('#menu03_1 li i').addClass('fa-angle-right');
    }
    if ((div.attr("id") === 'submenu03_1')) {
      $('#menu03_1 li i').removeClass('fa-angle-right');
      $('#menu03_1 li i').addClass('fa-angle-down');
      $('#menu03_1').addClass('choosed');
    }

    if ((div.attr("id") === 'menu03_2')) {
      $('#menu03_2 li i').toggleClass('fa-angle-right fa-angle-down')
      $('#menu03_2').toggleClass('choosed');
    } else {
      $('#menu03_2 li i').removeClass('fa-angle-down');
      $('#menu03_2').removeClass('choosed');
      $('#menu03_2 li i').addClass('fa-angle-right');
    }
    if ((div.attr("id") === 'submenu03_2')) {
      $('#menu03_2 li i').removeClass('fa-angle-right');
      $('#menu03_2 li i').addClass('fa-angle-down');
      $('#menu03_2').addClass('choosed');
    }

    /** Módulo Movimentação e Logística **/

    if ((div.attr("id") === 'menu04_1')) {
      $('#menu04_1 li i').toggleClass('fa-angle-right fa-angle-down')
      $('#menu04_1').toggleClass('choosed');
    } else {
      $('#menu04_1 li i').removeClass('fa-angle-down');
      $('#menu04_1').removeClass('choosed');
      $('#menu04_1 li i').addClass('fa-angle-right');
    }
    if ((div.attr("id") === 'submenu04_1')) {
      $('#menu04_1 li i').removeClass('fa-angle-right');
      $('#menu04_1 li i').addClass('fa-angle-down');
      $('#menu04_1').addClass('choosed');
    }

    if ((div.attr("id") === 'menu04_2')) {
      $('#menu04_2 li i').toggleClass('fa-angle-right fa-angle-down')
      $('#menu04_2').toggleClass('choosed');
    } else {
      $('#menu04_2 li i').removeClass('fa-angle-down');
      $('#menu04_2').removeClass('choosed');
      $('#menu04_2 li i').addClass('fa-angle-right');
    }
    if ((div.attr("id") === 'submenu04_2')) {
      $('#menu04_2 li i').removeClass('fa-angle-right');
      $('#menu04_2 li i').addClass('fa-angle-down');
      $('#menu04_2').addClass('choosed');
    }

    if ((div.attr("id") === 'menu04_3')) {
      $('#menu04_3 li i').toggleClass('fa-angle-right fa-angle-down')
      $('#menu04_3').toggleClass('choosed');
    } else {
      $('#menu04_3 li i').removeClass('fa-angle-down');
      $('#menu04_3').removeClass('choosed');
      $('#menu04_3 li i').addClass('fa-angle-right');
    }
    if ((div.attr("id") === 'submenu04_3')) {
      $('#menu04_3 li i').removeClass('fa-angle-right');
      $('#menu04_3 li i').addClass('fa-angle-down');
      $('#menu04_3').addClass('choosed');
    }


    if ((div.attr("id") === 'menu04_4')) {
      $('#menu04_4 li i').toggleClass('fa-angle-right fa-angle-down')
      $('#menu04_4').toggleClass('choosed');
    } else {
      $('#menu04_4 li i').removeClass('fa-angle-down');
      $('#menu04_4').removeClass('choosed');
      $('#menu04_4 li i').addClass('fa-angle-right');
    }
    if ((div.attr("id") === 'submenu04_4')) {
      $('#menu04_4 li i').removeClass('fa-angle-right');
      $('#menu04_4 li i').addClass('fa-angle-down');
      $('#menu04_4').addClass('choosed');
    }

    /** Conclusão **/

    if ((div.attr("id") === 'menu05_1')) {
      $('#menu05_1 li i').toggleClass('fa-angle-right fa-angle-down')
      $('#menu05_1').toggleClass('choosed');
    } else {
      $('#menu05_1 li i').removeClass('fa-angle-down');
      $('#menu05_1').removeClass('choosed');
      $('#menu05_1 li i').addClass('fa-angle-right');
    }
    if ((div.attr("id") === 'submenu05_1')) {
      $('#menu05_1 li i').removeClass('fa-angle-right');
      $('#menu05_1 li i').addClass('fa-angle-down');
      $('#menu05_1').addClass('choosed');
    }


     var find = id.substr(0,1);

     if(find == 'c'){
      findElement(find, id);
      $('#'+this.id).addClass('active');
      closeNav();
     }


  });

  // ============ Hide buttons on scroll =================
  var position = $(window).scrollTop(); 

  $('.highlight').ready(function (){
    setTimeout('$(".highlight").addClass("highlighted")', 300);
  });

  
  $(window).scroll(function() {
      var docHeight = $(document).innerHeight();
      var winHeight = $(window).innerHeight();
      var scroll = $(window).scrollTop();
      if(scroll > position) {
        $('.stepBack').css('bottom', '-100px');
        $('.stepFoward').css('bottom', '-100px');
        $('.side_menu_btn').css('top', '-100px');
         $('.side_module').css('top', '-100px');
        $('.header-bar').css('top', '-100px');
      } else {
        $('.stepBack').css('bottom', '40px');
        $('.stepFoward').css('bottom', '40px');
        $('.side_menu_btn').css('top', '0px');
         $('.side_module').css('top', '10px');
        $('.header-bar').css('top', '0px');        
      }
      position = scroll;

      if((scroll+winHeight)>=docHeight){ // chegou ao final
         $('.stepBack').css('bottom', '40px');
        $('.stepFoward').css('bottom', '40px');
        $('.side_menu_btn').css('top', '0px');
         $('.side_module').css('top', '10px');
        $('.header-bar').css('top', '0px');        
      } 
  });


// =====================================================

    $('[id^=player_]').each(function(){
      var audio_id = this.id;
      this.onplaying = function(){
        $('audio').each(function(){
            if (this.id!=audio_id) {
              this.pause(); 
            }
          });
          $('video').each(function(){
              this.pause(); 
          });
      }
    });
    $('[id^=video_]').each(function(){
      var video_id = this.id;
      this.onplaying = function(){
        $('video').each(function(){
            if (this.id!=video_id) {
              this.pause(); 
            }
          });
          $('audio').each(function(){
              this.pause(); 
          });
      }
    });
  });

initPlayers(jQuery('[id^=player-container]').length);


 $window = $(window);
    //Captura cada elemento section com o data-type "background"
    $('.parallax[data-type="background"]').each(function(){
        var $scroll = $(this);   
            //Captura o evento scroll do navegador e modifica o backgroundPosition de acordo com seu deslocamento.            
            $(window).scroll(function() {
                var yPos = -($window.scrollTop() / $scroll.data('speed')); 
                var coords = '50% '+ yPos + 'px';
                $scroll.css({ backgroundPosition: coords });    
            });
    }); 



/*==================== MENU ============ */

function openNav() {
  document.getElementById("mySidenav").style.left = "0px";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
function closeNav() {
  document.getElementById("mySidenav").style.left = "-380px";
}
// ----------------------------------------------

function stepNavigationNew(page){
  window.location = page + '.php';
}


function stepNavigation(page){
    var find = page.substr(0,1);
    var pagination; 
    if (find=='c') {
      pagination= page.substr(1,page.length-1);
    }else{
      pagination=page;
    }
    $('#side_module_pagination').text(pagination);
    $('page').load(page+'.php', function(){
        $('.highlight').each(function(){
          setTimeout('$(".highlight").addClass("highlighted")', 300);
        });
    });
    $(document).scrollTop(0);
    $("#mySidenav li").removeClass('active');
    //$('#'+page).addClass('active');

    closeNav();
}
