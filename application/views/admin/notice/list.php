<!-- 新建通知 -->
<div class="view-content">
    <h4>
        系统通知
        <span class="new-creation">+ 新建通知</span>
    </h4>
    <!-- 内容 -->
    <div class="content">
        <?php if ($total) { ?>
        <ul>
            <?php foreach($list as $item) { ?>
            <li data-id="<?=$item['id'];?>">
                <span><?=date("Y-m-d", $item['addtime']);?></span>
                <a href="#" class="link"><?=$item['subject'];?></a>
                <input type="hidden" name="content" value="<?=$item['content'];?>" />
                <div class="some">
                    <em>编辑</em>|
                    <em>删除</em>
                </div>
            </li>
            <?php } ?>
        </ul>
        <?php } ?>
    </div>
</div>
<!-- 分页 -->
<div class="page">
    <em>共<?=$total;?>条</em>
    <?php if (isset($pageStr)) { ?>
    <div class="page-list">
        <?=$pageStr;?>
    </div>
    <form action="">
        <span>到第</span>
        <label>
            <input type="text">
        </label>
        <span>页</span>
        <button class="go-view">确定</button>
    </form>
    <?php } ?>
</div>
<!-- 弹窗 -->
<div class="toast is-deleted" style="display:none">
    <h4>删除 <em class="close">X</em></h4>
    <div class="toast-content">
        <p>确定要删除吗？</p>
        <div class="buttons">
            <span class="save">确定</span>
            <span class="cancel">取消</span>
        </div>
    </div>
</div>

<div class="toast edit" style="display: none;">
    <h4>删除 <em class="close">X</em></h4>
    <div class="toast-content">
        <label for="">
            <span>标题</span>
            <input type="text">
        </label>
        <label for="">
            <span>标题</span>
            <textarea name="" id="" cols="30" rows="10"></textarea>
        </label>
        <div class="buttons">
            <span class="save">确定</span>
            <span class="cancel">取消</span>
        </div>
    </div>
</div>

<i class="layer" style="display: none"></i>
</body>

</html>