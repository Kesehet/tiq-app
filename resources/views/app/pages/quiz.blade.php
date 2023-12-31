<div class="w3-container">
    <!-- Quiz Description Section -->
    <div class="w3-card w3-round w3-margin-bottom" id="title-screen">
        <div class="w3-container w3-padding">
            <h2>{{ $quiz->title }}</h2>
            <p>{{ $quiz->description }}</p>
            <button class="w3-button w3-green w3-margin-top" onclick="startQuiz()">Start Quiz</button>
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

<script src="{{ asset('scripts/quiz.js') }}?refresh={{ random_int(1, 1000) }}"></script>
