<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $event_id
 * @property int $user_id
 * @property string $promo_code
 * @property float $discount_amount
 * @property int $is_valid
 * @property string $expired_at
 * @property string $created_at
 * @property string $updated_at
 * @property Event $event
 * @property User $user
 */
class PromoCode extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'promo_code';

    /**
     * @var array
     */
    protected $fillable = ['event_id', 'user_id', 'promo_code', 'discount_amount', 'is_valid', 'expired_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo('App\Event', null, 'event_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', null, 'user_id');
    }
}
