<div class="w3-container">
    <h2>Questions</h2>

    <!-- Add Question Button -->
    <div class="w3-row w3-margin-bottom">
        <a href="{{ route('dashboard.question.create') }}" class="w3-button w3-round w3-right w3-green"><i class="fa fa-plus"></i> Add New Question</a>
    </div>

    <!-- List of Questions -->
    <div class="w3-row-padding w3-margin-top">
        @foreach($questions as $question)
            <div class="w3-col s12 m6 l4 w3-margin-bottom">
                <div class="w3-card">
                    <header class="w3-container w3-light-grey">
                        <h3>{{ $question->text }}</h3>
                    </header>
                    <div class="w3-container">
                        <!-- Add question details here -->
                        <hr>
                        <a href="{{ route('dashboard.question.edit', $question->id) }}" class="w3-button w3-block w3-blue w3-margin-bottom">Edit</a>
                        <button onclick="confirmDelete({{ $question->id }})" class="w3-button w3-block w3-red">Delete</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function confirmDelete(questionId) {
        // Implement delete confirmation logic here
    }
</script>
