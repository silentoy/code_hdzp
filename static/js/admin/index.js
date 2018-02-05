$(function() {
    // 首页
    // 弹窗
    var $newBtn = $('.edit');
    var $layer = $('#layer');
    var $close = $('.close');
    var $cancel = $('.cancel');
    var form = $('#newsome');

    // 弹出弹窗
    $newBtn.on('click', function() {
        $('#newsome').show();
        $('#newsome .info p').html($(this).data('name'));
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

    // 删除
    var $closetd = $('.closetd');
    $closetd.on('click', function() {
        $('.is-deleted').show();
        $layer.show();
        $('.is-deleted input[name="id"]').val($(this).data('id'));
        console.log($(this).data('id'))
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

    // 编辑
    var form = $('#newsome');

    // 状态
    $('#editlists li').on('click', function() {
        $(this).addClass('selected').siblings().removeClass('selected');
        $('.error').hide();
    });

    // 设置时间
    $('#set_date input[name="vip_start"]').on('blur', blurInput);
    $('#set_date input[name="vip_end"]').on('blur', blurInput);

    function blurInput() {
        var ret = /^(\d{4})-(\d{2})-(\d{2})$/
        if (ret.test($(this).val())) {
            $('.error').hide();
        } else {
            $('.error').show();
        }
    }


    form.on('submit', function(e) {
        e.preventDefault();
        form.find('input[name="ulevel"]').val($('#editlists .selected').data('ulevel'));
        // if ($('#password').val().trim() == '') {
        //     alert('请输入密码！');
        //     return;
        // } else 
        if ($('.error').css('display') != 'none') {
            alert('请输入正确格式的时间');
            return;
        };

        // 提交
        $.ajax({
            url: form.attr("action"),
            data: form.serializeArray(),
            type: "POST",
            success: function(res) {
                console.log(res)
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