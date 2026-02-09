# 📝 Panduan Testing Order & OrderItem API di Postman

Dokumen ini berisi panduan lengkap untuk melakukan testing endpoint Order dan OrderItem menggunakan Postman.

## 🔐 Persiapan Awal

### 1. Login Terlebih Dahulu

Sebelum melakukan testing Order API, Anda harus login terlebih dahulu untuk mendapatkan **Bearer Token**.

**Endpoint Login:**

```
POST http://localhost:8000/api/login
```

**Headers:**

```
Content-Type: application/json
Accept: application/json
```

**Body (raw JSON):**

```json
{
  "email": "admin@example.com",
  "password": "password123"
}
```

**Response yang akan didapat:**

```json
{
  "status": "success",
  "token": "1|aBcDeFgHiJkLmNoPqRsTuVwXyZ...",
  "user": {
    "id": 1,
    "name": "Admin",
    "email": "admin@example.com"
  }
}
```

> ⚠️ **PENTING:** Simpan token yang didapat! Token ini akan digunakan untuk semua request API selanjutnya.

---

## 📦 Testing Order API

### 1️⃣ Membuat Order Baru (Create Order)

**Endpoint:**

```
POST http://localhost:8000/api/orders
```

**Headers:**

```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {your_token_here}
```

> 💡 **Cara setting Authorization di Postman:**
>
> 1. Buka tab **Authorization**
> 2. Pilih Type: **Bearer Token**
> 3. Paste token yang didapat dari login di kolom **Token**

**Body (raw JSON):**

```json
{
  "transaction_time": "2026-02-09 21:00:00",
  "total_price": 150000,
  "total_item": 3,
  "payment_method": "cash",
  "cashier_id": 1,
  "cashier_name": "Admin",
  "payment_amount": 200000,
  "order_items": [
    {
      "product_id": 1,
      "quantity": 2,
      "total_price": 100000
    },
    {
      "product_id": 2,
      "quantity": 1,
      "total_price": 50000
    }
  ]
}
```

**Penjelasan Field:**

- `transaction_time`: Waktu transaksi (format: YYYY-MM-DD HH:MM:SS)
- `total_price`: Total harga keseluruhan (integer)
- `total_item`: Jumlah total item yang dibeli (integer)
- `payment_method`: Metode pembayaran (string: cash, debit, credit, qris, dll)
- `cashier_id`: ID kasir (harus ada di tabel users)
- `cashier_name`: Nama kasir (string)
- `payment_amount`: Jumlah uang yang dibayarkan (integer)
- `order_items`: Array berisi item-item yang dibeli
  - `product_id`: ID produk
  - `quantity`: Jumlah produk
  - `total_price`: Total harga per item (harga satuan × quantity)

**Expected Response (Success - 201):**

```json
{
  "status": "success",
  "data": {
    "id": 1,
    "transaction_time": "2026-02-09 21:00:00",
    "total_price": 150000,
    "total_item": 3,
    "payment_method": "cash",
    "cashier_id": 1,
    "cashier_name": "Admin",
    "payment_amount": 200000,
    "created_at": "2026-02-09T14:00:00.000000Z",
    "updated_at": "2026-02-09T14:00:00.000000Z"
  }
}
```

**Possible Errors:**

1. **Validation Error (422):**

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "cashier_id": ["The selected cashier id is invalid."],
    "order_items": ["The order items field is required."]
  }
}
```

2. **Unauthorized (401):**

```json
{
  "message": "Unauthenticated."
}
```

> Solusi: Pastikan Anda sudah login dan menggunakan Bearer Token yang valid.

---

## 🧪 Contoh Test Cases

### ✅ Test Case 1: Order dengan 1 Item

```json
{
  "transaction_time": "2026-02-09 21:00:00",
  "total_price": 50000,
  "total_item": 1,
  "payment_method": "qris",
  "cashier_id": 1,
  "cashier_name": "Kasir 1",
  "payment_amount": 50000,
  "order_items": [
    {
      "product_id": 1,
      "quantity": 1,
      "total_price": 50000
    }
  ]
}
```

### ✅ Test Case 2: Order dengan Multiple Items

```json
{
  "transaction_time": "2026-02-09 21:15:00",
  "total_price": 350000,
  "total_item": 5,
  "payment_method": "debit",
  "cashier_id": 1,
  "cashier_name": "Kasir 1",
  "payment_amount": 350000,
  "order_items": [
    {
      "product_id": 1,
      "quantity": 2,
      "total_price": 100000
    },
    {
      "product_id": 2,
      "quantity": 1,
      "total_price": 150000
    },
    {
      "product_id": 3,
      "quantity": 2,
      "total_price": 100000
    }
  ]
}
```

### ✅ Test Case 3: Order dengan Pembayaran Lebih (Ada Kembalian)

```json
{
  "transaction_time": "2026-02-09 21:30:00",
  "total_price": 75000,
  "total_item": 3,
  "payment_method": "cash",
  "cashier_id": 1,
  "cashier_name": "Kasir 2",
  "payment_amount": 100000,
  "order_items": [
    {
      "product_id": 4,
      "quantity": 3,
      "total_price": 75000
    }
  ]
}
```

> Kembalian = payment_amount - total_price = 100000 - 75000 = **Rp 25.000**

---

## 🔴 Test Invalid Cases (Untuk Testing Error Handling)

### ❌ Test Case 4: Missing Required Field

```json
{
  "transaction_time": "2026-02-09 21:00:00",
  "total_price": 150000,
  "total_item": 3,
  "payment_method": "cash"
  // Missing: cashier_id, cashier_name, payment_amount, order_items
}
```

**Expected:** Error 422 - Validation Error

### ❌ Test Case 5: Invalid cashier_id

```json
{
  "transaction_time": "2026-02-09 21:00:00",
  "total_price": 150000,
  "total_item": 3,
  "payment_method": "cash",
  "cashier_id": 99999, // ID yang tidak ada di database
  "cashier_name": "Kasir Tidak Ada",
  "payment_amount": 200000,
  "order_items": [
    {
      "product_id": 1,
      "quantity": 2,
      "total_price": 100000
    }
  ]
}
```

**Expected:** Error 422 - The selected cashier id is invalid.

### ❌ Test Case 6: Empty Order Items

```json
{
  "transaction_time": "2026-02-09 21:00:00",
  "total_price": 150000,
  "total_item": 3,
  "payment_method": "cash",
  "cashier_id": 1,
  "cashier_name": "Kasir 1",
  "payment_amount": 200000,
  "order_items": [] // Array kosong
}
```

**Expected:** Error 422 - The order items field is required.

---

## 📊 Tips & Best Practices

### 1. Menggunakan Environment Variables di Postman

Untuk mempermudah testing, buat Environment Variables:

**Variables:**

- `base_url`: `http://localhost:8000/api`
- `token`: `{token_dari_login}`

**Cara menggunakan:**

```
URL: {{base_url}}/orders
Authorization: Bearer {{token}}
```

### 2. Membuat Collection di Postman

Organisir request Anda dengan membuat Collection:

```
📁 E-Ticketing API
  📁 Auth
    ├── 🔵 POST Login
    └── 🔵 POST Logout
  📁 Products
    ├── 🟢 GET All Products
    └── 🟢 GET Product by ID
  📁 Orders
    ├── 🟢 POST Create Order
    ├── 🟢 GET All Orders (jika sudah ada)
    └── 🟢 GET Order by ID (jika sudah ada)
```

### 3. Testing Flow yang Benar

1. ✅ Login terlebih dahulu
2. ✅ Simpan token yang didapat
3. ✅ Test endpoint /products untuk mendapatkan `product_id` yang valid
4. ✅ Test endpoint /orders dengan data yang valid
5. ✅ Cek database untuk memastikan data tersimpan dengan benar

### 4. Verifikasi di Database

Setelah membuat order, cek di database:

**Cek tabel orders:**

```sql
SELECT * FROM orders ORDER BY id DESC LIMIT 1;
```

**Cek tabel order_items:**

```sql
SELECT * FROM order_items WHERE order_id = 1;
```

---

## 🐛 Troubleshooting

### Problem 1: "Unauthenticated" Error

**Solusi:**

- Pastikan Anda sudah login
- Pastikan token sudah di-set di Authorization header
- Pastikan format: `Bearer {token}` (ada spasi setelah Bearer)

### Problem 2: "The selected cashier id is invalid"

**Solusi:**

- Cek apakah user dengan ID tersebut ada di database
- Gunakan ID yang valid (biasanya ID dari user yang login)

### Problem 3: "Order items array kosong tidak tersimpan"

**Catatan:** Kode di controller saat ini memiliki bug pada line 44 dan 49-54. Variable `$orderItem` di-overwrite dalam loop.

**Solusi Sementara:**
Pastikan selalu mengirim `order_items` array dengan minimal 1 item.

---

## 📸 Screenshot Postman Setup

### Setup Headers:

```
Content-Type: application/json
Accept: application/json
Authorization: Bearer 1|aBcDeFgHiJkLmNoPq...
```

### Setup Body (raw JSON):

1. Pilih **Body** tab
2. Pilih **raw**
3. Pilih **JSON** dari dropdown
4. Paste JSON data

---

## 🎯 Checklist Testing

### Pre-Testing

- [ ] Server Laravel sudah running (`php artisan serve`)
- [ ] Database sudah migrate
- [ ] Sudah ada minimal 1 user di database
- [ ] Sudah ada minimal 1 product di database

### Testing Create Order

- [ ] Login berhasil dan dapat token
- [ ] Create order dengan 1 item - SUCCESS
- [ ] Create order dengan multiple items - SUCCESS
- [ ] Create order tanpa token - ERROR 401
- [ ] Create order dengan cashier_id invalid - ERROR 422
- [ ] Create order tanpa order_items - ERROR 422
- [ ] Verifikasi data di database

---

## 📝 Catatan Tambahan

1. **OrderItems** otomatis dibuat saat membuat Order
2. Relationship: 1 Order memiliki banyak OrderItems (One-to-Many)
3. Payment amount bisa lebih besar dari total_price (ada kembalian)
4. Semua endpoint kecuali login memerlukan authentication

---

## 🔗 Related Documentation

- [Testing Product API](./POSTMAN_PRODUCT_TESTING.md) _(jika ada)_
- [API Authentication Guide](./API_AUTH_GUIDE.md) _(jika ada)_

---

**Last Updated:** 2026-02-09  
**Version:** 1.0
