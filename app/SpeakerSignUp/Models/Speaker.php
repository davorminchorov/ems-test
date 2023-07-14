<?php

namespace App\SpeakerSignUp\Models;

use App\Models\UserAuthentication;
use App\SpeakerSignUp\Events\SpeakerSignedUp;
use Database\Factories\SpeakerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Speaker extends Model
{
    use HasFactory;

    protected $table = 'speakers';

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'bio' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserAuthentication::class, 'user_id', 'id');
    }

    protected static function newFactory(): SpeakerFactory
    {
        return new SpeakerFactory();
    }

    public static function signUp(int $userId, string $name, string $email, string $bio): self
    {
        $speaker = self::create([
            'user_id' => $userId,
            'name' => $name,
            'email' => $email,
            'bio' => $bio,
        ]);

        self::$dispatcher->dispatch(SpeakerSignedUp::class);

        return $speaker;
    }
}
