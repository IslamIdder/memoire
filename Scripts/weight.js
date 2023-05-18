$(document).ready(function () {
  $.ajax({
    url: "../config.php",
    type: "GET",
    dataType: "json",
    success: function (data) {
      var weight = data.map(function (obj) {
        w = obj.weight
        return w;
      });
      var age = data.map(function (obj) {
        a = obj.age
        return a;
      });
      v = parseInt(age[0])
      var weightData = new Array(v).fill(null).concat(weight);
      var chartData1 = {
        labels: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18'],
        datasets: [
          {
            label: 'Max G',
            data: [, 11, 13, 15, 18, 22, 26, 31, 35, 40, 45, 51, 56, 62, 69, 72, 75, 76, 77],
            fill: false,
            borderColor: 'blue',
            borderWidth: 0.5,
            tension: 0.1
          },
          {
            label: 'Min G',
            data: [, 6, 9, 12, 14, 17, 20, 24, 27, 32, 39, 45, 47, 52, 54, 56, 57, 59, 60],
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            borderWidth: 0.5,
            tension: 0.1
          },
          {
            label: 'Max F',
            data: [, 8, 11, 14, 16, 18, 21, 25, 27, 32, 39, 44, 47, 55, 59, 62, 65, 67, 67],
            fill: false,
            borderColor: 'rgb(255, 99, 132)',
            borderWidth: 0.5,
            tension: 0.1
          },
          {
            label: 'Min F',
            data: [, 5, 7, 9, 10, 11, 13, 16, 20, 24, 27, 33, 36, 41, 46, 49, 51, 51, 52],
            fill: false,
            borderColor: 'red',
            borderWidth: 0.5,
            tension: 0.1
          },
          {
            label: 'Your weight',
            data: weightData,
            fill: false,
            borderColor: 'green',
            tension: 0.1
          }

        ]
      };

      var chart = document.getElementById('myChart1').getContext('2d');
      var myChart1 = new Chart(chart, {
        type: 'line',
        data: chartData1,
        options: {
          elements: {
            point: {
              radius: 0
            }

          },

          scales: {
            x: {
              grid: {
                display: false
              },
              stacked: true
            },
            y: {
              max: 77,
              grid: {
                display: false
              },
              ticks: {
                min: 5,
                stepSize: 5
              },
              title: {
                display: true,
                text: 'Weight (kg)'
              }
            }
          },
          plugins: {
            legend: {
              position: 'top'
            },

          },
          barPercentage: 0.5,
          categoryPercentage: 0.6

        }
      });
    },
    error: function (xhr, status, error) {
      console.log(error);
    }
  });
});
