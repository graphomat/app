dodaj menu dla mobilnej wersji
dostosuj footer do mobnilnej wersji
Zoptymalizuj strone dla SEO

Stworz prosty panel administracyjny z haslem do zmiany tresci dla artykulow, SEO, konfiguracji strony, menu, mediow, korzystaj z SQLite w folderze ../
przenies wszystkie zmienne do SQL i pozwol je edytowac, stworz API poprzez ktore beda dostepne dla frontendu

ustandaryzuj style css dla index.php i training.php
Stworz aplikacje w dockerfile i docker compose
stworz testy do strony i panelu administracyjnego
dodaj kluczowe zmienne i sciezki do .env

Każda sekcja powinna modularna, niezależna, być w formacie html w osobnych plikach dla html, css, js, sql query,  sql scehma, 
folder powinien mieć nazwe sekcji, np header, footer, menu, itp
Każdy folder sekcji będzie dynamicznie dodawany do index.php w zależnosci od konfiguracji w SQL, gdzie będzie określone ktora sekcja ma być ładowana i w jakiej kolejności

zaktualizauj install.php i install.sh, gdzie jest generowana baza danych, aktualizuj baze z kazdej sekcji sections/*/schema.sql

Dodaj do kazdej sekcji plik admin.php, ktory bedzie ladowany przy ladowaniu panelu administracyjnego na podobnej zasadzie co index.php strony www, w celu edycji danej sekcji na landing page dla admina w pliku sections/index.php

Dodaj sekcję footer,
Dodaj sekcję menu, categories, tags, article, blog
Dodaj sekcję sitemap, rss, do wyswietlania mapy strony w xml i rss rozszerzeniem odpowiednim dla danej sekcji z administracją i sql, obie sekcje powinny korzystać z sekcji menu, categories, article, tags

NOCODE

Dodaj sekcje kontakt

Dodaj rss


