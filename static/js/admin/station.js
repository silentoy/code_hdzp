$(function() {
    // 标签
    $('.firms li').on('click', function() {
        $('.select-list span').html($(this).html());
        $('.select-list span').css('color', '#333')
        $('#form input[name="cid"]').val($(this).data('id'));
    });

    // 应聘方式
    $('.your-type').on('click', function() {
        $(this).addClass('selected').siblings().removeClass('selected');
        $('#form input[name="ask_type"]').val($(this).data('id'))
    });

    // 面议
    $('.changed').on('click', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            $('#form input[name="wage_type"]').val(0)
        } else {
            $(this).addClass('selected');
            $('#form input[name="wage_type"]').val(1)
        }
    })

    var form = $('#form');
    var verifys = $('.need-verify');

    form.on('submit', function(e) {
        e.preventDefault();
        if ($('#form input[name="wage_type"]').val() == 0) {
            // 需要写钱
            if ($('#form input[name="wage_min"]').val() == '' && $('#form input[name="wage_min"]').val() == '') {
                $('.wage').addClass('visible')
            } else {
                $('.wage').removeClass('visible')
            }
        } else {
            $('.wage').hasClass('visible') && $('.wage').removeClass('visible')
        }
        verifys.each(function(index, ele) {
            var errorText = $(ele).parent().next();
            if ($(ele).val().trim().length <= 0) {
                errorText.addClass('visible');
            } else {
                errorText.hasClass('visible') && errorText.removeClass('visible');
            }
        });
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
                        alert(res.msg)
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
})