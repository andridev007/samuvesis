# SAMUVE (Laravel Rebuild)

Ringkas:
- Wallet terpisah: Remaining Profit vs Remaining Bonus
- Join: Manual / Profit / Bonus, semuanya wajib +10% lisensi + kode unik (3 digit)
- Dream auto-compound juga kena lisensi 10% (net 90% masuk effective balance)
- Distribusi: 60% user, 40% jaringan (1–9: 7,3,3,1,1,0.5,0.5,0.5,0.5)
- PWA + Tailwind dark UI

Setup cepat:
1) composer require spatie/laravel-permission laravel/sanctum laravel/horizon maatwebsite/excel barryvdh/laravel-dompdf
2) composer require laravel/breeze --dev && php artisan breeze:install
3) npm install && npm install vite-plugin-pwa --save-dev
4) .env, php artisan key:generate
5) php artisan migrate && php artisan db:seed
6) npm run dev

Command tambahan akan ditambahkan untuk profit:process.
