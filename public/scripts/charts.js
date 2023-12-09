    // Function to create a chart
    function createChart(canvasId, chartType, chartData, chartOptions) {
        let canvas = document.getElementById(canvasId);
        const ctx = canvas.getContext('2d');
        canvas.style.display = 'inline-block';
        canvas.style.width = '50vw';

        return new Chart(ctx, {
            type: chartType,
            data: chartData,
            options: chartOptions
        });
    }