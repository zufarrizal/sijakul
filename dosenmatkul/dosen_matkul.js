$(document).ready(function () {
    // Load initial data and options
    loadData();
    loadDosenOptions();
    loadMatkulOptions();

    function loadData() {
        $.ajax({
            url: 'get_dosen_matkul.php',
            type: 'GET',
            success: function (response) {
                $('#dosenMatkulTable tbody').html(response);
                // Add icons to edit and delete buttons
                $('#dosenMatkulTable .edit-btn').html('<i class="fas fa-edit"></i> Edit');
                $('#dosenMatkulTable .delete-btn').html('<i class="fas fa-trash-alt"></i> Hapus');
            },
            error: function () {
                showNotification('Gagal memuat data', 'danger');
            }
        });
    }

    function loadDosenOptions() {
        $.ajax({
            url: 'get_dosen.php',
            type: 'GET',
            success: function (response) {
                $('#id_dosen, #editIdDosen').html(response);
            },
            error: function () {
                showNotification('Gagal memuat data dosen', 'danger');
            }
        });
    }

    function loadMatkulOptions() {
        $.ajax({
            url: 'get_matkul.php',
            type: 'GET',
            success: function (response) {
                $('#id_matkul, #editIdMatkul').html(response);
            },
            error: function () {
                showNotification('Gagal memuat data matkul', 'danger');
            }
        });
    }

    $('#addDosenMatkulForm').on('submit', function (e) {
        e.preventDefault();
        let id_dosen = $('#id_dosen').val().toUpperCase();
        let id_matkul = $('#id_matkul').val().toUpperCase();

        if (!id_dosen || !id_matkul) {
            showNotification('Semua field wajib diisi', 'danger');
            return;
        }

        $.ajax({
            url: 'add_dosen_matkul.php',
            type: 'POST',
            data: { id_dosen, id_matkul },
            success: function (response) {
                if (response === 'duplicate') {
                    showNotification('Kombinasi ID Dosen dan ID Matkul sudah ada', 'danger');
                } else {
                    $('#addDosenMatkulModal').modal('hide');
                    loadData();
                    showNotification('Dosen Matkul berhasil ditambah', 'success');
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
            url: 'get_dosen_matkul_by_id.php',
            type: 'GET',
            data: { id },
            success: function (response) {
                let dosenMatkul = JSON.parse(response);
                $('#editIdDosenMatkul').val(dosenMatkul.id_dosenmatkul);
                $('#editIdDosen').val(dosenMatkul.id_dosen);
                $('#editIdMatkul').val(dosenMatkul.id_matkul);
                $('#editDosenMatkulModal').modal('show');
            },
            error: function () {
                showNotification('Gagal memuat data untuk diedit', 'danger');
            }
        });
    });

    $('#editDosenMatkulForm').on('submit', function (e) {
        e.preventDefault();
        let id_dosenmatkul = $('#editIdDosenMatkul').val();
        let id_dosen = $('#editIdDosen').val().toUpperCase();
        let id_matkul = $('#editIdMatkul').val().toUpperCase();

        if (!id_dosen || !id_matkul) {
            showNotification('Semua field wajib diisi', 'danger');
            return;
        }

        $.ajax({
            url: 'update_dosen_matkul.php',
            type: 'POST',
            data: { id_dosenmatkul, id_dosen, id_matkul },
            success: function (response) {
                if (response === 'duplicate') {
                    showNotification('Kombinasi ID Dosen dan ID Matkul sudah ada', 'danger');
                } else {
                    $('#editDosenMatkulModal').modal('hide');
                    loadData();
                    showNotification('Dosen Matkul berhasil diupdate', 'success');
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
        $('#deleteDosenMatkulModal').modal('show');
    });

    $('#confirmDelete').on('click', function () {
        let id = $(this).data('id');
        $.ajax({
            url: 'delete_dosen_matkul.php',
            type: 'POST',
            data: { id },
            success: function () {
                $('#deleteDosenMatkulModal').modal('hide');
                loadData();
                showNotification('Dosen Matkul berhasil dihapus', 'success');
            },
            error: function () {
                showNotification('Gagal menghapus data', 'danger');
            }
        });
    });

    $('#searchBox').on('input', function () {
        let query = $(this).val().toLowerCase();
        let column = $('input[name="searchColumn"]:checked').val();
        searchDosenMatkul(query, column);
    });

    function searchDosenMatkul(query, column) {
        $.ajax({
            url: 'search_dosen_matkul.php',
            type: 'GET',
            data: { query, column },
            success: function (response) {
                $('#dosenMatkulTable tbody').html(response);
                // Menambahkan ikon pada tombol edit dan hapus setelah pencarian
                $('#dosenMatkulTable .edit-btn').html('<i class="fas fa-edit"></i> Edit');
                $('#dosenMatkulTable .delete-btn').html('<i class="fas fa-trash-alt"></i> Hapus');
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
