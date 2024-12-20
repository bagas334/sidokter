<div class="size-full max-h-[60vh] pb-4">
    <canvas id="columnChartCanvas" class="size-full"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('columnChartCanvas').getContext('2d');
        const labels = @json($labels);
        const value = @json($value);

        const barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah',
                    data: value,
                    backgroundColor: 'rgba(0, 150, 136, 1)'
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        display: true,
                        grid: {
                            display: true
                        }
                    },
                    y: {
                        display: true,
                        grid: {
                            display: false
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
