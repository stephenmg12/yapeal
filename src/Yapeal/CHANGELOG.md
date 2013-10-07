# CHANGELOG #

## 2013-09-31

### Background

So Yapeal has been around now for about 5 years and like most software it hasn't
aged as well as I would have liked. Considering it was my first try at a real
project using PHP I think it has done well but in many ways it hasn't kept up
and once again I have to choose between continuing with the more legacy code as
is or move to something better while still holding on to the good part that exist.
Some backwards compatibility would be good as well to make migration by the
existing user base easier.

### Needed Changes

  * Better use of existing standards. Standards like [PSR-0][] etc need to be
  used as they make both Yapeal developer, and the developers that are using
  Yapeal, lives easier.
  * Use [Composer][] for dependence management and installation.
  * Replace ADOdb. **It must die!**
  * Make better or find better wrapper for cURL.



Through ADOdb does work and without it Yapeal probably would not have got to
where it is now but ADOdb is also legacy code that isn't very well maintained and
does some very questionable things programming wise. It's been update for PHP
5.x but in name only really as at it's heart it'll forever be PHP 4.x. I have
even started couple of other projects to replace it in the past but for varies
reason they never were finished.

The question is what to replace ADOdb with. [Doctrine 2][] is a great project
started by some of the same people that made MDB, MDB2, and some other database
abstraction layers. It is being use by many projects and some common PHP
frameworks like [Symfony 2][] as well.

Though it's not prefect cURL works and works well. It's been around for a long
time and is almost always available to use by developers so using anything else
just doesn't make much sense. That being said I've found it very hard to find
a good OOP wrapper for it as well that has the features Yapeal needs. I'm
currently looking at [Guzzle][] as it seems like it's well written and has the
features Yapeal needs.


[Composer]: http://getcomposer.org/ "Composer - Dependency Manager for PHP"
[Doctrine 2]: http://www.doctrine-project.org/ "Doctrine homepage"
[Guzzle]: http://guzzlephp.org/ "Guzzle homepage"
[PSR-0]: http://www.php-fig.org/ "PHP Framework Interop Group"
[Symfony 2]: http://symfony.com/ "Symfony homepage"

