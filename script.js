document.addEventListener('DOMContentLoaded', () => {
    const formularz = document.getElementById('formularz-biletow');
    const poleImie = document.getElementById('imie');
    const poleSeans = document.getElementById('seans');
    const poleBilety = document.getElementById('bilety');
    const polePopcorn = document.getElementById('popcorn');
    const wyswietlaczCeny = document.getElementById('cena-na-zywo');
    const komunikatBledu = document.getElementById('komunikat-bledu');

    function aktualizujCene() {
        const rodzajSeansu = poleSeans.value;
        const liczbaBiletow = parseInt(poleBilety.value, 10) || 0;
        const czyPopcorn = polePopcorn.checked;

        if (liczbaBiletow < 1) {
            wyswietlaczCeny.textContent = '0 zł';
            return;
        }

        const cenaZaBilet = (rodzajSeansu === '3D') ? 28 : 22;
        const kosztPopcornu = czyPopcorn ? 15 : 0;
        const suma = (cenaZaBilet * liczbaBiletow) + kosztPopcornu;

        wyswietlaczCeny.textContent = `${suma} zł`;
    }

    poleSeans.addEventListener('change', aktualizujCene);
    poleBilety.addEventListener('input', aktualizujCene);
    polePopcorn.addEventListener('change', aktualizujCene);

    formularz.addEventListener('submit', (event) => {
        komunikatBledu.textContent = '';

        const imie = poleImie.value.trim();
        const liczbaBiletow = parseInt(poleBilety.value, 10);

        if (imie === '') {
            event.preventDefault();
            komunikatBledu.textContent = 'Proszę wpisać imię klienta przed wysłaniem formularza.';
            poleImie.focus();
            return;
        }

        if (isNaN(liczbaBiletow) || liczbaBiletow < 1) {
            event.preventDefault();
            komunikatBledu.textContent = 'Liczba biletów musi wynosić co najmniej 1.';
            poleBilety.focus();
            return;
        }
    });

    aktualizujCene();
});