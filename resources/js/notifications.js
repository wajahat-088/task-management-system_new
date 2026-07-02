import { messaging, getToken, onMessage } from './firebase';

async function initPushNotifications() {
    try {
        //  const registration = await navigator.serviceWorker.register(
        //     '/task-manager/public/firebase-messaging-sw.js',
        //     { scope: '/task-manager/public/' }
        // );
        // console.log('Service worker registered:', registration);
        const permission = await Notification.requestPermission();

        if (permission !== 'granted') {
            console.log('Notification permission denied.');
            return;
        }

        const token = await getToken(messaging, {
            vapidKey: 'BC8YUGoKa4RcPFvKp2afz8daXsSg6HHCLnCs0nVEEo3IXmD0sf1TtIwMGxSwd_HDKUvYXqXX_w9ZUzmEuEc_fqg', 
        });

        if (token) {
            await fetch('/fcm-token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ token }),
            });
            console.log('FCM token saved successfully.');
        }
    } catch (err) {
        console.error('FCM token error:', err);
    }
}

onMessage(messaging, (payload) => {
    showInAppToast(payload.notification.title, payload.notification.body);
});

function showInAppToast(title, body) {
    const toast = document.getElementById('toast');
    if (toast) {
        toast.textContent = `${title}: ${body}`;
        toast.className = 'fixed top-5 right-5 px-4 py-3 rounded shadow-lg text-white text-sm z-50 bg-indigo-600';
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 5000);
    }
}

initPushNotifications();