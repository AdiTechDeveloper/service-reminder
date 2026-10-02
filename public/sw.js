// Service Worker: browser band ho tab bhi (OS level) push receive karta hai
self.addEventListener('push', function (event) {
  if (!event.data) return;
  const message = event.data.json();
  event.waitUntil(self.registration.showNotification(message.title, message));
});

self.addEventListener('notificationclick', function (event) {
  event.notification.close();
  const url = (event.notification.data && event.notification.data.url) || '/notifications';

  event.waitUntil(
    clients.matchAll({ type: 'window', includeUncontrolled: true }).then((list) => {
      const client = list.find((c) => 'focus' in c);
      if (client) {
        return client.navigate(url)
          .then((c) => (c || client).focus())
          .catch(() => clients.openWindow(url));
      }
      return clients.openWindow(url);
    })
  );
});