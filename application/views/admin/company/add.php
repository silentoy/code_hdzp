<!-- 新建 -->
<div class="view-content">
    <h4>
        <a href="#">公司管理</a>/新建公司
    </h4>
    <!-- 表单 -->
    <form action="" class="new-form">
        <input type="hidden" name="uid" value="<?=isset($info)?$info['uid']:0;?>" />
        <ul>
            <li>
                <em>公司名称</em>
                <label for="" style="width:436px;">
                    <input name="name" type="text" placeholder="请填写公司或机构名称" value="<?=isset($info)?$info['name']:'';?>">
                </label>
                <span class="error-text">请填写公司名称</span>
            </li>
            <li>
                <em>公司地址</em>
                <label for="" style="width:586px;">
                    <input name="address" type="text" placeholder="请填写公司地址" value="<?=isset($info)?$info['address']:'';?>">
                </label>
                <span class="error-text">请填写公司地址</span>
            </li>
            <li>
                <em>公司地点标签</em>
                <label for="">
                    <select name="tagid[]" id="">
                        <?php foreach($tags as $item) { ?>
                        <option <?php if (isset($info) && in_array($item['id'], explode(",",$info['tagid'])))?> value="<?=$item['id'];?>"><?=$item['name'];?></option>
                        <?php } ?>
                    </select>
                </label>
                <span class="error-text">请选择地点标签</span>
            </li>
            <li>
                <em>招聘负责人</em>
                <label for="">
                    <input name="master" type="text" placeholder="请填写真实姓名" value="<?=isset($info)?$info['master']:'';?>">
                </label>
                <span class="error-text">请填写真实姓名</span>
            </li>
            <li>
                <em>联系电话</em>
                <label for="">
                    <input name="tel" type="text" placeholder="请填写联系电话" value="<?=isset($info)?$info['tel']:'';?>">
                </label>
                <span class="error-text">请填写联系电话</span>
            </li>
            <li>
                <em>电子邮箱</em>
                <label for="" style="width:276px;">
                    <input name="email" type="text" placeholder="请填写简历接收邮箱" value="<?=isset($info)?$info['email']:'';?>">
                </label>
                <span class="error-text">请填写简历接收邮箱</span>
            </li>
            <li class="upimg-file">
                <em>营业执照副本</em>
                <label for="" style="width:100px;display:none;">
                    <span>上传</span>
                    <input type="file" placeholder="请上传营业执照副本电子版">
                </label>
                <!-- 上传成功 -->
                <div class="up-success">
                    <figure>
                        <img src="<?=isset($info) ? $info['license'] : 'http://temp.im/180x100';?>" class=""/>
                    </figure>
                    <span class="up-again">
                        重新上传
                        <input type="file" placeholder="请上传营业执照副本电子版">
                    </span>
                </div>

                <span class="error-text">请上传营业执照副本电子版</span>
            </li>
            <li class="intro">
                <em>公司简介</em>
                <label for="" style="width:586px;">
                    <textarea name="intro" id="" rows="10" maxlength="200" placeholder="请填写公司简介"><?=isset($info)?$info['intro']:'';?></textarea>
                    <var>0/200</var>
                </label>
                <span class="error-text">请填写公司简介</span>
            </li>
            <li class="submit-view">
                <button>保存</button>
            </li>
        </ul>
    </form>
</div>
</body>

</html>