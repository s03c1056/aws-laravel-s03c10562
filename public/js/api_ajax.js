$(function(){
 // データからhtmlを出力する関数
 function make_dom(data){
 var str = '';
 for (var i=0;i<data.length;i++){
 str += `<tr>
 <td class="table-text">
73 / 78
 ${data[i].task}
 </td>
 <td class="table-text">
 ${data[i].deadline}
 </td>
 <td class="table-text">
 ${data[i].comment}
 </td>
 <td>
 <button type="button" class="btn btn-danger
destroy" id="${data[i].id}">削除</button>
 </td>
 </tr>`;
 }
 return str;
 }
    
    
    
    
function storeData(){
 // 送信先の指定
 var url = '/api/tasks';
 // 入力情報の取得
 var data = {
 task:$('#task').val(),
 deadline:$('#deadline').val(),
 comment:$('#comment').val()
 };
 // データ送信
 $.ajax({
 headers: {
 'Content-Type': 'application/json',
 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
 },
 dataType: 'json',
 url:url,
 type:'POST',
 data:JSON.stringify(data),
 processData: false,
 contentType: false
 })
 .done(function (data) {
 console.log(data);
 console.log('done');
 $('#echo').html(make_dom(data));
 })
 .fail(function (XMLHttpRequest, textStatus, errorThrown) {
 console.log(textStatus);
 console.log('fail');
 })
 .always(function () {
 console.log('post:complete');
 });
}
// 表示する関数
function indexData(){
    const url = '/api';
    $.getJSON(url)
        .done(function (data, textStatus, jqXHR) {
        console.log(data);
        $('#echo').html(make_dom(data));
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.status + textStatus + errorThrown);
        })
        .always(function () {
            console.log('get:complete');
        });
}
// 削除する関数
function deleteData(id){
 // 送信先の指定
 var url = `/api/task/${id}`;
 $.ajax({
 headers: {
 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
 },
 url:url,
 type:'POST',
 processData: false,
 contentType: false
 })
 .done(function (data) {
 console.log(data);
 console.log('done');
 $('#echo').html(make_dom(data));
 })
 .fail(function (XMLHttpRequest, textStatus, errorThrown) {
 console.log(textStatus);
 console.log('fail');
 })
 .always(function () {
 console.log('post:complete');
 });
}


// 読み込み時に実行
indexData();


// 送信ボタンクリック時に登録
$('#submit').on('click',function(){
     if(
         $('#task').val() == '' ||
         $('#deadline').val() == ''
         ){
         alert('taskとdeadlineは入力必須です！')
     }else{
         storeData();
         $('#task').val(''),
         $('#deadline').val(''),
         $('#comment').val('')
         }
     });
     // 削除ボタンクリック時に削除
$('#echo').on('click','.destroy',function(){
     // 削除するタスクのidを取得
     var id = $(this).attr('id');
     deleteData(id);
    });
    
});
