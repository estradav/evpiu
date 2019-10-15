$(document).ready(function() {
    $.ajax({
        url: "/get-user-chart-data",
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            var months = data.months;
            var User_Count_data = data.User_Count_data;
            var color = ['rgb(66,133,244)', 'rgb(219,68,55)', 'rgb(244,180,0)', 'rgb(15,157,88)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'];
            var bordercolor = ['rgb(66,133,244)', 'rgb(219,68,55)', 'rgb(244,180,0)', 'rgb(15,157,88)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'];
            console.log(data);

            var chartdata = {
                labels: months,
                datasets: [{
                    label: months,
                    backgroundColor: color,
                    borderColor: color,
                    borderWidth: 2,
                    hoverBackgroundColor: color,
                    hoverBorderColor: bordercolor,
                    data: User_Count_data
                }]
            };

            var mostrar = $("#Usuarios");

            var grafico = new Chart(mostrar, {
                type: 'doughnut',
                data: chartdata,
                options: {
                    responsive: true,
                }
            });
        },
        error: function(data) {
            console.log(data);
        }
    });

    $.ajax({
        url: "/get-invoice-chart-data",
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            var Invoice_months = data.Invoice_months;
            var Invoice_Count_data = data.Invoice_Count_data;
            console.log(data);

            var Invoicechartdata = {
                labels: Invoice_months,
                datasets: [{
                    label: 'Facturas por Mes',
                    borderColor: [
                        'rgba(0, 99, 132, 1)',
                        'rgba(30, 99, 132, 1)',
                        'rgba(60, 99, 132, 1)',
                        'rgba(90, 99, 132, 1)',
                        'rgba(120, 99, 132, 1)',
                        'rgba(150, 99, 132, 1)',
                        'rgba(180, 99, 132, 1)',
                        'rgba(210, 99, 132, 1)',
                        'rgba(240, 99, 132, 1)',
                        'rgba(240, 99, 132, 1)'
                    ],
                    backgroundColor: [
                        'rgba(0, 99, 132, 0.6)',
                        'rgba(30, 99, 132, 0.6)',
                        'rgba(60, 99, 132, 0.6)',
                        'rgba(90, 99, 132, 0.6)',
                        'rgba(120, 99, 132, 0.6)',
                        'rgba(150, 99, 132, 0.6)',
                        'rgba(180, 99, 132, 0.6)',
                        'rgba(210, 99, 132, 0.6)',
                        'rgba(240, 99, 132, 0.6)',
                        'rgba(240, 99, 132, 0.6)'
                    ],
                    fill: true,
                    data: Invoice_Count_data
                }],

            };

            var mostrar = $("#FacturasPorMes");

            var grafico = new Chart(mostrar, {
                type: 'bar',
                data: Invoicechartdata,
                options: {
                    responsive: true,
                    hoverMode: 'index',
                    stacked: false,
                    title: {
                        display: false,
                        text: ''
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        },
        error: function(data) {
            console.log(data);
        }
    });



    $.ajax({
        url: "/get-invoice-chart-data-value",
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            var Invoice_value_months = data.Invoice_value_months;
            var Invoice_value_data =  data.Invoice_value_data;
            var Invoice_value_data_exp = data.Invoice_value_data_exp;
            var chartColors = {
                red: 'rgb(255, 99, 132)',
                orange: 'rgb(255, 159, 64)',
                yellow: 'rgb(255, 205, 86)',
                green: 'rgb(75, 192, 192)',
                blue: 'rgb(54, 162, 235)',
                purple: 'rgb(153, 102, 255)',
                grey: 'rgb(231,233,237)'
            };
            console.log(data);

            var Invoice_value_Chart = {
                labels: Invoice_value_months,
                datasets: [{
                    label: 'Nacionales',
                    backgroundColor: chartColors.red,
                    borderColor: chartColors.red,
                    fill: false,
                    data: Invoice_value_data,
                    yAxisID: 'y-axis-1',
                }, {
                    label: 'Exportaciones',
                    backgroundColor: chartColors.blue,
                    borderColor: chartColors.blue,
                    fill: false,
                    data: Invoice_value_data_exp,
                    yAxisID: 'y-axis-2'
                }
                ]};

            var mostrar = $("#VentasPorMes");

            var grafico = new Chart(mostrar, {
                type: 'line',
                data: Invoice_value_Chart,
                options: {
                    responsive: true,
                    hoverMode: 'index',
                    stacked: false,
                    title: {
                        display: true,
                        text: 'Valores representados en Millones'
                    },
                    scales: {
                        yAxes: [{
                            type: 'linear',
                            display: true,
                            position: 'left',
                            id: 'y-axis-1',
                            ticks: {
                                beginAtZero: true
                            }
                        },{
                            type: 'linear',
                            display: true,
                            position: 'right',
                            id: 'y-axis-2',
                            ticks: {
                                beginAtZero: true
                            },
                            gridLines:{
                                drawOnChartArea: true,
                            }
                        }]
                    }
                }
            });
        },
        error: function(data) {
            console.log(data);
        }
    });

    /* valores totales por año  */

    $.ajax({
        url: "/get-invoice-age-data-value",
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            var Invoice_age = data.Invoice_age;
            var Invoice_sum_data =  data.Invoice_sum_data;
            var Invoice_sum_data_exp = data.Invoice_sum_data_exp;
            var chartColors = {
                red: 'rgb(255, 99, 132)',
                orange: 'rgb(255, 159, 64)',
                yellow: 'rgb(255, 205, 86)',
                green: 'rgb(75, 192, 192)',
                blue: 'rgb(54, 162, 235)',
                purple: 'rgb(153, 102, 255)',
                grey: 'rgb(231,233,237)'
            };
            console.log(data);

            var Invoice_value_Chart = {
                labels: Invoice_age,
                datasets: [{
                    label: 'Nacionales',
                    backgroundColor: chartColors.red,
                    borderColor: chartColors.red,
                    fill: false,
                    data: Invoice_sum_data,
                    yAxisID: 'y-axis-1',
                }, {
                    label: 'Exportaciones',
                    backgroundColor: chartColors.blue,
                    borderColor: chartColors.blue,
                    fill: false,
                    data: Invoice_sum_data_exp,
                    yAxisID: 'y-axis-2'
                }
                ]};

            var mostrar = $("#VentasPorAño");

            var grafico = new Chart(mostrar, {
                type: 'line',
                data: Invoice_value_Chart,
                options: {
                    responsive: true,
                    hoverMode: 'index',
                    stacked: false,
                    title: {
                        display: true,
                        text: 'Valores representados en Millones'
                    },
                    scales: {
                        yAxes: [{
                            type: 'linear',
                            display: true,
                            position: 'left',
                            id: 'y-axis-1',
                            ticks: {
                                beginAtZero: true
                            }
                        },{
                            type: 'linear',
                            display: true,
                            position: 'right',
                            id: 'y-axis-2',
                            ticks: {
                                beginAtZero: true
                            },
                            gridLines:{
                                drawOnChartArea: true,
                            }
                        }]
                    }
                }
            });
        },
        error: function(data) {
            console.log(data);
        }
    });



    /*VALORES POR DIA (ULTIMOS 7 DIAS)*/

    $.ajax({
        url: "/get-invoice-day-data-value",
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            var Invoice_day = data.Invoice_day;
            var Invoice_day_sum_data =  data.Invoice_day_sum_data;
            var Invoice_day_sum_data_exp = data.Invoice_day_sum_data_exp;
            var chartColors = {
                red: 'rgb(255, 99, 132)',
                orange: 'rgb(255, 159, 64)',
                yellow: 'rgb(255, 205, 86)',
                green: 'rgb(75, 192, 192)',
                blue: 'rgb(54, 162, 235)',
                purple: 'rgb(153, 102, 255)',
                grey: 'rgb(231,233,237)'
            };
            console.log(data);

            var Invoice_value_Chart = {
                labels: Invoice_day,
                datasets: [{
                    label: 'Nacionales',
                    backgroundColor: chartColors.red,
                    borderColor: chartColors.red,
                    fill: false,
                    data: Invoice_day_sum_data,
                    yAxisID: 'y-axis-1',
                }, {
                    label: 'Exportaciones',
                    backgroundColor: chartColors.blue,
                    borderColor: chartColors.blue,
                    fill: false,
                    data: Invoice_day_sum_data_exp,
                    yAxisID: 'y-axis-2'
                }
                ]};

            var mostrar = $("#VentasPorDia");

            var grafico = new Chart(mostrar, {
                type: 'line',
                data: Invoice_value_Chart,
                options: {
                    responsive: true,
                    hoverMode: 'index',
                    stacked: false,
                    title: {
                        display: true,
                        text: 'Valores representados en Millones'
                    },
                    scales: {
                        yAxes: [{
                            type: 'linear',
                            display: true,
                            position: 'left',
                            id: 'y-axis-1',
                            ticks: {
                                beginAtZero: true
                            }
                        },{
                            type: 'linear',
                            display: true,
                            position: 'right',
                            id: 'y-axis-2',
                            ticks: {
                                beginAtZero: true
                            },
                            gridLines:{
                                drawOnChartArea: true,
                            }
                        }]
                    }
                }
            });
        },
        error: function(data) {
            console.log(data);
        }
    });
});
