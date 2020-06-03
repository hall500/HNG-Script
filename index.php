<?php
    include "./FileIndexer.php";

    $json = $_SERVER["QUERY_STRING"] ?? '';

    $data = [];

    if(function_exists('exec')){
        print "Exec is enabled\n";

        $output = FileIndexer::computeFiles('php');
        print_r($output);
        echo "\n";
        $output = FileIndexer::computeFiles('py');
        print_r($output);
        $output = FileIndexer::computeFiles('js');
        print_r($output);
        exit;
    }

    function testFileContent($string) {
        if (preg_match('/^Hello\sWorld[,|.|!]?\sthis\sis\s[a-zA-Z]{2,}\s[a-zA-Z]{2,}(\s[a-zA-Z]{2,})?\swith\sHNGi7\sID\s(HNG-\d{3,})\susing\s[a-zA-Z|#]{2,}\sfor\sstage\s2\stask.?$/i', trim($string))) {
            return 'Pass';
        }

        return 'Fail';
    }

    if($json){

        print_r(json_encode($data));
        exit;
    }

    echo 'HTML text here';

