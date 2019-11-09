<?php
  include("funkcije.php");
  include("db.php");

  $upit = "select id from karijera order by id desc limit 1";
  $rez = $db -> query($upit);
  $obj = mysqli_fetch_object($rez);
  $id = $obj -> id;
  $db -> query("update karijera set do=now() where id='$id'");

  $upit = "select id, od, do from karijera";
  $rez = $db -> query($upit);
  while($obj = mysqli_fetch_object($rez)){
    $id = $obj -> id;
    $db -> query("update karijera set broj_dana=(select datediff(do, od) + 1 where id='$id') where id='$id'");
  }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>PENZIJA</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div id="tabela">
      <div class="redNaslova">

        <div class="od">OD</div>

        <div class="do">DO</div>

        <div class="beneficija">BENEFICIJA 12/</div>

        <div class="efektivniRS">
          <div class="naslov">EFEKTIVNI RADNI STAŽ</div>
          <div class="GMD">
            <div class="godina">Godina</div>
            <div class="meseci">Meseci</div>
            <div class="dana">Dana</div>
          </div>
        </div>

        <div class="penzijskiRS">
          <div class="naslov">PENZIJSKI STAŽ</div>
          <div class="GMD">
            <div class="godina">Godina</div>
            <div class="meseci">Meseci</div>
            <div class="dana">Dana</div>
          </div>
        </div>

      </div>

      <?php
        $upis = "select * from karijera";
        $rez = $db -> query($upis);
        while($obj = mysqli_fetch_object($rez)){
          $od = $obj -> od;
          $do = $obj -> do;
          $beneficija = $obj -> beneficija;

          if($beneficija == 15){
            $koeficijent = 1 + 1/4;
          }elseif($beneficija == 16){
            $koeficijent = 1 + 1/3;
          }elseif($beneficija == 24){
            $koeficijent = 2;
          }

          $rez1600 = $db -> query("select to_days(str_to_date('1600-01-01', '%Y-%m-%d')) as dani1600");
          $obj1600 = mysqli_fetch_object($rez1600);
          $dani1600 = $obj1600 -> dani1600;

          $razlika = $obj -> broj_dana;
          $datumTemp = $db -> query("select extract(year from from_days($razlika + $dani1600)) - 1600 as godina, extract(month from from_days($razlika + $dani1600)) - 1 as meseci, extract(day from from_days($razlika + $dani1600)) - 1 as dana");
          $objKraj = mysqli_fetch_object($datumTemp);
            $godina = $objKraj -> godina;
            $meseci = $objKraj -> meseci;
            $dana = $objKraj -> dana;
          /*$godina = godina($razlika);
          $meseci = meseci($razlika, $godina);
          $dana = dana($razlika, $godina, $meseci);*/
          @$efektivniRS += $razlika;

       ?>

      <div class="red">
        <div class="od"><?php echo $od; ?></div>

        <div class="do"><?php echo $do; ?></div>

        <div class="beneficija"><?php echo $beneficija; ?></div>

        <div class="efektivniRS">
          <div class="GMD">
            <div class="godina"><?php echo $godina; ?></div>
            <div class="meseci"><?php echo $meseci; ?></div>
            <div class="dana"><?php echo $dana; ?></div>
          </div>
        </div>

        <?php
          $razlika = beneficiraniRS($razlika, $koeficijent);
          $datumTemp = $db -> query("select extract(year from from_days($razlika + $dani1600)) - 1600 as godina, extract(month from from_days($razlika + $dani1600)) - 1 as meseci, extract(day from from_days($razlika + $dani1600)) - 1 as dana");
          $objKraj = mysqli_fetch_object($datumTemp);
            $godina = $objKraj -> godina;
            $meseci = $objKraj -> meseci;
            $dana = $objKraj -> dana;
          /*$godina = godina($razlika);
          $meseci = meseci($razlika, $godina);
          $dana = dana($razlika, $godina, $meseci);*/
         ?>

        <div class="penzijskiRS">
          <div class="GMD">
            <div class="godina"><?php echo $godina; ?></div>
            <div class="meseci"><?php echo $meseci; ?></div>
            <div class="dana"><?php echo $dana; ?></div>
          </div>
        </div>

      </div>

      <?php
        @$beneficiraniRS += $razlika;
        }
       ?>

       <div class="red">
         <div class="ukupno">
           UKUPNO
         </div>

         <?php
           $razlika = $efektivniRS;
           $datumTemp = $db -> query("select extract(year from from_days($razlika + $dani1600)) - 1600 as godina, extract(month from from_days($razlika + $dani1600)) - 1 as meseci, extract(day from from_days($razlika + $dani1600)) - 1 as dana");
           $objKraj = mysqli_fetch_object($datumTemp);
             $godina = $objKraj -> godina;
             $meseci = $objKraj -> meseci;
             $dana = $objKraj -> dana;
           /*$godina = godina($razlika);
           $meseci = meseci($razlika, $godina);
           $dana = dana($razlika, $godina, $meseci);*/
          ?>

         <div class="efektivniRS">
           <div class="GMD">
             <div class="godina"><?php echo $godina; ?></div>
             <div class="meseci"><?php echo $meseci; ?></div>
             <div class="dana"><?php echo $dana; ?></div>
           </div>
         </div>

         <?php
           $razlika = $beneficiraniRS;
           $datumTemp = $db -> query("select extract(year from from_days($razlika + $dani1600)) - 1600 as godina, extract(month from from_days($razlika + $dani1600)) - 1 as meseci, extract(day from from_days($razlika + $dani1600)) - 1 as dana");
           $objKraj = mysqli_fetch_object($datumTemp);
             $godina = $objKraj -> godina;
             $meseci = $objKraj -> meseci;
             $dana = $objKraj -> dana;
           /*$godina = godina($razlika);
           $meseci = meseci($razlika, $godina);
           $dana = dana($razlika, $godina, $meseci);*/
          ?>

         <div class="penzijskiRS">
           <div class="GMD">
             <div class="godina"><?php echo $godina; ?></div>
             <div class="meseci"><?php echo $meseci; ?></div>
             <div class="dana"><?php echo $dana; ?></div>
           </div>
         </div>

       </div>

    </div>

    <?php
      $now = date("Y-m-d");
      $penzija = "2029-05-24";

      $brojDana = $db -> query("select datediff(str_to_date('$penzija', '%Y-%m-%d'), now()) as brojDana");
      $objDana = mysqli_fetch_object($brojDana);
      $danaBroj = $objDana -> brojDana;


      $rezTemporary = $db -> query("
      select extract(year from from_days(days)) - 1600 as years,
      extract(month from from_days(days)) - 1 as months,
      extract(day from from_days(days)) - 1 as days
      from (select '$danaBroj' + to_days(str_to_date('1600-01-01', '%Y-%m-%d')) as days) as b
        ");

      $objTemporary = mysqli_fetch_object($rezTemporary);
      $ukupnoDana = $danaBroj;
      $godina = $objTemporary -> years;
      $meseci = $objTemporary -> months;
      $dana =  $objTemporary -> days;

      /*$rez = $db -> query("select datediff('$penzija', now()) + 1 as brojDana");
      $obj = mysqli_fetch_object($rez);
      $razlika = $obj -> brojDana;
      $godina = godina($razlika);
      $meseci = meseci($razlika, $godina);
      $dana = dana($razlika, $godina, $meseci);
      $ukupnoDana = $razlika;*/
     ?>

     <div class="poslednjiRed">
       DO KRAJA JE OSTALO JOŠ <span><?php echo $godina; ?></span> GODINA <span><?php echo $meseci; ?></span> MESECI <span><?php echo $dana; ?></span> DANA.
     </div>

    <div id="ostatak">
      JOŠ <b><?php echo $ukupnoDana; ?></b> DANA
    </div>
  </body>
</html>
