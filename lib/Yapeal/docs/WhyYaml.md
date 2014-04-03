# Why Yaml #

## Introduction ##

So I'm sure some of you are wondering why the default configuration file format
for Yapeal is being switched from an 'ini' file to 'yaml'. The simple answer
would be because I decided to but I'll getting into the reasoning I used when
deciding to make a change and what options I looked at.

### 'ini' Pluses ###

'Ini' files of course are well understand by most people that deal with software
configuration since they have been around at least since the start of
DOS/Windows[1]. They can generally be understood by anyone if well designed and
commented and are simple to make.

### 'ini' Minuses

One of their minuses is also that they are simple. If you only need `key=value`
type settings with a single level of division with sections they work well but
as soon as you need sub-sections you run into problems as there is no standard
way to do that. In fact there really is no 'standard' at all to them but at best
some commonly allowed practices. Neither the 'key' or the 'value' have any true
requirement placed on they except for what the software parsing them enforces.

### 'xml' Pluses ###

There is of course good old XML which is very good at complex structures and
easily parse by software. There is a [XML standard] as well. Some people like
me find it relatively easy to understand and work with. There is some
enforcement of what is allowed in tags and values. You can have some validation
with [XSD schema] files which can be used to increase the enforcement of keys
and values and are themselves also XML. There are ways to add documentation
(metadata) to XML files to help someone that is making changes to settings in
them manually.

### 'xml' Minuses ###

Most people do NOT find XML easy to work with and understand. It is a very
verbose format with the opening and closing tags. There is of course also
deciding between attributes or tags values etc. Also in the case of Yapeal it
always some how seems wrong to have people that are looking to simplify using a
RESTful XML API have to put their configuration settings in a XML file.

### 'php' Pluses ###

Since Yapeal _is_ a PHP library it can be assumed anyone making changes could
understand a php settings file. It's easy to add documentation as well. Very
simple to parse. No need to 'cache' the settings since in effect they already
are.

### 'php' Minuses ###

Since it is just code would be a vector to cause damage or other issues for
anyone trying to use Yapeal if a third party should gain access to it and make
changes. Mistakes in manually editing the configuration could keep Yapeal from
run and even report that something is wrong.

### 'json' Pluses ###

Json is a good format for configuration and fairly compact as well. It can
handle complex structures well and most people find them relatively easy to
understand if designed with care. There is a [Json] standard which is very
easy to understand since it is only one page. Keys and values do have structure
and values can even have 'types'. There is even a [Json schema] standard in
the works which allows validation and enforcement of the structure.


### 'json' Minuses ###

No documentation (metadata). Json is made strictly as a software parsed data
format. Some software lets you add comments but it does go against the standard
to do so. One thing that I know for sure is without the extra documentation
most people will find using it for settings harder than it should be.

### 'yaml' Pluses ###

Yaml was made to be human readable first and foremost. None of the other formats
were. Documentation ia allowed and uses a pseudo-standard format (C comments)
that most programmers already know and anyone can easily understand. There is a
[Yaml spec] or standard also. It can handle complex structures as well since it
is a super-set of Json. It also shares the same or has even higher compactness
than Json in some cases.

### 'yaml' Minuses ###

There is no Yaml schema standard for validating them though there are some
[Yaml validators] out there that can be used. This is less of a issue in
Yapeal due to some design decisions but could cause some problems if Yapeal is
NOT designed in a way to some how help point towards why a setting is NOT
correct to the person making manual changes or for possible formatting problems.

## Summary ##

So give the above I decided to go with Yaml as the default configuration file
format but do plan on allowing for at least Json, and possible Ini and PHP as
well. The system I plan to use allows these plus XML as well so should it be
needed changes can be done and any developers using Yapeal can extend or add to
it and have their configuration in a different format if they choose to.

[1]: http://en.wikipedia.org/wiki/INI_file
[XML standard]: http://www.w3.org/TR/REC-xml/
[XSD schema]: http://en.wikipedia.org/wiki/XML_Schema_%28W3C%29
[Json]: http://www.json.org/
[Json schema]: http://json-schema.org/
[Yaml spec]: http://yaml.org/spec/
[Yaml validators]: http://stackoverflow.com/questions/287346/yaml-validation

#### Author: Michael Cummings ####
