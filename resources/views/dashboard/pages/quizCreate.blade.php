<div class="w3-container">
    <h2>{{ $quizTitle != '' ? 'Update' : 'Create' }} Quiz</h2>

    <form class="w3-container w3-card-4 w3-padding" action="{{ route('dashboard.quiz.store') }}" method="POST">
        @csrf <!-- CSRF token for security -->

        <p class=>
            <label>Title</label>
            <input class="w3-input" type="text" name="title" value="{{ $quizTitle }}" required>
        </p>
        <p>
            <label>Description</label>
            <textarea id='question_text' class="w3-input" name="description" required>{{$quizDescription}}</textarea>
            <script>
                CKEDITOR.replace('question_text');
            </script>
        </p>
        <p>
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="quiz_id" value="{{ $quiz_id }}">
            <input type="hidden" name="add_question" value="0">
        </p>
        <p>
            <button class="w3-button w3-feature w3-right" type="submit">{{ $quizTitle != '' ? 'Update' : 'Create' }} Quiz</button>
        </p>
    </form>
</div>
