<?php
//CONFIGURABLE
# zabbix server info(user must have API access)
$z_server       = 'http://ZabbixServer/zabbix/';
$z_user		= 'Admin';
$z_pass         = 'password';
# Temporary directory for storing pdf data and graphs - must exist
$z_tmp_path	= './tmp';
# Directory for storing PDF reports
$pdf_report_dir	= './reports';
# Root URL to reports
$pdf_report_url	= $z_server ."report/reports";
# paper settings
$paper_format	= 'A4'; // formats supported: 4A0, 2A0, A0 -> A10, B0 -> B10, C0 -> C10, RA0 -> RA4, SRA0 -> SRA4, LETTER, LEGAL, EXECUTIVE, FOLIO
$paper_orientation = 'portrait'; // formats supported: portrait / landscape
# time zone - see http://php.net/manual/en/timezones.php
$timezone	= 'Europe/Oslo';
# Logo used in PDF - may be empty
# TODO: Specify image size!
$pdf_logo	= './images/zabbix.png';
$company_name   = 'Zabbix';

//DO NOT CHANGE BELOW THIS LINE
$z_tmp_cookies 	= "/tmp/";
$z_url_index 	= $z_server ."index.php";
$z_url_graph	= $z_server ."chart2.php";
$z_url_api	= $z_server ."api_jsonrpc.php";
$z_login_data	= "name=" .$z_user ."&password=" .$z_pass ."&autologin=1&enter=Sign+in";
?>
