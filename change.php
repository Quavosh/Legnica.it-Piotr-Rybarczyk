<?php
include 'webstyle.htm';
require_once "db.php";
mysql_connect($host,$db_user,$db_password);
mysql_select_db($db_name);
session_start();
$login = $_SESSION['user'];
$id = $_SESSION['id'];
  function filtruj($zmienna)
{
    if(get_magic_quotes_gpc())
        $zmienna = stripslashes($zmienna); // usuwamy slashe
 
	// usuwamy spacje, tagi html oraz niebezpieczne znaki
    return mysql_real_escape_string(htmlspecialchars(trim($zmienna)));
}
if (isset($_POST['editbutton']))
{
	$name = filtruj($_POST['name']);
	$type = filtruj($_POST['type']);
    $ex = filtruj($_POST['valueex']);
    $ex = $ex/100;
	$value = filtruj($_POST['value']) + $ex;
	$currency = filtruj($_POST['currency']);
	$comment = filtruj($_POST['comment']);
    $put = "UPDATE $login
            SET name='$name', type='$type', value='$value', currency='$currency', comment='$comment' 
            WHERE id='$id'";     
        mysql_query($put) or die (mysql_error());
        echo "<center>Zmieniono!</center>";
        unset($_SESSION['id']); 
        header('Refresh: 1; url=menu.php');
    }
?>
<html>
<body>