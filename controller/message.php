<?php
/**
 * 訊息處理
 * @create Jet.lin[2017-03-07]
 */
class message{
	/**
	 * 宣告type
	 */
	public $type;

	/**
	 * data
	 */
	public $data;

	/**
	 * 建構子
	 */
	public function __construct($param){
		$this->data = $param;
		$this->type = $param['message']['type'];
	}

	/**
	 * 設定訊息
	 */
	public function setting(){
		if( empty($this->type) || empty($this->data) ){
			return ;
		}

		try{
			require_once('./libraries/'.$this->type.'.php');

			$shunt = new $this->type($this->data);

			return $shunt->settings()->send();

		} catch (Exception $e) {
		    set_log('Caught exception: ',  $e->getMessage(), "\n");
		}
	}

	/**
	 * 解構子
	 */
	public function __destruct(){
		unset($this);
	}
}