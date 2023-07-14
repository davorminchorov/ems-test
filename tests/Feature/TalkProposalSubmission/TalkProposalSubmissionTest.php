<?php

declare(strict_types=1);

namespace Tests\Feature\TalkProposalSubmission;

use Tests\TestCase;

final class TalkProposalSubmissionTest extends TestCase
{
    /**
     * @test
     */
    public function example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
