<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Task extends Model
{
    protected $fillable = ['content','status', 'user_id'];
    public function user()
    {
        // タスクはuserに所属している
        return $this->belongsTo(User::class);
    }
}
