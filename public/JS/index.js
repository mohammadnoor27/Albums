$(document).ready(function () {
  var table = $('#co').DataTable({
    destroy: true,
    "processing": false,
    "serverSide": false,
    "ajax": {
      "url": "/index/album",
      "type": "POST"
    },
    "columns": [
      { "data": "id" },
      { "data": "Artist_Name" },
      { "data": "Category_Name" },
      {
        data: "image",
        render: function (data, type, row) {
          return '<img src = "/image/' + data + '" style="height: 60px; width: 60px"></img>';
        }
      },
      {
        data: "id",
        render: function (data, type, row) {
          return '<button id="editbutton" data-id="' + data + '" data-toggle="modal" data-target="#formview">Edit</button> <a href="/index/delete?id=' + data + '&del=delete"><button id="Deletebutton">Delete</button></a>';
        }
      }
    ]
  });

  var modal = document.getElementById('fromview');
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

  // $('#co tbody').on('click', '#editbutton', function () {
  //   var jsData = table.row($(this).parents('tr')).data();
  //   console.log(jsData);
  //   $('.artist').val(jsData["Artist_Name"]);
  //   $('.category').val(jsData["Category_Name"]);
  //   $('#file').val(jsData["image"]);
  //   $('#id').val(jsData["id"]);
  // });
  $("body").on("click", "#Deletebutton", function () {
    var x = confirm("Are you sure you want to delete?");
    if (x)
      return true;
    else
      return false;
  });
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