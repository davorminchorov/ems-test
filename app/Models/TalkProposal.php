<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TalkProposal extends Model
{
    use HasFactory;

    protected $table = 'talk_proposals';

    protected $casts = [
        'id' => 'integer',
        'speaker_id' => 'integer',
        'title' => 'string',
        'abstract' => 'string',
        'preferred_time_slot' => 'string',
    ];

    public function speaker(): BelongsTo
    {
        return $this->belongsTo(Speaker::class);
    }

    public static function submit(
        int $speakerId,
        string $title,
        string $abstract,
        string $preferredTimeSlot
    ): self {
        return self::create([
            'speaker_id' => $speakerId,
            'title' => $title,
            'abstract' => $abstract,
            'preferred_time_slot' => $preferredTimeSlot,
        ]);

    }

    public static function paginatedTalkProposalsList(): LengthAwarePaginator
    {
        return self::query()->with(['speaker'])->orderByDesc('preferred_time_slot')->paginate();
    }
}
