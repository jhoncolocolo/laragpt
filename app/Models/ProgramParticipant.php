<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramParticipant extends Model
{
    use HasFactory;

    protected $guarded = [];

	protected $table = 'program_participants';

	protected $primaryKey = 'id';

	protected $fillable = ["program_id","entitiable_type","entitiable_id"];

	protected $hidden = ['created_at','updated_at'];


    /**
     * @return  mixed
    */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function entitiable(){
        return $this->morphTo();
    }
}
