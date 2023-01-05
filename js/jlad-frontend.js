function jlad_setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function jlad_getCookie(cname) {
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
    $('body').on('click', '.jlad-like-dislike-trigger', function () {
        if (ajax_flag == 0) {
            var restriction = $(this).data('restriction');
            var data_id = $(this).data('id');
            var trigger_type = $(this).data('trigger-type');
            var selector = $(this);
            var current_count = selector.closest('.jlad-common-wrap').find('.jlad-count-wrap').html();
            var already_liked = selector.data('already-liked');
            var jlad_action = 'jlad_post_ajax_action';

            // Check to see if any of our parents have the comment-content class, which means
            // we've clicked on a comment like/dislike and not a post like/dislike.
            if (selector.parents('.comment-content').length) {
                jlad_action = 'jlad_comment_ajax_action';
            }

            if (already_liked == 0) {
                $.ajax({
                    type: 'post',
                    url: jlad_js_object.admin_ajax_url,
                    data: {
                        data_id: data_id,
                        action: jlad_action,
                        type: trigger_type,
                        _wpnonce: jlad_js_object.admin_ajax_nonce
                    },
                    beforeSend: function (xhr) {
                        ajax_flag = 1;
                    },
                    error: function (jqXHR, exception) {
                        console.log(jqXHR);
                    },
                    success: function (res) {
                        ajax_flag = 0;
                        res = $.parseJSON(res);
                        if (res.success) {
                            var latest_count = res.latest_count;
                            selector.closest('.jlad-common-wrap').find('.jlad-count-wrap').html(latest_count);
                            if (restriction != 'no') {
                                selector.closest('.jlad-like-dislike-wrap').find('a').data('already-liked', 1);
                            }
                        }
                    }

                });
            }
        }
    });


    $('.jlad-like-dislike-wrap br,.jlad-like-dislike-wrap p').remove();


});