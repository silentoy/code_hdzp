$(function() {
    // 关闭
    var $layer = $('#layer');
    var $close = $('.close');
    $close.on('click', closeToast);

    function closeToast() {
        $('.big-img').hide();
        $layer.hide();
    }

    // 查看大图
    $('.up-success img').on('click', function() {
        $('.toast-content img').attr('src', $(this).attr('src'))
        $('.big-img').show();
        $layer.show();
    })

    var tagArr = [];
    var tagIdArr = [];
    // 标签
    $('.firms li').on('click', function() {
        // 删掉选择的
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            var mHtml = $(this).html();
            $(tagArr).each(function(i, ele) {
                if (mHtml == ele) {
                    tagArr.splice(i, 1);
                    tagIdArr.splice(i, 1);
                }
            });

        } else {
            $(this).addClass('selected')
            tagArr.push($(this).html());
            tagIdArr.push($(this).data('id'));
        }
        $('#form input[name="tagid"]').val(tagIdArr)
        $('.select-list span').html(tagArr.toString());
        $('.select-list span').css('color', '#333');
    });

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
            $.ajax({
                url: form.attr("action"),
                data: form.serializeArray(),
                type: 'POST',
                success: function(res) {
                    if (typeof(res) == 'string') {
                        var res = JSON.parse(res);
                    }
                    if (res.status == 'ok') {
                        alert('公司创建成功！！')
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
                } else {
                    alert(res.msg)
                }
            }
        })
    });

    // 实时输入
    $('.import textarea').on('input', function() {
        $(this).parent().find('var').html($(this).val().length + '/200')
    })
})