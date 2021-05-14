<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];
    public function profileImage() {
        $imagePath = ( $this->image ) ? $this->image: 'default';
        return  '/storage/' . $imagePath ;
    }

    // <!-- <div class="pr-5"><strong>{{$user->profle->followers->count()}}</strong>follower</div> -->
    // <!-- <div class="pr-5"><strong>{{$user->profle->following->count()}}</strong>follower</div> -->

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function followers() {
        return $this->belongsToMany(User::class);
    }
}
