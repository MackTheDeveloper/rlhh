 $(document).on('dblclick', '.grid-view tbody tr', function (e) {
    if (typeof ($("#edit-url").val()) == "undefined")
        {
            return false;
        }
        var updateURL = $("#edit-url").val();
        var recId = $(this).attr('data-key');
        var redirect = updateURL + '?id=' + recId;
        //var redirect = updateURL + '/' + recId;
        location.href = redirect;
});
$(document).on('click', '#modalbuttonviewdetail', function(){
 $('#modalViewDetail').modal('show').find('#modalContentViewDetail').load($(this).attr('value'));
});