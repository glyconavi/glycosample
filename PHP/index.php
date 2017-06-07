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

<div><h2>Contents</h2></div>
<div>
<ul>
<li><a href="./GlycoSampleList.php" target="_blank">GlycoSample List</li>
<li><a href="./entry.php?id=GS_26" target="_blank">Example of GlycoSample Entry</a></li>
<li><a href="./pickuplist.php" target="_blank">GlycoSample List Sample</a></li>
</ul>
</div>







<?php
include("../footer.php");
?>
