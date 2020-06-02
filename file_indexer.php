<?php
  class FileIndexer {
    private static $home = "scripts/";
    private static $files = array();

    public static function scripts($file_type = ''){
      $filename = self::$home . '*.' . $file_type;
      foreach (glob($filename) as $file) {
          self::$files[] = $file;
      }
      return self::$files;
    }
  }