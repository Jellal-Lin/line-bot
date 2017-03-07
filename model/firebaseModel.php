<?php
require_once('./model/firebaseLib.php');

class firebaseModel{
    /**
     * firebase url
     *
     * @var        string
     */
    private $firebase_url = 'YOUR_FIREBASE';

    /**
     * firebase token
     *
     * @var        string
     */
    private $firebase_token = 'YOUR_TOKEN';

    /**
     * firebase class
     * @var [type]
     */
    private $firebase_lib;

    /**
     * 建構子
     */
    public function __construct(){
        $this->firebase_lib = new \Firebase\FirebaseLib($this->firebase_url, $this->firebase_token);
    }

    /**
     * 設定type
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function type($type){
        if( empty($type) ){
            return ;
        }
        $this->setType = $type.'/';
        return $this;
    }

    /**
     * 取得資料 - 介接
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function get($data){
        if( empty($data) || empty($this->setType) ){
            if( empty($this->setType) ){
                set_log('no type');
            }
            return;
        }

        $_firebase_data = explode('/',$data);

        if( isset($_firebase_data[0]) ){
            $_firebase_data[0] = urlencode($_firebase_data[0]);
        }
        $firebase_data = join('/',$_firebase_data);

        return $this->firebase_lib->get($this->setType.$firebase_data);
    }

    /**
     * 設定資料 - 介接
     * @param [type] $data [description]
     */
    public function set($path, $data){
        if( empty($path) || empty($data) || empty($this->setType) ){
            if( empty($this->setType) ){
                set_log('no type');
            }
            return;
        }

        $_firebase_data = explode('/',$path);

        if( isset($_firebase_data[0]) ){
            $_firebase_data[0] = urlencode($_firebase_data[0]);
        }
        $firebase_data = join('/',$_firebase_data);

       return  $this->firebase_lib->set($this->setType.$firebase_data, $data);
    }

    /**
     * 解構子
     */
    public function __destruct(){
        unset($this);
    }
}
