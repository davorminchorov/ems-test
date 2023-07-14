<?php

declare(strict_types=1);

namespace Tests\Feature\TalkProposalSubmission;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class TalkProposalSubmissionTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
