<?php
$potwierdzenie = '';
$bladSerwera = '';

$imieWartosc = isset($_POST['imie']) ? trim($_POST['imie']) : '';
$seansWartosc = isset($_POST['seans']) ? $_POST['seans'] : '2D';
$biletyWartosc = isset($_POST['bilety']) ? (int)$_POST['bilety'] : 1;
$popcornWartosc = isset($_POST['popcorn']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($imieWartosc === '') {
        $bladSerwera = 'Błąd: Proszę podać imię klienta.';
    } elseif ($biletyWartosc < 1) {
        $bladSerwera = 'Błąd: Liczba biletów musi wynosić co najmniej 1.';
    } elseif ($seansWartosc !== '2D' && $seansWartosc !== '3D') {
        $bladSerwera = 'Błąd: Wybrano nieprawidłowy rodzaj seansu.';
    } else {
        $bezpieczneImie = htmlspecialchars($imieWartosc, ENT_QUOTES, 'UTF-8');
        $cenaBiletu = ($seansWartosc === '3D') ? 28 : 22;
        $kosztPopcornu = $popcornWartosc ? 15 : 0;
        $kwotaKoncowa = ($cenaBiletu * $biletyWartosc) + $kosztPopcornu;
        $popcornTekst = $popcornWartosc ? 'Tak (+15 zł)' : 'Nie';

        $potwierdzenie = "
            <section class='podsumowanie'>
                <h2>Potwierdzenie rezerwacji</h2>
                <p><strong>Klient:</strong> {$bezpieczneImie}</p>
                <p><strong>Rodzaj seansu:</strong> Seans {$seansWartosc} ({$cenaBiletu} zł / szt.)</p>
                <p><strong>Liczba biletów:</strong> {$biletyWartosc}</p>
                <p><strong>Zestaw z popcornem:</strong> {$popcornTekst}</p>
                <p class='kwota-koncowa'><strong>Kwota końcowa do zapłaty:</strong> {$kwotaKoncowa} zł</p>
            </section>
        ";
    }
}

$bezpieczneImiePole = htmlspecialchars($imieWartosc, ENT_QUOTES, 'UTF-8');
$biletyPole = $biletyWartosc > 0 ? $biletyWartosc : 1;
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator biletów – Kino „Start”</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>Kino „Start” – Rezerwacja biletów</h1>
    </header>

    <main>
        <form id="formularz-biletow" action="index.php" method="POST">
            <div class="pole-formularza">
                <label for="imie">Imię klienta:</label>
                <input type="text" id="imie" name="imie" placeholder="Wpisz swoje imię" value="<?php echo $bezpieczneImiePole; ?>">
            </div>

            <div class="pole-formularza">
                <label for="seans">Rodzaj seansu:</label>
                <select id="seans" name="seans">
                    <option value="2D" <?php echo ($seansWartosc === '2D') ? 'selected' : ''; ?>>Seans 2D (22 zł / szt.)</option>
                    <option value="3D" <?php echo ($seansWartosc === '3D') ? 'selected' : ''; ?>>Seans 3D (28 zł / szt.)</option>
                </select>
            </div>

            <div class="pole-formularza">
                <label for="bilety">Liczba biletów:</label>
                <input type="number" id="bilety" name="bilety" value="<?php echo $biletyPole; ?>" min="1">
            </div>

            <div class="pole-formularza checkbox-grupa">
                <input type="checkbox" id="popcorn" name="popcorn" value="1" <?php echo $popcornWartosc ? 'checked' : ''; ?>>
                <label for="popcorn">Zestaw z popcornem (+15 zł do zamówienia)</label>
            </div>

            <div class="podglad-ceny">
                Przewidywana kwota do zapłaty: <strong id="cena-na-zywo">22 zł</strong>
            </div>

            <p id="komunikat-bledu" class="blad"><?php echo $bladSerwera; ?></p>

            <button type="submit">Zarezerwuj bilety</button>
        </form>

        <?php echo $potwierdzenie; ?>
    </main>

    <footer>
        <p>Autorka pracy: Nadia Jabłońska</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>