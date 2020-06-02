<?php


$json = $_SERVER["QUERY_STRING"] ?? '';

$files = scandir("scripts/");

unset($files[0]);
unset($files[1]);
print_r($files);
exit;
$output = [];

foreach($files as $file){

    $extension = explode('.', $file);

    switch($extension[1]){
        case 'php':
            $startScript = "php";
            break;
        case 'js':
            $startScript = "node";
            break;
        case 'py':
            $startScript = "python";
            break;
    }

    $f = exec($startScript . " scripts/".$file);
    $output[] = ['content' => $f, 'status' => testFileContent()];
}

function testFileContent($string){
    if(preg_match('/^Hello\sWorld[,|.|!]*\sthis\sis\s[a-zA-Z]{2,}\s[a-zA-Z]{2,}(\s[a-zA-Z]{2,})?\swith\sHNGi7\sID\s(HNG-\d{3,})\susing\s[a-zA-Z]{3,}\sfor\sstage\s2\stask.?$/i',trim($string))){
        return 'Pass';
    }

    return 'Fail';
}

function can_run_command($module = ''){
    return exec($module);
}


