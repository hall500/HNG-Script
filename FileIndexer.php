<?php
  class FileIndexer {
    private static $home = "scripts/";
    private static $files = array();
    private static $command_scripts = [
      'js' => 'node',
      'py' => 'python',
      'php' => 'php',
      'cpp' => 'cpp'
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

        $last_line = @exec($command, $output, $return_var);
        if($return_var == 0){
            return $last_line;
        }else{
            return false;
        }
    }

    public static function executeCommand($command = ''){
      try{
        $result = @self::command_handler($command);
        return $result != false ? $result: NULL;
      }catch(\Exception $e){
        //echo "Error : " . $e->getMessage();
        echo "An Error occurred\n";
        die();
      }
    }

    public static function canExecuteCommand($file_type = '', $fail_message = ''){
        if(!isset(self::$command_scripts[$file_type])){
          print "." . $file_type . " File Format is not supported\n";
          return false;
        }
        $command = "which " . self::$command_scripts[$file_type] . " 2>nul";
        $output = @self::executeCommand($command, $fail_message);
        return ($output == NULL) ? false : true;
    }

    public static function computeFiles($file_type = '', $error_message = 'server not running'){
      $data = [];

      if(!self::canExecuteCommand($file_type)){
        print $file_type . " " . $error_message . "\n";
        return false;
      }

      $files = self::scripts($file_type);
      $command = "which " . self::$command_scripts[$file_type];
      @self::executeCommand();
      foreach($files as $file){
          $extension = explode('.', $file);
          $command = self::$command_scripts[$file_type] . " " . $file . ' 2>nul';
          $exec = @self::executeCommand($command);
          $data[$extension[0]]['content'] = ($exec === NULL) ? 'Script Error' : $exec;;
          $data[$extension[0]]['status'] = testFileContent($exec);
          $data[$extension[0]]['name'] = $extension[0];
          $data[$extension[0]]['language'] = $extension[count($extension) - 1];
      }
      return $data;
    }
        
}