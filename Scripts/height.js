$(document).ready(function () {
  $.ajax({
    url: "../config.php",
    type: "GET",
    dataType: "json",
    success: function (data) {
      console.log(data);
      var height = data.map(function (obj) {
        h = obj.height
        return h;
      });
      var age = data.map(function (obj) {
        a = obj.age
        return a;
      });
      v = parseInt(age[0]);
      var heightData = new Array(v).fill(null).concat(height);
      console.log(heightData);
      var chartData = {
        labels: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18'],
        datasets: [
          {
            label: 'Max G',
            data: [, , , 97, 105, 110, 117, 124, 130, 136, 142, 150, 157, 165, 174, 180, 184, 185, 187],
            fill: false,
            borderColor: 'blue',
            borderWidth: 0.6,
            tension: 0.1
          },
          {
            label: 'Min G',
            data: [, , , 91, 97, 105, 110, 116, 122, 127, 134, 140, 146, 152, 155, 157, 160, 162, 163],
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            borderWidth: 0.5,
            tension: 0.1
          },
          {
            label: 'Max F',
            data: [, , , 91, 97, 105, 110, 116, 122, 126, 132, 137, 145, 152, 160, 165, 170, 172, 174],
            fill: false,
            borderColor: 'rgb(255, 99, 132)',
            borderWidth: 0.5,
            tension: 0.1
          },
          {
            label: 'Min F',
            data: [, , , 85, 90, 95, 100, 104, 107, 114, 117, 123, 131, 137, 145, 147, 150, 151, 152],
            fill: false,
            borderColor: 'red',
            borderWidth: 0.5,
            tension: 0.1
          },
          {
            label: 'Your height',
            data: heightData,
            fill: false,

            borderColor: 'green',
            tension: 0.1
          }

        ]
      };

      var chart = document.getElementById('myChart').getContext('2d');
      var myChart = new Chart(chart, {
        type: 'line',
        data: chartData,
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
              grid: {
                display: false
              },
              ticks: {
                min: 80,
                max: 190,
                stepSize: 5
              },
              title: {
                display: true,
                text: 'Height (cm)'
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
      console.log(height);
    },
    error: function (xhr, status, error) {
      console.log(error);
    }
  });
});
