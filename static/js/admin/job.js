$(function() {
    // 首页

    // 编辑
    var form = $('#newsome');

    // 状态
    $('#typelists li').on('click', function() {
        $(this).addClass('selected').siblings().removeClass('selected');
    });

    form.on('submit', function(e) {
        e.preventDefault();
        form.find('input[name="status"]').val($('.selected').index());
        form.find('input[name="id"]').val(form.data('id'));
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