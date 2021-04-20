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
          return '<button id="editbutton" data-id="' + data + '" >Edit</button> <button id="Deletebutton" data-id="' + data + '">Delete</button>';
        }
      }
    ]
  });
  $("body").on("click", "#Deletebutton", function () {
    var x = confirm("Are you sure you want to delete?");
    if (x) {
      var per_id = $(this).data('id');
      $.ajax({
        url: '/category/delete/id/' + per_id + '',
        type: 'POST',
        success: function () {
          window.location.href = "category";
        }
      });
    }
    else
      return false;
  });
  $("body").on('click', '#editbutton', function () {
    $("#formview")
      .find("input[type=text],img,select")
      .val('')
      .end();
    $('#formview').modal('show');
    var jsData = table.row($(this).parents('tr')).data();
    $('#category').val(jsData["Category_Name"]);
    $('#id').val(jsData["ID"]);
  });

  $('#addeditForm').validate({
    rules: {
      Categoryname: {
        required: true
      }
    },
    messages: {
      Categoryname: {
        required: 'Please enter Category.'
      }
    },
    submitHandler: function (form) {
      form.submit();
    }
  });
  $("body").on('click', '#AddButton', function () {
    $("#formview")
      .find("input[type=text],select")
      .val('')
      .end();
    $('#formview').modal('show');
  });

});