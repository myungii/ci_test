<head>
    <style>
        #noticeList {
            font-weight : bold;
        }
        #new {
            color : red;
        }
 
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
            <col width="120px">
            <col>
    
        </colgroup>
        <tbody>
            <tr>
                <th>제목</th>
                <td>
                    <input type="text" name="filter_name" class="form-control input-xsm"  style="width:1022px;"  value="" autocomplete="off">
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
        <span class="f-bold"><strong><span id="recordsTotal">0</span></strong>건</span>
        <div class="button-box">
            <button class="btn btn-flat-blue" onclick="location.replace('/index.php/write');" style="float: left;">게시물 등록</button>
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

$(document).ready(function() {

	load_data();

	function load_data()
	{

		$.ajax({
			url : "/index.php/boardAjax/home/ajaxList",
			type : "POST",
			dataType : "text",
			crossOrigin : false,
			success :function(data) {
				console.log(data);

			}
			, error : function (request, status, error) {
					console.log('error 발생 : ' + request + '   ' + status + '   ' + error);

			}

		});

	}


	function htmlData(json) {


		var html = '<tr>';
		$(json).each(function() {

				html += '<td id="bidx">' + this.idx  + '</td>';
				html += '<td id="bname">' + this.title + '</td>';
				html += '<td id="bregdate">' + this.name + '</td>';
				html += '<td id="bcnt">' + this.regdate + '</td> </tr>';

			
		});

		 $("#board_list").html(html);

	}

	
	$('#searchBtn').click(function() {


	});




});

</script>
