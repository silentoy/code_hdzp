
        <div class="total">
            <span class="visit">职位：<var><?=$positions;?></var></span>
            <span>访问量：<var><?=$hrInfo['views'];?></var></span>
        </div>
        <?php if ($notices) { ?>
        <div class="notice">
            <h3>系统通知</h3>
            <ul class="notice-list">
                <?php foreach($notices as $item) { ?>
                <li>
                    <span class="time"><?=date("Y-m-d", $item['addtime']);?></span>
                    <a href="#<?=$item['id'];?>"><?=$item['subject'];?></a>
                </li>
                <?php } ?>
            </ul>
        </div>
        <?php } ?>
    </div>

</div>
</body>
</html>