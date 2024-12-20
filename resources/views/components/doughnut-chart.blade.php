<div class="size-full max-h-[60vh] pb-4">
    <canvas id="doughnutChartCanvas" class="size-full"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('doughnutChartCanvas').getContext('2d');
        const labels = @json($labels);
        const value = @json($value);

        const doughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Data',
                    data: value,
                    backgroundColor: [
                        '#008d8c',
                        '#0091b6',
                        '#2d8fd6',
                        '#9381db',
                        '#da6dbc',
                        '#ff6384'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    tooltip: {
                        enabled: true
                    }
                },
                cutout: '60%'
            }
        });
    });
</script>
