<?php

namespace Omniax\X_slot\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Xslot extends Model
{
    use HasFactory;
    protected $table = 'xslots';
    protected $fillable = ['start_time', 'end_time', 'slot_time', 'capacity', 'current_orders', 'date'];

    protected $with = ['bookings'];
    protected $append = ['is_available'];
    public function bookings() : HasMany
    {
        return $this->hasMany(XslotBooking::class);
    }
    // Check if slot is available
    public function isAvailable(): bool
    {
        return $this->current_orders < $this->capacity;
    }

    public function scopeAvailable(){
        return $this->where('current_orders', '<', $this->capacity);
    }
    public function bookSlot(): void
    {
        if ($this->isAvailable()) {
            $this->current_orders++;
            $this->save();
        } else {
            throw new \Exception('Slot is not available');
        }
    }

    public function cancelBooking(): void
    {
        if ($this->current_orders > 0) {
            $this->current_orders--;
            $this->save();
        } else {
            throw new \Exception('No bookings to cancel');
        }
    }
}
