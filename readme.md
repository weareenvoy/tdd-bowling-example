## Bowling Game Kata

The bowling game kata is one of many quick "TDD stretches" that can help you get into the rhythm of doing TDD. It’s usually used as one of a few exercises prior to starting the “real” development work.

### Tech Used
**Technology, Techniques, etc.**

* PHP
* [PHPUnit 6.0](https://github.com/sebastianbergmann/phpunit)


* Red-Green-Refactor

[Read More](https://en.wikipedia.org/wiki/Test-driven_development)

### Description of each step in the process

Scoring a bowling game is a set of a few simple rules, as follows:

* Each player gets 10 frames of two throws each.
* The last frame adds an extra throw if the first two throws are a spare or include a strike.
* 1 pin === 1 point
* A spare is 10 pins down in 1 frame over 2 throws. Its score is determined as 10 pins plus the next throw.
* A strike is 10 pins down in the first throw in 1 frame. Its score is determined as 10 pins plus the next two throws.

Looking at these steps, a few things here don’t really matter within the context of scoring (and this kata).

1. the number of throws in a game
2. whether or not the last frame is 2 or 3 throws

These are inconsequential because they would be, for the most part, handled by a different portion of the system. For the purposes of scoring a game in this kata, an external source (the test) will define those steps.

Each test follows an **Arrange**, **Act**, **Assert** pattern. This fits within a **White Box Testing** methodology where we identify the current state of the test (**Arrange**), run a specific set of actions within that world (**Act**), and confirm that everything is as expected after the actions are complete (**Assert**).

#### Test #1 -- Scoring All Gutters

Follow along with the code completely by following the commits in `test/1-scores-all-gutters`.

This test is, in a real game of bowling, a pretty unrealistic case, but it’s a pretty important part of scoring the game. This test helps us set up our necessary class and functions (though any other test could do that for us).

```php
<?php

class BowlingGameTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function scores_all_gutters()
    {
        // Arrange
        $game = new BowlingGame;
        
        // Act
        for ($i = 0; $i < 20; $i++) {
            $game->roll(0);
        }
        
        // Assert
        self::assertEquals(0, $game->score());
    }
}
```

In non-code terms, we create a game, roll 20 gutters (2 throws over 10 frames), and confirm that the resulting score is 0. Let’s run the test now.

```
Error: Class 'BowlingGame' not found
```

Our one test is Red, so we’re starting off the Red-Green-Refactor process at the right spot. Create the `BowlingGame` class and run the test again.

> Remember: only write the minimum code necessary to achieve your test’s goals! The idea is to write only the code necessary to pass the tests.
> Once the test passes, it can be refactored, which is coming up!

```
Method not found: BowlingGame::roll
```

Still red! Looks like there’s more for us to do here.

Add the `BowlingGame::roll(int)` method (empty), and run it again.

```
Method not found: BowlingGame::score
```

Still red, add the `BowlingGame::score()` method (empty), and run it again.

At this point our one test is coming up green. Great!

> Note: Ok, so you may have noticed the weirdness here with the fact that both `BowlingGame::roll` and `BowlingGame::score` are empty.
> `\PHPUnit\Framework\TestCase::assertEquals` does not do a type check, and so `null` is coerced into `0`. Don’t like that?
> You might like `\PHPUnit\Framework\TestCase::assertSame` instead, as it does a type check as well as a value check.
> For the purposes of this kata, it won’t cause enough of an issue to make a difference, as we’ll show with the next tests.

#### Test #2 -- Scoring One Pin

Follow along with the code completely by following the commits in `test/2-scores-one-pin`.

Alright, now we’re at the meat of the kata. Scoring one pin!

```php
<?php

class BowlingGameTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function scores_one_pin()
    {
        // Arrange
        $game = new BowlingGame;
        
        // Act
        $game->roll(1);
        for ($i = 0; $i < 19; $i++) {
            $game->roll(0);
        }
        
        self::assertEquals(1, $game->score());
    }
}
```

This is pretty similar to the first test. The only difference here is that we roll 1 pin for the first roll and follow it up with 19 gutters (to equal 20 rolls in the game).

If we run the tests now, we get the following error:

```
Failed asserting null equals expected 1.
```

Time to look at `BowlingGame` and see what’s going on! As you already know, both functions within `BowlingGame` are empty, so of course the test is failing. Let’s look at what we can do to make this test pass.

The first thought is to simply add `return 1;` from `BowlingGame::score()`. It meets all of our requirements: simple and makes the test pass. Try it and let’s run `scores_one_pin()`.

It passes! Fantastic. If we run our full test suite, we get the following:

```
Failed asserting `1` equals expected `0`.
```

Hmm... what went wrong here?
