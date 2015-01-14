<?php

function startsWith($haystack, $needle) {
    return $needle === "" || strpos($haystack, $needle) === 0;
}

function endsWith($haystack, $needle) {
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}

function escapeJS($str) {
    return str_replace("'", "\'", $str);
}

function mediaUrl($filename) {
    return site_url("images/media/" . $filename);
}

function dispatchResponse($Response, $ResponseFormat = null) {

    $this->_helper->viewRenderer->setNoRender();

    $Response = $this->toXml($Response);

    switch ($ResponseFormat) {
        case "xml":
            header('Content-Type: text/xml');
            echo $Response;
            break;
        case "html":
            header('Content-Type: text/html');
            echo $Response;
            break;
        case "plain":
            print_r(Zend_Json::decode(Zend_Json::fromXml($Response), Zend_Json::TYPE_OBJECT));
            break;
        case "json":
        default:
            header('Content-Type: text/json');
            echo Zend_Json::fromXml($Response);
            break;
    }
}

//// General Functions Copy

/**
 * @name: GeneralFunctions.php
 * 
 * @desc: General usefull Functions for system.
 * 
 * @author: indianic
 */
function _pr($obj, $exit = 0) {
    echo "<pre>";
    if (!is_object($obj))
        print_r($obj);
    else {
        foreach ($obj as $index => $value) {
            printf("<br>%-20s => ", $index);
            print_r($value);
        }
    }
    echo "</pre>";
    if ($exit == 1) {
        exit();
    }
}

function file_check_exists($url) {
    $file_headers = @get_headers($url);
    if ($file_headers[0] == 'HTTP/1.1 404 Not Found') {
        $exists = false;
    } else {
        $exists = true;
    }

    return $exists;
}

function formatErrorMessage($varMessage) {
    $messageErr = '';

    if (!empty($varMessage)) {
        $messageErr = "<ul>";
        if (is_array($varMessage)) {
            foreach ($varMessage as $message) {
                if (is_array($message)) {
                    foreach ($message as $key => $val)
                        $messageErr .= "<li>" . $val . "</li>";
                } else {
                    $messageErr .= "<li>" . $message . "</li>";
                }
            }
        } else {
            $messageErr .= "<li>" . $varMessage . "</li>";
        }
        $messageErr .="</ul>";
    }

    return $messageErr;
}

function escapeString($string) {
    $tmpString = str_replace("&nbsp;", "#@#", $string);
    $tmpString = htmlspecialchars($tmpString, ENT_COMPAT, "ISO-8859-1");
    $tmpString = str_replace("#@#", "&nbsp;", $tmpString);
    return $tmpString;
}

function getLevel($val = 0, $maxVal = 0, $minVal = 0, $size = 5) {
    $Diff = $maxVal - $minVal;

    $incr = $Diff / $size;

    for ($size, $i = $minVal; $i < $maxVal; $size--, $i = $i + $incr) {
        if ($val < $i)
            break;
    }

    return $size;
}

function convertdateformat($date, $minfalg = '0') {
    $curr_date = explode('-', $date);
    //_pr($curr_date,1);
    if ($date != '') {
        if ($minfalg == '1')
            return @date('m-d-Y', mktime(0, 0, 0, $curr_date[1], $curr_date[2], $curr_date[0]));
        else
            return @date('Y-m-d', mktime(0, 0, 0, $curr_date[0], $curr_date[1], $curr_date[2]));
    }
}

/**
 * @name: curl_post(string)
 * 
 * @desc: Function to Send Curl Request
 * 
 * @author: indianic
 */
function curl_post($url, $postVar = null, $referer = null) {
    if (function_exists('curl_init')) {
        $ch = curl_init(); // Initialize a CURL session.     
        curl_setopt($ch, CURLOPT_URL, $url);  // Pass URL as parameter.
        curl_setopt($ch, CURLOPT_POST, true); // use this option to Post a form
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postVar); // Pass form Fields.

        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Return Page contents.

        $response = curl_exec($ch);  // grab URL and pass it to the variable.
        curl_close($ch);

        unset($ch);

        return $response;
    }

    return false;
}

/**
 * @name: makeObjects(string)
 * 
 * @desc: Function to change type to object
 * 
 * @author: indianic
 */
function makeObjects($array) {
    if (!is_array($array)) {
        return $array;
    }

    $object = new stdClass();
    if (is_array($array) && count($array) > 0) {
        foreach ($array as $name => $value) {
            if (!empty($name)) {
                $object->$name = makeObjects($value);
            }
        }
        return $object;
    } else {
        return FALSE;
    }
}

// Original PHP code by Chirp Internet: www.chirp.com.au
// Please acknowledge use of this code by including this header.
function truncateChars($string, $limit, $break = ".", $pad = "...") {
    // return with no change if string is shorter than $limit
    if (strlen($string) <= $limit)
        return $string;

    // is $break present between $limit and the end of the string? 
    if (false !== ($breakpoint = strpos($string, $break, $limit))) {
        if ($breakpoint < strlen($string) - 1) {
            $string = substr($string, 0, $breakpoint) . $pad;
        }
    }

    return $string;
}

/**
 * @name: truncateWords(string)
 * 
 * @desc: Function to truncate words
 * 
 * @author: indianic
 */
function truncateWords($input, $numwords, $padding = "") {
    $output = strtok($input, " \n");
    while (--$numwords > 0)
        $output .= " " . strtok(" \n");
    if ($output != $input)
        $output .= $padding;
    return $output;
}

/**
 * @name: abuseReplaceString(string)
 * 
 * @desc: Function to replace abusive words
 * 
 * @author: indianic
 */
function abuseReplaceString($defineArray, $replaceString, $stringContent, $keep_first_last = false, $replace_matches_inside_words = false) {
    if (!$keep_first_last && $replace_matches_inside_words)
        $stringContent = str_ireplace($defineArray, $replaceString, $stringContent);
    else {
        if (is_string($defineArray))
            $defineArray = array($defineArray);

        foreach ($defineArray as $word) {
            $word = trim($word);

            $replacement = '';

            $str = strlen($word);

            $first = ($keep_first_last) ? $word[0] : '';
            $str = ($keep_first_last) ? $str - 2 : $str;
            $last = ($keep_first_last) ? $word[strlen($word) - 1] : '';

            $replacement = (empty($replaceString)) ? str_repeat('*', $str) : $replaceString;

            if ($replace_matches_inside_words) {
                $stringContent = str_replace($word, $first . $replacement . $last, $stringContent);
            } else {
                $stringContent = preg_replace('/\b' . $word . '\b/i', $first . $replacement . $last, $stringContent);
            }
        }
    }

    return $stringContent;
}

/**
 * @name: abuseReplaceString(string)
 * 
 * @desc: Function to replace abusive words
 * 
 * @author: indianic
 */
function abuseReplaceWord($badword, $stringContent, $replaceString = '') {

    if (!is_array($badword))
        $badword = array("/([\W]+){$badword}([\W]+)/", "/([\W]+){$badword}([\W]+)/");

    if (empty($replaceString))
        $replaceString = str_repeat("*", strlen($badword));

    $stringContent = preg_replace($badword, "$1" . $replaceString . "$2", $stringContent);

    return $stringContent;
}

function getCurrentWeek($date) {
    //$date = '05/05/2011';
    // parse about any English textual datetime description into a Unix timestamp
    $ts = strtotime($date);
    // calculate the number of days since Monday
    $dow = date('w', $ts);
    $offset = $dow - 1;
    if ($offset < 0)
        $offset = 6;
    // calculate timestamp for the Monday
    $ts = $ts - $offset * 86400;
    // loop from Monday till Sunday
    for ($i = 0; $i < 7; $i++, $ts+=86400) {
        $week[] = date("Y-m-d", $ts);
    }

    return $week;
}

function getCurrentTwoWeek($date) {
    //$date = '05/05/2011';
    // parse about any English textual datetime description into a Unix timestamp
    $ts = strtotime($date);
    // calculate the number of days since Monday
    $dow = date('w', $ts);
    $offset = $dow - 1;
    if ($offset < 0)
        $offset = 6;
    // calculate timestamp for the Monday
    $ts = $ts - $offset * 86400;
    // loop from Monday till Sunday
    for ($i = 0; $i < 14; $i++, $ts+=86400) {
        $week[] = date("Y-m-d", $ts);
    }

    return $week;
}

function getCurrentDayName($date) {
    return strftime('%A', strtotime($date));
}

/**
 * @name: get_uuid(void())
 * 
 * @desc: Function to generate and return universally unique id
 * 
 * @author: indianic
 *
 * @return: string Universally Unique ID
 */
function get_uuid() {
    $rawid = strtoupper(md5(uniqid(rand(), true)));
    $workid = $rawid;

    // hopefully conform to the spec, mark this as a "random" type
    // lets handle the version byte as a number
    $byte = hexdec(substr($workid, 12, 2));
    $byte = $byte & hexdec("0f");
    $byte = $byte | hexdec("40?");
    $workid = substr_replace($workid, strtoupper(dechex($byte)), 12, 2);

    // hopefully conform to the spec, mark this common variant
    // lets handle the "variant"
    $byte = hexdec(substr($workid, 16, 2));
    $byte = $byte & hexdec("3f");
    $byte = $byte | hexdec("80?");
    $workid = substr_replace($workid, strtoupper(dechex($byte)), 16, 2);

    // build a human readable version
    $rid = substr($rawid, 0, 8) . '-'
            . substr($rawid, 8, 4) . '-'
            . substr($rawid, 12, 4) . '-'
            . substr($rawid, 16, 16);

    // build a human readable version
    $wid = substr($workid, 0, 8) . '-'
            . substr($workid, 8, 4) . '-'
            . substr($workid, 12, 4) . '-'
            . substr($workid, 16, 16);

    // -_-_?_-_?_-_?_-_?
    return $rid;
//	return $wid;
}

/**
 * @name: clean_dir(string,array)
 * 
 * @desc: Function to Clean up directory recursively
 * 
 * @author: indianic
 *
 * @var: string $dir - path of the directory to cleanup
 * @var: array $skipFiles -  array of files or dir to skip cleaning
 */
function clean_dir($dir, $skipFiles = array('.', '..')) {
    $dir .= (substr($dir, 0, -1) == '/') ? '' : '/';
    foreach (scandir($dir) as $file) {
        if (in_array($file, $skipFiles) === false) {
            if (is_dir($dir . $file))
                clean_dir($dir . $file);
            (is_dir($dir . $file)) ? rmdir($dir . $file) : unlink($dir . $file);
        }
    }
}

/**
  Chmods files and folders with different permissions.

  This is an all-PHP alternative to using: \n
  <tt>exec("find ".$path." -type f -exec chmod 644 {} \;");</tt> \n
  <tt>exec("find ".$path." -type d -exec chmod 755 {} \;");</tt>

  @author Jeppe Toustrup (tenzer at tenzer dot dk)
  @param $path An either relative or absolute path to a file or directory
  which should be processed.
  @param $filePerm The permissions any found files should get.
  @param $dirPerm The permissions any found folder should get.
  @return Returns TRUE if the path if found and FALSE if not.
  @warning The permission levels has to be entered in octal format, which
  normally means adding a zero ("0") in front of the permission level. \n
  More info at: http://php.net/chmod.
 */
function recursiveChmod($path, $filePerm = 0644, $dirPerm = 0777) {
    // Check if the path exists
    if (!file_exists($path)) {
        return(FALSE);
    }
    // See whether this is a file
    if (is_file($path)) {
        // Chmod the file with our given filepermissions
        @chmod($path, $filePerm);
        // If this is a directory...
    } elseif (is_dir($path)) {
        // Then get an array of the contents
        $foldersAndFiles = scandir($path);
        // Remove "." and ".." from the list
        $entries = array_slice($foldersAndFiles, 2);
        // Parse every result...
        foreach ($entries as $entry) {
            // And call this function again recursively, with the same permissions
            recursiveChmod($path . "/" . $entry, $filePerm, $dirPerm);
        }
        // When we are done with the contents of the directory, we chmod the directory itself
        @chmod($path, $dirPerm);
    }
    // Everything seemed to work out well, return TRUE
    return(TRUE);
}

/**
 * To Get auto Unique string 
 *
 * @param int $length
 * @return string
 * @author Jethva Manish
 */
function getUniqueCode($length = "") {
    $code = md5(uniqid(rand(), true));
    if ($length != "")
        return substr($code, 0, $length);
    else
        return $code;
}

/**
 * Download images from remote server
 *
 * @param string $inPath
 * @param string $outPath
 */
function save_image($inPath, $outPath) {
    $in = fopen($inPath, "rb");
    $out = fopen($outPath, "wb");
    while ($chunk = fread($in, 8192)) {
        fwrite($out, $chunk, 8192);
    }
    fclose($in);
    fclose($out);
}

function timeDifference($t1,$t2) {
    $time1 = new DateTime($t1);
    $time2 = new DateTime($t2);
    $interval = $time1->diff($time2);
    $y = $interval->format('%y');
    $out = $y." Years ago";
    if($y == 0){
        $y = $interval->format('%m');
        $out = $y." Months ago";
        if($y == 0){
           $y = $interval->format('%d');
           $out = $y." Days ago";
           if($y == 0){
              $y = $interval->format('%h'); 
              $out = $y." Hours ago";
              if($y == 0){
                  $y = $interval->format('%m'); 
                  $out = $y." Minutes ago";
                  if($y == 0){
                     $y = $interval->format('%s'); 
                     $out = $y." Seconds ago";
                  }
              }
           }
        }
    }
    return $out;
}

function GetTimeDifference($date) {
    if (empty($date)) {
        return "No date provided";
    }
    date_default_timezone_set('Asia/Kolkata');
    $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

    $now = time();
    //$date=substr($date,0,-3);
    $unix_date = strtotime($date);
    //return $unix_date." ".$now;
    // check validity of date
    if (empty($unix_date)) {
        return "Bad date";
    }
    // is it future date or past date
    if ($now > $unix_date) {
        $difference = $now - $unix_date;
        $tense = "ago";
    } else {
        $difference = $unix_date - $now;
        $tense = "now";
        //$tense         = "ago";
    }

    for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
        $difference /= $lengths[$j];
    }

    $difference = round($difference);

    if ($difference != 1) {
        $periods[$j].= "s";
    }

    return "$difference $periods[$j] {$tense}";
}

function getCountArr($array,$type){
    $c = 0;
    foreach($array as $key=>$val){
        if($val->type == $type){
            $c++;
            continue;
        }        
    }
    return $c;
}

function getLastTime($array,$type){
    $c = 0;
    foreach($array as $key=>$val){
        if($val->type == $type){
            $c = GetTimeDifference($val->dt);
            break;
        }        
    }
    return $c;
}

function formatbytes($size, $type)
{
   switch($type){
      case "KB":
         $filesize = $size * .0009765625; // bytes to KB
      break;
      case "MB":
         $filesize = ($size * .0009765625) * .0009765625; // bytes to MB
      break;
      case "GB":
         $filesize = (($size * .0009765625) * .0009765625) * .0009765625; // bytes to GB
      break;
   }
   if($size <= 0){
      return $filesize = '0'.' '.$type;}
   else{return round($filesize, 2).' '.$type;}
}