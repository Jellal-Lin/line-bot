<?php
require_once('./libraries/functions.php');

class sendData{
	/**
	 * 允許轉換的類型
	 * @var array
	 */
	private $allowType = array('text','image','location','sticker');

	/**
	 * 建構子
	 */
	public function __construct($param){
		$this->param = $param;
		$this->replyToken = $param['replyToken'];
	}

	/**
	 * 要送出的訊息
	 *
	 * @return     array  ( description_of_the_return_value )
	 */
	public function send($type = 'general'){
		// 發送前準備動作 - 驗證 / 轉譯
		$this->_sendPrepare();

		switch($type){
			case 'general' : default :
				$messages['replyToken'] = $this->replyToken;
				break;
			case 'push' :
				$messages['to'] = $this->replyToken;
				break;
		}
		
		$messages['messages'] = $this->dataMessage;

		// setlog
		if( !empty($messages['messages']) ){
			set_log($this->param,$messages);
		}

		return $messages;
	}

	/**
	 * 發送前準備動作 - 驗證 / 轉譯
	 */
	private function _sendPrepare(){
		if( empty($this->dataMessage) || !is_array($this->dataMessage) ){
			return ;
		}
		
		foreach($this->dataMessage as $message){
			if( !is_array($message) ){
				$this->dataMessage = array($this->dataMessage);
			}
			break;
		}
	}

	/**
	 * 類型轉換
	 * @param  [type] $data [description]
	 * @param  [type] $type [description]
	 * @return [type]       [description]
	 */
	public function dataTranslate($data, $type){
		if( !in_array($type,$this->allowType) ){
			setlog('不允許轉換的類型'.$type);
			return ;
		}

		$returnData['type'] = $type;
		switch($type){
			case 'text' :
				$returnData['text'] = $data;
				break;
			case 'image' :
				$returnData['originalContentUrl'] = $data;
				$returnData['previewImageUrl'] = $data;
				break;
			case 'location' :
				$returnData['title'] = $data['title'];
				$returnData['address'] = $data['address'];
				$returnData['latitude'] = $data['latitude'];
				$returnData['longitude'] = $data['longitude'];
				break;
			case 'sticker' :
				$returnData['packageId'] = $data['packageId'];
				$returnData['stickerId'] = $data['stickerId'];
				break;
		}

		return $returnData;
	}

	/**
	 * 解構子
	 */
	public function __destruct(){
		unset($this);
	}
}