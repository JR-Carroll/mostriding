<?php
// RESTful SecureNet Gateway Transaction Class
// Author: William Brall
// Created on: May/25/2010
// Usage: This class enables PHP applications to easily talk to the
//		SecureNet Gateway API for secure transactions. Please see
//		included documentation for data formatting instructions.
class Gateway
{
	private $host 		= "certify.securenet.com";
	private $base_url 	= "https://certify.securenet.com/api/gateway.svc/wsHttp";
	private $format;
	public $soap;
	private $soap_url	= "https://certify.securenet.com/api/gateway.svc/soap";

	// format choices: 0 - 'xml'; 1 - 'array'; 2 - 'simplexml'; 3 - 'soap';
	public function __construct($format = 3)
	{
		if($format == "soap" OR $format == 3)
		{
			$this->host 	= "certify.securenet.com";
			$this->base_url = "http://certify.securenet.com/api/gateway.svc?wsdl";
			$this->soap_url = "https://certify.securenet.com/api/gateway.svc/soap";
			$this->soap = new SoapClient($this->base_url);
			$this->soap->__setLocation($this->soap_url);
		}
		else
		{
			$this->host 	= "certify.securenet.com";
			$this->base_url = "https://certify.securenet.com/api/gateway.svc/wsHttp";
		}
		$this->format = $format;
	}
	
	// Lists the valid methods you can use in this class, not very useful but can speed up dev time.
	public function methods()
	{
		echo "->ProcessTransaction(\$data[]);<br>\n";
		echo "->ProcessVaultTransaction(\$data[]);<br>\n";
		echo "->UpdateTransaction(\$data[]);<br>\n";
		echo "->ProcessAccount(\$data[]);<br>\n";
		echo "->ProcessCustomer(\$data[]);<br>\n";
		echo "->ProcessCustomerAndAccount(\$data[]);<br>\n";
		echo "->AddABAccount(\$data[]);<br>\n";
		echo "->UpdateABAccount(\$data[]);<br>\n";
		echo "->UpdateABSchedule(\$data[]);<br>\n";
	}
	
	// This magic method allows for the selection of the above methods in the format: $response = $Gateway_object->method_name($array_of_data);
	public function __call($name, $request)
	{
		if(is_object($this->soap))
		{
			switch($name)
			{
				case "ProcessTransaction":
				case "AddABAccount":
				case "UpdateABAccount":
				case "UpdateABSchedule":
					$r["TRANSACTION"] = $request[0];
				break;
				
				case "ProcessVaultTransaction":
				case "UpdateTransaction":
				case "ProcessAccount":
				case "ProcessCustomer":
				case "ProcessCustomerAndAccount":
					$r["TRANSACTION_VAULT"] = $request[0];
				break;
				
				default:
                    $r = $request[0];
					//throw new Exception('Method Choice Error - '.$name.' is not a valid Gateway method name.');
					//return FALSE;
				break;
			}
			
			// Remove bool items
			$r = $this->soap_request($r);
			// No further formatting is offered for soap responses, as the soap response object is uber-powerful.
			$response = $this->soap->$name($r);
			
			//if($response->ProcessTransactionResult->TRANSACTIONRESPONSE->RESPONSE_CODE == 3)
			//{
			//	throw new Exception('Request Error - '.$response->ProcessTransactionResult->TRANSACTIONRESPONSE->RESPONSE_REASON_TEXT);
			//}
			return $response;
		}
		else
		{
			switch($name)
			{
				case "ProcessTransaction":
				case "AddABAccount":
				case "UpdateABAccount":
				case "UpdateABSchedule":
					$xml  = '<TRANSACTION xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://gateway.securenet.com/API/Contracts">';
					$xml .= $this->xmlize($request[0]);
					$xml .= '</TRANSACTION>';
				break;
				
				case "ProcessVaultTransaction":
				case "UpdateTransaction":
				case "ProcessAccount":
				case "ProcessCustomer":
				case "ProcessCustomerAndAccount":
					$xml  = '<TRANSACTION_VAULT xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://gateway.securenet.com/API/Contracts">';
					$xml .= $this->xmlize($request[0]);
					$xml .= '</TRANSACTION_VAULT>';
				break;
				
				default:
					throw new Exception('Method Choice Error - '.$name.' is not a valid Gateway method name.');
					return FALSE;
				break;
			}
			return $this->send($xml,$name);
		}
	}
	
	// Format Soap Request (recursive)
	private function soap_request($request)
	{
		ksort($request);
		foreach($request as $k => $v) // For each root key of the array structure,
		{
			if(is_array($v)) // if the value is an array,
			{
				$r[$k] = $this->soap_request($v); // We recurse into that array;
			} 
			elseif(!is_bool($v)) // however, if it is a bool value, we leave it out.
			{
				$r[$k] = $v; // Otherwise, we keep it around.
			} 	
		}
		return $r; // Then return it.
	}

	// Format Request as XML (recursive)
	private function xmlize($request)
	{
		$xml = '';
		
		ksort($request); // At one time, perhaps still, the items in the XML needed to be alphabetized. This does that.
		
		foreach($request as $k => $v) // For each root key of the array structure,
		{
			if(is_int($k))
			{
				$xml .= $this->xmlize($v);
			}
			elseif(is_array($v)) // if the value is an array,
			{
				$xml .= '<'.$k.'>';
				$xml .= $this->xmlize($v); // walk that new array like the first;
				$xml .= '</'.$k.'>';
			} 
			elseif(is_bool($v) OR $v === "" OR is_null($v)) // however, if it is a bool value or NULL,
			{
				$xml .= '<'.$k.' i:nil="true" />'; // write out the funny bool i:nil value.
			} 
			else // Otherwise, and these should all be strings, but it will accept ints or floats as well,
			{
				$xml .= '<'.$k.'>'.$v.'</'.$k.'>'; // just write the value into a standard tag structure.
			}
		}
		return $xml;	
	}
	
	// Sends a request to the desired method.
	private function send($request, $method)
	{
		$header[] = "Host: ".$this->host;
		$header[] = "Content-type: text/xml";
		$header[] = "Content-length: ".strlen($request) . "\r\n";
		$header[] = $request;
		
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $this->base_url.$method);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
		$result = curl_exec( $ch );
		curl_close($ch); 

		return $this->format_response($result);
	}
	
	// Formats the response based on a selection made when the object was instantiated.
	private function format_response($result)
	{
		// Detect for various types of errors.
		if(stristr($result, "Request Error") === FALSE AND stristr($result, "<RESPONSE_CODE>3") === FALSE)
		{
			// Select formatting type, this was chosen when the object was instantiated.
			switch(strtolower($this->format))
			{
				// Attempt to format as an Array. May fail for some Transaction Types.
				case "1":
				case "array":
					return xml2array($result);
				break;
				
				// Format as SimpleXML Elements. They aren't all that simple, really. :(
				case "2":
				case "simplexml":
					return simplexml_load_string($result);
				break;
				
				// Retain the XML formatting exactly as returned from the SecureNet Gateway.
				case "0":
				case "xml":
				default:
					return $result;
				break;
			}
		}
		// For Major Errors, causing the Gateway to Fail
		elseif(stristr($result, "<RESPONSE_CODE>3") === FALSE)
		{
			$err = explode('<P class="intro">',$result);
			$err = explode(" The exception stack trace is:</P>",$err[1]);
			throw new Exception('Major Request Error - '.$err[0]);
			return FALSE;
		}
		// For Lesser Errors, causing detailed Gateway Response Errors
		else
		{
			$err = explode('<RESPONSE_REASON_TEXT>',$result);
			$err = explode("</RESPONSE_REASON_TEXT>",$err[1]);
			throw new Exception('Request Error - '.$err[0]);
			return FALSE;
		}
	}
}

// The below function is useful for formatting some responses from the SecureNet Gateway as PHP Associative Arrays. 
// 	It may not always succeed, as XML and arrays can't always be interchanged.
//	Should this function fail on a request, try using 'simplexml' formatting instead.
//	Yes, I know that 'simplexml' isn't very simple, hence the inclusion of this function. :)

/**
 * xml2array() will convert the given XML text to an array in the XML structure.
 * Link: http://www.bin-co.com/php/scripts/xml2array/
 * Arguments : $contents - The XML text
 *                $get_attributes - 1 or 0. If this is 1 the function will get the attributes as well as the tag values - this results in a different array structure in the return value.
 *                $priority - Can be 'tag' or 'attribute'. This will change the way the resulting array sturcture. For 'tag', the tags are given more importance.
 * Return: The parsed XML in an array form. Use print_r() to see the resulting array structure.
 * Examples: $array =  xml2array(file_get_contents('feed.xml'));
 *              $array =  xml2array(file_get_contents('feed.xml'), 1, 'attribute');
 */ 
function xml2array($contents, $get_attributes=1, $priority = 'tag') {
    if(!$contents) return array();

    if(!function_exists('xml_parser_create')) {
        //print "'xml_parser_create()' function not found!";
        return array();
    }

    //Get the XML parser of PHP - PHP must have this module for the parser to work
    $parser = xml_parser_create('');
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);

    if(!$xml_values) return;//Hmm...

    //Initializations
    $xml_array = array();
    $parents = array();
    $opened_tags = array();
    $arr = array();

    $current = &$xml_array; //Refference

    //Go through the tags.
    $repeated_tag_index = array();//Multiple tags with same name will be turned into an array
    foreach($xml_values as $data) {
        unset($attributes,$value);//Remove existing values, or there will be trouble

        //This command will extract these variables into the foreach scope
        // tag(string), type(string), level(int), attributes(array).
        extract($data);//We could use the array by itself, but this cooler.

        $result = array();
        $attributes_data = array();
        
        if(isset($value)) {
            if($priority == 'tag') $result = $value;
            else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
        }

        //Set the attributes too.
        if(isset($attributes) and $get_attributes) {
            foreach($attributes as $attr => $val) {
                if($priority == 'tag') $attributes_data[$attr] = $val;
                else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
            }
        }

        //See tag status and do the needed.
        if($type == "open") {//The starting of the tag '<tag>'
            $parent[$level-1] = &$current;
            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
                $current[$tag] = $result;
                if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
                $repeated_tag_index[$tag.'_'.$level] = 1;

                $current = &$current[$tag];

            } else { //There was another element with the same tag name

                if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                    $repeated_tag_index[$tag.'_'.$level]++;
                } else {//This section will make the value an array if multiple tags with the same name appear together
                    $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
                    $repeated_tag_index[$tag.'_'.$level] = 2;
                    
                    if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                        $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                        unset($current[$tag.'_attr']);
                    }

                }
                $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
                $current = &$current[$tag][$last_item_index];
            }

        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
            //See if the key is already taken.
            if(!isset($current[$tag])) { //New Key
                $current[$tag] = $result;
                $repeated_tag_index[$tag.'_'.$level] = 1;
                if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;

            } else { //If taken, put all things inside a list(array)
                if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...

                    // ...push the new element into that array.
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                    
                    if($priority == 'tag' and $get_attributes and $attributes_data) {
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag.'_'.$level]++;

                } else { //If it is not an array...
                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
                    $repeated_tag_index[$tag.'_'.$level] = 1;
                    if($priority == 'tag' and $get_attributes) {
                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                            
                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                            unset($current[$tag.'_attr']);
                        }
                        
                        if($attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                        }
                    }
                    $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
                }
            }

        } elseif($type == 'close') { //End of tag '</tag>'
            $current = &$parent[$level-1];
        }
    }
    
    return($xml_array);
}  

?>
