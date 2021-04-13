$(document).ready(function () {
  var table = $('#co').DataTable({
    destroy: true,
    "processing": false,
    "serverSide": false,
    "ajax": {
      "url": "/category/getcategory",
      "type": "POST"
    },
    "columns": [
      { "data": "ID" },
      { "data": "Category_Name" },
      {
        data: "ID",
        render: function (data, type, row) {
          return '<button id="editbutton" data-id="' + data + '" data-toggle="modal" data-target="#formview">Edit</button> <a href="/category/delete?id=' + data + '&del=delete"><button id="Deletebutton">Delete</button></a>';
        }
      }
    ]
  });
  $("body").on("click", "#Deletebutton", function () {
    var x = confirm("Are you sure you want to delete?");
    if (x)
      return true;
    else
      return false;
  });
  $('#co tbody').on('click', '#editbutton', function () {
    var jsData = table.row($(this).parents('tr')).data();
    $('#category').val(jsData["Category_Name"]);
    $('#id').val(jsData["ID"]);
  });

  var modal = document.getElementById('fromview');
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
  $("body").on("click", "#editbutton", function () {

    var AddButton = document.getElementById("Add");
    AddButton.style.display = 'none';
  });
  $("body").on("click", "#submitbutton", function () {

    var EditButton = document.getElementById("Edit");
    EditButton.style.display = 'none';
  });
  $('#formview').on('hidden.bs.modal', function () {
    location.reload();
  });

});