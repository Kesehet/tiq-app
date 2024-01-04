<div class="w3-container">
    <h2>Create Quiz</h2>

    <form class="w3-container w3-card-4 w3-padding" action="{{ route('quizzes.store') }}" method="POST">
        @csrf <!-- CSRF token for security -->

        <p>
            <label>Title</label>
            <input class="w3-input" type="text" name="title" required>
        </p>
        <p>
            <label>Description</label>
            <textarea class="w3-input" name="description" required></textarea>
        </p>

        <div id="questions-container">
            <!-- Questions will be added here -->
        </div>

        <p><button type="button" onclick="addQuestion()">Add Question</button></p>
        <p><button class="w3-button w3-blue" type="submit">Create Quiz</button></p>
    </form>
</div>

<script>
    function addQuestion() {
        const container = document.getElementById('questions-container');
        const questionNumber = container.children.length + 1;
        const questionDiv = document.createElement('div');
        questionDiv.className = 'w3-margin-top';
        questionDiv.innerHTML = `
            <label>Question ` + questionNumber + `</label>
            <input class="w3-input" type="text" name="questions[` + questionNumber + `][text]" required>
            <div id="options-container-` + questionNumber + `">
                <!-- Options will be added here -->
            </div>
            <button type="button" onclick="addOption(` + questionNumber + `)">Add Option</button>
        `;
        container.appendChild(questionDiv);
    }

    function addOption(questionNumber) {
        const container = document.getElementById('options-container-' + questionNumber);
        const optionNumber = container.children.length + 1;
        const optionDiv = document.createElement('div');
        optionDiv.className = 'w3-margin-top';
        optionDiv.innerHTML = `
            <label>Option ` + optionNumber + `</label>
            <input class="w3-input" type="text" name="questions[` + questionNumber + `][options][` + optionNumber + `]" required>
        `;
        container.appendChild(optionDiv);
    }
</script>

