<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
  use HasFactory;
	protected $table = 'companies';

	protected $primaryKey = 'id';

	protected $fillable = ["name","image_path","location","industry","user_id"];

	protected $hidden = ['created_at','updated_at'];


  /**
   * @return  mixed
  */
  public function user(): BelongsTo
  {
      return $this->belongsTo(User::class);
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
