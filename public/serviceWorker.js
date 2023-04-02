const CACHE_NAME = 'version-1';
const urlsToCache = ['/','/timeline'];

// Install SW
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      console.log('Opened cache');
      return cache.addAll(urlsToCache);
    })
  );
});

// Listen for requests
self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        if (response) {
          return response;
        } else {
          // キャッシュがなければリクエストを投げて、レスポンスをキャッシュに入れる
          return fetch(event.request)
            .then(function(res) {
              return caches.open(CACHE_NAME)
                .then(function(cache) {
                  // 最後に res を返せるように、ここでは clone() する必要がある
                  cache.put(event.request.url, res.clone());
                  return res;
                })
            })
            .catch(function() {
              // エラーが発生しても何もしない
            });
        }
    })
  );
});

// Activate the SW
self.addEventListener('activate', (event) => {
  const casheWhitelist = [];
  casheWhitelist.push(CACHE_NAME);
  event.waitUntil(
    caches.keys().then((casheNames) =>
      Promise.all(
        casheNames.map((casheName) => {
          if (!casheWhitelist.includes(casheName)) {
            return cashes.delete(casheName);
          }
        })
      )
    )
  );
});