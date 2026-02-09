# Panduan Testing API E-Ticketing dengan Postman

Dokumen ini berisi langkah-langkah untuk menjalankan tes endpoint API `Product` dan `Category` menggunakan Postman.

## Prasyarat: Login & Autentikasi

Semua endpoint di bawah ini dilindungi oleh middleware `auth:sanctum`. Anda harus login terlebih dahulu untuk mendapatkan token akses.

### 1. Login (Mendapatkan Token)

- **Method**: `POST`
- **URL**: `http://127.0.0.1:8000/api/login`
- **Body** (JSON):
    ```json
    {
        "email": "admin@example.com",
        "password": "password"
    }
    ```
- **Response**: Salin **token** dari response JSON (bagian `data.token`).

### 2. Setup Authorization (Untuk Request Selanjutnya)

Setiap kali Anda mengakses endpoint di bawah ini, sertakan token tersebut:

- **Tab Authorization**: Pilih Type **Bearer Token**.
- **Token**: Paste token yang Anda salin.
- **Headers**: Tambahkan `Accept: application/json`.

---

## A. Tes Endpoint Product

Endpoint untuk manajemen produk.

### 1. Melihat Semua Product (List)

- **Method**: `GET`
- **URL**: `http://127.0.0.1:8000/api/products`
- **Filter (Opsional)**: `?category_id=1`

### 2. Menambah Product Baru (Create)

Karena endpoint ini menerima upload file gambar, gunakan **Form-data**.

- **Method**: `POST`
- **URL**: `http://127.0.0.1:8000/api/products`
- **Body**: Pilih `form-data`.
    - `name` (Text): Contoh "Tiket Konser VIP"
    - `description` (Text): Contoh "Tiket barisan depan"
    - `price` (Text): 1500000
    - `stock` (Text): 100
    - `category_id` (Text): 1 (Pastikan ID kategori ada)
    - `image` (File): Upload gambar.

### 3. Menghapus Product (Delete)

- **Method**: `DELETE`
- **URL**: `http://127.0.0.1:8000/api/products/{id}`

> **Catatan**: Endpoint `Update` (PUT) dan `Show` (GET by ID) pada `ProductController` saat ini belum diimplementasikan.

---

## B. Tes Endpoint Category

Endpoint untuk manajemen kategori.

### 1. Melihat Semua Category (List)

- **Method**: `GET`
- **URL**: `http://127.0.0.1:8000/api/categories`

### 2. Menambah Category Baru (Create)

Saat ini controller kategori belum menangani upload file secara khusus, jadi `image` bisa diisi string URL atau teks.

- **Method**: `POST`
- **URL**: `http://127.0.0.1:8000/api/categories`
- **Body** (JSON):
    ```json
    {
        "name": "Musik",
        "description": "Kategori konser musik",
        "image": "https://placehold.co/600x400/png"
    }
    ```

### 3. Update Category (Update)

- **Method**: `PUT`
- **URL**: `http://127.0.0.1:8000/api/categories/{id}`
- **Body** (JSON):
    ```json
    {
        "name": "Musik & Festival"
    }
    ```

### 4. Detail Category (Show)

- **Method**: `GET`
- **URL**: `http://127.0.0.1:8000/api/categories/{id}`

### 5. Menghapus Category (Delete)

- **Method**: `DELETE`
- **URL**: `http://127.0.0.1:8000/api/categories/{id}`
