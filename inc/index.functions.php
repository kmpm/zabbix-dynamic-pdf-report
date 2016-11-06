<?php
// FUNCTIONS
function ReadArray($array) {
	foreach($array as $key=>$value) {
		$name = $array[$key]['name'];
		if (isset($array[$key]['hostid'])) {
			$id   = $array[$key]['hostid'];
		}
		elseif (isset($array[$key]['groupid'])) {
			$id   = $array[$key]['groupid'];
		}
		else {
			$id   = $name;
		}
		echo "<option value=\"$id\">$name</option>\n";
	}
}



function listdir_by_date($path){
    $dir = opendir($path);
    $list = array();
    while($file = readdir($dir)){
        if ($file != '.' and $file != '..'){
            // add the filename, to be sure not to
            // overwrite a array key
            $ctime = filemtime("$path/$file") . ',' . $file;
            $list[$ctime] = $file;
        }
    }
    closedir($dir);
    krsort($list);
    return $list;
}

function ListOldReports($dir) {
	#$dir_files = array_diff(scandir($dir), array('..', '.'));
	$dir_files = listdir_by_date($dir);
	echo "<thead>";
	echo "<tr><th>Report timestamp</th><th align=\"left\">Report</th></tr>\n";
	echo "</thead>";
	echo "<tbody>";
	foreach ($dir_files as $fdate => $fname) {
		$fdate = explode(",",$fdate);
		$fdate = date("Y.m.d H:i:s", $fdate[0]);
		echo "<tr><td>$fdate</td><td align=\"left\"><a href=\"reports/$fname\">$fname</a></td></tr>\n";
	}
	echo "</tbody>";
}
?>
