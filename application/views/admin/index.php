
<!-- 管理 -->
<div class="view-content">
    <!-- 搜索 -->
    <div class="search">
        <form action="/index.php">
            <input type="hidden" name="c" value="admin" />
            <label for="">
                <input type="text" name="name" placeholder="可输入公司名称或职位名称" value="<?=isset($_GET['name'])?addslashes(htmlspecialchars($_GET['name'])):'';?>">
            </label>
            <button class="soso">搜索</button>
        </form>

        <span class="new-creation" onclick="location.href='/index.php?c=admin&m=companyadd'">+ 新建公司</span>
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
                <input type="hidden" name="name" value="<?=$item['name']?>" />
                <input type="hidden" name="ulevel" value="<?=$item['ulevel']?>" />
                <?php if ($item['ulevel']==2) { ?>
                <input type="hidden" name="vip_start" value="<?=date("Y-m-d", $item['vip_start']);?>" />
                <input type="hidden" name="vip_end" value="<?=date("Y-m-d", $item['vip_end']);?>" />
                <?php } ?>

                <td><?=$item['name']?></td>

                <td><?=$item['regdate']?></td>

                <td><?=$item['master']?></td>

                <td><?=$item['tel'] ? $item['tel'] : $item['email'];?></td>

                <td><?=$item['positions']?></td>

                <td><?=$item['views']?></td>

                <td class="some-thing">
                <a href="/index.php?c=admin&m=companyadd&id=<?=$item['id'];?>">编辑</a>
                <a href="javascript:;" class="closetd" data-id="<?=$item['id'];?>">删除</a>
                    <?php if ($item['ulevel']==3) { ?><a href="javascript:;" class="edit" data-name="<?=$item['name']?>" data-id="<?=$item['id'];?>">待审核</a><?php } ?>
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
<form class="toast" action="/index.php?c=admin&m=oncompanyupdate" style="display:none;" id="newsome">
    <h4>公司等级编辑 <em class="close">X</em></h4>
    <div class="toast-content">
        <div class="info">
            <p>北京中关村在线科技有限公司</p>
            <label for="">
                    密码 
                    <input type="text" id="password" name="password">
                </label>
        </div>
        <div class="types" id="editlists">
            <ul>
                <li class="selected" data-ulevel="3">
                    <i></i>
                    <span>待审核</span>
                </li>
                <li data-ulevel="1">
                    <i></i>
                    <span>普通用户</span>
                </li>
                <li data-ulevel="2">
                    <i></i>
                    <span>VIP用户</span>
                    <label for="" id="set_date">
                            <em>有效期</em> 
                            <input type="text" name="vip_start">
                            <em>至</em>
                            <input type="text" name="vip_end">
                        </label>
                    <!-- error -->
                    <p class="error">请填写正确的有效期</p>
                    <p class="hiont">填写规范：2011-01-01</p>
                </li>
            </ul>
        </div>
        <div class="buttons">
            <button class="save">保存</button>
            <span class="cancel">取消</span>
        </div>
    </div>
    <!-- 公司状态 1-免费用户 2-VIP用户 3-待审核用户 -1 删除 -->

    <input type="hidden" name="ulevel" value="" />
    <input type="hidden" name="id" value="" />
</form>

<form class="toast is-deleted" action="/index.php?c=admin&m=oncompanyupdate" data-url="/index.php?c=admin&m=oncompanyupdate" style="display:none;">
    <h4>删除 <em class="close">X</em></h4>
    <div class="toast-content">
        <p>确定要删除吗？</p>
        <div class="buttons">
            <span class="save" id="delete_btn">确定</span>
            <span class="cancel">取消</span>
        </div>
    </div>
    <input type="hidden" name="id" value="" />
    <input type="hidden" name="ulevel" value="-1" />
</form>
<i class="layer" id="layer" style="display:none;"></i>
</body>
<script src="<?=BASEURL;?>/static/js/admin/index.js"></script>
</html>