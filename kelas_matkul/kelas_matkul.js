$(document).ready(function () {
    loadData();
    loadKelasOptions();
    loadMatkulOptions();

    function loadData() {
        $.ajax({
            url: "get_kelas_matkul.php",
            type: "GET",
            success: function (response) {
                $("#kelasMatkulTable tbody").html(response);
            },
        });
    }

    function loadKelasOptions() {
        $.ajax({
            url: "get_kelas.php",
            type: "GET",
            success: function (response) {
                $("#id_kelas, #editIdKelas").html(response);
            },
        });
    }

    function loadMatkulOptions() {
        $.ajax({
            url: "get_matkul.php",
            type: "GET",
            success: function (response) {
                $("#id_matkul, #editIdMatkul").html(response);
            },
        });
    }

    $("#addKelasMatkulForm").on("submit", function (e) {
        e.preventDefault();
        let id_kelas = $("#id_kelas").val();
        let id_matkul = $("#id_matkul").val();

        if (!id_kelas || !id_matkul) {
            showNotification("Semua field wajib diisi", "danger");
            return;
        }

        $.ajax({
            url: "add_kelas_matkul.php",
            type: "POST",
            data: { id_kelas, id_matkul },
            success: function (response) {
                if (response === "duplicate") {
                    showNotification(
                        "Kombinasi ID Kelas dan ID Matkul sudah ada",
                        "danger"
                    );
                } else {
                    $("#addKelasMatkulModal").modal("hide");
                    loadData();
                    showNotification(
                        "Kelas Matkul berhasil ditambah",
                        "success"
                    );
                }
            },
        });
    });

    $(document).on("click", ".edit-btn", function () {
        let id = $(this).data("id");
        $.ajax({
            url: "get_kelas_matkul_by_id.php",
            type: "GET",
            data: { id },
            success: function (response) {
                let kelasMatkul = JSON.parse(response);
                $("#editIdKelasMatkul").val(kelasMatkul.id_kelasmatkul);
                $("#editIdKelas").val(kelasMatkul.id_kelas);
                $("#editIdMatkul").val(kelasMatkul.id_matkul);
                $("#editKelasMatkulModal").modal("show");
            },
        });
    });

    $("#editKelasMatkulForm").on("submit", function (e) {
        e.preventDefault();
        let id_kelasmatkul = $("#editIdKelasMatkul").val();
        let id_kelas = $("#editIdKelas").val();
        let id_matkul = $("#editIdMatkul").val();

        if (!id_kelas || !id_matkul) {
            showNotification("Semua field wajib diisi", "danger");
            return;
        }

        $.ajax({
            url: "update_kelas_matkul.php",
            type: "POST",
            data: { id_kelasmatkul, id_kelas, id_matkul },
            success: function (response) {
                if (response === "duplicate") {
                    showNotification(
                        "Kombinasi ID Kelas dan ID Matkul sudah ada",
                        "danger"
                    );
                } else {
                    $("#editKelasMatkulModal").modal("hide");
                    loadData();
                    showNotification(
                        "Kelas Matkul berhasil diupdate",
                        "success"
                    );
                }
            },
        });
    });

    $(document).on("click", ".delete-btn", function () {
        let id = $(this).data("id");
        $("#confirmDelete").data("id", id);
        $("#deleteKelasMatkulModal").modal("show");
    });

    $("#confirmDelete").on("click", function () {
        let id = $(this).data("id");
        $.ajax({
            url: "delete_kelas_matkul.php",
            type: "POST",
            data: { id },
            success: function () {
                $("#deleteKelasMatkulModal").modal("hide");
                loadData();
                showNotification("Kelas Matkul berhasil dihapus", "success");
            },
        });
    });

    $("#searchBox").on("input", function () {
        let query = $(this).val().toLowerCase();
        let column = $('input[name="searchColumn"]:checked').val();
        $.ajax({
            url: "search_kelas_matkul.php",
            type: "GET",
            data: { query, column },
            success: function (response) {
                $("#kelasMatkulTable tbody").html(response);
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
