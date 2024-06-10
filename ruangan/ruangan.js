$(document).ready(function () {
    loadData();

    function loadData() {
        $.ajax({
            url: "get_ruangan.php",
            type: "GET",
            success: function (response) {
                $("#ruanganTable tbody").html(response);
            },
        });
    }

    $("#addRuanganForm").on("submit", function (e) {
        e.preventDefault();
        let nama_ruangan = $("#nama_ruangan").val().toUpperCase();
        let kapasitas = $("#kapasitas").val();

        if (!nama_ruangan || !kapasitas) {
            showNotification("Semua field wajib diisi", "danger");
            return;
        }

        $.ajax({
            url: "add_ruangan.php",
            type: "POST",
            data: { nama_ruangan, kapasitas },
            success: function (response) {
                let result = JSON.parse(response);
                if (result.status === "error") {
                    showNotification(result.message, "danger");
                } else {
                    $("#addRuanganModal").modal("hide");
                    loadData();
                    showNotification(result.message, "success");
                }
            },
        });
    });

    $(document).on("click", ".edit-btn", function () {
        let id = $(this).data("id");
        $.ajax({
            url: "get_ruangan_by_id.php",
            type: "GET",
            data: { id },
            success: function (response) {
                let ruangan = JSON.parse(response);
                $("#editIdRuangan").val(ruangan.id_ruangan);
                $("#editNamaRuangan").val(ruangan.nama_ruangan);
                $("#editKapasitas").val(ruangan.kapasitas);
                $("#editRuanganModal").modal("show");
            },
        });
    });

    $("#editRuanganForm").on("submit", function (e) {
        e.preventDefault();
        let id_ruangan = $("#editIdRuangan").val();
        let nama_ruangan = $("#editNamaRuangan").val().toUpperCase();
        let kapasitas = $("#editKapasitas").val();

        if (!nama_ruangan || !kapasitas) {
            showNotification("Semua field wajib diisi", "danger");
            return;
        }

        $.ajax({
            url: "update_ruangan.php",
            type: "POST",
            data: { id_ruangan, nama_ruangan, kapasitas },
            success: function (response) {
                let result = JSON.parse(response);
                if (result.status === "error") {
                    showNotification(result.message, "danger");
                } else {
                    $("#editRuanganModal").modal("hide");
                    loadData();
                    showNotification(result.message, "success");
                }
            },
        });
    });

    $(document).on("click", ".delete-btn", function () {
        let id = $(this).data("id");
        $("#confirmDelete").data("id", id);
        $("#deleteRuanganModal").modal("show");
    });

    $("#confirmDelete").on("click", function () {
        let id = $(this).data("id");
        $.ajax({
            url: "delete_ruangan.php",
            type: "POST",
            data: { id },
            success: function () {
                $("#deleteRuanganModal").modal("hide");
                loadData();
                showNotification("Ruangan berhasil dihapus", "success");
            },
        });
    });

    $("#searchBox").on("input", function () {
        let query = $(this).val().toLowerCase();
        let column = $('input[name="searchColumn"]:checked').val();
        $.ajax({
            url: "search_ruangan.php",
            type: "GET",
            data: { query, column },
            success: function (response) {
                $("#ruanganTable tbody").html(response);
            },
        });
    });

    function showNotification(message, type) {
        let notification = $("#notification");
        notification.removeClass();
        notification.addClass("alert alert-" + type + " floating-notification");
        notification.text(message);
        notification.fadeIn();
        setTimeout(function () {
            notification.fadeOut();
        }, 2000);
    }
});
