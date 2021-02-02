<?php require_once 'includes/head.php'; ?>

<body>
  <?php require_once 'includes/nav.php'; ?>
  <html>

  <body>
    <div class="container mt-5 container-video">
      <div class="row">
        <div id="msg_aluno" class="col-lg-4 texto-informativo">
          <div class="row">
            <div class="col-lg-10">
              <h4 class="titulo_informacao">Olá participante,</h4>
            </div>
            <div class="col-lg-2">
              <a href="javascript:void(0)" class="closebtn" onclick="adjustVideoOn()"><i class="fas fa-times"></i></a>
            </div>
          </div>
          <p class="frase_video">Para realizar essa etapa com sucesso e alcançar as metas de aprendizagem online, você
            deverá:</p>
          <ul class="frase_video_lista">
            <li><i class="fas fa-arrow-right"></i>Assistir ao vídeo;</li>
            <li><i class="fas fa-arrow-right"></i>Realizar os exercícios de fixação propostos, lembrando que os
              exercícios são avaliativos; e</li>
            <li><i class="fas fa-arrow-right"></i>Acessar o manual, se for necessário complementar os seus
              conhecimentos. Lembrando que este manual poderá ser impresso.</li>
          </ul>
        </div>
        <div id="video_principal" class="col-lg-8 text-left">
          <div class="video text-center">
            <div class="row">
              <div class="col-lg-11">
                <span class="video_title">Saída diversa</span>
              </div>
              <div class="col-lg-1">
                <a href="javascript:void(0)" id="btn_close" class="video_title closebtn" onclick="adjustVideoOff()"><i
                    class="fas fa-compress"></i></a>
              </div>
            </div>
            <video id="custom_video_play" controls="controls">
              <source src="https://efg.brasilia.fiocruz.br/ava/external/ESUS_Recursos/videos/saida_diversa.mp4"
                type="video/mp4">
              Your browser does not support HTML5 video.
            </video>
          </div>
        </div>
      </div>
    </div>

    <div class="stepBack" onclick="stepNavigationNew('c27');"><i class="fas fa-chevron-left"></i></div>
    <div class="stepFoward" onclick="stepNavigationNew('c29');"><i class="fas fa-chevron-right"></i></div> 


    </div>


    <?php require_once 'includes/footer.php'; ?>

  </body>


  </html>

  <script>

    $(function () {
      activeMenu(28);
      updatePage(28);
      $('.side_module').show();
      $('.side_module_pagination').show();
      $('.pagination').show();
      $('#btn_close').hide();
    });

  </script>
