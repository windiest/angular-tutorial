(function($) {
    $('body').append('<div class="rollto"><a href="javascript:;"></a></div>')

    // lazy avatar
    $('.content .avatar').lazyload({
        placeholder: jui.uri + '/images/avatar-default.png',
        event: 'scrollstop'
    });

    $('.sidebar .avatar').lazyload({
        placeholder: jui.uri + '/images/avatar-default.png',
        event: 'scrollstop'
    });

    $('.content .thumb').lazyload({
        placeholder: jui.uri + '/images/thumbnail.png',
        event: 'scrollstop'
    });

    $('.sidebar .thumb').lazyload({
        placeholder: jui.uri + '/images/thumbnail.png',
        event: 'scrollstop'
    });

    $('.content .wp-smiley').lazyload({
        event: 'scrollstop'
    });

    $('.sidebar .wp-smiley').lazyload({
        event: 'scrollstop'
    });


    var elments = {
        sidebar: $('.sidebar'),
        footer: $('.footer')
    }

    $('.feed-weixin').popover({
        placement: 'bottom',
        trigger: 'hover',
        container: 'body',
        html: true
    })


    if( elments.sidebar ){
    	var h1 = 20, h2 = 30
    	if( $('body').hasClass('ui-navtop') ){
    		h1 = 90, h2 = 100
    	}
        var rollFirst = elments.sidebar.find('.widget:eq('+(Number(jui.roll[0])-1)+')')
        var sheight = rollFirst.height()
        rollFirst.on('affix-top.bs.affix', function(){
            rollFirst.css({top: 0}) 
            sheight = rollFirst.height()

            for (var i = 1; i < jui.roll.length; i++) {
                var item = Number(jui.roll[i])-1
                var current = elments.sidebar.find('.widget:eq('+item+')')
                current.removeClass('affix').css({top: 0})
            };
        })

        rollFirst.on('affix.bs.affix', function(){
            rollFirst.css({top: h1}) 

            for (var i = 1; i < jui.roll.length; i++) {
                var item = Number(jui.roll[i])-1
                var current = elments.sidebar.find('.widget:eq('+item+')')
                current.addClass('affix').css({top: sheight+h2})
                sheight += current.height() + 20
            };
        })

        rollFirst.affix({
            offset: {
                top: elments.sidebar.height(),
                bottom: (elments.footer.height()||0) + 10
            }
        })
    }

    $('.excerpt header small').each(function() {
        $(this).tooltip({
            container: 'body',
            title: '此文有 ' + $(this).text() + '张 图片'
        })
    })

    $('.article-tags a, .post-tags a').each(function() {
        $(this).tooltip({
            container: 'body',
            placement: 'bottom',
            title: '查看关于 ' + $(this).text() + ' 的文章'
        })
    })

    $('.cat').each(function() {
        $(this).tooltip({
            container: 'body',
            title: '查看关于 ' + $(this).text() + ' 的文章'
        })
    })

    $('.widget_tags a').tooltip({
        container: 'body'
    })

    $('.readers a, .widget_comments a').tooltip({
        container: 'body',
        placement: 'top'
    })

    $('.article-meta li:eq(1) a').tooltip({
        container: 'body',
        placement: 'bottom'
    })
    $('.post-edit-link').tooltip({
        container: 'body',
        placement: 'right',
        title: '去后台编辑此文章'
    })


    if ($('.article-content').length) $('.article-content img').attr('data-tag', 'bdshare')

    window._bd_share_config = {
        common: {
            "bdText": "",
            "bdMini": "2",
            "bdMiniList": false,
            "bdPic": "",
            "bdStyle": "0"
        },
        share: [{
        	"bdSize": "24"
        }]
    }
    with(document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion=' + ~(-new Date() / 36e5)];


    $('.rollto a').on('click', function() {
        scrollTo()
    })

    $(window).scroll(function() {
        var scroller = $('.rollto');
        document.documentElement.scrollTop + document.body.scrollTop > 200 ? scroller.fadeIn() : scroller.fadeOut();
    })

    /* functions
     * ====================================================
     */
    function scrollTo(name, speed) {
        if (!speed) speed = 300
        if (!name) {
            $('html,body').animate({
                scrollTop: 0
            }, speed)
        } else {
            if ($(name).length > 0) {
                $('html,body').animate({
                    scrollTop: $(name).offset().top
                }, speed)
            }
        }
    }
    

    var islogin = false
    if( $('body').hasClass('logged-in') ) islogin = true

    /* event click
     * ====================================================
     */
    $(document).on('click', function(e) {
        e = e || window.event;
        var target = e.target || e.srcElement,
            _ta = $(target)

        if (_ta.hasClass('disabled')) return
        if (_ta.parent().attr('data-event')) _ta = $(_ta.parent()[0])
        if (_ta.parent().parent().attr('data-event')) _ta = $(_ta.parent().parent()[0])

        var type = _ta.attr('data-event')

        switch (type) {
            case 'like':
                var pid = _ta.attr('data-pid')
                if ( !pid || !/^\d{2,5}$/.test(pid) ) return;
                
                if( !islogin ){
                    var lslike = LS.get('_likes') || ''
                    if( lslike.indexOf(','+pid+',')!==-1 ) return alert('你已赞！')

                    if( !lslike ){
                        LS.set('_likes', ','+pid+',')
                    }else{
                        if( lslike.length >= 160 ){
                            lslike = lslike.substring(0,lslike.length-1)
                            lslike = lslike.substr(1).split(',')
                            lslike.splice(0,1)
                            lslike.push(pid)
                            lslike = lslike.join(',')
                            LS.set('_likes', ','+lslike+',')
                        }else{
                            LS.set('_likes', lslike+pid+',')
                        }
                    }
                }

                $.ajax({
                    url: jui.uri + '/actions/index.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        key: 'like',
                        pid: pid
                    },
                    success: function(data, textStatus, xhr) {
                        //called when successful
                        // console.log(data)
                        if (data.error) return false;
                        // console.log( data.response )
                        // if( data.type === 1 ){
                        _ta.toggleClass('actived')
                        _ta.find('span').html(data.response)
                        // }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        //called when there is an error
                        console.log(xhr)
                    }
                });

                break;
            case 'comment-user-change':
                $('#comment-author-info').slideDown(300)
                $('#comment-author-info input:first').focus()

                break;
            case 'login':
                $('#modal-login').modal('show')


                break;
        }
    })



    $('.commentlist .url').attr('target','_blank')
	
	/*$('#comment-author-info p input').focus(function() {
		$(this).parent('p').addClass('on')
	})
	$('#comment-author-info p input').blur(function() {
		$(this).parent('p').removeClass('on')
	})

	$('#comment').focus(function(){
		if( $('#author').val()=='' || $('#email').val()=='' ) $('.comt-comterinfo').slideDown(300)
	})*/

    var edit_mode = '0',
        txt1 = '<div class="comt-tip comt-loading">正在提交, 请稍候...</div>',
        txt2 = '<div class="comt-tip comt-error">#</div>',
        txt3 = '">',
        cancel_edit = '取消编辑',
        edit,
        num = 1,
        comm_array = [];
    comm_array.push('');

    $comments = $('#comments-title');
    $cancel = $('#cancel-comment-reply-link');
    cancel_text = $cancel.text();
    $submit = $('#commentform #submit');
    $submit.attr('disabled', false);
    $('.comt-tips').append(txt1 + txt2);
    $('.comt-loading').hide();
    $('.comt-error').hide();
    $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
    $('#commentform').submit(function() {
        $('.comt-loading').show();
        $submit.attr('disabled', true).fadeTo('slow', 0.5);
        if (edit) $('#comment').after('<input type="text" name="edit_id" id="edit_id" value="' + edit + '" style="display:none;" />');
        $.ajax({
            url: jui.uri+'/modules/comment.php',
            data: $(this).serialize(),
            type: $(this).attr('method'),
            error: function(request) {
                $('.comt-loading').hide();
                $('.comt-error').show().html(request.responseText);
                setTimeout(function() {
                        $submit.attr('disabled', false).fadeTo('slow', 1);
                        $('.comt-error').fadeOut()
                    },
                    3000)
            },
            success: function(data) {
                $('.comt-loading').hide();
                comm_array.push($('#comment').val());
                $('textarea').each(function() {
                    this.value = ''
                });
                var t = addComment,
                    cancel = t.I('cancel-comment-reply-link'),
                    temp = t.I('wp-temp-form-div'),
                    respond = t.I(t.respondId),
                    post = t.I('comment_post_ID').value,
                    parent = t.I('comment_parent').value;
                if (!edit && $comments.length) {
                    n = parseInt($comments.text().match(/\d+/));
                    $comments.text($comments.text().replace(n, n + 1))
                }
                new_htm = '" id="new_comm_' + num + '"></';
                new_htm = (parent == '0') ? ('\n<ol style="clear:both;" class="commentlist commentnew' + new_htm + 'ol>') : ('\n<ul class="children' + new_htm + 'ul>');
                ok_htm = '\n<span id="success_' + num + txt3;
                ok_htm += '</span><span></span>\n';

                if (parent == '0') {
                    if ($('#postcomments .commentlist').length) {
                        $('#postcomments .commentlist').before(new_htm);
                    } else {
                        $('#respond').after(new_htm);
                    }
                } else {
                    $('#respond').after(new_htm);
                }

                $('#comment-author-info').slideUp()

                // console.log( $('#new_comm_' + num) )
                $('#new_comm_' + num).hide().append(data);
                $('#new_comm_' + num + ' li').append(ok_htm);
                $('#new_comm_' + num).fadeIn(1000);
                $body.animate({
                        scrollTop: $('#new_comm_' + num).offset().top - 200
                    },
                    500);
                $('.comt-avatar .avatar').attr('src', $('.commentnew .avatar:last').attr('src'));
                countdown();
                num++;
                edit = '';
                $('*').remove('#edit_id');
                cancel.style.display = 'none';
                cancel.onclick = null;
                t.I('comment_parent').value = '0';
                if (temp && respond) {
                    temp.parentNode.insertBefore(respond, temp);
                    temp.parentNode.removeChild(temp)
                }
            }
        });
        return false
    });
    addComment = {
        moveForm: function(commId, parentId, respondId, postId, num) {
            var t = this,
                div, comm = t.I(commId),
                respond = t.I(respondId),
                cancel = t.I('cancel-comment-reply-link'),
                parent = t.I('comment_parent'),
                post = t.I('comment_post_ID');
            if (edit) exit_prev_edit();
            num ? (t.I('comment').value = comm_array[num], edit = t.I('new_comm_' + num).innerHTML.match(/(comment-)(\d+)/)[2], $new_sucs = $('#success_' + num), $new_sucs.hide(), $new_comm = $('#new_comm_' + num), $new_comm.hide(), $cancel.text(cancel_edit)) : $cancel.text(cancel_text);
            t.respondId = respondId;
            postId = postId || false;
            if (!t.I('wp-temp-form-div')) {
                div = document.createElement('div');
                div.id = 'wp-temp-form-div';
                div.style.display = 'none';
                respond.parentNode.insertBefore(div, respond)
            }!comm ? (temp = t.I('wp-temp-form-div'), t.I('comment_parent').value = '0', temp.parentNode.insertBefore(respond, temp), temp.parentNode.removeChild(temp)) : comm.parentNode.insertBefore(respond, comm.nextSibling);
            $body.animate({
                    scrollTop: $('#respond').offset().top - 180
                },
                400);
            if (post && postId) post.value = postId;
            parent.value = parentId;
            cancel.style.display = '';
            cancel.onclick = function() {
                if (edit) exit_prev_edit();
                var t = addComment,
                    temp = t.I('wp-temp-form-div'),
                    respond = t.I(t.respondId);
                t.I('comment_parent').value = '0';
                if (temp && respond) {
                    temp.parentNode.insertBefore(respond, temp);
                    temp.parentNode.removeChild(temp)
                }
                this.style.display = 'none';
                this.onclick = null;
                return false
            };
            try {
                t.I('comment').focus()
            } catch (e) {}
            return false
        },
        I: function(e) {
            return document.getElementById(e)
        }
    };

    function exit_prev_edit() {
        $new_comm.show();
        $new_sucs.show();
        $('textarea').each(function() {
            this.value = ''
        });
        edit = ''
    }
    var wait = 15,
        submit_val = $submit.val();

    function countdown() {
        if (wait > 0) {
            $submit.val(wait);
            wait--;
            setTimeout(countdown, 1000)
        } else {
            $submit.val(submit_val).attr('disabled', false).fadeTo('slow', 1);
            wait = 15
        }
    }



})(jQuery)