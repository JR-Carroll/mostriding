<?php
require 'system/core/Model.php';

class Constants
{
    public static $SN_BATCH_ID_CURRENT_BATCH = "0";
    public static $SN_BATCH_ID_PREV_BATCH = "1";
}

class SNData extends CI_Model {

    public static function DateFromDayOfMonth($dayOfMonth, $minDaysAhead) {
        $today = new ArrayObj(getdate());
        $target = $dayOfMonth - $minDaysAhead;
        if ($today->mday >= $target)
            $today->mon += 1;
        $dateOnDayOfMonth = mktime(0, 0, 0, $today->mon, $dayOfMonth, $today->year);
        return $dateOnDayOfMonth;
    }

    public static function DateYearsFromToday($years)
    {
        $today = new ArrayObj(getdate());
        $today->year += $years;
        return mktime(0, 0, 0, $today->mon, $today->mday, $today->year);
    }

    public static function DateYearsFromDate($date,$years)
    {
        $date = new ArrayObj(getdate($date));
        $date->year += $years;
        return mktime(0, 0, 0, $date->mon, $date->mday, $date->year);
    }

    public static function formatGatewayDate($t) {
        return date('mdY',$t);
    }

    public static $codes = array ( 
         "AUTH_ONLY" => "0000", 
         "AUTH_CAPTURE" => "0100",
         "PRIOR_AUTH_CAPTURE" => "0200",
         "UPDATE_TRANS_INFO" => "0201",
         "CAPTURE_ONLY" => "0300",
         "VOID" => "0400",
         "CREDIT" => "0500",
         "FORCE_CREDIT" => "0600", 
         "VERIFICATION" => "0700"
    );

    public static $responseCodes = array ( // for your convenience
         "Approved" => 1,
         "Declined" => 2,
         "Error" => 3 
    ); // or invalid data

    public static $actionCodes = array (
        "ADD" => 1,
        "UPDATE" => 2,
        "DELETE" => 3 
    );

    public static $methodCodes = array (
        "CREDIT" => "CC",
        "DEBIT" => "DB",
        "STORED_VALUE" => "SV",
        "ELECTRONIC_BENEFITS_TRANSFER" => "EBT",
        "ECHECK" => "CHECK21",
        "PINLESS_DEBIT" => "PD"
    );

    public static $Constants = array (
        "SN_BATCH_ID_CURRENT_BATCH" => "0",
        "SN_BATCH_ID_PREV_BATCH" => "1"
    );

    // For E-commerce transactions: P—Physical goods
    // D—Digital goods For MO/TO transactions:
    // 1—Single purchase transaction (AVS is required) 2—Recurring billing transaction (do not submit AVS) 3—Installment transaction

    public static $industrySpecificData = array (
        //  For E-commerce transactions:
        "NONE" => null,
        "PHYSICAL_GOODS" => "P",
        "DIGITAL_GOODS" => "D",
        
        //  For MO/TO transactions:

        //  Single purchase transaction (AVS is required)
        "SINGLE_PURCHASE" => 1,
        //  Recurring billing transaction (do not submit AVS)
        "RECURRING_BILLING" => 2,
        //  Installment transaction
        "INSTALLMENT" => 3

    );

    public static $TransactionService = array (
        "Regular" => 0, 
        "VaultUsingCustomerID" => 1, 
        "VaultAddCustomerAndAccount" => 2, 
        "VaultProcessTransactionAddCustomerAndAccount" =>3 
    );

    public static $secCodes = array (
        "AccountsReceiveableEntry"      => "ARC",
        "BackOfficeConversion"          => "BOC",
        "CorporateCashDisbursement"     => "CCD",
        "PointOfSale"                   => "POS",
        "PrearrangedPaymentAndDeposits" => "PPD",
        "TelephoneInitiatedEntry"       => "TEL",
        "WebInitiatedEntry"             => "WEB",
        "BankAccount"                   => "POP"
    );


    public $userName = '';
    public $password = '';
    public $cardNumber = '4444333322221111';
    public $trackData = '';
    public $cardCode = '123';
    public $expDate = '1115';
    public $customerID = 100;
    public $orderID = '';
    public $batchID = 0;
    public $transactionID = '';
    public $authCode = '';
    public $paymentID = 0;
    public $groupID = '';
    public $planID = 0;
    public $amount = 0;

}
?>
