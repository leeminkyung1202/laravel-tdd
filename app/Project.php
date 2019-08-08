<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function path ()
    {
        return "/projects/{$this->id}";
    }

    public function owner ()
    {
        // user 테이블에서 내가 로그인 한 id 를 owner_id 컬럼의 조건으로 줘서 내가 작성 한 글을 가져온다.
        return $this->belongsTo(User::class);
    }
}
