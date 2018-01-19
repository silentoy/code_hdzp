
<!-- 管理 -->
<div class="view-content">
    <!-- 搜索 -->
    <div class="search">
        <form action="/index.php">
            <input type="hidden" name="c" value="admin" />
            <label for="">
                <input type="text" name="name" placeholder="可输入公司名称或职位名称" value="<?=addslashes(htmlspecialchars($_GET['name']));?>">
            </label>
            <button class="soso">搜索</button>
        </form>

        <span class="new-creation">+ 新建公司</span>
    </div>
    <!-- 内容 -->
    <div class="content">
        <table>
            <thead>
            <tr>


                <th>公司名称</th>

                <th>创建日期</th>

                <th>联系人</th>

                <th>电话</th>

                <th>职位</th>

                <th>访问量</th>

                <th>操作</th>

            </tr>
            </thead>
            <?php if ($total) { ?>
            <tbody>
            <tr>

            <?php foreach ($list as $item) { ?>
            <tr>

                <td><?=$item['name']?></td>

                <td><?=$item['regdate']?></td>

                <td><?=$item['master']?></td>

                <td><?=$item['tel'] ? $item['tel'] : $item['email'];?></td>

                <td><?=$item['positions']?></td>

                <td><?=$item['views']?></td>

                <td>
                    <a href="javascript:;">编辑</a>
                    <a href="javascript:;">删除</a>
                    <a href="javascript:;">待审核</a>
                </td>
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
    <?php if ($pageStr) { ?>
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
<div class="toast" style="display: none;">
    <h4>公司等级编辑 <em class="close">X</em></h4>
    <div class="toast-content">
        <div class="info">
            <p>北京中关村在线科技有限公司</p>
            <label for="">
                密码
                <input name="password" type="text">
            </label>
        </div>
        <div class="types">
            <ul>
                <li class="selected">
                    <i></i>
                    <span>待审核</span>
                </li>
                <li>
                    <i></i>
                    <span>普通用户</span>
                </li>
                <li>
                    <i></i>
                    <span>VIP用户</span>
                    <label for="">
                        <em>有效期</em>
                        <input type="date">
                        <em>至</em>
                        <input type="date">
                    </label>
                    <!-- error -->
                    <p class="error">请填写正确的有效期</p>
                    <p class="hiont">填写规范：2011-01-01</p>
                </li>
            </ul>
        </div>
        <div class="buttons">
            <span class="save">保存</span>
            <span class="cancel">取消</span>
        </div>
    </div>

</div>
<i class="layer" style="display: none;"></i>
</body>

</html>