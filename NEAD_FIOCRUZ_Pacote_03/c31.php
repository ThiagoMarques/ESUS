<?php require_once 'includes/head.php'; ?>

<body>
  <?php require_once 'includes/nav.php'; ?>
  <html>

  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 text-left">
          <div class="video text-center" style="width: 70%">
            <span class="video_title">Conclusão</span>
            <video id="custom_video_play" controls="controls">
            <source src="https://efg.brasilia.fiocruz.br/ava/external/ESUS_Recursos/videos/conclusao.mp4" type="video/mp4">
              Your browser does not support HTML5 video.
            </video>
          </div>
        </div>
      </div>
    </div>
    <div class="stepBack" onclick="stepNavigationNew('c30');"><i class="fas fa-chevron-left"></i></div>
    <?php require_once 'includes/footer.php'; ?>
  </body>


  </html>
  <script>
    $(document).ready(function () {
    activeMenu(31);
    updatePage(31);
  });
</script>