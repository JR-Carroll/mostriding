<?php
require_once dirname(__FILE__) . '/../securenet/class_gateway.php';
require_once dirname(__FILE__) . '/../utils/arrayToObject.php';
require_once dirname(__FILE__) . '/../models/sndata.php';
require_once dirname(__FILE__) . '/../utils/apiutils.php';

class Order extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();       
        $this->load->model('user');
        $this->load->model('schedule');
    }

    //------- loading login page------
    public function index()
    {
        
        if (!$this->session->userdata('user_id')) {
            $this->login();
        }
    }
    
    public function test(){
        $data = [];
        $data['content'] = $this->load->view('schedule/test', $data, true);
        $this->load->view('layouts/main', $data);
    }

    public function confirmation()
    {
        $data = array();
		print_r('Order Confirmation');
		var_dump($_REQUEST);
        //we insert the record in the db already
    }
    public function thankyou($confirmationNumber){
        //var_dump($_REQUEST);
        //var_dump($_POST);
    	$data['confirmationNumber'] = $confirmationNumber;
    	$data['content'] = $this->load->view('schedule/thankyou', $data, true);
    	$this->load->view('layouts/main', $data);
    }
    public function paymentOld()
    {
    	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/schedule.html');
        }
        
            $input = $this->input->post();
            $isGC = $input['isGC'];
            
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
            //$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
            $this->form_validation->set_rules('street_address', 'Address', 'trim|required');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('state', 'State', 'trim|required');
            $this->form_validation->set_rules('zip', 'Zip', 'trim|required');
            $this->form_validation->set_rules('cardNumber', 'Card Number', 'trim|required');
            $this->form_validation->set_rules('exp_month', 'Card Expiry Month', 'trim|required');
            $this->form_validation->set_rules('exp_year', 'Card Expiry Year', 'trim|required');
            $this->form_validation->set_rules('cvc', 'CVC', 'trim|required');
          	$isSuccess = false;   
          	$confirmationNumber = '';
          	$courseCode = '';
          	if($isGC == 0){
          	    $courseScheduleId = $input['course_schedule_id'];
          	    $data['courseSchedule'] = $this->schedule->getCourseSchedule($courseScheduleId);
          	    $courseCode = $data['courseSchedule']['course_code'];
          	    
          	    $data['isGC'] = false;
          	    $data['courseCode'] = '';
          	    
          	}else{
          	    $courseCode = $input['course_code'];
          	    $data['courseSchedule'] = false;
          	    $data['isGC'] = true;
          	    $data['courseCode'] = $courseCode;
          	}
          	
          	
            //template has errors
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = validation_errors();
                $data['input'] = $input;
            }else {
                //template is for saving
                //$data['success'] = 'Course Schedule Participant Added Successfully';
                
                 
                $participant = array();
                $participant = $input;
                
                
                $confirmationNumber='';
                
                unset($participant['save']);
                unset($participant['exp_month']);
                unset($participant['exp_year']);
                unset($participant['cvc']);
                unset($participant['cardNumber']);
                
                $dataInfo = [];
                $dataInfo['participant'] = $participant;
                $dataInfo['isGC'] = $isGC;
                
                //var_dump($res);
                $responseModel = $this->ProcessCardTransaction($input, number_format(getCoursePrice($courseCode)));
                //var_dump($responseModel->response->TRANSACTIONRESPONSE->RESPONSE_CODE);
                if($responseModel !== false && $responseModel->response->TRANSACTIONRESPONSE->RESPONSE_CODE == '1'){
                	$isSuccess = true;
                	$confirmationNumber = $responseModel->response->TRANSACTIONRESPONSE->TRANSACTIONID;
                	$participant['transaction_status'] = $confirmationNumber;//confirmation code;;
                	unset($participant['isGC']);
                	                	
                	if($isGC == 0){
                	   unset($participant['course_code']);
                	   $participant['course_schedule_id'] = $courseScheduleId;
                	   $res = $this->schedule->addCourseParticipant($participant);
                	}else{
                	   unset($participant['course_schedule_id']);
                	   $res = $this->schedule->addCourseGiftCertificatePurchases($participant); 
                	}
                	//print_r('success');
                }else if($responseModel === false){
                	$data['error'] = "Credit Card Error, please try again";
                	$data['input'] = $input;
                }else{
                	$data['error'] = $responseModel->response->TRANSACTIONRESPONSE->RESPONSE_REASON_TEXT;
                	//print_r('failure');
                	$data['input'] = $input;
                }
                
            }
    
    		if($isSuccess == true){
    			redirect('/order/thankyou/'.$confirmationNumber);
    		}else{
	            
	            $data['content'] = $this->load->view('schedule/register', $data, true);
	            $this->load->view('layouts/main', $data);
    		}
        
    }
    
    public function payment()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $protocol = '';
            if(isset($_SERVER['HTTPS'])){
                $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
            }
            else{
                $protocol = 'http';
            }
            redirect($protocol.'://'.$_SERVER['SERVER_NAME'].'/schedule.html');
        }
    
        $input = $this->input->post();
        $isGC = $input['isGC'];
    
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        //$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('street_address', 'Address', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('zip', 'Zip', 'trim|required');
//         $this->form_validation->set_rules('cardNumber', 'Card Number', 'trim|required');
//         $this->form_validation->set_rules('exp_month', 'Card Expiry Month', 'trim|required');
//         $this->form_validation->set_rules('exp_year', 'Card Expiry Year', 'trim|required');
//         $this->form_validation->set_rules('cvc', 'CVC', 'trim|required');
        $isSuccess = false;
        $confirmationNumber = '';
        $courseCode = '';
        if($isGC == 0){
            $courseScheduleId = $input['course_schedule_id'];
            $data['courseSchedule'] = $this->schedule->getCourseSchedule($courseScheduleId);
            $courseCode = $data['courseSchedule']['course_code'];
             
            $data['isGC'] = false;
            $data['courseCode'] = '';
             
        }else{
            $courseCode = $input['course_code'];
            $data['courseSchedule'] = false;
            $data['isGC'] = true;
            $data['courseCode'] = $courseCode;
        }
         
         
        //template has errors
        if ($this->form_validation->run() == FALSE) {
            $data['error'] = validation_errors();
            $data['input'] = $input;
        }else {
            //template is for saving
            //$data['success'] = 'Course Schedule Participant Added Successfully';
    
             
            $participant = array();
            $participant = $input;
    
    
            $confirmationNumber='';
    
            unset($participant['save']);
            unset($participant['exp_month']);
            unset($participant['exp_year']);
            unset($participant['cvc']);
            unset($participant['cardNumber']);
    
           
                //$participant['transaction_status'] = $confirmationNumber;//confirmation code;;
                unset($participant['isGC']);
            
                if($isGC == 0){
                    unset($participant['course_code']);
                    $participant['course_schedule_id'] = $courseScheduleId;
                    //$res = $this->schedule->addCourseParticipant($participant);
                }else{
                    unset($participant['course_schedule_id']);
                    //$res = $this->schedule->addCourseGiftCertificatePurchases($participant);
                }
                //print_r('success');
            
            $dataInfo = [];
            $dataInfo['participant'] = $participant;
            $dataInfo['courseCode'] = $courseCode;
            $dataInfo['isGC'] = $isGC;
            $dataInfo['amount'] = number_format(getCoursePrice($courseCode));
    
            $data['content'] = $this->load->view('schedule/processor', ['info' => $dataInfo], true);
            $this->load->view('layouts/main', $data);
        }
        /*
        if($isSuccess == true){
            redirect('/order/thankyou/'.$confirmationNumber);
        }else{
             
            $data['content'] = $this->load->view('schedule/register', $data, true);
            $this->load->view('layouts/main', $data);
        }
        */
    }
    
    public function paymentconfirm(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $protocol = '';
            if(isset($_SERVER['HTTPS'])){
                $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
            }
            else{
                $protocol = 'http';
            }
            redirect($protocol.'://'.$_SERVER['SERVER_NAME'].'/schedule.html');
        }
        
        if(count($_POST) != 0){
            $paymentSuccess = false;
            $postParams = json_decode($_POST['x_params'], true);
            $participant = $postParams['participant'];
            $courseCode = $postParams['courseCode'];
            $isGC = $postParams['isGC'];
            if(isset($_POST['x_response_code']) && isset($_POST['x_response_reason_code']) && $_POST['x_response_code'] == '1' && $_POST['x_response_reason_code'] == '1'){
                $paymentSuccess = true;
                
                $confirmationNumber = $_POST['x_trans_id'];
                
                
                $participant['transaction_status'] = $confirmationNumber;//confirmation code;;
                
                if($isGC == 0){
                    //unset($participant['course_code']);
                    //$participant['course_schedule_id'] = $courseScheduleId;
                    $res = $this->schedule->addCourseParticipant($participant);
                }else{
                    //unset($participant['course_schedule_id']);
                    $res = $this->schedule->addCourseGiftCertificatePurchases($participant);
                }
                
                $protocol = '';
                if(isset($_SERVER['HTTPS'])){
                    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
                }
                else{
                    $protocol = 'http';
                }
                $redirectUrl = ($protocol.'://'.$_SERVER['SERVER_NAME'].'/application/order/thankyou/'.$confirmationNumber);                
                $data['content'] = $this->load->view('schedule/redirect', ['redirectUrl' => $redirectUrl], true);
                $this->load->view('layouts/main', $data);
            }else{
                $additionalMsg = '';
                if(isset($_POST['x_response_reason_text'])){
                    $additionalMsg = $_POST['x_response_reason_text'];
                }
                
                $data['error'] = "Payment Failed: ".$additionalMsg;
                $data['content'] = $this->load->view('schedule/error', $data, true);
                $this->load->view('layouts/main', $data);
            }
        
        
        }
        //var_dump($_POST);
    }
    private function updateFromUIForCardTransaction($uiData)
    {
    	
    }
    protected function getMerchantKey()
    {
    	
    	$merchantKey = new ArrayObj;
    	try
    	{
    		$merchantKey->GROUPID = 0;
    		$merchantKey->SECURENETID = SECURENET_ID;
    		$merchantKey->SECUREKEY = SECURENET_KEY;
    	}
    	catch (Exception $e)
    	{ }
        	
    	return $merchantKey->getArray();
    }
    
    private function initializeTransaction($input)
    {
        
    	$transaction = new ArrayObj();
    	$transaction->MERCHANT_KEY = $this->getMerchantKey();
    	
    	
    	
    	$transaction->DEVELOPERID = "12345"; // your developer id
    	$transaction->VERSION = "v1.0"; // your app version
    
    	$customerBill = new ArrayObj();
    	$customerBill->ADDRESS = $input['street_address'];
    	$customerBill->EMAIL = $input['email'];
    	$customerBill->EMAILRECEIPT = "TRUE";
    	$customerBill->PHONE = $input['phone'];
    	$customerBill->CITY = '';//$input['city'];
    	$customerBill->COMPANY = "";
    	$customerBill->COUNTRY = "USA";
    	$customerBill->FIRSTNAME = $input['first_name'];
    	$customerBill->LASTNAME = $input['last_name'];
    	$customerBill->STATE = '';//$input['state'];
    	$customerBill->ZIP = '';//$input['zip'];
    
    	$customerShip = new ArrayObj();
    	$customerShip->CITY = "";
    	$customerShip->COMPANY = "";
    	$customerShip->COUNTRY = "USA";
    	$customerShip->FIRSTNAME = $input['first_name'];
    	$customerShip->LASTNAME = $input['last_name'];
    	$customerShip->STATE = "";
    
    	$transaction->DCI = 0;
    	$transaction->INSTALLMENT_SEQUENCENUM = 0;
    	$transaction->GROUPID = 0;
    	$transaction->OVERRIDE_FROM = 0;
    	$transaction->RETAIL_LANENUM = 0;
    	$transaction->TOTAL_INSTALLMENTCOUNT = 0;
    	$transaction->TRANSACTION_SERVICE = 0;
    	
    	//$this->transaction = $transaction;
    	$transaction->CUSTOMER_BILL = $customerBill;
    	//$transaction->customerShip = $customerShip;
    	//var_dump($transaction);
    	//die;
    	return $transaction;
    }
    private function ProcessCardTransaction($input, $amount)
    {
    	$card = new ArrayObj();  // CARD
    	
		$card->CARDNUMBER = nullToStr($input['cardNumber']);
    	$card->CARDCODE = nullToStr($input['cvc']);
    	$card->EXPDATE = nullToStr($input['exp_month'].$input['exp_year']);
    	
    	
    	$transaction = $this->initializeTransaction($input);
    
    	$transaction->AMOUNT = $amount;
    	$transaction->CODE = SNData::$codes["AUTH_CAPTURE"];
    	$transaction->METHOD = SNData::$methodCodes["CREDIT"];
    	$transaction->CARD = $card;
    	$transaction->ORDERID = "";
    	$transaction->CUSTOMERID = "";
    
    	$service = new ArrayObj(); // SERVICE
    	$service->GRATUITY = 0;
    	$service->SERVERNUM = "3";
    
    	$transaction->SERVICE = $service->getArray();
    
    	$gateway = $this->newGateway();
    
    	$responseModel = new ProcessGatewayResponse;
    
    	try {
    		$response = $gateway->ProcessTransaction(array('TRANSACTION' => $transaction->getArray()));
    		$responseModel->response = $response->ProcessTransactionResult;
    		$responseModel->responseStr = varDumpStr($responseModel->response);
    	}
    	catch (Error $e) {
    		//echo $e["message"];
    		return false;
    	}
    	//$this->load->view("templates/_GatewayTransactionResponse", array('user' => $responseModel));
    	return ($responseModel);
    }
    
    protected function newGateway()
    {
    	$base_url = "http://certify.securenet.com/api/gateway.svc?wsdl";
    	$soap_url = "https://certify.securenet.com/api/gateway.svc/soap";
    	$gatewaySoap = new SoapClient($base_url);
    	$gatewaySoap->__setLocation($soap_url);
    	return $gatewaySoap;
    }
    
}

?>
