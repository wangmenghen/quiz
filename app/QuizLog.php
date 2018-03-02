<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizLog extends Model
{
    protected $fillable = ['user_id', 'topics_id', 'is_finish', 'title', 'username'];

    // public function quiz()
    // {
    //     return $this->hasMany(Question::class, 'topic_id')->withTrashed();
    // }
    // public function topic()
    // {
    //     return $this->belongsTo(Topic::class, 'topic_id')->withTrashed();
    // }

    public function topic()
    {
        // return $this->hasMany(QuizLog::class, 'topics_id')->withTrashed();
        return $this->belongsTo('Topic');
    }
}
