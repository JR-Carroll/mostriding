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
<script>
	function stripHtml(stringToStrip)
	{
		return stringToStrip.replace(/(<([^>]+)>)/ig,""); 
	}

	function trimString(stringToTrim)
	{
		return stringToTrim.replace(/\s+$/,"");
	}
	function checkInputs()
	{
		document.getElementById("securenetid").value = stripHtml(trimString(document.getElementById("securenetid").value));
		if(document.getElementById("securenetid").value.length==0)
		{
			alert("SecureNET Id is a required field");
			document.getElementById("securenetid").focus();
			return false;
		}
		if(isNaN(document.getElementById("securenetid").value))
		{
		    alert("SecureNET Id is a numeric field");
			document.getElementById("securenetid").focus();
			return false;
		}
		document.getElementById("securekey").value = stripHtml(trimString(document.getElementById("securekey").value));
		if(document.getElementById("securekey").value.length==0)
		{
			alert("SecureNET Key is a required field");
			document.getElementById("securekey").focus();
			return false;
		}
		document.getElementById("creditcardnum").value = stripHtml(trimString(document.getElementById("creditcardnum").value));
		if(document.getElementById("creditcardnum").value.length==0)
		{
			alert("Credit Card Number is a required field");
			document.getElementById("creditcardnum").focus();
			return false;
		}
		document.getElementById("cvvc").value = stripHtml(trimString(document.getElementById("cvvc").value));
		if(document.getElementById("cvvc").value.length==0)
		{
			alert("CVVC is a required field");
			document.getElementById("cvvc").focus();
			return false;
		}
		var currentTime = new Date();
		var month = currentTime.getMonth() + 1;
		var year = currentTime.getYear();
		var length = (""+month).length;
		if(length==1)
		{
			month = "0"+month;
		}
		length = (""+year).length;
		if(length==4)
		{
			year = (""+year).substr(2);
		}
		else if (length==3)
		{
			year = (""+year).substr(1);
		}
		if(year==document.getElementById("ExpYear").value)
		{
			if(document.getElementById("ExpMonth").value <= month)
			{
				alert("Your Credit card is Expired.");
				return false;
			}
		}
		document.getElementById("transamount").value = stripHtml(trimString(document.getElementById("transamount").value));
		if(document.getElementById("transamount").value.length==0)
		{
			alert("Transaction Amount is a required field");
			document.getElementById("transamount").focus();
			return false;
		}
		if(isNaN(document.getElementById("transamount").value))
		{
		    alert("Transaction Amount is a numeric field");
			document.getElementById("transamount").focus();
			return false;
		}
		document.getElementById("orderid").value = stripHtml(trimString(document.getElementById("orderid").value));
		if(document.getElementById("orderid").value.length==0)
		{
			alert("Order Id is a required field");
			document.getElementById("orderid").focus();
			return false;
		}
		var valueofdropdown = document.getElementById("transactiontype").value;
		if (valueofdropdown == "0200" || valueofdropdown == "0400" || valueofdropdown == "0300" || valueofdropdown == "0600")
		{
			document.getElementById("authroizationcode").value = stripHtml(trimString(document.getElementById("authroizationcode").value));
			if(document.getElementById("authroizationcode").value.length==0)
			{
				alert("Authorization Code is a required field");
				document.getElementById("authroizationcode").focus();
				return false;
			}
		}
		if (valueofdropdown == "0200" || valueofdropdown == "0400" || valueofdropdown == "0500")
		{
			document.getElementById("transactionid").value = stripHtml(trimString(document.getElementById("transactionid").value));
			if(document.getElementById("transactionid").value.length==0)
			{
				alert("Transaction Id is a required field");
				document.getElementById("transactionid").focus();
				return false;
			}
		}

	}
	function visible_invisible()
	{
		var valueofdropdown = document.getElementById("transactiontype").value;
		if(valueofdropdown =="0100" || valueofdropdown =="0000")
		{
			document.getElementById("trAuthCode").style.display="none";
			document.getElementById("trTransactionID").style.display="none";
		}
		else if(valueofdropdown=="0200" || valueofdropdown=="0400")
		{
			document.getElementById("trAuthCode").style.display="block";
			document.getElementById("trTransactionID").style.display="block";
		}
		else if(valueofdropdown=="0300" || valueofdropdown=="0600")
		{
			document.getElementById("trAuthCode").style.display="block";
			document.getElementById("trTransactionID").style.display="none";
		}
		else if(valueofdropdown=="0500")
		{
			document.getElementById("trAuthCode").style.display="none";
			document.getElementById("trTransactionID").style.display="block";
		}
	}
</script>
</head>
<body>
<h1>Sample application for SECURENET API</h1>
<form method="post" action="request_process.php" onsubmit="return checkInputs()">
	<table cellspacing="0" cellpadding="2" border="0">
		<tr>
			<td>Securenet ID</td>
			<td><input id="securenetid" name="securenetid" size="40" /></td>
		</tr>
		<tr>
			<td>Securenet Key</td>
			<td><input id="securekey" name="securekey" size="40" /></td>
		</tr>
		<tr>
			<td>Is Test?</td>
			<td><input id="istest" name="istest" type="checkbox" value="1" /></td>
		</tr>
		<tr>
			<td>Transaction Type</td>
			<td><select name="transactiontype" id="transactiontype" onchange="visible_invisible();">
				<option value="0100">AUTH_CAPTURE</option>
				<option value="0000">AUTH_ONLY</option>
				<option value="0200">PRIOR_AUTH_CAPTURE</option>
				<option value="0300">CAPTURE_ONLY</option>
				<option value="0500">CREDIT</option>
				<option value="0600">FORCE_CREDIT</option>
				<option value="0400">VOID</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Credit Card Number</td>
			<td><input id="creditcardnum" name="creditcardnum" size="40" value="4444333322221111" /></td>
		</tr>
		<tr>
			<td>CVVC</td>
			<td><input id="cvvc" name="cvvc" size="40" value="999" /></td>
		</tr>
		<tr>
			<td>Transaction Amount</td>
			<td><input id="transamount" name="transamount" size="40" value="1.0" /></td>
		</tr>
		<tr>
			<td>Card Expiry</td>
			<td><select name="ExpMonth" id="ExpMonth">
				<option value="01">Jan</option>
				<option value="02">Feb</option>
				<option value="03">Mar</option>
				<option value="04">Apr</option>
				<option value="05">May</option>
				<option value="06">Jun</option>
				<option value="07">Jul</option>
				<option value="08">Aug</option>
				<option value="09">Sep</option>
				<option value="10">Oct</option>
				<option value="11">Nov</option>
				<option value="12">Dec</option>
				</select>
				<select name="ExpYear" id="ExpYear">
				<?php
				$curryearX = date("Y");
				for ($x=0; $x<=10; $x++)
				{
				?>
				<option value="<?php echo substr(($curryearX+$x),2); ?>"><?php  echo ($curryearX+$x); ?></option>
				<?php
				} 
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Order ID</td>
			<td><input id="orderid" name="orderid" size="40" value="<?php echo date("Ymdhis"); ?>" /></td>
		</tr>
		<tr id="trAuthCode" name="trAuthCode">
			<td>Authorization Code</td>
			<td><input id="authroizationcode" name="authroizationcode" size="40" /></td>
		</tr>
		<tr id="trTransactionID" name="trTransactionID">
			<td>Transaction ID</td>
			<td><input id="transactionid" name="transactionid" size="40" /></td>
		</tr>
		<tr>
			<td></td><td><input type="submit" value="Process Request" id="check" name="check" /></td>
		</tr>
	</table>
	<br>
	<script>
	visible_invisible();
	</script>
</form>
</body>
</html>