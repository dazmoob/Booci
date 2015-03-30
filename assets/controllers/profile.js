var uploadUrl = project + "profile/uploadPicture";

$("#profile-picture").fileinput({
    uploadUrl: uploadUrl,
    uploadAsync: true,
    maxFileCount: 5
});

$('#profile-picture').on('fileuploaderror', function(event, data, previewId, index) {
    var form = data.form, files = data.files, extra = data.extra, 
        response = data.response, reader = data.reader;
});

$('#profile-picture').on('fileuploaded', function(event, data, previewId, index) {
    var form = data.form, files = data.files, extra = data.extra, response = data.response, reader = data.reader;
    $('img.profile-picture').attr('src', project + response.file);
    $('button#cancel-upload').html('').html('<i class="fa fa-remove"></i>&nbsp; Close');
});

$(function(){
    $('#upload-picture').fadeOut('fast');
    $("#test-upload").fileinput({
        'showPreview' : false,
        'allowedFileExtensions' : ['jpg', 'png','gif'],
        'elErrorContainer': '#errorBlock'
    });
    $('#change-picture').click(function(){
        $('#show-picture').fadeOut('fast');
        $('#upload-picture').fadeIn('fast');
    });
    $('#cancel-upload').click(function(){
        $('#upload-picture').fadeOut('fast');
        $('#show-picture').fadeIn('fast');
    });
});