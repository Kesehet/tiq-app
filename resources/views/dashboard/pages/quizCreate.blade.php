<div class="w3-container">
    <h2>Create Quiz</h2>

    <form class="w3-container w3-card-4 w3-padding" action="{{ route('dashboard.quiz.store') }}" method="POST">
        @csrf <!-- CSRF token for security -->

        <p class=>
            <label>Title</label>
            <input class="w3-input" type="text" name="title" required>
        </p>
        <p>
            <label>Description</label>
            <textarea class="w3-input" name="description" required></textarea>
        </p>
        <p>
            <button class="w3-button w3-feature w3-left" type="submit">Create Quiz</button>
            <button class="w3-button w3-green w3-right " type="submit">Add Questions</button>
        </p>
    </form>
</div>
