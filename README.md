## Projekat sistema za pracenje troskova (PHP, MySql, jQuery, Bootstrap)

### Upute za pokretanje aplikacije

#### Potrebni software:
    1. Xamp 
    2. Visual Studio Code
    3. Github desktop ili git za windows

#### Korisni Linkovi:  
   [Download XAMP](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.2.4/xampp-windows-x64-8.2.4-0-VS16-installer.exe/download)  
   [Download Github Desktop](https://desktop.github.com/)  
   [Download VS Code](https://code.visualstudio.com/download)  
   [Git Windows](https://gitforwindows.org/)  

   Napomena: Aplikaciju je moguce klonirati putem git aplikacije za windows koristeci komandu `git clone`  prateci tacke **6.** i **7.** iz upustva za pokretanje

#### Upustvo za pokretanje:  

1. Instalirati XAMP u `C:\xamp\` 
2. Pokrenuti apache i mysql servise
3. Provjeriti da li XAMP radi kucati `localhost` u browser
4. Ukoliko vidimo xamp dashboard instalirati github desktop ili git
5. Povezati se na github racun
6. Klonirati repository sistem-troskovi u `C:\xamp\htdocs\`
7. Link za kloniranje: `https://github.com/leylaglasic/troskovi-sistem.git`
8. Drugi nacin je downloadovati zip repositoryija i ekstraktovati ga u gore navedeni folder `C:\xamp\htdocs\`
9. Provjeriti da li je moguce pristupiti aplikaciji preko linka `localhost/sistem-troskovi`
10. Kreirati bazu za web aplikaciju tako sto cemo importovati sql file za bazu iz `C:\xamp\htdocs\sistem-troskovi\database\baza_troskova.sql` kroz meni `import` u phpmyadmin
11. Po potrebi promjeniti defaultne podatke za povezivanje na bazu podataka u `C:\xamp\htdocs\sistem-troskovi\config\database.php` 
12. Prijaviti se na sistem za pracenje troskova koristeci podatke za prijavu sa pocetne stranice

#### Detalji projekta:

Projekat je osmisljen kao jednostavna aplikacija koja omogucava korisniku da unese prilive i troskove, te odabere vrste priliva i troskova, datum i iznos za svaki unos.  

Korisnik aplikacije koji ima rolu administrator moze dodavati, uredjivati i brisati nove korisnike, vrste troskova i vrste priliva.

Sve role vide meni **Izvjestaj** gdje mogu da vide sazetak troskova, ukupne troskove, prilive i ukupnu ustedu tako sto ce biraju datum **od** i datum **do** te prikazuju izvjestaj putem klika na dugme **Vidi Izvjestaj**  

Ukoliko nije moguce prikazati izvjestaj za odabrani opseg datuma ili ne postoji dovoljno podataka da se izvjestaj prikaze korisniku ce se prikazati ta informacija.

#### Koristene biblioteke:
   1. [Bootstrap](https://getbootstrap.com/) - za izgled
   2. [jQuery](https://jquery.com/) - za manipulaciju prikaza
   3. [DataTables](https://datatables.net/) - za prikaz tabela 
   4. [PHP](https://www.php.net/) - za obradu i prikaz podataka