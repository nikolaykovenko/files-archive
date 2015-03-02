function updateFilesList() {
    ajaxQuery({'mode': 'get-files-list'}, function (data) {
        $('[data-files-list]').html(data);
        
        var filesUploaded = parseInt($('[data-files-uploaded]').html()),
            disabled = filesUploaded >= maxFiles;
        
        $('#fine-uploader .qq-upload-button-selector').attr('disabled', disabled);
    });
}

$(function() {
    updateFilesList();
    
    $('[data-files-list]').on('click', '[data-delete-item]', function (e) {
        alert($(this).data('delete-item'));
    });


    $('#fine-uploader').fineUploader({
        debug: false,
        request: {
            endpoint: 'index.php?mode=file-upload'
        }
    });

    $('#fine-uploader').on('allComplete', function (event, id, xhr, isError) {
        updateFilesList();
    }).on('complete', function (event, id, name, responseJSON, xhr) {
        $(this).find('[qq-file-id="' + id + '"] .qq-upload-status-message-selector').html(responseJSON.message);
    });
});
