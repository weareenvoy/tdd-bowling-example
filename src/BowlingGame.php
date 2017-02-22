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

        for ($frameIndex = 0, $i = 0; $frameIndex < 10; $frameIndex++, $i += 2) {
            if ($this->isFrameSpare($i)) {
                $score += $this->scoreSpareFrame($i);
            } else {
                $score += $this->scoreFrame($i);
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
