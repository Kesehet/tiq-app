<h1> Create Quiz </h1>


<div class="globalVariables w3-hide">
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    <input type="hidden" name="quiz_id" value="">
</div>


<div class="forms  w3-card-4 w3-padding w3-round-xlarge">
    <form class="w3-container w3-padding quiz" action="#" method="POST">
        
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <div class="w3-row w3-padding">
            <label for="quiz_name">Quiz Name</label>
            <input type="text" class="w3-input" name="quiz_name" value="" placeholder="Please enter the name of the Quiz">
        </div>

    </form>
    <div class="w3-container" id="questions">
        
    </div>
    <div class="w3-row w3-padding">
        <button class="w3-button w3-feature" onclick="addQuestion(document.getElementById('questions'))">Add Question</button>
    </div>
    <div class="w3-row w3-padding">
            <input type="submit" class="w3-button w3-feature" value="Create Quiz">
        </div>    
</div>






<script>
    var QuizForm = document.getElementsByClassName("quiz")[0];
    QuizForm.addEventListener("submit", function (e) {
        e.preventDefault();
        inputs = QuizForm.getElementsByTagName("input");
        var data = {};
        for (var i = 0; i < inputs.length; i++) {
            data[inputs[i].name] = inputs[i].value;
        }
        fetch('{{ route('dashboard.quiz.store') }}', {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]'),
            },
            body: JSON.stringify(data),
        })
    });

    function addQuestion(that){
        that.innerHTML += getQuestionBox();
    }

    function getQuestionBox(){
        let r = (Math.random() + 1).toString(36).substring(7);
        return `
        <div id="${r}_box" class="question w3-card-4 w3-padding w3-round-large w3-hover-green">
            <div class="w3-row w3-padding">
                <label for="question_text">Question</label>
                <input type="text" id="${r}_question_text" onchange="document.getElementById('${r}_question_text_display').innerHTML = this.value;" class="w3-input" name="question_text" value="" placeholder="Please enter the question">
            <div/>
            <div class="w3-row w3-padding">
                <button class="w3-button w3-feature" onclick="addAnswer(this)">Add Answer</button>
                <button class="w3-button w3-feature" onclick="document.getElementById('${r}_box').remove()">Remove Question</button>
                <button class="w3-button w3-feature" onclick="document.getElementById('${r}_box').style.display = 'none'; document.getElementById('${r}_display_all').style.display = 'block';  " >Save Question</button>
            </div>
        </div>
        
        <div id="${r}_display_all" style="display: none;" class="question w3-card-4 w3-padding w3-round-large w3-hover-green">
            <p class="w3-large" id="${r}_question_text_display"></p>
            <div class="w3-row w3-padding">
                <button class="w3-button w3-feature" onclick="this.parentElement.parentElement.style.display = 'none'; document.getElementById('${r}_box').style.display = 'block';  " >Edit</button>
            </div>
        </div>
        

        `;
    }

</script>

