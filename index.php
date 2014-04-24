<?php
include "config.php";
include "header.php";
include "menu.php";
if(isset( $_GET['op'] )){
$op = $_GET['op'];
if($op == "data-training") include "data-training.php";
elseif($op == "home") include "content.php";
elseif($op == "data-testing") include "data-testing.php";
elseif($op == "backpropagation") include "backpropagation.php";
else include "content.php";
}else include "content.php";
include "footer.php";
?>

