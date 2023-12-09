<!DOCTYPE html>
<html>
<head>
    <title>Quiz Page</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>

<div class="w3-container w3-padding w3-margin">
    <div id="question" class="w3-panel w3-border w3-padding">Question will go here</div>
    <ul class="w3-ul w3-border">
        <li id="option1" class="w3-hover-light-grey">Option 1</li>
        <li id="option2" class="w3-hover-light-grey">Option 2</li>
        <li id="option3" class="w3-hover-light-grey">Option 3</li>
        <li id="option4" class="w3-hover-light-grey">Option 4</li>
    </ul>
    <button class="w3-button w3-blue w3-margin-top" onclick="previousQuestion()">Previous</button>
    <button class="w3-button w3-blue w3-margin-top" onclick="nextQuestion()">Next</button>
</div>

<script src="{{asset('scripts/quiz.js')}}"></script>
<script>
    let currentQuestionIndex = 0;
const questions = [
    { question: "What is the capital of France?", options: ["Paris", "Berlin", "Rome", "Madrid"] },
    { question: "What is 2 + 2?", options: ["3", "4", "5", "6"] },
    // Add more questions here
];
// Initialize
displayQuestion();
</script>
</body>
</html>
