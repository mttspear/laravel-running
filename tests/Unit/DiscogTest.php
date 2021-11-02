<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Helpers\Discog\Discog;

class DiscogTest extends TestCase
{
    /**
     * Test the get song api
     *
     * @return void
     */
    public function test_getSong()
    {
        $discog = new Discog();
        $discogResults = $discog->getSong(
            "Shine on you crazy diamond",
            "pink floyd"
        );

        $this->assertTrue(isset($discogResults["tracklist"]));
        $this->assertTrue(isset($discogResults["tracklist"][0]["title"]));
    }
}
