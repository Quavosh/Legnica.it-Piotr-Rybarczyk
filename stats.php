<?php
include 'webstyle.htm';
require_once "db.php";
mysql_connect($host,$db_user,$db_password);
mysql_select_db($db_name);
session_start();
$login = $_SESSION['user'];
$req = mysql_query("SELECT * FROM budget");
$point = 1;
$names[0] = "blank";
$incomes[0] = 0;
$outcomes[0] = 0;
$sum = 0;
$rel = mysql_query('SELECT SUM(balance) AS suma FROM budget');
$bud = mysql_fetch_array($rel);
while($row = mysql_fetch_array($req))
{
    $names[$point] = $row['login'];
    $incomes[$point] = round($row['income']);
    $outcomes[$point] = round($row['outcome']);
    $point = $point + 1;
}
?>
<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
        <?php
        for($r=1;$r < $point;$r++)
        {
            echo "['" . $names[$r] . "', " . $incomes[$r] . "],";
        }
        ?>
        ]);

        // Set chart options
        var options = {'title':'Dochody poszczegolnych uzytkownikow',
                       'width':1880,
                       'height':375};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
        <?php
        for($r=1;$r < $point;$r++)
        {
            echo "['" . $names[$r] . "', " . $outcomes[$r] . "],";
        }
        ?>
        ]);

        // Set chart options
        var options = {'title':'Wydatki poszczegolnych uzytkownikow',
                       'width':1880,
                       'height':375};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
    </script>
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
         <?php
          echo "['Task', 'Hours per Day'],";
          for($r=1;$r < $point;$r++)
          {$sum=$sum+$incomes[$r];}
          echo "['Przychod', " . $sum . "],";
          $sum = 0;
          for($r=1;$r < $point;$r++)
          {$sum=$sum+$outcomes[$r];}
          echo "['Straty', " . $sum . "]";
         ?>
        ]);

        var options = {
          title: 'Balans Budzetu Domowego',
          'width':1880,
          'height':375,
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
    
  </head>

  <body>
  <center><b>Wykresy</b></center>
  <form action="index.php" method="post"></p>
  <input type="submit" value="Wyloguj" name="logout" />
  </form>
  </form><form action="menu.php" method=post><input type="submit" value="Wroc" /></form>
  <?php
    echo"<div class='inbox'>";
    echo "<center><b><font size=5px>Stan Konta Domowego: " . $bud['suma'] . "</font></b>";
    echo "</center></div>"; ?>
    <!--Div that will hold the pie chart-->
    <center><div id="chart_div"></div>
    <div id="donutchart"></div>
    <div id="chart_div2"></div></div></center>
    <img src="google.png" width=10% height=10% style="float: center;"/>
</html>
