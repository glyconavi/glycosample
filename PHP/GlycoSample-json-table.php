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



$id="GS_26";
if(isset($_REQUEST['id'])) {
    if ($_REQUEST["id"] != "") {
        $id = $_REQUEST["id"];
        $id = str_replace("\t", ",", $id);
        $id = preg_replace("/\r\n|\r|\n/", ",", $id);
        $idarray = explode(",", trim($id));
    }
}

$sparqlformat =  "format=application%2Fsparql-results%2Bjson";

if (strlen($id) > 0) {
    
    $spqrqldata = "http://rdf.glyconavi.org:8890/sparql?default-graph-uri=&query=select++distinct+%3Fres%0D%0Afrom+%3Chttp%3A%2F%2Fglyconavi.org%2Fdatabase%2Fglycosample%3E%0D%0Awhere+%7B+%0D%0A%0D%0A%3Fs+%3Chttp%3A%2F%2Fpurl.org%2Fdc%2Fterms%2Fidentifier%3E+%3Fgsid+.%0D%0AVALUES+%3Fgsid+%7B+%22".trim($id)."%22+%7D%0D%0A%3Fs+%3Chttp%3A%2F%2Fglyconavi.org%2Fglycobio%2Fglycosample%2Fglycosample_entry%3E+%3Fres+.%0D%0A%0D%0A+%7D%0D%0A&should-sponge=&format=application%2Fsparql-results%2Bjson&timeout=0&debug=on";

    $getdata = file_get_contents($spqrqldata);
    //var_dump($getdata);
    //echo $getdata;
}

$json = mb_convert_encoding($getdata, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$arr = json_decode($json,true);


if ($arr === NULL) {
    return;
}
else{
    
    $resarray = array();
    //$jsonarray = array();
    $arr = $arr["results"]["bindings"];
    //var_dump($arr);
    $sparqlformat =  "format=application%2Fsparql-results%2Bjson";
    foreach ($arr as $ressouce) {
        $resentry = urlencode("<".$ressouce["res"]["value"].">");
        //echo "ressouce\t".$ressouce["res"]["value"]."\n";

        // %3Chttp%3A%2F%2Fglyconavi.org%2Fglycobio%2Fglycosample%2FGS_26_E1%3E

        $spqrqldata = "http://rdf.glyconavi.org:8890/sparql?default-graph-uri=&query=select++distinct+str+%28%3Fo%29+AS+%3FEntry+%3Fdata%0D%0Afrom+%3Chttp%3A%2F%2Fglyconavi.org%2Fdatabase%2Fglycosample%3E%0D%0Awhere+%7B+%0D%0A".$resentry."+%3Fp+%3Fdata+.%0D%0A%3Fp+%3Chttp%3A%2F%2Fwww.w3.org%2F1999%2F02%2F22-rdf-syntax-ns%23label%3E+%3Fo+.%0D%0A+%7D%0D%0Aorder+by+%3FEntry&should-sponge=&".$sparqlformat."&timeout=0&debug=on";
        $getdata = file_get_contents($spqrqldata);
        //$jsonarray = json_decode( $getdata );
        //$jsonData = json_encode( $jsonarray, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        //echo $jsonData;
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
                <th scope="cols">Entry</th>
                <th scope="cols">data</th>
            </tr>
            </thead>
            <tbody>
        <?php
            foreach ($arr as $ressouce) {
                echo '<tr>'."\n";

                if(strpos($ressouce["data"]["value"], 'http') !== false) {
                    echo '<th scope="row">'.$ressouce["Entry"]["value"].'</th>'."\n";
                    echo '<td><a href="'.$ressouce["data"]["value"].' target="_blank" >'.$ressouce["data"]["value"].'</a></td>'."\n";
                    echo '</tr>'."\n";
                }
                else {
                    echo '<th scope="row">'.$ressouce["Entry"]["value"].'</th>'."\n";
                    echo '<td>'.$ressouce["data"]["value"].'</td>'."\n";
                    echo '</tr>'."\n";
                }
            }
        ?>
            </tbody>
        </table>
        <?php    
        }





    }

    
}




  



/*
http://www.w3.org/1999/02/22-rdf-syntax-ns#type
http://purl.org/dc/terms/reference
http://glyconavi.org/glycobio/glycosample/age
http://glyconavi.org/glycobio/glycosample/biomaterial_provider
http://glyconavi.org/glycobio/glycosample/bioproject_id
http://glyconavi.org/glycobio/glycosample/cell_line
http://glyconavi.org/glycobio/glycosample/culture_collection
http://glyconavi.org/glycobio/glycosample/disease
http://glyconavi.org/glycobio/glycosample/disease_stage
http://glyconavi.org/glycobio/glycosample/doi
http://glyconavi.org/glycobio/glycosample/genotype
http://glyconavi.org/glycobio/glycosample/glycosample_entry
http://glyconavi.org/glycobio/glycosample/glycosample_id
http://glyconavi.org/glycobio/glycosample/grant
http://glyconavi.org/glycobio/glycosample/has_resource
http://glyconavi.org/glycobio/glycosample/health_state
http://glyconavi.org/glycobio/glycosample/host
http://glyconavi.org/glycobio/glycosample/host_body_site
http://glyconavi.org/glycobio/glycosample/isolation_source
http://glyconavi.org/glycobio/glycosample/journal_name
http://glyconavi.org/glycobio/glycosample/journal_site
http://glyconavi.org/glycobio/glycosample/journal_title
http://glyconavi.org/glycobio/glycosample/lab_host
http://glyconavi.org/glycobio/glycosample/organism
http://glyconavi.org/glycobio/glycosample/passage_history
http://glyconavi.org/glycobio/glycosample/pmid
http://glyconavi.org/glycobio/glycosample/recombinant_information
http://glyconavi.org/glycobio/glycosample/sample_type
http://glyconavi.org/glycobio/glycosample/sex
http://glyconavi.org/glycobio/glycosample/strain
http://glyconavi.org/glycobio/glycosample/taxonomy_id
http://glyconavi.org/glycobio/glycosample/taxonomy_name
http://glyconavi.org/glycobio/glycosample/tissue_type
http://purl.org/dc/terms/identifier
*/

?>

</body>
</html>
