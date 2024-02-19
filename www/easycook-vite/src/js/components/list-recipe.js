document.addEventListener("DOMContentLoaded", () => {
  $("#form-menu-insert .select-category").on("change", function () {
    var value = $(this).val();
    $.ajax({
      url: "/admin/menus/add",
      type: "POST",
      data: "category=" + value,
      success: function (data) {
        $(".content-recipe").html(data);
        document.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
          checkbox.addEventListener("change", (event) => {
            if (event.target.checked) {
              console.log(event.target);
              if (event.target.checked) {
                console.log(event.target.closest("tr"));
              }
              //event.target.nextElementSibling.style.textDecoration = "line-through";
            }
          });
        });
      },
    });
  });
  $("#form-menu-edit .select-category").on("change", function () {
    var value = $(this).val();
    var id = $("#id_menu").val();
    $.ajax({
      url: "/admin/menus/edit",
      type: "POST",
      data: "id=" + id + "&category=" + value,
      success: function (data) {
        $(".content-recipe").html(data);
        console.log("bhdadzaazdz");
        console.log(document.querySelectorAll('input[type="checkbox"]'));
      },
    });
  });
});
