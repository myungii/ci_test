
         <div id="form-commentInfo">
               <input type="hidden" id="comment-pid" value="<?= $pid ?>">
              <div id="comment-count">댓글 <span id="count"><?= $total ?></span></div> 
              <input type="text" name="name" id="comment-name" placeholder="이름">
              <input id="comment-input" placeholder="댓글을 입력해 주세요."> 
              <button id="submit"  class="btn btn-lg btn-theme">등록</button> 
        </div> 
        <div id=comments>
		<?php foreach($reply as $list) { ?>
			<div class="name"><?= $list->name ?>
			</div>
			<span class="eachComment"><?= $list->content ?> </span>
			<div class="time"><?= $list->regdate ?></div>
		<?php }	?>
		</div>
         <script src="/asset/reply/js/reply.js"></script> 
