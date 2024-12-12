function reset_form() {
  $("#txnama").val('').focus();
  $("#txgender").val('');
  $("#txgoldarah").val('');
  $("#txnik").val('');
  $("#txtelepon").val('');
  $("#txtempat").val('');
  $("#txtanggal").val('');
  $("#txalamat").val('');
}

function age(dateOfBirth) {
  if (!dateOfBirth) return "N/A"; // Jika tanggal lahir kosong, kembalikan "N/A"

  const birthDate = new Date(dateOfBirth); // Mengonversi tanggal lahir ke objek Date
  if (isNaN(birthDate)) return "N/A"; // Validasi tanggal

  const currentDate = new Date(); // Dapatkan tanggal saat ini

  // Hitung selisih waktu dalam milidetik
  const timeDifference = currentDate - birthDate;

  // Konversi milidetik ke tahun (365,25 hari untuk memperhitungkan tahun kabisat)
  const ageInYears = timeDifference / (1000 * 60 * 60 * 24 * 365.25);

  // Mengembalikan usia yang dibulatkan ke bawah
  return Math.floor(ageInYears);
}

function formatDateDDMMYYYY(dateString) {
  let date = new Date(dateString);
  if (isNaN(date)) return "Invalid Date";

  let year = date.getFullYear();
  let month = String(date.getMonth() + 1).padStart(2, "0");
  let day = String(date.getDate()).padStart(2, "0");

  return `${day}/${month}/${year}`;
}

function load_patient() {
  $.post(
    "patient/load_patient",
    {},
    function (data) {
      console.log(data);
      $("#table").DataTable().clear().destroy();

      $("#table > tbody").html("");
      $.each(data.patient, function (idx, val) {
        let patientAge = age(val["patientDateOfBirth"]); // Hitung usia dari tanggal asli

        let html = "<tr>";
        html += "<td>" + (idx + 1) + "</td>";
        html += "<td>" + val["patientName"] + "</td>";
        html += "<td>" + val["patientGender"] + "</td>";
        html += "<td>" + val["patientBloodType"] + "</td>";
        html += "<td>" + val["patientPlaceOfBirth"] + ", " + formatDateDDMMYYYY(val["patientDateOfBirth"]) + " (" + (patientAge !== null ? patientAge : "N/A") + ")" + "</td>";
        html +=
          '<td><button class="btn btn-info btn-sm btn-edit" onclick="detail(' +
          val["patientId"] +
          ')"><i class="bi bi-search"></i></i></i></button> ' + ' <button class="btn btn-danger btn-sm btn-edit" onclick="delete_data(' +
          val["patientId"] +
          ')"><i class="bi bi-trash"></i></i></i></button> </td>';
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

function save_data() {
  let nama = $("#txnama").val();
  let gender = $("#txgender").val();
  let goldarah = $("#txgoldarah").val();
  let nik = $("#txnik").val();
  let telepon = $("#txtelepon").val();
  let tempat = $("#txtempat").val();
  let tanggal = $("#txtanggal").val();
  let alamat = $("#txalamat").val();

  if (
    nama === "" ||
    gender === null ||
    nik === "" ||
    telepon === "" ||
    tempat === "" ||
    tanggal === "" ||
    alamat === ""
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
    "patient/create",
    {
      nama: nama,
      gender: gender,
      goldarah: goldarah,
      nik: nik,
      telepon: telepon,
      tempat: tempat,
      tanggal: tanggal,
      alamat: alamat,
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
          load_patient();
        });
      }
    },
    "json"
  );
}

function detail(id) {
  $.post(
    "patient/detail",
    { id: id },
    function (data) {
      if (data.status === "ok") {
        $("#txnama").val(data.data.patientName);
        $("#txgender").val(data.data.patientGender);
        $("#txgoldarah").val(data.data.patientBloodType);
        $("#txnik").val(data.data.patientNik);
        $("#txtelepon").val(data.data.patientPhoneNumber);
        $("#txtempat").val(data.data.patientPlaceOfBirth);
        $("#txtanggal").val(data.data.patientDateOfBirth);
        $("#txalamat").val(data.data.patientAddress);
        $("#loginModal").data("id", id);
        $("#loginModal").modal("show");
        $(".btn-submit").hide();
        $(".btn-editen").show();
        $("#loginModal input").prop("readonly", true);
        $("#loginModal select").prop("disabled", true);
      } else {
        alert(data.msg);
      }
    },
    "json"
  );
}

function delete_data(id) {
  Swal.fire({
    title: "Apakah kamu ingin menghapus data?",
    showDenyButton: true,
    showCancelButton: false,
    denyButtonText: "Tidak",
    confirmButtonText: "Ya",
    customClass: {
      actions: "my-actions",
      confirmButton: "order-2",
      denyButton: "order-3",
    },
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(
        "patient/delete_table",
        { id: id },
        function (data) {
          if (data.status === "success") {
            Swal.fire({
              title: "Succes!",
              text: data.msg,
              icon: "success",
              confirmButtonText: "OK",
            }).then(() => {
              load_patient();
            });
          } else {
            Swal.fire({
              title: "Error!",
              text: data.msg,
              icon: "error",
              confirmButtonText: "OK",
            });
          }
        },
        "json"
      );
    } else if (result.isDenied) {
      Swal.fire("Data tidak dihapus!", "", "info");
    }
  });
}

$(document).ready(function () {
  $("body").on("keyup", ".angka", function (e) {
    if (this.value != this.value.replace(/[^0-9\.]/g, "")) {
      this.value = this.value.replace(/[^0-9\.]/g, "");
    }
  });
  $(".tittle").html("Pasien - HealthCenter");
  $(".page-title").html("Pasien");
  $(".btn-add").click(function () {
    $("#loginModal input").prop("readonly", false);
    $("#loginModal select").prop("disabled", false);
    $(".btn-submit").show();
    $(".btn-editen").hide();
    reset_form();
  });
  $(".btn-closed").click(function () {
    reset_form();
  });
  load_patient();
});
