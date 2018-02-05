
        <div class="total">
            <span class="visit">职位：<var><?=$positions;?></var></span>
            <span>访问量：<var><?=$hrInfo['views'];?></var></span>
        </div>

        <div class="notice upFirmImg">
            <h3>上传公司首页图片
            <span>此图片展示在小程序中公司首页上</span></h3>
            <ul>
                <li class="image">
                  <label class="upload-button">上传<input type="file" class="upFirmImgBtn" accept="image/*"></label>
                  <span class="notes">上传图片请控制在2M以内</span>
                </li>
                <li id="firmImgList" class="img-list" style="display:none">
                    <div><!--<figure><img src="/uploads/20180204_1517710382.png"></figure>--><span>重新上传<input class="upFirmImgBtn" data-type="change" data-number="0" type="file" accept="image/*"></span></div>
                    <div><span>重新上传<input class="upFirmImgBtn" data-type="change" data-number="1" type="file" accept="image/*"></span></div>
                    <div><span>重新上传<input class="upFirmImgBtn" data-type="change" data-number="2" type="file" accept="image/*"></span></div>
                </li>
            </ul>
        </div>
        <?php if ($notices) { ?>
        <div class="notice">
            <h3>系统通知</h3>
            <ul class="notice-list">
                <?php foreach($notices as $item) { ?>
                <li>
                    <span class="time"><?=date("Y-m-d", $item['addtime']);?></span>
                    <a href="/index.php?c=hr&m=notice&id=<?=$item['id'];?>"><?=$item['subject'];?></a>
                </li>
                <?php } ?>
            </ul>
        </div>
        <?php } ?>
    </div>

</div>
    <script src="<?=BASEURL;?>/static/js/jquery.js"></script>
    <script src="<?=BASEURL;?>/static/js/home.js"></script>
</body>
</html>