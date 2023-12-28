


<div class="w3-card-4 w3-margin w3-padding">
    
    <canvas id="resultsChart" ></canvas>
    
    <p><strong>Total Questions:</strong> {{ $totalQuestions }}</p>
    <p><strong>Correct Answers:</strong> {{ $correctAnswers }}</p>
    <p><strong>Your Score:</strong> {{ $totalScore }}</p>

    <div class="w3-card-4 w3-margin w3-padding">
        <h2>Leaderboard</h2>
        <table class="w3-table w3-striped w3-bordered">
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Score</th>
            </tr>
            @foreach ($leaderboard as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->total_score }}</td>
                </tr>
            @endforeach
        </table>
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
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
            }
        });
    </script>
