<?php
// Some useful functions to have

function generateName($firstname, $lastname, $middlename = null)
{
  return "$lastname $firstname $middlename";
}


function analyseCardNumber($number)
{
  $number = explode('-', $number);
  $cat = $number[0];
  $digits = $number[1];
  preg_match('/(\d{2,3})(\d{4})/', $digits, $analysed);
  $id = $analysed[1];
  $date = $analysed[2];
  // $id += 1;
  return [$cat, $id, $date];
}
