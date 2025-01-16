<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Traits\Credits;
use App\Models\Traits\HasMeta;
use App\Models\Traits\IsRetailer;
use App\Services\CreditWallet;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use TCG\Voyager\Contracts\User as UserContract;
use TCG\Voyager\Traits\VoyagerUser;
use Iziibuy;

class User extends Authenticatable implements UserContract
{
    use HasApiTokens, HasMeta, HasFactory, Notifiable, Credits, IsRetailer, VoyagerUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',

    ];

    public const ROLES = [
        'Admin' => 1,
        'User' => 2,
        'Vendor' => 3,
        'Manager' => 4,
        'Retailer' => 5,
        'External' => 6,
        'Enterprise' => 7,
    ];

    protected $meta_attributes = [
        'country',
        'city',
        'address',
        'post_code',
        'state',
        "trainee",
        "self_checkout",
        "level",
        "target",
        "details",
        "sub_title",
        "current_package",
        "current_package_price",
        "personal_trainner",
        "split",
        "view_orders",
    ];

    public $additional_attributes = ['locale', 'emailAndBalance', 'retailerBalance'];
    //Attribute

    public function fullName(): Attribute
    {
        return Attribute::make(get: fn ($value) => $this->attributes['name'] . ' ' . $this->attributes['last_name']);
    }
    public function emailAndBalance(): Attribute
    {
        return Attribute::make(get: fn ($value) => $this->attributes['email'] . ' - ' . Iziibuy::price($this->totalBalance()));
    }
    //Start of Relations
    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function affiliatedShop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function getShop()
    {

        switch ($this->role->name) {
            case 'vendor':
                return $this->shop;
                break;
            case 'manager':
                return $this->affiliatedShop;
                break;
        }
    }
    public function schedules()
    {
        return $this->morphMany(Schedule::class, 'scheduleable');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function retailer()
    {
        return $this->hasOne(RetailerMeta::class, 'user_id');
    }
    public function retailers()
    {
        return $this->hasMany(RetailerMeta::class, 'parent_id');
    }
    //Scopes

    public function scopeManager($query)
    {
        return $query->where('role_id', self::ROLES['Manager']);
    }
    public function scopeCustomer($query)
    {
        return $query->where('role_id', self::ROLES['User']);
    }

    public function paymentMethodAccess()
    {
        return $this->hasOne(PaymentMethodAccess::class);
    }

    public function scopePersonalTrainer($query)
    {
        return $query->whereHas('metas', function ($query) {
            $query->where('column_name', 'trainee')->where('column_value', 1);
        });
    }

    //Helper functions 
    public function getScheduleFor($day)
    {
        $schedule = $this->schedules->where('day', $day)->first();

        if ($schedule) {
            return $schedule;
        };

        return new Schedule;
    }

    public function trainer(Shop $shop)
    {

        return $this->credits->where('shop_id', $shop->id)->first()->trainer ?? null;
    }

    public function level()
    {
        return Level::find($this->level) ?? new Level;
    }

    public function bookingUrl()
    {
        return route('trainer_services.schedule', ['user_name' => request('user_name'), 'user' => $this, 'option' =>  $this->getShop()->defaultoption]);
    }


    public function getCredit($shop, $trainer)
    {
        return $this->credits()->where('shop_id', $shop)->where('trainer_id', $trainer)->first();
    }


    public function priceGroups()
    {
        return $this->hasMany(ManagerPriceGroup::class, 'manager_id');
    }

    public function managers()
    {
        return $this->hasManyThrough(User::class, Shop::class);
    }

    public function perosnalTrainer()
    {
        return $this->belongsTo(User::class, 'pt_trainer_id');
    }
    public function myPackage()
    {
        return $this->belongsTo(Package::class, 'pt_package_id')->withDefault();
    }


    public function subtractCredits($shop, $trainer, $credits)
    {
        $credit = $this->getCredit($shop->id, $trainer);

        $creditH = $this->current_credit($shop->id, $trainer, $credits);
        if ($credit->credits >= $credits) {
            $credit->decrement('credits', $credits);
            $creditH->decrement('credits', $credits);
            return 'credit';
        } elseif ($credit->admin_free_credits >= $credits) {
            $credit->decrement('admin_free_credits', $credits);
            return 'admin_credit';
        } elseif ($credit->free_credit >= $credits) {
            $credit->decrement('free_credit', $credits);
            return 'manager_credit';
        } else {
            throw new Exception('Not enough credit');
        }
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'user_product')->withPivot('shop_id');
    }

    public function sentMessages($receiver = null)
    {
        if ($receiver) {
            return $this->hasMany(Message::class, 'sender', 'id')->where('receiver', $receiver->id);
        }
        return $this->hasMany(Message::class, 'sender', 'id');
    }

    public function recivedMessages($sender = null)
    {
        if ($sender) {
            return $this->hasMany(Message::class, 'receiver', 'id')->where('sender', $sender->id);
        }
        return $this->hasMany(Message::class, 'receiver', 'id');
    }
    public function customerCredits()
    {
        return $this->hasMany(Credit::class, 'trainer_id');
    }

    public function credithistories()
    {
        return $this->hasMany(CreditHistory::class, 'user_id', 'id');
    }

    public function customerCreditHistories()
    {
        return $this->hasMany(CreditHistory::class, 'manager_id', 'id');
    }
    public function getCredits($shop, $trainer)
    {

        $wallet = $this->credits()->where('shop_id', $shop)->where('trainer_id', $trainer)->first();

        if ($wallet) {
            return $wallet->manager_credits + $wallet->admin_credits + $wallet->subscription_credits + $wallet->session_credits;
        } else {
            return 0;
        }
    }

    public function enterpriseOnboarding()
    {
        return $this->hasOne(EnterpriseOnboarding::class);
    }

    public function current_credit($shop, $trainer, $credits)
    {


        return $this->credithistories()->where('shop_id', $shop)
            ->where('manager_id', $trainer)
            ->where('credits', '>=', $credits)
            ->first();
    }
    public function checkIfShippingIsValid(Shipping $shipping)
    {
        if (@$shipping->shop->selling_loctaion_mode == 2) {
            return !in_array($this->country, $shipping->locations);
        }
        return true;
    }

    public function appointment()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    public function provideServiceOnline(): Attribute
    {
        return Attribute::make(get: fn () => in_array('online', (array) json_decode($this->service_type)));
    }

    public function provideServiceOffline(): Attribute
    {
        return Attribute::make(get: fn () => in_array('offline', (array) json_decode($this->service_type)));
    }

    public function provideServiceDefault(): Attribute
    {
        return Attribute::make(get: fn () => in_array('default', (array) json_decode($this->service_type)));
    }

    public function provideServiceAll(): Attribute
    {
        return Attribute::make(get: fn () => $this->provideServiceDefault && $this->provideServiceOffline && $this->provideServiceOnline);
    }


    public function scopeIsRetailer($query)
    {
        return  $query->where('role_id', 5)->whereHas('retailer', function ($query) {
            $query->where('status', 1);
        });
    }

    public function scopeParentRetailer($query)
    {
        return $query->isRetailer()->whereHas('retailer', function ($q) {
            $q->whereNull('parent_id');
        });
    }

    // protected static function booted(): void
    // {
    //     static::addGlobalScope('metas', function (Builder $builder) {
    //         $builder->with(['shop']);
    //     });
    // }



    public function getAvatarAttribute($value)
    {
        return $value ?? config('voyager.user.default_avatar', 'users/default.png');
    }

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function setSettingsAttribute($value)
    {
        $this->attributes['settings'] = $value ? $value->toJson() : json_encode([]);
    }

    public function getSettingsAttribute($value)
    {
        return collect(json_decode((string)$value));
    }

    public function setLocaleAttribute($value)
    {
        $this->settings = $this->settings->merge(['locale' => $value]);
    }

    public function getLocaleAttribute()
    {
        return $this->settings->get('locale');
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
