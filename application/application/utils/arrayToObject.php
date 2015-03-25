<?php
function ArrayToObject($array) {
  $obj = new stdClass;
  foreach($array as $k => $v) {
     if(strlen($k)) {
        if(is_array($v)) {
           $obj->{$k} = ArrayToObject($v);
        } else {
           $obj->{$k} = $v;
        }
     }
  }
  return $obj;
}
class ProcessGatewayResponse
{
	public $response; // GATEWAYRESPONSE
	public $responseStr;
}
class ArrayObj {
    public $ary;

    function __construct($a = NULL) {
        $this->setAry($a);
    }

    function __get($p) {
        return array_key_exists($p, $this->ary) ? $this->ary[$p] : null;
    }

    function __set($k, $v) {
        $this->ary[$k] = $v;
    }

    public function __clone() {
        $this->setAry($this->ary);
    }

    private static function copyAry($ary) {
        $a = array();
        foreach ($ary as $k => $v) {
            if (is_array($v))
                $a[$k] = ArrayObj::copyAry($v);
            else if (is_object($v))
                $a[$k] = clone $v;
            else
                $a[$k] = $v;
        }
        return $a;
    }

    public static function toAry($obj) {
        $a = (array)$obj;
        foreach ($a as $k => $v) {
            if (is_object($v)) {
                $a[$k] = ArrayObject::toAry($v);
            }
        }
        return $a;
    }

    public function setAry($ary) {
        if (is_null($ary)) {
            $this->ary = array();
            return;
        }
        $this->ary = self::copyAry($ary);
    }

    protected static function copyAryOfObj($a) {
        $aa = array();
        foreach ($a as $k => $v) {
            if ($v instanceof ArrayObj) {
                $aa[$k] = $v->getArray();
            }
            else if (is_array($v)) {
                $aa[$k] = ArrayObj::copyAryOfObj($v);
            }
            else {
                $aa[$k] = $v;
            }
        }
        return $aa;
    }

    public function getArray() {
        return ArrayObj::copyAryOfObj($this->ary);
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->ary[] = $value;
        } else {
            $this->ary[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->ary[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->ary[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->ary[$offset]) ? $this->ary[$offset] : null;
    }
}

?>
