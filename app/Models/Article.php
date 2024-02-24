<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Article extends Model
{
    use HasFactory;

    protected $filllable = ['id','article_title','article_slug','article_short_note','article_body_content','thumbnail_img','user_id','status'];
    
    protected $casts = [
        'publish_date' => 'datetime',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

     /**
     * Get the auther that owns the article.
     */
    public function auther(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
