<?php

namespace App\Api\V1\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TalkProposalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'abstract' => $this->resource->abstract,
            'preferred_time_slot' => $this->resource->preferred_time_slot,
            'speaker' => new SpeakerResource($this->resource->speaker),
            'created_at' => $this->resource->created_at,
        ];
    }
}
