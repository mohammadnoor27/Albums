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
        $('#id').val(values.id);
        $('#img').attr('src', '/image/' + values.image);
        $('.artist').val(values.artist).trigger('change');
        $('.category').val(values.IDCategory).trigger('change');
        $('#image').val(values.image);
      }
    });
  });
  $("body").on('click', '#AddButton', function () {
    $(".artist").val('').trigger('change');
    $(".category").val('').trigger('change');
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
    var msgDel = confirm("Are you sure you want to delete?");
    if (msgDel) {
      var per_id = $(this).data('id');
      $.ajax({
        url: '/index/delete/id/' + per_id + '',
        type: 'GET',
        dataType: "json",
        success: function (msg) {
          alert(msg.Delete);
          table.ajax.reload();
        }
      });
    }
  });
  function readURL(input) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#img').attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.getSource()); // convert to base64 string
    
  }
  
  $("#browse").change(function() {
    readURL(this);
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
  $(".js-example-placeholder-single").select2({
    placeholder: "Select a Name",
    allowClear: true
  });
  $(".js-example-placeholder-multiple").select2({
    placeholder: "Select a Category"
  });
  var uploader = new plupload.Uploader({
    runtimes: 'html5,flash,silverlight,html4',

    browse_button: 'browse',
    container: document.getElementById('container'),

    url: "/index/uploadalbum",

    filters: {
      max_file_size: '10mb',
      mime_types: [
        { title: "Image files", extensions: "jpg,gif,png,jpeg" },
        { title: "Zip files", extensions: "zip" }
      ]
    },


    flash_swf_url: '/var/www/zf-tutorial/public/JS/pluploadjs/Moxie.swf',


    silverlight_xap_url: '/var/www/zf-tutorial/public/JS/pluploadjs/Moxie.xap',


    init: {
      PostInit: function () {
        document.getElementById('filelist').innerHTML = '';

        document.getElementById('Save').onclick = function () {
          uploader.start();
          $('#formview').modal('hide');
          return false;
        };
      },

      FilesAdded: function (up, files) {

        plupload.each(files, function (file) {
          document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
          $('#image').val(file.name);
          readURL(file.getSource());
        });
      },

      UploadProgress: function (up, file) {
        document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";

      },

      Error: function (up, err) {
        document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
      }
    }
  });

  uploader.init();

  $("body").on("click", "#Save", function () {
    var Artist = $(".artist").val();
    var category = $('.category').val();
    var img = $('#image').val();
    if (Artist != "" && img != "" && category != "") {
      $.ajax({
        url: '/index/submit',
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