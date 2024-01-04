<div class="w3-container">
    <h2>Quizzes</h2>
    <div class="w3-row w3-margin-bottom">
        <a href="{{ route('dashboard.quiz.create') }}" class="w3-button w3-round w3-right w3-green"><i class="fa fa-plus"></i> Add New Quiz</a>
    </div>

    <!-- List of Quizzes -->
    <ul class="w3-ul w3-card-4">
        @foreach($quizzes as $quiz)
            <div class="w3-container">
                {{ json_encode($quiz) }}
            </div>
        @endforeach
    </ul>
</div>
