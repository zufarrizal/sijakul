$(document).ready(function () {
    loadData();

    function loadData() {
        $.ajax({
            url: 'get_dosen.php',
            type: 'GET',
            success: function (response) {
                $('#dosenTable tbody').html(response);
            }
        });
    }

    $('#addDosenForm').on('submit', function (e) {
        e.preventDefault();
        let nama_dosen = $('#nama_dosen').val().toUpperCase();
        let nid = $('#nid').val();

        if (!nama_dosen || !nid) {
            showNotification('Semua field wajib diisi', 'danger');
            return;
        }

        $.ajax({
            url: 'add_dosen.php',
            type: 'POST',
            data: { nama_dosen, nid },
            success: function (response) {
                let result = JSON.parse(response);
                if (result.status === 'error') {
                    showNotification(result.message, 'danger');
                } else {
                    $('#addDosenModal').modal('hide');
                    loadData();
                    showNotification(result.message, 'success');
                }
            }
        });
    });

    $(document).on('click', '.edit-btn', function () {
        let id = $(this).data('id');
        $.ajax({
            url: 'get_dosen_by_id.php',
            type: 'GET',
            data: { id },
            success: function (response) {
                let dosen = JSON.parse(response);
                $('#editIdDosen').val(dosen.id_dosen);
                $('#editNamaDosen').val(dosen.nama_dosen);
                $('#editNid').val(dosen.nid); // pastikan ID input sesuai
                $('#editDosenModal').modal('show');
            }
        });
    });

    $('#editDosenForm').on('submit', function (e) {
        e.preventDefault();
        let id_dosen = $('#editIdDosen').val();
        let nama_dosen = $('#editNamaDosen').val().toUpperCase();
        let nid = $('#editNid').val();

        if (!nama_dosen || !nid) {
            showNotification('Semua field wajib diisi', 'danger');
            return;
        }

        $.ajax({
            url: 'update_dosen.php',
            type: 'POST',
            data: { id_dosen, nama_dosen, nid },
            success: function (response) {
                let result = JSON.parse(response);
                if (result.status === 'error') {
                    showNotification(result.message, 'danger');
                } else {
                    $('#editDosenModal').modal('hide');
                    loadData();
                    showNotification(result.message, 'success');
                }
            }
        });
    });

    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        $('#confirmDelete').data('id', id);
        $('#deleteDosenModal').modal('show');
    });

    $('#confirmDelete').on('click', function () {
        let id = $(this).data('id');
        $.ajax({
            url: 'delete_dosen.php',
            type: 'POST',
            data: { id },
            success: function () {
                $('#deleteDosenModal').modal('hide');
                loadData();
                showNotification('Dosen berhasil dihapus', 'success');
            }
        });
    });

    $('#searchBox').on('input', function () {
        let query = $(this).val().toLowerCase();
        let column = $('input[name="searchColumn"]:checked').val();
        $.ajax({
            url: 'search_dosen.php',
            type: 'GET',
            data: { query, column },
            success: function (response) {
                $('#dosenTable tbody').html(response);
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
