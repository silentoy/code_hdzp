<!-- 新建职位 -->
<div class="view-content">
    <h4>
        <a href="#">职位管理</a>/新建职位
    </h4>
    <!-- 表单 -->
    <form action="/index.php?c=admin&m=onadd" class="new-form" id="form">
        <input type="hidden" name="id" value="<?=isset($info) ? $info['id'] : 0;?>">
        <ul>
            <li>
                <em>选择公司</em>
                <div class="select-list">
                    <span>请填写公司或机构名称</span>
                    <div class="firms">
                        <ul>
                            <?php foreach($companys as $item) { ?>
                            <li data-id="<?=$item['id']?>" <?php if(isset($info) && $item['id']==$info['cid']) {echo 'selected';}?>><?=$item['name']?></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <input class="need-verify" type="hidden" name="cid">
                </div>
                <span class="error-text">请填写公司名称</span>
            </li>
            <li>
                <em>岗位名称</em>
                <label for="" style="width:290px;">
                    <input type="text" name="name" placeholder="请填写岗位名称" class="need-verify" value="<?=isset($info)?$info['name']:'';?>">
                </label>
                <span class="error-text">请填写岗位名称</span>
            </li>
            <li>
                <em>薪资待遇</em>
                <div class="timer">
                    <label for="" style="width:125px;">
                        <input type="text" name="wage_min" value="<?=isset($info)?$info['wage_min']:''?>">
                    </label> 至
                    <label for="" style="width:125px;">
                        <input type="text" name="wage_max" value="<?=isset($info)?$info['wage_max']:''?>">
                    </label>
                </div>
                <div name="wage_type" class="changed" data-id="<?=isset($info)?$info['wage_type']:''?>">
                    面议
                </div>
                <input type="hidden" class="" name="wage_type" value="0">
                <span class="error-text">请填写薪资待遇</span>
            </li>
            <li class="describe">
                <em>工作职责</em>
                <label for="" style="width:586px;">
                    <textarea class="need-verify" name="intro" id="" rows="10" maxlength="200" placeholder="请填写工作职责"><?=isset($info)?$info['intro']:'';?></textarea>
                </label>
                <span class="error-text">请填写工作职责</span>
            </li>
            <li class="describe">
                <em>岗位要求</em>
                <label for="" style="width:586px;">
                    <textarea class="need-verify" name="requirement" id="" rows="10" maxlength="200" placeholder="请填写岗位要求"><?=isset($info)?$info['requirement']:'';?></textarea>
                </label>
                <span class="error-text">请填写岗位要求</span>
            </li>
            <li>
                <em name="ask_type">应聘方式</em>
                <div class="your-type selected" data-id="1">
                    <i></i>
                    <span>发简历</span>
                </div>
                <div class="your-type" data-id="2">
                    <i></i>
                    <span>打电话</span>
                </div>
                <input type="hidden" class="need-verify" name="ask_type" value="1">
            </li>
            <li class="submit-view">
                <button>保存修改</button>
            </li>
        </ul>
    </form>
</div>
</body>
<script src="<?=BASEURL;?>/static/js/admin/station.js"></script>
</html>