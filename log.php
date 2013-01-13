<?php
/*
 ******************************************************************************************************************
 *  Author:           Nam Tran, GreyHatApps LLC
 *  Email Address:    nam@greyhatapps
 *  Date Created:     1/16/2011
 *
 ******************************************************************************************************************
 *  Class: Log
 *
 *  Write to log files
 *
 ******************************************************************************************************************
 */
  include_once("core/object.php");

  class Log
  {
    public static function write($pFile, $pStr, $pPrint=false, $pDie=false)
		  {
		    $file = "logs/" . $pFile;
		    $debugHandle = fopen($file, 'a');
		    $traceStr = self::getCallTrace(debug_backtrace());
		    $debugString = "[" . date('F j, Y @ h:i:s A') . "] (" . $traceStr . ") \r\n" . $pStr . "\r\n";

		    if($pPrint)
		    {
		      echo $debugString;
		    }
		    fwrite($debugHandle, $debugString);
		    fclose($debugHandle);

		    if($pDie)
		      die("[DIE] " . $debugString);
		  }

    public static function writeThenDie($pFile, $pStr, $pPrint=false)
    {
		    $file = "logs/" . $pFile;
      self::write($pFile, $pStr, $pPrint, true);
    }

  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // +  getLastCall
  // +
  // +  Returns the most recent object in the debug_backtrace() array
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public static function getLastCall($pObjArray)
    {
      return $pObjArray[0];
    }

  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // +  getCallTrace
  // +
  // +  Returns the call string of which file and what lines
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public static function getCallTrace($pObjArray)
    {
      $str = "";

      foreach((array)$pObjArray as $obj)
      {
        $str .= basename($obj["file"]) . "::" . $obj["line"] . " >> ";
      }
      $str = rtrim($str, " >> ");

      return $str;
    }

  }
?>