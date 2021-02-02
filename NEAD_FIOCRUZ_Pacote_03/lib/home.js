function checkModulo(){
    let status = unasus.pack.getStatus();
    let last_page = 0
    for(let i=1; i<=31; i++){
        if(status.Pages[i]){
            if(last_page < i){
                last_page = i
                if (status.visited.indexOf(i) === -1)
                    status.visited.push(i)
                lastPage(last_page)
            }
            if(i === 2 && status.Pages[i-1] === true){
                $('#menu01').toggleClass('fa-angle-right fa-check');
                $('#tr-acesso-sistema .fa-times').toggleClass('fa-times fa-check');
                let score = checkNote("M0E1");
                $('#tr-acesso-sistema .nota-exercicio').html(score +' / 3</td>');
            }
            if(i === 4 && status.Pages[i-1] === true){
                $('#menu02').toggleClass('fa-angle-right fa-check');
                $('#tr-solicitacao-perfil .fa-times').toggleClass('fa-times fa-check');
                let score = checkNote("M0E2");
                $('#tr-solicitacao-perfil .nota-exercicio').html(score +' / 3</td>');
            }
            if(i === 5){
                $('#menu03').toggleClass('fa-book fa-check');
                let score = checkNote("A0");
                $('#tr-acesso-sistema .nota-avaliacao').html((score / 5) * 100 + '%');
            }

            if(i === 7 && status.Pages[i-1] === true){
                $('#menu04').toggleClass('fa-angle-right fa-check');
                $('#tr-cadastro-estabelecimento .fa-times').toggleClass('fa-times fa-check');
                let score = checkNote("M1E1");
                $('#tr-cadastro-estabelecimento .nota-exercicio').html(score +' / 3</td>');
            }
            if(i === 9 && status.Pages[i-1] === true){
                $('#menu05').toggleClass('fa-angle-right fa-check');
                $('#tr-configuracoes-origem .fa-times').toggleClass('fa-times fa-check');
                let score = checkNote("M1E2");
                $('#tr-configuracoes-origem .nota-exercicio').html(score +' / 3</td>');
            }
            if(i === 11 && status.Pages[i-1] === true){
                $('#menu06').toggleClass('fa-angle-right fa-check');
                $('#tr-consulta-produto .fa-times').toggleClass('fa-times fa-check');
                let score = checkNote("M1E3");
                $('#tr-consulta-produto .nota-exercicio').html(score +' / 3</td>');
            }
            if(i === 13 && status.Pages[i-1] === true){
                $('#menu07').toggleClass('fa-angle-right fa-check');
                $('#tr-cadastro-empenho .fa-times').toggleClass('fa-times fa-check');
                let score = checkNote("M1E4");
                $('#tr-cadastro-empenho .nota-exercicio').html(score +' / 3</td>');
            }
            if(i === 15 && status.Pages[i-1] === true){
                $('#menu08').toggleClass('fa-angle-right fa-check');
                $('#tr-selecionar-estabelecimento .fa-times').toggleClass('fa-times fa-check');
                let score = checkNote("M1E5");
                $('#tr-selecionar-estabelecimento .nota-exercicio').html(score +' / 3</td>');
            }
            if(i === 16){
                $('#menu09').toggleClass('fa-book fa-check');
                let score = checkNote("A1");
                console.log('Checknote', score)
                $('#tr-cadastro-estabelecimento .nota-avaliacao').html((score / 5) * 100 + '%');
            }

            if(i === 18 && status.Pages[i-1] === true){
                $('#menu10').toggleClass('fa-angle-right fa-check');
                $('#tr-cadastro-usuario .fa-times').toggleClass('fa-times fa-check');
                let score = checkNote("M2E1");
                $('#tr-cadastro-usuario .nota-exercicio').html(score +' / 3</td>');
            }
            if(i === 20 && status.Pages[i-1] === true){
                $('#menu11').toggleClass('fa-angle-right fa-check');
                $('#tr-dispensacao .fa-times').toggleClass('fa-times fa-check');
                let score = checkNote("M2E2");
                $('#tr-dispensacao .nota-exercicio').html(score +' / 3</td>');
            }
            if(i === 21){
                $('#menu12').toggleClass('fa-book fa-check');
                let score = checkNote("A2");
                $('#tr-cadastro-usuario .nota-avaliacao').html((score / 5) * 100 + '%');
            }

            if(i === 23 && status.Pages[i-1] === true){
                $('#menu13').toggleClass('fa-angle-right fa-check');
                $('#tr-entrada .fa-times').toggleClass('fa-times fa-check');
                let score = checkNote("M3E1");
                $('#tr-entrada .nota-exercicio').html(score +' / 3</td>');
            }4
            if(i === 25 && status.Pages[i-1] === true){
                $('#menu14').toggleClass('fa-angle-right fa-check');
                $('#tr-bloqueio-lote .fa-times').toggleClass('fa-times fa-check');
                let score = checkNote("M3E2");
                $('#tr-bloqueio-lote .nota-exercicio').html(score +' / 3</td>');
            }
            if(i === 27 && status.Pages[i-1] === true){
                $('#menu15').toggleClass('fa-angle-right fa-check');
                $('#tr-requisicao .fa-times').toggleClass('fa-times fa-check');
                let score = checkNote("M3E3");
                $('#tr-requisicao .nota-exercicio').html(score +' / 3</td>');
            }
            if(i === 29 && status.Pages[i-1] === true){
                $('#menu16').toggleClass('fa-angle-right fa-check');
                $('#tr-saidas-diversas .fa-times').toggleClass('fa-times fa-check');
                let score = checkNote("M3E4");
                $('#tr-saidas-diversas .nota-exercicio').html(score +' / 3</td>');
            }
            if(i === 30){
                $('#menu17').toggleClass('fa-book fa-check');
                let score = checkNote("A3");
                $('#tr-entrada .nota-avaliacao').html((score / 5) * 100 + '%');
            }
            if(i === 31){
                $('#menu18').toggleClass('fa-book fa-check');
            }
            unasus.pack.setStatus(status);
        }
    }
}
function checkNote(exercise){
    let status = unasus.pack.getStatus();
    let cont = 0;

    switch(exercise){
        case "M0E1":
            for(let i=1; i<=3; i++){
                if(status.M0E1[i]){
                    cont++;
                }
            }
            break;
        case "M0E2":
            for(let i=1; i<=3; i++){
                if(status.M0E2[i]){
                    cont++;
                }
            }
            break;
        case "A0":
            cont = status.A0V['score'] 
            break;

        case "M1E1":
            for(let i=1; i<=3; i++){
                if(status.M1E1[i]){
                    cont++;
                }
            }
            break;
        case "M1E2":
            for(let i=1; i<=3; i++){
                if(status.M1E2[i]){
                    cont++;
                }
            }
            break;
        case "M1E3":
            for(let i=1; i<=3; i++){
                if(status.M1E3[i]){
                    cont++;
                }
            }
            break;
        case "M1E4":
            for(let i=1; i<=3; i++){
                if(status.M1E4[i]){
                    cont++;
                }
            }
            break;
        case "M1E5":
            for(let i=1; i<=3; i++){
                if(status.M1E5[i]){
                    cont++;
                }
            }
            break;
        case "A1":
            cont = status.A1V['score'] 
            break;

        case "M2E1":
            for(let i=1; i<=3; i++){
                if(status.M2E1[i]){
                    cont++;
                }
            }
            break;
        case "M2E2":
            for(let i=1; i<=3; i++){
                if(status.M2E2[i]){
                    cont++;
                }
            }
            break;
        case "A2":
            cont = status.A2V['score'] 
            break;
        case "M3E1":
            for(let i=1; i<=3; i++){
                if(status.M3E1[i]){
                    cont++;
                }
            }
            break;
        case "M3E2":
            for(let i=1; i<=3; i++){
                if(status.M3E2[i]){
                    cont++;
                }
            }
            break;
        case "M3E3":
            for(let i=1; i<=3; i++){
                if(status.M3E3[i]){
                    cont++;
                }
            }
            break;
        case "M3E4":
            for(let i=1; i<=3; i++){
                if(status.M3E4[i]){
                    cont++;
                }
            }
            break;
        case "A3":
            cont = status.A3V['score'] 
            break;
    }
    return cont;
}

function lastPage(page){
    switch(page){
        case 1:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>vídeo em <span class="modulo-feedback">"Acesso ao Sistema"</span></b>. <br><a href="c1.php">Clique aqui para acessar a página</a></p>');
            break;
        case 2:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>exercício em <span class="modulo-feedback">"Acesso ao Sistema"</span></b>. <br><a href="c2.php">Clique aqui para acessar a página</a></p>');
            break;
        case 3:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>vídeo em <span class="modulo-feedback">"Solicitação de Perfil"</span></b>. <br><a href="c3.php">Clique aqui para acessar a página</a></p>');
            break;
        case 4:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>exercício em <span class="modulo-feedback">"Solicitação de Perfil"</span></b>. <br><a href="c4.php">Clique aqui para acessar a página</a></p>');
            break;       
        case 5:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>avaliação do módulo <span class="modulo-feedback">"Apresentação de Sistema"</span></b>. <br><a href="c5.php">Clique aqui para acessar a página</a></p>');
            break; 
        case 6:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>vídeo em <span class="modulo-feedback">"Cadastro de Estabelecimento"</span></b>. <br><a href="c6.php">Clique aqui para acessar a página</a></p>');
            break;
        case 7:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>exercício em <span class="modulo-feedback">"Cadastro de Estabelecimento"</span></b>. <br><a href="c7.php">Clique aqui para acessar a página</a></p>');
            break;
        case 8:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>vídeo em <span class="modulo-feedback">"Configurações (subgrupo de origem)"</span></b>. <br><a href="c8.php">Clique aqui para acessar a página</a></p>');
            break;
        case 9:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>exercício em <span class="modulo-feedback">"Configurações (subgrupo de origem)"</span></b>. <br><a href="c9.php">Clique aqui para acessar a página</a></p>');
            break;
        case 10:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>vídeo em <span class="modulo-feedback">"Consulta de Produto"</span></b>. <br><a href="c10.php">Clique aqui para acessar a página</a></p>');
            break;
        case 11:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>exercício em <span class="modulo-feedback">"Consulta de Produto"</span></b>. <br><a href="c11.php">Clique aqui para acessar a página</a></p>');
            break;
        case 12:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>vídeo em <span class="modulo-feedback">"Cadastro de Empenho"</span></b>. <br><a href="c12.php">Clique aqui para acessar a página</a></p>');
            break;
        case 13:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>exercício em <span class="modulo-feedback">"Cadastro de Empenho"</span></b>. <br><a href="c13.php">Clique aqui para acessar a página</a></p>');
            break;
        case 14:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>vídeo em <span class="modulo-feedback">"Selecionar Estabelecimento"</span></b>. <br><a href="c14.php">Clique aqui para acessar a página</a></p>');
            break;
        case 15:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>exercício em <span class="modulo-feedback">"Selecionar Estabelecimento"</span></b>. <br><a href="c15.php">Clique aqui para acessar a página</a></p>');
            break;
        case 16:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>avaliação do módulo <span class="modulo-feedback">"Módulo Administrativo"</span></b>. <br><a href="c16.php">Clique aqui para acessar a página</a></p>');
            break;
        case 17:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>vídeo em <span class="modulo-feedback">"Cadastro de Usuário"</span></b>. <br><a href="c17.php">Clique aqui para acessar a página</a></p>');
            break;
        case 18:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>exercício em <span class="modulo-feedback">"Cadastro de Usuário"</span></b>. <br><a href="c18.php">Clique aqui para acessar a página</a></p>');
            break;
        case 19:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>vídeo em <span class="modulo-feedback">"Dispensação"</span></b>. <br><a href="c19.php">Clique aqui para acessar a página</a></p>');
            break;
        case 20:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>exercício em <span class="modulo-feedback">"Dispensação"</span></b>. <br><a href="c20.php">Clique aqui para acessar a página</a></p>');
            break;
        case 21:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>avaliação do módulo <span class="modulo-feedback">"Módulo Atendimento"</span></b>. <br><a href="c21.php">Clique aqui para acessar a página</a></p>');
            break;
        case 22:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>vídeo em <span class="modulo-feedback">"Entrada"</span></b>. <br><a href="c22.php">Clique aqui para acessar a página</a></p>');
            break;
        case 23:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>exercício em <span class="modulo-feedback">"Entrada"</span></b>. <br><a href="c23.php">Clique aqui para acessar a página</a></p>');
            break;
        case 24:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>vídeo em <span class="modulo-feedback">"Bloqueio de lote"</span></b>. <br><a href="c24.php">Clique aqui para acessar a página</a></p>');
            break;
        case 25:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>exercício em <span class="modulo-feedback">"Bloqueio de lote"</span></b>. <br><a href="c25.php">Clique aqui para acessar a página</a></p>');
            break;
        case 26:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>vídeo em <span class="modulo-feedback">"Requisição"</span></b>. <br><a href="c26.php">Clique aqui para acessar a página</a></p>');
            break;
        case 27:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>exercício em <span class="modulo-feedback">"Requisição"</span></b>. <br><a href="c27.php">Clique aqui para acessar a página</a></p>');
            break;
        case 28:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>vídeo em <span class="modulo-feedback">"Saídas diversas"</span></b>. <br><a href="c28.php">Clique aqui para acessar a página</a></p>');
            break;
        case 29:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>exercício em <span class="modulo-feedback">"Saídas diversas"</span></b>. <br><a href="c29.php">Clique aqui para acessar a página</a></p>');
            break;
        case 30:
            $('#msg-feedback').html('<p id="msg-feedback">Olá aluno(a),<br>Sua última página acessada: <b>avaliação do módulo <span class="modulo-feedback">"Módulo Movimentação e Logística"</span></b>. <br><a href="c30.php">Clique aqui para acessar a página</a></p>');
    }
            
}

function scoreTotal(){
    lti = 0.0;
    let score1 = (checkNote("A0") / 5);
    lti = score1 + lti;
    let score2 = (checkNote("A1") / 5);
    lti = score2 + lti;
    let score3 = (checkNote("A2") / 5);
    lti = score3 + lti;
    let score4 = (checkNote("A3") / 5);
    lti = score4 + lti;
    $('#nota-geral').html((lti / 4 )* 100 + '%');
}

function redirectPage(pagina){
    $('body').load('c'+ pagina+'.php');
}

function sendCertificate(){
    let status = unasus.pack.getStatus();
    if (status.LTIvalue >= 0.7){
        $('#info_pesquisa').removeClass('pesquisa');
        $('#info_pesquisa').addClass('pesquisa_display');
    }
}

$(function () {
    checkModulo();
    scoreTotal();
});
