<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pie Chart converter</title>
    <meta content="Matthew Webber" name="author">
    <meta content="Pie Chart Programming Project" name="description">
    <link rel="stylesheet" type="text/css" href="../styles/main.css">
    <h1> Spreadsheet to Pie Chart Converter </h1>
</head>
<body>
	Input Excel File: <input type="text" name="exfile"><br>
    <?php
error_reporting(E_ALL ^ E_NOTICE);
require_once("../lib/phpchartdir.php");
require_once 'excel_reader2.php';
$file = new Spreadsheet_Excel_Reader("exfile");
# The data for the pie chart
$data = array();
$data[] = $file.getCol(1);

# The labels for the pie chart
$labels = array();
$labels = $file.getCol(1)
# Create a PieChart object of size 360 x 300 pixels
$c = new PieChart(360, 300);

# Set the center of the pie at (180, 140) and the radius to 100 pixels
$c->setPieSize(180, 140, 100);

# Set the pie data and the pie labels
$c->setData($data, $labels);

# Output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>
	
</body>
</html>
