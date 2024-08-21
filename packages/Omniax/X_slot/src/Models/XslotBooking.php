<?php 

namespace Omniax\X_slot\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class XslotBooking extends Model
{
    protected $table = 'xslot_bookings';
    protected $fillable = [
        'xslot_id',
        'delivary_id',
    ];

    public function xslot(): BelongsTo
    {
        return $this->belongsTo(Xslot::class);
    }
}

