<?php
include("../head.php");
?>
<body>

<?php
//header('Content-Type: text/plain;charset=UTF-8');
ini_set('auto_detect_line_endings', 1);
ini_set('auto_detect_line_endings', 1);
date_default_timezone_set('Asia/Tokyo');
$timeHeader = date("Y-m-d_H-i-s");
    
$spqrqldata = "http://rdf.glyconavi.org:8890/sparql?default-graph-uri=&query=prefix+gs%3A+%3Chttp%3A%2F%2Fglyconavi.org%2Fglycobio%2Fglycosample%2F%3E%0D%0Aselect+distinct+%3Fgsid%0D%0Afrom+%3Chttp%3A%2F%2Fglyconavi.org%2Fdatabase%2Fglycosample%3E%0D%0Awhere+%7B%0D%0A%3Fgs+gs%3Aglycosample_id+%3Fgsid+.%0D%0A%7D%0D%0Aorder+by++%3Fgsid&should-sponge=&format=application%2Fsparql-results%2Bjson&timeout=0&debug=on";
$getdata = file_get_contents($spqrqldata);
//echo $getdata;
$json = mb_convert_encoding($getdata, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$arr = json_decode($json,true);

if ($arr === NULL) {
    return;
}
else{
    
    $resarray = array();
    $arr = $arr["results"]["bindings"];


?>
<div>
<table class="TwoWayBack">
    <thead>
    <tr>
        <th scope="cols">GlycoSample ID</th>
    </tr>
    </thead>
    <tbody>
<?php
    foreach ($arr as $ressouce) {
        echo '<tr>'."\n";
        
        echo '<th scope="row"><a href="entry.php?id='.$ressouce["gsid"]["value"].'" target="_blank" >'.$ressouce["gsid"]["value"].'</a></th>'."\n";

        echo '</tr>'."\n";
    }
?>
    </tbody>
</table>
</div>
<?php    
}
?>
</body>
</html>
