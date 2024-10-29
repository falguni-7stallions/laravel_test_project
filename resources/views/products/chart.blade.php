<div id="pieChart"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('/product-category-data')
            .then(response => response.json())
            .then(data => {
                const categories = data.map(item => item.category);
                const counts = data.map(item => item.count);

                var options = {
                    series: counts,
                    labels: categories,
                    chart: {
                        type: 'pie',
                        height: 350,
                        fontFamily: "Plus Jakarta Sans', sans-serif",
                        fontSize: '20px',
                    },
                    stroke: {
                        show: false,
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function (val, opts) {
                            return opts.w.config.series[opts.seriesIndex] + ' Products';
                        },
                        offsetY: '100px',
                        style: {
                            fontSize: '15px',
                            fontFamily: "Plus Jakarta Sans', sans-serif",
                        },
                    },

                    legend: {
                        position: 'left',
                        style:{
                            top: '315px',
                        },
                        offsetY: '300px',
                        background: 'transparent',
                        formatter: function(val, opt) {
                            return counts ? val +" - "+ opt.w.globals.initialSeries[opt.seriesIndex] : val +" - "+ 0
                        },
                        onItemHover: {
                            highlightDataSeries: false,
                        },
                    },
                    tooltip: {
                        theme: "dark",
                        fillSeriesColor: false,
                    },
                };

                var chart = new ApexCharts(document.querySelector("#pieChart"), options);
                chart.render();
            })
            .catch(error => console.error('Error fetching data:', error));
    });
</script>
