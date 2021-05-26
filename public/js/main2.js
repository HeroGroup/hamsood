if ('serviceWorker' in navigator) {
    navigator.serviceWorker
        .register('/sw.js')
        .then(() => { console.log('Service Worker Registered'); });
}

let deferredPrompt;
const installSection = document.getElementById('addToHomeScreen'),
    installBtn = document.querySelector('.install-button');

window.addEventListener('beforeinstallprompt', (evt) => {
    evt.preventDefault();
    deferredPrompt = evt;
    installSection.style.display = 'flex';

    installBtn.addEventListener('click', () => {
        installSection.style.display = 'none';
        deferredPrompt.prompt();

        deferredPrompt.userChoice.then((choiceResult) => {
            deferredPrompt = null;
        });
    });
});
