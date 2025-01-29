$(document).ready(function () {
    sahowchart();
    sahowchart(chartinboundoutbound, 600000);
});

$('input[data-name="date"]').datepicker({
    format: "yyyy-mm-dd",
    viewMode: "days",
    minViewMode: "days",
    autoclose: true
});


$('[data-name="save_data"]').on('click', function () {
    var activity = $('[data-name="activity"]').val();
    var date = $('[data-name="date"]').val();
    var value = $('[data-name="value"]').val();

    // console.log(activity, date, value);

    if(activity == '' || date == '' || value == ''){
        Swal.fire({
            position: 'center',
            title: 'Action Not Valid!',
            icon: 'warning',
            showConfirmButton: true,
            // timer: 1500
        }).then((data) => {
        })
    }else{
        $.ajax({
            url: 'save_data',
            type: 'POST',
            data: {
                activity: activity,
                date: date,
                value: value
            },
            success: function (response) {
                // console.log(response);
                sahowchart();
                $('[data-name="activity"]').val('');
                $('[data-name="date"]').val('');
                $('[data-name="value"]').val('');
                Swal.fire({
                    position: 'center',
                    title: 'Action Success!',
                    icon: 'success',
                    showConfirmButton: true,
                    timer: 1500
                }).then((data) => {
                })
            },
            error: function (xhr) {
                console.log(xhr);
                Swal.fire({
                    position: 'center',
                    title: 'Action Not Valid!',
                    icon: 'warning',
                    showConfirmButton: true,
                    // timer: 1500
                }).then((data) => {
                })
            }
        });
    }

});

Highcharts.chart('activity_chart', {
    chart: {
        backgroundColor: 'transparent'
    },
    title: {
        text: null
    },
    subtitle: {
        text: null
    },
    xAxis: {
        categories: [],
        crosshair: true,
        accessibility: {
            description: 'Countries'
        },
    },
    yAxis: {
        min: 0,
        title: {
            text: null
        }
    },
    credits: {
        enabled: false
    },
    tooltip: {
        valueSuffix: ' Value'
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{y}',
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold',
                    color: '#000'
                }
            }
        }
    },
    series: [
        {
            name: 'Value',
            type: 'column',
            data: []
        },{
            name: 'Target',
            type: 'spline',
            data: []
        },
    ]
});

function sahowchart() {
    var chart = $('#activity_chart').highcharts();

    $.ajax({
        url: 'show_data',
        type: 'POST',
        dataType: 'json',
        success: function (response) {

            var categories = response.monthlyData.map(data => data.month);
            var values = response.monthlyData.map(data => data.value);
            var targets = response.monthlyData.map(data => data.target);

            chart.xAxis[0].setCategories(categories);
            chart.series[0].setData(values);
            chart.series[1].setData(targets);
            chart.setTitle({ text: `Monthly Data for ${response.year}` });

            // console.log(values);
        },
        error: function (xhr, status, error) {
            var message = JSON.stringify(xhr);
            console.log(message);
        }
    });
}
