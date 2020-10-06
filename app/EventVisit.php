<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventVisit extends Model
{
    use HasFactory;


    /** The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'start', 'end', 'type', 'nit', 'created_by'
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events_activities';


    /** Devuelve la informacion del usuario que creo la visita
     *
     * @return BelongsTo
     * @var array
     */
    public function user_by() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
