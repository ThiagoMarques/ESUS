<?php require_once 'includes/head.php'; ?>

<body>
    <?php require_once 'includes/nav.php'; ?>
    <html>
    <!-- Exercício Requisição -->
    <div class="container">
        <!-- Informações Iniciais -->
        <div id="informativo" class="row">
            <div class="col-lg-12">
                <h3 class="informativo-bold">Vamos consolidar o que estudamos?</h3>
                <p>A seguir vamos fazer exercícios, são três questões relacionadas aos conteúdos
                    estudados.</p>
                <p>Orientações para responder os exercícios:</p>
                <ul>
                    <li>Clique na opção correta. Aparecerá o feedback dessa questão.</li>
                    <li>Clique em <span class="bold">Próxima Questão</span> para responder outra questão. Após responder
                        todas
                        as questões será mostrada a quantidade de respostas corretas.</li>
                    <li>Após responder todas as questões será mostrada a quantidade de respostas corretas</li>
                </ul>
                <button class="btn btn-lg btnStart" onclick="show('questoes')">Iniciar</button>
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
                <input type="button" onclick="tryAgain()" value="Refazer exercício.">
                <input type="button" onclick="changeWindow()" value="Próxima aula">
                <h1></h1>
            </div>
            <div class="stepBack" onclick="stepNavigationNew('c26');"><i class="fas fa-chevron-left"></i></div>
            <div class="stepFoward" onclick="stepNavigationNew('c28');"><i class="fas fa-chevron-right"></i></div>
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
    let questionCounter = 0
    let availableQuestions = []

    let questions = [
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "O e-SUS AF permite a realização de requisições para qualquer estabelecimento do País cadastrado no Sistema, sem a necessidade de autorizações.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 2,
            feedback1: 'Incorreto. Requisições para estabelecimentos atendentes de outra esfera de gestão são possíveis, mas exigem autorizações, tanto por parte do requisitante, quanto do atendente.',
            feedback2: 'Muito bem!',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Distribuições para departamentos não exigem solicitação.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 1,
            feedback1: 'Isso mesmo. Assim como em “Distribuição sem solicitação”, as distribuições para departamento são realizadas diretamente pelo estabelecimento atendente, sem a necessidade de solicitação do estabelecimento de destino.',
            feedback2: 'Item incorreto.',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Caso uma requisição seja enviada com algum erro, o estabelecimento solicitante pode requerer a devolução do pedido para a realização de correções.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 1,
            feedback1: 'Isso mesmo. Ao acionar o botão “Solicitar Devolução”, o pedido muda sua situação para “Devolução Solicitada”, podendo ser devolvido para a realização de correções.',
            feedback2: 'Muito bem!',
          }
        ]

    const SCORE_POINTS = 1
    const MAX_QUESTIONS = 3
    const moduleExercise = 'M3E3'
    const currentExercise = 'c27.php'
    const nextWindow = 'c28.php'


    startQuestions = () => {
        questionCounter = 0
        score = 0
        availableQuestions = [...questions]
        clearScore()
        getNewQuestion()
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

        for (let i = 1; i <= score; i++) {
            if (status.M3E3[i]) {}
        }

        unasus.pack.setStatus(status);

        if (score === 0) {
            feed_text = '<span class="bad">Estude um pouco mais o conteúdo do curso e refaça o exercício quando se sentir preparado(a).</span>'
            texto = "De um total de " + MAX_QUESTIONS + " questões, você acertou " + score + " questões."
        }

        if (score === 1) {
            feed_text = '<span class="bad">Estude um pouco mais o conteúdo do curso e refaça o exercício quando se sentir preparado(a).</span>'
            texto = "De um total de " + MAX_QUESTIONS + " questões, você acertou " + score + " questão."
        }

        if (score === 2) {
            feed_text = '<span class="great">Parabéns!</span> <br>'
            texto = "De um total de " + MAX_QUESTIONS + " questões, você acertou " + score + " questões."
        }
        if (score === 3) {
            feed_text = '<span class="great">Parabéns!</span> <br>'
            texto = "De um total de " + MAX_QUESTIONS + " questões, você acertou " + score + " questões."
        }
        $("#feedbackTexto").html(feed_text);
        $("#feedbackResultado").html(texto);
        updatePage(27);
    }

    function clearScore() {
        let status = unasus.pack.getStatus()
        status.M3E3 = {
            '1': false,
            '2': false,
            '3': false
        };
        unasus.pack.setStatus(status);
    }

    function tryAgain() {
        clearScore()
        window.location = currentExercise;
    }

    function changeWindow() {
        window.location = nextWindow;
    }

    $(document).ready(function() {
        activeMenu(27);
        show('informativo');
    });
</script>
    <?php require_once 'includes/footer.php'; ?>
</body>

</html>