<?php

function corporate_tax_code_verify($corporate_tax_code)
{
	$corporate_tax_code = preg_replace('/[^0-9]/', '', (string) $corporate_tax_code);
	
	if (strlen($corporate_tax_code) != 14)
		return false;

	if (preg_match('/(\d)\1{13}/', $corporate_tax_code))
		return false;	

	for ($i = 0, $j = 5, $total_value = 0; $i < 12; $i++)
	{
		$total_value += $corporate_tax_code[$i] * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}

	$rest = $total_value % 11;

	if ($corporate_tax_code[12] != ($rest < 2 ? 0 : 11 - $rest))
		return false;

	for ($i = 0, $j = 6, $total_value = 0; $i < 13; $i++)
	{
		$total_value += $corporate_tax_code[$i] * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}

	$rest = $total_value % 11;

	return $corporate_tax_code[13] == ($rest < 2 ? 0 : 11 - $rest);
}

function taxid_verify($taxid){
	  $taxid = preg_replace( '/[^0-9]/is', '', $taxid );
     
	  if (strlen($taxid) != 11) {
		  return false;
	  }
  
	  if (preg_match('/(\d)\1{10}/', $taxid)) {
		  return false;
	  }
  
	  for ($t = 9; $t < 11; $t++) {
		  for ($d = 0, $c = 0; $c < $t; $c++) {
			  $d += $taxid[$c] * (($t + 1) - $c);
		  }
		  $d = ((10 * $d) % 11) % 10;
		  if ($taxid[$c] != $d) {
			  return false;
		  }
	  }
	  return true;
}


function mail_verify($mail) {
    return filter_var($mail, FILTER_VALIDATE_EMAIL);
}

function format_date_to_db($date){
	if($date == null || $date == ''){
		return false;
	}
	$new_date = str_replace('/', '-', $date);
	return date('Y-m-d', strtotime($new_date));
}
?>