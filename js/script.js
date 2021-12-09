//* ini menggunakan jQuery
$(document).ready(() => {
  $("#search").hide();

  $("#keyword").on("keyup", () => {
    //menampilkan .loader ketika keyup
    $(".loader").show();
    //menyembunyikan #search .pagination dan .tbl ketika keyup
    $(".pagination").hide();
    $(".tbl").hide();
    //.get
    $.get(`ajax/staff.php?keyword=${$("#keyword").val()}`, (data) => {
      $(".loader").hide();
      $(".contain").html(data);
    });
  });
});

//! ini menggunakan ajax
// const keyword = document.querySelector("#keyword");
// const searchButton = document.querySelector("#search");
// const contain = document.querySelector(".contain");
// const pagination = document.querySelector(".pagination");
// const tabel = document.querySelector(".tbl");

// keyword.addEventListener("keyup", () => {
//   pagination.style.display = "none";
//   tabel.style.display = "none";

//   const xhr = new XMLHttpRequest();

//   //cek kesiapan ajax
//   xhr.onreadystatechange = () => {
//     if (xhr.readyState === 4 && xhr.status === 200) {
//       contain.innerHTML = xhr.responseText;
//     }
//   };

//   xhr.open("GET", `ajax/staff.php?keyword=${keyword.value}`, true);
//   xhr.send();
// });
