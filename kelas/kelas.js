$(document).ready(function () {
    loadData();

    function loadData() {
        $.ajax({
            url: 'get_kelas.php',
            type: 'GET',
            success: function (response) {
                $('#kelasTable tbody').html(response);
            }
        });
    }

    $('#addKelasForm').on('submit', function (e) {
        e.preventDefault();
        let nama_kelas = $('#nama_kelas').val();
        let kapasitas = $('#kapasitas').val();

        if (!nama_kelas || !kapasitas) {
            showNotification('Semua field wajib diisi', 'danger');
            return;
        }

        $.ajax({
            url: 'add_kelas.php',
            type: 'POST',
            data: { nama_kelas, kapasitas },
            success: function (response) {
                let result = JSON.parse(response);
                if (result.status === 'error') {
                    showNotification(result.message, 'danger');
                } else {
                    $('#addKelasModal').modal('hide');
                    loadData();
                    showNotification(result.message, 'success');
                }
            }
        });
    });

    $(document).on('click', '.edit-btn', function () {
        let id = $(this).data('id');
        $.ajax({
            url: 'get_kelas_by_id.php',
            type: 'GET',
            data: { id },
            success: function (response) {
                let kelas = JSON.parse(response);
                $('#editIdKelas').val(kelas.id_kelas);
                $('#editNamaKelas').val(kelas.nama_kelas);
                $('#editKapasitas').val(kelas.kapasitas);
                $('#editKelasModal').modal('show');
            }
        });
    });

    $('#editKelasForm').on('submit', function (e) {
        e.preventDefault();
        let id_kelas = $('#editIdKelas').val();
        let nama_kelas = $('#editNamaKelas').val();
        let kapasitas = $('#editKapasitas').val();

        if (!nama_kelas || !kapasitas) {
            showNotification('Semua field wajib diisi', 'danger');
            return;
        }

        $.ajax({
            url: 'update_kelas.php',
            type: 'POST',
            data: { id_kelas, nama_kelas, kapasitas },
            success: function (response) {
                let result = JSON.parse(response);
                if (result.status === 'error') {
                    showNotification(result.message, 'danger');
                } else {
                    $('#editKelasModal').modal('hide');
                    loadData();
                    showNotification(result.message, 'success');
                }
            }
        });
    });

    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        $('#confirmDelete').data('id', id);
        $('#deleteKelasModal').modal('show');
    });

    $('#confirmDelete').on('click', function () {
        let id = $(this).data('id');
        $.ajax({
            url: 'delete_kelas.php',
            type: 'POST',
            data: { id },
            success: function () {
                $('#deleteKelasModal').modal('hide');
                loadData();
                showNotification('Kelas berhasil dihapus', 'success');
            }
        });
    });

    $('#searchBox').on('input', function () {
        let query = $(this).val().toLowerCase();
        let column = $('input[name="searchColumn"]:checked').val();
        $.ajax({
            url: 'search_kelas.php',
            type: 'GET',
            data: { query, column },
            success: function (response) {
                $('#kelasTable tbody').html(response);
            }
        });
    });

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
