# Coding Style #

## Introduction ##

Yapeal has always had a set coding style it has used. There have been a few
changes to it over the years but most of it has been the same since near the
beginning of the project. One reason is really none of the code until the last
six months or so have been added to Yapeal without usually being done by me or
review one or more times by me personally and I have usually edited it as well
at some point and changed any styling differences. If you want a contrasting
example of a project that did NOT seem to do that look no farther than ADOdb. It
is easy to find files in ADOdb that have code in two or more styles some of
which are NOT really of any know 'standard'. This was one of many things that
have made me unhappy with it plus the fact there are just better libraries now
available. The 'standard' that I have used with Yapeal in the past was PEAR's
standard with a few changes and I made it available in a wiki since I decided on
it where other developers could read it. To sum up the differences I liked 2
space indenting and opening braces always on the same line. There are some other
differences but those are the ones that are most noticeable.

## Other styles ##

So as much as I think some of my ideas on styling look better I do understand
not everyone else would agree and it fact most of the existing standards do NOT
on the ones I listed above. They do have their own differences but on the couple
points above they seem to be largely in agreement. Many other existing projects
have come up with their own styling guides and wrote them up for others to use
but finally a group which includes members from multiple projects as well as
others interested programmers have come up with a couple of new standards. They
come from [Php-Fig]. Like most standards from php-fig IMHO they are well
thought out and usable.

## PSR-1/PSR-2 ##

PSR-1 is fairly simple and really a standardizing of current generally accept
coding practices. Yapeal mostly already was following it although it has some
issues when it came to 'Side Effects' which will be addressed in future versions.
Yapeal also does NOT follow the stuff about namespaces and PSR-0 auto-loading
since it was made to work with PHP < 5.3 when namespaces were added. PSR-2 is
more what most people think of as a coding style. Yapeal like probably most
projects followed some of these and not others. Many IDE editors now have
PSR-1/PSR-2 style reformatting included like the newer versions of [PhpStorm]
do which is what I use. I expect most, if not all, programmer editors / IDEs
will do the same thing in the future. In PhpStorm with them included the PSR
standards as built-in selectable styles etc. and it's already very good code
reformatting I decided it is much easier to just go with the flow than having to
import or re-create my existing style during installs or major updates and have
other programmers doing the same thing in their favorite editor for code they
want to submit to Yapeal.

## Summary ##

So to summarize, Yapeal going forward will use PSR-1/PSR-2 for it's code styling.

[Php-Fig]: http://www.php-fig.org/
[PhpStorm]: http://www.jetbrains.com/phpstorm/

#### Author: Michael Cummings ####
