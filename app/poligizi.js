function reset_form() {
    load_patient();
    load_poli();
}

function load_poligizi() {
    $.post(
        "poligizi/load_poligizi",
        {},
        function (data) {
            console.log(data);
            $("#table").DataTable().clear().destroy();

            $("#table > tbody").html("");
            $.each(data.poligizi, function (idx, val) {
                html = "<tr>";
                html += "<td>" + (idx + 1) + "</td>";
                html += "<td>" + val["polyclinicName"] + "</td>";
                html += "<td>" + val["patientName"] + "</td>";
                html += "<td>" + val["queuesNo"] + "</td>";
                html += "<td>" + val["queuesRegTime"] + "</td>";
                html += '<td><span onclick="status_data(' + val["queuesId"] + ',' + val["queuesStatus"] + ')" class="badge ' +
                    (val["queuesStatus"] == "1" ? "bg-success" :
                        (val["queuesStatus"] == "2" ? "bg-primary" : "bg-secondary")) + '">' +
                    (val["queuesStatus"] == "1" ? "<i class='bi bi-clock'></i> Dilayani" :
                        (val["queuesStatus"] == "2" ? "<i class='bi bi-check-circle'></i> Selesai" : "<i class='bi bi-hourglass-split'></i> Menunggu")) +
                    "</span></td>";
                html += "</tr>";
                $("#table > tbody").append(html);
            });
            $("#table").DataTable({
                responsive: true,
                processing: true,
                pagingType: "first_last_numbers",
                order: [[0, "asc"]],
                dom:
                    "<'row'<'col-3'l><'col-9'f>>" +
                    "<'row dt-row'<'col-sm-12'tr>>" +
                    "<'row'<'col-4'i><'col-8'p>>",
                language: {
                    info: "Page _PAGE_ of _PAGES_",
                    lengthMenu: "_MENU_",
                    search: "",
                    searchPlaceholder: "Search..",
                },
            });
        },
        "json"
    );
}

let txpasienChoices;
function load_patient() {
    $.post("poligizi/load_patient", function (res) {
        console.log("Respon server:", res); // Debugging: Melihat data yang diterima dari server
        if (res && res.patient && Array.isArray(res.patient)) {
            const $txpasien = $("#txpasien");
            $txpasien.empty(); // Kosongkan dropdown

            // Tambahkan opsi default
            $txpasien.append('<option value="">Pilih Pasien</option>');

            // Tambahkan opsi dari data pasien
            $.each(res.patient, function (i, v) {
                $txpasien.append(
                    '<option value="' + v.patientId + '">' + v.patientName + "</option>"
                );
            });

            // Re-initialize Choices.js jika digunakan
            if (txpasienChoices) {
                txpasienChoices.destroy();
            }
            txpasienChoices = new Choices($txpasien[0]);
        } else {
            console.error("Respon server tidak valid:", res);
        }
    }, "json");
}

let txpoliChoices;
function load_poli() {
    $.post("poligizi/load_poli", function (res) {
        if (res && res.poli && Array.isArray(res.poli)) {
            const $txpoli = $("#txpoli");
            $txpoli.empty(); // Kosongkan dropdown

            // Tambahkan opsi default
            $txpoli.append('<option value="">Pilih Poliklinik</option>');

            // Tambahkan opsi dari data pasien
            $.each(res.poli, function (i, v) {
                $txpoli.append(
                    '<option value="' + v.polyclinicId + '">' + v.polyclinicName + "</option>"
                );
            });

            // Re-initialize Choices.js jika digunakan
            if (txpoliChoices) {
                txpoliChoices.destroy();
            }
            txpoliChoices = new Choices($txpoli[0]);
        } else {
            console.error("Respon server tidak valid:", res);
        }
    }, "json");
}

function save_data() {
    let poli = $("#txpoli").val();
    let nama = $("#txpasien").val();

    if (
        poli === "" ||
        nama === ""
    ) {
        Swal.fire({
            title: "Error!",
            text: "Lengkapi Form!",
            icon: "error",
            confirmButtonText: "OK",
        });
        return;
    }

    $.post(
        "poligizi/create",
        {
            poli: poli,
            nama: nama
        },
        function (data) {
            console.log(data.status);
            if (data.status === "error") {
                Swal.fire({
                    title: "Error!",
                    text: data.msg,
                    icon: "error",
                    confirmButtonText: "OK",
                });
            } else {
                Swal.fire({
                    title: "Success!",
                    text: data.msg,
                    icon: "success",
                    confirmButtonText: "OK",
                }).then(() => {
                    $("#loginModal").modal("hide");
                    load_poligizi();
                    load_patient();
                    load_poli();
                });
            }
        },
        "json"
    );
}

function status_data(id, status) {
    let actionText = "";
    let confirmButtonText = "";

    // Menentukan teks aksi dan tombol konfirmasi berdasarkan status
    if (status == 1) {
        actionText = "Selesaikan antrian?";
        confirmButtonText = "Ya, Selesaikan";
    } else if (status == 0) {
        actionText = "Pasien sedang dilayani?";
        confirmButtonText = "Ya, Dilayani";
    } else if (status == 2) {
        actionText = "Pasien harus menunggu kembali?";
        confirmButtonText = "Ya, Kembalikan";
    }

    // Konfirmasi dengan SweetAlert
    Swal.fire({
        title: "Konfirmasi",
        text: `${actionText}`,
        icon: "warning",
        showCancelButton: true,
        cancelButtonText: "Batal",
        confirmButtonText: confirmButtonText,
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(
                "poligizi/status_data",
                { id: id, status: status }, // Kirimkan status dalam request
                function (data) {
                    if (data.status === "success") {
                        Swal.fire({
                            title: "Sukses!",
                            text: data.msg,
                            icon: "success",
                            confirmButtonText: "OK",
                        }).then(() => {
                            load_poligizi(); // Memuat data setelah update
                            load_patient();
                            load_poli();
                        });
                    } else {
                        Swal.fire({
                            title: "Gagal!",
                            text: data.msg,
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                    }
                },
                "json"
            );
        }
    });
}

$(document).ready(function () {
    $("body").on("keyup", ".angka", function (e) {
        if (this.value != this.value.replace(/[^0-9\.]/g, "")) {
            this.value = this.value.replace(/[^0-9\.]/g, "");
        }
    });
    $(".tittle").html("Poliklinik Gizi - HealthCenter");
    $(".page-title").html("Poliklinik Gzi");
    $(".btn-add").click(function () {
        $(".btn-submit").show();
        $(".btn-editen").hide();
        reset_form();
    });
    $(".btn-closed").click(function () {
        reset_form();
    });
    load_poligizi();
    load_patient();
    load_poli();
});