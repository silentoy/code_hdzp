<!-- 新建标签-->
<div class="view-content">
    <h4>
        定位标签
        <span class="new-creation edit">+ 新建标签</span>
    </h4>
    <!-- 内容 -->
    <div class="content">
        <?php if ($total) { ?>
        <ul id="tag_list" data-url="/index.php?c=admin&m=tagadd">
            <?php foreach ($list as $item) { ?>
            <li data-id="<?=$item['id'];?>">
                <span>X</span> <p><?=$item['name'];?></p>
            </li>
            <?php } ?>
        </ul>
        <?php } ?>
    </div>
</div>

<form action="/index.php?c=admin&m=tagadd" class="toast" style="display:none;" id="newsome">
    <h4>创建 <em class="close">X</em></h4>
    <div class="toast-content">
        <label for="">
            <input type="text" name="name" placeholder="请输入标签">
        </label>
        <div class="buttons">
            <button class="save">确定</button>
            <span class="cancel">取消</span>
        </div>
    </div>
    <input type="hidden" name="status" value="0">
</form>

<i class="layer" id="layer" style="display:none;"></i>
</body>
<script src="<?=BASEURL;?>/static/js/admin/tags.js"></script>
</html>