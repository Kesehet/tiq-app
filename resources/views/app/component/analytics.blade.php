

<div>
    <div class="w3-container header7">
        Your Performance
    </div>
    <div class="scroll-wrapper">
        <div class="w3-container scroll-card" style="width: 75vw;">
            <canvas class="w3-container w3-card-4 w3-round-large "  id="quizAnalyticsChart"></canvas>
        </div>
        <div class="w3-container scroll-card" style="width: 75vw;">
            <canvas class="w3-container w3-card-4 w3-round-large "  id="quizAnalyticsChart2"></canvas>
        </div>
    </div>
</div>


<script>


    // Data for the charts
    const chartData = {
        labels: ['Quiz 1', 'Quiz 2', 'Quiz 3'],
        datasets: [{
            label: 'Scores',
            data: [12, 19, 3],
            backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
            borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
            borderWidth: 1
        }]
    };

    const chartOptions = {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    // Create the charts
    const quizAnalyticsChart = createChart('quizAnalyticsChart', 'line', chartData, chartOptions);
    const quizAnalyticsChart2 = createChart('quizAnalyticsChart2', 'bar', chartData, chartOptions);
</script>
