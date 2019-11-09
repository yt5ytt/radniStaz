<?php
  function danasnjiDan(){
    $now = date("Y-m-d");
    return $now;
  }

  function sledeciDan($now){
    $unix = strtotime($now);
    $unix = $unix + 86400;
    $unix = date("d.m.Y.", $unix);
    return $unix;
  }

  function godina($razlika){
    $godinaTemp = floor($razlika/365);
    return $godinaTemp;
  }

  function meseci($razlika, $godina){
    $meseciTemp = ($razlika - $godina*365)/30;
    $meseci = floor($meseciTemp);
    return $meseci;
  }

  function dana($razlika, $godina, $meseci){
    $godinaTemp = $godina*365;
    $meseciTemp = $meseci*30;
    $dana = $razlika - $godinaTemp - $meseciTemp;
    return floor($dana);
  }

  function beneficiraniRS($razlika, $koeficijent){
    $beneficiraniRS = $razlika * $koeficijent;
    return $beneficiraniRS;
  }
 ?>
