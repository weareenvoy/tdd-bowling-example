<?php

use PHPUnit\Framework\TestCase;

class BowlingGameTest extends TestCase
{
    /**
     * @test
     */
    public function scores_all_gutters()
    {
        $game = new BowlingGame;

        for ($i = 0; $i < 20; $i++) {
            $game->roll(0);
        }

        self::assertEquals(0, $game->score());
    }

    /**
     * @test
     */
    public function scores_one_pin()
    {
        $game = new BowlingGame;

        $game->roll(1);
        for ($i = 0; $i < 19; $i++) {
            $game->roll(0);
        }

        self::assertEquals(1, $game->score());
    }
}
