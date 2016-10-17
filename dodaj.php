<?php
include 'webstyle.htm';
?>
<html>
<body>

<p><form action="index.php" method="post"></p>
<input type="submit" value="Wyloguj" name="logout" />
</form>
<center><p><form action="add.php" method="post">
Tytul: <br /> <input type="text" name="name"/> <br />
Rodzaj: <br />  <select name="type"><option>Wydatek</option><option>Dochod</option></select> <br /> 
Wartosc: <br /> <input type="number" name="value" min="0" max="999999"/> <input type="number" name="valueex" min="1" max="99"/> <br />
Waluta: <br />  <select name="currency"><option>PLN</option><option>Dolar</option><option>Euro</option></select> <br /> 
Komentarz: 
<p><textarea rows="4" cols="50" name="comment">Pisz tutaj...</textarea></p>
<input type="submit" value="Dodaj" name="addbutton" />
</form></p></center>
</body></html>