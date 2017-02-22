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
        $score = 0;

        for ($frameIndex = 0, $i = 0; $frameIndex < 10; $frameIndex++, $i += 2) {
            if (10 === $this->rolls[$i] + $this->rolls[$i + 1]) {
                $score += 10 + $this->rolls[$i + 2];
            } else {
                $score += $this->rolls[$i] + $this->rolls[$i + 1];
            }
        }

        return $score;
    }
}
