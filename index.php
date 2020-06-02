<?php
    include "./FileIndexer.php";

    /* $json = $_SERVER["QUERY_STRING"] ?? ''; */

    $data = [];

    if(function_exists('exec')){
        print "Exec is enabled\n";

        if(FileIndexer::checkIfFileExecutes('php') == null){
            print "PHP Server is not running and hence not working\n";
        }else{
            $php_files = FileIndexer::scripts('php');
            
            foreach($php_files as $file){
                $extension = explode('.', $file);
                $exec = FileIndexer::executeCommand("php " . $file);
                $data[$extension[0]]['content'] = $exec;
                $data[$extension[0]]['status'] = testFileContent($exec);
                $data[$extension[0]]['name'] = $extension[0];
            }
        }
        
        /* if(FileIndexer::checkIfFileExecutes('js') == null){
            print "Node Server is not running and hence not working\n";
        }else{
            $js_files = FileIndexer::scripts('js');
            foreach($js_files as $file){
                $extension = explode('.', $file);
                $exec = FileIndexer::executeCommand("node " . $file);
                $data[$extension[0]]['content'] = $exec;
                $data[$extension[0]]['status'] = testFileContent($exec);
                $data[$extension[0]]['name'] = $extension[0];
            }
        }

        if(FileIndexer::checkIfFileExecutes('py') == null){
            print "Python Server is not running and hence not working\n";
        }else{
            $py_files = FileIndexer::scripts('py');
            foreach($py_files as $file){
                $extension = explode('.', $file);
                $exec = FileIndexer::executeCommand("python " . $file);
                $data[$extension[0]]['content'] = $exec;
                $data[$extension[0]]['status'] = testFileContent($exec);
                $data[$extension[0]]['name'] = $extension[0];
            }
        } */
    }

    function testFileContent($string){
        if (preg_match('/^Hello\sWorld[,|.|!]*\sthis\sis\s[a-zA-Z]{2,}\s[a-zA-Z]{2,}(\s[a-zA-Z]{2,})?\swith\sHNGi7\sID\s(HNG-\d{3,})\susing\s[a-zA-Z]{3,}\sfor\sstage\s2\stask.?$/i', trim($string))) {
            return 'Pass';
        }

        return 'Fail';
    }

    print_r($data);
    exit;

