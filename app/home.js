function load_patient() {
    $.post('home/load_patient', function (res) {
        $.each(res.patient, function (i, v) {
            $("#pasien").append('<h4>' + v.jumlah + '</h4>')
        }
        )
    }, 'json');
}

function load_poli() {
    $.post('home/load_poli', function (res) {
        $.each(res.poli, function (i, v) {
            $("#poli").append('<h4>' + v.jumlah + '</h4>')
        }
        )
    }, 'json');
}

function load_umumqueue() {
    $.post('home/load_umumqueue', function (res) {
        $.each(res.umum, function (i, v) {
            $("#poliumum").append('<h4>' + v.jumlah + '</h4>')
        }
        )
    }, 'json');
}

function load_gigiqueue() {
    $.post('home/load_gigiqueue', function (res) {
        $.each(res.gigi, function (i, v) {
            $("#poligigi").append('<h4>' + v.jumlah + '</h4>')
        }
        )
    }, 'json');
}

function load_giziqueue() {
    $.post('home/load_giziqueue', function (res) {
        $.each(res.gizi, function (i, v) {
            $("#poligizi").append('<h4>' + v.jumlah + '</h4>')
        }
        )
    }, 'json');
}

function load_queues() {
    $.post(
        "home/load_queues",
        {},
        function (data) {
            console.log(data);
            $("#table").DataTable().clear().destroy();

            $("#table > tbody").html("");
            $.each(data.queues, function (idx, val) {
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

$(document).ready(function () {
    load_patient();
    load_poli();
    load_queues();
    load_umumqueue();
    load_gigiqueue();
    load_giziqueue();
});
