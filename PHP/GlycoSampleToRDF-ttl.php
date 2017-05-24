<?php
header('Content-Type: text/plain;charset=UTF-8');
ini_set('auto_detect_line_endings', 1);
ini_set('auto_detect_line_endings', 1);
date_default_timezone_set('Asia/Tokyo');
$timeHeader = date("Y-m-d_H-i-s");

//作成したいディレクトリ（のパス）
$directory_path = "RDF";    //この場合、同じ階層に「RDF」というディレクトリを作成する 
//「$directory_path」で指定されたディレクトリが存在するか確認
if(file_exists($directory_path)){
    //存在したときの処理
    echo "作成しようとしたディレクトリは既に存在します";
}else{
    //存在しないときの処理（「$directory_path」で指定されたディレクトリを作成する）
    if(mkdir($directory_path, 0777)){
        //作成したディレクトリのパーミッションを確実に変更
        chmod($directory_path, 0777);
        //作成に成功した時の処理
        echo "作成に成功しました";
    }else{
        //作成に失敗した時の処理
        echo "作成に失敗しました";
    }
}

//$fileHeader = date("Y-m-d");
$savepath = $directory_path.DIRECTORY_SEPARATOR."GlycoNAVI-GlycoSample_".$timeHeader.".ttl";

$DataString = "@prefix gs: <http://glyconavi.org/glycobio/glycosample/> .\n";
$DataString .= "@prefix dcterms: <http://purl.org/dc/terms/> .\n";
$DataString .= "@prefix xsd: <http://www.w3.org/2001/XMLSchema#> .\n";
$DataString .= "@prefix rdfs:  <http://www.w3.org/2000/01/rdf-schema#> .\n";
$DataString .= "@prefix rdf:   <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .\n";
$DataString .= "@prefix fabio: <http://purl.org/spar/fabio/> .\n";
//$DataString .= "@prefix skos: <http://www.w3.org/2004/02/skos/core#> .\n";
$DataString .= "\n";

file_put_contents($savepath, $DataString, FILE_APPEND | LOCK_EX); //追記モード


$gssamplearray = array();

foreach(glob('./{*.tsv}',GLOB_BRACE) as $file) {
    if(is_file($file)) {
        $gssamplearray[] = $file;
    }
}

sort($gssamplearray);

// get file names
foreach($gssamplearray as $file) {
    if(is_file($file)) {
        // get file path
        echo htmlspecialchars($file)."\n";
        // lines
        $lines = array();
        try {
            $filedata = file_get_contents($file);
            $str = str_replace(array("\r\n","\r","\n"), "\n", $filedata);
            $lines = explode("\n", $str);
        }
        catch (Exception $e) {
            echo $e;
        }

        $GSID = "";
        $ResourceURI = "";

        
        foreach ($lines as $line) {
            
            
            try {
                
                $DataString = "";
                $datas = explode("\t", $line);

                if (count($datas) > 1 ) { //&& strlen($datas[1]) > 0) {
                    if ($datas[0] == "glycosample_id") {
                        $DataString .= "gs:Glycosample\tgs:has_resource\tgs:".$datas[1].".\n";
                        $DataString .= "gs:".$datas[1]."\tgs:".$datas[0]."\t\"".$datas[1]."\".\n";
                        $DataString .= "gs:".$datas[1]."\tdcterms:identifier\t\"".$datas[1]."\".\n";
                        $DataString .= "gs:".$datas[1]."\trdf:type\tgs:Sample.\n";
                        $ResourceURI = "gs:".$datas[1];
                        $GSID = $datas[1];
                    }

                    else if ($datas[0] == "glycosample_entry") {
                        $count = 0;
                        foreach ($datas as $data) {
                            if ($count != 0) {
                                if (strlen($data) > 0 && $data != "not data") {
                                    $DataString .= $ResourceURI."\tgs:".$datas[0]."\tgs:".$data.".\n";
                                    $DataString .= $ResourceURI."_E".$count."\trdf:type\tgs:Sample_Entry.\n";
                                    $DataString .= "gs:".$datas[0]."\trdf:label\t\"".strtoupper(str_replace("_", " ", $datas[0]))."\".\n";
                                }
                            }
                            $count++;
                        }
                    }
                    else {
                        $count = 0;
                        foreach ($datas as $data) {
                            if ($count != 0) {
                                if (strlen($data) > 0 && $data != "not data") {
                                    $DataString .= $ResourceURI."_E".$count."\tgs:".$datas[0]."\t\"".$data."\".\n";
                                    $DataString .= "gs:".$datas[0]."\trdf:label\t\"".strtoupper(str_replace("_", " ", $datas[0]))."\".\n";
                                }

                                if ($datas[0] == "pmid") {
                                    $DataString .= $ResourceURI."_E".$count."\tdcterms:reference\t<http://identifiers.org/pubmed/".$data.">.\n";
                                    $DataString .= "<http://identifiers.org/pubmed/".$data.">\tdcterms:identifier\t\"".$data."\".\n";
                                    $DataString .= "<http://identifiers.org/pubmed/".$data.">\trdf:type\tfabio:JournalArticle .\n";
                                    $DataString .= "dcterms:reference\trdf:label\t\"PMID or DOI\" .\n";
                                }
                                if ($datas[0] == "doi") {
                                    $DataString .= $ResourceURI."_E".$count."\tdcterms:reference\t<http://doi.org/".$data.">.\n";
                                    $DataString .= "<http://doi.org/".$data.">\tdcterms:identifier\t\"".$data."\".\n";
                                    $DataString .= $ResourceURI."_E".$count."\tdcterms:reference\t<http://identifiers.org/doi/".$data.">.\n";
                                    $DataString .= "<http://doi.org/".$data.">\trdf:type\tfabio:JournalArticle .\n";
                                    $DataString .= "dcterms:reference\trdf:label\t\"PMID or DOI\" .\n";
                                }
                            }
                            $count++;
                        }
                    }

                    echo $DataString;
                    file_put_contents($savepath, $DataString, FILE_APPEND | LOCK_EX); //追記モード
                }

            }
            catch (Exception $e) {
                echo "ERROR: ".$line."/n";
            }
        }
        file_put_contents($savepath, "\n", FILE_APPEND | LOCK_EX); //追記モード
    }
    echo "wrote $file...\n".htmlspecialchars($file)."\n";
}
echo "fin...";
?>  