<div class="w3-container">
    <!-- Quiz Description Section -->
    <div class="w3-card w3-round-large w3-margin-bottom" id="title-screen" >
        <div class="w3-container w3-padding">
            <img src="{{ $quiz->featured_image }}" class="w3-round-xlarge" style="width:100%;">
            <h2>{{ $quiz->title }}</h2>
            <p>{!!$quiz->description !!}</p>
            <button class="w3-button w3-green w3-margin-top w3-round-xxlarge" onclick="startQuiz()">Start Quiz</button>
        </div>
    </div>

    <!-- Quiz Questions Section -->
    <div id="quizSection" style="display:none;">
        <div id="question" class="w3-panel w3-border w3-padding">Question will go here</div>
        <ul class="w3-ul w3-border" id="option_holder">
            <!-- Options will be populated here -->
        </ul>
        <button id="previous" class="w3-button w3-blue w3-margin-top" onclick="previousQuestion()"><i class="fa fa-arrow-left"></i> Previous</button>
        <button id="next" class="w3-button w3-blue w3-margin-top" onclick="nextQuestion()">Next <i class="fa fa-arrow-right"></i></button>
    </div>
</div> 

<script>
    function startQuiz() {
        document.getElementById('quizSection').style.display = 'block';
        document.getElementById('title-screen').style.display = 'none';
        document.getElementById('quizSection').style.width = "100vw";
        document.getElementsByClassName("content")[0].style.display = "flex";
        document.getElementsByClassName("content")[0].style.justifyContent = "center";
        document.getElementsByClassName("content")[0].style.alignContent = "center";
        document.getElementsByClassName("content")[0].style.flexWrap = "wrap";
        document.getElementsByClassName("content")[0].style.alignItems = "center";

    }



    let currentQuestionIndex = 0;
    const QUIZ = {!! $quizContent !!};
    var ACTIVE_LANGUAGE = "default";
</script>



<script>


const QUESTIONS = QUIZ.questions;

var question_index = 0;
var ANSWERS = {};
LANGUAGES = @json($languages);


function getQuestions(){
    // Initialize an empty array to store the processed questions.
    var ret = [];

    // Iterate over each question in the QUESTIONS array.
    QUESTIONS.forEach(question => {
        // Initialize an empty object to store translations of the question.
        var translations = {};

        // Define an array to track available languages, starting with 'default'.
        var available_languages = ["default"];

        // Iterate over each translation in the current question.
        question.translations.forEach(translation => {
            // Store the translation details in the translations object.
            // Each language will be a key, and the value is an object containing
            // the translated text, question ID, and language.
            translations[languageIDtoLanguage(translation.language_id)] = {
                translated_text : translation.translated_text,
                question_id : translation.question_id,
                language : languageIDtoLanguage(translation.language_id)
            };

            // Add the current language to the available languages array.
            available_languages.push(languageIDtoLanguage(translation.language_id));

            // Debugging: Log the current translation object.
            console.log("Processing translation:", translation);
        });

        // Add the default language translation (original question) to the translations object.
        translations["default"] = {
            translated_text : question.question_text,
            question_id : question.id,
            language : "default"
        };

        // Push the processed question along with its translations into the ret array.
        // This includes the question ID, original question text, processed options,
        // and all translations.
        ret.push({
            id: question.id,
            question: question.question_text,
            answers: processOptions(question.options), // Assumes processOptions is a function defined elsewhere.
            translations: translations
        });

        // Debugging: Log the processed question object.
        console.log("Processed question:", question);
    });

    // Return the array containing all processed questions.
    return ret;
}

// Debugging: Call getQuestions and log the output to verify its functioning.
console.log("Output of getQuestions:", getQuestions());

function languageIDtoLanguage(id){
    for(var i = 0; i < LANGUAGES.length; i++){
        var language = LANGUAGES[i];
        if(language.id == id){
            return language.name;
        }
    }
    return undefined;
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
    color = is_correct == 1 ? "green" : "grey";
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
    console.log(question);
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



</script>
