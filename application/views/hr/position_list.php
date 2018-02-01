
        <table class="position-list" id="positionList">
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
            <?php foreach ($list as $index => $item) { ?>
            <tr data-id="<?=$item['id']?>" data-index="<?=$index?>">
                <td><?=$item['name'];?></td>
                <td><?=date("Y-m-d", $item['addtime']);?></td>
                <td class="status"><?=positionStatus($item['status']);?></td>
                <td>
                    <a href="/index.php?c=hr&m=positionadd&id=<?=$item['id'];?>">修改</a>
                    <?php if ($item['status']>0) { ?>
                    <?php if ($item['status']!=1) { ?><span class="shelf" data-type="1">下架</span><?php } ?>
                    <?php if ($item['status']!=2) { ?><span class="shelf" data-type="2">上线</span><?php } ?>
                    <?php if ($item['status']!=-1) { ?><span class="shelf" data-type="-1">删除</span><?php } ?>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
            </tbody>
            <?php } ?>
        </table>
        <!-- 分页 -->
        <?=$pageStr;?>
        <!-- 操作弹层 -->
        <div class="mask" id="handleMask">
            <div class="title">
                <p>职位<em>删除</em></p>
                <span class="shutBox">关</span>
            </div>
            <div class="mask-content">
                <p class="delete-text">确定要<em>删除</em>吗？</p>
                <div class="footer">
                    <span class="determine" id="handleOk">确定</span>
                    <span class="cancel">取消</span>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="<?=BASEURL;?>/static/js/jquery.js"></script>
    <script src="<?=BASEURL;?>/static/js/home.js"></script>
</body>
</html>