<script type="text/javascript">

$(function () {
    $('#container').highcharts({
        chart: {
            type: 'scatter',
            zoomType: 'xy'
        },
        title: {
            text: 'Grad Students enrolled by Year'
        },
        xAxis: {
            title: {
                text: 'Year'
            },
            startOnTick: true,
            endOnTick: true,
            showLastLabel: true
        },
        yAxis: {
            title: {
                text: 'Number Enrolled'
            }
        },
        plotOptions: {
            scatter: {
                marker: {
                    radius: 5,
                    states: {
                        hover: {
                            enabled: true,
                            lineColor: 'rgb(100,100,100)'
                        }
                    }
                },
                states: {
                    hover: {
                        marker: {
                            enabled: false
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                    pointFormat: '{point.x}, {point.y}'
                }
            }
        },
        series: [{
            name: 'Number Admitted',
            color: 'rgba(223, 83, 83, .5)',
            data: <?= $json; ?>
        }], 
    });
});

</script>

<div id="container" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>
