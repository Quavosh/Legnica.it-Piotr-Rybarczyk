<?php
session_start();
$login = $_SESSION['user'];
include 'webstyle.htm';
require_once "db.php";
$id = $_GET['edit'];
$_SESSION['id'] = $id;
mysql_connect($host,$db_user,$db_password);
mysql_select_db($db_name);
$res= mysql_query("SELECT name,comment,value FROM $login WHERE id='$id'") or die(mysql_error());
$row= mysql_fetch_array($res);
$tytul = $row['name'];
$komentarz = $row['comment'];
$wartosc = $row['value'];
$x = bcdiv($wartosc, 1, 0); 
$y = round($wartosc - $x,2,PHP_ROUND_HALF_DOWN) * 100;



?>
<html>
<body>

<p><form action="index.php" method="post"></p>
<input type="submit" value="Wyloguj" name="logout" />
</form>



     <center><p><form action="change.php" method="post">
     Tytul: <?php echo "<br /> <input type='text' name='name' value=" . $tytul . "> <br />" ?>
     Rodzaj: <br />  <select name="type"><option>Wydatek</option><option>Dochod</option></select> <br /> 
     Wartosc: <?php echo "<br /> <input type='number' value=" . $x . " name='value' min='0' max='999999'/> <input type='number' value=" . $y . " name='valueex' min='1' max='99'/> <br />" ?>
     Waluta: <br />  <select name="currency"><option>PLN</option><option>Dolar</option><option>Euro</option></select> <br /> 
     Komentarz: 
     <?php echo "<p><textarea rows='4' cols='50' name='comment'> " . $komentarz . " </textarea></p>" ?>
     <input type="submit" value="Zmien" name="editbutton" />
     </form><form action="menu.php" method=post><input type="submit" value="Wroc" /></form></p></center>       
</body></html>