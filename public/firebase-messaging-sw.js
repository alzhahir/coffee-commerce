importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js')
importScripts("https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js")

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object

/*firebaseConfig = {
    apiKey: "AIzaSyBYu-HeucZacAKoAJHgwAzNYYjSKhhxZYw",
    authDomain: "mdvpnzone.firebaseapp.com",
    projectId: "mdvpnzone",
    storageBucket: "mdvpnzone.appspot.com",
    messagingSenderId: "429146314022",
    appId: "1:429146314022:web:030e8efdfaaf8caa285de7",
    measurementId: "G-ZQSPFKPBLL"
};*/

import * as firebaseConfig from '/firebase-config.json' assert{type: 'json'};

firebase.initializeApp(firebaseConfig);

class CustomPushEvent extends Event {
    constructor(data) {
        super('push')

        Object.assign(this, data)
        this.custom = true
    }
}

/*
 * Overrides push notification data, to avoid having 'notification' key and firebase blocking
 * the message handler from being called
 */
self.addEventListener('push', (e) => {
    // Skip if event is our own custom event
    if (e.custom) return;

    // Kep old event data to override
    let oldData = e.data

    // Create a new event to dispatch, pull values from notification key and put it in data key, 
    // and then remove notification key
    let newEvent = new CustomPushEvent({
        data: {
            json() {
                let newData = oldData.json()
                newData.data = {
                    ...newData.data,
                    ...newData.notification
                }
                delete newData.notification
                return newData
            },
        },
        waitUntil: e.waitUntil.bind(e),
    })

    // Stop event propagation
    e.stopImmediatePropagation()

    // Dispatch the new wrapped event
    dispatchEvent(newEvent)
})

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
messaging = firebase.messaging();
messaging.onBackgroundMessage((payload) => {
    console.log(
		'[firebase-messaging-sw.js] Received background message ',
		payload
    );
    // Customize notification here
    const notificationTitle = payload.data.title;
    const notificationOptions = {
		body: payload.data.body,
		icon: payload.data.image,
        tag: payload.data.id,
        data: {
            redirect: payload.data.redirect,
        }
    };
  
    self.registration.showNotification(notificationTitle, notificationOptions);
    self.onnotificationclick = (event) => {
        console.log("On notification click: ", event.notification.tag);
        event.notification.close();
    
        // This looks to see if the current is already open and
        // focuses if it is
        event.waitUntil(
            clients
            .matchAll({
                type: "window",
            })
            .then((clientList) => {
                for (const client of clientList) {
                if (client.url === event.notification.data.redirect && "focus" in client) return client.focus();
                }
                if (clients.openWindow) return clients.openWindow(event.notification.data.redirect);
            })
        );
    };
});