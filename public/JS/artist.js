$(document).ready(function () {
  var table = $('#co').DataTable({
    destroy: true,
    "processing": false,
    "serverSide": false,
    "ajax": {
      "url": "/artist/getartist",
      "type": "POST"
    },
    "columns": [
      { "data": "ID" },
      { "data": "Artist_Name" },
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
        url: '/artist/delete/id/' + per_id + '',
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
      .find("input[type=text],select")
      .val('')
      .end();
    $('#formview').modal('show');
    var per_id = $(this).data('id');
    $.ajax({
      url: '/artist/editartist',
      type: 'GET',
      data: 'id=' + per_id,
      success: function (values) {
        $('#id').val(values.ID);
        $('#artist').val(values.Artist_Name);
      }
    });
  });

  $('#addeditForm').validate({
    rules: {
      Artist: {
        required: true
      }
    },
    messages: {
      Artist: {
        required: 'Please enter Artist.'
      }
    },
    submitHandler: function (form) {
      form.submit();
      $('#formview').modal('hide');
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
    var artist = $('#artist').val();
    if(artist!=""){
    $.ajax({
      url: '/artist/submit',
      type: 'GET',
      data: $("#addeditForm").serialize(),
      dataType: "json",
      success: function (msgs) {
          alert(msgs.msg);
          table.ajax.reload();
      }
    });
  }
  });
});