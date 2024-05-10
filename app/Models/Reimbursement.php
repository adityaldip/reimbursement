<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reimbursement extends Model
{
    protected $table = 'reimbursement';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'file',
        'status',
        'keterangan_ditolak',
        'from_user',
        'to_user',
        'tanggal'
    ];

    public function history(): HasMany
    {
        return $this->hasMany(ReimbursementHistory::class, 'id_reimbursement','id');
    }
}
