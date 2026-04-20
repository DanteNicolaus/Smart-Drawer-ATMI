(function () {
    const sessionLifetime = (window.sessionLifetime || 120) * 60 * 1000;

    setInterval(function () {
        fetch('/check-session-status', {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (!data.authenticated) {
                showExpired();
            }
        })
        .catch(function () {
            // Diam saja jika gagal konek, coba lagi interval berikutnya
        });
    }, 10000);

    let expiredShown = false; // Cegah modal muncul berkali-kali

    function showExpired() {
        if (expiredShown) return;
        expiredShown = true;

        const modal = document.getElementById('sessionExpiredModal');
        if (modal) modal.style.display = 'flex';
    }

    // Fungsi dipanggil oleh tombol OK di modal
    window.redirectToLogin = function () {
        window.location.replace('/login');
    };
})();