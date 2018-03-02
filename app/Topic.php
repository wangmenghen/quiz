<?php
namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Topic
 *
 * @package App
 * @property string $title
*/
class Topic extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'quiz_time', 'start_time'];

    public static function boot()
    {
        parent::boot();

        Topic::observe(new \App\Observers\UserActionsObserver);
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'topic_id')->withTrashed();
    }
}
