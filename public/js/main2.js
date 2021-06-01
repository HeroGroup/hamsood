var pwaSupport = false;
if ('serviceWorker' in navigator) {
    pwaSupport = true;
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

function hidePrompt() {
    installSection.style.display = 'none';
}

window.onload = function() {
    if(pwaSupport) {
        var p = navigator.platform;
        if(p === 'iPhone' || p === 'iPad' || p === 'iPod') {
            if(!navigator.standalone) {
                var lastShown = parseInt(localStorage.getItem('lastShown'));
                var now = new Date().getTime();
                if(isNaN(lastShown) || (lastShown + 1000*60*60*24*7) <= now) {
                    document.getElementById("ios-install-instructions").style.display = "block";
                    localStorage.setItem('lastShown', now.toString());
                }
            }
        }
    }
};

function hideInstructions() {
    document.getElementById("ios-install-instructions").style.display = "none";
}
