# My-CTF-Challenges

Hey, I created this repo as a way of sharing my challenges/solutions for them. You'll see that most of them are web as I'm mostly into web hacking, but there will be the occasional challenges in other categories.

## TimisoaraCTF - Quals

### Watch Your Head

#### Summary
The flag is being sent two chars at a time in each request, one in the header X-Data and one in the cookie Data-X, repeated after it's completedly sent.

#### Source
* [index.php](timisoara-ctf-2018-quals/watchyourhead/)

### BookDir

#### Summary
TBA

#### Source
* [www/](timisoara-ctf-2018-quals/bookdir/)

## TimisoaraCTF - Finals

### SQL Sanity Check

#### Description
Because our school's headmaster hates passwords, he asked our talented students to develop him a special login page, without any passwords! Confused, but while still aware of security practices, our students devised a way to login the headmaster when he's at school, only based on his email (which, by the way, is john.smith@timisoaractf.com). Can you figure out what's happening? We heard that the headmaster has some flags stashed around...

#### Summary

PostgreSQL, a simple register (non-injectable) that inserts the (ua, email) combo in the database and a login that checks the (ua, email) combo and returns true/false whether the login was successful or not. The UA is encoded with a key 11 Caesar cipher, and error reporting was left on for the database login query to observe the cipher. There are two methods to solve it, one is the 'easy' one using an error based solution because the database login query displayed the errors, or blind-based.

#### Source
* [www/](timisoara-ctf-2018-finals/sqlsanitycheck/www/)
* [solution.php](timisoara-ctf-2018-finals/sqlsanitycheck/www/)

### PHP-REvival

#### Description
Hey guys, our sports teacher was apparently hit in the head when supervising a basketball game and has a minor amnesia... He has left a valuable flag in his online area but we cannot seem to log in. Fortunately, our security experts extracted this file from the server, telling us that it's related to his login and now we count on you to find the password and get his beloved flag back!

If you think you found the correct password from the file, here is the login he used: http://89.38.210.129:8091 (with added protection for bruteforce attempts)

#### Summary
A file containing a dump with PHP opcodes was given. The function is simple, checks for strlen 8, it checks a few offsets of the password, giving around ~90 possible solutions. The initial idea was that the last condition, md5('a' . $password . 'a') == '0' should only return 1 possible solution, an md5 'magic hash' that has the format '0e[0-9]{30}'. But.. PHP also accepts a few other solutions, formatted as '0[^0-9][a-f0-9]{30}', so, when the first val is 0 and there is a character after it, it'll also return true.

My intended solution was to use z3 to generate the ~90 solutions, then check which one is correct.

#### Source
* [php-rev.txt - the task](timisoara-ctf-2018-finals/php-REvival/php-rev.txt)
* [www/](timisoara-ctf-2018-finals/php-REvival/www/)
* [solution.py](timisoara-ctf-2018-finals/php-REvival/solution.py)

### YAPS - Yet Another PHP Sandbox

#### Description
* Part 1: Oh no.. When we were checking our school filesystem that got hacked by this weird group last summer, we've stumbled upon a page called: Yet Another PHP Shell. It seems that they restricted access to an important file, `flag.php`! Can you find what's inside?

* Part 2: Huh, latest PHP and Apache can not have 0days right? Can you get RCE and run the /get_flag binary? Find the 1day and engrave your name on the Wall of (Sh/F)ame!

#### Summary
Two-part sandbox challenge, I'll split the summary here.

#### Part 1
The description says that the flag is in `flag.php`. The regex disallows using more than 2 alphanumeric (+underscore) characters in a row or any of the following: ' " . [

There are quite a few possible solutions I believe, all of them should be based on PHP considering strings without quotes as constants, therefore still strings. Two of the solutions can be:

* Encoding the string you want to use in a variable by using a non-ascii character after each 2 ascii characters, and replacing it at the end. For example, "abcdefghij" can be encoded into $a as `$a=ab\xffde\xffgh\xffj;$a{2}=c;$a{5}=f;$a{8}=i;`

* Using XOR to bypass any alpha-numeric checks. In PHP, `$a=string^string;` will put the result of the two XORed strings into $a, even if the strings are non-ascii and there are no quotes.

So, the solution is simply to encode a `readfile` into, let's say `$a` and `flag.php` into $b, and then do a `$a($b);` to get the flag.

#### Part 2
This is where it gets interesting. There is *nothing* enabled on the server, not even error_reporting, disable_functions has everything that can be possibly used for executing code, open_basedir is set on `/var/www/site/` and there is a `tmp/` folder non-readable, world-writable. `phpinfo` is also disabled, but all the info needed can be retrieved using `ini_get_vars()`. Open_basedir can be bypassed with symlinks but it's not useful if you don't have RCE to execute the `/get_flag` binary.

The idea is the following: `sendmail` is not disabled. There is a pretty old 'vulnerability' that floats around PHP since 2008, when it was reported that `sendmail` calls `/usr/bin/sendmail`. `putenv` is also enabled, and you can put a `LD_PRELOAD` in the environment to be used before calling `sendmail`. There is a repo on github that explains it pretty well: [TarlogicSecurity/Chankro](https://github.com/TarlogicSecurity/Chankro).

My solution creates a folder in tmp using `mkdir`, writes the specific payload generated with Chankro, then executes the putenv();mail(0,0,0,0); to cat the flag in the same directory. After that, simply accessing it through the browser will display the flag.

#### Source
* [www/](timisoara-ctf-2018-finals/yaps/www/)
* [solution.php](timisoara-ctf-2018-finals/yaps/solution.php)
* [solution2.php](timisoara-ctf-2018-finals/yaps/solution2.php)
