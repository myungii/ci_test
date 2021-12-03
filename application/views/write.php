<!-- //subTitle -->
<div id="title-area">글쓰기 </div>
    <!-- Contents -->
    <div id="Contents" style="width:1400px; padding-left:20em;">

    <form id="frmAdjehyuList" method="post" action="/index.php/write/save">
    
        <table class="table table-bordered table-list">
            <colgroup>
                <col width="120px">
                <col width="1000px">
                <col width="120px">
                <col width="1000px">
            </colgroup>

            <tbody>
             
            <tr>
                <th>이름</th>
                <td>
                  <input type="text" name="name" id="name" style="width:980px;" value="" >
                </td>
            </tr>
            <tr>
                <th>제목</th>
                <td><input type="text" name="title" value="" id="title"  style="width:980px;"></td>
            </tr> 

            </tbody>

        </table>  <br>

         <textarea id="summernote" name="editordata"></textarea>
               
         <div class="area-button">
            <button type="button" name="save" class="btn btn-lg btn-theme" onclick="">저장</button>
            <button type="button" class="btn btn-gray btn-lg modal-close" onclick="location.href='/';">목록</button>
        </div>

    </form>
    </div>

</div>

<script type="text/javascript">

$(document).ready(function () {
    $('#summernote').summernote({
      height: 500,
      width: 1120,              
      minHeight: 500,            
      maxHeight: 500, 
      focus: true,                  
      lang: "ko-KR",					
      placeholder: '내용을 입력해주세요.',	
      toolbar: [
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
        ['color', ['forecolor', 'color']],
        ['table', ['table']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['insert', ['picture', 'link', 'video']],
        ['view', ['fullscreen', 'help']]
      ],
      fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', '맑은 고딕', '궁서', '굴림체',
        '굴림', '돋음체', '바탕체'],
      fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '22', '24', '28', '30', '36',
        '50', '72']
    });

    $(document).on("click", "button[name='save']" , function() {
        let name = $('input[name=name]').val();
        let title = $('input[name=title]').val();
        let content = $('#summernote').val()

        let arr  = [name, title, content];
        let arr2 = ['이름', '제목', '내용'];

        for(i=0; i<=arr.length; i++)
        {
          if(arr[i] == '')
          {
            alert(arr2[i] + '을(를) 입력해주세요.');
            return false;
          }
        }

        $.ajax({
          url      : "/index.php/write/save",
          dataType : "json",
          contentType : "application/x-www-form-urlencoded; charset=UTF-8",
          data     : { "name"    : name, 
                       "title"    : title,
                       "content"  : content
                      },
          type   : "POST"
        , success : function(r)
        {
            if(r == '200') {
              alert("저장되었습니다.");
              location.replace('/');
              return true;
            } else {
              alert("오류발생.");
              return false;
            }
        }
        , complete : function()
        {
            
        }
      }); //ajax end

    }); //click end

  });



</script>