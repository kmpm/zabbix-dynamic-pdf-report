<?php
// FUNCTIONS
function tempdir($dir=false,$prefix='zabbix_report_') {
	$tempfile=tempnam($dir,$prefix);
	if (file_exists($tempfile)) { unlink($tempfile); }
	$old_umask = umask(0);
	mkdir($tempfile,0775);
	umask($old_umask);
	if (is_dir($tempfile)) { return $tempfile; }
}

function GetGraphImageById ($graphs, $stime, $period = 3600, $width, $height, $filename) {
	global $z_server, $z_user, $z_pass, $z_tmp_cookies, $z_url_index, $z_url_graph, $z_url_api, $z_login_data;
	// file names
	$filename_cookie = tempnam($z_tmp_cookies,"zabbix_cookie_");
	//setup curl
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $z_url_index);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $z_login_data);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $filename_cookie);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $filename_cookie);
	// login	
	$output=curl_exec($ch);
	// get graph
	// TODO: foreach ($graphs as $graphid) { $filename....
		$graphid = $graphs;
		//$image_file = $z_tmpimg_path ."/".$trimmed_hostname ."_" .$graphid .".png";
		curl_setopt($ch, CURLOPT_URL, $z_url_graph ."?graphid=" .$graphid ."&width=" .$width ."&height=" .$height ."&period=" .$period ."&stime=" .$stime);
		$output = curl_exec($ch);
		curl_close($ch);
		// delete cookie
		unlink($filename_cookie);
		$fp = fopen($filename, 'w');
		fwrite($fp, $output);
		fclose($fp);
	//}
}

function CreatePDF($hostarray) {
	global $stime, $timeperiod, $tmp_pdf_data, $z_tmpimg_path, $debug;

	foreach($hostarray as $key=>$host) {
		$hostid   = $hostarray[$key]['hostid'];
		$hostname = $hostarray[$key]['name'];
		$trimmed_hostname = str_replace(" ", "_",$hostname);

		if ($debug) { echo "<b>$hostname(id:$hostid)</b></br>\n"; }
		$fh = fopen($tmp_pdf_data, 'a') or die("Can't open $tmp_pdf_data for writing!");
		$stringData = "1<Graphs for ".$hostname.">\n";
		fwrite($fh, $stringData);
		fclose($fh);
		#$hostGraphs = ZabbixAPI::fetch_array('graph','get',array('output'=>'extend','hostids'=>$hostid))
		$hostGraphs = ZabbixAPI::fetch_array('graph','get',array('output'=>array('graphid','name'),'hostids'=>$hostid))
			or die('Unable to get graphs: '.print_r(ZabbixAPI::getLastError(),true));
		#var_dump($hostGraphs);
		asort($hostGraphs);
		foreach($hostGraphs as $graphkey=>$graphs) {
			$graphid    = $hostGraphs[$graphkey]['graphid'];
			$graphname  = $hostGraphs[$graphkey]['name'];
			$image_file = $z_tmpimg_path ."/".$trimmed_hostname ."_" .$graphid .".png";
			if ($debug) { echo "$graphname(id:$graphid)</br>\n"; }
			$fh = fopen($tmp_pdf_data, 'a') or die("Can't open $tmp_pdf_data for writing!");
			$stringData = "2<$graphname>\n";
			fwrite($fh, $stringData);
			$stringData = "[" .$image_file ."]\n";
			fwrite($fh, $stringData);
			GetGraphImageById($graphid,$stime,$timeperiod,'750','150',$image_file);
			fclose($fh);
			if ($debug) { ob_flush(); flush(); }
		}
	}
}
?>
