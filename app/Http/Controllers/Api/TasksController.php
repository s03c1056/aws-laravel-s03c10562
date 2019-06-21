<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Task;
use Validator;
use Auth;
use App\Http\Controllers\Controller;


class TasksController extends Controller
{
   //クラスが呼ばれたら最初に実行する処理
   public function __construct(){
       $this->middleware('auth');
   }
   //登録処理関数
   public function store(Request $request) {
   //バリデーション
   $validator = Validator::make($request->all(), [
       'task' => 'required|max:255',
       'deadline' => 'required'
   ]);
   //バリデーション:エラー
   if ($validator->fails()) {
       return redirect('/')
           ->withInput()
           ->withErrors($validator);
   }
   // Eloquentモデル
   $task = new Task;
   $task->task = $request->task;
   $task->user_id = Auth::user()->id;
   $task->deadline = $request->deadline;
   $task->comment = $request->comment;
   $task->save();
   // 最新のDB情報を取得して返す
   $tasks = Task::where('user_id',Auth::user()->id)
               ->orderBy('deadline', 'asc')
               ->get();
   return $tasks;
   }

   //表示処理関数
   public function index() {
   $tasks = Task::where('user_id',Auth::user()->id)
               ->orderBy('deadline', 'asc')
               ->get();
   return $tasks;
   }

   //更新画面表示関数
   public function edit($task_id) {
   $task = Task::where('user_id',Auth::user()->id)->find($task_id);
   return view('tasksedit', ['task' => $task]);
   }

   //更新処理関数
   public function update(Request $request) {
   //バリデーション
   $validator = Validator::make($request->all(), [
       'id' => 'required',
       'task' => 'required|max:255',
       'deadline' => 'required'
   ]);
   //バリデーション:エラー
   if ($validator->fails()) {
       return redirect('/')
           ->withInput()
           ->withErrors($validator);
   }
   //データ更新処理
   $task = Task::where('user_id',Auth::user()->id)
               ->find($request->id);
   $task->task   = $request->task;
   $task->deadline = $request->deadline;
   $task->comment = $request->comment;
   $task->save();
   return redirect('/');
   }

   //削除処理関数
   public function destroy($task_id) {
   $task = Task::where('user_id',Auth::user()->id)->find($task_id);
   $task->delete();
   // 最新のDB情報を取得して返す
   $tasks = Task::where('user_id',Auth::user()->id)
   ->orderBy('deadline', 'asc')
   ->get();
   return $tasks;
   }
   
   //api画面表示用関数
   public function api_ajax() {
   return view('api_ajax');
   }
}
