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
      icon: payload.notification.image
    };
  
    self.registration.showNotification(notificationTitle, notificationOptions);
});