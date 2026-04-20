# Super Admin Views Documentation

## Struktur Direktori
Semua file view ini harus ditempatkan di: `resources/views/super-admin/`

```
resources/views/super-admin/
├── dashboard.blade.php
├── admins/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── users/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── alat/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
└── peminjaman/
    ├── index.blade.php
    ├── create.blade.php
    └── show.blade.php
```

## File Status

### ✅ Sudah Dibuat:
1. dashboard.blade.php
2. admins/index.blade.php
3. admins/create.blade.php
4. admins/edit.blade.php
5. users/index.blade.php
6. users/create.blade.php
7. users/edit.blade.php
8. alat/index.blade.php

### 📝 Perlu Dibuat (Mirip dengan Admin Lab):
9. alat/create.blade.php - Copy dari admin/alat/create.blade.php, ganti route ke super-admin
10. alat/edit.blade.php - Copy dari admin/alat/edit.blade.php, ganti route ke super-admin
11. alat/show.blade.php - Copy dari admin/alat/show.blade.php, ganti route ke super-admin
12. peminjaman/index.blade.php - Copy dari admin/peminjaman/index.blade.php, ganti route ke super-admin
13. peminjaman/create.blade.php - Copy dari admin/peminjaman/create.blade.php, ganti route ke super-admin
14. peminjaman/show.blade.php - Copy dari admin/peminjaman/show.blade.php, ganti route ke super-admin

## Cara Cepat Membuat File Yang Tersisa

Karena Super Admin memiliki fitur yang sama dengan Admin Lab untuk alat dan peminjaman,
Anda bisa copy file dari admin dan replace route-nya:

### Untuk Alat:
```bash
# Copy create
cp resources/views/admin/alat/create.blade.php resources/views/super-admin/alat/create.blade.php
# Ganti semua route('admin.alat. menjadi route('super-admin.alat.
sed -i "s/route('admin\.alat\./route('super-admin.alat./g" resources/views/super-admin/alat/create.blade.php
sed -i "s/@extends('layouts\.admin')/@extends('layouts.super-admin')/g" resources/views/super-admin/alat/create.blade.php

# Copy edit
cp resources/views/admin/alat/edit.blade.php resources/views/super-admin/alat/edit.blade.php
sed -i "s/route('admin\.alat\./route('super-admin.alat./g" resources/views/super-admin/alat/edit.blade.php
sed -i "s/@extends('layouts\.admin')/@extends('layouts.super-admin')/g" resources/views/super-admin/alat/edit.blade.php

# Copy show  
cp resources/views/admin/alat/show.blade.php resources/views/super-admin/alat/show.blade.php
sed -i "s/route('admin\.alat\./route('super-admin.alat./g" resources/views/super-admin/alat/show.blade.php
sed -i "s/@extends('layouts\.admin')/@extends('layouts.super-admin')/g" resources/views/super-admin/alat/show.blade.php
```

### Untuk Peminjaman:
```bash
# Copy create
cp resources/views/admin/peminjaman/create.blade.php resources/views/super-admin/peminjaman/create.blade.php
sed -i "s/route('admin\.peminjaman\./route('super-admin.peminjaman./g" resources/views/super-admin/peminjaman/create.blade.php
sed -i "s/@extends('layouts\.admin')/@extends('layouts.super-admin')/g" resources/views/super-admin/peminjaman/create.blade.php

# Copy show
cp resources/views/admin/peminjaman/show.blade.php resources/views/super-admin/peminjaman/show.blade.php
sed -i "s/route('admin\.peminjaman\./route('super-admin.peminjaman./g" resources/views/super-admin/peminjaman/show.blade.php
sed -i "s/@extends('layouts\.admin')/@extends('layouts.super-admin')/g" resources/views/super-admin/peminjaman/show.blade.php
```

## Notes Penting

1. **Layout**: Semua view menggunakan `@extends('layouts.super-admin')`
2. **Routes**: Semua menggunakan prefix `super-admin.` (contoh: `super-admin.users.index`)
3. **Warna Navbar**: Layout super-admin menggunakan gradient pink/red (berbeda dari admin lab yang ungu)
4. **Menu Navbar**: Super Admin punya menu:
   - Dashboard
   - Kelola Admin
   - Riwayat Peminjaman

## Testing Checklist

Setelah semua file dibuat, test:
- [ ] Dashboard super admin muncul dengan statistik lengkap
- [ ] CRUD Admin berfungsi (create, read, update, delete)
- [ ] CRUD User berfungsi (create, read, update, delete)
- [ ] CRUD Alat berfungsi (create, read, update, delete, toggle status)
- [ ] CRUD Peminjaman berfungsi (create, show, approve, reject, process, return, delete)
- [ ] Filter dan search di semua halaman berfungsi
- [ ] Pagination berfungsi
- [ ] Alert success/error muncul dengan benar
- [ ] Responsive di mobile

