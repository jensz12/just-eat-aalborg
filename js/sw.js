const cacheName = 'JE-Cache';
const startPage = 'https://justeat.jensz12.com';
const offlinePage = 'https://justeat.jensz12.com/';
const CACHING_DURATION = 7 * 24 * 3600;
const filesToCache = [
  '/img/logo/192.png',
  '/img/logo/512.png',
  '/img/logo/1024.png',
  '/img/logo/je.png',
  '/rest/kastet.png',
  '/rest/jamesrobertson.png',
  '/rest/carlsjr.png',
  '/rest/aalborgstreetfood.jpg',
  '/rest/grillen.png',
  '/rest/esaan.png',
  '/rest/amor.PNG',
  '/rest/jensens.png',
  '/rest/thien-nhi.png',
  '/rest/bogo.png',
  '/rest/bollywood.jpg',
  '/rest/falafel.png',
  '/rest/grill-sandwich.png',
  '/rest/highway66.png',
  '/rest/katjas.png',
  '/rest/southindian.png',
  '/rest/bk.svg',
  '/rest/sunset.svg',
  '/img/andet/je-back.jpg',
  '/img/andet/je-bg.png',
  '/img/andet/back.jpg'
];

// Install
self.addEventListener('install', function(e) {
	console.log('Juest Eat service worker installation');
	e.waitUntil(
		caches.open(cacheName).then(function(cache) {
			console.log('Just Eat service worker caching dependencies');
			filesToCache.map(function(url) {
				return cache.add(url).catch(function (reason) {
					return console.log('Just Eat: ' + String(reason) + ' ' + url);
				});
			});
		})
	);
});

// Activate
self.addEventListener('activate', function(e) {
	console.log('Just Eat service worker activation');
	e.waitUntil(
		caches.keys().then(function(keyList) {
			return Promise.all(keyList.map(function(key) {
				if ( key !== cacheName ) {
					console.log('Just Eat old cache removed', key);
					return caches.delete(key);
				}
			}));
		})
	);
	return self.clients.claim();
});

// Fetch
self.addEventListener('fetch', function(e) {
	
	// Return if request url protocal isn't http or https
	if ( ! e.request.url.match(/^(http|https):\/\//i) )
		return;
	
	// Return if request url is from an external domain.
	if ( new URL(e.request.url).origin !== location.origin )
		return;
	
	// For POST requests, do not use the cache. Serve offline page if offline.
	if ( e.request.method !== 'GET' ) {
		e.respondWith(
			fetch(e.request).catch( function() {
				return caches.match(offlinePage);
			})
		);
		return;
	}
	
	// Revving strategy
	if ( e.request.mode === 'navigate' && navigator.onLine ) {
		e.respondWith(
			fetch(e.request).then(function(response) {
				return caches.open(cacheName).then(function(cache) {
					cache.put(e.request, response.clone());
					return response;
				});  
			})
		);
		return;
	}

	e.respondWith(
		caches.match(e.request).then(function(response) {
			return response || fetch(e.request).then(function(response) {
				return caches.open(cacheName).then(function(cache) {
					cache.put(e.request, response.clone());
					return response;
				});  
			});
		}).catch(function() {
			return caches.match(offlinePage);
		})
	);
});
