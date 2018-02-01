$(function() {
    var form = $('#form');
    var verifys = $('.need-verify');

    form.on('submit', function(e) {
        e.preventDefault();
        // 验证必填
        verifys.each(function(index, ele) {
            var errorText = $(ele).parent().next();
            if ($(ele).val().trim().length <= 0) {
                errorText.addClass('visible');
            } else {
                console.log(1, $(ele).data('pattern'))
                if ($(ele).data('pattern')) {
                    var reg = new RegExp($(ele).data('pattern'));
                    // 手机邮箱单独处理
                    if (!reg.test($(ele).val())) {
                        errorText.addClass('visible');
                        console.log(1)
                    } else {
                        console.log(2)
                        errorText.hasClass('visible') && errorText.removeClass('visible');
                    }
                } else {
                    errorText.hasClass('visible') && errorText.removeClass('visible');
                }

            }
        });
        // 没有错误的时候。。。
        if (!$('.need-verify').hasClass('visible')) {
            return;
            $.ajax({
                url: form.action,
                data: form.data,
                type: 'POST',
                success: function(res) {
                    if (res.status == 'ok') {

                    } else {
                        alert(res.msg)
                    }
                },
                error: function(err) {
                    alert('网络请求失败！')
                }
            })
        }
    });

    // 图片上传
    var upImg = $('.upimg');
    var upSuccess = $('.up-success')
    upImg && upImg.bind('change', function(ele) {
        var file = this.files[0]
        var reader = new FileReader();

        var formData = new FormData();

        formData.append("userfile", file);

        // 图片上传
        $.ajax({
            url: '/index.php?c=upload&m=onupload',
            type: 'post',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: formData,
            success: function(res) {
                if (res.status === 'ok') {
                    // 赋值图片路径 并且创建预览
                    if (upSuccess.hide()) {
                        upSuccess.show();
                        $('.fileup').hide();
                    }
                    $('.new-form input[name="license"]').val(res.info.url);
                    upSuccess.find('figure img').attr('src', res.info.url);
                }
            }
        })
    });

    // 实时输入
    $('.import textarea').on('input', function() {
        $(this).parent().find('var').html($(this).val().length + '/200')
    })
})