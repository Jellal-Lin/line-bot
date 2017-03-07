<?php

require_once('./model/firebaseModel.php');
// require_once('./config/constants.php');
require_once('./libraries/functions.php');
require_once('./libraries/sendData.php');

class text extends sendData {

    /**
     * firebase class
     */
    private $firebase;

    /**
     * 回傳token
     */
    public $replyToken;

    /**
     * 要傳出去的值
     */
    public $dataMessage;

    /**
     * 建構子
     */
    public function __construct($param) {
        parent::__construct($param);

        $this->firebase = new firebaseModel();

        $this->getMessage = $param['message']['text'];
        $this->user = $param['source']['userId'];
        $this->user = ( $this->user != null ) ? $this->user : $param['source']['roomId'];
        $this->user = ( $this->user != null ) ? $this->user : $param['source']['groupId'];

        $this->dir = './libraries/'.__CLASS__.'/';
    }

    /**
     * 制定送出的訊息
     */
    public function settings() {
        switch ($this->getMessage) {
            case '101地址' :
                $param = array(
                    'title' => '台北101大樓',
                    'address' => '110台北市信義區信義路五段7號',
                    'latitude' => '25.0339031',
                    'longitude' => '121.5645099'
                );
                $this->dataMessage = $this->dataTranslate($param, 'location');
                break;
            
            default :
                break;
        }
        return $this;
    }

    /**
     * 解構子
     */
    public function __destruct() {
        unset($this);
    }

}
