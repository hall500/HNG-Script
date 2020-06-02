<?php
  class FileIndexer {
    private static $home = "scripts/";
    private static $files = array();
    private static $command_scripts = [
      'js' => 'node',
      'py' => 'python',
      'php' => 'php'
    ];

    public static function scripts($file_type = ''){
      $filename = self::$home . '*.' . $file_type;
      foreach (glob($filename) as $file) {
          self::$files[] = $file;
      }
      return self::$files;
    }

    private static function command_handler($command = ''){
        $output = array();
        $return_var = -1;

        $last_line = exec($command, $output, $return_var);

        if($return_var == 0){
            return $last_line;
        }else{
            return false;
        }
    }

    public static function executeCommand($command = ''){
      try{
        $result = self::command_handler($command);
        return $result != false ? $result: null;
      }catch(\Exception $e){
        //echo "Error : " . $e->getMessage();
        echo "An Error occurred\n";
        die();
      }
    }

    public static function checkIfFileExecutes($file_type = '', $fail_message = ''){
        $command = self::$command_scripts[$file_type] . " test_scripts/server_running." . $file_type;
        return (self::executeCommand($command, $fail_message) == "Test") ? true : false;
    }
        
}