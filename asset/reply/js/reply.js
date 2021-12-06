const pid       = $("#comment-pid").val();
const inputBar  = document.querySelector("#comment-input"); 
const inputName = document.querySelector("#comment-name"); 
const rootDiv   = document.querySelector("#comments"); 
const btn       = document.querySelector("#submit"); 
const mainCommentCount = document.querySelector('#count'); 


console.log('pid : ' + pid + ' & co_name : ' + co_name + ' & co_content : ' + co_content + ' & co_date : ' + co_date);
//맨위 댓글 숫자 세는거. 
//타임스템프 만들기 

function generateTime(){ 
    const date = new Date(); 
    const year = date.getFullYear(); 
    const month = date.getMonth(); 
    const wDate = date.getDate(); 
    const hour = date.getHours(); 
    const min = date.getMinutes(); 
    const sec = date.getSeconds(); 
    const time = year+'-'+month+'-'+wDate+' '+hour+':'+min+':'+sec; return time; 
} 


function showComment(currentVal, nameVal, pid) {

       var dataObj          = new Object();
       dataObj['pid']       = pid;
       dataObj['name']      = nameVal;
       dataObj['content']   = currentVal;
       dataObj              = JSON.stringify(dataObj);
       
        
    $.ajax({
        url      : "/index.php/reply/save",
        data		    : { dataObj : dataObj },
        method          : "post",
        cache           : false,
        
        success : function(data) { 

        if(data == '200') { 
            alert("등록되었습니다.");
                location.replace('/index.php/content?id='+pid);

                return true;
            } else {
                alert("오류발생.");
                return false;
            }
      },
      error : function( jqxhr , status , error ){
        console.log( jqxhr , status , error );
      }
  
    }); //ajax end

    
}


    
    //버튼만들기+입력값 전달 
    function pressBtn()
    { 
        const currentVal = inputBar.value; 
        const nameVal  = inputName.value;

        if(!nameVal.length)
        {
            alert("이름을 입력해주세요!!");
        }
        else if(!currentVal.length)
        { 
            alert("댓글을 입력해주세요!!");

         }else{ 
             showComment(currentVal, nameVal, pid); 
             mainCommentCount.innerHTML++; 
             inputBar.value =''; 
        } 
    } 
    
    btn.onclick = pressBtn;

