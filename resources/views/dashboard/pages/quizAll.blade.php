<div class="w3-container">
    <h2>Quizzes</h2>
    <div class="w3-row w3-margin-bottom">
        <a href="{{ route('dashboard.quiz.create') }}" class="w3-button w3-round w3-right w3-feature"><i class="fa fa-plus"></i> Add New Quiz</a>
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


    <!-- List of Quizzes as Cards -->
    <div class="w3-row-padding w3-margin-top">
        @foreach($quizzes as $quiz)
            <div class="w3-col s12 m6 l4 w3-margin-bottom">
                <div class="w3-card">
                    <header class="w3-container w3-light-grey">
                        <h3>{{ $quiz->title }}</h3>
                    </header>
                    <div class="w3-container">
                        <p>{{ $quiz->description }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

