$(document).ready(function(){
   $("#btn-import").on('click',function(){
       showDialog();
   })
});

function showDialog(){
    $( "#import-dialog-confirm" ).dialog({
        resizable: false,
        height:240,
        width:400,
        modal: true,
        buttons: {
            "Import": function() {
                postImportPopup();
                $( this ).dialog( "close" );
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        }
    });
};

function postImportPopup(){
    $( "#form-import" ).submit();
}