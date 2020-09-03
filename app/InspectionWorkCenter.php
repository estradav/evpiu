<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionWorkCenter extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['production_order', 'quantity_inspected', 'conforming_quantity',
        'non_conforming_quantity', 'cause', 'operator_id', 'inspector_id', 'non_compliant_treatment',
        'action', 'observation', 'center'];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inspection_work_centers';


    /**
     * Get inspector user data.
     *
     * @return BelongsTo
     * @var string
     */
    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }


    /**
     * Get operator user data.
     *
     * @return BelongsTo
     * @var string
     */
    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }
}
