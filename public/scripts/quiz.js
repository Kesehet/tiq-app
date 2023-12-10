

const QUESTIONS = QUIZ.questions;

var question_index = 0;
var ANSWERS = {};

function getQuestions(){
    var ret = [];
    QUESTIONS.forEach(question => {
        var translations = {};
        var available_languages = [];
        question.translations.forEach(translation => {
            translations[translation.language] = {
                translated_text : translation.translated_text,
                question_id : translation.question_id,
                language : translation.language
            };
        available_languages.push(translation.language);
        });

        ret.push({
            id: question.id,
            question: question.question_text,
            answers: processOptions(question.options),
            translations: translations
        });
    });
    return ret;
}


function processOptions(options){
    var ret= [];
    options.forEach(option => {
        var translations = {};
        option.translation_options.forEach(translation => {
            translations[translation.language] = {
                translated_text : translation.translated_text,
                option_id : translation.question_id,
                language : translation.language
            };
        });
        ret.push(
            {
                id: option.id,
                text: option.option_text,
                is_correct: option.is_correct,
                translation : translations
            }
        );
    });

    return ret;
}
 

function addOption(text,id){
    var parentElement = document.getElementById("option_holder");
    parentElement.innerHTML += getOptionBox(text,id);
}

function clearOptions(){
    var parentElement = document.getElementById("option_holder");
    parentElement.innerHTML = "";
}


function getOptionBox(text,id){
    return `
        <li id="${id}" name="${id}" class="w3-hover-light-grey" onclick="addAnswerToList('${id}')">${text}</li>
    `;
}

function addAnswerToList(id){
    var questionNow = getQuestions()[question_index]
    ANSWERS[questionNow.id] = id;
    questionNow.answers.forEach(answer => {
        if(answer.is_correct == 1){
            document.getElementById(answer.id).classList.add("w3-green");
        }else if(answer.is_correct == 0){
            document.getElementById(answer.id).classList.add("w3-red");
        }
        else{
            document.getElementById(answer.id).classList.add("w3-grey");
        }
        document.body.focus();
    });
    
}


function setQuestion(){
    clearOptions();
    var question = getQuestions()[question_index];
    document.getElementById("question").innerHTML = question.question;
    question.answers.forEach(answer => {
        addOption(answer.text,answer.id);
    });
}

function nextQuestion(){
    if(question_index < getQuestions().length - 1){
        question_index++;
        setQuestion();
    }else{
        finishQuiz();
    }
    
    
}

function previousQuestion(){
    if(question_index > 0){
        question_index--;
        setQuestion();
    }
}

function finishQuiz(){
    if(question_index == getQuestions().length-1){
        clearOptions();
        document.getElementById("question").innerHTML = "Quiz Finished.";
        document.getElementById("next").style.display = "none";
        document.getElementById("previous").style.display = "none";
        submitAnswers();
    }
}

function submitAnswers(){
    console.log(ANSWERS);
}

setQuestion();
