/* PPU 11/2020 */

function init(){
    unasus.pack.initialize();

    let status = unasus.pack.getStatus();

    if (status === undefined){
        status = createStatusDefault();
    }
    if(status === null){
        return false;
    }
}

function createStatusDefault(){
    let status = new Object();
    status.status = "attended";
    status.percentage = 0;
    status.LTIvalue = 0;


    /* Módulo 0 */
    status.M0E1 = {'1': false, '2': false, '3': false};
    status.M0E2 = {'1': false, '2': false, '3': false};

    status.A0 = {'1': false, '2': false, '3': false, '4': false, '5': false}
    status.AT0 = {'1': false, '2': false, '3': false};
    status.A0V = {'score': 0}

    /* Módulo 1 */
    status.M1E1 = {'1': false, '2': false, '3': false};
    status.M1E2 = {'1': false, '2': false, '3': false};
    status.M1E3 = {'1': false, '2': false, '3': false};
    status.M1E4 = {'1': false, '2': false, '3': false};
    status.M1E5 = {'1': false, '2': false, '3': false};

    status.A1 = {'1': false, '2': false, '3': false, '4': false, '5': false}
    status.AT1 = {'1': false, '2': false, '3': false};
    status.A1V = {'score': 0}

    /* Módulo 2 */
    status.M2E1 = {'1': false, '2': false, '3': false};
    status.M2E2 = {'1': false, '2': false, '3': false};

    status.A2 = {'1': false, '2': false, '3': false, '4': false, '5': false}
    status.AT2 = {'1': false, '2': false, '3': false};
    status.A2V = {'score': 0}

    /* Módulo 3 */
    status.M3E1 = {'1': false, '2': false, '3': false};
    status.M3E2 = {'1': false, '2': false, '3': false};
    status.M3E3 = {'1': false, '2': false, '3': false};
    status.M3E4 = {'1': false, '2': false, '3': false};

    status.A3 = {'1': false, '2': false, '3': false, '4': false, '5': false}
    status.AT3 = {'1': false, '2': false, '3': false};
    status.A3V = {'score': 0}


    status.Pages = {'1': false, '2': false, '3': false, '4': false, '5': false, '6': false, '7': false, '8': false, '9': false, '10': false, '11': false, '12': false, 
    '13': false, '14': false, '15': false,'16': false, '17': false, '18': false, '19': false, '20': false, '21': false, '22': false, '23': false, '24': false, '25': false, 
    '26': false, '27': false, '28': false, '29': false, '30': false};

    status.visited = [];

    status.last = {'0': 0, '1': 1};

    unasus.pack.setStatus(status);

    return status;
}

function checkQuestion(exercise, question, correct){
    let status = unasus.pack.getStatus();

    switch(exercise){

        /* Módulo 0 */
        case "M0E1":
            status.M0E1[question] = correct;
            break;
        case "M0E2":
            status.M0E2[question] = correct;
            break;
        case "A0":
            status.A0[question] = correct;
            break;

        /* Módulo 1 */
        case "M1E1":
            status.M1E1[question] = correct;
            break;
        case "M1E2":
            status.M1E2[question] = correct;
            break;
        case "M1E3":
            status.M1E3[question] = correct;
            break;
        case "M1E4":
            status.M1E4[question] = correct;
            break;
        case "M1E5":
            status.M1E5[question] = correct;
            break;
        case "A1":
            status.A1[question] = correct;
            break;

        /* Módulo 2 */
        case "M2E1":
            status.M2E1[question] = correct;
            break;
        case "M2E2":
            status.M2E2[question] = correct;
            break;
        case "A2":
            status.A2[question] = correct;
            break;

        /* Módulo 3 */
        case "M3E1":
            status.M3E1[question] = correct;
            break;
        case "M3E2":
            status.M3E2[question] = correct;
            break;
        case "M3E3":
            status.M3E3[question] = correct;
            break;
        case "M3E4":
            status.M3E4[question] = correct;
            break;
        case "A3":
            status.A3[question] = correct;
            break;

    }
    updateLTI(status);
}

function updateLTI(status){
    let lti = 0.0;

    let score1 = (checkNote("A0") / 5);
    lti = score1;
    console.log('### SCORE1 ###', lti)
    let score2 = (checkNote("A1") / 5);
    lti = score2;
    console.log('### SCORE2 ###', lti)
    let score3 = (checkNote("A2") / 5);
    lti = score3;
    console.log('### SCORE3 ###', lti)
    let score4 = (checkNote("A3") / 5);
    lti = score4;
    console.log('### SCORE4 ###', lti)
    
    unasus.pack.setStatus(status);
    
}

function caseAnswer(arrayQuestions, stage) {

    let answer = new Object();

    answer.stage = stage;
    answer.questions = arrayQuestions;

    unasus.pack.setPersistence('ANSWER', answer);
    
    checkQuestion(stage, arrayQuestions[0]['question'], arrayQuestions[0]['correct']);
    
}

function checkPerc(){
    let status = unasus.pack.getStatus();
    return status.percentage;
}

function checkScore(){
    let status = unasus.pack.getStatus();
    return status.LTIvalue;
}

function updatePage(page){
    let status = unasus.pack.getStatus();
    
    if(page > 20){
        status.percentage = status.percentage + 2;
    }else{
        status.percentage = status.percentage + 4;
    }
    if(status.percentage <= 100 && status.Pages[page] === false){
        status.Pages[page]= true;
        unasus.pack.setStatus(status);
    }
}

function activeMenu(page){
    let number_module = document.getElementById("module_now"); 
    let text_module = document.getElementById("module_text"); 
    function clearItem() {
        for(i=1 ; i<=31; i++){
            $('#c'+i).removeClass('active');
        }
    }

    switch(page){
        case 1:
            number_module.innerHTML = 'Apresentação do Sistema /';
            text_module.innerHTML = 'Acesso ao Sistema';
            clearItem();
            $('#submenu01_1').collapse();
            $('#menu01_1 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#c1').addClass('active');
            break;
        case 2:
            number_module.innerHTML = 'Apresentação do Sistema /';
            text_module.innerHTML = 'Acesso ao Sistema - Exercício';
            clearItem();
            $('#menu01_1 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu01_1').collapse();
            $('#c2').addClass('active');
            break;
        case 3:
            number_module.innerHTML = 'Apresentação do Sistema /';
            text_module.innerHTML = 'Solicitação de Perfil';
            clearItem();
            $('#menu01_2 li i').toggleClass('fa-angle-right fa-angle-down')
            $('#submenu01_2').collapse();
            $('#c3').addClass('active');
            break;
        case 4:
            number_module.innerHTML = 'Apresentação do Sistema /';
            text_module.innerHTML = 'Solicitação de Perfil - Exercício';
            clearItem();
            $('#menu01_2 li i').toggleClass('fa-angle-right fa-angle-down')
            $('#submenu01_2').collapse();
            $('#c4').addClass('active');
            break;       
        case 5:
            number_module.innerHTML = 'Apresentação do Sistema /';
            text_module.innerHTML = 'Avaliação';
            clearItem();
            $('#c5').addClass('active');
            break; 
        case 6:
            number_module.innerHTML = 'Módulo Administrativo /';
            text_module.innerHTML = 'Cadastro de Estabelecimento';
            clearItem();
            $('#menu02_1 li i').toggleClass('fa-angle-right fa-angle-down')
            $('#submenu02_1').collapse();
            $('#c6').addClass('active');
            break;
        case 7:
            number_module.innerHTML = 'Módulo Administrativo /';
            text_module.innerHTML = 'Cadastro de Estabelecimento - Exercício';
            clearItem();
            $('#menu02_1 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu02_1').collapse();
            $('#c7').addClass('active');
            break;
        case 8:
            number_module.innerHTML = 'Módulo Administrativo /';
            text_module.innerHTML = 'Configurações (subgrupo de origem)';
            clearItem();
            $('#menu02_2 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu02_2').collapse();
            $('#c8').addClass('active');
            break;
        case 9:
            number_module.innerHTML = 'Módulo Administrativo /';
            text_module.innerHTML = 'Configurações (subgrupo de origem) - Exercícios';
            clearItem();
            $('#menu02_2 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu02_2').collapse();
            $('#c9').addClass('active');
            break;
        case 10:
            number_module.innerHTML = 'Módulo Administrativo /';
            text_module.innerHTML = 'Consulta de Produto';
            clearItem();
            $('#menu02_3 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu02_3').collapse();
            $('#c10').addClass('active');
            break;
        case 11:
            number_module.innerHTML = 'Módulo Administrativo /';
            text_module.innerHTML = 'Consulta de Produto - Exercícios';
            clearItem();
            $('#menu02_3 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu02_3').collapse();
            $('#c11').addClass('active');
            break;
        case 12:
            number_module.innerHTML = 'Módulo Administrativo /';
            text_module.innerHTML = 'Cadastro de Empenho';
            clearItem();
            $('#menu02_4 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu02_4').collapse();
            $('#c12').addClass('active');
            break;
        case 13:
            number_module.innerHTML = 'Módulo Administrativo /';
            text_module.innerHTML = 'Cadastro de Empenho - Exercício';
            clearItem();
            $('#menu02_4 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu02_4').collapse();
            $('#c13').addClass('active');
            break;
        case 14:
            number_module.innerHTML = 'Módulo Administrativo /';
            text_module.innerHTML = 'Selecionar Estabelecimento';
            clearItem();
            $('#menu02_5 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu02_5').collapse();
            $('#c14').addClass('active');
            break;
        case 15:
            number_module.innerHTML = 'Módulo Administrativo /';
            text_module.innerHTML = 'Selecionar Estabelecimento - Exercício';
            clearItem();
            $('#menu02_5 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu02_5').collapse();
            $('#c15').addClass('active');
            break;
        case 16:
            number_module.innerHTML = 'Módulo Administrativo /';
            text_module.innerHTML = 'Avaliação';
            clearItem();
            $('#c16').addClass('active');
            break;
        case 17:
            number_module.innerHTML = 'Módulo Atendimento /';
            text_module.innerHTML = 'Cadastro de Usuário';
            clearItem();
            $('#menu03_1 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu03_1').collapse();
            $('#c17').addClass('active');
            break;
        case 18:
            number_module.innerHTML = 'Módulo Atendimento /';
            text_module.innerHTML = 'Cadastro de Usuário - Exercício';
            clearItem();
            $('#menu03_1 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu03_1').collapse();
            $('#c18').addClass('active');
            break;
        case 19:
            number_module.innerHTML = 'Módulo Atendimento /';
            text_module.innerHTML = 'Dispensação';
            clearItem();
            $('#menu03_2 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu03_2').collapse();
            $('#c19').addClass('active');
            break;
        case 20:
            number_module.innerHTML = 'Módulo Atendimento /';
            text_module.innerHTML = 'Dispensação - Exercício';
            clearItem();
            $('#menu03_2 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu03_2').collapse();
            $('#c20').addClass('active');
            break;
        case 21:
            number_module.innerHTML = 'Módulo Atendimento /';
            text_module.innerHTML = 'Avaliação';
            clearItem();
            $('#c21').addClass('active');
        case 22:
            number_module.innerHTML = 'Módulo Movimentação e Logística /';
            text_module.innerHTML = 'Entrada';
            clearItem();
            $('#menu04_1 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu04_1').collapse();
            $('#c22').addClass('active');
            break;
        case 23:
            number_module.innerHTML = 'Módulo Movimentação e Logística /';
            text_module.innerHTML = 'Entrada - Exercício';
            clearItem();
            $('#menu04_1 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu04_1').collapse();
            $('#c23').addClass('active');
            break;
        case 24:
            number_module.innerHTML = 'Módulo Movimentação e Logística /';
            text_module.innerHTML = 'Bloqueio de lote';
            clearItem();
            $('#menu04_2 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu04_2').collapse();
            $('#c24').addClass('active');
            break;
        case 25:
            number_module.innerHTML = 'Módulo Movimentação e Logística /';
            text_module.innerHTML = 'Bloqueio de lote - Exercício';
            clearItem();
            $('#menu04_2 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu04_2').collapse();
            $('#c25').addClass('active');
            break;
        case 26:
            number_module.innerHTML = 'Módulo Movimentação e Logística /';
            text_module.innerHTML = 'Requisição';
            clearItem();
            $('#menu04_3 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu04_3').collapse();
            $('#c26').addClass('active');
            break;
        case 27:
            number_module.innerHTML = 'Módulo Movimentação e Logística /';
            text_module.innerHTML = 'Requisição - Exercício';
            clearItem();
            $('#menu04_3 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu04_3').collapse();
            $('#c27').addClass('active');
            break;
        case 28:
            number_module.innerHTML = 'Módulo Movimentação e Logística /';
            text_module.innerHTML = 'Saídas diversas';
            clearItem();
            $('#menu04_4 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu04_4').collapse();
            $('#c28').addClass('active');
            break;
        case 29:
            number_module.innerHTML = 'Módulo Movimentação e Logística /';
            text_module.innerHTML = 'Saídas diversas - Exercício';
            clearItem();
            $('#menu04_4 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu04_4').collapse();
            $('#c29').addClass('active');
            break;
        case 30:
            number_module.innerHTML = 'Módulo Movimentação e Logística /';
            text_module.innerHTML = 'Avaliação';
            clearItem();
            $('#c30').addClass('active');
            break;
        case 31:
            number_module.innerHTML = 'Conclusão';
            text_module.innerHTML = '';
            clearItem();
            $('#menu05_1 li i').toggleClass('fa-angle-right fa-angle-down');
            $('#submenu05_1').collapse();
            $('#c31').addClass('active');
            break;
    }
}

function checkAttempt(exercise) {

    let status = unasus.pack.getStatus();
    let cont = 0

    switch(exercise){
        case "AT0":
            for(i=1; i<=3; i++){
                if(!status.AT0[i]){
                    cont++
                }
            } 
            return cont
        case "AT1":
            for(i=1; i<=3; i++){
                if(!status.AT1[i]){
                    cont++
                }
            } 
            return cont
        case "AT2":
            for(i=1; i<=3; i++){
                if(!status.AT2[i]){
                    cont++
                }
            } 
            return cont
        case "AT3":
            for(i=1; i<=3; i++){
                if(!status.AT3[i]){
                    cont++
                }
            } 
            return cont

    }   
}   

function maxAttempt(exercise){
    let status = unasus.pack.getStatus();
    let cont = 0

    switch(exercise){
        case "AT0":
            for(i=1; i<=3; i++){
                if(!status.AT0[i]){
                    cont++
                }
            } 
            if(cont > 0){
                status.AT0[cont]= true;
                unasus.pack.setStatus(status);
            }
            return cont

        case "AT1":
            for(i=1; i<=3; i++){
                if(!status.AT1[i]){
                    cont++
                }
            } 
            if(cont > 0){
                status.AT1[cont]= true;
                unasus.pack.setStatus(status);
            }
            return cont

        case "AT2":
            for(i=1; i<=3; i++){
                if(!status.AT2[i]){
                    cont++
                }
            } 
            if(cont > 0){
                status.AT2[cont]= true;
                unasus.pack.setStatus(status);
            }
            return cont

        case "AT3":
        for(i=1; i<=3; i++){
            if(!status.AT3[i]){
                cont++
            }
        } 
        if(cont > 0){
            status.AT3[cont]= true;
            unasus.pack.setStatus(status);
        }
        return cont
    }  
     
}

