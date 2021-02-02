function passAnswer(unidade, question, alternative, correct) {

    var arrayAnswer = new Array();
    var answer = new Object();

    answer.question = question;
    answer.alternative = alternative;
    answer.correct = correct;

    arrayAnswer.push(answer);

    caseAnswer(arrayAnswer, unidade);
}


$(function () {

    init();
});