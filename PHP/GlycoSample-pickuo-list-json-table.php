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
    
$spqrqldata = "http://rdf.glyconavi.org:8890/sparql?default-graph-uri=&query=prefix+gs%3A+%3Chttp%3A%2F%2Fglyconavi.org%2Fglycobio%2Fglycosample%2F%3E%0D%0Aselect+distinct+%3Fgsid+%3Forganism+%3Ftaxonomy_name+%3Fprovider+%3Ftissue_type+%3Fcell_line+%3Fdisease%0D%0Afrom+%3Chttp%3A%2F%2Fglyconavi.org%2Fdatabase%2Fglycosample%3E%0D%0Awhere+%7B%0D%0A%3Fgs+%3Chttp%3A%2F%2Fpurl.org%2Fdc%2Fterms%2Fidentifier%3E+%3Fgsid+.%0D%0A%3Fgs%09gs%3Aglycosample_entry%09%3Fentry+.%0D%0A%0D%0AOPTIONAL+%7B%0D%0A%3Fentry+gs%3Aorganism+%3Forganism+.%0D%0A%7D%0D%0AOPTIONAL+%7B%0D%0A%3Fentry+gs%3Ataxonomy_name+%3Ftaxonomy_name+.%0D%0A%7D%0D%0AOPTIONAL+%7B%0D%0A%3Fentry+gs%3Abiomaterial_provider+%3Fprovider+.%0D%0A%7D%0D%0AOPTIONAL+%7B%0D%0A%3Fentry+gs%3Atissue_type+%3Ftissue_type+.%0D%0A%7D%0D%0AOPTIONAL+%7B%0D%0A%3Fentry+gs%3Acell_line+%3Fcell_line+.%0D%0A%7D%0D%0AOPTIONAL+%7B%0D%0A%3Fentry+gs%3Adisease+%3Fdisease+.%0D%0A%7D%0D%0A%0D%0A%0D%0A%7D%0D%0Aorder+by+DESC+%28%3Forganism%29+%3Fgsid&should-sponge=&format=application%2Fsparql-results%2Bjson&timeout=0&debug=on";
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
<table class="TwoWayBack">
    <thead>
    <tr>
        <th scope="cols">GS_ID</th>
        <th scope="cols">Organism</th>
        <th scope="cols">Taxonomy</th>
        <th scope="cols">Provider</th>
        <th scope="cols">Tissue type</th>
        <th scope="cols">Cell line</th>
        <th scope="cols">Disease</th>
    </tr>
    </thead>
    <tbody>
<?php
    foreach ($arr as $ressouce) {
        echo '<tr>'."\n";
        
        echo '<th scope="row"><a href="entry.php?id='.$ressouce["gsid"]["value"].'" target="_blank" >'.$ressouce["gsid"]["value"].'</a></th>'."\n";

        echo '<td>'.$ressouce["organism"]["value"].'</td>'."\n";
        echo '<td>'.$ressouce["taxonomy_name"]["value"].'</td>'."\n";
        echo '<td>'.$ressouce["provider"]["value"].'</td>'."\n";
        echo '<td>'.$ressouce["tissue_type"]["value"].'</td>'."\n";
        echo '<td>'.$ressouce["cell_line"]["value"].'</td>'."\n";
        echo '<td>'.$ressouce["disease"]["value"].'</td>'."\n";
        echo '</tr>'."\n";
    }
?>
    </tbody>
</table>
<?php    
}
?>
</body>
</html>
