if('serviceWorker' in navigator) {
    // register the service worker
    navigator.serviceWorker.register('/sw.js').then(function (result) {
        console.log("Service Worker Registered!");
        console.log("Scope: " + result.scope);
    }, function (error) {
        console.log("Service Worker Registration Failed");
        console.log(error);
    });
} else {
    console.log("Service Workers Not Supported!");
}

var installEvt;
window.addEventListener('beforeinstallprompt', function(evt) {
    console.log("before install prompt event");
    installEvt = evt;
    evt.preventDefault();
    document.getElementById("addToHomeScreen").style.display = "block";
});

function hidePrompt() {
    document.getElementById("addToHomeScreen").style.display = "none";
}

function installApp() {
    hidePrompt();
    installEvt.prompt();
    installEvt.userChoice.then(function(result) {
        if(result.outcome === 'accepted')
            console.log("app installed");
        else
            console.log("app NOT installed");
    });
}

window.addEventListener('appinstalled', function() {
    console.log("app installed event");
});
