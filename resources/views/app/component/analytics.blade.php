

<div>
    <div class="w3-container header5">
        Performance
    </div>
    <div class="scroll-wrapper">
        <div class="w3-container quiz-card" style="width: 75vw;">
            <canvas class="w3-container w3-card-4 w3-round-large "  id="quizAnalyticsChart"></canvas>
        </div>
        <div class="w3-container quiz-card" style="width: 75vw;">
            <canvas class="w3-container w3-card-4 w3-round-large "  id="quizAnalyticsChart2"></canvas>
        </div>
    </div>
</div>



<script>
    let canvas = document.getElementById('quizAnalyticsChart'); 
    const ctx = canvas.getContext('2d');
    let canvas2 = document.getElementById('quizAnalyticsChart2');
    const ctx2 = canvas2.getContext('2d');
    canvas.style.display = 'inline-block';
    canvas2.style.display = 'inline-block';
    canvas.style.width = '50vw';
    canvas2.style.width = '50vw';
    
    const quizAnalyticsChart = new Chart(ctx, {
        type: 'line', // or 'line', 'pie', etc., depending on your needs
        data: {
            labels: ['Quiz 1', 'Quiz 2', 'Quiz 3'], // Replace with your quiz labels
            datasets: [{
                label: 'Scores',
                data: [12, 19, 3], // Replace with your score data
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)', // Colors for each bar
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const quizAnalyticsChart2 = new Chart(ctx2, {
        type: 'line', // or 'line', 'pie', etc., depending on your needs
        data: {
            labels: ['Quiz 1', 'Quiz 2', 'Quiz 3'], // Replace with your quiz labels
            datasets: [{
                label: 'Scores',
                data: [12, 19, 3], // Replace with your score data
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)', // Colors for each bar
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
