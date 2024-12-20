<div class="size-full max-h-[60vh] pb-4">
    <canvas id="lineChartCanvas" class="size-full"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('lineChartCanvas').getContext('2d');
        const labels = @json($labels);
        const value = @json($value);

        const gradientFill = ctx.createLinearGradient(0, 0, 0, 400); // Adjust the height as needed
        gradientFill.addColorStop(0, 'rgba(0, 150, 136, 0.4)'); // Darker teal with 0.6 opacity
        gradientFill.addColorStop(1, 'rgba(0, 150, 136, 0)');   // Transparent end color

        const lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Data',
                    data: value,
                    fill: true,
                    backgroundColor: gradientFill,
                    //line
                    borderColor: 'rgba(0, 150, 136, 1)',
                    borderWidth: 2,

                    //point
                    pointBackgroundColor: '#fff',
                    pointBorderColor: 'rgba(0, 150, 136, 1)', // Hollow circle border color
                    pointBorderWidth: 3,
                    pointRadius: 5, // Adjust the size of the circles
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Hides the legend and thus the series label
                    }
                },
                scales: {
                    x: {
                        display: true,
                        // title: {
                        //     display: true,
                        //     text: 'X-axis Label'
                        // },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        display: true,
                        // title: {
                        //     display: true,
                        //     text: 'Y-axis Label'
                        // },
                        grid: {
                            display: true
                        }
                    }
                }
            }
        });
    });
</script>
