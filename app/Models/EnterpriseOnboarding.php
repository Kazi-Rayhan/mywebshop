<?php

namespace App\Models;

use Iziibuy;
use App\Models\Traits\HasMeta;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnterpriseOnboarding extends Model
{
    use HasFactory, HasMeta;


    protected $casts = ['last_paid_at' => 'datetime'];

    protected $meta_attributes = [
        "name",
        // "company_name",
        "logo",
        "cover",
        "contact_email",
        "contact_phone",
        "city",
        "street",
        "post_code",
        'title',
        "card_holder_name",
        "card_number",
        "expiration_month",
        "expiration_year",
        "ccv",
        "contactPerson",
        "businessAddress",
        "comapny_address",
        "ownership",
        "orgNumber",
        "foundationDate",
        "businessDescription",
        "creditCardTurnover",
        "avgTransactionValue",
        "cardHolderPresent",
        "mailPhoneOrder",
        "internet",
        "gender",
        "dob",
        "share",
        "ceo",
        "privateAddress",
        "otherNationality",
        "country",
        "mobileNumber",
        "privateEmail",
        "idNumber",
        "issueDate",
        
        "expiryDate",
        "nationality",
        "bankName",
        "accountHolderName",
        "accountNumber",
        "selectedUserName",
        "preferredUsername",
        "userEmail",
        "userPhoneNumber",
        "fullNameTitle",
        "date",
        "signature",
        "elavon_payment_setup",
        "elavon_details_verified_by_shop",
        "customer_profile",
        "authrized",
        "financial",
        "report",
        'ip_address',
        'date',
        'customerDetails',
        'trading',
        'partner',
        'productId',
        'needKYC',
        "elavon_merchant_alias",
        "elavon_public_key",
        "elavon_secret_key",
    ];

    protected $guarded = [];



    public function establishment_fee(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => $value / 100,
            set: fn (int $value) => $value * 100
        );
    }

    public function subscription()
    {
        return $this->morphOne(Subscription::class, 'subscribable');
    }

    public function getSubscriptionFee()
    {
           return Iziibuy::needToCharge($this->fee);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function companyAddress(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value)
        );
    }

    public function addressFull(): Attribute
    {
        return Attribute::make(get: fn () => $this->company_address->street . ' ' . $this->company_address->zip . ' ' . $this->company_address->city);
    }
}
