


<div class="w3-card-4">
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
