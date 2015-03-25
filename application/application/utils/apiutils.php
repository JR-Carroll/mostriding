<?php
class SNController extends CI_Controller {
    protected $card;
    protected $transaction;
    protected $customerBill;
    protected $customerShip;
    protected $inputValues;
    protected $merchantKey;

    protected function varDump($v, $msg="")
    {
        echo "<pre>".$msg; var_dump($v); echo "</pre>";
    }

    protected function varDumpStr($v, $msg="") {
      ob_start();
      var_dump($v);
      $result = ob_get_contents();
      ob_end_clean();
      return "<pre>".$msg.$result."</pre>";
    }

    protected function getCookies()
    {
        return $_COOKIE;
    }

    protected function getMerchantKey()
    {
        if ($this->merchantKey != null)
            return $this->merchantKey->getArray();

        $merchantKey = new ArrayObj;
        try
        {
            //$inputValues = parseCookie($this->getCookies(), "InputValues");
            //$merchantKey->GROUPID = isset($inputValues["myGroupID"]) ? $inputValues["myGroupID"] : 0;
			$merchantKey->GROUPID = 0;
            $merchantKey->SECURENETID = '8003668';			  
            $merchantKey->SECUREKEY = "5p0CEH5jUxpL";
        }
        catch (Exception $e)
        { }

        $this->merchantKey = $merchantKey;
        return $merchantKey->getArray();
    }

    protected function saveCookie() {
        $cookie = array( 'name' => 'InputValues', 'value' => http_build_query($this->inputValues->getArray()), 'expire' => '86400' );
        $this->input->set_cookie($cookie);
    }

    protected function saveUIData($inputData) { // save input as response cookie
        $this->getMerchantKey();
        $this->inputValues = new ArrayObj($inputData);
        $this->inputValues->mySecureNetID = $this->merchantKey->SECURENETID;
        $this->inputValues->mySecureNetKey = $this->merchantKey->SECUREKEY;
        $inputValuesCookie = parseCookie($this->getCookies(), "InputValues");
        if ($inputValuesCookie != null && isset($inputValuesCookie["myUserID"])) {
            $userID = $inputValuesCookie["myUserID"];
            if ($userID != null)
                $this->inputValues->myUserID = $inputValuesCookie["myUserID"];
            if (isset($inputValuesCookie["myGroupID"])) {
                $groupID = $inputValuesCookie["myGroupID"];
                if ($groupID != null)
                    $this->inputValues->myGroupID = $inputValuesCookie["myGroupID"];
            }
        }
        $this->saveCookie();
    }
}

function varDumpStr($v, $msg="") { 
  ob_start();
  var_dump($v);
  $result = ob_get_contents();
  ob_end_clean();
  return "<pre>".$msg.$result."</pre>";
}

function nullToStr($v)
{
    return is_null($v) ? "" : $v;
}

function parseCookie($cookies, $name) { // parse a cookie value with a url param style value
    if (!array_key_exists($name,$cookies))
        return null;
    $cookie = $cookies[$name];
    return parseParams($cookie);
}

function parseParams($query) {
    $queryParts = explode('&', $query);

    $params = array();
    foreach ($queryParts as $param) {
        $item = explode('=', $param);
        $params[$item[0]] = urldecode($item[1]);
    }

    return $params;
}

?>
