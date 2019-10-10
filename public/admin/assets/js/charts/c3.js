(function ($) {
  'use strict';

  var C3ChartData = [
    ['data1', 30, 200, 100, 400, 150, 250],
    ['data2', 130, 100, 140, 200, 150, 50]
  ];

  if ($("#sample_c3-line-chart").length) {
    var c3LineChart = c3.generate({
      bindto: '#sample_c3-line-chart',
      data: {
        columns: C3ChartData,
        colors: {
          data1: chartColors[0],
          data2: chartColors[1]
        }
      }
    });
  }

  if ($("#sample_c3-area-chart").length) {
    var c3AreaChart = c3.generate({
      bindto: '#sample_c3-area-chart',
      data: {
        columns: C3ChartData,
        types: {
          data1: 'area-spline',
          data2: 'area-spline'
        },
        groups: [
          ['data1', 'data2']
        ],
        colors: {
          data1: chartColors[0],
          data2: chartColors[1]
        }
      }
    });
  }

  if ($("#sample_c3-bar-chart").length) {
    var c3BarChart = c3.generate({
      bindto: '#sample_c3-bar-chart',
      data: {
        columns: C3ChartData,
        type: 'bar',
        bar: {
          width: {
            ratio: 0.5
          }
        },
        colors: {
          data1: chartColors[0],
          data2: chartColors[1]
        }
      }
    });
  }

  if ($("#sample_c3-stacked-bar-chart").length) {
    var c3StackedBarChart = c3.generate({
      bindto: '#sample_c3-stacked-bar-chart',
      data: {
        columns: C3ChartData,
        type: 'bar',
        groups: [
          ['data1', 'data2']
        ],
        colors: {
          data1: chartColors[0],
          data2: chartColors[1]
        }
      },
      grid: {
        y: {
          lines: [{
            value: 0
          }]
        }
      }
    });
  }

  if ($("#sample_c3-step-chart").length) {
    var c3StepChart = c3.generate({
      bindto: '#sample_c3-step-chart',
      data: {
        columns: C3ChartData,
        types: {
          data1: 'step',
          data2: 'area-step'
        },
        colors: {
          data1: chartColors[0],
          data2: chartColors[1]
        }
      }
    });
  }

  if ($("#sample_c3-scattered-plot-chart").length) {
    var chart = c3.generate({
      bindto: '#sample_c3-scattered-plot-chart',
      data: {
        xs: {
          setosa: 'setosa_x',
          versicolor: 'versicolor_x',
        },
        // iris data from R
        columns: [
          ["setosa_x", 3.5, 3.0, 3.2, 3.1, 3.6, 3.9, 3.4, 3.4, 2.9, 3.1, 3.7, 3.4, 3.0, 3.0, 4.0, 4.4, 3.9, 3.5, 3.8, 3.8, 3.4, 3.7, 3.6, 3.3, 3.4, 3.0, 3.4, 3.5, 3.4, 3.2, 3.1, 3.4, 4.1, 4.2, 3.1, 3.2, 3.5, 3.6, 3.0, 3.4, 3.5, 2.3, 3.2, 3.5, 3.8, 3.0, 3.8, 3.2, 3.7, 3.3],
          ["versicolor_x", 3.2, 3.2, 3.1, 2.3, 2.8, 2.8, 3.3, 2.4, 2.9, 2.7, 2.0, 3.0, 2.2, 2.9, 2.9, 3.1, 3.0, 2.7, 2.2, 2.5, 3.2, 2.8, 2.5, 2.8, 2.9, 3.0, 2.8, 3.0, 2.9, 2.6, 2.4, 2.4, 2.7, 2.7, 3.0, 3.4, 3.1, 2.3, 3.0, 2.5, 2.6, 3.0, 2.6, 2.3, 2.7, 3.0, 2.9, 2.9, 2.5, 2.8],
          ["setosa", 0.2, 0.2, 0.2, 0.2, 0.2, 0.4, 0.3, 0.2, 0.2, 0.1, 0.2, 0.2, 0.1, 0.1, 0.2, 0.4, 0.4, 0.3, 0.3, 0.3, 0.2, 0.4, 0.2, 0.5, 0.2, 0.2, 0.4, 0.2, 0.2, 0.2, 0.2, 0.4, 0.1, 0.2, 0.2, 0.2, 0.2, 0.1, 0.2, 0.2, 0.3, 0.3, 0.2, 0.6, 0.4, 0.3, 0.2, 0.2, 0.2, 0.2],
          ["versicolor", 1.4, 1.5, 1.5, 1.3, 1.5, 1.3, 1.6, 1.0, 1.3, 1.4, 1.0, 1.5, 1.0, 1.4, 1.3, 1.4, 1.5, 1.0, 1.5, 1.1, 1.8, 1.3, 1.5, 1.2, 1.3, 1.4, 1.4, 1.7, 1.5, 1.0, 1.1, 1.0, 1.2, 1.6, 1.5, 1.6, 1.5, 1.3, 1.3, 1.3, 1.2, 1.4, 1.2, 1.0, 1.3, 1.2, 1.3, 1.3, 1.1, 1.3],
        ],
        type: 'scatter',
        colors: {
          data1: chartColors[0],
          data2: chartColors[1]
        }
      },
      axis: {
        x: {
          label: 'Sepal.Width',
          tick: {
            fit: false
          }
        },
        y: {
          label: 'Petal.Width'
        }
      }
    });
  }

  if ($("#sample_c3-donut-chart").length) {
    var c3DonutChart = c3.generate({
      bindto: '#sample_c3-donut-chart',
      data: {
        columns: [
          ['data1', 30],
          ['data2', 120],
        ],
        type: 'donut',
        onclick: function (d, i) {
          console.log("onclick", d, i);
        },
        onmouseover: function (d, i) {
          console.log("onmouseover", d, i);
        },
        onmouseout: function (d, i) {
          console.log("onmouseout", d, i);
        },
        colors: {
          data1: chartColors[0],
          data2: chartColors[1]
        }
      },
      donut: {
        title: "Iris Petal Width"
      }
    });
  }

  if ($("#sample_c3-pie-chart").length) {
    var c3PieChart = c3.generate({
      bindto: '#sample_c3-pie-chart',
      data: {
        // iris data from R
        columns: [
          ['data1', 30],
          ['data2', 120],
        ],
        colors: {
          data1: chartColors[0],
          data2: chartColors[1]
        },
        type: 'pie',
        onclick: function (d, i) {
          console.log("onclick", d, i);
        },
        onmouseover: function (d, i) {
          console.log("onmouseover", d, i);
        },
        onmouseout: function (d, i) {
          console.log("onmouseout", d, i);
        }
      }
    });
  }

  if ($("#sample_c3-guage-chart").length) {
    var chart = c3.generate({
      bindto: '#sample_c3-guage-chart',
      data: {
        columns: [
          ['data', 65]
        ],
        colors: {
          data1: chartColors[0],
          data2: chartColors[1]
        },
        type: 'gauge'
      },
      gauge: {
        // min: 0, // 0 is default, //can handle negative min e.g. vacuum / voltage / current flow / rate of change
        // max: 100, // 100 is default
        // units: ' %',
        // width: 39 // for adjusting arc thickness
      },
      color: {
        pattern: chartColors, // the three color levels for the percentage values.
        threshold: {
          // unit: 'value', // percentage is default
          // max: 200, // 100 is default
          values: [30, 60, 90, 100]
        }
      },
      size: {
        height: 180
      }
    });
  }
})(jQuery);