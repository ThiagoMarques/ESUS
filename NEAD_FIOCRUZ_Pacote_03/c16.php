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
            <div class="stepBack" onclick="stepNavigationNew('c15');"><i class="fas fa-chevron-left"></i></div>
            <div class="stepFoward" onclick="stepNavigationNew('c17');"><i class="fas fa-chevron-right"></i></div>
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
            question: 'Os estabelecimentos de saúde são necessários para a execução de vários processos dentro do Sistema. Sobre o cadastro de estabelecimento de saúde, assinale a alternativa INCORRETA:',
            choice1: 'Todos os estabelecimentos de saúde do município/estado já estão cadastrados automaticamente no e-SUS AF.',
            choice2: 'Todos os estabelecimentos que utilizam o e-SUS AF devem ser cadastrados. Esse cadastro é essencial para que as movimentações e o vínculo do usuário do Sistema (operador do e-SUS AF) ao seu local de trabalho seja possível.',
            choice3: 'Não será permitido cadastro de mais de um estabelecimento de saúde com o mesmo número de CNES ou CNPJ.',
            choice4: 'O cadastro de estabelecimento no e-SUS AF deve ser realizado através da indicação do CNES ou CNPJ do estabelecimento.',
            answer: 1,
            feedback1: 'Para cadastro de estabelecimento no e-SUS AF é necessário que o gestor local realize o cadastro através da funcionalidade “Cadastro de estabelecimento”, este cadastro deve ser realizado com a indicação do CNES ou CNPJ. Desta maneira, o registro dos estabelecimentos no Sistema não ocorre de forma automática.',
            feedback2: 'Todo estabelecimento no e-SUS AF deve ser previamente cadastrado.',
            feedback3: 'Um número de CNES ou CNPJ somente poderá ser utilizado por um estabelecimento de saúde no e-SUS AF.',
            feedback4: 'CNES ou CNPJ é a informação essencial para o cadastro de qualquer estabelecimento de saúde no e-SUS AF.',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Toda entrada deve estar obrigatoriamente vinculada a um empenho cadastrado no sistema.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 2,
            feedback1: 'Entradas não precisam estar vinculadas a empenhos para serem realizadas.',
            feedback2: 'Muito bem!',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Um registro de empenho com produtos já armazenados em estoque poderá ser excluído do e-SUS AF",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 1,
            feedback1: 'Empenhos já utilizados em registros de entrada não podem ser excluídos do Sistema. Empenhos nessa situação podem ser finalizados, mas jamais excluídos.',
            feedback2: 'Muito bem!',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Um registro de empenho pode conter mais de um produto.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 1,
            feedback1: 'Sim. Registros de empenho podem conter um ou mais produtos vinculados.',
            feedback2: 'Item incorreto.',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Os subgrupos de origem de receita são utilizados na funcionalidade “Cadastro de Usuário”.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 2,
            feedback1: 'Os subgrupos de origem de receita são utilizados na funcionalidade “Dispensação”. Eles trazem a informação do estabelecimento de saúde que emitiu a prescrição médica.',
            feedback2: 'Muito bem!',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Um subgrupo de origem de receita se refere a um estabelecimento no e-SUS AF, sendo cadastrado utilizando seu número de CNES (Cadastro Nacional de Estabelecimentos de Saúde) ou CNPJ.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 1,
            feedback1: 'Exatamente. O subgrupo de origem de receita indica o estabelecimento de origem de uma prescrição médica, sendo cadastrado no Sistema utilizando seu número de CNES ou CNPJ.',
            feedback2: 'Item incorreto.',
          },
          {
            type: 'ME',
            enunciate: 'Marque uma das opções abaixo:',
            question: 'O cadastro de medicamentos e produtos para a saúde no e-SUS AF pode ser realizado por qual perfil abaixo?',
            choice1: 'Farmacêutico;',
            choice2: 'Gestor Estadual;',
            choice3: 'Atendente;',
            choice4: 'Nenhuma das anteriores.',
            answer: 4,
            feedback1: 'O perfil do tipo “Farmacêutico” não possui o privilégio de cadastrar produtos no e-SUS AF.',
            feedback2: 'O perfil do tipo “Gestor municipal” não possui o privilégio de cadastrar produtos no e-SUS AF.',
            feedback3: 'O perfil do tipo “Atendente” não possui o privilégio de cadastrar produtos no e-SUS AF.',
            feedback4: 'Somente usuários do tipo “Gestor Master” podem realizar cadastros de produtos no e-SUS AF. Assim, esta é a opção correta.',
          },
          {
            type: 'ME',
            enunciate: 'Marque uma das opções abaixo:',
            question: 'Sobre a funcionalidade “Selecionar Estabelecimento”, marque a opção CORRETA:',
            choice1: 'A funcionalidade está disponível para todos os perfis do e-SUS AF;',
            choice2: 'É possível se vincular a um estabelecimento de saúde de estado diferente do seu perfil de acesso no e-SUS AF, independentemente do tipo de perfil;',
            choice3: 'O estabelecimento de saúde pode ser buscado pelo seu nome, número de CNES ou CNPJ;',
            choice4: 'Nenhuma das anteriores.',
            answer: 3,
            feedback1: 'A funcionalidade está disponível somente para perfis do tipo “Gestor”.',
            feedback2: 'Com perfil do tipo “Gestor” é possível se vincular somente a estabelecimentos de saúde da mesma esfera de gestão.',
            feedback3: 'Exatamente como apresentado na funcionalidade.',
            feedback4: 'O item C está correto.',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Dois estabelecimentos de saúde distintos podem compartilhar o mesmo número de CNES ou CNPJ no e-SUS AF.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 2,
            feedback1: 'Um número de CNES ou CNPJ somente poderá ser utilizado por um estabelecimento de saúde no e-SUS AF',
            feedback2: 'Muito bem!',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Para concluir o cadastro de um estabelecimento de saúde no e-SUS AF, é necessário ter ao menos um departamento vinculado.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 1,
            feedback1: 'O cadastro de departamento é opcional no e-SUS AF.',
            feedback2: 'Muito bem!',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "É possível cadastrar um estabelecimento de saúde no e-SUS AF sem número de CNES.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 1,
            feedback1: 'Sim. Estabelecimentos de saúde sem CNES podem ser cadastrados utilizando o número de CNPJ',
            feedback2: 'Item incorreto.',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Entre os cadastros de farmacêutico para um estabelecimento de saúde, ao menos um deles deve ser do tipo farmacêutico responsável.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 2,
            feedback1: 'Assim como o cadastro de farmacêutico é opcional para o cadastro de um estabelecimento de saúde no e-SUS AF, não há necessidade de que um deles seja do tipo farmacêutico responsável',
            feedback2: 'Muito bem!',
          }
        ]

    const SCORE_POINTS = 1
    const MAX_QUESTIONS = 5
    const moduleExercise = 'A1'
    const currentExercise = 'c16.php'
    const nextWindow = 'c17.php'


    startQuestions = () => {
        questionCounter = 0
        score = 0
        availableQuestions = [...questions]
        clearScore()
        startAttempt()
        getNewQuestion()
        if (checkAttempt("AT1") === 1) {
          
          clearPPU()
        }
        if (checkAttempt("AT1") === 2) {
          
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

        betterScore = status.A1V['score']

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

        if (checkAttempt("AT1") === 0 && score <= 2) {
          feed_text = '<span class="bad">Você não possui mais tentativas.</span>'
        }

        status.A1V['score'] = betterScore

        lti = status.LTIvalue
        lti += betterScore / 20
        status.LTIvalue = lti

        unasus.pack.setStatus(status);

        $("#feedbackTexto").html(feed_text);
        $("#feedbackResultado").html(texto);
        $("#notaAvaliacao").html((score / 5) * 100 + '%');
        $("#maiorNota").html((betterScore / 5) * 100 + '%');

        if (checkAttempt("AT1") === 0) {
          $("#btn-refazer").hide();
        }
        updatePage(16);
    }

    function clearScore() {
        let status = unasus.pack.getStatus()
        status.A1 = {
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
      if (maxAttempt("AT1") === 0) {
        $("#btn-start").prop("disabled",true)
        $("#btn-refazer").hide()
        let tentativas = checkAttempt("AT1")
        $("#tentativasRestantes").html(tentativas)
        let limite = '<span class="bad">Você excedeu o número de tentivas!</span>'
        $("#limiteExcedido").html(limite);
        show('resultado')
      }
    }

    function clearPPU(){
      let status = unasus.pack.getStatus()
      betterScore = status.A1V['score']
      status.A1 = {'1': false, '2': false, '3': false, '4': false, '5': false};
      lti = status.LTIvalue
      lti -= betterScore / 20
      status.LTIvalue = lti
      unasus.pack.setStatus(status);
    }

    function changeWindow(){
      window.location = nextWindow;
    }


    $(document).ready(function() {
      activeMenu(16)
      show('informativo')
      let tentativas = checkAttempt("AT1")
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