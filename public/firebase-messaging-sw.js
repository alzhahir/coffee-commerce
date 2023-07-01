importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js')
importScripts("https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js")

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object

firebaseConfig = {
    apiKey: "AIzaSyBYu-HeucZacAKoAJHgwAzNYYjSKhhxZYw",
    authDomain: "mdvpnzone.firebaseapp.com",
    projectId: "mdvpnzone",
    storageBucket: "mdvpnzone.appspot.com",
    messagingSenderId: "429146314022",
    appId: "1:429146314022:web:030e8efdfaaf8caa285de7",
    measurementId: "G-ZQSPFKPBLL"
};

firebase.initializeApp(firebaseConfig);

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
messaging = firebase.messaging();
messaging.onBackgroundMessage((payload) => {
    console.log(
		'[firebase-messaging-sw.js] Received background message ',
		payload
    );
    // Customize notification here
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
		body: payload.notification.body,
		icon: payload.notification.image,
        tag: payload.data.id,
    };
  
    self.registration.showNotification(notificationTitle, notificationOptions);
});

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
            if (client.url === "/" && "focus" in client) return client.focus();
            }
            if (clients.openWindow) return clients.openWindow("/");
        })
	);
};