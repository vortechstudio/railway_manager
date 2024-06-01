import './bootstrap';
import Swiper from 'swiper';
import 'swiper/css'
import 'animate.css'
import './isotoemoji.js'
import './plugins.js'
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import { polyfillCountryFlagEmojis } from "country-flag-emoji-polyfill";
Livewire.start()
polyfillCountryFlagEmojis();

const swiper = new Swiper('.swiper', {
    spaceBetween: 30,
    hashNavigation: {
        watchState: true,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
})

function initSW() {
    if (!"serviceWorker" in navigator) {
        //service worker isn't supported
        return;
    }

    //don't use it here if you use service worker
    //for other stuff.
    if (!"PushManager" in window) {
        //push isn't supported
        return;
    }

    //register the service worker
    navigator.serviceWorker.register('/serviceworker.js')
        .then(() => {
            console.log('serviceWorker installed!')
            initPush();
        })
        .catch((err) => {
            console.log(err)
        });
}

function initPush() {
    if (!navigator.serviceWorker.ready) {
        return;
    }

    new Promise(function (resolve, reject) {
        const permissionResult = Notification.requestPermission(function (result) {
            resolve(result);
        });

        if (permissionResult) {
            permissionResult.then(resolve, reject);
        }
    })
        .then((permissionResult) => {
            if (permissionResult !== 'granted') {
                throw new Error('We weren\'t granted permission.');
            }
            subscribeUser();
        });
}

function subscribeUser() {
    navigator.serviceWorker.ready
        .then((registration) => {
            const subscribeOptions = {
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(
                    `${import.meta.env.VITE_VAPID_PUBLIC_KEY}`
                )
            };

            return registration.pushManager.subscribe(subscribeOptions);
        })
        .then((pushSubscription) => {
            console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
            storePushSubscription(pushSubscription);
        });
}

function urlBase64ToUint8Array(base64String) {
    let padding = '='.repeat((4 - base64String.length % 4) % 4);
    let base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    let rawData = window.atob(base64);
    let outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

function storePushSubscription(pushSubscription) {
    const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

    fetch('/push', {
        method: 'POST',
        body: JSON.stringify(pushSubscription),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-Token': token
        }
    })
        .then((res) => {
            return res.json();
        })
        .then((res) => {
            console.log(res)
        })
        .catch((err) => {
            console.log(err)
        });
}

if (NodeList.prototype.forEach === undefined) {
    NodeList.prototype.forEach = function (callback) {
        [].forEach.call(this, callback)
    }
}

let terms = [{
    time: 45,
    divide: 60,
    text: 'moins d\'une minute'
}, {
    time: 90,
    divide: 60,
    text: 'environ une minute'
}, {
    time: 45 * 60,
    divide: 60,
    text: '%d minutes'
}, {
    time: 90 * 60,
    divide: 60 * 60,
    text: 'environ une heure'
}, {
    time: 24 * 60 * 60,
    divide: 60 * 60,
    text: '%d heures'
}, {
    time: 42 * 60 * 60,
    divide: 24 * 60 * 60,
    text: 'environ un jour'
}, {
    time: 30 * 24 * 60 * 60,
    divide: 24 * 60 * 60,
    text: '%d jours'
}, {
    time: 45 * 24 * 60 * 60,
    divide: 24 * 60 * 60 * 30,
    text: 'environ un mois'
}, {
    time: 365 * 24 * 60 * 60,
    divide: 24 * 60 * 60 * 30,
    text: '%d mois'
}, {
    time: 365 * 1.5 * 24 * 60 * 60,
    divide: 24 * 60 * 60 * 365,
    text: 'environ un an'
}, {
    time: Infinity,
    divide: 24 * 60 * 60 * 365,
    text: '%d ans'
}]

document.querySelectorAll('[data-ago]').forEach(function (node) {

    let date = parseInt(node.dataset.ago, 10)

    function setText () {
        let secondes = Math.floor((new Date()).getTime() / 1000 - date)
        let prefix = secondes > 0 ? 'Il y a ' : 'Dans '
        let term = null
        secondes = Math.abs(secondes)
        for (term of terms) {
            if (secondes < term.time) {
                break
            }
        }
        node.innerHTML = prefix + term.text.replace('%d', Math.round(secondes / term.divide))

        let nextTick = secondes % term.divide
        if (nextTick === 0) {
            nextTick = term.divide
        }

        window.setTimeout(function () {
            if (node.parentNode) {
                if (window.requestAnimationFrame) {
                    window.requestAnimationFrame(setText)
                } else {
                    setText()
                }
            }
        }, nextTick * 1000)
    }

    setText()
})


initSW()
