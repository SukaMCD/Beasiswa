// FCM Frontend Logic
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js";
import {
    getMessaging,
    getToken,
    onMessage,
} from "https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging.js";

// Use dynamic config from self.firebaseConfig (loaded in footer)
const firebaseConfig = self.firebaseConfig || {};

const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

function requestPermission() {
    console.log("Requesting permission...");
    Notification.requestPermission().then((permission) => {
        if (permission === "granted") {
            console.log("Notification permission granted.");
            saveToken();
        } else {
            console.log("Unable to get permission to notify.");
        }
    });
}

function saveToken() {
    getToken(messaging, {
        vapidKey: firebaseConfig.vapidKey,
    })
        .then((currentToken) => {
            if (currentToken) {
                console.log("FCM Token:", currentToken);
                // Send token to backend
                fetch("/notifications/subscribe", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({
                        fcm_token: currentToken,
                        device_type: "web",
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => console.log("Token saved:", data))
                    .catch((err) => console.error("Error saving token:", err));
            } else {
                console.log(
                    "No registration token available. Request permission to generate one.",
                );
            }
        })
        .catch((err) => {
            console.log("An error occurred while retrieving token. ", err);
        });
}

// Initial check
if ("Notification" in window) {
    if (Notification.permission === "granted") {
        saveToken();
    } else if (Notification.permission !== "denied") {
        // You might want to trigger this after a user interaction
        // requestPermission();
    }
}

onMessage(messaging, (payload) => {
    console.log("Foreground message received. ", payload);
    const data = payload.data;

    // Show notification using SweetAlert2 if available
    if (data && data.title && data.body && window.Swal) {
        Swal.fire({
            title: data.title,
            text: data.body,
            icon: "info",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 5000,
        });
    }
});
