function adjustVideoOn(){
    $('#msg_aluno').hide();
    $('#video_principal').toggleClass('col-lg-8 col-lg-12');
    $('#btn_close').show();
}
function adjustVideoOff(){
  $('#msg_aluno').show();
  $('#video_principal').toggleClass('col-lg-12 col-lg-8');
  $('#btn_close').hide();
}
