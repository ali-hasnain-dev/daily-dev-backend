<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = ['user_id', 'title', 'url', 'image_url', 'description', 'comment_count', 'vote'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'profile_image', 'user_name', 'email');
    }
}
