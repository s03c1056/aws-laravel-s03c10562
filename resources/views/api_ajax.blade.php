@extends('layouts.app')
@section('content')
 <div class="panel-body">
 <form class="form-horizontal" id="api_form">
 {{ csrf_field() }}
 <div class="form-group">
 <!-- タスク名 -->
 <div class="col-sm-6">
 <label for="task" class="col-sm-3 controllabel">Task</label>
 <input type="text" name="task" id="task" class="form-control">
 </div>
 <!-- deadline -->
 <div class="col-sm-6">
 <label for="deadline" class="col-sm-3 controllabel">Deadline</label>
 <input type="date" name="deadline" id="deadline"
class="form-control">
 </div>
 <!-- comment -->
 <div class="col-sm-6">
 <label for="comment" class="col-sm-3 controllabel">Comment</label>
 <input type="text" name="comment" id="comment" class="form-control">
 </div>
 </div>
 <!-- タスク登録ボタン -->
 <div class="form-group">
 <div class="col-sm-offset-3 col-sm-6">
 <button type="button" class="btn btn-default"
id="submit">Save</button>
 </div>
 </div>
 </form>
 <div class="panel panel-default">
 <div class="panel-heading">タスクリスト</div>
 <div class="panel-body">
 <table class="table table-striped task-table">
 <!-- テーブルヘッダ -->
 <thead>
 <th>タスク</th>
 <th>&nbsp;</th>
 </thead>
<!-- テーブル本体 -->
 <tbody id="echo">
 <!--データ出力部分-->
 </tbody>
 </table>
 </div>
 </div>
 </div>
@endsection
