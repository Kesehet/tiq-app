<div class="w3-container">
    <h2>Quizzes</h2>
    <div class="w3-row w3-margin-bottom">
        <a href="{{ route('dashboard.question.combo') }}" class="w3-button w3-round w3-right w3-feature"><i class="fa fa-plus"></i> Add New Quiz</a>
    </div>

    <!-- Search Form -->
    <form action="" method="GET" class="w3-row w3-margin-bottom">
        <div class="w3-col s8 m10 l10">
            <input class="w3-input w3-border" type="text" placeholder="Search for quizzes..." name="q">
        </div>
        <div class="w3-col s4 m2 l2">
            <button  class="w3-button w3-block w3-feature" type="submit" >Search</button>
        </div>
    </form>
</div>


@foreach($quizzes as $quiz)
<div class="w3-col s12 m6 l4 w3-margin-bottom">
    <div class="w3-card w3-hover-shadow w3-round-large">

        <header class="w3-container w3-light-grey">
            <h3 class="w3-margin w3-padding-16">{{ $quiz->title }}</h3>
        </header>
        <div class="w3-container">
            <p>{!! $quiz->description !!}</p>
        </div>

        <footer class="w3-container">
            <button onclick = "location.href='{{route('dashboard.quiz.create', ['quiz_id' => $quiz->id])}}'" class="w3-button w3-right w3-feature w3-margin w3-round">Edit</button>
            <button onclick = "deleteQuiz({{ $quiz->id }})" class="w3-button w3-left w3-red w3-margin w3-round">Delete</button>
        </footer>

        <div id="deleteQuiz_{{ $quiz->id }}" class="w3-modal w3-hide"  >
            <div class="w3-modal-content w3-card-4 w3-animate-top">
                <header class="w3-container w3-red">
                    <span onclick="deleteQuiz({{ $quiz->id }})" class="w3-button w3-display-topright">&times;</span>
                    <h2>Delete Quiz</h2>
                </header>
                <div class="w3-container">
                    <p>Are you sure you want to delete this quiz?</p>
                </div>
                <footer class="w3-container w3-border-top w3-padding-16">
                    <button onclick="location.href='{{ route('dashboard.quiz.delete', ['id'=>$quiz->id]) }}'" class="w3-button w3-red">Delete</button>
                </footer>
            </div>
        </div>

    </div>
</div>
@endforeach



<script>
    // A function to create a dynamic overlay to prompt the user if he really wants to make the delete
    function deleteQuiz(id) {
        var element = document.getElementById('deleteQuiz_' + id);
        element.classList.toggle('w3-show');
        element.classList.toggle('w3-hide');
    }

</script>