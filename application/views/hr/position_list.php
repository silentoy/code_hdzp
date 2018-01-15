
        <table class="position-list">
            <thead>
            <tr>
                <td>职位名称</td>
                <td>发布日期</td>
                <td>状态</td>
                <td>操作</td>
            </tr>
            </thead>
            <?php if ($total) { ?>
            <tbody>
            <?php foreach ($list as $item) { ?>
            <tr data-id="<?=$item['id'];?>">
                <td><?=$item['name'];?></td>
                <td><?=date("Y-m-d", $item['addtime']);?></td>
                <td><?=positionStatus($item['status']);?></td>
                <td>
                    <span class="modify" data-url="/index.php?c=hr&m=positionsAdd&id=<?=$item['id'];?>">修改</span>
                    <?php if ($item['status']>0) { ?>
                    <?php if ($item['status']!=1) { ?><span class="shelf" data-id="1">下架</span><?php } ?>
                    <?php if ($item['status']!=2) { ?><span class="shelf" data-id="2">上线</span><?php } ?>
                    <?php if ($item['status']!=-1) { ?><span class="delete" data-id="-1">删除</span><?php } ?>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
            </tbody>
            <?php } ?>
        </table>
        <!-- 分页 -->
        <?=$pageStr;?>
        <!-- 弹层 -->
        <div class="mask">
            <div class="title">
                <p>职位删除</p>
                <span>关</span>
            </div>
            <p class="delete-text">确定要删除吗？</p>
            <div class="footer">
                <span class="determine">确定</span>
                <span class="cancel">取消</span>
            </div>
        </div>
    </div>
</div>
</body>
</html>