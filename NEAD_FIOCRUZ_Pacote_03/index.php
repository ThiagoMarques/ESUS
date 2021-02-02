<?php require_once 'includes/head.php'; ?>

<body>
  <?php require_once 'includes/nav.php'; ?>

      <div class="container " style="margin-bottom: 100px;">
      <div class="row mt-5">
        <div class="col-lg-12 text-left">
          <h1>Curso de Capacitação para Utilização do Sistema Nacional de Gestão da Assistência Farmacêutica (e-SUS AF)
          </h1>
          <h5 class="pt-2"><strong>Objetivo geral:</strong> Capacitar usuários para utilização do Sistema e-SUS-AF
            (Sistema Nacional de
            Gestão da Assistência Farmacêutica)</h5>
          <h6 class="pt-1">Está disponível o Ambiente de Treinamento do e-SUS AF! Utilize-o para seu aprendizado,
            testando as
            funcionalidades apresentadas neste curso. Acesse-o em <a
              href="https://esusaf.trn.saude.gov.br">https://esusaf.trn.saude.gov.br</a></h6>
          <br>
        </div>
      </div>
      <div class="row ">
        <div class="col-lg-12 text-left">
          <div class="video text-center" style="width: 70%">
            <video id="video_1" controls="">
              <source src="https://efg.brasilia.fiocruz.br/ava/external/ESUS_Recursos/videos/boas_vindas.mp4" type="video/mp4">
              Your browser does not support HTML5 video.
            </video>
          </div>
        </div>

        <div class="col-lg-12 text-left pagina-principal mt-5">
          <h5>Apresentação do Sistema</h5>
          <ul class="funcionalidade-index">
            <li><i class="far fa-arrow-alt-circle-right"></i><button class="btn_funcionalidades" type="button"><a
                  href="c1.php">Acesso ao sistema</a></button></li>
            <li><i class="far fa-arrow-alt-circle-right"></i><button class="btn_funcionalidades" type="button"><a
                  href="c3.php">Solicitação de perfil</a></button></li>
          </ul>

          <h5>Módulo Administrativo</h5>
          <p>O objetivo deste módulo é capacitar o usuário a consultar e cadastrar estabelecimentos de saúde no e-SUS
            AF, bem como entender a importância dessa funcionalidade nos fluxos de movimentação e dispensação. Além
            disso, ele abordará outras funcionalidades envolvidas na dinâmica de movimentação de estoques ao orientar o
            usuário a como realizar um cadastro de empenho e sua importância para a transparência da gestão de recursos
            financeiros. Este módulo se propõe também a capacitar o operador sobre a consulta de produtos (medicamentos
            e produtos para saúde) cadastrados no Sistema e como proceder com o cadastro de subgrupos de origem de
            receita (cadastros indicadores da proveniência de receitas médicas para o e-SUS AF).</p>
          <ul class="funcionalidade-index">
            <li><i class="far fa-arrow-alt-circle-right"></i><button class="btn_funcionalidades" type="button"><a
                  href="c1.php">Cadastro de estabelecimento</a></button></li>
            <li><i class="far fa-arrow-alt-circle-right"></i><button class="btn_funcionalidades" type="button"><a
                  href="c3.php">Configurações (subgrupo de origem)</a></button></li>
            <li><i class="far fa-arrow-alt-circle-right"></i><button class="btn_funcionalidades" type="button"><a
                  href="c3.php">Consulta de produto</a></button></li>
            <li><i class="far fa-arrow-alt-circle-right"></i><button class="btn_funcionalidades" type="button"><a
                  href="c3.php">Cadastro de empenho</a></button></li>
            <li><i class="far fa-arrow-alt-circle-right"></i><button class="btn_funcionalidades" type="button"><a
                  href="c3.php">Selecionar estabelecimento</a></button></li>
          </ul>

          <h5>Módulo Atendimento</h5>
          <p>O Módulo de Atendimento do e-SUS AF compreende funcionalidades que envolvem o cadastro de Usuários SUS e a
            realização de dispensações. Este módulo tem como objetivo orientar a consulta, cadastro e edição de dados de
            Usuários SUS no Sistema e a realização de agendamentos de atendimento e registros de dispensação, ou seja, a
            retirada de medicamentos ou produtos para saúde do estoque virtual do e-SUS AF para um Usuário SUS.</p>
          <ul class="funcionalidade-index">
            <li><i class="far fa-arrow-alt-circle-right"></i><button class="btn_funcionalidades" type="button"><a
                  href="c1.php">Cadastro de usuário</a></button></li>
            <li><i class="far fa-arrow-alt-circle-right"></i><button class="btn_funcionalidades" type="button"><a
                  href="c3.php">Dispensação</a></button></li>
          </ul>

          <h5>Módulo Movimentação e Logística</h5>
          <p>O módulo Movimentação e Logística contempla as funcionalidades do e-SUS AF responsáveis pelo deslocamento
            de produtos entre estabelecimentos, bloqueio de lotes e retiradas excepcionais de estoque (saídas diversas).
          </p>
          <ul class="funcionalidade-index">
            <li><i class="far fa-arrow-alt-circle-right"></i><button class="btn_funcionalidades" type="button"><a
                  href="c1.php">Entrada</a></button></li>
            <li><i class="far fa-arrow-alt-circle-right"></i><button class="btn_funcionalidades" type="button"><a
                  href="c3.php">Bloqueio de Lote</a></button></li>
            <li><i class="far fa-arrow-alt-circle-right"></i><button class="btn_funcionalidades" type="button"><a
                  href="c3.php">Requisição</a></button></li>
            <li><i class="far fa-arrow-alt-circle-right"></i><button class="btn_funcionalidades" type="button"><a
                  href="c3.php">Saídas Diversas</a></button></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="stepFoward" onclick="stepNavigationNew('c1');"><i class="fas fa-chevron-right"></i></div>

  


  <?php require_once 'includes/footer.php'; ?>
</body>

</html>

<script>
    let number_module = document.getElementById("module_now"); 
    let text_module = document.getElementById("module_text"); 
    number_module.innerHTML = 'Introdução /';
    text_module.innerHTML = 'ESUS AF';
</script>
