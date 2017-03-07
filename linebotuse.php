<title>直接呼叫機器人</title>
<?php 

if( !empty($_POST['data']) ){
	include_once('controller/lineBotInterface.php');
	$linebot = new lineBotInterface();
	$linebot->replySetting($_POST['data']);
}else{

}
?>
<form method="post">
	<input type="text" name="data">
	<input type="submit" value="送出">
</form>