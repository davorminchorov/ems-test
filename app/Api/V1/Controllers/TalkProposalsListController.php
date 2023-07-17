<?php

declare(strict_types=1);

namespace App\Api\V1\Controllers;

use App\Api\V1\Resources\TalkProposalResource;
use App\Models\TalkProposal;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final readonly class TalkProposalsListController
{
    public function __invoke(): AnonymousResourceCollection
    {
        return TalkProposalResource::collection(TalkProposal::paginatedTalkProposalsList());
    }
}
