importScripts(
    "https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js",
);
importScripts(
    "https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging-compat.js",
);

importScripts("/firebase-config.js");

// Initialize the Firebase app in the service worker
firebase.initializeApp(self.firebaseConfig);

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    console.log("[firebase-messaging-sw.js] Background message: ", payload);

    // After switching to Data-only messages in PHP,
    // we should have our info in the 'data' property.
    let notificationTitle, notificationOptions;

    if (payload.data && payload.data.title && payload.data.body) {
        notificationTitle = payload.data.title;
        notificationOptions = {
            body: payload.data.body,
            icon: payload.data.icon || "/images/kedai-cendana-rounded.webp",
            data: payload.data, // carries click_action
        };
    } else if (payload.notification) {
        // Fallback for standard notification messages (from other sources)
        notificationTitle = payload.notification.title;
        notificationOptions = {
            body: payload.notification.body,
            icon:
                payload.notification.icon ||
                "/images/kedai-cendana-rounded.webp",
            data: payload.data,
        };
    } else {
        return; // Nothing to show
    }

    // showNotification returns a promise
    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});

self.addEventListener("notificationclick", function (event) {
    console.log("[firebase-messaging-sw.js] Notification click Received.");
    event.notification.close();

    const data = event.notification.data;
    let urlToOpen = "/"; // Default

    if (data && data.click_action) {
        urlToOpen = data.click_action;
    }

    event.waitUntil(
        clients
            .matchAll({ type: "window", includeUncontrolled: true })
            .then(function (windowClients) {
                // Check if there is already a window open with this URL
                for (let i = 0; i < windowClients.length; i++) {
                    let client = windowClients[i];
                    // Focus if URL matches
                    if (client.url.includes(urlToOpen) && "focus" in client) {
                        return client.focus();
                    }
                }
                // If not open, open a new window
                if (clients.openWindow) {
                    return clients.openWindow(urlToOpen);
                }
            }),
    );
});
