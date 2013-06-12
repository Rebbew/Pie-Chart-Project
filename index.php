<?php
    require_once('header.php');
?>

	<form enctype="multipart/form-data" action="uploader.php" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
        Choose a file to upload: <input name="exfile" type="file" /><br />
        <input type="submit" value="Upload File" />
        </form>
    <?php
        error_reporting(E_ALL ^ E_NOTICE);
        require_once("/ChartDirector/lib/phpchartdir.php");
        require_once ("/Excel_reader2/excel_reader2.php");
	
        $file = new Spreadsheet_Excel_Reader("exfile");
        # The data for the pie chart
        $data = array();
        $data[] = $file.getCol(0);

         The labels for the pie chart
        $labels = array();
        $labels[] = $file.getCol(1);

        # Create a PieChart object of size 360 x 300 pixels
        $c = new PieChart(360, 300);

        # Set the center of the pie at (180, 140) and the radius to 100 pixels
     	 $c.setPieSize(180, 140, 100);

        # Set the pie data and the pie labels
    	 $c.setData($data, $labels);

        # Output the chart
        header("Content-type: image/png");
      	print($c.makeChart2(PNG));
    ?>

<?php
      require_once('footer.php');
?>

