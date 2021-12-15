<head>
    <style>
        #noticeList {
            font-weight : bold;
        }
        #new {
            color : red;
        }

		.ui-datepicker-trigger{cursor: pointer;}
		.datepicker{cursor: pointer;} 
    </style>
</head>

<!-- //subTitle -->
<div id="title-area">HTML </div>
<!-- Contents -->
<div id="Contents" style="width:1400px; padding-left:20em;">
    <!-- filter -->
    <form id="FrmAttendanceSearch" >
    <input type="hidden" name="p" value="">
    <table class="table table-bordered table-form pad">
        <colgroup>
            <col>
			<col style="width:400px">
        </colgroup>
		
        <tbody>
            <tr>
                <th>재목</th>
                <td>
                    <input type="text" name="search_title" class="form-control input-xsm"   value="" autocomplete="off">
                </td>

                <th>이름</th>
                <td>
                    <input type="text" name="search_name" class="form-control input-xsm"  value="" autocomplete="off">
                </td>
            </tr>

            <tr>
                <th>등록일</th>
                <td>
					<div style="float:left; width:180px">
						 <input type="text" name="search_reg_start" class="datepicker" id="datepicker_start" style="width:100%"  value="" autocomplete="off" readonly>
					</div>	
					<div style="float:left;">
						<span style="margin:0 5px; line-height:30ox;">
							~
						</span>
					</div>
					<div style="float:left;width:180px;">
						 <input type="text" name="search_reg_end" class="datepicker" id="datepicker_end" style="width:100%"  value="" autocomplete="off" readonly>
					</div>	

                </td>

                <th>공지여부</th>
                <td style="text-align:start;">
                  <input type="radio" name="notice" id="all" value="all" class="hmis validate" checked>
                  <span class="lbl">전체</span>
                  <input type="radio" name="notice" id="yes" value="Y" class="hmis validate" >
                  <span class="lbl">공지</span>
                  <input type="radio" name="notice" id="no" value="N" class="hmis validate">
                  <span class="lbl">일반</span>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="area-button">
        <button type="button" id="searchBtn" class="btn btn-lg btn-theme" onclick="">검색</button>
    </div>
    </form>
    
        <!-- btn, total -->
        <h3 class="area-title">
        Total :
        <span class="f-bold"><strong><span id="recordsTotal"></span></strong>건</span>
        <div class="button-box">
            <button class="btn btn-flat-blue" onclick="location.replace('/index.php/boardAjax/write');" style="float: left;">게시물 등록</button>
        </div>
    </h3>
    
    <!-- list -->
    
        <table class="table table-bordered table-list table-striped table-hover table-adjehyu" id="adjehyuList">
            <colgroup>
                <col width="80px">
                <col>
                <col width="100px">
                <col width="100px">
                <col width="100px">
            </colgroup>
            <thead>
            <tr>
                <th>No</th>
                <th>제목</th>
                <th>이름</th>
                <th>등록일</th>
                <th>조회수</th>
            </tr>
            </thead>
            <tbody id="board_list">
                
                    
            </tbody>
            
        </table>
            
        <div id="paging" class="area-button">
        <ul class="pagination">
        </ul>
        
        </div>
    

</div>

<!-- Contents -->

<script type="text/javascript">

        $(function() {
            //모든 datepicker에 대한 공통 옵션 설정
            $.datepicker.setDefaults({
                dateFormat: 'yy-mm-dd' //Input Display Format 변경
                ,showOtherMonths: true //빈 공간에 현재월의 앞뒤월의 날짜를 표시
                ,showMonthAfterYear:true //년도 먼저 나오고, 뒤에 월 표시
                ,changeYear: true //콤보박스에서 년 선택 가능
                ,changeMonth: true //콤보박스에서 월 선택 가능                
                ,yearSuffix: "년" //달력의 년도 부분 뒤에 붙는 텍스트
                ,monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'] //달력의 월 부분 텍스트
                ,monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'] //달력의 월 부분 Tooltip 텍스트
                ,dayNamesMin: ['일','월','화','수','목','금','토'] //달력의 요일 부분 텍스트
                ,dayNames: ['일요일','월요일','화요일','수요일','목요일','금요일','토요일'] //달력의 요일 부분 Tooltip 텍스트
                ,minDate: "-1M" //최소 선택일자(-1D:하루전, -1M:한달전, -1Y:일년전)
                ,maxDate: "+1M" //최대 선택일자(+1D:하루후, -1M:한달후, -1Y:일년후)                    
            });
 
            //input을 datepicker로 선언
            $("#datepicker_start").datepicker();                    
            $("#datepicker_end").datepicker();
            //To의 초기값을 내일로 설정
            $('#datepicker_end').datepicker('setDate', 'today'); //(-1D:하루전, -1M:한달전, -1Y:일년전), (+1D:하루후, -1M:한달후, -1Y:일년후)
        });



$(document).ready(function() {

	load_data();
});

	function load_data(search, page)
	{
			page = page? page : 0;

		$.ajax({
			url : "/index.php/boardAjax/home/ajaxList",
			type : "POST",
			data : { search : search, page : page},
			dataType : 'text',
	  		contentType : 'application/x-www-form-urlencoded; charset=euc-kr json',
			success :function(data) {
				var json = JSON.parse(data);

				$("input[name=p]").attr("value", json.p);
				$("span#recordsTotal").text(json.total);
				htmlData(json.list, json.page, json.total, json.pagingArr.rowsPage);
			//	noticeData(json.notice_view);
				paging(json.paging, json.page);
			}
			, error : function (request, status, error) {
					console.log('error 발생 : ' + request + '   ' + status + '   ' + error);

			}

		});

	}


	function htmlData(json, page, total, rowsPage) {
		var index = total - (page - 1) * rowsPage;

		for(var i in json)
		{

			var row = $("<tr/>").append(

				$("<td/>").text(index-i),
				$("<td/>").html("<a href ='/index.php/ajax/content/"+ json[i].idx +"'>" + json[i].title + "</a>"),
				$("<td/>").text(json[i].name),
				$("<td/>").text(json[i].regdate),
				$("<td/>").text(json[i].cnt)

			);

			$("#board_list").append(row);
		}


	}


/*
	function noticeData(notice) {

		     for(var i in notice)
        {

            var notice  = $("<tr/>").append(

                $("<td/>").html("<b>공지</b>"),
                $("<td/>").html("<a href ='/index.php/ajax/content/"+ notice[i].idx +"'>" + json[i].title + "</a>"),
                $("<td/>").text(notice[i].name),
                $("<td/>").text(notice[i].regdate),
                $("<td/>").text(notice[i].cnt)

            );


	}
*/


	function paging(json, page) {

		 $("ul.pagination").html('');

           if (json.current_block > 2) {
				 $("ul.pagination").append("<li><a id='page-1' href='#'>◀</a></li>");
            }
            if (json.current_block > 1) {
				$("ul.pagination").append("<li><a id='" + json.prev + "' href='#'>◁</a></li>");
			}
            for(var i=1; i<=json.current.length; i++) {

                if (page == i) {
					$("ul.pagination").append("<li class='act'><a id='" + i + "' href='#'><span style='color:red;'>" + i + "</span></a></li>");
                } else {

					 $("ul.pagination").append("<li><a id='" + i + "' href='#'>" + i + "</a></li>");
                }
            }
            if (json.current_block < (json.total_block)) {
				$("ul.pagination").append("<li><a id='" + json.next + "' href='#'>▷</a></li>");
            }
            if (json.current_block < (json.total_block - 1)) {
				 $("ul.pagination").append("<li><a id='" + json.totalPage + "' href='#'>▶</a></li>");
            }


	}


	$(document).on('click', 'ul.pagination li > a', function() {
		var page = $(this).attr("id");
		test = $("input[name=p]").attr("value", page);

		 $('#searchBtn').click();
	});

	
	$('#searchBtn').click(function(e) {
		$("#board_list").html('');

	   let title 		= $("input[name=search_title]").val();	
	   let name 		= $("input[name=search_name]").val();	
	   let reg_start 	= $("input[name=search_reg_start]").val();	
	   let reg_end 		= $("input[name=search_reg_end]").val();	
	   let notice 		= $("input[type=radio]:checked").val();	
	   
	   let page			= $("input[name=p]").val();

		let search     		= new Object();

		search.title   		= title;
		search.name   		= name;
		search.reg_start   	= reg_start;
		search.reg_end   	= reg_end;
		search.notice   	= notice;

		load_data(search, page);

	});




</script>
