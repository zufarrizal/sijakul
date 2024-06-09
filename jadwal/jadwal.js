$(document).ready(function () {
    loadData();
    loadKelasOptions();
    loadRuanganOptions();

    // Load mata kuliah ketika kelas dipilih
    $('#id_kelas, #editIdKelas').on('change', function () {
        let id_kelas = $(this).val();
        let targetMatkul = $(this).attr('id') === 'id_kelas' ? '#id_matkul' : '#editIdMatkul';
        loadMatkulOptionsByKelas(id_kelas, targetMatkul);
    });

    // Load dosen ketika mata kuliah dipilih
    $('#id_matkul, #editIdMatkul').on('change', function () {
        let id_matkul = $(this).val();
        let targetDosen = $(this).attr('id') === 'id_matkul' ? '#id_dosen' : '#editIdDosen';
        loadDosenOptionsByMatkul(id_matkul, targetDosen);
    });

    function loadData() {
        $.ajax({
            url: 'get_jadwal.php',
            type: 'GET',
            success: function (response) {
                $('#jadwalTable tbody').html(response);
                // Add icons to edit and delete buttons
                $('#jadwalTable .edit-btn').html('<i class="fas fa-edit"></i> Edit');
                $('#jadwalTable .delete-btn').html('<i class="fas fa-trash-alt"></i> Hapus');
            },
            error: function () {
                showNotification('Gagal memuat data', 'danger');
            }
        });
    }

    function loadKelasOptions() {
        $.ajax({
            url: 'get_kelas.php',
            type: 'GET',
            success: function (response) {
                let options = "<option value=''>Pilih Kelas</option>" + response;
                $('#id_kelas, #editIdKelas').html(options);
            },
            error: function () {
                showNotification('Gagal memuat data kelas', 'danger');
            }
        });
    }

    function loadMatkulOptionsByKelas(id_kelas, targetMatkul, selectedMatkul = null) {
        $.ajax({
            url: 'get_matkul_by_kelas.php',
            type: 'GET',
            data: { id_kelas: id_kelas },
            success: function (response) {
                let options = "<option value=''>Pilih Mata Kuliah</option>" + response;
                $(targetMatkul).html(options);
                if (selectedMatkul) {
                    $(targetMatkul).val(selectedMatkul);
                    // Muat dosen berdasarkan mata kuliah yang dipilih
                    let targetDosen = targetMatkul === '#id_matkul' ? '#id_dosen' : '#editIdDosen';
                    loadDosenOptionsByMatkul(selectedMatkul, targetDosen);
                }
            },
            error: function () {
                showNotification('Gagal memuat data matkul', 'danger');
            }
        });
    }

    function loadDosenOptionsByMatkul(id_matkul, targetDosen, selectedDosen = null) {
        $.ajax({
            url: 'get_dosen_by_matkul.php',
            type: 'GET',
            data: { id_matkul: id_matkul },
            success: function (response) {
                let options = "<option value=''>Pilih Dosen</option>" + response;
                $(targetDosen).html(options);
                if (selectedDosen) {
                    $(targetDosen).val(selectedDosen);
                }
            },
            error: function () {
                showNotification('Gagal memuat data dosen', 'danger');
            }
        });
    }

    function loadRuanganOptions() {
        $.ajax({
            url: 'get_ruangan.php',
            type: 'GET',
            success: function (response) {
                let options = "<option value=''>Pilih Ruangan</option>" + response;
                $('#id_ruangan, #editIdRuangan').html(options);
            },
            error: function () {
                showNotification('Gagal memuat data ruangan', 'danger');
            }
        });
    }

    $('#addJadwalForm').on('submit', function (e) {
        e.preventDefault();
        let data = {
            hari: $('#hari').val(),
            jam_mulai: $('#jam_mulai').val(),
            jam_selesai: $('#jam_selesai').val(),
            id_kelas: $('#id_kelas').val(),
            id_matkul: $('#id_matkul').val(),
            id_dosen: $('#id_dosen').val(),
            id_ruangan: $('#id_ruangan').val()
        };

        if (!data.hari || !data.jam_mulai || !data.jam_selesai || !data.id_kelas || !data.id_matkul || !data.id_dosen || !data.id_ruangan) {
            showNotification('Semua field wajib diisi', 'danger');
            return;
        }

        $.ajax({
            url: 'add_jadwal.php',
            type: 'POST',
            data: data,
            success: function (response) {
                if (response === 'duplicate_dosen') {
                    showNotification('Dosen sudah ada di jam yang sama pada hari ini', 'danger');
                } else if (response === 'duplicate_ruangan') {
                    showNotification('Ruangan sudah digunakan di jam yang sama pada hari ini', 'danger');
                } else if (response === 'success') {
                    $('#addJadwalModal').modal('hide');
                    loadData();
                    showNotification('Jadwal berhasil ditambah', 'success');
                } else {
                    showNotification('Gagal menambah data', 'danger');
                }
            },
            error: function () {
                showNotification('Gagal menambah data', 'danger');
            }
        });
    });

    $(document).on('click', '.edit-btn', function () {
        let id = $(this).data('id');
        $.ajax({
            url: 'get_jadwal_by_id.php',
            type: 'GET',
            data: { id: id },
            success: function (response) {
                let jadwal = JSON.parse(response);
                $('#editIdJadwal').val(jadwal.id_jadwal);
                $('#editHari').val(jadwal.hari);
                $('#editJamMulai').val(jadwal.jam_mulai);
                $('#editJamSelesai').val(jadwal.jam_selesai);
                $('#editIdKelas').val(jadwal.id_kelas);
                loadMatkulOptionsByKelas(jadwal.id_kelas, '#editIdMatkul', jadwal.id_matkul);
                loadDosenOptionsByMatkul(jadwal.id_matkul, '#editIdDosen', jadwal.id_dosen);
                $('#editIdRuangan').val(jadwal.id_ruangan);
                $('#editJadwalModal').modal('show');
            },
            error: function () {
                showNotification('Gagal memuat data untuk diedit', 'danger');
            }
        });
    });

    $('#editJadwalForm').on('submit', function (e) {
        e.preventDefault();
        let data = {
            id_jadwal: $('#editIdJadwal').val(),
            hari: $('#editHari').val(),
            jam_mulai: $('#editJamMulai').val(),
            jam_selesai: $('#editJamSelesai').val(),
            id_kelas: $('#editIdKelas').val(),
            id_matkul: $('#editIdMatkul').val(),
            id_dosen: $('#editIdDosen').val(),
            id_ruangan: $('#editIdRuangan').val()
        };

        if (!data.hari || !data.jam_mulai || !data.jam_selesai || !data.id_kelas || !data.id_matkul || !data.id_dosen || !data.id_ruangan) {
            showNotification('Semua field wajib diisi', 'danger');
            return;
        }

        $.ajax({
            url: 'update_jadwal.php',
            type: 'POST',
            data: data,
            success: function (response) {
                if (response === 'duplicate_dosen') {
                    showNotification('Dosen sudah ada di jam yang sama pada hari ini', 'danger');
                } else if (response === 'duplicate_ruangan') {
                    showNotification('Ruangan sudah digunakan di jam yang sama pada hari ini', 'danger');
                } else if (response === 'success') {
                    $('#editJadwalModal').modal('hide');
                    loadData();
                    showNotification('Jadwal berhasil diupdate', 'success');
                } else {
                    showNotification('Gagal mengupdate data', 'danger');
                }
            },
            error: function () {
                showNotification('Gagal mengupdate data', 'danger');
            }
        });
    });

    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        $('#confirmDelete').data('id', id);
        $('#deleteJadwalModal').modal('show');
    });

    $('#confirmDelete').on('click', function () {
        let id = $(this).data('id');
        $.ajax({
            url: 'delete_jadwal.php',
            type: 'POST',
            data: { id: id },
            success: function () {
                $('#deleteJadwalModal').modal('hide');
                loadData();
                showNotification('Jadwal berhasil dihapus', 'success');
            },
            error: function () {
                showNotification('Gagal menghapus data', 'danger');
            }
        });
    });

    $('#searchBox').on('input', function () {
        let query = $(this).val().toLowerCase();
        let column = $('input[name="searchColumn"]:checked').val();
        searchJadwal(query, column);
    });

    function searchJadwal(query, column) {
        $.ajax({
            url: 'search_jadwal.php',
            type: 'GET',
            data: { query: query, column: column },
            success: function (response) {
                $('#jadwalTable tbody').html(response);
                // Menambahkan ikon pada tombol edit dan hapus setelah pencarian
                $('#jadwalTable .edit-btn').html('<i class="fas fa-edit"></i> Edit');
                $('#jadwalTable .delete-btn').html('<i class="fas fa-trash-alt"></i> Hapus');
            },
            error: function () {
                showNotification('Gagal mencari data', 'danger');
            }
        });
    }

    function showNotification(message, type) {
        let notification = $('#notification');
        notification.removeClass();
        notification.addClass('alert alert-' + type + ' floating-notification');
        notification.text(message);
        notification.fadeIn();
        setTimeout(function () {
            notification.fadeOut();
        }, 2000);
    }
});
