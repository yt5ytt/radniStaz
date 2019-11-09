<?php
  include("funkcije.php");
  include("db.php");

  //   Update last date to be today

  $upit = "select id from karijera order by id desc limit 1";
  $rez = $db -> query($upit);
  $obj = mysqli_fetch_object($rez);
  $id = $obj -> id;
  $db -> query("update karijera set do=now() where id='$id'");

  //   Update of column broj_dana in table

  $upit = "select id, od, do from karijera";
  $rez = $db -> query($upit);
  while($obj = mysqli_fetch_object($rez)){
    $id = $obj -> id;
    $db -> query("update karijera set broj_dana=(select datediff(do, od) + 1 where id='$id') where id='$id'");
  }

?>

<?php
  //   Now goes HTML with CSS styling
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

      //   Reading data from DB

        $upis = "select * from karijera";
        $rez = $db -> query($upis);
        while($obj = mysqli_fetch_object($rez)){
          $od = $obj -> od;
          $do = $obj -> do;
          $beneficija = $obj -> beneficija;

      //   Related to amount of acceleration, defines coefficient for multiplication of days

          if($beneficija == 15){
            $koeficijent = 1 + 1/4;
          }elseif($beneficija == 16){
            $koeficijent = 1 + 1/3;
          }elseif($beneficija == 24){
            $koeficijent = 2;
          }

      //   Using functions for converting days to years, months and days

          $razlika = $obj -> broj_dana;
          $godina = godina($db, $razlika);
          $meseci = meseci($db, $razlika);
          $dana = dana($db, $razlika);
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

        //   Using functions for converting days to years, months and days, now for service with acceleration

          $razlika = beneficiraniRS($razlika, $koeficijent);
          $godina = godina($db, $razlika);
          $meseci = meseci($db, $razlika);
          $dana = dana($db, $razlika);
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

         //   Summary of service without acceleration

           $razlika = $efektivniRS;
           $godina = godina($db, $razlika);
           $meseci = meseci($db, $razlika);
           $dana = dana($db, $razlika);
          ?>

         <div class="efektivniRS">
           <div class="GMD">
             <div class="godina"><?php echo $godina; ?></div>
             <div class="meseci"><?php echo $meseci; ?></div>
             <div class="dana"><?php echo $dana; ?></div>
           </div>
         </div>

         <?php

         //   Summary of service with acceleration

           $razlika = $beneficiraniRS;
           $godina = godina($db, $razlika);
           $meseci = meseci($db, $razlika);
           $dana = dana($db, $razlika);
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

    //   Calculating how many time is needed for retirement according to Retirement law of Republic of Serbia

      $now = date("Y-m-d");
      $penzija = "2029-05-24";

      $brojDana = $db -> query("select datediff(str_to_date('$penzija', '%Y-%m-%d'), now()) as brojDana");
      $objDana = mysqli_fetch_object($brojDana);
      $razlika = $objDana -> brojDana;
      $godina = godina($db, $razlika);
      $meseci = meseci($db, $razlika);
      $dana = dana($db, $razlika);
     ?>

     <div class="poslednjiRed">
       DO KRAJA JE OSTALO JOŠ <span><?php echo $godina; ?></span> GODINA <span><?php echo $meseci; ?></span> MESECI <span><?php echo $dana; ?></span> DANA.
     </div>

    <div id="ostatak">
      JOŠ <b><?php echo $razlika; ?></b> DANA
    </div>
  </body>
</html>
