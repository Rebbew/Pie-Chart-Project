<?php
require_once("../lib/phpchartdir.php");

# The data for the pyramid chart
$data = array(156, 123, 211, 179);

# The colors for the pyramid layers
$colors = array(0x66aaee, 0xeebb22, 0xcccccc, 0xcc88ff);

# The layer gap
$gap = (int)($_REQUEST["img"]) * 0.01;

# Create a PyramidChart object of size 200 x 200 pixels, with white (ffffff)
# background and grey (888888) border
$c = new PyramidChart(200, 200, 0xffffff, 0x888888);

# Set the pyramid center at (100, 100), and width x height to 60 x 120 pixels
$c->setPyramidSize(100, 100, 60, 120);

# Set the layer gap
$c->addTitle("Gap = $gap", "ariali.ttf", 15);
$c->setLayerGap($gap);

# Set the elevation to 15 degrees
$c->setViewAngle(15);

# Set the pyramid data
$c->setData($data);

# Set the layer colors to the given colors
$c->setColors2(DataColor, $colors);

# Output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>
