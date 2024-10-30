<div id="barChart"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('/product-category-data')
            .then(response => response.json())
            .then(data => {
                const categories = data.map(item => item.category);
                const counts = data.map(item => item.count);

                var options = {
                    series: [{
                        name: 'Products',
                        data: counts
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        fontFamily: "Plus Jakarta Sans', sans-serif",
                        stacked: true,
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,      //true create chart horizontal
                            columnWidth: '30%',
                            borderRadius: 10,
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: categories,
                        title: {
                            text: 'Categories'
                        }
                    },
                    yaxis: {
                        tickAmount: 4,
                        title: {
                            text: 'Product Count'
                        }
                    },
                    // fill: {
                    //     opacity: 1
                    // },
                    tooltip: {
                        theme: "dark",
                        y: {
                            formatter: function (val) {
                                return val;
                            }
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#barChart"), options);
                chart.render();
                // chart.updateOptions({
                //     series: [{
                //         name: 'Products',
                //         data: counts
                //     }],
                // });
            })
            .catch(error => console.error('Error fetching data:', error));
    });
</script>
