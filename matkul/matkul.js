$(document).ready(function () {
    loadData();

    function loadData() {
        $.ajax({
            url: "get_matkul.php",
            type: "GET",
            success: function (response) {
                $("#matkulTable tbody").html(response);
            },
        });
    }

    $("#addMatkulForm").on("submit", function (e) {
        e.preventDefault();
        let nama_matkul = $("#nama_matkul").val().toUpperCase();
        let sks = $("#sks").val();

        if (!nama_matkul || !sks) {
            showNotification("Semua field wajib diisi", "danger");
            return;
        }

        $.ajax({
            url: "add_matkul.php",
            type: "POST",
            data: { nama_matkul, sks },
            success: function (response) {
                let result = JSON.parse(response);
                if (result.status === "error") {
                    showNotification(result.message, "danger");
                } else {
                    $("#addMatkulModal").modal("hide");
                    loadData();
                    showNotification(result.message, "success");
                }
            },
        });
    });

    $(document).on("click", ".edit-btn", function () {
        let id = $(this).data("id");
        $.ajax({
            url: "get_matkul_by_id.php",
            type: "GET",
            data: { id },
            success: function (response) {
                let matkul = JSON.parse(response);
                $("#editIdMatkul").val(matkul.id_matkul);
                $("#editNamaMatkul").val(matkul.nama_matkul);
                $("#editSks").val(matkul.sks);
                $("#editMatkulModal").modal("show");
            },
        });
    });

    $("#editMatkulForm").on("submit", function (e) {
        e.preventDefault();
        let id_matkul = $("#editIdMatkul").val();
        let nama_matkul = $("#editNamaMatkul").val().toUpperCase();
        let sks = $("#editSks").val();

        if (!nama_matkul || !sks) {
            showNotification("Semua field wajib diisi", "danger");
            return;
        }

        $.ajax({
            url: "update_matkul.php",
            type: "POST",
            data: { id_matkul, nama_matkul, sks },
            success: function (response) {
                let result = JSON.parse(response);
                if (result.status === "error") {
                    showNotification(result.message, "danger");
                } else {
                    $("#editMatkulModal").modal("hide");
                    loadData();
                    showNotification(result.message, "success");
                }
            },
        });
    });

    $(document).on("click", ".delete-btn", function () {
        let id = $(this).data("id");
        $("#confirmDelete").data("id", id);
        $("#deleteMatkulModal").modal("show");
    });

    $("#confirmDelete").on("click", function () {
        let id = $(this).data("id");
        $.ajax({
            url: "delete_matkul.php",
            type: "POST",
            data: { id },
            success: function () {
                $("#deleteMatkulModal").modal("hide");
                loadData();
                showNotification("Matkul berhasil dihapus", "success");
            },
        });
    });

    $("#searchBox").on("input", function () {
        let query = $(this).val().toLowerCase();
        let column = $('input[name="searchColumn"]:checked').val();
        $.ajax({
            url: "search_matkul.php",
            type: "GET",
            data: { query, column },
            success: function (response) {
                $("#matkulTable tbody").html(response);
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
