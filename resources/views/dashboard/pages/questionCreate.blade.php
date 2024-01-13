<div class="w3-container">
    <h2>Create Question</h2>

    <form class="w3-container w3-card-4 w3-padding" action="{{ route('dashboard.question.store') }}" method="POST">
        @csrf <!-- CSRF token for security -->
        <p>
            <label>Quiz</label>
            <select class="w3-select" name="quiz_id">
                @foreach($quizzes as $quiz)
                    <option class="w3-select" {{$quiz_selected->id == $quiz->id ? 'selected' : ''}} value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                @endforeach
            </select>
        </p>
        <p >
            <label>Title</label>
            <input class="w3-input" type="text" name="question_text" required>
        </p>
        
        <p>
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="add_option" value="0">
            <input type="hidden" name="quiz_id" value="{{ $quiz_selected->id }}">
        </p>
        <hr/>
        @foreach ($languages as $language)
            <p>
                <label>{{ $language->name }} Text</label>
                <input class="w3-input" type="text" name="question_text_{{ $language->id }}">
            </p>
        @endforeach

        <p>
            <button class="w3-button w3-feature w3-left" type="submit">Create Question</button>
            <button class="w3-button w3-green w3-right"  type="button" onclick="this.form.add_question.value=1;this.form.submit();"><i class="fa fa-plus"></i> Add Options</button>
        </p>

    </form>
</div>
