<!-- datatables js/css -->
<link href='/asset/adminsin/js/datatables/DataTables-1.10.20/css/jquery.dataTables.css' rel='stylesheet' type='text/css'>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.21/pagination/full_numbers_no_ellipses.js" type="text/javascript"></script>
<style>
    .dataTables_wrapper .dataTables_processing{top:50%; height: 0px; padding: 0;}
    .dataTables_wrapper .table > tbody > tr.odd{background-color: #f9f9f9;}
    .dataTables_wrapper .table > tbody > tr{}
    .dataTables_wrapper .table > tbody > tr > td > a{text-decoration: underline;}
    .dataTables_wrapper .table > tbody > tr > td{word-break: break-all; height: 35px}
    .dataTables_wrapper .table > tbody > tr > td.dataTables_empty{text-align: center; vertical-align: middle;}
    .dataTables_wrapper .table > tbody > tr > td.center{text-align: center;}
    .dataTables_wrapper .table > tbody > tr > td.cursor{cursor: pointer;}
    .dataTables_wrapper .table > tbody > tr > td.right{text-align: right;}
    .dataTables_wrapper .pagination{display: block; border-radius: 0; margin: 0; text-align: center;}
    .dataTables_wrapper .pagination > div.dataTables_paginate{display: inline-block; padding-top: 0; margin: 20px 0; float: none;}
    .dataTables_wrapper .pagination > div.dataTables_paginate > span{float: left;}
    .dataTables_wrapper .pagination > div.dataTables_paginate > span > a, .dataTables_wrapper .pagination > div > a{
        background: #fff !important; border: 1px solid #ddd !important; float: left !important; line-height: 1.42857 !important;
        margin-left: -1px !important; padding: 6px 12px !important; position: relative !important;
        text-decoration: none !important; border-radius: 0!important; outline: none !important; box-shadow: none !important;}
    .dataTables_wrapper .pagination > div.dataTables_paginate > span > a:hover, .dataTables_wrapper .pagination > div > a:hover{background-color: #eee !important; background: #eee !important; color:#333 !important;}
    .dataTables_wrapper .pagination > div.dataTables_paginate > span > a.current {background: #53687f !important; border-color: #53687f !important; color: #fff !important; cursor: default !important; z-index: 2 !important;}
    .dataTables_wrapper .pagination > div.dataTables_paginate > span > a.current:hover{color:#fff !important;}
    .table-adjehyu input[type=checkbox].hmis + .lbl::before{margin-right: 0;}
    .table-adjehyu label.hmis{margin-right: 0; display: inline-block;}
    .table > tbody > tr > td, .table > tbody > tr > th, .table > thead > tr > th{padding:6px;}



    #new { color : red; } 
</style>

<!-- //subTitle -->
<div id="title-area"></div>
<!-- Contents -->
<div id="Contents" style="width:1400px;padding-left:255px;">
    <!-- filter -->
    <form id="search_frm"  onsubmit="return false">
    <input type="hidden" name="p" value="">
    <table class="table table-bordered table-form pad">

        <colgroup>
            <col>
			<col style="width:400px">
        </colgroup>
		
        <tbody>
            <tr>
                <th>??????</th>
                <td>
                    <input type="text" name='title' class="form-control input-xsm"   value="" autocomplete="off">
                </td>

                <th>??????</th>
                <td>
                    <input type="text" name="name" class="form-control input-xsm"  value="" autocomplete="off">
                </td>
            </tr>

            <tr>
                <th>?????????</th>
                <td>
					<div style="float:left; width:180px">
						 <input type="text" name="regstart" class="datepicker" id="datepicker_start" style="width:100%"  value="" autocomplete="off" readonly>
					</div>	
					<div style="float:left;">
						<span style="margin:0 5px; line-height:30ox;">
							~
						</span>
					</div>
					<div style="float:left;width:180px;">
						 <input type="text" name="regend" class="datepicker" id="datepicker_end" style="width:100%"  value="" autocomplete="off" readonly>
					</div>	

                </td>

                <th>????????????</th>
                <td style="text-align:start;">
                  <input type="radio" name="notice" id="all" value="all" class="hmis validate" checked>
                  <span class="lbl">??????</span>
                  <input type="radio" name="notice" id="yes" value="Y" class="hmis validate" >
                  <span class="lbl">??????</span>
                  <input type="radio" name="notice" id="no" value="N" class="hmis validate">
                  <span class="lbl">??????</span>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="area-button">
        <button type="submit" id="searchBtn" class="btn btn-lg btn-theme_bu" onclick="board_list.ajax.reload();">??????</button>
    </div>
    </form>

        <!-- btn, total -->
        <h3 class="area-title">
        Total :
        <span class="f-bold"><strong><span id="recordsTotal"></span></strong>???</span>
        <div class="button-box">
            <button class="btn btn-flat-blue" onclick="location.replace('/');" style="float: left;">????????? ??????</button>
        </div>
    </h3>
    <!-- list -->
    <form id="frmAdjehyuList" onsubmit="return false">
        <table class="table table-bordered table-list table-striped table-hover table-adjehyu" id="board_list">
            <colgroup>
                <col width="80px">
                <col>
                <col width="180px">
                <col width="140">
                <col width="130px">
            </colgroup>
            <thead>
            <tr>
                <th>No</th>
                <th>??????</th>
                <th>??????</th>
                <th>?????????</th>
                <th>?????????</th>
            </tr>
            </thead>
        </table>
    </form>

</div>


<!-- ????????? ?????? -->
<div id="dialog-form" title="?????????">

	<form>
		<div class="form-group">
			<label for="wname" style="display:inline-block">??????</label>
			 <div class="col-sm-10">
				<input type="text" class="form-control" id="wname" name="wname"  aria-describedby="emailHelp" placeholder="????????? ???????????????.">
			 </div>
			 <div class="valid_notice" style="color:red"> </div>
		</div>
		<div class="form-group">
			<label for="wtitle" style="display:inline-block">??????</label>
			<input type="text" class="form-control" id="wtitle" name="wtitle" placeholder="????????? ???????????????.">
		</div>
		<div class="form-check">
			<label style="display:block">????????????</label>
			<input class="form-check-input" type="radio" name="wnotice" id="wnotice_N" value="N" checked>
			<label class="form-check-label" style="display:inline-block" for="wnotice_N">
				?????????
			</label>
			<input class="form-check-input" type="radio" name="wnotice" id="wnotice_Y" value="Y" >
			<label class="form-check-label" style="display:inline-block" for="wnotice_Y">
				??????
			</label>
		</div>
		<br>
		<div class="form-group">
			<label for="wupload_file" style="display:inline-block">????????????</label>
			<input type="file" class="form-control-file" name="wupload_file"  id="wupload_file">
		</div>
		<div class="form-group">
			<textarea class="form-control" id="summernote" name="editoerdata" rows="3"></textarea>
		</div>
	</form>

</div>


<!-- Contents -->
<script type="text/javascript">

        $(function() {
            //?????? datepicker??? ?????? ?????? ?????? ??????
            $.datepicker.setDefaults({
                dateFormat: 'yy-mm-dd' //Input Display Format ??????
                ,showOtherMonths: true //??? ????????? ???????????? ???????????? ????????? ??????
                ,showMonthAfterYear:true //?????? ?????? ?????????, ?????? ??? ??????
                ,changeYear: true //?????????????????? ??? ?????? ??????
                ,changeMonth: true //?????????????????? ??? ?????? ??????                
                ,yearSuffix: "???" //????????? ?????? ?????? ?????? ?????? ?????????
                ,monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'] //????????? ??? ?????? ?????????
                ,monthNames: ['1???','2???','3???','4???','5???','6???','7???','8???','9???','10???','11???','12???'] //????????? ??? ?????? Tooltip ?????????
                ,dayNamesMin: ['???','???','???','???','???','???','???'] //????????? ?????? ?????? ?????????
                ,dayNames: ['?????????','?????????','?????????','?????????','?????????','?????????','?????????'] //????????? ?????? ?????? Tooltip ?????????
                ,minDate: "-1M" //?????? ????????????(-1D:?????????, -1M:?????????, -1Y:?????????)
                ,maxDate: "+1M" //?????? ????????????(+1D:?????????, -1M:?????????, -1Y:?????????)                    
            });
 
            //input??? datepicker??? ??????
            $("#datepicker_start").datepicker();                    
            $("#datepicker_end").datepicker();
            //To??? ???????????? ????????? ??????
            $('#datepicker_end').datepicker('setDate', 'today'); //(-1D:?????????, -1M:?????????, -1Y:?????????), (+1D:?????????, -1M:?????????, -1Y:?????????)
        });



//????????? ??????
var dialog, form;

dialog = $( "#dialog-form" ).dialog({
        autoOpen: false,
        height: 800,
        width: 1000,
        modal: true,
        buttons: {
            
			Submit: function() {

							var name			= $("input[name=wname]").val();
							var title			= $("input[name=wtitle]").val();
							var upload_file		= $("input[name=wupload_file]")[0].files[0];
							var content			= $("#summernote").val();

						$("input[name=wnotice]:checked").each(function() {
							var notice = $(this).val();

							add_write(name, title, content, notice, upload_file)

						});
			},

            Cancel: function() {
            dialog.dialog( "close" );
            }
        },
        close: function() {
            //form[ 0 ].reset();
            //allFields.removeClass( "ui-state-error" );
        }
});//dialog end





function writePopup(formData) {
	
console.log("writePopup : " + formData);

        $.ajax({
            url : "/index.php/plugin/write/ajaxPopup",
            method : "POST",
			data : formData,
			dataType : "text",
			contentType : false,
			processData: false,
            success :function(data) {

                console.log('?????? : ' + data);

					if(data == "200") 
					{
						alert("?????????????????????.");
						location.replace("/index.php/ajax")
					} 
					else {
						alert("????????????");
					}
			
                        
            }
            , error : function (request, status, error) {
                    console.log('error ?????? : ' + request + '   ' + status + '   ' + error);

            }

        }); //ajax end


} //writePopup end



//???????????? ??? ????????? ????????? 
function add_write(name, title, content, notice, upload_file) {

		var arr		= [name, title, content];
		var arr2	= ['??????', '??????', '??????'];

		for(i=0; i<=arr.length; i++)
		{
			if(arr[i] == '')
			{
				alert(arr2[i] + '???(???) ??????????????????.');
				return false;
			}
		}

		let formData = new FormData();
		
		formData.append("name",         name);
		formData.append("title",        title);
		formData.append("content",      content);
		formData.append("notice",       notice);

		if(upload_file) {
			formData.append("upload_file",  upload_file);
		}

		writePopup(formData);


}




//dataTables list
var board_list;

$(function() {

	function Lists(list) {
			this.idx		= list.idx;
			this.title		= list.title;
			this.name		= list.name;
			this.content	= list.content;
			this.regdate	= list.regdate;
			this.cnt		= list.cnt;

	}

	board_list = $("#board_list").DataTable({
		"dom" : 't<"pagination"p>r',
        "info" : false,
        "filter" : false,
        "paging" : true,
        "pagingType" : "full_numbers_no_ellipses",
        "language" :{
            "paginate" : {
                "first" : "<i class=\"fa fa-angle-double-left\"></i>",
                "last" : "<i class=\"fa fa-angle-double-right\">",
                "previous" : "<i class=\"fa fa-angle-left\">",
                "next" : "<i class=\"fa fa-angle-right\">"
            },
            "processing" : "<div style='position:absolute;left:50%;top:50%;z-index:999999;transform: translate(-50%, -50%);'><img src='/asset/adminsin/images/indicator_white_2.gif' border='0' alt=''/></div>",
            "emptyTable" : "???????????? ???????????? ????????????.",
            "zeroRecords" : "???????????? ???????????? ????????????.",
        },

        "processing" : true,
        "serverSide" : true,	
		"ajax": function(data, callback, settings) {

			var search  = $("#search_frm").serialize(); 
			var params  = {
							//page	:	this.api().page(),
							page    :   $("#board_list").DataTable().page.info().page + 1,
							search  :   search
					    	}
			return $.ajax({

				url: "/plugin/home/pluginList",
				type: "POST",
				data: params,
				dataType: "json",
				contentType : 'application/x-www-form-urlencoded; charset=euc-kr json',
				success: function(res) {
					//var json = JSON.parse(res);

					var result = {
									draw: res.draw,
									data: res.list, //?????? ????????? ?????????
									notice : res.notice_list, //???????????? ?????????
									recordsTotal : res.total,
									recordsFiltered : res.total
								};

					callback(result);

					$("#recordsTotal").text(res.total);

				}
			});

		},
            "columns" : 
			[
                //{"data" : null, "render" : function (data, type, full, meta) { return meta.row + 1 ; } },
                {"data" : "index"},
                {"data" : null, "render": function(data, type, row, meta) {
													return  '<a href="index.php/plugin/content/'+ row.idx +'">' + row.title + '</a>' + row.new;	
											}
				},
                {"data" : "name"},
                {"data" : "regdate"},     
                {"data" : "cnt"}
            ]
        

	});



});




</script>
