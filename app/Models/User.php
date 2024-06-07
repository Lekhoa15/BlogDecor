<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Support\Str;
use App\Traits\ModelHelpers;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use function Illuminate\Events\queueable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Billable;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use ModelHelpers;

    const DEFAULT = 1;
    const MODERATOR = 2;
    const WRITER = 3;
    const ADMIN = 4;
    const SUPERADMIN = 5;

    const TABLE = 'users';

    protected $table = self::TABLE;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'slug',
        'password',
        'type',
        'line1',
        'line2',
        'city',
        'state',
        'profile_photo_path',
        'country',
        'postal_code',
    ];

    protected $with = [
        'subscriptions',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'trial_ends_at'     => 'datetime'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
            ? Storage::disk($this->profilePhotoDisk())->url('public/' . $this->profile_photo_path)
            : $this->defaultProfilePhotoUrl();
    }

    public function getRoutekeyName()
    {
        return 'slug';
    }

    public function getUserId(): int
    {
        return $this->id;
    }


    public function name(): string
    {
        return $this->name;
    }

    public function emailAddress(): string
    {
        return $this->email;
    }

    public function lineOne(): ?string
    {
        return $this->line1;
    }

    public function lineTwo(): ?string
    {
        return $this->line2;
    }

    public function city(): ?string
    {
        return $this->attributes['city'] ?? null;
    }

    public function getCountryAttribute(): ?string
    {
        return $this->attributes['country'] ?? null;
    }
    public function country(): ?string
{
    return $this->attributes['country'] ?? null;
}


    public function postalCode(): ?string
    {
        return $this->postal_code;
    }

    public function type(): int
    {
        return (int) $this->type;
    }

    // Social
    public function bioProfile()
{
    if ($this->profile) {
        return $this->profile->bio();
    } else {
        return "No bio available";
    }
}

    public function bioProfileExcerpt($limit = 80)
    {
        return Str::limit($this->bioProfile(), $limit);
    }

    public function facebookProfile()
    {
        // Kiểm tra xem biến $profile có tồn tại và không null
        if ($this->profile) {
            // Gọi phương thức facebook() trên biến $profile
            return $this->profile->facebook();
        } else {
            // Trả về một giá trị mặc định nếu biến $profile là null
            return "No Facebook profile available";
        }
    }


    public function twitterProfile()
    {
        if ($this->profile) {

            return $this->profile->twitter();
        } else {

            return "No twitter profile available";
        }
    }

    public function instagramProfile()
    {
        if ($this->profile) {

            return $this->profile->instagram();
        } else {

            return "No instagram profile available";
        }
    }

    public function linkedInProfile()
    {
        if ($this->profile) {

            return $this->profile->linkedIn();
        } else {

            return "No linkedIn profile available";
        }

    }

    // Type
    public function isDefault(): bool
    {
        return $this->type() === self::DEFAULT;
    }

    public function isModerator(): bool
    {
        return $this->type() === self::MODERATOR;
    }

    public function isWriter(): bool
    {
        return $this->type() === self::WRITER;
    }

    public function isAdmin(): bool
    {
        return $this->type() === self::ADMIN;
    }

    public function isSuperAdmin(): bool
    {
        return $this->type() === self::SUPERADMIN;
    }

    // Profile Relations
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function joinedDate()
    {
        return $this->created_at->format('d/m/Y');
    }

    public function posts()
    {
        return $this->postsRelation;
    }

    public function postsRelation(): HasMany
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    protected static function booted()
    {
        static::updated(queueable(function ($customer) {
            $customer->syncStripeCustomerDetails();
        }));
    }
    public function state(): ?string
    {
        return $this->attributes['state'] ?? null;
    }





public function stripeAddress()
{
    return [
        'line1'         => $this->lineOne(),
        'line2'         => $this->lineTwo(),
        'city'          => $this->city(),
        'state'         => $this->state,
        'country'       => $this->getCountryAttribute(), // Access using the accessor method
        'postal_code'   => $this->postalCode(),
    ];
}

}
