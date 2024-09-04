<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Constants\FileConstants;
use App\Traits\Models\UserRelations;
use App\Traits\ModelTrait;
use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticated;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Translatable\HasTranslations;
use Omniax\basement_chatBot\Contracts\User as BasementUserContract;
use Omniax\basement_chatBot\Traits\HasPrivateMessages;
class User extends Authenticated implements BasementUserContract
{
    use HasFactory,HasPrivateMessages,HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'phone'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token',];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
 
     public function getNameAttribute(): string
    {
        return str($this->attributes['name'])->explode(' ')->last();
    }

    public function getAvatarAttribute(): string
    {
        return $this->attributes['image_url'];
    }
   
}
