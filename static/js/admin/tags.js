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
    var tag_listCloses = $('#tag_list li span');

    tag_listCloses.on('click', function(e) {
        $.ajax({
            url: $('#tag_list').data('url'),
            data: {
                id: $(this).parent().data('id'),
                name: $(this).next().html(),
                status: 1,
            },
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

    // 编辑
    var form = $('#newsome');

    form.on('submit', function(e) {
        e.preventDefault();
        form.find('input[name="id"]').val(form.data('id'));
        if (form.find('input[name="name"]').val().length <= 0) {
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