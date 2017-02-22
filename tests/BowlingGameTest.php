<?php

use PHPUnit\Framework\TestCase;

class BowlingGameTest extends TestCase
{
    /**
     * @test
     */
    public function scores_all_gutters()
    {
        $game = $this->createGame();

        $this->rollMany($game, 20, 0);

        self::assertEquals(0, $game->score());
    }

    /**
     * @test
     */
    public function scores_one_pin()
    {
        $game = $this->createGame();

        $game->roll(1);
        $this->rollMany($game, 19, 0);

        self::assertEquals(1, $game->score());
    }

    /**
     * @return BowlingGame
     */
    private function createGame(): BowlingGame
    {
        return new BowlingGame;
    }

    /**
     * @param BowlingGame $game
     * @param int         $count
     * @param int         $pins
     */
    private function rollMany(BowlingGame $game, int $count, int $pins)
    {
        for ($i = 0; $i < $count; $i++) {
            $game->roll($pins);
        }
    }
}
