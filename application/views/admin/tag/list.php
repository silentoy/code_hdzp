<!-- 新建标签-->
<div class="view-content">
    <h4>
        定位标签
        <span class="new-creation">+ 新建标签</span>
    </h4>
    <!-- 内容 -->
    <div class="content">
        <?php if ($total) { ?>
        <ul>
            <?php foreach ($list as $item) { ?>
            <li data-id="<?=$item['id'];?>">
                <span>X</span> <?=$item['name'];?>
            </li>
            <?php } ?>
        </ul>
        <?php } ?>
    </div>
</div>

<div class="toast">
    <h4>删除 <em class="close">X</em></h4>
    <div class="toast-content">
        <label for="">
            <input type="text" placeholder="请输入标签">
        </label>
        <div class="buttons">
            <span class="save">确定</span>
            <span class="cancel">取消</span>
        </div>
    </div>
</div>

<i class="layer"></i>
</body>

</html>