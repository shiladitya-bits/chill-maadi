<?php
 
ini_set("display_errors",1);
require_once 'excel_reader2.php';
require_once 'db.php';
 
 if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
  }
else
  {
  echo "Upload: " . $_FILES["file"]["name"] . "<br>";
  echo "Type: " . $_FILES["file"]["type"] . "<br>";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
  echo "Stored in: " . $_FILES["file"]["tmp_name"];
  }

//  $target = 'example_code.xls';
// move_uploaded_file( $_FILES['userFile']['tmp_name'], $target);

$data = new Spreadsheet_Excel_Reader($_FILES["file"]["tmp_name"]);
 
echo "Total Sheets in this xls file: ".count($data->sheets)."<br /><br />";
 
$html="<table border='1'>";
for($i=0;$i<count($data->sheets);$i++) // Loop to get all sheets in a file.
{    
    if(count($data->sheets[$i][cells])>0) // checking sheet not empty
    {
        echo "Sheet $i:<br /><br />Total rows in sheet $i  ".count($data->sheets[$i][cells])."<br />";
        for($j=2;$j<=count($data->sheets[$i][cells]);$j++) // loop used to get each row of the sheet
        {
            $html.="<tr>";
            for($k=1;$k<=count($data->sheets[$i][cells][$j]);$k++) // This loop is created to get data in a table format.
            {
                $html.="<td>";
                $html.=$data->sheets[$i][cells][$j][$k];
                $html.="</td>";
            }
            $invoiceDate = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][1]);
            $dueDate = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][2]);
            $partnerId = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][3]);
            $merchantName = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][4]);
            
            $accountManager = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][5]);
            $city = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][6]);
            $salesforceContractNumber = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][7]);
            $salesforceId = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][8]);
            
            $paymentTerms = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][9]);
            $paymentTermsOnSchedule = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][10]);
            $dealId = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][11]);
            $glInvoiceId = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][12]);
            
            $glStatus = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][13]);
            $reasonCode = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][4]);
            $amount = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][15]);
            $collectedQty = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][16]);
            
            $redeemedQty = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][17]);
            $consumerPrice = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][18]);
            $unitPrice = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][19]);
            $vat = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][20]);
            
            $cda = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][21]);
            $merchantVat = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][22]);
            $vatExemption = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][23]);
            $voucherCount = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][24]);
            
            $paymentStatus = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][25]);
            $paymentDate = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][26]);
            $amountAdjusted = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][27]);
            $amountPaid = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][28]);

            $issue = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][29]);            
            $issueDate = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][30]);
            $issueStatus = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][31]);
            $resolveMessage = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][32]);
    
            $txnReference = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][33]);        
            $cdaName = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][34]);
            $consumerPriceCda = mysqli_real_escape_string($connection,$data->sheets[$i][cells][$j][35]);
           

            $query = "INSERT INTO payment_log(invoiceDate, dueDate, partnerId, merchantName, accountManager, 
              city, salesforceContractNumber, salesforceId, paymentTerms, paymentTermsOnSchedule, 
              dealId, glInvoiceId, glStatus, reasonCode, amount, collectedQty, redeemedQty, 
              consumerPrice, unitPrice, vat, cda, merchantVat, vatExemption, voucherCount,
               paymentStatus, paymentDate, amountAdjusted, amountPaid, issue, issueDate, issueStatus, 
               resolveMessage, txnReference, cdaName, consumerPriceCda) 
           VALUES('".$invoiceDate."','".$dueDate."','".$partnerId."','".$merchantName."','".$accountManager
            ."','".$city."','".$salesforceContractNumber."','".$salesforceId."','".$paymentTerms."','"
            .$paymentTermsOnSchedule."','".$dealId."','".$glInvoiceId."','".$glStatus."','"
            .$reasonCode."','".$amount."','".$collectedQty."','".$redeemedQty."','".
            $consumerPrice."','".$unitPrice."','".$vat."','".$cda."','".
            $merchantVat."','".$vatExemption."','".$voucherCount."','".$paymentStatus."','".
            $paymentDate."','".$amountAdjusted."','".$amountPaid."','".$issue."','".
            $issueDate."','".$issueStatus."','".$resolveMessage."','".$txnReference."','".
            $cdaName."','".$consumerPriceCda."')";
 
            mysqli_query($connection,$query);
            $html.="</tr>";
        }
    }
 
}
 
$html.="</table>";
echo $html;
echo "<br />Data Inserted in dababase";
?>