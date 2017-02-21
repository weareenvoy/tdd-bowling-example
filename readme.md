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
