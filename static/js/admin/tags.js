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

    tag_listCloses.on('click', function() {
        $('.is-deleted').show();
        $('.is-deleted').attr('data-id', $(this).next().data('id'));
        $('.is-deleted').attr('data-name', $(this).next().html());
        $layer.show();
    });

    // 确定删除
    $('#delete_btn').on('click', closeAjax);
    // ajax
    function closeAjax() {
        $.ajax({
            url: $('#tag_list').data('url'),
            data: {
                id: $('.is-deleted').data('id'),
                name: $('.is-deleted').data('name'),
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
    }

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
    //拖拽完成后
    var tagsWrapper = $('#tag_list')
        // tagsWrapper.dragsort()
    $("#tag_list").dragsort({
        dragSelector: "p",
        dragBetween: true,
        dragEnd: saveOrder,
        placeHolderTemplate: "<li></li>",
        scrollSpeed: 5
    });
    //拖拽完成后
    function saveOrder() {
        // array(array('id'=>1, 'orderby'=>4), array('id'=>2, 'orderby'=>3))
        var _array = [];
        var _length = $("#tag_list p").length - 1;
        $("#tag_list p").each(function(i, ele) {
            var id = $(ele).data('id');
            _array.push({
                id: id,
                orderby: _length - i
            });
        });

        $.ajax({
            url: '/index.php?c=admin&m=tagorder',
            data: { order: _array },
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
    };

})