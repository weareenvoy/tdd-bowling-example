<?php

/**
 * Class BowlingGame
 */
class BowlingGame
{
    /**
     * @var array
     */
    private $rolls = [];

    /**
     * @param int $pins
     */
    public function roll(int $pins)
    {
        $this->rolls[] = $pins;
    }

    /**
     * @return int
     */
    public function score(): int
    {
        $score = 0;

        for ($frameIndex = 0, $i = 0; $frameIndex < 10; $frameIndex++) {
            if (10 === $this->rolls[$i]) {
                $score += 10 + $this->rolls[$i + 1] + $this->rolls[$i + 2];
                $i += 1;
            } elseif ($this->isFrameSpare($i)) {
                $score += $this->scoreSpareFrame($i);
                $i += 2;
            } else {
                $score += $this->scoreFrame($i);
                $i += 2;
            }
        }

        return $score;
    }

    /**
     * @param int $rollIndex
     *
     * @return int
     */
    private function scoreFrame(int $rollIndex): int
    {
        return $this->rolls[$rollIndex] + $this->rolls[$rollIndex + 1];
    }

    /**
     * @param int $rollIndex
     *
     * @return int
     */
    private function scoreSpareFrame(int $rollIndex): int
    {
        return 10 + $this->rolls[$rollIndex + 2];
    }

    /**
     * @param int $rollIndex
     *
     * @return bool
     */
    private function isFrameSpare(int $rollIndex): bool
    {
        return 10 === $this->scoreFrame($rollIndex);
    }
}
