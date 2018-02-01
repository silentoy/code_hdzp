<!-- 管理 -->
<div class="view-content">
    <!-- 搜索 -->
    <div class="search">
        <form action="/index.php">
            <input type="hidden" name="c" value="admin" />
            <input type="hidden" name="m" value="positionlist" />
            <label for="">
                <input type="text" name="name" placeholder="可输入公司名称或职位名称" value="<?=isset($_GET['name'])?addslashes(htmlspecialchars($_GET['name'])):'';?>">
            </label>
            <button class="soso">搜索</button>
        </form>

        <span class="new-creation">+ 新建职位</span>
    </div>
    <!-- 内容 -->
    <div class="content">
        <table>
            <thead>
            <tr>


                <th>岗位名称</th>

                <th>发布日期</th>

                <th>状态</th>

                <th>访问量</th>

                <th>操作</th>

                <th>公司名称</th>

            </tr>
            </thead>
            <?php if ($total) { ?>
            <tbody>
            <?php foreach ($list as $item) { ?>
            <tr data-id="<?=$item['id'];?>">
                <td><?=$item['name'];?></td>
                <td><?=date("Y-m-d", $item['addtime']);?></td>
                <td data-id="<?=$item['status'];?>"> <span class="waiting"><?=positionStatus($item['status']);?></span> </td>
                <td><?=$item['views']?></td>
                <td>
                    <a href="javascript:;" class="edit">编辑</a>
                    <a href="javascript:;" class="closetd" data-id="<?=$item['status'];?>">删除</a>
                </td>
                <td><?=$item['company_name'];?></td>
            </tr>
            <?php } ?>
            </tbody>
            <?php } ?>
        </table>
    </div>

    <!-- 分页 -->

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
<form action="/index.php?c=admin&m=onadd" class="toast" style="display:none;" id="newsome">
    <h4>职位状态编辑 <em class="close">X</em></h4>
    <div class="toast-content" id="typelists">
        <ul>
            <li class="selected">
                <i></i>
                <span>待审核</span>
            </li>
            <li>
                <i></i>
                <span>下架</span>
            </li>
            <li>
                <i></i>
                <span>上线</span>
            </li>
            <li>
                <i></i>
                <span>精选</span>
            </li>
        </ul>
        <div class="buttons">
            <button class="save">保存</button>
            <span class="cancel">取消</span>
        </div>
    </div>
    <input type="hidden" name="status" value="" />
    <input type="hidden" name="id" value="" />
</form>

<div class="toast is-deleted" data-url="" style="display:none;">
    <h4>删除 <em class="close">X</em></h4>
    <div class="toast-content">
        <p>确定要删除吗？</p>
        <div class="buttons">
            <span class="save" id="delete_btn">确定</span>
            <span class="cancel">取消</span>
        </div>
    </div>
</div>
<i class="layer" id="layer" style="display:none;"></i>
</body>
<script src="<?=BASEURL;?>/static/js/admin/public.js"></script>
<script src="<?=BASEURL;?>/static/js/admin/job.js"></script>
</html>