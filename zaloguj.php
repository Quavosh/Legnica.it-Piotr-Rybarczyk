<?php
include 'webstyle.htm';
require_once "db.php";
mysql_connect($host,$db_user,$db_password);
mysql_select_db($db_name);

function filtruj($zmienna)
{
    if(get_magic_quotes_gpc())
        $zmienna = stripslashes($zmienna); // usuwamy slashe
 
	// usuwamy spacje, tagi html oraz niebezpieczne znaki
    return mysql_real_escape_string(htmlspecialchars(trim($zmienna)));
}
 
if (isset($_POST['loguj']))
{
	$login = filtruj($_POST['login']);
	$haslo = filtruj($_POST['haslo']);
	$ip = filtruj($_SERVER['REMOTE_ADDR']);
 
	// sprawdzamy czy login i haslo sa dobre
	if (mysql_num_rows(mysql_query("SELECT login, haslo FROM uzytkownicy WHERE login = '".$login."' AND haslo = '".md5($haslo)."';")) > 0)
	{
		// uaktualniamy date logowania oraz ip
		mysql_query("UPDATE `uzytkownicy` SET (`logowanie` = '".time().", `ip` = '".$ip."'') WHERE login = '".$login."';");
 
		$_SESSION['zalogowany'] = true;
		$_SESSION['login'] = $login;
        echo "<center>Zalogowano!</center>";
        $yes= 1;
 
		// zalogowany
 
	}
	else echo "Wpisano zle dane.";
}
?>

<center><form action="logowanie.php" method="post">
<input type="submit" value="Powrot" name="returnlogin" /></center></form>
<?php if($yes == 1)
{
   session_start();
   $_SESSION['user'] = $login;
   header('Refresh: 1; url=menu.php');  
} ?>
