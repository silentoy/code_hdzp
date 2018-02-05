$(function() {
    // 弹窗
    var $newBtn = $('.edit');
    var $layer = $('#layer');
    var $close = $('.close');
    var $cancel = $('.cancel');
    var form = $('#newsome');

    // 弹出弹窗
    $('.edit').on('click', function() {
        $('#newsome').show();
        $('#newsome').attr('data-id', $(this).data('id'))
        form.find('input[name="id"]').val($(this).data('id'));
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

    // 删除弹窗
    var $closetd = $('.closetd');
    $closetd.on('click', function() {
        $('.is-deleted').show();
        $layer.show();
        $('.is-deleted input[name="id"]').val($(this).data('id'));
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
    // 编辑

    // 状态
    $('#typelists li').on('click', function() {
        $(this).addClass('selected').siblings().removeClass('selected');
        form.find('input[name="status"]').val($(this).data('id'));
    });

    form.on('submit', function(e) {
        e.preventDefault();

        // 提交
        $.ajax({
            url: form.attr("action"),
            data: form.serializeArray(),
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
    })
})