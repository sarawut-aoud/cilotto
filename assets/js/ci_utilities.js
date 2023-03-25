$.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

function site_url(url) {
    if (!url) {
        url = '';
    }
    return siteURL + url;
}

function base_url(param) {
    if (!param) { param = ''; }
    return baseURL + param;
}


function loading_after(obj) {
    $(obj).after('<span id="loading_after">&nbsp;&nbsp;<i class="fa fa-refresh fa-spin"></i> Loading..</span>');
}

function loading_after_remove() {
    $('#loading_after').remove();
}

function loading_on(obj) {
    var attr = obj.attr('prev_html');
    if (typeof attr !== typeof undefined && attr !== false) {
        return false;
    } else {
        $(obj).addClass('disabled');
        obj.attr('prev_html', $(obj).html());
        obj.html('<i class="fa fa-refresh fa-spin"></i> Loading..');
        return true;
    }
}

function loading_on_remove(obj) {
    obj.removeClass('disabled');
    var prev_html = obj.attr('prev_html');
    obj.html(prev_html);
    obj.removeAttr('prev_html');
}


function ajaxErrorMessage(jqXHR, exception, elem) {
    var message;
    var statusErrorMap = {
        '400': "Server understood the request, but request content was invalid.",
        '401': "Unauthorized access.",
        '403': "Forbidden resource can't be accessed.",
        '500': "Internal server error.",
        '503': "Service unavailable."
    };
    if (jqXHR.status) {
        message = statusErrorMap[jqXHR.status];
        if (!message) {
            message = "Unknown Error. \n";
        }
    } else if (jqXHR.status === 0) {
        message = 'Requested JSON parse failed.';
    } else if (exception === 'parsererror') {
        message = 'Requested JSON parse failed.';
    } else if (exception === 'timeout') {
        message = 'Time out error.';
    } else if (exception === 'abort') {
        message = 'Ajax request aborted.';
    } else {
        message = 'Uncaught Error. \n'; // + jqXHR.responseText;
    }
    var responseTitle = $(jqXHR.responseText).filter('title').get(0);
    var detail = $(responseTitle).text();

    var other_detail = '';
    var obj = $(jqXHR.responseText).filter('div').get(0);
    other_detail = $(obj).find("p").eq(1).text();
    if (other_detail == '') {
        other_detail = '> ' + $(obj).find("p").text();
    }

    detail += ' - ' + other_detail;

    alert(message + "\n\n" + detail);
    if (elem) {
        elem.html(message + '(' + jqXHR.status + ')' + "\n\n" + jqXHR.responseText + "\n\n");
    }
}


function initializeDataTables(settings) {
    $('#' + settings.nTable.id + '_filter').parent().removeClass("col-sm-12").addClass("col-sm-6 d-flex align-items-center ms-auto w-auto");
    $('#' + settings.nTable.id + '_length').parent().removeClass("col-sm-12").addClass("col-sm-6 d-flex align-items-center w-auto").css("margin-bottom", "0px");
    $('#' + settings.nTable.id + '_length select').addClass("radius-15").css("margin", "7px 3px");
    $('#' + settings.nTable.id + '_filter input').css("width", "100px").addClass("radius-15");
    $(".dataTables_length").css("margin-bottom", "0px");
}
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })