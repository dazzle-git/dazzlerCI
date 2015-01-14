function getBaseUrl() {
    var l = window.location;
    var base_url = l.protocol + "//" + l.host + "/" + l.pathname.split('/')[1];
    return base_url;
}

function deleteMe(id) {
    var url = getBaseUrl() + "/media/delete/" + id
    var rurl = getBaseUrl() + "/user/profile";
    if (confirm("Do you want to delete?")) {
        $.ajax({
            url: url,
            type: 'POST',
            success: function(result) {
                alert("successfully deleted");
                //alert(result);
                location.href = rurl;
            }});
    }
}

function follow(id, typeCall) {
    var url = getBaseUrl() + "/ajax/follow/" + id
    var rurl = getBaseUrl() + "/user/profile";

    $.ajax({
        url: url,
        type: 'POST',
        success: function(result) {
            alert("successfully Follwoed user");
            //alert(result);
            if (typeCall == 1)
                $('#followwho').modal('show');
            //location.href = rurl;
        }});

}

function deleteFollower(id) {
    var url = getBaseUrl() + "/ajax/delete/" + id
    var rurl = getBaseUrl() + "/user/profile";
    if (confirm("Do you want to delete?")) {
        $.ajax({
            url: url,
            type: 'POST',
            success: function(result) {
                alert("successfully deleted");
                //alert(result);
                location.href = rurl;
            }});
    }
}

function deleteFollowing(id) {
    var url = getBaseUrl() + "/ajax/delete/" + id
    var rurl = getBaseUrl() + "/user/profile";
    if (confirm("Do you want to delete?")) {
        $.ajax({
            url: url,
            type: 'POST',
            success: function(result) {
                alert("successfully deleted");
                //alert(result);
                location.href = rurl;
            }});
    }
}

function loadComments() {
    //alert("LLLLLLLLLLLLLLLL");
    var url = getBaseUrl() + "/ajax/loadData";
    var cl = parseInt(document.getElementById('commentLimit').value);
    //alert(cl);
    var param = "medid=" + document.getElementById('medid').value + "&commStart=" + cl;

    $.ajax({
        url: url,
        type: 'POST',
        data: param,
        success: function(result) {
            //alert("KKKKKKKKKKKKKKKKK");
            cl = cl + 5;
            document.getElementById('commentLimit').value = cl;
            $('#commentList').html($('#commentList').html() + result);
            //alert(cl+"   "+document.getElementById('totalcnt').value);
            if (cl >= document.getElementById('totalcnt').value) {
                $('#viewmore').hide();
            }
        }});

}

function ajaxloadPage(num) {
    //alert("LLLLLLLLLLLLLLLL");
    var url = getBaseUrl() + "/ajax/loadpage/" + num;

    $.ajax({
        url: url,
        type: 'POST',
        success: function(result) {
            //alert(result);
            $('#content').html(result);
        }});

}

function dazzling(id) {
    var url = getBaseUrl() + "/ajax/dazzle/" + id;
    alert(url);
    $.ajax({
        url: url,
        type: 'POST',
        success: function(result) {
            //console.log(result);
            $('#dazzle').modal('show');
        }});
    //$('#dazzle').modal('show');
}

function shoutout(id) {
    var url = getBaseUrl() + "/ajax/shoutout/" + id;
    alert(url);
    $.ajax({
        url: url,
        type: 'POST',
        success: function(result) {
            //console.log(result);
            //$('#dazzle').modal('show');
            alert("shoutout for the user!!")
            location.href = location.href;
        }});
    //$('#dazzle').modal('show');
}

function cancelling(i) {
    switch (i) {
        case 1:
            $('#shoutout').modal('hide');
            break;
        case 2:
            $('#followwho').modal('hide');
            break;        
    }
    
}

