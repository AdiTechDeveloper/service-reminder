function urlB64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
  const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
  const raw = atob(base64);
  return Uint8Array.from([...raw].map((c) => c.charCodeAt(0)));
}

async function enablePush(silent = false) {
  if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
    if (!silent) alert('Is browser mein push notification support nahi hai.');
    return false;
  }
  const permission = Notification.permission === 'granted'
    ? 'granted'
    : await Notification.requestPermission();
  if (permission !== 'granted') {
    if (!silent) alert('Notification permission allow karo.');
    return false;
  }

  const reg = await navigator.serviceWorker.register('/sw.js');
  await navigator.serviceWorker.ready;

  const vapid = document.querySelector('meta[name="vapid-public-key"]').content;
  const sub = (await reg.pushManager.getSubscription()) ||
    (await reg.pushManager.subscribe({
      userVisibleOnly: true,
      applicationServerKey: urlB64ToUint8Array(vapid),
    }));

  const json = sub.toJSON();
  await fetch('/push/subscribe', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    },
    body: JSON.stringify({
      endpoint: json.endpoint,
      keys: json.keys,
      contentEncoding: (PushManager.supportedContentEncodings || ['aesgcm'])[0],
    }),
  });
  return true;
}

document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('enable-push');
  if (!btn) return;
  if ('Notification' in window && Notification.permission === 'granted') {
    btn.classList.add('d-none');
    enablePush(true); // subscription silently refresh
  }
  btn.addEventListener('click', async () => {
    if (await enablePush()) btn.classList.add('d-none');
  });
});
