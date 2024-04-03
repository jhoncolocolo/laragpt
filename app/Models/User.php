<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
      use HasApiTokens, HasFactory, Notifiable;

      protected $table = 'users';

      protected $primaryKey = 'id';

      protected $fillable = ["name","email","image_path"];

      protected $hidden = ['created_at','updated_at'];


    /**
     * @return  mixed
     */
    public function challenge(): HasMany
    {
        return $this->hasMany(Challenge::class);
    }

    /**
     * @return  mixed
     */
    public function company(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    /**
     * @return  mixed
     */
    public function program(): HasMany
    {
        return $this->hasMany(Program::class);
    }

    //Morph Relation
    public  function programParticipant(){
        return $this->morphOne(ProgramParticipant::class,'entitiable');
    }

    //Method for Seeders and Tests
    public static function getRandomId()
    {
        return self::inRandomOrder()->value('id');
    }
}
