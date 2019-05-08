function pld_setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function pld_getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

jQuery(document).ready(function ($) {
    var ajax_flag = 0;
    $('body').on('click', '.pld-like-dislike-trigger', function () {
        if (ajax_flag == 0) {
            var restriction = $(this).data('restriction');
            var post_id = $(this).data('post-id');
            var trigger_type = $(this).data('trigger-type');
            var selector = $(this);
            var pld_cookie = pld_getCookie('pld_' + post_id);
            var current_count = selector.closest('.pld-common-wrap').find('.pld-count-wrap').html();
            var new_count = parseInt(current_count) + 1;
            var ip_check = $(this).data('ip-check');
            var user_check = $(this).data('user-check');
            var like_dislike_flag = 1;
            if (restriction == 'cookie' && pld_cookie != '') {
                like_dislike_flag = 0;

            }
            if (restriction == 'ip' && ip_check == '1') {
                like_dislike_flag = 0;

            }
            if (restriction == 'user' && user_check == '1') {
                like_dislike_flag = 0;
            }
            if (like_dislike_flag == 1) {
                $.ajax({
                    type: 'post',
                    url: pld_js_object.admin_ajax_url,
                    data: {
                        post_id: post_id,
                        action: 'pld_post_ajax_action',
                        type: trigger_type,
                        _wpnonce: pld_js_object.admin_ajax_nonce
                    },
                    beforeSend: function (xhr) {
                        ajax_flag = 1;
                        selector.closest('.pld-common-wrap').find('.pld-count-wrap').html(new_count);
                    },
                    success: function (res) {
                        ajax_flag = 0;
                        res = $.parseJSON(res);
                        if (res.success) {
                            if (restriction == 'ip') {
                                selector.closest('.pld-like-dislike-wrap').find('.pld-like-dislike-trigger').data('ip-check', 1);
                            }
                            if (restriction == 'user') {
                                selector.closest('.pld-like-dislike-wrap').find('.pld-like-dislike-trigger').data('user-check', 1);
                            }
                            var cookie_name = 'pld_' + post_id;
                            pld_setCookie(cookie_name, 1, 365);
                            var latest_count = res.latest_count;
                            selector.closest('.pld-common-wrap').find('.pld-count-wrap').html(latest_count);
                        }
                    }

                });
            }
        }
    });


    $('.pld-like-dislike-wrap br,.pld-like-dislike-wrap p').remove();


});