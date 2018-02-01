<!-- 新建 -->
<div class="view-content">
    <h4>
        <a href="#">公司管理</a>/新建公司
    </h4>
    <!-- 表单 -->
    <form action="/index.php?c=reg&m=onreg" class="new-form" id="form">
        <input type="hidden" name="uid" value="<?=isset($info)?$info['uid']:0;?>" />
        <ul>
            <li>
                <em>公司名称</em>
                <label for="" style="width:436px;">
                    <input class="need-verify" name="name" type="text" placeholder="请填写公司或机构名称" value="<?=isset($info)?$info['name']:'';?>">
                </label>
                <span class="error-text">请填写公司名称</span>
            </li>
            <li>
                <em>公司地址</em>
                <label for="" style="width:586px;">
                    <input class="need-verify" name="address" type="text" placeholder="请填写公司地址" value="<?=isset($info)?$info['address']:'';?>">
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
                    <input class="need-verify" name="master" type="text" placeholder="请填写真实姓名" value="<?=isset($info)?$info['master']:'';?>">
                </label>
                <span class="error-text">请填写真实姓名</span>
            </li>
            <li>
                <em>联系电话</em>
                <label for="">
                    <input class="need-verify" name="tel" type="text" data-pattern="^1(([38]\d)|(4[57])|(5[012356789])|(6[6])|(7[0678])|(9[89]))\d{8}$" placeholder="请填写联系电话" value="<?=isset($info)?$info['tel']:'';?>">
                </label>
                <span class="error-text">请填写联系电话</span>
            </li>
            <li>
                <em>电子邮箱</em>
                <label for="" style="width:276px;">
                    <input class="need-verify" name="email" type="text" data-pattern="^([0-9A-Za-z\-_\.]+)@([0-9a-z]+\.[a-z]{2,3}(\.[a-z]{2})?)$" placeholder="请填写简历接收邮箱" value="<?=isset($info)?$info['email']:'';?>">
                </label>
                <span class="error-text">请填写简历接收邮箱</span>
            </li>
            <li class="upimg-file">
                <em>营业执照副本</em>
                <label for="" class="fileup">
                    <span>上传</span>
                    <input type="file" class="upimg" placeholder="请上传营业执照副本电子版">
                </label>
                <!-- 上传成功 -->
                <div class="up-success" style="display:none;">
                    <figure>
                        <img src="<?=isset($info) ? $info['license'] : 'http://temp.im/180x100';?>" class=""/>
                    </figure>
                    <span class="up-again">
                        重新上传
                        <input type="file" class="upimg" placeholder="请上传营业执照副本电子版">
                    </span>
                    <input class="need-verify" type="hidden" name="license">
                </div>

                <span class="error-text">请上传营业执照副本电子版</span>
            </li>
            <li class="intro">
                <em>公司简介</em>
                <label for="" style="width:586px;" class="import">
                    <textarea class="need-verify" name="intro" id="" rows="10" maxlength="200" placeholder="请填写公司简介"><?=isset($info)?$info['intro']:'';?></textarea>
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
<script src="<?=BASEURL;?>/static/js/admin/public.js"></script>
<script src="<?=BASEURL;?>/static/js/admin/newwork-form.js"></script>
</html>