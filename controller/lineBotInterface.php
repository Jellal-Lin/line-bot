<?php
require_once('./core/LINEBotTiny.php');
require_once('./libraries/functions.php');

/**
 * LineBot Interface
 * @create Jet.lin[2017-03-07]
 */
class lineBotInterface{

	/**
	 * line bot tiny secret
	 *
	 * @var        string
	 */
	private $tinySecret = 'YOUR_KEY';

	/**
	 * line bot tiny aceess token
	 *
	 * @var        string
	 */
	private $tinyAccessToken = 'YOUR_KEY';

	/**
	 * line bot tiny class
	 */
	private $tiny;

	/**
	 * 建構子
	 */
	public function __construct(){
		$this->tiny = new LINEBotTiny($this->tinyAccessToken, $this->tinySecret);
	}

	/**
	 * message setting
	 * 若收到值，則接下一個分流，處理完後回傳訊息(統一格式)
	 */
	public function messageSetting(){
		$events = $this->tiny->parseEvents();

		if( empty($events) || !is_array($events) ){
			return ;
		}

		try{
			require_once('./controller/'.$events[0]['type'].'.php');

			$this->shunt = new $events[0]['type']($events[0]);

			$message = $this->shunt->setting();

			if( !empty($message) ){
				$this->tiny->replyMessage($message);
			}

		} catch (Exception $e) {
		    set_log('Caught exception: ',  $e->getMessage(), "\n");
		}
	}

	/**
	 * 直接操控機器人
	 * @return [type] [description]
	 */
	public function replySetting($rec_data){
		if( empty($rec_data) ){
			return;
		}

		require_once('./libraries/sendData.php');

		$data['replyToken'] = 'TARGET_TOKEN';
		$senddata = new sendData($data);
		$senddata->dataMessage = $senddata->dataTranslate($rec_data,'text');
		$message = $senddata->send('push');
		$this->tiny->replyMessage($message,'push');
		// dump($message);
	}

	/**
	 * 解構子
	 */
	public function __destruct(){
		unset($this);
	}
}