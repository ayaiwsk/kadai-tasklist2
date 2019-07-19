<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Task;  
// コントローラーの内容を引き継ぐ
class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // もしログインしたら
        if (\Auth::check()) {
            //タスクを全部表示
            // $tasks = Task::all();
            
            // 認証したユーザーで
            $user = \Auth::user();
            // １ページに１０個までタスクを表示する
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
    
            //views/tasksのindex.blade.phpを表示
            return view('tasks.index', [
            'tasks' => $tasks,
        ]);
        
             
        }
        // ログインしてなかったらこれ
        return view('welcome'); 
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //  新規作成の画面表示
    public function create()
    {
        //taskモデルを取得
         $task = new Task;
         //views/tasksのcreate.blade.phpを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     //タスク作成入力時の指示
    public function store(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:191',
        ]);
        //taskモデルを取得
        $task = new Task;
        //入力された「状況」を取得
        $request->user()->tasks()->create([
        'status'=> $request->status,
        //入力された「タスク」を取得
        'content' => $request->content,
         ]);
        //top画面に戻る
        return redirect('/');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     //入力項目チェック画面表示
    public function show($id)
    {
        //Taskモデルから$idのidをもつレコードを1件取得する
        $task = Task::find($id);
        
        if (\Auth::id() === $task->user_id) {
        //show.blade.phpの内容を表示
        return view('tasks.show', [
            'task' => $task,
        ]);
        }
        return redirect('/');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     //編集ページ
    public function edit($id)
    {
        //Taskモデルから$idのidをもつレコードを1件取得する
        $task = Task::find($id);
         
        if (\Auth::id() === $task->user_id) {
        // edit.blade.phpの内容表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
        }
        return redirect('/');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //何かしらの制限します
        $this->validate($request, [
            // 状況の制限（空欄だめ、１０文字以内）
            'status' => 'required|max:10',
            // タスクの制限（空欄だめ、文字以内）
            'content' => 'required|max:191',
            
        ]);
        //Taskモデルから$idのidをもつレコードを1件取得する
        $task = Task::find($id);
        //入力された状況を取得
        $task->status = $request->status;
        //入力されたタスクを取得
        $task->content = $request->content;
        // 保存
        $task->save();
        ////top画面に戻る
        return redirect('/');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     //削除対応
    public function destroy($id)
    {
        //Taskモデルから$idのidをもつレコードを1件取得する
        $task = Task::find($id);
        
        if (\Auth::id() === $task->user_id) {
        //タスクを削除する
        $task->delete();
        }
        //最初の画面に戻る
        return redirect('/');
    }
}