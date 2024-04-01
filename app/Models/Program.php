<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Program extends Model
{
  use HasFactory;
	protected $table = 'programs';

	protected $primaryKey = 'id';

	protected $fillable = ["title","description","start_date","end_date","user_id"];

	protected $hidden = ['created_at','updated_at'];

  /**
   * @return  mixed
  */
  public function program_participant(): HasMany
  {
      return $this->hasMany(ProgramParticipant::class);
  }


  /**
   * @return  mixed
  */
  public function user(): BelongsTo
  {
      return $this->belongsTo(User::class);
  }

  //Method for Seeders and Tests
  public static function getRandomId()
  {
      return self::inRandomOrder()->value('id');
  }
}
