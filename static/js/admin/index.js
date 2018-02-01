$(function() {
    // 首页

    // 编辑
    var form = $('#newsome');

    // 状态
    $('#editlists li').on('click', function() {
        $(this).addClass('selected').siblings().removeClass('selected');
        $('.error').hide();
    });

    // 设置时间
    $('#set_date input').on('blur', function() {
        var ret = /^(\d{4})-(\d{2})-(\d{2})$/
        if (ret.test($(this).val())) {
            $('.error').hide();
        } else {
            $('.error').show();
        }
    });

    form.on('submit', function(e) {
        e.preventDefault();
        form.find('input[name="ulevel"]').val(parseInt($('.selected').index()) + 1);
        form.find('input[name="id"]').val(form.data('id'));

        if ($('#password').val().trim() == '') {
            alert('请输入密码！');
            return;
        } else if ($('.error').css('display') != 'none') {
            alert('请输入正确格式的时间');
            return;
        };

        // 提交
        $.ajax({
            url: form.action,
            data: form.data,
            type: "POST",
            success: function(res) {
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