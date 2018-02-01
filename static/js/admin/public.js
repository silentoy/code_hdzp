$(function() {
    // 弹窗
    var $newBtn = $('.edit');
    var $layer = $('#layer');
    var $close = $('.close');
    var $cancel = $('.cancel');

    // 弹出弹窗
    $newBtn.on('click', function() {
        $('#newsome').show();
        $('#newsome').attr('data-id', $(this).data('id'))
        $layer.show();
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
            url: is_deleted.data('url'),
            data: { id: $('.is-deleted').data('id') },
            type: "GET",
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

})