# Using Standards #

## Introduction ##

Yapeal has always used many actual standards for all kinds of stuff like using
HTTP to connect to the Eve API servers, and things like XML, XSDs and than the
ones made up just for Yapeal itself if those can really be considered standards.
As the project has progress some standards used have changed or at least been
refined especially the ones made just for Yapeal. Below I will try to list some
of the more visible ones that it already uses or will be soon.

### PSR Standards ###

* [PSR-0][0] - Is a standard way of finding and auto-loading PHP classes,
interfaces, and other code. It's the first standard released by
[Php-Fig][5] and has been greeted very well by the greater PHP programing
community.

* [PSR-1][1] - Is the first of two code styling standards that was approved by
Php-Fig and also well accepted by most PHP programmers.

* [PSR-2][2] - The second coding standard released which have not been used
yet by as many PHP programmers as the PSR-1 standard, at this time at least, but
I expect that on new projects in the future many programmers will start using it.

* [PSR-3][3] - This logging standard is also doing well with most of the greater
PHP programming community.

From the above list you can tell I seem to like what Php-Fig has done so far.
You might have noticed that [PRS-4][4] is NOT in the list though. There's a
couple reasons for that. One it is new so I have NOT looked at it as closely as
the others. Another is I do NOT see where any of the differences between PSR-0
and PSR-4 have any real advantages in Yapeal. In the future if there seems to be
an advantage I will look at making the change but for now PSR-0 is good enough.

**Update**

Having looked at [PSR-4][4] some more and been doing some testing have decided
it would simplify and improve the directory structure within the project by
flattening it out.

### Other 'Standards' ###

Not really a standard in the normal sense but [Composer][6] / [Packagist][7].
They can each be used without the other but together they currently are
unbeatable by anything else for features or easy of use. Visit the websites to
really understand them better but in short Composer takes care of managing the
external dependencies your project might have. For example in Yapeal it would
handle getting the correct version of ADOdb and [Log4php][8] etc. Or now things
like [Monolog][9], [PSR-3][3], and some components from [Symfony2][10] that
Yapeal will use.
Composer uses Packagist as it's default repository to look for the other
packages though it can told to look other places as well. Nice thing with
Packagist is it let's you keep own projects anywhere you want as long as it can
access it to pull updates. It can be integrated with sites like [GitHub][11] so it
knows when a new version is pushed and will update itself so all your users can
always be up to date with the latest version with almost no work on their part.

[0]: http://www.php-fig.org/psr/psr-0
[1]: http://www.php-fig.org/psr/psr-1
[2]: http://www.php-fig.org/psr/psr-2
[3]: http://www.php-fig.org/psr/psr-3
[4]: http://www.php-fig.org/psr/psr-4
[6]: https://getcomposer.org/
[7]: https://packagist.org/
[5]: http://www.php-fig.org/
[8]: https://logging.apache.org/log4php/
[9]: https://github.com/Seldaek/monolog
[10]: http://symfony.com/
[11]: https://github.com/

#### Author: Michael Cummings ####
