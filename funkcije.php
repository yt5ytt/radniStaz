<?php

  //   Function for calculating number of years from number of days

  function godina($db, $razlika){
    $dani1600 = $db -> query("select to_days(str_to_date('1600-01-01', '%Y-%m-%d')) as dani1600");
    $objDani1600 = mysqli_fetch_object($dani1600);
    $konstanta = $objDani1600 -> dani1600;

    $ukupnoDana = $konstanta + $razlika;
    $rez = $db -> query("select extract(year from from_days($ukupnoDana)) - 1600 as godina");
    $obj = mysqli_fetch_object($rez);
    $godina = $obj -> godina;
    return $godina;
  }

  //   Function for calculating number of months from number of days

  function meseci($db, $razlika){
    $dani1600 = $db -> query("select to_days(str_to_date('1600-01-01', '%Y-%m-%d')) as dani1600");
    $objDani1600 = mysqli_fetch_object($dani1600);
    $konstanta = $objDani1600 -> dani1600;

    $ukupnoDana = $konstanta + $razlika;
    $rez = $db -> query("select extract(month from from_days($ukupnoDana)) - 1 as godina");
    $obj = mysqli_fetch_object($rez);
    $godina = $obj -> godina;
    return $godina;
  }

  //   Function for calculating rest number of days from number of days

  function dana($db, $razlika){
    $dani1600 = $db -> query("select to_days(str_to_date('1600-01-01', '%Y-%m-%d')) as dani1600");
    $objDani1600 = mysqli_fetch_object($dani1600);
    $konstanta = $objDani1600 -> dani1600;

    $ukupnoDana = $konstanta + $razlika;
    $rez = $db -> query("select extract(day from from_days($ukupnoDana)) - 1 as godina");
    $obj = mysqli_fetch_object($rez);
    $godina = $obj -> godina;
    return $godina;
  }

  //   Function for calculating service with benefits according to benefits coefficient

  function beneficiraniRS($razlika, $koeficijent){
    $beneficiraniRS = $razlika * $koeficijent;
    return $beneficiraniRS;
  }
 ?>
