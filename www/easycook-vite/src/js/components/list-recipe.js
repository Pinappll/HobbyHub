document.addEventListener("DOMContentLoaded", () => {
  $(".select-category").on("change", function () {
    var value = $(this).val();
    $.ajax({
      url: "/admin/menus/add",
      type: "POST",
      data: "category=" + value,
      success: function (data) {
        $(".content-recipe").html(data);
      },
    });
  });
});
