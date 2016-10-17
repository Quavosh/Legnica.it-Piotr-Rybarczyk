<?php
include 'webstyle.htm';
require_once "db.php";
mysql_connect($host,$db_user,$db_password);
mysql_select_db($db_name);
session_start();
$login = $_SESSION['user'];
function seed($user)
{
    $seedname = "blank";
    $seedtype = "blank";
    $seedcurr = "PLN";
    $comm = "Wygenerowany";
    $seeddate = "0000-00-00 00:00:00";
    $datearray = array(2999,12,30,23,59,0);
    $seedval = 0;
    
    $seedval = rand(0,7);
    switch($seedval){
       case 0:
       $seedname = "Zakupy";
       $seedtype = "Wydatek";
       break; 
       case 1:
       $seedname = "Rachunek";
       $seedtype = "Wydatek";
       break; 
       case 2:
       $seedname = "Czynsz";
       $seedtype = "Wydatek";
       break; 
       case 3:
       $seedname = "Paliwo";
       $seedtype = "Wydatek";
       break; 
       case 4:
       $seedname = "Sprzedaz";
       $seedtype = "Dochod";
       break; 
       case 5:
       $seedname = "Kredyt";
       $seedtype = "Dochod";
       break; 
       case 6:
       $seedname = "Wyplata";
       $seedtype = "Dochod";
       break; 
       case 7:
       $seedname = "Faktura";
       $seedtype = "Dochod";
       break;     
    }
    $datearray[0] = rand(2004,2016);
    $datearray[1] = rand(1,12);
    $datearray[2] = rand(1,30);
    $datearray[3] = rand(0,23);
    $datearray[4] = rand(0,59);
    $seeddate = "$datearray[0]-$datearray[1]-$datearray[2] $datearray[3]:$datearray[4]:$datearray[5]";
    $seedval = rand(3,9999);
    
    $put = "INSERT INTO $user (`name`, `type`, `value`, `currency`, `comment`, `dt`)
            VALUES ('".$seedname."', '".$seedtype."', '".$seedval."', '".$seedcurr."', '".$comm."', '".$seeddate."')";
    
    if (mysql_num_rows(mysql_query("SELECT name FROM $user WHERE name = '".$name."';")) == 0)
    {
        mysql_query("$put")  or die (mysql_error());;}
}
?>
<html>
<body>
<p><form action="index.php" method="post"></p>
<input type="submit" value="Wyloguj" name="logout" />
</form>
<center><?php echo "Zalogowano jako $login"; ?></center>
<?php
$table = $login;
//usuniecie rekordu
if (isset($_GET['delete']))
{
    $del = $_GET['delete'];
    mysql_query("DELETE FROM $login WHERE id ='$del'")  or die (mysql_error());
    unset($_GET['delete']);
}
//Wyswietlnie zawartsci tablicy na stronie
if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$table."'"))==1)
    {
        $res = mysql_query("SELECT * FROM $table ORDER BY dt DESC");
        echo "<center><table>
        <tr>
        <th>Tytul</th>
        <th>Rodzaj</th>
        <th>Wartosc</th>
        <th>Waluta</th>
        <th>Komentarz</th>
        <th>Data</th>
        <th>Edytuj</th>
        <th>Usun</th>
        </tr>";
    $inc=0;
    $out=0;
    while($row = mysql_fetch_array($res))
    {
      echo "<tr>";
      $idx = $row['id'];
      echo "<td width=200px>" . $row['name'] . "</td>";
      echo "<td>" . $row['type'] . "</td>";
      echo "<td>" . $row['value'] . "</td>";
      echo "<td>" . $row['currency'] . "</td>";
      echo "<td width=400px>" . $row['comment'] . "</td>";
      echo "<td width=200px>" . $row['dt'] . "</td>";
      echo "<td><form action='edycja.php' method=get> <input type='image' src='edit.png' width=30% height=30% name='edit' value='$idx'/></form></td>";
      echo "<td><form action='menu.php' method=get> <input type='image' src='delete.png' width=30% height=30% name='delete' value='$idx'/></form></td>";
      echo "</tr>";
      if($row['type'] == "Dochod")
      {$inc= $inc + $row['value'];} 
      else
      {$out= $out + $row['value'];}
    }
    echo "</table></center>";
    $bal= $inc - $out;
    echo "<div class='inbox'>";
    echo "<center>Twoj Rachunek:</br>Dochod:" . $inc ." | Obciazenia:" . $out . " | Saldo:" . $bal . "</center>";
    echo "</div>";
    //przenosi dane do ogolnego budzetu
    if (mysql_num_rows(mysql_query("SELECT login FROM budget WHERE login = '".$login."';")) == 0)
     {
        $sql= "INSERT INTO `budget` (`login`, `income`, `outcome`, `balance`)
               VALUES ('".$login."', '".$inc."', '".$out."', '".$bal."')";
        mysql_query($sql) or die (mysql_error());
     }
     else
     {
        $sql= "UPDATE budget
               SET income='".$inc."', outcome='".$out."', balance='".$bal."'
               WHERE login='".$login."'";
               mysql_query($sql) or die (mysql_error());
     }
    }
else
{
//jezeli uzytkownik nie ma tablicy, to ja tworzy
$create = "CREATE TABLE $table (
`id` int(10) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`type` varchar(255) NOT NULL,
`value` decimal(20,2) NOT NULL,
`currency` varchar(255) NOT NULL,
`comment` varchar(255) NOT NULL,
`dt` datetime,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
mysql_query($create) or die (mysql_error());
for($i = 0; $i < 12; ++$i){seed($login);}
echo "<center>Baza wygenerowana! Odswiez strone</center>";
}
header('Refresh: 60; url=menu.php');
?>
<center><form action="dodaj.php" method="post"><input type="submit" value="Dodaj rekord" name=addvalue" /></form></center>
</div>
<?php
        $rel = mysql_query('SELECT SUM(balance) AS suma FROM budget');
        $bud = mysql_fetch_array($rel);
        echo"<div class='inbox'>";
        echo "<center><b><font size=5px>Stan Konta Domowego: " . $bud['suma'] . "</font></b>";
        echo "<form action='stats.php' method='post'><input type='submit' value='Szczegoly' name='diag'/>";
        echo "</center></div>"; ?>
<center><font size=1px>Strona jest odswierzana co 60 sekund.</font></center>
<center><img src="php.png"/>
<img src="mysql.png"/></center>
</body>
</html>