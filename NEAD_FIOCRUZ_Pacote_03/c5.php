<?php require_once 'includes/head.php'; ?>

<body>
    <?php require_once 'includes/nav.php'; ?>
    <html>
    <!-- Avaliação Apresentação do Sistema -->
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
            <div class="stepBack" onclick="stepNavigationNew('c4');"><i class="fas fa-chevron-left"></i></div>
            <div class="stepFoward" onclick="stepNavigationNew('c6');"><i class="fas fa-chevron-right"></i></div>
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
            question: 'Para solicitar a senha de acesso ao e-SUS AF (Sistema Nacional de Gestão da Assistência Farmacêutica), clicando em “Novo por aqui?”, o usuário será direcionado para realização de cadastro em qual plataforma de acesso?',
            choice1: 'Site do Departamento de Informática do SUS (DATASUS).',
            choice2: 'Plataforma de acesso do e-SUS Atenção Básica (e-SUS AB).',
            choice3: 'Sistema de informação em Saúde (SIS).',
            choice4: 'Sistema de Cadastro e Permissão de Acesso (SCPA).',
            answer: 4,
            feedback1: 'Não é possível solicitar acesso ao e-SUS AF no site do DATASUS.',
            feedback2: 'A opção indicada é utilizada para acesso ao Sistema e-SUS Atenção Básica e não para solicitação de acesso ao e-SUS AF.',
            feedback3: 'Não é possível solicitar acesso ao e-SUS AF via SIS.',
            feedback4: 'A fim de realizar cadastro no e-SUS AF, ao clicar em “Novo por aqui?”, o usuário será direcionado para o site do SCPA (Sistema de Cadastro e Permissão de Acesso), uma plataforma de acesso a diversos sistemas do Ministério da Saúde.',
          },
          {
            type: 'ME',
            enunciate: 'Marque uma das opções abaixo:',
            question: 'Após a realização de cadastro no SCPA (Sistema de Cadastro e Permissão de Acesso), deve-se clicar no menu “Solicitar acesso aos sistemas” e escolher o sistema no qual deseja vincular seu acesso. Para solicitação de acesso ao Sistema Nacional de Gestão da Assistência Farmacêutica (e-SUS AF), a opção a ser selecionada deverá ser:',
            choice1: 'BNAFAR - Base Nacional de Dados da Assistência Farmacêutica;',
            choice2: 'ESUSAF - Sistema Nacional de Gestão de Assistência Farmacêutica;',
            choice3: 'HORUSWSB - HÓRUS WEBSERVICE – BÁSICO;',
            choice4: 'ESUSAB – Sistema e-SUS da Atenção Básica.',
            answer: 2,
            feedback1: 'A BNAFAR não é um sistema de informações, mas uma base de dados do Ministério da Saúde.',
            feedback2: 'Para vincular seu acesso ao e-SUS AF, o sistema selecionado no SCPA, após a inclusão das informações de cadastro, deve ser o ESUSAF – Sistema Nacional de Gestão da Assistência Farmacêutica.',
            feedback3: 'O Sistema Hórus se trata de um outro sistema de informação.',
            feedback4: 'Embora o nome seja semelhante, a opção se refere a um sistema de informações da Atenção Básica e não da Assistência Farmacêutica.',
          },
          {
            type: 'ME',
            enunciate: 'Marque uma das opções abaixo:',
            question: 'Após a realização de cadastro no SCPA (Sistema de Cadastro e Permissão de Acesso) e finalização das etapas de escolha do estado, município, perfil desejado e estabelecimento de saúde, o acesso ao e-SUS AF estará em qual fase:',
            choice1: 'Aguardando que a solicitação de acesso seja autorizada pelo gestor de sua esfera.',
            choice2: 'O usuário já terá permissão para acessar o e-SUS AF conforme perfil e estabelecimento indicados no cadastro.',
            choice3: 'Aguardando autenticação via e-mail.',
            choice4: 'Aguardando confirmação via SMS.',
            answer: 1,
            feedback1: 'Após a realização de cadastro no SCPA, para ter acesso ao e-SUS AF, é necessário que o gestor local autorize o acesso do usuário. Portanto, após o cadastro, o usuário ainda não terá permissão para acessar o e-SUS AF.',
            feedback2: 'O usuário só terá permissão para acessar o e-SUS AF após autorização do gestor de sua esfera de atuação.',
            feedback3: 'O usuário receberá um e-mail somente após a criação de acesso no SCPA (Sistema de Cadastro e Permissão de Acesso).',
            feedback4: 'O usuário nunca receberá um SMS em qualquer etapa de solicitação de perfil para o e-SUS AF.',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "A inserção de uma justificativa é etapa obrigatória para solicitação de um perfil de acesso no e-SUS AF (Sistema Nacional de Gestão da Assistência Farmacêutica).",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 1,
            feedback1: 'Sim. Não é possível seguir para as próximas etapas de solicitação de perfil no e-SUS AF sem inserir uma justificativa.',
            feedback2: 'Item incorreto.',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "“Almoxarifado” é um tipo de perfil no e-SUS AF.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 2,
            feedback1: 'Não existe o perfil do tipo “Almoxarifado” no e-SUS AF.',
            feedback2: 'Muito bem!',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Após o cadastro no SCPA (Sistema de Cadastro e Permissão de Acesso), o usuário já está apto a utilizar o e-SUS AF.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 2,
            feedback1: 'Após o cadastro no SCPA, o usuário ainda precisa solicitar acesso ao e-SUS AF, escolher o perfil de acesso no Sistema e ter o perfil autorizado pelo gestor local.',
            feedback2: 'Muito bem!',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "O cadastro no SCPA (Sistema de Cadastro e Permissão de Acesso) não é necessário para ter acesso ao e-SUS AF.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 2,
            feedback1: 'Somente usuários cadastrados no SCPA podem ter acesso ao e-SUS AF.',
            feedback2: 'Muito bem!',
          },
          {
            type: 'ME',
            enunciate: 'Marque uma das opções abaixo:',
            question: 'O e-SUS AF (Sistema Nacional de Gestão da Assistência Farmacêutica) é um sistema de informação criado e mantido pelo:',
            choice1: 'Ministério da Economia.',
            choice2: 'Agência Nacional de Vigilância Sanitária (ANVISA).',
            choice3: 'Ministério da Saúde.',
            choice4: 'Presidência da República.',
            answer: 3,
            feedback1: 'O Ministério da Economia não possui qualquer relação com o e-SUS AF.',
            feedback2: 'Apesar de estar vinculada ao Ministério da Saúde, o e-SUS AF não é um sistema da ANVISA.',
            feedback3: 'O e-SUS AF foi criado e é mantido pelo Ministério da Saúde.',
            feedback4: 'A Presidência da República não possui relação com o e-SUS AF.',
          },
          {
            type: 'ME',
            enunciate: 'Marque uma das opções abaixo:',
            question: 'Marque a opção abaixo que não contenha informação obrigatória para realização de cadastro no SCPA:',
            choice1: 'Endereço de e-mail.',
            choice2: 'CPF (número de Cadastro de Pessoa Física).',
            choice3: 'Senha de acesso.',
            choice4: 'Raça/cor.',
            answer: 4,
            feedback1: 'O e-mail é uma informação obrigatória para cadastro no SCPA.',
            feedback2: 'O CPF é uma informação obrigatória para cadastro no SCPA.',
            feedback3: 'A senha de acesso é uma informação obrigatória para cadastro no SCPA.',
            feedback4: 'Apesar de ser um item do formulário de cadastro no SCPA, não é uma informação obrigatória para solicitação de acesso.',
          }
        ]

    const SCORE_POINTS = 1
    const MAX_QUESTIONS = 5
    const moduleExercise = 'A0'
    const currentExercise = 'c5.php'
    const nextWindow = 'c6.php'


    startQuestions = () => {
        questionCounter = 0
        score = 0
        availableQuestions = [...questions]
        clearScore()
        startAttempt()
        getNewQuestion()
        if (checkAttempt("AT0") === 1) {
          
          clearPPU()
        }
        if (checkAttempt("AT0") === 2) {
          
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

        betterScore = status.A0V['score']

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

        if (checkAttempt("AT0") === 0 && score <= 2) {
          feed_text = '<span class="bad">Você não possui mais tentativas.</span>'
        }

        status.A0V['score'] = betterScore

        lti = status.LTIvalue
        lti += betterScore / 20
        status.LTIvalue = lti

        unasus.pack.setStatus(status);

        $("#feedbackTexto").html(feed_text);
        $("#feedbackResultado").html(texto);
        $("#notaAvaliacao").html((score / 5) * 100 + '%');
        $("#maiorNota").html((betterScore / 5) * 100 + '%');

        if (checkAttempt("AT0") === 0) {
          $("#btn-refazer").hide();
        }

        updatePage(5);
    }

    function clearScore() {
        let status = unasus.pack.getStatus()
        status.A0 = {
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
      if (maxAttempt("AT0") === 0) {
        $("#btn-start").prop("disabled",true)
        $("#btn-refazer").hide()
        let tentativas = checkAttempt("AT0")
        $("#tentativasRestantes").html(tentativas)
        let limite = '<span class="bad">Você excedeu o número de tentivas!</span>'
        $("#limiteExcedido").html(limite);
        show('resultado')
      }
    }

    function clearPPU(){
      let status = unasus.pack.getStatus()
      betterScore = status.A0V['score']
      status.A0 = {'1': false, '2': false, '3': false, '4': false, '5': false};
      lti = status.LTIvalue
      lti -= betterScore / 20
      status.LTIvalue = lti
      unasus.pack.setStatus(status);
    }

    function changeWindow(){
      window.location = nextWindow;
    }


    $(document).ready(function() {
      activeMenu(5)
      show('informativo')
      let tentativas = checkAttempt("AT0")
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