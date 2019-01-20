<script>
    function subscribe() {
        navigator.serviceWorker.ready.then(function (serviceWorkerRegistration) {
            serviceWorkerRegistration.pushManager.subscribe({userVisibleOnly: true})
                .then(function (subscription) {
                    return sendSubscriptionToServer(subscription);
                })
                .catch(function (e) {
                    if (Notification.permission === 'denied') {
                        console.warn('Permission for Notifications was denied');
                        alert('Permission for Notifications was denied');
                    } else {
                        console.error('Unable to subscribe to push.', e);
                        alert('Unable to subscribe to push.', e);
                    }
                });
        });
    }

    subscribe();

    navigator.serviceWorker.register('sw.js.php').then(initialiseState);

    function sendSubscriptionToServer(subscription) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                console.log("subscription saved: " + subscription.endpoint);
            }
        };
        xhttp.open("GET", "action/savePushRegistrationId.php?q=" + subscription.endpoint, true);
        xhttp.send();

    }

    function initialiseState() {
        // Are Notifications supported in the service worker?
        if (!('showNotification' in ServiceWorkerRegistration.prototype)) {
            console.warn('Notifications aren\'t supported.');
            alert('Notifications aren\'t supported.');
            return;
        }

        // Check the current Notification permission.
        // If its denied, it's a permanent block until the
        // user changes the permission
        if (Notification.permission === 'denied') {
            console.warn('The user has blocked notifications.');
            alert('The user has blocked notifications.');
            return;
        }

        // Check if push messaging is supported
        if (!('PushManager' in window)) {
            console.warn('Push messaging isn\'t supported.');
            alert('Push messaging isn\'t supported.');
            return;
        }

        // We need the service worker registration to check for a subscription
        navigator.serviceWorker.ready.then(function (serviceWorkerRegistration) {
            // Do we already have a push message subscription?
            serviceWorkerRegistration.pushManager.getSubscription()
                .then(function (subscription) {
                    // Keep your server in sync with the latest subscriptionId
                    sendSubscriptionToServer(subscription);
                })
                .catch(function (err) {
                    console.warn('Error during getSubscription()', err);
                    alert('Error during getSubscription()'  + JSON.stringify(err));
                });
        });
    }
</script>