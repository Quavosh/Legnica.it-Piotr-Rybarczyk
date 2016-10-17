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
 
if (isset($_POST['rejestruj']))
{
	$login = filtruj($_POST['login']);
	$haslo1 = filtruj($_POST['haslo1']);
	$haslo2 = filtruj($_POST['haslo2']);
	$email = filtruj($_POST['email']);
	$ip = filtruj($_SERVER['REMOTE_ADDR']);
 
	// sprawdzamy czy login nie jest juz w bazie
	if (mysql_num_rows(mysql_query("SELECT login FROM uzytkownicy WHERE login = '".$login."';")) == 0)
	{
		if ($haslo1 == $haslo2) // sprawdzamy czy hasla takie same
		{
			mysql_query("INSERT INTO `uzytkownicy` (`login`, `haslo`, `email`, `rejestracja`, `logowanie`, `ip`)
				VALUES ('".$login."', '".md5($haslo1)."', '".$email."', '".time()."', '".time()."', '".$ip."');");
 
			echo "Konto zostalo utworzone! Za chwile zostaniesz przekierowany na odp strone!";
            $yes = 1;
		}
		else echo "Hasla nie sa takie same";
	}
	else echo "Podany login jest juz zajety.";
}  
?>
<html>
<body>

<?php if($yes == 1)
{
   session_start(); 
   $_SESSION['user'] = $login;
   header('Refresh: 1; url=menu.php');  
} ?>
</body>
</html>
