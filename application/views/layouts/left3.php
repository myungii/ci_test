
<ul class="sideList">
    <li><a href="#" class="one">목록</a>
        <ul class="inner">
            <li><a href="/"  class="">일반 게시판
                  <?php if(Board_model::newCnt() > 0) { ?>
                        <span class="badge  " style="background:#eb2c2c" data-toggle="tooltip" title="새글" style="width:25px;height:14px;" >
                            <?= Board_model::newCnt() ?>
                        </span>
                   <?php } ?>
            </a></li>

            <li><a href="/ajax"  class="">Ajax 게시판
                  
                        <span class="badge  " style="background:#eb2c2c" data-toggle="tooltip" title="새글" style="width:25px;height:14px;" >
                            
                        </span>
                   
            </a></li>

            <li><a href="/plugin"  class="">Plugin 게시판
                        <span class="badge  " style="background:#eb2c2c" data-toggle="tooltip" title="새글" style="width:25px;height:14px;" >

                        </span>
                   
            </a></li>

        </ul>
    </li>
</ul>


