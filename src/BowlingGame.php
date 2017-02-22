<?php

class BowlingGame
{
    private $rolls = [];

    public function roll(int $pins)
    {
        $this->rolls[] = $pins;
    }

    public function score(): int
    {
        return array_sum($this->rolls);
    }
}
