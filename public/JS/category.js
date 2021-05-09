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
        dataType: "json",
        success: function (msg) {
          alert(msg.Delete);
          table.ajax.reload();
        }
      });
    }
  });
  $("body").on('click', '#editbutton', function () {
    $("#formview")
      .find("input[type=text],img,select")
      .val('')
      .end();
    $('#formview').modal('show');
    var per_id = $(this).data('id');
    $.ajax({
      url: '/category/editcategory',
      type: 'GET',
      data: 'id=' + per_id,
      success: function (values) {
        $('#id').val(values.ID);
        $('#category').val(values.Category_Name);
      }
    });
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
      .find("input[type=text],input[type=hidden],select")
      .val('')
      .end();
    $('#formview').modal('show');
  });
  $("body").on("click", "#Save", function () {
    var category = $('#category').val();
    if (category != "") {
      $.ajax({
        url: '/category/submit',
        type: 'POST',
        data: $("#addeditForm").serialize(),
        dataType: "json",
        success: function (msgs) {
          $('#formview').modal('hide');
          alert(msgs.msg);
          table.ajax.reload();
        }
      });
    }
  });
});