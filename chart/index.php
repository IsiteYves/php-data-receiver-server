<!doctype html>
<html>

<head>
  <script src="https://cdn.anychart.com/releases/8.8.0/js/anychart-base.min.js"></script>
  <script src="https://cdn.anychart.com/releases/8.8.0/js/anychart-data-adapter.min.js"></script>
  <style type="text/css">
    html,
    body,
    #container {
      width: 60vw;
      height: 60vh;
      margin: 2rem auto;
      padding: 0;
    }

    #dataHeader {
      text-align: center !important;
      font-size: 25px !important;
      color: orangered !important;
      font-family: Arial;
      font-weight: 700 !important
    }

    #dataHeader2 {
      text-align: center !important;
      font-size: 20px !important;
    }
  </style>
</head>

<body>
  <p id="dataHeader">ESP8266 Uploaded Data</p>
  <h2 id="dataHeader2">No data uploaded yet.</h2>
  <div id="container"></div>
  <script>
    let currLength = 0

    try {
      let dataHeader2 = document.querySelector('#dataHeader2')

      function checkEmptyData() {
        fetch('../readData.php').then((res) => {
          if (res.status === 200) {
            return false
          } else {
            return true
          }
        })
      }

      const loadDataChart = () => {
        anychart.data.loadJsonFile("../readData.php", function(data) {
          // create a chart and set loaded data
          currLength = data.data.length
          const dataToUse = []
          for (let i = 0; i < data.data.length; i++) {
            const {
              device_name,
              temperature
            } = data.data[i]
            dataToUse.push([device_name, temperature])
          }
          for (let i = 0; i < data.data.length; i++) {
            const {
              device_name,
              temperature
            } = data.data[i]
            dataToUse.push([device_name, temperature])
          }
          chart = anychart.line(dataToUse);
          chart.title("Device names and their Temperatures");
          chart.xAxis().title("Device Name");
          chart.yAxis().title("Temperature (°C)");
          chart.tooltip().format(function(e) {
            var value = this.value;
            return `Temperature: ${value}°C`;
          });
          chart.container("container");
          chart.draw();
        });
      }

      anychart.onDocumentReady(function() {
        if (checkEmptyData()) {
          dataHeader2.style.display = 'block'
        } else {
          dataHeader2.style.display = 'none'
          loadDataChart()
        }
      });

      setInterval(() => {
        anychart.onDocumentReady(function() {
          if (checkEmptyData()) {
            dataHeader2.style.display = 'none'
          } else {
            dataHeader2.style.display = 'block'
            anychart.data.loadJsonFile("../readData.php", function(data) {
              if (data.data.length !== currLength) {
                document.getElementById('container').innerHTML = ''
                currLength = data.data.length
                loadDataChart()
              }
            })
          }
        })
      }, 1000);
    } catch (e) {
      console.log(e.message)
    }
  </script>
</body>

</html>