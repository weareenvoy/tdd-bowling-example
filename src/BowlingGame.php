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
            if ($this->isFrameStrike($i)) {
                $score += $this->scoreStrikeFrame($i);
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
     * @return int
     */
    private function scoreStrikeFrame(int $rollIndex): int
    {
        return 10 + $this->rolls[$rollIndex + 1] + $this->rolls[$rollIndex + 2];
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

    /**
     * @param int $rollIndex
     *
     * @return bool
     */
    private function isFrameStrike(int $rollIndex): bool
    {
        return 10 === $this->rolls[$rollIndex];
    }
}
