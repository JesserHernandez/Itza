const CACHE_NAME = "itza-cache-v2";
const urlsToCache = ["/", "/manifest.json", "/img/img-logo/Logo_itzat.svg"];

// Instalar y guardar en caché
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll(urlsToCache))
    );
});

// Activar (limpiar cachés viejas)
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches
            .keys()
            .then((keys) =>
                Promise.all(
                    keys
                        .filter((k) => k !== CACHE_NAME)
                        .map((k) => caches.delete(k))
                )
            )
    );
});

// Interceptar peticiones
self.addEventListener("fetch", (event) => {
    const req = event.request;
    const url = new URL(req.url);

    // 🔹 Ignorar peticiones de Vite, Inertia o hot reload
    if (
        url.pathname.startsWith("/@vite") ||
        url.pathname.endsWith(".vue") ||
        url.pathname.includes("/hot") ||
        url.pathname.endsWith(".js") ||
        url.pathname.endsWith(".ts")
    ) {
        return; // no interceptar
    }

    // 🔹 Responder desde caché o red
    event.respondWith(
        caches.match(req).then((response) => response || fetch(req))
    );
});
