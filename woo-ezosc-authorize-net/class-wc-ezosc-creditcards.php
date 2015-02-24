<?php
/* Luhn algorithm number checker - (c) 2005-2008 shaman - www.planzero.org *
 * This code has been released into the public domain, however please      *
 * give credit to the original author where possible.                      */

function ezoscValidateCreditCard($number) {

  // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
  $number=preg_replace('/\D/', '', $number);

  // Set the string length and parity
  $number_length=strlen($number);
  $parity=$number_length % 2;

  // Loop through each digit and do the maths
  $total=0;
  for ($i=0; $i<$number_length; $i++) {
    $digit=$number[$i];
    // Multiply alternate digits by two
    if ($i % 2 == $parity) {
      $digit*=2;
      // If the sum is two digits, add them together (in effect)
      if ($digit > 9) {
        $digit-=9;
      }
    }
    // Total up the digits
    $total+=$digit;
  }

  // If the total mod 10 equals 0, the number is valid
  return ($total % 10 == 0) ? TRUE : FALSE;

}

function ezoscValidateCreditCardExpirationDate($month, $year)
{
    if (!preg_match('/^\d{1,2}$/', $month)){
        return false; // The month isn't a one or two digit number
    }
    else if (!preg_match('/^\d{4}$/', $year)){
        return false; // The year isn't four digits long
    }
    else if ($year < date("Y")){
        return false; // The card is already expired
    }
    else if ($month < date("m") && $year == date("Y")){
        return false; // The card is already expired
    }
    return true;
}

function ezoscCheckCVV($cardNumber, $cvv) {
    $firstnumber = (int) substr($cardNumber, 0, 1);
    if ($firstnumber === 3) {if (!preg_match("/^\d{4}$/", $cvv)){return false;}}
    else if (!preg_match("/^\d{3}$/", $cvv)) {return false;}
    return true;
}