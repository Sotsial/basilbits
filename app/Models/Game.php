<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'price',
        'on_request',
        'title_image',
        'screenshots',
        'platform',
        'earnings',
        'age',
        'installs',
        'monetization',
        'attachments',
        'financials',
        'description',
        'link',
        'payment_methods',
        'seller_id',
        'video_link',
        'specials',
        'user_id',
    ];
    
    /**
     * Get the user that owns the game.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the seller associated with the game.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
    
    /**
     * Get the screenshots as an array.
     */
    public function getScreenshotsArrayAttribute()
    {
        return $this->screenshots ? json_decode($this->screenshots, true) : [];
    }
    
    /**
     * Get the monetization methods as an array.
     */
    public function getMonetizationArrayAttribute()
    {
        return $this->monetization ? json_decode($this->monetization, true) : [];
    }
    
    /**
     * Get the payment methods as an array.
     */
    public function getPaymentMethodsArrayAttribute()
    {
        return $this->payment_methods ? json_decode($this->payment_methods, true) : [];
    }
    
    /**
     * Get the specials as an array.
     */
    public function getSpecialsArrayAttribute()
    {
        return $this->specials ? json_decode($this->specials, true) : [];
    }
}
