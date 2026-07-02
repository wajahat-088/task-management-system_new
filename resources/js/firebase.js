import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage } from "firebase/messaging";

const firebaseConfig = {
    apiKey: "AIzaSyANQxoUUEpviZC4YaQXAH4dwvQ6yJYaZqI",
    authDomain: "task-manager-notificatio-3322d.firebaseapp.com",
    projectId: "task-manager-notificatio-3322d",
    storageBucket: "task-manager-notificatio-3322d.firebasestorage.app",
    messagingSenderId: "833114159895",
    appId: "1:833114159895:web:c515fe953d8925263c9552",
};

const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

export { messaging, getToken, onMessage };