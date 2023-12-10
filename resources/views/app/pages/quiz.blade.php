<!DOCTYPE html>
<html>
<head>
    <title>Quiz Page</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>

<div class="w3-container">
    <div id="question" class="w3-panel w3-border w3-padding">Question will go here</div>
    <ul class="w3-ul w3-border" id="option_holder">
        <li id="option1" class="w3-hover-light-grey">Option 1</li>
        <li id="option2" class="w3-hover-light-grey">Option 2</li>
        <li id="option3" class="w3-hover-light-grey">Option 3</li>
        <li id="option4" class="w3-hover-light-grey">Option 4</li>
    </ul>
    <button id="previous" class="w3-button w3-blue w3-margin-top" onclick="previousQuestion()"><i class="fa fa-arrow-left"></i></button>
    <button id="next" class="w3-button w3-blue w3-margin-top" onclick="nextQuestion()"><i class="fa fa-arrow-right"></i></button>
</div>


<script>
    let currentQuestionIndex = 0;
    const QUIZ = {!! json_encode($quiz->readQuizWithQuestionsAndTranslations($quiz->id)) !!}
    var ACTIVE_LANGUAGE = "default";
    
</script>

<script src="{{asset('scripts/quiz.js')}}?refresh={{random_int(1, 1000)}}"></script>


</body>
</html>
