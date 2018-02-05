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
                <div class="some" data-subject="<?=$item['subject'];?>" data-content="<?=$item['content'];?>">
                    <em class="edit" data-id="<?=$item['id'];?>">编辑</em>|
                    <em class="closetd" data-id="<?=$item['id'];?>">删除</em>
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
    <?php if (isset($pageStr) && $pageStr) { ?>
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
<form action="/index.php?c=admin&m=noticeadd" class="toast editing" style="display:none;" id="newsome">
    <h4>编辑 <em class="close">X</em></h4>
    <div class="toast-content">
        <label for="">
            <span>标题</span>
            <input type="text" name="subject">
        </label>
        <label for="">
            <span>内容</span>
            <textarea name="content" cols="30" rows="10"></textarea>
        </label>
        <div class="buttons">
            <button class="save">确定</button>
            <span class="cancel">取消</span>
        </div>
    </div>
    <input type="hidden" name="id">
    <input type="hidden" name="status" value="0">
</form>

<form action="/index.php?c=admin&m=noticeadd" class="toast is-deleted" data-url="/index.php?c=admin&m=noticeadd" style="display:none;">
    <h4>删除 <em class="close">X</em></h4>
    <div class="toast-content">
        <p>确定要删除吗？</p>
        <div class="buttons">
            <span class="save" id="delete_btn">确定</span>
            <span class="cancel">取消</span>
        </div>
    </div>
    <input type="hidden" name="subject">
    <input type="hidden" name="id">
    <input type="hidden" name="content">
    <input type="hidden" name="status" value="1">
</form>
<i class="layer" id="layer" style="display:none;"></i>
</body>
<script src="<?=BASEURL;?>/static/js/admin/hint.js"></script>
</html>