
<div class="w3-container">
    <h2>{{ $quiz_selected ? 'Edit' : 'New' }} Question</h2>

    <form class="w3-container w3-card-4 w3-padding" action="{{ route('dashboard.question.store') }}" method="POST">
        @csrf <!-- CSRF token for security -->
        <p>
            <label>Quiz</label>
            <select class="w3-select" name="quiz_id">
                @foreach($quizzes as $quiz)
                    <option class="w3-select" {{($quiz_selected->id ?? 0) == $quiz->id ? 'selected' : ''}} value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                @endforeach
            </select>
        </p>
        <p >
            <label>Title</label>
            <textarea id='question_text_{{ $quiz->id }}' class="w3-input" type="text" name="question_text"  required>
            {{ $question_selected->question_text ?? '' }}
            </textarea>
            <script>
                CKEDITOR.replace('question_text_{{ $quiz->id }}');
            </script>
        </p>
        
        <p>
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="add_option" value="0">
            <input type="hidden" name="question_id" value="{{ $question_selected->id ?? '' }}">
        </p>
        <hr/>
        @foreach ($languages as $language)
            <p>
                <label>{{ $language->name }} Question</label>
                <input class="w3-input" type="text" name="question_text_{{ $language->id }}" value="{{ $translations->where('question_id', $question_selected->id ?? 0)->where('language_id', $language->id)->first()->translated_text ?? '' }}" required>
            </p>
        @endforeach

        <p>
            <button class="w3-button w3-feature w3-right w3-round" type="submit">{{ $quiz_selected ? 'Update' : 'New' }} Question</button>
            
        </p>

    </form>
</div>
