<?php

require_once 'database/db_connect.php';

class User
{
    private $chatID;

    public function __construct($chatID)
    {
        $this->chatID = $chatID;

        if (!$this->isUserSet()) $this->makeUser();
    }
    public function makeAdmin(){
        global $db;

        $admin_name = $this->getAdminName();
        $admin_id  = $this->getAdminId();


        $query = "insert into `admin`(name,chat_id) values('{$admin_name}',{$admin_id})";

        if (!$db->query($query))

            die("пользователя создать не удалось");

    }
    function setAdminName($name){

        $this->setKeyValue('adminName',$name);

    }
    function getAdminName(){

       return  $this->getKeyValue('adminName');
    }
    function setAdminId($id){

      $this->setKeyValue('adminId',$id);

    }
    function getAdminId(){

      return  $this->getKeyValue('adminId');

    }
    private function makeUser()
    {

        global $db;

        $chatID = $db->real_escape_string($this->chatID);


        $query = "insert into `users`(chatID) values('{$chatID}')";

        if (!$db->query($query))

            die("пользователя создать не удалось");

    }
    private function isUserSet()
    {

        global $db;

        $chatID = $db->real_escape_string($this->chatID);


        $result = $db->query("select * from `users` where chatID='$chatID' LIMIT 1");

        $myArray = (array)($result->fetch_array());

        if (!empty($myArray)) return true;

        return false;

    }
    function setProduct($product)
    {

        $this->setKeyValue('product', json_encode($product, JSON_UNESCAPED_UNICODE));

    }

    function getProduct()
    {

        return json_decode($this->getKeyValue('product'), true);

    }


    function setLanguage($lang)
    {

        $this->setKeyValue('lang', $lang);

    }

    function getLanguage()
    {

        return $this->getKeyValue('lang');

    }

    function setPage($page)
    {

        return $this->setKeyValue('page', $page);

    }

    function getPage()
    {

        return $this->getKeyValue('page');

    }
    function setCategoryId($category)
    {

        $this->setKeyValue('categoryId', $category);

    }

    function getCategoryId()
    {

        return $this->getKeyValue('categoryId');

    }

    function setLatitude($data)
    {

        $this->setKeyValue('latitude', $data);

    }

    function getLatitude()
    {

        return $this->getKeyValue('latitude');

    }

    function setLongitude($data)
    {

        $this->setKeyValue('longitude', $data);

    }

    function getLongitude()
    {

        return $this->getKeyValue('longitude');

    }
    function setPhoneNumber($phoneNumber)
    {

        $this->setKeyValue('phoneNumber', $phoneNumber);

    }

    function getPhoneNumber()
    {

        return $this->getKeyValue('phoneNumber');

    }
    function setFirstName($data)
    {

        $this->setKeyValue('firstName', $data);

    }

    function getFirstName()
    {

        return $this->getKeyValue('firstName');

    }
    function setOrderType($orderType)
    {

        $this->setKeyValue('orderType', $orderType);

    }

    function setOrderText($data)
    {

        $this->setKeyValue('orderText', $data);

    }

    function getOrderText()
    {

        return $this->getKeyValue('orderText');

    }
    function getOrderType()
    {

        return $this->getKeyValue('orderType');

    }



    function setKeyValue($key, $value)
    {

        global $db;

        $chatID = $db->real_escape_string($this->chatID);

        $value = base64_encode($value);

        if (!$this->isUserSet()) {

            $this->makeUser(); // если каким-то чудом этот пользователь не зарегистрирован в базе

        }

        $data = $this->getData();

        $data[$key] = $value;

        $data = json_encode($data, JSON_UNESCAPED_UNICODE);

        return $db->query("update `users` SET data_json = '{$data}' WHERE chatID = '{$chatID}'"); // обновляем запись в базе

    }

    function getKeyValue($key)
    {

        $data = $this->getData();

        if (array_key_exists($key, $data)) {

            return base64_decode($data[$key]);

        }

        return "";


    }

    private function getData()
    {

        global $db;

        $res = array();

        $chatID = $db->real_escape_string($this->chatID);

        $result = $db->query("select * from `users` where chatID='$chatID'");

        $arr = $result->fetch_assoc();

        if (isset($arr['data_json'])) {

            $res = json_decode($arr['data_json'], true);

        }


        return $res;

    }
}