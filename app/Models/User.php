<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\confirmMail;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Profile;
use App\Models\WorkExperiance;
use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Generates a verification token for the user and sends a verification email.
     *
     * The generated token is a random 40 character string.
     *
     * @return void
     */
    public function generateVerificationToken()
    {
        $this->email_verification_token = Str::random(40);
        $this->save();

        // Send email
        $this->sendVerificationEmail();
    }

    /**
     * Sends a verification email to the user.
     *
     * The email is sent using the `VerifyEmail` mailable and contains a link to the verification page.
     * The verification link is constructed by appending the user's email and verification token to
     * the `app.verification_link` config value.
     *
     * @return void
     */
    public function sendVerificationEmail()
    {
        $verificationUrl = config('app.verification_link')."?email=".$this->email."&token=". $this->email_verification_token;
        Mail::to($this->email)->send(new confirmMail($verificationUrl));
    }

    public function apiTokens() {
        return $this->hasMany(ApiToken::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function workExperiances()
    {
        return $this->hasMany(WorkExperiance::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
