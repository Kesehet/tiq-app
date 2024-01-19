<h1> Create Quiz </h1>



<form class="w3-container w3-card-4 w3-padding quiz" action="#" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

    <label for="quiz_name">Quiz Name</label>
    <input type="text" class="w3-input" name="quiz_name" value="" placeholder="Please enter the name of the Quiz">

    <input type="submit" class="w3-button w3-feature" value="Create Quiz">

</form>



<script>
    var QuizForm = document.getElementsByClassName("quiz")[0];
    QuizForm.addEventListener("submit", function (e) {
        e.preventDefault();
        inputs = QuizForm.getElementsByTagName("input");
        var data = {};
        for (var i = 0; i < inputs.length; i++) {
            data[inputs[i].name] = inputs[i].value;
        }
        console.log(data);
    })
</script>
