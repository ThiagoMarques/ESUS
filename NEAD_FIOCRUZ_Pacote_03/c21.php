<?php require_once 'includes/head.php'; ?>

<body>
    <?php require_once 'includes/nav.php'; ?>
    <html>
    <!-- Avaliação Módulo Administrativo -->
    <div class="container">
        <!-- Informações Iniciais -->
        <div id="informativo" class="row">
            <div class="col-lg-12">
                <h3 class="informativo-bold">Vamos consolidar o que estudamos?</h3>
                <p>A seguir vamos fazer exercícios que são <span class="bold">avaliativos</span>, são cinco questões relacionadas aos conteúdos
                  estudados.</p>
                <p>Orientações para responder os exercícios:</p>
                <ul>
                  <li>Serão três tentativas, a maior nota será computada a nota final.</li>
                  <li class="tentativas-user">Tentativas restantes: <span id="tentativasUser" class=""></span></li>
                  <li>Ao clicar em iniciar, será contabilizado uma tentativa.</li>
                  <li>Clique na opção correta. Aparecerá o feedback dessa questão.</li>
                  <li>Clique em <span class="bold">Próxima Questão</span> para responder outra questão.</li>
                  <li>Após responder todas as questões será mostrada a quantidade de respostas corretas</li>
              </ul>
                <button id="btn-start" class="btn btn-lg btnStart" onclick="show('questoes')">Iniciar</button>
            </div>
        </div>
        <!-- Layout de questões -->
        <div id="questoes" class="row justify-content-between">
            <div class="col-lg-12">
                <h1 class="tituloExercicio">Exercícios </h1>
                <h3 id="progressText" class="tituloQuestao">Questão</h3>
                <div id="progressBar">
                    <div id="progressBarFull"></div>
                </div>
                <h1 id="enunciate">Enunciado</h1>
                <h1 id="question">Pergunta</h1>
                <div id="optA" class="choice-container">
                    <p class="choice-prefix">(a)</p>
                    <p class="choice-text" data-number="1">Pergunta 1</p>
                </div>
                <div id="optB" class="choice-container">
                    <p class="choice-prefix">(b)</p>
                    <p class="choice-text" data-number="2">Pergunta 2</p>
                </div>
                <div id="optC" class="choice-container">
                    <p class="choice-prefix">(c)</p>
                    <p class="choice-text" data-number="3">Pergunta 3</p>
                </div>
                <div id="optD" class="choice-container">
                    <p class="choice-prefix">(d)</p>
                    <p class="choice-text" data-number="4">Pergunta 4</p>
                </div>
                <input id="btnResposta" type="button" value="Próxima questão" onclick="nextQuestion()">
            </div>
        </div>
        <!-- Informações Finais -->
        <div id="resultado" class="row">
            <div class="col-lg-12 text-left align-self-center resultado">
                <h3 class="informativo-bold">Rendimento</h3>
                <p id="feedbackResultado"></p>
                <p id="feedbackTexto"></p>
                <p id="limiteExcedido"></p>
                <p class="nota">Você possui <span id="tentativasRestantes"></span> tentativa(s) restantes</p>
                <p class="nota">Sua nota nesta tentativa: <span id="notaAvaliacao">0</span> </p>
                <p class="nota">Sua maior nota: <span id="maiorNota">0</span> </p>
                <input id="btn-refazer" type="button" onclick="tryAgain()" value="Refazer avaliação.">
                <input type="button" onclick="changeWindow()" value="Próxima aula">
                <h1></h1>
            </div>
            <div class="stepBack" onclick="stepNavigationNew('c20');"><i class="fas fa-chevron-left"></i></div>
            <div class="stepFoward" onclick="stepNavigationNew('c22');"><i class="fas fa-chevron-right"></i></div>
        </div>
    </div>
    <!-- Modal (feedback para usuário) -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="tituloModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="texto-modal" class="modal-body">
                </div>
            </div>
        </div>
    </div>

<!-- JavaScript -->
<script>
    const enunciate = document.querySelector('#enunciate')
    const question = document.querySelector('#question')
    const choices = Array.from(document.querySelectorAll('.choice-text'))
    const progressText = document.querySelector('#progressText')
    const progressBarFull = document.querySelector('#progressBarFull')

    let currentQuestion = {}
    let acceptingAnswers = true
    let score = 0
    let betterScore = 0
    let questionCounter = 0
    let availableQuestions = []

    let questions = [
          {
            type: 'ME',
            enunciate: 'Marque uma das opções abaixo:',
            question: 'Para o cadastro de usuário SUS no e-SUS AF, as informações do paciente provêm do Sistema CADSUS a partir da indicação do número de CNS (Cartão Nacional de Saúde) ou CPF do usuário SUS. Entretanto, algumas informações complementares podem ser incluídas no cadastro do usuário SUS no e-SUS AF. Quais informações são essas?',
            choice1: 'Telefone, e-mail e endereço.',
            choice2: 'Responsável pelo paciente e nome.',
            choice3: 'Observações e responsável pelo paciente.',
            choice4: 'Endereço, responsável pelo paciente e observações.',
            answer: 3,
            feedback1: 'Nenhum dos itens podem ser editados na tela de cadastro de usuário no e-SUS AF.',
            feedback2: 'Nome é migrado diretamente do CADSUS e não pode ser alterado.',
            feedback3: 'As informações adicionais que podem ser registradas no e-SUS AF são as observações e os responsáveis pelo usuário SUS, todas as outras informações como nome, data de nascimento, endereço, telefone, entre outras, são migradas do CADSUS.',
            feedback4: 'Endereço é migrado diretamente do CADSUS e não pode ser alterado.',
          },
          {
            type: 'ME',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Ao realizar o cadastro de usuário SUS no e-SUS AF, por meio da importação dos dados do CADSUS, foi constatado que os dados de endereço do usuário estão desatualizados. Para realizar a atualização do cadastro devemos:",
            choice1: 'Entrar em contato com a equipe de suporte do Sistema e solicitar a alteração da informação de endereço diretamente no e-SUS AF.',
            choice2: 'Realizar a atualização no e-SUS AF, alterando os dados de endereço.',
            choice3: 'Incluir o endereço novo no campo de observação.',
            choice4: 'Direcionar o usuário ao setor de cadastro de usuário (confecção do cartão SUS), conforme protocolo de seu estabelecimento, para que seja realizada a atualização do endereço do paciente no Sistema CADSUS. ',
            answer: 4,
            feedback1: 'Como o cadastro é migrado do CADSUS, não há nada que a equipe de suporte do e-SUS AF possa fazer. Qualquer informação referente ao CNS deve ser alterada no registro do CADSUS.',
            feedback2: 'Os dados somente podem ser alterados no Sistema CADSUS.',
            feedback3: 'O campo “Observações” deve ser preenchido com informações adicionais sobre o usuário SUS, não contempladas no cadastro do CADSUS. A informação do campo “Endereço” continuaria incorreta no cadastro do usuário SUS.',
            feedback4: 'Exatamente. A correção da informação deverá ser realizada no Sistema CADSUS. O  usuário deverá ser direcionado ao local responsável pelo cadastro do cartão SUS, conforme o protocolo de seu estabelecimento de saúde, e realizar a atualização dos dados. Após a indicação do novo endereço no CADSUS, as informações no e-SUS AF serão atualizadas automaticamente.',
          },
          {
            type: 'ME',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "A funcionalidade de dispensação permite o registro da entrega de produtos a um usuário SUS. Para realização de dispensações, é necessário que algumas informações tenham sido previamente cadastradas no Sistema, sendo elas:",
            choice1: 'Endereçamento físico e programa de saúde.',
            choice2: 'Cadastro de entidade e cadastro de usuário SUS.',
            choice3: 'Subgrupo de origem de receita e enfermeiro.',
            choice4: 'Cadastro de usuário SUS e subgrupo de origem de receita.',
            answer: 4,
            feedback1: 'Endereçamento físico e programa de saúde não são pré-requisitos para realizar registros de dispensação no e-SUS AF.',
            feedback2: 'Não existe o cadastro de entidades no e-SUS AF.',
            feedback3: 'Não há a possibilidade de cadastro de enfermeiros no e-SUS AF.',
            feedback4: 'Para realização de dispensação através do e-SUS AF, é necessário que o usuário SUS tenha sido previamente cadastrado por meio da funcionalidade de “Cadastro de Usuário”. Outro cadastro que deve ser realizado previamente é o subgrupo de origem de receita, no menu “Configurações”. Esse deve ser realizado pelo gestor local com indicação do CNES ou CNPJ do estabelecimento prescritor.',
          },
          {
            type: 'ME',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Quanto às situações de dispensação no e-SUS AF, assinale a alternativa INCORRETA:",
            choice1: 'Dispensação agendada se refere à dispensação que possui atendimentos previstos em datas específicas a um usuário SUS.',
            choice2: 'Dispensações estornadas são atendimentos que foram realizados e posteriormente estornados por um operador do Sistema, sendo os produtos da dispensação retornados ao estoque do estabelecimento atendente.',
            choice3: 'Dispensações atendidas são dispensações que possuem agendamentos pendentes e podem ser utilizadas posteriormente para atendimento de qualquer usuário SUS.',
            choice4: 'Dispensações atendidas são registros de dispensações concluídas e sem qualquer agendamento pendente.',
            answer: 3,
            feedback1: 'Exatamente como ocorre o funcionamento do e-SUS AF para a funcionalidade “Dispensação”.',
            feedback2: 'Descrição correta de dispensação estornada.',
            feedback3: 'Dispensações atendidas são registros de dispensações concluídas, portanto sem qualquer agendamento pendente.',
            feedback4: 'Descrição correta de uma dispensação atendida.',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Um registro de dispensação no e-SUS AF pode ser realizado para um usuário SUS sem número de CNS (Cartão Nacional de Saúde).",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 2,
            feedback1: 'O número de CNS do usuário SUS é imprescindível para a realização de uma dispensação no e-SUS AF.',
            feedback2: 'Muito bem!',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Caso haja algum erro, uma dispensação com situação “Atendida” ou “Agendada” pode ser excluída ou apagada do e-SUS AF.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 2,
            feedback1: 'Dispensações que resultaram em qualquer retirada do estoque (situação atendida ou agendada) não podem ser excluídas do e-SUS AF. Em caso de erro, o registro incorreto poderá ser estornado, mas jamais excluído do Sistema.',
            feedback2: 'Muito bem!',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Um usuário SUS somente poderá ser cadastrado no e-SUS AF se possuir um número de CNS (Cartão Nacional de Saúde).",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 1,
            feedback1: 'Mesmo com a possibilidade de ser buscado pelo número de CPF, o registro no CNS do paciente é obrigatório para cadastro no e-SUS AF.',
            feedback2: 'Item incorreto.',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "As Observações do Paciente podem ser criadas e visualizadas tanto na funcionalidade de “Dispensação”, quanto na funcionalidade “Cadastro de Usuário”.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 1,
            feedback1: 'Exatamente. Temos as duas opções para as Observações do Paciente.',
            feedback2: 'Item incorreto.',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Uma dispensação com a situação “Agendada” pode ter qualquer dos seus campos alterados, incluindo prescritor e produto dispensado.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 2,
            feedback1: 'Uma dispensação com essa situação não permite qualquer alteração no cadastro. Somente há a possibilidade de atender ou estornar um agendamento ou incluir uma nova observação no registro.',
            feedback2: 'Muito bem!',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Após o atendimento de uma dispensação, o e-SUS AF não disponibiliza qualquer documento comprobatório do registro, algo que possa servir como recibo para o paciente atendido.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 2,
            feedback1: 'Após uma dispensação, o e-SUS AF apresenta a possibilidade de gerar arquivo em formato PDF (recibo) com todas as informações referentes ao registro realizado. O recibo possui campos para assinaturas tanto do atendente quanto do paciente.',
            feedback2: 'Muito bem!',
          },
          {
            type: 'ME',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Em relação à funcionalidade de dispensação, marque a opção CORRETA:",
            choice1: 'O mesmo registro de dispensação pode ser utilizado para atender mais de um usuário SUS;',
            choice2: 'Os produtos de uma dispensação retornam ao estoque do estabelecimento de saúde atendente após a realização de um estorno do registro;',
            choice3: 'Na tela “Incluir Dispensação”, o campo “CID-10” é de preenchimento obrigatório em qualquer registro de dispensação;',
            choice4: 'Uma dispensação com situação “Em Preenchimento” não permite qualquer alteração em seu registro.',
            answer: 2,
            feedback1: 'Cada registro de dispensação é exclusivo para somente um paciente no e-SUS AF.',
            feedback2: 'O estorno da dispensação retorna os produtos atendidos para o estoque do estabelecimento atendente.',
            feedback3: 'O campo “CID-10” somente se tornará de preenchimento obrigatório se a dispensação for do medicamento Talidomida ou seus derivados.',
            feedback4: 'ispensações com situação “Em preenchimento” podem ser alteradas e até mesmo excluídas do sistema.',
          },
          {
            type: 'ME',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Em relação à funcionalidade de dispensação, marque a opção INCORRETA:",
            choice1: 'Uma dispensação pode conter mais de um produto a ser dispensado;',
            choice2: 'A especificação de origem de receita não é obrigatória para a conclusão de um registro de dispensação;',
            choice3: 'Cada dispensação possui somente um prescritor associado;',
            choice4: 'Uma dispensação com situação “Atendida” pode ser estornada.',
            answer: 3,
            feedback1: 'Um registro de dispensação pode conter um ou mais produtos por registro.',
            feedback2: 'A definição de uma origem de receita é obrigatória para a conclusão de um registro de dispensação.',
            feedback3: 'Exatamente. Não é possível vincular mais de prescritor a um registro de dispensação.',
            feedback4: 'Sim. Os produtos de uma dispensação atendida podem ser retornados ao estoque do estabelecimento de saúde por meio do estorno do registro.',
          }
        ]

    const SCORE_POINTS = 1
    const MAX_QUESTIONS = 5
    const moduleExercise = 'A2'
    const currentExercise = 'c21.php'
    const nextWindow = 'c22.php'


    startQuestions = () => {
        questionCounter = 0
        score = 0
        availableQuestions = [...questions]
        clearScore()
        startAttempt()
        getNewQuestion()
        if (checkAttempt("AT2") === 1) {
          
          clearPPU()
        }
        if (checkAttempt("AT2") === 2) {
          
          clearPPU()
        } 
    }

    getNewQuestion = () => {
        if (availableQuestions.length === 0 || questionCounter >= MAX_QUESTIONS) {
            feedbackUser()
            show('resultado')

        } else {

            questionCounter++
            clearAtributes()

            progressText.innerText = `Questão ${questionCounter} de ${MAX_QUESTIONS}`
            progressBarFull.style.width = `${(questionCounter / MAX_QUESTIONS) * 100}%`

            const questionsIndex = Math.floor(Math.random() * availableQuestions.length)
            currentQuestion = availableQuestions[questionsIndex]

            if (currentQuestion.type === 'ME') {
                enunciate.innerText = currentQuestion.enunciate
                question.innerText = currentQuestion.question

                choices.forEach(choice => {
                    const number = choice.dataset['number']
                    choice.innerText = currentQuestion['choice' + number]
                })
            }
            if (currentQuestion.type === 'VF') {
                enunciate.innerText = currentQuestion.enunciate
                question.innerText = currentQuestion.question

                choices.forEach(choice => {
                    const number = choice.dataset['number']
                    choice.innerText = currentQuestion['choice' + number]

                    $("#optC").hide()
                    $("#optD").hide()
                })
            }
            availableQuestions.splice(questionsIndex, 1)
            acceptingAnswers = true
        }
    }

    nextQuestion = () => {
        getNewQuestion()
    }

    clearAtributes = () => {
        $("#optC").show()
        $("#optD").show()

        $("#btnResposta").prop("disabled", true)

        $('.modal-content').removeClass('correta')
        $('.modal-content').removeClass('incorreta')

        choices.forEach(choice => {
            choice.parentElement.classList.remove('correct')
            choice.parentElement.classList.remove('incorrect')
        })

        let all = $(".choiced-container").map(function() {
                this.classList.remove('choiced-container')
                this.classList.add('choice-container')
        })
    }

    clearQuestion = () => {
        acceptingAnswers = true
    }

    choices.forEach(choice => {
        choice.addEventListener('click', e => {
            if (!acceptingAnswers) return

            acceptingAnswers = false
            const selectedChoice = e.target
            const selectedAnswer = selectedChoice.dataset['number']
            let numQuestion = parseInt(selectedAnswer)

            switch (numQuestion) {
                case 1:
                    $('.modal-body').html(currentQuestion.feedback1)
                    break
                case 2:
                    $('.modal-body').html(currentQuestion.feedback2)
                    break
                case 3:
                    $('.modal-body').html(currentQuestion.feedback3)
                    break
                case 4:
                    $('.modal-body').html(currentQuestion.feedback4)
                    break
            }

            $("#btnResposta").prop("disabled", false)

            let classToApply = selectedAnswer == currentQuestion.answer ? 'correct' : 'incorrect'

            if (classToApply === 'correct') {
                incrementScore(SCORE_POINTS)
                $(".modal-content").addClass('correta')
                $('#tituloModal').html('Resposta correta')


                passAnswer(moduleExercise, questionCounter, 'Prototipo', true);

            } else {
                $(".modal-content").addClass('incorreta')
                $('#tituloModal').html('Resposta incorreta')
            }

            $("#feedbackModal").modal()

            selectedChoice.parentElement.classList.add(classToApply)

            let all = $(".choice-container").map(function() {
                this.classList.remove('choice-container')
                this.classList.add('choiced-container')
            })

            if (questionCounter > MAX_QUESTIONS - 1)
                $("#btnResposta").prop('value', 'Ver pontuação')
        })
    })

    incrementScore = num => {
        score += num
    }

    function show(elementID) {
        switch (elementID) {
            case 'informativo':
                $("#questoes").hide()
                $("#resultado").hide()
                break

            case 'questoes':
                $("#informativo").hide()
                $("#resultado").hide()
                startQuestions()
                break;

            case 'resultado':
                $("#informativo").hide()
                $("#questoes").hide()
                break;
        }

        let questao = document.getElementById(elementID)
        if (!questao) {
            return;
        }

        let pages = document.getElementsByClassName('questao')
        for (let i = 0; i < pages.length; i++) {
            pages[i].style.display = 'none';
        }
        questao.style.display = 'block';
    }

    function feedbackUser() {
        let status = unasus.pack.getStatus()
        let feed_text = ""
        let texto = ""  

        betterScore = status.A2V['score']

        if (score > betterScore){
          betterScore = score
        }
        
        if (score === 0) {
            feed_text = '<span class="bad">Estude um pouco mais o conteúdo do curso e refaça o avaliação quando se sentir preparado(a).</span>'
            texto = "De um total de " + MAX_QUESTIONS + " questões, você acertou " + score + " questões."
        }

        if (score === 1) {
            feed_text = '<span class="bad">Estude um pouco mais o conteúdo do curso e refaça o avaliação quando se sentir preparado(a).</span>'
            texto = "De um total de " + MAX_QUESTIONS + " questões, você acertou " + score + " questão."
        }

        if (score === 2) {
            feed_text = '<span class="bad">Estude um pouco mais o conteúdo do curso e refaça o avaliação quando se sentir preparado(a).</span>'
            texto = "De um total de " + MAX_QUESTIONS + " questões, você acertou " + score + " questão."
        }
        if (score >= 3) {
            feed_text = '<span class="great">Parabéns!</span> <br>'
            texto = "De um total de " + MAX_QUESTIONS + " questões, você acertou " + score + " questões."
        }

        if (checkAttempt("AT2") === 0 && score <= 2) {
          feed_text = '<span class="bad">Você não possui mais tentativas.</span>'
        }

        status.A2V['score'] = betterScore

        lti = status.LTIvalue
        lti += betterScore / 20
        status.LTIvalue = lti

        unasus.pack.setStatus(status);

        $("#feedbackTexto").html(feed_text);
        $("#feedbackResultado").html(texto);
        $("#notaAvaliacao").html((score / 5) * 100 + '%');
        $("#maiorNota").html((betterScore / 5) * 100 + '%');

        if (checkAttempt("AT2") === 0) {
          $("#btn-refazer").hide();
        }

        updatePage(21);
    }

    function clearScore() {
        let status = unasus.pack.getStatus()
        status.A2 = {
            '1': false,
            '2': false,
            '3': false,
            '4': false,
            '5': false
        };
        unasus.pack.setStatus(status);
    }

    function tryAgain() {
        clearScore()
        window.location = currentExercise;
    }

    function startAttempt(){
      if (maxAttempt("AT2") === 0) {
        $("#btn-start").prop("disabled",true)
        $("#btn-refazer").hide()
        let tentativas = checkAttempt("AT2")
        $("#tentativasRestantes").html(tentativas)
        let limite = '<span class="bad">Você excedeu o número de tentivas!</span>'
        $("#limiteExcedido").html(limite);
        show('resultado')
      }
    }

    function clearPPU(){
      let status = unasus.pack.getStatus()
      betterScore = status.A2V['score']
      status.A2 = {'1': false, '2': false, '3': false, '4': false, '5': false};
      lti = status.LTIvalue
      lti -= betterScore / 20
      status.LTIvalue = lti
      unasus.pack.setStatus(status);
    }

    function changeWindow(){
      window.location = nextWindow;
    }


    $(document).ready(function() {
      activeMenu(21)
      show('informativo')
      let tentativas = checkAttempt("AT2")
      $("#tentativasUser").html(tentativas)
      $("#tentativasRestantes").html(tentativas -1)
      console.log('Tentativas', tentativas)
      if(tentativas === 0){
        $("#btn-start").prop("disabled",true);
        $("#btn-refazer").hide();
      }

    });
</script>
    <?php require_once 'includes/footer.php'; ?>
</body>

</html>