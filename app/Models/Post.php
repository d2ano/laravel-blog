<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $appends = ['teaser','date'];

    protected $fillable = ['title' , 'text' , 'slug' , 'user_id'];

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag','post_tag');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function cover()
    {
        return $this->belongsTo('App\Models\Cover');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }



    //word limiter fo teaser
    public function getTeaserAttribute()
    {
        return Str::words($this->text, '30');
    }



    //create date format
    public function getDateAttribute()
    {
        return date('F j, Y, g:i a', strtotime($this->created_at));    
    }


    /**
	 * Create slug from title before storing to DB
	 *
	 * @param $value
	 */
	public function setTitleAttribute($value)
	{
	 	$this->attributes['title'] = ucfirst( $value );
        $this->attributes['slug']  = Str::of($value)->slug('-');
    }
}
