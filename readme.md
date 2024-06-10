Berikut adalah README untuk proyek SIJAKUL yang diperbarui tanpa menggunakan Markdown.

---

**SIJAKUL - Sistem Informasi Jadwal Kuliah**

SIJAKUL adalah aplikasi manajemen jadwal kuliah yang dirancang untuk mempermudah administrasi dan pengelolaan jadwal perkuliahan di lingkungan akademis. Aplikasi ini mendukung pengelolaan data dosen, kelas, mata kuliah, ruangan, serta jadwal kuliah dengan integrasi hubungan antara dosen-mata kuliah dan kelas-mata kuliah. SIJAKUL juga dilengkapi dengan fitur-fitur canggih yang memungkinkan otomatisasi penjadwalan kuliah dan notifikasi jadwal.

### Fitur-fitur:

1. **Dosen**:
   - Pengelolaan data dosen yang meliputi penambahan, pengeditan, dan penghapusan data dosen.
   - Integrasi dengan data pribadi dosen seperti email dan nomor kontak.

2. **Kelas**:
   - Pengelolaan data kelas yang meliputi penambahan, pengeditan, dan penghapusan data kelas.
   - Menyediakan informasi tentang kapasitas kelas dan tingkat.

3. **Mata Kuliah (Matkul)**:
   - Pengelolaan data mata kuliah yang meliputi penambahan, pengeditan, dan penghapusan data mata kuliah.
   - Informasi tentang jumlah SKS dan prasyarat mata kuliah.

4. **Ruangan**:
   - Pengelolaan data ruangan yang meliputi penambahan, pengeditan, dan penghapusan data ruangan.
   - Data kapasitas ruangan dan fasilitas yang tersedia.

5. **Jadwal**:
   - Pengelolaan data jadwal kuliah yang meliputi penambahan, pengeditan, dan penghapusan jadwal kuliah.
   - Menyediakan kalender visual untuk memudahkan pengelolaan jadwal.

6. **Hubungan Dosen-Mata Kuliah**:
   - Pengelolaan hubungan antara dosen dengan mata kuliah yang diampu.
   - Menyimpan data riwayat pengajaran dosen.

7. **Hubungan Kelas-Mata Kuliah**:
   - Pengelolaan hubungan antara kelas dengan mata kuliah yang diikuti.
   - Informasi kehadiran mahasiswa dalam kelas.

8. **Auto Generate Jadwal**:
   - Fitur otomatis untuk menghasilkan jadwal kuliah berdasarkan preferensi dan aturan yang telah ditentukan.
   - Mengoptimalkan penggunaan ruangan dan waktu pengajaran dosen.
   - Menghindari konflik jadwal dengan mempertimbangkan semua keterbatasan yang ada.

9. **Notifikasi Jadwal**:
   - Pengingat otomatis untuk dosen dan mahasiswa terkait jadwal kuliah.
   - Notifikasi melalui email dan aplikasi.

### Instalasi:

Untuk menjalankan aplikasi SIJAKUL di lingkungan lokal Anda, ikuti langkah-langkah berikut:

1. **Clone repositori ini**:
   Jalankan perintah berikut di terminal atau Command Prompt:
   ```
   git clone https://github.com/zufarrizal/sijakul.git
   ```

2. **Masuk ke direktori proyek**:
   Pindah ke direktori proyek dengan perintah:
   ```
   cd sijakul
   ```

3. **Instal dependensi**:
   Instal semua dependensi yang diperlukan dengan perintah:
   ```
   npm install
   ```

4. **Jalankan aplikasi**:
   Mulai aplikasi dengan perintah:
   ```
   npm start
   ```

### Kontribusi & Fork:

Kami sangat menghargai kontribusi dari komunitas untuk memperbaiki dan mengembangkan SIJAKUL. Untuk berkontribusi, Anda dapat melakukan fork repositori ini dan membuat pull request dengan perubahan yang Anda lakukan.

Langkah-langkah kontribusi:

1. **Fork repositori ini**.
2. **Buat branch baru** untuk fitur atau perbaikan bug dengan perintah:
   ```
   git checkout -b fitur-atau-perbaikan
   ```

3. **Lakukan commit pada perubahan Anda**:
   Setelah melakukan perubahan, simpan dengan perintah:
   ```
   git commit -m "Deskripsi perubahan"
   ```

4. **Push ke branch**:
   Kirim perubahan ke repositori dengan perintah:
   ```
   git push origin fitur-atau-perbaikan
   ```

5. **Buat pull request** di GitHub.

### Lisensi:

Proyek ini dilisensikan di bawah MIT License. Lihat file LICENSE untuk informasi lebih lanjut.

### Status Pengembangan:

SIJAKUL masih dalam tahap pengembangan. Kami terus berupaya memperbaiki dan meningkatkan fitur-fitur yang ada. Versi saat ini mungkin masih mengandung bug dan kekurangan.

### Terima Kasih:

Terima kasih telah menggunakan SIJAKUL! Kami berharap aplikasi ini dapat membantu Anda dalam mengelola jadwal perkuliahan dengan lebih mudah dan efisien. Jangan ragu untuk memberikan masukan dan saran agar SIJAKUL dapat menjadi lebih baik. Selamat menggunakan!