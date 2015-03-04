<html>
<head>
<style>
.reqfield
{
	color:red;
	font-weight:bold;
}
td,span,tr,table,p,body,input,select
{
	font-size:11px;
	font-family:verdana,arial;
}
.note
{
	font-size:9px;
	font-family:verdana,arial;
}
h1
{
	font-size:14px;
	font-family:verdana,arial;
	font-weight:bold;
}
h2
{
	font-size:13px;
	font-family:verdana,arial;
	font-weight:bold;
}
h3
{
	font-size:12px;
	font-family:verdana,arial;
	font-weight:bold;
}
</style>
</head>
<body>
<?php
require_once("class_gateway.php");
	if ($_POST["check"] != "")
	{
		$request["DCI"] 							= "0";
		$request["INSTALLMENT_SEQUENCENUM"] 		= "0";
		$request["OVERRIDE_FROM"] 					= "0";
		$request["RETAIL_LANENUM"] 					= "0";
		$request["TOTAL_INSTALLMENTCOUNT"] 			= "0";
		$request["TRANSACTION_SERVICE"] 			= "0";
		
		$request["AMOUNT"] 							= $_POST["transamount"];
		$request["CARD"]["CARDCODE"] 				= $_POST["cvvc"];
		$request["CARD"]["CARDNUMBER"] 				= $_POST["creditcardnum"];
		$request["CARD"]["EXPDATE"] 				= $_POST["ExpMonth"] ."".$_POST["ExpYear"];
		$request["CODE"] 							= $_POST["transactiontype"];
		$request["MERCHANT_KEY"]["GROUPID"] 		= "0";
		$request["MERCHANT_KEY"]["SECUREKEY"] 		= $_POST["securekey"];
		$request["MERCHANT_KEY"]["SECURENETID"] 	= $_POST["securenetid"];
		$request["METHOD"] 							= "CC";
		$request["ORDERID"] 						= $_POST["orderid"];
		$transactionType = $_POST["transactiontype"];
		if ($transactionType == "0200" || $transactionType == "0400" || $transactionType == "0300" || $transactionType == "0600")
		{
			$request["AUTHCODE"]						= $_POST["authroizationcode"];
		}
		else
		{
			$request["AUTHCODE"]						= "";
		}
		if ($transactionType == "0200" || $transactionType == "0400" || $transactionType == "0500")
		{	
			$request["REF_TRANSID"] 					= $_POST["transactionid"];
		}
		else
		{
			$request["REF_TRANSID"] 					= "";
		}
		if($_POST["istest"] == "1")
		{
			$request["TEST"] 							= $_POST["TRUE"];
		}
		else
		{
			$request["TEST"] 							= $_POST["FALSE"];
		}		
		try
		{
			$gw = new Gateway(3);
			$response = $gw->ProcessTransaction($request);
		}
		catch(Exception $e)
		{
			echo "Exception: ".$e->getMessage()."\n";
		}
		echo "<br><strong>Transaction Response</strong><br><br>Response Reason Code = " . $response->ProcessTransactionResult->TRANSACTIONRESPONSE->RESPONSE_CODE;
		echo "<br>Response Reason Text = " . $response->ProcessTransactionResult->TRANSACTIONRESPONSE->RESPONSE_REASON_TEXT;
		if($response->ProcessTransactionResult->TRANSACTIONRESPONSE->RESPONSE_CODE == "1")
		{
			echo "<br>Authorization Code = " . $response->ProcessTransactionResult->TRANSACTIONRESPONSE->AUTHCODE;
			echo "<br>Transaction Id = " . $response->ProcessTransactionResult->TRANSACTIONRESPONSE->TRANSACTIONID;
		}	
		echo "<br><br><a href='sample_code.php'>Try again</a>";
	}
	else
	{
		Header("Location: sample_code.php");;
	}
?>
</body>
</html>
