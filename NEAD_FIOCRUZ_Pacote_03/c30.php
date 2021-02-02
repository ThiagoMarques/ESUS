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
                <input type="button" onclick="changeWindow()" value="Finalizar curso">
                <h1></h1>
            </div>
            <div class="stepBack" onclick="stepNavigationNew('c29');"><i class="fas fa-chevron-left"></i></div>
            <div class="stepFoward" onclick="stepNavigationNew('c31');"><i class="fas fa-chevron-right"></i></div>
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
            question: 'A funcionalidade “Cadastro de empenho” permite que o operador registre os dados de empenho no sistema e-SUS AF. Quanto a esta funcionalidade, assinale a alternativa INCORRETA:',
            choice1: 'Essa funcionalidade está relacionada com a funcionalidade de “Entrada de produtos”, onde os empenhos podem ser utilizados e vinculados ao registro da entrada.',
            choice2: 'O e-SUS AF permite que os gestores acompanhem a execução dos empenhos, possibilitando assim o controle dos registros financeiros de sua localidade.',
            choice3: 'O registro dos empenhos é obrigatório no e-SUS AF. Não é possível a inclusão de produtos no Sistema (entrada de produtos) sem a criação de registros de empenho.',
            choice4: 'Empenhos salvos parcialmente podem ser alterados a qualquer momento pelo operador e não estarão disponíveis para consulta na funcionalidade “Entrada de produtos”.',
            answer: 3,
            feedback1: 'Isso mesmo. Empenhos cadastrados podem ter as suas informações resgatadas na funcionalidade  “Entrada de produtos”.',
            feedback2: 'Essa é a definição da principal propriedade dos cadastros de empenho no e-SUS AF.',
            feedback3: 'A funcionalidade de “Cadastro de empenho” não é de uso obrigatório, portanto, caso o ente opte por não registrar seus empenhos, as entradas podem ser realizadas normalmente, por meio da funcionalidade “Entrada de produtos”.',
            feedback4: 'Sim. Empenhos salvos parcialmente não estarão disponíveis na funcionalidade “Entrada de produtos” e poderão ser alterados ou excluídos do sistema.',
          },
          {
            type: 'ME',
            enunciate: 'Marque uma das opções abaixo:',
            question: "A funcionalidade “Entrada” permite o registro de todos os produtos recebidos pelo estabelecimento de saúde. Algumas funcionalidades do e-SUS AF estão vinculadas diretamente com a funcionalidade de “Entrada”. Marque a opção que possui tais  funcionalidades:",
            choice1: "Endereçamento físico, programa de saúde e empenho.",
            choice2: "Cadastro de usuário SUS e dispensação.",
            choice3: "Subgrupo de origem de receita e programa de saúde.",
            choice4: "Empenho e saídas diversas.",
            answer: 1,
            feedback1: 'A funcionalidade de entrada está relacionada ao endereçamento físico que é registrado no cadastro de estabelecimento, pois este tem o objetivo de organizar fisicamente o estoque do local. Também está relacionada à indicação do programa de saúde, pois no momento da realização da entrada o operador poderá indicar a qual programa de saúde o lote do medicamento pertence e assim diferenciá-lo em seu estoque. Outra funcionalidade que está relacionada à entrada é o registro de empenho, pois os empenhos, previamente cadastrados, podem ser recuperados no momento da entrada, sendo possível ao gestor realizar o controle de saldo dos empenhos de sua localidade.',
            feedback2: 'As duas funcionalidades apontadas estão relacionadas à saída de produtos do Sistema, por meio da funcionalidade “Dispensação”.',
            feedback3: 'O subgrupo de origem de receita se relaciona diretamente com a funcionalidade “Dispensação”.',
            feedback4: 'A funcionalidade “Saídas diversas” não tem relação com a funcionalidade “Entrada”.',
          },
          {
            type: 'ME',
            enunciate: 'Marque uma das opções abaixo:',
            question: "Para realização de solicitações e distribuições entre estabelecimentos, o e-SUS AF possui a funcionalidade “Requisição”. Quanto a essa funcionalidade, é CORRETO afirmar que:",
            choice1: "Requisições com situação “Em preenchimento” não podem ser editadas pelo estabelecimento de saúde que está realizando a requisição;",
            choice2: "O e-SUS AF permite que estados e municípios diferentes realizem e atendam requisições de produtos entre si. Entretanto, para que essa movimentação ocorra, é necessária à autorização do gestor do local que está solicitando e do local que está atendendo a requisição;",
            choice3: "As requisições com status “Aguardando autorização (solicitante)” estão em fase de análise do local requisitado;",
            choice4: "Para distribuir produtos para um departamento de estabelecimento de saúde, faz-se necessária a autorização do gestor local.",
            answer: 2,
            feedback1: 'Essa situação é a única que permite a edição de dados do registro.',
            feedback2: 'O e-SUS AF permite que estados e municípios diferentes realizem e atendam requisições de medicamentos entre si, porém, há diversas questões legais que devem ser consideradas para realização de movimentações deste tipo. Portanto, para que essas movimentações ocorram, ao realizar uma requisição entre estados e municípios, esta apresenta a situação “Aguardando autorização (solicitante)”, ou seja, pendente de autorização do gestor do local que está solicitando o produto. Após a autorização do gestor do local solicitante, a requisição apresenta a “Aguardando autorização (atendente)” e, só após as duas autorizações, as requisições podem ser atendidas no e-SUS AF.',
            feedback3: 'Pequeno erro no item: a situação indicada exige análise e autorização do local solicitante em vez do local requisitado.',
            feedback4: 'Este tipo de distribuição não requer nenhuma autorização.',
          },
          {
            type: 'ME',
            enunciate: 'Marque uma das opções abaixo:',
            question: "Um dos grandes avanços do e-SUS AF  é a possibilidade de utilização de leitor de código de barras e de códigos do tipo Datamatrix para identificação de medicamentos e produtos para a saúde. Quanto a essa funcionalidade do Sistema, indique a opção CORRETA:",
            choice1: "A funcionalidade de entrada de produto não possibilita a utilização de leitor de código de barras ou de Datamatrix, sendo possível sua utilização apenas na funcionalidade de dispensação.",
            choice2: "As funcionalidades de entrada de produtos, atendimento de requisição, saída diversa e dispensação possibilitam a utilização de leitor de código de barras e Datamatrix.",
            choice3: "É obrigatório o uso de leitor de código de barras e Datamatrix para realização de uma dispensação.",
            choice4: "Para registrar um empenho no sistema é obrigatória a utilização de leitor de código de barras e Datamatrix.",
            answer: 2,
            feedback1: 'Qualquer funcionalidade que envolva produtos no e-SUS AF permite a utilização de leitor de código de barras ou de Datamatrix para identificação e busca dos itens',
            feedback2: 'As funcionalidades de entrada de produto, atendimento de requisição, saída diversa e dispensação possibilitam a utilização do leitor de código de barras e Datamatrix. Já nas funcionalidades de empenho e solicitação via requisição, a utilização de leitores não é habilitada, pois nestas funcionalidades o operador não possui o produto em mãos para bipagem com utilização de leitores.',
            feedback3: 'O produto também pode ser buscado e selecionado pela digitação dos números do código de barras ou identificação pelo princípio ativo.',
            feedback4: 'Não há obrigatoriedade de utilização de leitor para registro de um empenho no e-SUS AF.',
          },
          {
            type: 'ME',
            enunciate: 'Marque uma das opções abaixo:',
            question: "O e-SUS AF permite o registro de saídas diversas que devem ser utilizadas nas seguintes situações:",
            choice1: "Atendimento de requisição e atendimento a usuário SUS.",
            choice2: "Eventos incomuns como: validade vencida, perda de medicamentos, roubo e atendimento de usuário não identificado. ",
            choice3: "Eventos comuns de rotina como: dispensação, atendimento de requisição e troca entre locais diferentes.",
            choice4: "A funcionalidade nunca deve ser utilizada, pois todos os registros devem ser realizados através de dispensação.",
            answer: 2,
            feedback1: 'Para ambos os casos há funcionalidades próprias no e-SUS AF.',
            feedback2: 'A funcionalidade de saída diversa deve ser utilizada em caso de saídas com impossibilidade de atendimento via requisição e dispensação, sendo, portanto para eventos incomuns como: validade vencida, perda de medicamentos, roubo e atendimento de usuário não identificado.',
            feedback3: 'Para atendimento das necessidades do item, o e-SUS AF possui as funcionalidades “Dispensação” e “Requisição”.',
            feedback4: 'De modo algum. A funcionalidade deve ser usada para qualquer evento de saída de estoque que fuja às demais funcionalidades do e-SUS AF',
          },
          {
            type: 'ME',
            enunciate: 'Marque uma das opções abaixo:',
            question: "Acerca da funcionalidade “Bloqueio de Lote”, marque a opção INCORRETA:",
            choice1: "O bloqueio de lotes impede que lotes específicos de produtos sofram qualquer movimentação (entrada, saída ou dispensação) no estoque do estabelecimento no e-SUS AF.",
            choice2: "O e-SUS permite bloquear lotes em estoque de outros estabelecimentos de saúde.",
            choice3: "O bloqueio de lote pode ser aplicado a partir de uma data específica.",
            choice4: "Somente é possível bloquear lotes que estejam em estoque.",
            answer: 1,
            feedback1: 'Essa é a consequência de se bloquear um lote no sistema.',
            feedback2: 'Sim. O sistema permite essa função para usuários com perfil do tipo “Gestor”.',
            feedback3: 'Por meio do preenchimento do campo “Data do bloqueio”, é possível agendar o início da vigência de um bloqueio de lote.',
            feedback4: 'O e-SUS permite o bloqueio de lotes ainda não inseridos no estoque, por meio da opção “Outros lotes”.',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Um produto com validade vencida poderá somente ser retirado do estoque por meio da funcionalidade “Saídas diversas”, utilizando-se o tipo de saída “Validade Vencida”.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 1,
            feedback1: 'Exatamente. É a única possibilidade de retirar produtos vencidos em estoque no e-SUS AF.',
            feedback2: 'Item incorreto.',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Toda requisição no e-SUS AF exige autorização para ser realizada no Sistema.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 2,
            feedback1: 'Somente requisições entre estabelecimentos de esferas de gestão distintas exigem autorizações para serem realizadas.',
            feedback2: 'Muito bem!',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Ao clicar no botão “Salvar Parcial”, na tela de “Cadastrar Entrada de Produto”, o registro de entrada é concluído e os produtos são armazenados no estoque do estabelecimento de saúde.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 2,
            feedback1: 'Ao clicar no botão, a entrada não é realizada e o pedido somente é salvo no Sistema, tendo a situação do tipo “Em preenchimento”, podendo ser futuramente editado ou excluído do e-SUS AF.',
            feedback2: 'Muito bem!',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "A funcionalidade “Saídas Diversas” pode ser realizada para atender usuários SUS.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 1,
            feedback1: 'Embora não seja regra no Sistema, caso o usuário SUS não tenha nenhuma identificação e seja preciso realizar uma saída para atendê-lo, há o recurso de saída do tipo “Usuário SUS”, na funcionalidade “Saídas Diversas”.',
            feedback2: 'Item incorreto.',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Em “Requisição”, movimentações entre estabelecimentos podem ser realizadas somente mediante o fluxo de solicitação e atendimento entre estabelecimentos de saúde no e-SUS AF.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 2,
            feedback1: 'Por meio dessa funcionalidade também é possível realizar distribuições sem solicitação e distribuições para departamento.',
            feedback2: 'Muito bem!',
          },
          {
            type: 'VF',
            enunciate: 'Julgue a afirmativa abaixo:',
            question: "Após a entrada de um lote, caso este tenha sido previamente bloqueado no Sistema, ele entrará em estoque, mas somente poderá sofrer movimentações adicionais após o seu desbloqueio no sistema.",
            choice1: "Verdadeiro",
            choice2: "Falso",
            answer: 1,
            feedback1: 'Exatamente. O bloqueio não impede o registro da entrada, mas impede qualquer outra movimentação do estoque.',
            feedback2: 'Item incorreto.',
          }
        ]

    const SCORE_POINTS = 1
    const MAX_QUESTIONS = 5
    const moduleExercise = 'A3'
    const currentExercise = 'c30.php'
    const nextWindow = 'c31.php'


    startQuestions = () => {
        questionCounter = 0
        score = 0
        availableQuestions = [...questions]
        clearScore()
        startAttempt()
        getNewQuestion()
        if (checkAttempt("AT3") === 1) {
          
          clearPPU()
        }
        if (checkAttempt("AT3") === 2) {
          
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

        betterScore = status.A3V['score']

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

        if (checkAttempt("AT3") === 0 && score <= 2) {
          feed_text = '<span class="bad">Você não possui mais tentativas.</span>'
        }

        status.A3V['score'] = betterScore

        lti = status.LTIvalue
        lti += betterScore / 20
        status.LTIvalue = lti

        unasus.pack.setStatus(status);

        $("#feedbackTexto").html(feed_text);
        $("#feedbackResultado").html(texto);
        $("#notaAvaliacao").html((score / 5) * 100 + '%');
        $("#maiorNota").html((betterScore / 5) * 100 + '%');

        if (checkAttempt("AT3") === 0) {
          $("#btn-refazer").hide();
        }

        updatePage(30);
    }

    function clearScore() {
        let status = unasus.pack.getStatus()
        status.A3 = {
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
      if (maxAttempt("AT3") === 0) {
        $("#btn-start").prop("disabled",true)
        $("#btn-refazer").hide()
        let tentativas = checkAttempt("AT3")
        $("#tentativasRestantes").html(tentativas)
        let limite = '<span class="bad">Você excedeu o número de tentivas!</span>'
        $("#limiteExcedido").html(limite);
        show('resultado')
      }
    }

    function clearPPU(){
      let status = unasus.pack.getStatus()
      betterScore = status.A3V['score']
      status.A3 = {'1': false, '2': false, '3': false, '4': false, '5': false};
      lti = status.LTIvalue
      lti -= betterScore / 20
      status.LTIvalue = lti
      unasus.pack.setStatus(status);
    }

    function changeWindow(){
      window.location = nextWindow;
    }


    $(document).ready(function() {
      activeMenu(30)
      show('informativo')
      let tentativas = checkAttempt("AT3")
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