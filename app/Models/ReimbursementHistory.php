<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReimbursementHistory extends Model
{
    protected $table = 'reimbursement_history';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'id_reimbursement',
        'user_id',
        'status',
        'deskripsi',
        'user_own'
    ];

    public function reimbursement(): BelongsTo
    {
        return $this->belongsTo(Reimbursement::class, 'id_reimbursement', 'id');
    }


}
