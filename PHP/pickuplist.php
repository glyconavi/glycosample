<?php
include("../head.php");
?>

<body>
<div class="green-bord"><img src="http://www.glyconavi.org/logo/GlycoNAVI.png"><h1>GlycoSample</h1></div>
<?php
//header('Content-Type: text/plain;charset=UTF-8');
mb_internal_encoding("UTF-8");
ini_set('auto_detect_line_endings', 1);
ini_set('auto_detect_line_endings', 1);
date_default_timezone_set('Asia/Tokyo');
$timeHeader = date("Y-m-d_H-i-s");

?>
<div><h2><?php echo "List"; ?></h2></div>
<div><a href="./index.php" target="_blank" >GlycoSample Home</a></div>
<!-- <div class="green-bord-black"><h2>GlycoSample Information</h2></div> -->
<?php

$url = "./GlycoSample-pickuo-list-json-table.php";
printf("<div>");
printf("<iframe ID=\"parent-iframe\" width=\"1300\" class=\"glycanframe\" src=\"".$url."\"></iframe>");
printf("</div>");
printf("<SCRIPT>jQuery('iframe.glycanframe').iframeAutoHeight();</SCRIPT>");

include("../footer.php");
?>
