<?php
header('Content-Type: text/plain;charset=UTF-8');
ini_set('auto_detect_line_endings', 1);
ini_set('auto_detect_line_endings', 1);
date_default_timezone_set('Asia/Tokyo');
$timeHeader = date("Y-m-d_H-i-s");
    
$spqrqldata = "http://rdf.glyconavi.org:8890/sparql?default-graph-uri=&query=prefix+gs%3A+%3Chttp%3A%2F%2Fglyconavi.org%2Fglycobio%2Fglycosample%2F%3E%0D%0Aselect+distinct+%3Fgsid+%3Forganism+%3Ftaxonomy_name+%3Fprovider+%3Ftissue_type+%3Fcell_line+%3Fdisease%0D%0Afrom+%3Chttp%3A%2F%2Fglyconavi.org%2Fdatabase%2Fglycosample%3E%0D%0Awhere+%7B%0D%0A%3Fgs+%3Chttp%3A%2F%2Fpurl.org%2Fdc%2Fterms%2Fidentifier%3E+%3Fgsid+.%0D%0A%3Fgs%09gs%3Aglycosample_entry%09%3Fentry+.%0D%0A%0D%0AOPTIONAL+%7B%0D%0A%3Fentry+gs%3Aorganism+%3Forganism+.%0D%0A%7D%0D%0AOPTIONAL+%7B%0D%0A%3Fentry+gs%3Ataxonomy_name+%3Ftaxonomy_name+.%0D%0A%7D%0D%0AOPTIONAL+%7B%0D%0A%3Fentry+gs%3Abiomaterial_provider+%3Fprovider+.%0D%0A%7D%0D%0AOPTIONAL+%7B%0D%0A%3Fentry+gs%3Atissue_type+%3Ftissue_type+.%0D%0A%7D%0D%0AOPTIONAL+%7B%0D%0A%3Fentry+gs%3Acell_line+%3Fcell_line+.%0D%0A%7D%0D%0AOPTIONAL+%7B%0D%0A%3Fentry+gs%3Adisease+%3Fdisease+.%0D%0A%7D%0D%0A%0D%0A%0D%0A%7D%0D%0Aorder+by+DESC+%28%3Forganism%29+%3Fgsid&should-sponge=&format=application%2Fsparql-results%2Bjson&timeout=0&debug=on";
$getdata = file_get_contents($spqrqldata);
echo $getdata;

?>