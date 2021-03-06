<?php
require_once("../lib/phpchartdir.php");

# The data for the pie chart
$data = array(25, 18, 15, 12, 8, 30, 35);

# The labels for the pie chart
$labels = array("Labor", "Licenses", "Taxes", "Legal", "Insurance", "Facilities",
    "Production");

# Create a PieChart object of size 480 x 300 pixels
$c = new PieChart(480, 300);

#Set directory for loading images to current script directory
#Need when running under Microsoft IIS
$c->setSearchPath(dirname(__FILE__));

# Use a blue marble pattern as the background wallpaper, with a black border, and 1
# pixel 3D border effect
$c->setBackground($c->patternColor("marble.png"), 0x000000, 1);

# Set the center of the pie at (150, 150) and the radius to 100 pixels
$c->setPieSize(150, 150, 100);

# Add a title to the pie chart using Times Bold Italic/15 points/deep blue (0x000080)
# as font, with a wood pattern as the title background
$textBoxObj = $c->addTitle("Project Cost Breakdown", "timesbi.ttf", 15, 0x000080);
$textBoxObj->setBackground($c->patternColor("wood.png"));

# Draw the pie in 3D
$c->set3D();

# Add a legend box using Arial Bold Italic/11 points font. Use a pink marble pattern
# as the background wallpaper, with a 1 pixel 3D border. The legend box is top-right
# aligned relative to the point (465, 70)
$b = $c->addLegend(465, 70, true, "arialbi.ttf", 11);
$b->setBackground($c->patternColor("marble2.png"), Transparent, 1);
$b->setAlignment(TopRight);

# Set the default font for all sector labels to Arial Bold/8 pts/dark green
# (0x008000).
$c->setLabelStyle("arialbd.ttf", 8, 0x008000);

# Set the pie data and the pie labels
$c->setData($data, $labels);

# Explode the 3rd sector
$c->setExplode(2, 40);

# Use Arial Bold/12 pts/red as label font for the 3rd sector
$sectorObj = $c->sector(2);
$sectorObj->setLabelStyle("arialbd.ttf", 12, 0xff0000);

# Use Arial/8 pts/deep blue as label font for the 5th sector. Add a background box
# using the sector fill color (SameAsMainColor), with a black (0x000000) edge and 2
# pixel 3D border.
$sectorObj = $c->sector(4);
$textBoxObj = $sectorObj->setLabelStyle("arial.ttf", 8, 0x000080);
$textBoxObj->setBackground(SameAsMainColor, 0x000000, 2);

# Use Arial Italic/8 pts/light red (0xff9999) as label font for the 6th sector. Add a
# dark blue (0x000080) background box with a 2 pixel 3D border.
$sectorObj = $c->sector(0);
$textBoxObj = $sectorObj->setLabelStyle("ariali.ttf", 8, 0xff9999);
$textBoxObj->setBackground(0x000080, Transparent, 2);

# Use Times Bold Italic/8 pts/deep green (0x008000) as label font for 7th sector. Add
# a yellow (0xFFFF00) background box with a black (0x000000) edge.
$sectorObj = $c->sector(6);
$textBoxObj = $sectorObj->setLabelStyle("timesbi.ttf", 8, 0x008000);
$textBoxObj->setBackground(0xffff00, 0x000000);

# Output the chart
header("Content-type: image/jpeg");
print($c->makeChart2(JPG));
?>
