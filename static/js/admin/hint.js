$(function() {
    // 编辑 系统通知

    // 删除
    $('.closetd').on('click', function() {
        var me = $(this).parent();
        // 填入
        $('.is-deleted input[name="id"]').val($(this).data('id'));
        $('.is-deleted input[name="subject"]').val(me.data('subject'));
        $('.is-deleted input[name="content"]').val(me.data('content'));
    });

    // 新建
    $('.new-creation').on('click', function() {
        $('#newsome').show();
        $('#layer').show();
    });


    // 编辑

    // 弹窗
    var $newBtn = $('.edit');
    var $layer = $('#layer');
    var $close = $('.close');
    var $cancel = $('.cancel');

    // 弹出弹窗
    $newBtn.on('click', function() {
        var me = $(this).parent();

        $('#newsome').show();
        $layer.show();
        $('#newsome input[name="id"]').val($(this).data('id'));
        $('#newsome input[name="subject"]').val(me.data('subject'));
        $('#newsome textarea[name="content"]').val(me.data('content'));
    })

    // 关闭弹窗
    $close.on('click', closeToast);
    $cancel.on('click', closeToast);

    function closeToast() {
        parentFind($(this), 'toast');
        parentFind.par.hide();
        $layer.hide();
    }

    // 删除
    var $closetd = $('.closetd');
    $closetd.on('click', function() {
        $('.is-deleted').show();
        $layer.show();
        $('.is-deleted').attr('data-id', $(this).data('id'));
    });

    // 删除
    var delete_btn = $('#delete_btn');
    var is_deleted = $('.is-deleted');

    delete_btn.on('click', function(e) {
        is_deleted.hide();
        $layer.hide();
        $.ajax({
            url: is_deleted.attr("action"),
            data: is_deleted.serializeArray(),
            type: "POST",
            success: function(res) {
                if (typeof(res) == 'string') {
                    var res = JSON.parse(res);
                }
                if (res.status == 'ok') {
                    // 刷新页面
                    location.href = location.href;
                } else {
                    alert(res.msg)
                }
            },
            error: function(res) {
                alert('网络不好，请稍后再试！')
            }
        })
    });


    // 父级
    function parentFind(p, calssName) {
        var par = p.parent();
        if (par.hasClass(calssName)) {
            parentFind.par = par
            return;
        } else {
            parentFind(par, calssName)
        }
    }


    var form = $('#newsome');

    form.on('submit', function(e) {
        e.preventDefault();
        form.find('input[name="id"]').val(form.data('id'));
        if (form.find('input[name="subject"]').val().length <= 0) {
            alert('请输入标题进行提交！');
            return;
        }
        if (form.find('textarea[name="content"]').val().length <= 0) {
            alert('请输入标题进行提交！');
            return;
        }

        // 提交
        $.ajax({
            url: form.attr("action"),
            data: form.serializeArray(),
            type: "POST",
            success: function(res) {
                if (typeof(res) == 'string') {
                    var res = JSON.parse(res);
                }
                if (res.status == 'ok') {
                    // 刷新页面
                    location.href = location.href;
                } else {
                    alert(res.msg)
                }
            },
            error: function(res) {
                alert('网络不好，请稍后再试！')
            }
        })
    })
})