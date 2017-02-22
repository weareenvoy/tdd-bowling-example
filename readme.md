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

Hmm... what went wrong here? Turns out the problem here is that our code in `BowlingGame::score()` was a bit **too** simple to be true. Rats. Fine, what are our other options to make this work while not breaking the previous test?

What if we create an instance variable on the class? Let’s add a private instance variable `$score` to `BowlingGame`, add all of the pins to `$score` when `BowlingGame::roll()` is called, and return `$score` from `BowlingGame::score()`.

It’s passing now!

#### Interlude #1 -- Refactoring!

Follow along with the code completely by following the commits in `refactor/part-1`.

Since we’ve gone through 2 tests, we can visit the **Refactor** step of Red-Green-Refactor and determine what, if anything, we want to do.

There are a few things we can look at to want to refactor, including but not limited to:

* duplicated code
* complex code
* hard-to-read code

The goal in the **Refactor** step of Red-Green-Refactor is to make your code easier to understand and have a better architecture. Let’s jump into the code and see what we can do.

Well, there is some duplicate code within our tests that may be used in other tests. To promote reusability and extensibility, let’s abstract out the creation of `BowlingGame` to a private function on the test.

Let’s also take those for loops and make them a private function on the test so we can have a more expressive (readable) test.

How do we do that? We want to **always** stay in a Green state. Going into a Red state breaks the loop, as Red only happens after all of the tests are passing. Until you are 110%+ comfortable writing tests, do this step. Keep it green. If you don’t, it will turn into more work than you want it to be.

We approach this in a seemingly backwards fashion. Let’s look at the duplicated creation of a game. First, let’s create a function `createGame` on the test class. Re-run the tests, and confirm everything is green. Update the function so that `createGame` returns a new `BowlingGame` instance. Re-run the tests again, and confirm they’re green. Finally, in one of the tests, replace `new BowlingGame` with `$this->createGame()`, and run them again. Once they come back as green, we can make this change in every other location where we want the code.

Challenge yourself to see if you can make the same thing happen for the looped rolls that are happening (`rollMany` is a pretty good function name,  if you need it). Go through the same steps, confirming every time that every change you make does not make a test turn red.

> Why do we put `rollMany` on the test class instead of in `BowlingGame` itself?
> First, we don’t have a test for it. Second, within our business rules (score a bowling game)
> there is no need for such a function. For the time being it works better as a test helper
> function rather than a function on the instance itself. When you consider a real bowling game,
> is there ever a moment when multiple rolls would be scored at the same time with the same
> number of pins?

> Something else to consider is that all of the refactoring being done here is in the test class
> rather than in the implementation class. This is just fine. If no refactoring needs to happen
> in the implementation class (yet), then there’s no reason to force any refactoring. That will
> surely happen later on in the process.

#### Test #3 -- Scoring a Spare

Follow along with the code completely by following the commits in `test/3-scores-a-spare`.

Until this point the majority of what we’ve done is to cover the more simplistic rules that govern the majority of cases. As long as the player never gets a spare or a strike, we’ll be able to score a game perfectly.

Let’s quickly review how a spare is scored, and once we’re comfortable with the rule, we write up our test.

A spare is
* both rolls in a frame added together equals 10 (all pins in a frame)
* the first roll in the frame is not 10 itself (a strike)

So, a spare could be `1,9`, `8,2`, even `0,10`, etc., but not `10,0`. Let’s write up a test and see how it works.

```php
<?php

class BowlingGameTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function scores_a_spare()
    {
        $game = $this->createGame();
        
        $game->roll(6);
        $game->roll(4);
        $game->roll(4);
        $this->rollMany($game, 17, 0);
        
        self::assertEquals(18, $game->score());
    }
}
```

Great. Now it rolls a spare for the first frame, one extra pin (as this is needed to score the rolls, per the rules), and finishes up with all gutters. Run the test, and see what happens!

```
Failed asserting `14` equals expected `18`.
```

Ok, looks like what we currently have written isn’t covering how a spare is scored. Let’s visit the `BowlingGame::score()` function and see what we can do to resolve that.

Right now `BowlingGame::score()` is simply returning a predefined value. What we really need to do is to determine the value of each frame with relation to the following frames to score spares correctly. As the code stands currently, we aren’t handling anything with consideration to frames. Uh-oh!

At this point we need to refactor a bit. This is different from the Refactor step from Red-Green-Refactor because we are no longer in the **Green** state. What we want to do here is to remove this breaking test from the suite temporarily, so we’re back to **Green**, and then do a refactor, then bring the test back.

In PHPUnit skipping a test is as simple as removing the `@test` annotation.

Let’s first do a refactor to switch from having a `$score` field on `BowlingGame` and instead let’s store every roll that happens in a game. This wil let us reference the rolls when we calculate out the score. As a first guess, and also an easy way to keep our first two tests passing, let’s return the sum of every roll from `BowlingGame::score()`.

First, create the field and make sure your tests pass. Then, update the `roll` function to also drop the value of `$pins` into our new `$rolls` array. Run the tests, and confirm everything is green. Then, in the `score` function, let’s start some real refactoring. Remember, all of these moves need to make sure the tests stay green!

Make sure to add back the `@test` annotation!

As expected, the first two tests pass, and the new one fails.

Great, now let’s rework `BowlingGame::score()` to calculate out the game on the fly.

The basic logic here is as follows:

    foreach frame
        if the sum of both rolls equals 10
            increment $score by 10 + the next roll
        else
            increment $score by both rolls

In trying to implement this logic, we’ll quickly come to realize that we need two index variables, one for the current frame and one for the current roll. Once it’s implemented, run the tests!

We’ve got a passing test suite!

#### Interlude #2 -- Refactoring!

Follow along with the code completely by following the commits in `refactor/part-2`.

Back to a refactoring section! Remembering what we learned previously about refactoring, let’s get to it!

We’ve got some duplicated code around scoring a frame, in that it’s the same in the spare check expression as well as scoring a frame itself.

Another thing we can do within our refactoring step here is to make the code more readable by extracting our spare check expression. We can pull out the expression within the `if` statement we put into `BowlingGame::score()` to make it easier to read. Put that expression into a `BowlingGame::isFrameSpare()` private method so we don’t have to concern ourselves with how a spare is determined.

One last refactor for readability will be to pull out the scoring of a frame with a spare. The only goal for this is to make it easier to read the `BowlingGame::score()` function, as it’s much easier to skim through. The details of how a spare frame is scored do not need to muddy the waters.

If everything went well, all of the tests still pass.
