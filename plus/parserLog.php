<title>line bot log debug</title>
<?php
include '../libraries/functions.php';

$mod = 3;

$logs = file_get_contents('../log/log.txt');
$logs = explode("\n",$logs);
foreach($logs as $key => $data){
	$log = unserialize($data);
    if( $log !== false ){
        $tmp[] = $log;
    }
	if( $key % $mod == 2 ){
		dump($tmp);
		unset($tmp);
	}
}