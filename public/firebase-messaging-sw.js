importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "AIzaSyANQxoUUEpviZC4YaQXAH4dwvQ6yJYaZqI",
    authDomain: "task-manager-notificatio-3322d.firebaseapp.com",
    projectId: "task-manager-notificatio-3322d",
    storageBucket: "task-manager-notificatio-3322d.firebasestorage.app",
    messagingSenderId: "833114159895",
    appId: "1:833114159895:web:c515fe953d8925263c9552",
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    self.registration.showNotification(payload.notification.title, {
        body: payload.notification.body,
        icon: '/favicon.ico',
        data: payload.data,
    });
});