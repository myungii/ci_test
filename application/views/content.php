
<!-- //subTitle -->
<div id="title-area">HTML </div>
<!-- Contents -->
<div id="Contents" style="width:1400px; padding-left:20em;">

    <!-- list -->
    <form id="frmAdjehyuList" onsubmit="return false">
        <table class="table table-bordered table-list table-striped">
            <colgroup>
                <col width="120px">
                <col>
                <col width="120px">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <th>제목</th>
                <td colspan="3"><?= $content->title ?></td>
            </tr>
            <tr>
                <th>이름</th>
                <td><?= $content->name ?></td>
                <th>등록일</th>
                <td><?= Board::setRegdate($content->regdate) ?></td>
            </tr>
            <tr>
                <th>조회수</th>
                <td colspan="3"><?= $content->cnt ?></td>
            </tr>
            <tr>
                <th>파일</th>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="4" style="vertical-align: text-top;height:150px;line-height:15px;padding:10 10 10 10;word-wrap:break-word;word-break:break-all">
                    <?= $content->content ?>
                </td>
            </tr>

            </tbody>

        </table>
        
        <div class="area-button">
            <button type="button" class="btn btn-gray btn-lg modal-close" onclick="location.href='/';">목록</button>
            <button type="button" class="btn btn-lg btn-theme" onclick="location.replace('/index.php/write?id=<?=$content->idx?>')">수정</button>
            <button type="button" class="btn btn-lg" onclick="location.replace('/index.php/delete?id=<?=$content->idx?>')">삭제</button>
        </div>

    </form>

</div>

<!-- Contents -->

<script type="text/javascript">


</script>