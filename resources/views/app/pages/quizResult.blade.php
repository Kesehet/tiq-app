


<div class="w3-card-4 w3-round-large">
    <div class="w3-col s12 l6 m6 w3-center">
        <canvas id="resultsChart" ></canvas>
    </div>
    <div class="w3-col s12 l6 m6">
        <p><strong>Total Questions:</strong> {{ $totalQuestions }}</p>
        <p><strong>Correct Answers:</strong> {{ $correctAnswers }}</p>
        <p><strong>Your Score:</strong> {{ $totalScore }}</p>
        <hr/>
    </div>


    <div class="w3-col s12 l6 m6">
    @foreach ($questionsWithAnswers as $question)
    <div class="w3-col s12 l12 m12 w3-padding">
        <div class="w3-card w3-round-large">
            <div class="w3-container">
                <h2>{{ $question->title }}</h2>
                <p>{{ $question->question_text }}</p>
                @foreach ($question->options as $option)
                    <div class="w3-row w3-padding w3-border {{ $option->id == $question->answers->first()->option_id ? 'w3-light-grey' : '' }} {{ $option->is_correct ? 'w3-border-green' : '' }}">
                        <div class="w3-col l10 m10 s10">
                            {{ $option->option_text }}
                            @if ($option->is_correct)
                                <span class="w3-tag w3-green w3-round">Correct</span>
                            @endif
                        </div>
                        <div class="w3-col l2 m2 s2">
                            @if ($option->id == $question->answers->first()->option_id)
                                <span class="w3-tag w3-blue w3-round">Selected</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>


    <div class="w3-col s12 l6 m6">
        <h2>Leaderboard</h2>
        <table class="w3-table w3-striped w3-bordered">
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Score</th>
            </tr>
            @foreach ($leaderboard as $index => $user)
                @if ($index % 2 == 0)
                    <tr class="w3-animate-left">
                @else
                    <tr class="w3-animate-right">
                @endif
                    <td>{{ $index + 1 }}</td>
                    <td>{{$user['name']}}</td>
                    <td>{{ $user['total_score'] }}</td>
                </tr>
            @endforeach
        </table>

        <hr/>

    </div>



</div>



    <script>
        var ctx = document.getElementById('resultsChart').getContext('2d');
        var resultsChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Correct Answers', 'Incorrect Answers'],
                datasets: [{
                    label: 'Quiz Results',
                    data: [{{ $correctAnswers }}, {{ $totalQuestions - $correctAnswers }}],
                    backgroundColor: [
                        'rgba(0, 92, 39, 0.4)',
                        'rgba(255, 99, 132, 0.4)'
                    ],
                    borderColor: [
                        'rgba(0, 92, 39, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    </script>
