# Feladat informális leírása
A feladat célja, egy szállodában a szobák foglalását tartalmazó adatbázis karbantartása. Az alkalmazás adatbázisában tároljuk a szobákat, azok tulajdonságait, a vendégeket és a hozzájuk tartozó adatokat.

A cél az, hogy nyomon tudjuk követni, hogy éppen melyik szoba van szabadon, vagy éppen melyik szobában tartózkodik valaki, továbbá egy egyértelműen áttekinthető foglaltsági naptárat hozzunk létre, mely alapján a szobák rendelkezésre állása könnyen eldönthető.

# Elérhető funkciók
- Szobák kezelése (/room.php) :
    - Új szoba létrehozása
    - Meglévő szoba adatainak módosítása
    - Szoba törlése
    - Szobák listázása
    - Foglaltsági naptár, egy szoba adott foglalásainak kijelzése
    - Szabad szoba keresése megadott dátumintervallumra

- Vendégek kezelése (/guest.php) :
    - Új vendég létrehozása
    - Meglévő vendég adatainak a módosítása
    - Vendég törlése
    - A vendégek listázása

- Foglalások kezelése (/booking.php) :
    - Új foglalás felvétele
    - Foglalás törlése
    - Foglalás módosítása
    - Kijelentkezés
    
# Adatbázis séma
Az adatbázisban a következő entitásokat és attribútumokat tároljuk:

- Szoba: azonosító, szobaszám, ár, férőhely, extra, kategória
- Vendég: azonosító, név, telefon, e-mail, 
- Foglalás: azonosító, vendég, szoba, foglalás kezdete, foglalás vége, ár

A fenti adatok tárolását az alábbi sémával oldjuk meg:

![hotelmanschema](./doc/hotelman-schema.png "schema" )
