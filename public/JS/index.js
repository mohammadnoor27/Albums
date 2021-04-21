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
          return '<button name="editbutton" id="editbutton" data-id="' + data + '">Edit</button> <button id="Deletebutton" data-id="' + data + '">Delete</button>';
        }
      }
    ]
  });

  $("body").on('click', '#editbutton', function () {
    $("#formview")
      .find("input[type=text],img,select")
      .val('')
      .end();
    $('#formview').modal('show');
    var per_id = $(this).data('id');
    $.ajax({
      url: '/index/editalbum',
      type: 'GET',
      data: 'id=' + per_id,
      success: function (values) {
        $('#id').val(values[0].id);
        $('#img').attr('src', '/image/' + values[0].image)
        $('.artist').val(values[0].artist);
        $('.category').val(values[0].IDCategory);
        $('#image').val(values[0].image);
      }
    });
  });
  $("body").on('click', '#AddButton', function () {
    $("#formview")
      .find("input[type=text],input[type=hidden],select")
      .val('')
      .end()
      .find('img')
      .attr('src', '')
      .end();
    $('#formview').modal('show');
  });
  $("body").on("click", "#Deletebutton", function () {
    var x = confirm("Are you sure you want to delete?");
    if (x) {
      var per_id = $(this).data('id');
      $.ajax({
        url: '/index/delete/id/' + per_id + '',
        type: 'POST',
        success: function () {
          table.ajax.reload();
        }
      });
    }
    else
      return false;
  });
  $('#addeditForm').validate({
    rules: {
      Artist: {
        required: true
      },
      Category: {
        required: true
      }
    },
    messages: {
      Artist: {
        required: 'Please enter Artist.'
      },
      Category: {
        required: 'Please enter Category.'
      }
    },
    submitHandler: function (form) {
      form.submit();
    }
  });
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#img').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#file").change(function () {
    readURL(this);
  });
  $(".js-example-placeholder-single").select2({
    placeholder: "Select a Name",
    allowClear: true
});
$(".js-example-placeholder-multiple").select2({
  placeholder: "Select a Category"
});

});