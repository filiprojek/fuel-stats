# Habit Tracker

Aplikace pro sledování návyků a motivaci k dosažení osobních cílů.

## Funkce
- **Uživatelská autentizace:** Možnost registrace a přihlášení.
- **Správa návyků:** Přidávání, úprava a mazání návyků.
- **Denní kontrola:** Označování splněných návyků každý den.
- **Gamifikace:** Získávání bodů za splněné návyky, odemykání odznaků a postup na vyšší úrovně.
- **Přehled:** Statistiky o pokroku a dosažených úspěších.
- **(Volitelné) Žebříček:** Srovnání bodů mezi uživateli.

## Použité technologie
- **Backend:** PHP (OOP)
- **Databáze:** MySQL
- **Frontend:** HTML, CSS, JavaScript (Bootstrap pro responzivní design)

## Instalace
1. Klonujte tento repozitář:
   ```bash
   git clone https://github.com/vase-repozitar/habit-tracker.git
   ```
2. Importujte databázovou strukturu ze souboru `database.sql` do MySQL.
3. Nakonfigurujte připojení k databázi v souboru `config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'uzivatel');
   define('DB_PASS', 'heslo');
   define('DB_NAME', 'habit_tracker');
   ```
4. Spusťte lokální server (např. pomocí XAMPP nebo WAMP) a přistupte k aplikaci přes prohlížeč.

## Struktura databáze

### Tabulka `users` (uživatelé)
| Sloupec       | Typ         | Popis                      |
|---------------|-------------|----------------------------|
| id            | INT         | Primární klíč             |
| username      | VARCHAR(50) | Uživatelské jméno          |
| email         | VARCHAR(100)| Email                     |
| password      | VARCHAR(255)| Heslo (hashované)         |
| points        | INT         | Celkový počet bodů        |
| created_at    | TIMESTAMP   | Datum registrace          |

### Tabulka `habits` (návyků)
| Sloupec       | Typ         | Popis                      |
|---------------|-------------|----------------------------|
| id            | INT         | Primární klíč             |
| user_id       | INT         | ID uživatele (cizí klíč)   |
| title         | VARCHAR(100)| Název návyku              |
| frequency     | VARCHAR(50) | Frekvence (denní/týdenní) |
| reward_points | INT         | Počet bodů za splnění     |
| created_at    | TIMESTAMP   | Datum vytvoření           |

### Tabulka `progress` (pokrok)
| Sloupec       | Typ         | Popis                      |
|---------------|-------------|----------------------------|
| id            | INT         | Primární klíč             |
| user_id       | INT         | ID uživatele (cizí klíč)   |
| habit_id      | INT         | ID návyku (cizí klíč)      |
| date          | DATE        | Datum splnění             |
| status        | ENUM        | Stav (např. 'Done')       |

### Tabulka `achievements` (odznaky)
| Sloupec       | Typ         | Popis                      |
|---------------|-------------|----------------------------|
| id            | INT         | Primární klíč             |
| user_id       | INT         | ID uživatele (cizí klíč)   |
| achievement   | VARCHAR(100)| Název odznaku             |
| unlocked_at   | TIMESTAMP   | Datum odemknutí           |

## Použití
1. Zaregistrujte se a přihlaste do aplikace.
2. Přidejte své návyky pomocí intuitivního rozhraní.
3. Každý den označte splněné návyky a sledujte svůj pokrok.
4. Sbírejte body a odemykejte odznaky za svou vytrvalost!

## Autor
Tento projekt byl vytvořen jako součást školního zadání.

## Licence
Tento projekt je licencován pod GNU GENERAL PUBLIC LICENSE verze 3. Více informací v souboru `LICENSE`. 

