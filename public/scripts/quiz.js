

const QUESTIONS = QUIZ.questions;

var question_index = 0;
var ANSWERS = {};


function getQuestions(){
    var ret = [];
    QUESTIONS.forEach(question => {
        var translations = {};
        var available_languages = ["default"];
        question.translations.forEach(translation => {
            translations[translation.language] = {
                translated_text : translation.translated_text,
                question_id : translation.question_id,
                language : translation.language
            };
        available_languages.push(translation.language);
        });
        translations["default"] = {
            translated_text : question.question_text,
            question_id : question.id,
            language : "default"
        };

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
                language : translation.language
            };
        });
        translations["default"] = {
            translated_text : option.option_text,
            language : "default"
        };
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
 

function addOption(text,id,is_correct){
    var parentElement = document.getElementById("option_holder");
    parentElement.innerHTML += getOptionBox(text,id,is_correct);
}

function clearOptions(){
    var parentElement = document.getElementById("option_holder");
    parentElement.innerHTML = "";
}


function getOptionBox(text,id,is_correct){
    console.log(is_correct);
    color = is_correct == 1 ? "w3-green" : "w3-grey";
    return `
        <li id="${id}" name="${id}" class="w3-hover-${color}" onclick="addAnswerToList('${id}')">${text}</li>
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
    document.getElementById("question").innerHTML = question.translations[ACTIVE_LANGUAGE].translated_text;
    question.answers.forEach(answer => {
        addOption(answer.translation[ACTIVE_LANGUAGE].translated_text,answer.id,answer.is_correct);
    });

    // Update the visibility of the Previous button
    document.getElementById("previous").style.display = question_index > 0 ? "" : "none";

    // Change the Next button to Finish on the last question
    if (question_index == getQuestions().length - 1) {
        document.getElementById("next").textContent = "Finish";
    } else {
        document.getElementById("next").textContent = "Next";
    }
}


function nextQuestion(){
    if(question_index < getQuestions().length - 1){
        question_index++;
        setQuestion();
    } else{
        finishQuiz();
    }    
}


function setLanguage(language){
    ACTIVE_LANGUAGE = language;
    setQuestion();
}

function previousQuestion(){
    if(question_index > 0){
        question_index--;
        setQuestion();
    }
}

function finishQuiz(){
    clearOptions();
    document.getElementById("question").innerHTML = "Quiz Finished.";
    document.getElementById("next").style.display = "none";
    document.getElementById("previous").style.display = "none";
    submitAnswers();
}


function submitAnswers() {
    fetch(BASE_URL+'/api/submit-quiz/'+QUIZ.id, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Fetch CSRF token
        },
        body: JSON.stringify({answers: ANSWERS})
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        window.location.href = BASE_URL+'/quiz-results/'+QUIZ.id;
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}


setQuestion();
