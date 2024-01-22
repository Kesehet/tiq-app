<h1> Create Quiz </h1>


<div class="globalVariables w3-hide">
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    <input type="hidden" name="quiz_id" value="">
</div>


<div class="forms w3-card-4 w3-padding w3-round-xlarge w3-small">
    <div class="w3-container w3-padding quiz" action="#" method="POST">
        
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <div class="w3-row w3-padding">
            <label for="quiz_name">Quiz Name</label>
            <input type="text" id="quiz_name" class="w3-input" name="quiz_name" value="" placeholder="Please enter the name of the Quiz">
        </div>
        <div class="w3-row w3-padding">
            <label for="quiz_description">Quiz Description</label>
            <input type="text" id="quiz_description" class="w3-input" name="quiz_description" value="" placeholder="Please enter the description of the Quiz">
        </div>
        <div class="w3-row w3-padding">
            <label for="quiz_name">Quiz Featured Image</label>
            <input type="text" id="quiz_featured_image" class="w3-input" name="quiz_featured_image" value="" placeholder="Please enter the featured image of the Quiz">
        </div>

        <div class="w3-row w3-padding">
            <div class="w3-col s6 l6 m6">
                <label for="quiz_preference_can_change_answers">Can Change Answers ?</label>
                <input type="checkbox" id="quiz_preference_can_change_answers" class="w3-input" name="quiz_preference_can_change_answers" value="">
            </div>
            <div class="w3-col s6 l6 m6">
                <label for="quiz_preference_show_answers">Show Answers ?</label>
                <input type="checkbox" id="quiz_preference_show_answers" class="w3-input" name="quiz_preference_show_answers" value="">
            </div>
        </div>
    </div>




    <div class="w3-container" id="questions"></div>



    <div class="w3-row w3-padding">
        <button class="w3-button w3-feature w3-right" onclick="addQuestion(document.getElementById('questions'))">Add Question</button>
        <input type="button" onclick="submitTheQuiz()" class="w3-button w3-feature" value="Create Quiz">
    </div>  
    
    

</div>


<script>

    

    var QUIZ = {
        name: () => document.getElementById("quiz_name").value,
        description: () => getEditorData("quiz_description"),
        featured_image: () => document.getElementById("quiz_featured_image").value,
        "preferences" : {
            can_change_answers : () => document.getElementById("quiz_preference_can_change_answers").checked,
            show_answers : () => document.getElementById("quiz_preference_show_answers").checked,
        },
        "questions" : []
    };




    var QuizForm = document.getElementsByClassName("quiz")[0];
    QuizForm.addEventListener("submit", function (e) {
        e.preventDefault();
    });

    function addQuestion(that){
        questionBox(that);
    }

    LANGUAGES = @json($languages);
    EDITORS = {};
    EDITORS["quiz_description"] = CKEDITOR.replace("quiz_description");

    function questionBox(mainContainer){
        let r = (Math.random() + 1).toString(36).substring(7);
        QUIZ.questions.push({
            "id": r,
            "text": () => getEditorData(`${r}_question_text`),
            "languages": ()=>{
                var ret = [];
                
                for(var i = 0; i < LANGUAGES.length; i++){
                    let lang = LANGUAGES[i];                        
                    if(document.getElementById(`${r}_question_text_${lang.id}`)){
                        lang.text = ()=>document.getElementById(`${r}_question_text_${lang.id}`).value;
                        ret.push(lang);
                    }
                }
                return ret;
            },
            "options":[]
        });

        let questionDiv = document.createElement("div");
        questionDiv.id = `${r}_box`;
        questionDiv.className = "question w3-animate-left w3-margin-top w3-card-4 w3-padding w3-round-large";

        let questionInputContainer = document.createElement("div");
        questionInputContainer.className = "w3-row w3-padding";

        let questionLabel = document.createElement("label");
        questionLabel.for = `${r}_question_text`;
        questionLabel.textContent = "Question";

        

        let questionInput = document.createElement("textarea");
        questionInput.id = `${r}_question_text`;
        questionInput.type = "text";
        questionInput.className = "w3-input";
        questionInput.name = "question_text";
        questionInput.placeholder = "Please enter the question";
        questionInput.onchange = function(){
            document.getElementById(`${r}_question_text_display`).innerHTML = getEditorData(`${r}_question_text`);          
        }

        questionInputContainer.appendChild(questionLabel);
        questionInputContainer.appendChild(questionInput);
        questionDiv.appendChild(questionInputContainer);

        for(var i = 0; i < LANGUAGES.length; i++){
            let lang = LANGUAGES[i];
            let langDiv = document.createElement("div");
            langDiv.className = "w3-row w3-padding";

            let langLabel = document.createElement("label");
            langLabel.for = `${r}_question_text_${LANGUAGES[i].id}_label`;
            langLabel.textContent = "Question " + LANGUAGES[i].name;

            let langInput = document.createElement("textarea");
            langInput.id = `${r}_question_text_${LANGUAGES[i].id}`;
            langInput.type = "text";
            langInput.className = "w3-input";
            langInput.name = `question_text_${LANGUAGES[i].id}`;
            langInput.placeholder = "Please enter the question";
            langInput.onchange = function(){
                document.getElementById(`${r}_question_text_${lang.id}_display`).innerHTML = this.value;
            }

            langDiv.appendChild(langLabel);
            langDiv.appendChild(langInput);
            questionDiv.appendChild(langDiv);
        }

        let optionsDiv = document.createElement("div");
        optionsDiv.id = `${r}_options`;
        optionsDiv.className = "w3-row w3-padding";

        questionDiv.appendChild(optionsDiv);

        let optionButton = document.createElement("button");
        optionButton.className = "w3-button w3-feature w3-right";
        optionButton.textContent = "Add Option";
        optionButton.onclick = function(){
            addOption(r);
        }

        questionDiv.appendChild(optionButton);

        let deleteButton = document.createElement("button");
        deleteButton.className = "w3-button w3-feature";
        deleteButton.textContent = "Delete Question";
        deleteButton.onclick = function(){
            document.getElementById(`${r}_box`).remove();
            document.getElementById(`${r}_display_all`).style.display = "none";
            deleteQuestionFromQuiz(r);
        }

        questionDiv.appendChild(deleteButton);

        let saveButton = document.createElement("button");
        saveButton.className = "w3-button w3-feature ";
        saveButton.textContent = "Save Question";
        saveButton.onclick = function(){
            switchQuestionsDisplay(document.getElementById(`${r}_box`), document.getElementById(`${r}_display_all`));
            document.getElementById(`${r}_question_text_display`).innerHTML = getEditorData(`${r}_question_text`);
        }

        questionDiv.appendChild(saveButton);

        

        // DISPLAY STARTS HERE _____________________________


        let displayDiv = document.createElement("div");
        displayDiv.id = `${r}_display_all`;
        displayDiv.className = "question w3-card-4 w3-animate-bottom w3-padding w3-margin-top w3-round-large ";
        displayDiv.style.display = "none";


        let displayInputDiv = document.createElement("div");
        displayInputDiv.className = "w3-row w3-padding";

        let displayLabel = document.createElement("label");
        displayLabel.for = `${r}_question_text`;
        displayLabel.textContent = "Question";

        let displayText = document.createElement("div");
        displayText.id = `${r}_question_text_display`;
        displayText.className = "w3-large w3-white w3-padding-large w3-round-xlarge";

        let editButton = document.createElement("button");
        editButton.className = "w3-button w3-feature";
        editButton.textContent = "Edit";
        editButton.onclick = function(){
            switchQuestionsDisplay(document.getElementById(`${r}_box`), document.getElementById(`${r}_display_all`));
        }


        

        displayInputDiv.appendChild(displayLabel);
        displayInputDiv.appendChild(displayText);
        displayDiv.appendChild(displayInputDiv);

        for(var i = 0; i < LANGUAGES.length; i++){
            let langDiv = document.createElement("div");
            langDiv.className = "w3-row w3-padding";

            let label = document.createElement("label");
            label.for = `${r}_question_text_${LANGUAGES[i].id}`;
            label.textContent = "Question " + LANGUAGES[i].name;

            
            let lang = LANGUAGES[i];
            let displayLangInput = document.createElement("div");
            displayLangInput.id = `${r}_question_text_${lang.id}_display`;
            displayLangInput.className = "w3-large w3-white w3-padding-large w3-round-xlarge";

            langDiv.appendChild(label);
            langDiv.appendChild(displayLangInput);
            displayInputDiv.appendChild(langDiv);

        }

        let optionsDisplayDiv = document.createElement("div");
        optionsDisplayDiv.id = `${r}_options_display`;
        optionsDisplayDiv.className = "w3-row w3-padding";

        displayDiv.appendChild(optionsDisplayDiv);
        displayDiv.appendChild(editButton);

        mainContainer.appendChild(questionDiv);
        mainContainer.appendChild(displayDiv);

        EDITORS[r+'_question_text'] = CKEDITOR.replace( r+'_question_text' );
        
    }

    function addOption(question_r){
        optionBox(question_r);
        return;
    }


    function optionBox(question_r){

        let r = (Math.random() + 1).toString(36).substring(7);


        getQuestionFromQuiz(question_r).options.push({
            id: r,
            text: ()=>document.getElementById(`${r}_option_text`).value,
            "languages": ()=>{
                let ret = [];
                for (var i = 0; i < LANGUAGES.length; i++){
                    let lang = LANGUAGES[i];
                    lang.text = ()=>document.getElementById(`${r}_option_text_${lang.id}`).value;
                    ret.push(lang);
                }

                return ret;

            },
            "is_correct": ()=>document.getElementById(`${r}_is_correct`).checked,
            "score": ()=>document.getElementById(`${r}_score`).value,
        });
        
        if(document.getElementById(question_r + "_options") == null){
            return;
        }

        let optionsContainer = document.getElementById(question_r + "_options");
        let displayContainer = document.getElementById(question_r + "_options_display");

        

        let optionDiv = document.createElement("div");
        optionDiv.id = `${r}_box`;
        optionDiv.className = "w3-row w3-border w3-col s12 l6 m12 w3-padding w3-animate-top w3-margin-top w3-round-large";

        let inputDiv = document.createElement("div");
        inputDiv.className = "w3-row w3-padding";

        let label = document.createElement("label");
        label.for = "option_text";
        label.textContent = "Option";

        let input = document.createElement("textarea");
        input.id = `${r}_option_text`;
        input.type = "text";
        input.className = "w3-input";
        input.name = "option_text";
        input.value = "";
        input.onchange = function () {
            document.getElementById(`${r}_option_text_display`).innerHTML = this.value;
        }

        let scoreAndIsCorrectDiv = document.createElement("div");
        scoreAndIsCorrectDiv.className = "w3-row w3-padding";


        // add a checkbox called is Correct and label
        let isCorrectLabel = document.createElement("label");
        isCorrectLabel.for = `${r}_is_correct`;
        isCorrectLabel.className = "w3-col l6 m6 s6";
        isCorrectLabel.textContent = "Is Correct?";

        let checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.className = "w3-input w3-green";
        checkbox.name = "is_correct";
        checkbox.id = `${r}_is_correct`;
        checkbox.onchange = function () {
            document.getElementById(`${r}_is_correct`).innerHTML = document.getElementById(`${r}_is_correct`).checked;
            if(document.getElementById(`${r}_is_correct`).checked){
                document.getElementById(`${r}_score`).value = 1;
                document.getElementById(`${r}_score`).style.display = "block";
                document.getElementById(`${r}_score_display`).innerHTML = document.getElementById(`${r}_score`).value;
                document.getElementById(`${r}_score_display`).style.display = "block";
                document.getElementById(`${r}_score_label`).style.display = "block";
            }
            else{
                document.getElementById(`${r}_score`).value = 0;
                document.getElementById(`${r}_score`).style.display = "none";
                document.getElementById(`${r}_score_label`).style.display = "none";
                document.getElementById(`${r}_score_display`).style.display = "none";
            }
        }

        // add a input for score with a label
        let scoreLabel = document.createElement("label");
        scoreLabel.for = `${r}_score`;
        scoreLabel.id = `${r}_score_label`;
        scoreLabel.className = "w3-col l6 m6 s6";
        scoreLabel.textContent = "Score";

        let score = document.createElement("input");
        score.type = "number";
        score.className = "w3-input ";
        score.name = "score";
        score.id = `${r}_score`;
        score.style.display = "none";
        score.onchange = function () {
            document.getElementById(`${r}_score_display`).innerHTML = `<b>Score: ${this.value} </b>`;
            if(this.value > 0){
                document.getElementById(`${r}_is_correct`).checked = true;
            }
            else{
                document.getElementById(`${r}_is_correct`).checked = false;
            }
        }



        inputDiv.appendChild(label);
        inputDiv.appendChild(input);
        isCorrectLabel.appendChild(checkbox);
        
        scoreAndIsCorrectDiv.appendChild(isCorrectLabel);
        
        scoreLabel.appendChild(score);
        scoreAndIsCorrectDiv.appendChild(scoreLabel);
        
        
        optionDiv.appendChild(inputDiv);
        optionDiv.appendChild(scoreAndIsCorrectDiv);

        for(var i = 0; i < LANGUAGES.length; i++){
            let langDiv = document.createElement("div");
            let lang = LANGUAGES[i];

            langDiv.className = "w3-row w3-padding " + lang.font;

            

            let label = document.createElement("label");
            label.for = `${r}_option_text_${lang.id}`;
            label.textContent = "Option " + lang.name;


            let langInput = document.createElement("textarea");
            langInput.id = `${r}_option_text_${lang.id}`;
            langInput.type = "text";
            langInput.className = "w3-input";
            langInput.name = `option_text_${lang.id}`;
            langInput.value = "";
            langInput.onchange = function () {
                document.getElementById(`${r}_option_text_${lang.id}_display`).innerHTML = document.getElementById(`${r}_option_text_${lang.id}`).value;
            }

            langDiv.appendChild(label);
            langDiv.appendChild(langInput);
            optionDiv.appendChild(langDiv);
        }

        
        let button = document.createElement("button");
        button.className = "w3-button w3-feature w3-right";
        button.textContent = "Remove Option";
        button.onclick = function () {
            document.getElementById(`${r}_box`).remove();
            document.getElementById(`${r}_display`).remove();
            deleteOptionFromQuestion(question_r,r);
        }

        optionDiv.appendChild(button);
        optionsContainer.appendChild(optionDiv);


        // Display Options 

        let displayDiv = document.createElement("div");
        displayDiv.id = `${r}_display`;
        displayDiv.className = "w3-row w3-padding w3-card w3-col l4 m6 s12 w3-round-xxlarge w3-animate-zoom w3-margin-top w3-border-bottom";

        let displayInputDiv = document.createElement("div");
        displayInputDiv.className = "w3-row w3-padding";

        let displayLabel = document.createElement("label");
        displayLabel.for = "option_text";
        displayLabel.textContent = "Option";

        let displayInput = document.createElement("div");
        displayInput.id = `${r}_option_text_display`;
        displayInput.className = "w3-large w3-whit w3-animate-left w3-padding-large w3-round-xlarge";

        
        displayInputDiv.appendChild(displayLabel);
        displayInputDiv.appendChild(displayInput);
        displayDiv.appendChild(displayInputDiv);


        for(var i = 0; i < LANGUAGES.length; i++){
            let langDiv = document.createElement("div");
            let lang = LANGUAGES[i];
            langDiv.className = "w3-row w3-padding "+ LANGUAGES[i].font;

            let displayLangLabel = document.createElement("label");
            displayLangLabel.for = `${r}_option_text_${lang.id}`;
            displayLangLabel.textContent = lang.name;

            let displayLangInput = document.createElement("div");
            displayLangInput.id = `${r}_option_text_${lang.id}_display`;
            displayLangInput.className = "w3-large w3-white w3-padding-large w3-round-xlarge "+lang.font;

            langDiv.appendChild(displayLangLabel);
            langDiv.appendChild(displayLangInput);            
            displayInputDiv.appendChild(langDiv);
        }

        // Show the score input
        let scoreNowDiv = document.createElement("div");
        scoreNowDiv.className = "w3-row w3-large w3-padding w3-text-green";
        scoreNowDiv.id = `${r}_score_display`;

        displayDiv.appendChild(scoreNowDiv);



        displayContainer.appendChild(displayDiv);

    }

    function setEditorData(id){
        EDITORS[id].setData(getEditorData(id));
    }

    function getEditorData(id){
        return EDITORS[id].getData();
    }

    function switchQuestionsDisplay(item1, item2){
        if(item1.style.display == 'none'){
         item1.style.display = 'block';
         item2.style.display = 'none';   
        }
        else{
            item1.style.display = 'none';
            item2.style.display = 'block';
        }
    }


    function getQuestionFromQuiz(question_id){
        for(var i=0; i<QUIZ.questions.length; i++){
            if(QUIZ.questions[i].id == question_id){
                return QUIZ.questions[i];
            }
        } 
    }

    function deleteQuestionFromQuiz(question_id) {
        QUIZ.questions = QUIZ.questions.filter(question => question.id !== question_id);
    }

    function deleteOptionFromQuestion(question_id, option_id){
        let question = getQuestionFromQuiz(question_id);
        question.options = question.options.filter(option => option.id !== option_id);
    }


    function submitTheQuiz(){


        if(QUIZ.questions.length == 0){
            // Ask for confirmation from user else cancel
            var decided = confirm('You have no questions. Do you want to continue?') ? "" : "cancel";
            if(decided == "cancel") return;
        }

        

        final_quiz = {
            'name': QUIZ.name(),
            'description': QUIZ.description(),
            'can_change_answer': QUIZ.preferences.can_change_answers(),
            'show_answers': QUIZ.preferences.show_answers(),
            'featured_image': QUIZ.featured_image(),
            'questions': []
        };
        
        

        QUIZ.questions.forEach(question => {

        
            
            var languages = [];
            question.languages().forEach(lang => {
                languages.push({
                    'id': lang.id,
                    'name': lang.name,
                    'text': lang.text()
                });
            })
            var options = [];
            question.options.forEach(option => {

        

                var option_languages = [];
                option.languages().forEach(lang => {
                    option_languages.push({
                        'id': lang.id,
                        'name': lang.name,
                        'text': lang.text(),
                    })
                })
                options.push({
                    'id': option.id,
                    'text': option.text(),
                    'is_correct': option.is_correct(),
                    'score': option.score() ? option.score() : 0,
                    'languages': option_languages,
                })
            })
            
            

            final_quiz.questions.push({
                'question_text': question.text(),
                "languages": languages,
                "options": options,
            })
        })


        fetch("{{route('dashboard.question.combo.store')}}", {
            'method': 'POST',
            'headers': {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'  // Add this line
            },
            'body': JSON.stringify(final_quiz)
        }).then(response => response.json()).then(data => {
            
            console.log(data);
            window.location.href = "{{route('home')}}";
        }).catch(error => {
            console.error('Error:', error);
        })
    }


</script>



