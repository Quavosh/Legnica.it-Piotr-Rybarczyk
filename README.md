# Legnica.it-Piotr-Rybarczyk
Zadanie na praktyki 2016-2017

Piotr Rybarczyk nr.35757
Rok Studiów: trzeci / semestr piąty 2014-2017

O mnie: Informatyka to moja pasja. Lubie tworzyć programy, budować sieci, pisać gry(jedna nawet już zrobiłem). Uwielbiam również arduino
oraz naprawy komputerów. Szukam miejsca gdzie moge się rozwinąć oraz wykazać umiejętnościami programistycznymi. Zależy mi bardzo na dostaniu się
na te praktyki, bo wiem ,że to dla mnie wielka szansa na robienie tego co kocham. Z PHP mam pierwszy raz styczność, ale chciałem się podjać wyzwania
i stworzyłem całe zadanie w nim.

Języki programowania:
PHP,HTML oraz SQL.

Odnośnie zadania:
Ogólnie wszystkie polecenia zostały przeze mnie wykonanie. Nawet dodałem system rejestracji. Niestety polecenie drugie było dla mnie trudne do
zinterpretowania, więc stworzyłem wspólny budżet domowy, do którego są przypisani użytkownicy. Budżet jest zależny od ich własnych rachunków.

Aplikacje:
Do wykresów uzyłem Google Charts ponieważ Raspberry z architekturą ARM Cortex-A7 nie pozwalał mi na zainstalowanie jakichkolwiek bibliotek do wykresów w php.
https://developers.google.com/chart/

Jak Uruchomić:
Jest to w postaci Serwera PHP. Wystarczy mieć np. apache2 z obsługa php żeby móc przetestować. Należy wypakować zawartość archiwum w miejscu gdzie serwer poszukuję pliku "index.php".
Dodatkowo jest wymaga współpraca z bazą mysql. W pliku "db.php" są zapisane dane do połączenia z bazą danych. Można je dostosować do własnych potrzeb.
Trzeba również wstawić tabele "login.sql" oraz "Budget.sql" do bazy danych. Aby zalogowac się do systemu wystraczy stworzyć sobie konto klikajac "rejestracja".
Dane po stworzeniu konta Automatycznie się generują wystarczy odświeżyć stronę.
