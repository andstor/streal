<?php
/*
 * Format the date
 */
 function formatDate($date) {
   setlocale (LC_TIME, "no_NO");

   return strftime("%d. %B %Y kl %R",strtotime($date));
 }

 /*
  * Shorten text
  */
  function shortenText($text, $chars = 490) {
      $length = strlen($text);
      if ($length > $chars) {


    $text = substr($text, 0, $chars);
    $text = substr($text, 0, strrpos($text,' '));
    $text = $text."...";
    }
    return $text;
  }

function alert($text) {
    echo '<script>alert("' . $text . '")</script>';
}