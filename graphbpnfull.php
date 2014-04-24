<?php
include('lib/phpgraphlib.php');
include('config.php');
$x=1;
$dtmse = mysql_query("select mse as err, id from mse");
while ($row = mysql_fetch_assoc($dtmse)) {
  $mse		= $row["err"];
  //add to data areray
  $dataArray[$x] = $mse;
  $x++;
}
$graph = new PHPGraphLib(20000,800);
$graph->addData($dataArray);
$graph->setTitle('MEAN SQUARE ERROR');
$graph->setBars(false);
$graph->setLine(true);
$graph->setDataPoints(true);
$graph->setDataPointColor('maroon');
$graph->setDataValues(true);
$graph->setDataValueColor('maroon');
$graph->setGoalLine(.005);
$graph->setGoalLineColor('red');
$graph->createGraph();
?>