 <!-- 发布职位 -->
        <form class="release">
            <input type="hidden" name="id" value="<?=isset($info['id']) ? $info['id'] : 0;?>">
            <input type="hidden" name="uid" value="<?=$hrInfo['uid'];?>">
            <input type="hidden" name="cid" value="<?=$hrInfo['id'];?>">
            <ul>
                <li>
                    <label for="">岗位名称</label>
                    <input name="name" type="text" placeholder="如会计、程序员等" value="<?=isset($info['name']) ? $info['name'] : '';?>">
                    <span class="remind">请填写岗位名称</span>
                </li>
                <li class="second" id="salary">
                    <label for="">薪资待遇</label>
                    <input name="wage_min" type="text" value="<?=isset($info['wage_min']) ? $info['wage_min'] : '';?>">
                    <span class="reach">至</span>
                    <input name="wage_max" type="text" value="<?=isset($info['wage_max']) ? $info['wage_max'] : '';?>">
						<span class="checkbox">
							<input name="wage_type" value="1" id="negotiable" type="checkbox" <?php if (isset($info['wage_type']) && $info['wage_type']) {echo 'checked="checked"';}?>>
							面议
						</span>
                    <span class="remind">请填写薪资待遇</span>
                </li>
                <li class="three">
                    <label for="">工作职责</label>
                    <textarea name="intro" id="" placeholder="请填写工作职责"><?=isset($info['intro']) ? $info['intro'] : '';?></textarea>
                    <span class="remind">请填写工作职责</span>
                </li>
                <li class="three">
                    <label for="">岗位要求</label>
                    <textarea name="requirement" id="" placeholder="请填写岗位要求"><?=isset($info['requirement']) ? $info['requirement'] : '';?></textarea>
                    <span class="remind">请填写岗位要求</span>
                </li>
                <li class="choose">
                    <label for="">应聘方式</label>
						<span  class="radio">
							<input name="ask_type" id="jianli" type="radio" checked value="1" <?php if (isset($info['ask_type']) && $info['ask_type']==1) {echo 'checked="checked"';}?>>
							<label for="jianli">发送简历</label>
						</span>
						<span class="radio">
							<input name="ask_type" id="phone" type="radio" value="2" <?php if (isset($info['ask_type']) && $info['ask_type']==2) {echo 'checked="checked"';}?>>
							<label for="phone">打电话</label>
						</span>
                </li>
            </ul>
        </form>
        <div class="release-occupation" id="addPosition">发布职位</div>
        <div class="mask" id="mask" style="">
            <div class="mask-content">
                <p class="delete-text">添加成功</p>
                <div class="footer">
                    <span class="determine" id="addPositionBtn" data-id="123" data-type="remove">确定</span>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="<?=BASEURL;?>/static/js/jquery.js"></script>
    <script src="<?=BASEURL;?>/static/js/home.js"></script>
</body>
</html>