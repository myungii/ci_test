
<ul class="sideList">
    <li><a href="#" class="one">목록</a>
        <ul class="inner">
            <li><a href="/"  class="">목록1
                  <?php if(Board_model::newCnt() != 0 || Board_model::newCnt() != null) { ?>
                        <span class="badge  " style="background:#eb2c2c" data-toggle="tooltip" title="새글" style="width:25px;height:14px;" >
                            <?= Board_model::newCnt() ?>
                        </span>
                   <?php } ?>  
            </a></li>
        </ul>
    </li>
</ul>


