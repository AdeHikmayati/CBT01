const staticCacheName = 'site-static-v11';
const dynamicCacheName = 'site-dynamic-v11';
const assets = [

  'manifest.json',
  'index.js',
  'assets/dist/css/mystyle.css',
  'assets/dist/css/AdminLTE.min.css',
  'assets/dist/js/adminlte.min.js',
  'offline.php',
   'fallback.html',
  'dosen.html',
  'assets/dist/img/icon-192x192.png',
  '/'
  

  
];

// install event
self.addEventListener('install', evt => {
  //console.log('service worker installed');
  evt.waitUntil(
    caches.open(staticCacheName).then((cache) => {
      console.log('caching shell assets');
      cache.addAll(assets);
    })
  )
});

// activate event
self.addEventListener('activate', evt => {
  //console.log('service worker activated');
   evt.waitUntil(
    caches.keys()
    .then(keys => {
      //console.log(keys);
      return Promise.all(keys.map(function(key){
      	if (key !== staticCacheName && key !== dynamicCacheName){
      		console.log('Removing old cache.', key);
      		return caches.delete(key);
      	}
      }));
  })
    );
   return self.clients.claim();
});
// fetch event
self.addEventListener('fetch', function(event) {
  //console.log('fetch event', evt);
  event.respondWith(
  	//try the network
  	fetch(event.request)
  		.then(function(fetchRes){
  			return caches.open(dynamicCacheName)
  			.then(function(cache){
  			//put in cache if succeeds
  			cache.put(event.request.url, fetchRes.clone());
  			return fetchRes;
  		})
  	})
  	 .catch(function(err) {
          // Fallback to cache
          return caches.match('fallback.html');
      })
  );
});