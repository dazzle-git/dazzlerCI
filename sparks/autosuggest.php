<?php
/*====================== Database Connection Code Start Here ======================= */

define ("DB_HOST", "localhost"); // set database host
define ("DB_USER", "root"); // set database user
define ("DB_PASS","password"); // set database password
define ("DB_NAME","dazzler"); // set database name

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

/*====================== Database Connection Code End Here ========================== */

// Here, we will get user input data and trim it, if any space in that user input data
$user_input = trim($_REQUEST['term']);

// Define two array, one is to store output data and other is for display
$display_json = array();
$json_arr = array();
 

$user_input = preg_replace('/\s+/', ' ', $user_input);

$query = 'SELECT * FROM user bg WHERE bg.userEmail LIKE "%'.$user_input.'%"';
 
$recSql = mysql_query($query);
if(mysql_num_rows($recSql)>0){
while($recResult = mysql_fetch_assoc($recSql)) {
  $json_arr["id"] = $recResult['userId'];;
  $json_arr["value"] = $recResult['userEmail'];
  $json_arr["label"] = '<a><img width="52px" height="52px" src="http://dazzler.com/images/noimage.gif"><span class="ui-detail"><span class="ui-label">' . $recResult['firstName'] . ' ' . $recResult['lastName'] . '</span><span class="ui-desc">' . $recResult['userEmail'] . '</span></span></a>';
  array_push($display_json, $json_arr);
}
} else {
  $json_arr["id"] = "#";
  $json_arr["value"] = "";
  $json_arr["label"] = "No Result Found !";
  array_push($display_json, $json_arr);
}
 
	
$jsonWrite = json_encode($display_json); //encode that search data
print $jsonWrite;
?>