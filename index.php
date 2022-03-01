<?php
//Uncaught Error: Class "duzun\hQuery\Parser\HTML" not found in C:\xampp\htdocs\scraping\hQuery.php-master\src\hQuery\HTML_Index.php:423
//hQuery error

include("simple_html_dom.php");
$web = file_get_html("https://scholar.google.co.id/citations?user=6eDyhRgAAAAJ&hl=id");
// $web = file_get_html("file:///C:/Users/andika/Downloads/webscraping.html");

$chart = $web->find("div[class='gsc_md_hist_b']",0);
$data = $chart->find("a[class='gsc_g_a']");
$year = $chart->find("span[class='gsc_g_t']");
?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body style="text-align:center;overflow-x:hidden">
    <h1><?=$web->find("title",0)->plaintext?></h1>
    <div id="curve_chart" style="width: 100vw; height: 500px"></div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart', 'line']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Tahun', 'Kutipan'],
            <?php
            for($i=0;$i<sizeof($data);$i++){
                echo "['".($year[$i]->plaintext)."',".(int)($data[$i]->plaintext)."],";
            }
          ?>
        ]);

        var options = {
          title: 'kutipan pertahun',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
  </body>
</html>