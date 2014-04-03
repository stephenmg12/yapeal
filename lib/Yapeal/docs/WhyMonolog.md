# Why Monolog #

## Introduction ##

Logging in Yapeal has gone through a lot of changes over the years from using
the settings in PHP itself to some custom designs and the latest system
[Log4php]. Each has generally been an improve over the last but in the end I
have never been really been happy with the result. Below I will go over some of
my thoughts about logging and why I have decided to go with [Monolog], for
now at least.

### Before Log4php ###

Logging before I started using log4php was difficult to add, use, and understand
and often very verbose at times. There were times it felt like it was causing
more problems that it solved for me and developers using Yapeal. There was a lot
of extra code in Yapeal just to handle errors and it was everywhere and often
made the code harder to understand.

### Log4php ###

The change to Log4php improved things a lot and I did a lot of clean up to what
was logged. It also brought in other options for what types of logs could be
used, location etc. The main problem with Log4php is it ended up requiring it's
own XML configuration file. Now XML is fine and all but having some of the
settings in an Ini file and some in XML added to the confusion and made several
things like update Yapeal or explaining it's configuration harder then it should
have been.

### PSR-3 ###

A new standard for PHP logging has emerged called [PSR-3]. Like most of the
[Php-Fig] standards it seems to be well thought out and of practical use as
well which is NOT always true with many standards you find. The nice thing about
it is that any programmer can basically do their own thing as long as they use
the interface included in the standard. Someone has even prototyped a
[wrapper around log4php][1] to make it work as a PSR-3 logger. I only found this
today and it still does NOT solve the two configuration files issue but anyone
else that is using log4php might find it useful.

### Monolog ###

So I decided on Monolog first because it is a PSR-3 type logger which should
mean it could be easily replaced in the future if I decide to with a different
PSR-3 logger. Monolog does NOT require a configuration file which makes
integrating it with Yapeal easy. PSR-3 compatibility also means for projects
that already use a PSR-3 logger they should be able to simply pass an exist
instance to Yapeal and it's logs should merge with their existing logs if they
want. For projects that do NOT use a PSR-3 logger it should still be easy to add
a wrapper to their existing system for PSR-3 and pass that to Yapeal to use.
Another advantage to Monolog is several major projects already use it which
means the code is well tested and there lots of examples to learn from available
on the Internet for anyone that needs or wants to change how Yapeal does it's
logging.

## Summary ##

So to sum it up Yapeal for now anyway is using Monolog but the main thing is it
will be PSR-3 compatible going forward at least until / if something with an
improved set of features comes along.

[Log4php]: https://logging.apache.org/log4php/
[Monolog]: https://github.com/Seldaek/monolog
[PSR-3]: http://www.php-fig.org/psr/psr-3/
[Php-Fig]: http://www.php-fig.org/
[1]: http://www.sitepoint.com/implementing-psr-3-with-log4php/

#### Author: Michael Cummings ####
