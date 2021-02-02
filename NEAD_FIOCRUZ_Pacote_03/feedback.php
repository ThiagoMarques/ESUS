<?php require_once 'includes/head.php'; ?>

<body>
  <?php require_once 'includes/nav.php'; ?>

  <div class="container">
    <div class="row mt-5">
      <div class="col-lg-12 text-left">
        <h2 class="tituloPrincipal">Curso de Capacitação para Utilização do Sistema Nacional de Gestão da Assistência
          Farmacêutica (e-SUS AF)</h2>
      </div>
    </div>

    <div class="row align-items-center">
      <div class="col-lg-8 col-sm-8">
        <p id="msg-feedback">Olá aluno(a),<br>Você ainda não iniciou as atividades. Clique em <a href="c1.php" class="modulo-feedback">"Acesso ao Sistema"</a> para começar!</p>
      </div>
      <div class="col-lg-4 col-sm-4">
        <p class="text-right" id="msg-feedback"><b>Nota geral: <span id="nota-geral"></span></b></p>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-sm-12 div-table text-center">
        <table id="table-apresentacao" class="table table-feedback" style="width:100%">
          <tr>
            <th class="table-titulo" colspan="4">Apresentação do Sistema</th>
          </tr>
          <tr>
            <th></th>
            <th>Concluído</th>
            <th>Exercícios</th>
            <th>Avaliação</th>
          </tr>
          <tr id="tr-acesso-sistema">
            <td><a href="c1.php">Acesso ao sistema</a></td>
            <td class="concluido"><i class="fas fa-times"></i></td>
            <td><span class="nota-exercicio">Não respondido</span></td>
            <td rowspan="2" aling="center"><span class="nota-avaliacao">Não respondido</span></td>
          </tr>
          <tr id="tr-solicitacao-perfil">
            <td><a href="c3.php">Solicitação de perfil</a></td>
            <td aling="center" class="concluido"><i class="fas fa-times"></i></td>
            <td class="nota-exercicio">Não respondido</td>
          </tr>

          <tr>
            <th class="table-titulo" colspan="4">Módulo Administrativo</th>
          </tr>
          <tr>
            <th></th>
            <th>Concluído</th>

            <th>Exercícios</th>
            <th>Avaliação</th>
          </tr>
          <tr id="tr-cadastro-estabelecimento">
            <td><a href="c6.php">Cadastro de estabelecimento</a></td>
            <td class="concluido"><i class="fas fa-times"></i></td>
            <td><span class="nota-exercicio">Não respondido</span></td>
            <td rowspan="5" aling="center"><span class="nota-avaliacao">Não respondido</span></td>
          </tr>
          <tr id="tr-configuracoes-origem">
            <td><a href="c8.php">Configurações (subgrupo de origem)</a></td>
            <td aling="center" class="concluido"><i class="fas fa-times"></i></td>
            <td class="nota-exercicio">Não respondido</td>
          </tr>
          <tr id="tr-consulta-produto">
            <td><a href="c10.php">Consulta de produto</a></td>
            <td aling="center" class="concluido"><i class="fas fa-times"></i></td>
            <td class="nota-exercicio">Não respondido</td>
          </tr>
          <tr id="tr-cadastro-empenho">
            <td><a href="c12.php">Cadastro de empenho</a></td>
            <td aling="center" class="concluido"><i class="fas fa-times"></i></td>
            <td class="nota-exercicio">Não respondido</td>
          </tr>
          <tr id="tr-selecionar-estabelecimento">
            <td><a href="c14.php">Selecionar estabelecimento</a></td>
            <td aling="center" class="concluido"><i class="fas fa-times"></i></td>
            <td class="nota-exercicio">Não respondido</td>
          </tr>

          <tr>
            <th class="table-titulo" colspan="4">Módulo Atendimento</th>
          </tr>
          <tr>
            <th></th>
            <th>Concluído</th>
            <th>Exercícios</th>
            <th>Avaliação</th>
          </tr>
          <tr id="tr-cadastro-usuario">
            <td><a href="c17.php">Cadastro de usuário</a></td>
            <td class="concluido"><i class="fas fa-times"></i></td>
            <td><span class="nota-exercicio">Não respondido</span></td>
            <td rowspan="2" aling="center"><span class="nota-avaliacao">Não respondido</span></td>
          </tr>
          <tr id="tr-dispensacao">
            <td><a href="c19.php">Dispensação</a></td>
            <td aling="center" class="concluido"><i class="fas fa-times"></i></td>
            <td class="nota-exercicio">Não respondido</td>
          </tr>
          
          <tr>
            <th class="table-titulo" colspan="4">Módulo Movimentação e Logística</th>
          </tr>
          <tr>
            <th></th>
            <th>Concluído</th>
            <th>Exercícios</th>
            <th>Avaliação</th>
          </tr>
          <tr id="tr-entrada">
            <td><a href="c22.php">Entrada</a></td>
            <td class="concluido"><i class="fas fa-times"></i></td>
            <td><span class="nota-exercicio">Não respondido</span></td>
            <td rowspan="4" aling="center"><span class="nota-avaliacao">Não respondido</span></td>
          </tr>
          <tr id="tr-bloqueio-lote">
            <td><a href="c24.php">Bloqueio de lote</a></td>
            <td aling="center" class="concluido"><i class="fas fa-times"></i></td>
            <td class="nota-exercicio">Não respondido</td>
          </tr>
          <tr id="tr-requisicao">
            <td><a href="c26.php">Requisição</a></td>
            <td aling="center" class="concluido"><i class="fas fa-times"></i></td>
            <td class="nota-exercicio">Não respondido</td>
          </tr>
          <tr id="tr-saidas-diversas">
            <td><a href="c28.php">Saída diversas</a></td>
            <td aling="center" class="concluido"><i class="fas fa-times"></i></td>
            <td class="nota-exercicio">Não respondido</td>
          </tr>
        </table>
      </div>
    </div>
</div>



<?php require_once 'includes/footer.php'; ?>
</body>

</html>

<script>
    let number_module = document.getElementById("module_now"); 
    let text_module = document.getElementById("module_text"); 
    number_module.innerHTML = 'Meu Desempenho /';
    text_module.innerHTML = 'ESUS AF';
</script>

