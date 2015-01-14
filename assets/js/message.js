$(document).ready(function() {
    $('.composetxt').click(function() {
        //alert("LLLLL");
        //$('#nomessagetxt').hide();
        $('#userM').hide();
        $('#compose').show();
    });
    $('.subcontainer').perfectScrollbar();
});
$(function() {
    var url = getBaseUrl() + "/user/usercombo";
    $("#useremail").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: url + "/" + request.term,
                data: "{ 'name': '" + request.term + "' }",
                dataType: "json",
                type: "POST",
                contentType: "application/json; charset=utf-8",
                dataFilter: function(data) {
                    return data;
                },
                success: function(data) {
                    if (data != '') {
                        response($.map(data, function(item) {
                            return {
                                label: item.label,
                                value: item.value
                            };
                        }));
                    }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    // alert('@T("Alert.Symbol.Msg")');
                }
            });
        },
        select: function(event, ui) {
            console.log(ui.item.value);
            $('#useremail').val(ui.item.value);
            //$(':hidden[id=hdnmedicinenm]').val(ui.item.value.toString());

        },
        minLength: 1,
        autoFocus: true,
        html: true
    });

});

function loadData(msgId) {
    var url = getBaseUrl() + "/ajax/loadcontent/" + msgId;
    //alert(url);
    $.ajax({
        url: url,
        type: 'POST',
        success: function(result) {
            alert(result);
            $('#messageContent').html(result);
        }});

}

function setAction(i) {
    //alert(i);
    if (i == 2)
        act = getBaseUrl() + "/message/messageDelete";
    else
        act = getBaseUrl() + "/message/messageRead";

    $('#inboxFrm').attr('action', act);
    $('#inboxFrm').submit();
}

function selAction(opr) {
    var msgid = $('#msgTopId').val();
    var url = getBaseUrl() + "/message/operationDropdown/" + msgid;
    var param = "operation="+opr
    //alert(url);
    $.ajax({
        url: url,
        type: 'POST',
        success: function(result) {
            alert(result);
            //$('#messageContent').html(result);
            location.href = getBaseUrl() + "/message";
        }});

}


