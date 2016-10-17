<?php
include 'webstyle.htm';
require_once "db.php";
mysql_connect($host,$db_user,$db_password);
mysql_select_db($db_name);
session_start();
$login = $_SESSION['user'];
  function filtruj($zmienna)
{
    if(get_magic_quotes_gpc())
        $zmienna = stripslashes($zmienna); // usuwamy slashe
 
	// usuwamy spacje, tagi html oraz niebezpieczne znaki
    return mysql_real_escape_string(htmlspecialchars(trim($zmienna)));
}
if (isset($_POST['addbutton']))
{
	$name = filtruj($_POST['name']);
	$type = filtruj($_POST['type']);
    $ex = filtruj($_POST['valueex']);
    $ex = $ex/100;
	$value = filtruj($_POST['value']) + $ex;
	$currency = filtruj($_POST['currency']);
	$comment = filtruj($_POST['comment']);
    $put = "INSERT INTO $login (`name`, `type`, `value`, `currency`, `comment`, `dt`)
            VALUES ('".$name."', '".$type."', '".$value."', '".$currency."', '".$comment."', NOW())";        
    if (mysql_num_rows(mysql_query("SELECT name FROM $login WHERE name = '".$name."';")) == 0)
    {
        mysql_query("$put");
        echo "<center>Dodano!</center>";
        header('Refresh: 1; url=menu.php');
    }
    }
?>
<html>
<body>
