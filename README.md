# Kovács Dániel (ADEJ1R)

## Ez a feldaat az alábbi bedandó munka: Webprogramozás II.

Olyan böngészőben használható webes alkalmazást kell készíteni, amely a háttérben egy fájl adatainak kezelését látja el. Keretes szerkezetben kell dolgozni (minden kérést az index.php hajt végre, és ez tölti be a GET kérés parmaéterei alapján a megfelelő tartalmat).
minden funkció ellátáshoz HTML nézetet kell biztosítani (alap HTML + CSS, lehet Bootstrap) (C - létrehozás (űrlap), R - olvasás (lista + egyedi nézet, U - módosítás (űrlap), D - törlés (funkció, nem kell külön nézet));
az "adatbázis" egy fájl (csv/json) legalább 5 adat (szöveg, szám), legyen olyan adat, amit az űrlapon vagy radio/checkbox/select formában kell kezelni
funkciók működjenek, az űrlapadatokat validáljuk

RestFul API fejlesztése (levelező tanárképzéses hallgatóknak ezt nem kell megcsinálni)
az "adatbázis" adatbázis (használható a korábbi szöveges adatmodell, csak db-re képezzük le)
GET, POST, PUT és DELETE metódusokon kersztül támogassuk az API alapú adatkezelést
a bejövő adatokat validálni kell

### Szerkezet: 

- index.php: Webes fellet belépési pontja
- api: php Restful API belépési pontja
- public (/assets/*) Publikusan elérhető assetek, Bootstrap, esetleges CSS Javascript fájlok
- private: Az alkalmazás működéséhez szükséges állományok
- private /classes: CRUD műveletek osztályai
- config: Konfigurációs állomány mappája
- data: Az adatbázisul szolgáló JSON állomány található ebben a mappában. A fájlnak nem kell léteznie, létrejön, de a mappának igen.
- templates: A fő sablon PHP állománya és minden további szükséges HTML template amely túlnagy lehet közvetlenül PHP kódból generálva. Jelenleg csak a létrehozás / módosítás űrlap
- private/utility.php: Közös metódusok gyűjtője, singleton osztály, csak egyszer inicializálható
- private/database.php: API lekérdezésnél az adatbázis kapcsolat létrehozásáért és az adatbázisműveletek végrehajtásáért felelős osztály.

## Webes felület működése

A webes felület nem használ adatbázist, egy JSON fájlban tárolja az adatokat. Ez nyilván zárolás, adatintegritás szempontjából aggályos.
A felület indításához a config/config.php értelemszerű módosítása szükséges. A webes felület elindításához adatázis kapcsolat, így ezeknek a paramétereknek a beállítása nem szükséges.
Az űrlapokon minden adat kitöltése kötelező. A required html attribútumot eltávolítottam, hogy az ellenőzések mindenképpen a PHP kódbók fussanak le.

Az egyszerűsége és a rendkívüli hasonlósága miatt a CREATE és UPDATE metódusoknak nem készült önálló osztály, helyette egy CreateUpdate osztály végzi el a feladatot függően attól hogy az indítás során kapott-e id-t (UPDATE) vagy sem (CREATE)

## RESTFUL API működése

A restapi a /api.php végpontról indítható.
A használatához szükséges MySQL vagy MariaDB adatbáziskapcsolat kiépítése, a kapcsolódáshoz szükséges adatokat a config/config.php állományban értelemszerűen ki kell tölteni.
Az adatbázisba importálni kell a private/dump/sql.php állományt, ami egyetlen táblát hoz létre.


Az api endpointot egy konstans Bearer token védi, az endpointok eléréséhez
````
Authorizatoin: Bearer ekkeik
````

fejléc küldése szükséges. A token a konfigurációs állományban módosítható.

Az api endpointon keresztül az alábbi szolgáltatások érhetőek el:

### GET /api.php
visszaadja a teljes listát.
Várt http státusz: 200
````
[
    {
        id: 1,
        iro: "módosított 3 író",
        szindarab: "Mdosított színdarab",
        rendezo: "Módosított rendező",
        mufaj: "Módosított műfaj",
        szinpad: "Módosított színpad"
    },
    {
        id: 2,
        iro: "Második író",
        szindarab: "Második színdarab",
        rendezo: "Második rendező",
        mufaj: "Második műfaj",
        szinpad: "Második színpad"
    }
]
````

### GET /api.php/[id:num]
Visszaadja az adott azonosítójú elemet az adatbázisból.
pl. GET /api.php/1
várt http státusz: 200
````
{
    id: 1,
    iro: "módosított 3 író",
    szindarab: "Mdosított színdarab",
    rendezo: "Módosított rendező",
    mufaj: "Módosított műfaj",
    szinpad: "Módosított színpad"
}
````

POST /api.php
Létrehoz egy rekordot az adatbázisban, hiba esetén hibaüzenetet ad vissza.

Body-ban az új rekord JSON objektumát kell átadni.

Példa body:
````
{
"iro": "harmadik író",
"szindarab": "harmadik színdarab",
"rendezo": "harmadik rendező",
"mufaj": "harmadik műfaj",
"szinpad": "harmadik színpad"
}
````

Várt http státusz: 201
````
{
    id: 3,
    iro: "harmadik író",
    szindarab: "harmadik színdarab",
    rendezo: "harmadik rendező",
    mufaj: "harmadik műfaj",
    szinpad: "harmadik színpad"
}
````

## PUT api.php/[id:num]
Módosítja a megadott azonosítójú rekordot az adatbázisban.
Body-ban az új rekord JSON objektumát kell átadni.

Példa body:
````
{
"iro": "harmadik író",
"szindarab": "harmadik színdarab",
"rendezo": "harmadik rendező",
"mufaj": "harmadik műfaj",
"szinpad": "harmadik színpad"
}
````

Várt http státusz: 204
Várt válasz: Nincs

##DELETE api.php/1

Törli a megadott rekordú adatot az adatbázisból.

Várt http státusz: 200

Az api endpointok mindegyike hibaüzenet ad vissza, ha a feldolgozás során probléma történik
````
["message" => "Hibaüzenet" ]
````

formában, a http státusz kód pedig tükrözi a hiba jellegét. (400, 404, 500)
