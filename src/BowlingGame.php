<?php

class BowlingGame
{
    private $score = 0;

    public function roll(int $pins)
    {
        $this->score += $pins;
    }

    public function score(): int
    {
        return $this->score;
    }
}
