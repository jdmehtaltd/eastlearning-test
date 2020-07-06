# East Learning Test

## Test Problem

https://docs.google.com/document/d/15haPQP0pQPJkDDGR0aRBktC4I_-pCUvQ_fdc-SlMQRk/edit

## Getting Started

I use Windows but typically develop on Linux using Docker containers. For dev environments, docker-compose is quite
convenient. It allows me to share the project between the container the IDE, which I run on Windows. To run the app, do
`cd {project_root}; docker-compose up -d` (skip the `-d` and you can see the log from the app in the foreground). 
Port 8000 is exposed on the host OS by docker-compose. Try the app at http://localhost:8000/index.php on your browser.

## Learning PHP (again)

It has been 4+ years outside of PHP world for me, so I am revising a few things.

## GitHub workflow

I am using the basic GitHub workflow of feature-branch -> PR -> master. For a single dev, this is still useful because:
* It gives you a chance to squash related commits into one, so that very small fix commits do not clutter the history
of the `master` branch. The commit history in `master` then becomes a sort of atomic history of features which makes
rollback easier. There are other opinions about this in the community. Something similar can be done with tags.
* GitHub Actions is now a powerful CI/CD environment. In addition to Linux builds, you can also do Windows and Mac 
builds. There is a pretty big library of pre-built actions with lots of community contributions coming at a fast pace. 
For most use cases, a separate CI/CD server is no longer required. At some point, as a project advances, I tend to
make some actions which do things like lint checking, compilation, unit testing within the PR so that a merge into
`master` will usually be very clean. On merge into `master`, the actions can trigger a deployment into the *shared* 
test system. 

## JetBrains Tools

I tend to rely on the professional tools offered by JetBrains. They are quite heavy on memory usage, but that seems
a small price to pay becoming quickly productive with new languages and frameworks. I have shared my `.idea/` directory 
in this repo. It helps new developers get up to speed quickly and from my latest reading, this is a scheme that
JetBrains now encourages by setting up a pre-configured `.gitignore` file inside `.idea/`.

## TDD

TDD is pretty standard now with well documented benefits. My first task was to configure PHPUnit. I have read 
that Pest may be a better option. For now, PHPUnit may be the easier option since it is more popular. The unit test
run config works inside PHPStorm (through my shared `.idea/`). For command line, try this:
`cd {project_root}; docker-compose exec php /vendor/phpunit/phpunit/phpunit /app/tests`.

The classes which do the Validator and Processor logic are in `src/Validator.php` and `src/Processor.php`. The script 
which receives the POST for the upload is in `src/upload.php`.

## The PHP file upload

A simple google of 'PHP file upload' yields these links. 
https://www.w3schools.com/php/php_file_upload.asp, 
https://www.php.net/manual/en/features.file-upload.php.

## Coding Style Guide

I googled and found the PSR-2 style guide: https://www.php-fig.org/psr/psr-2/

## Simplifications, Assumptions, Compromises
* There are a few TODO comments in the code. Although that is considered bad practice, it is helpful sometimes to just
move on without looking up the full idiomatic style, especially in experimental projects.
* During resizing, I preserve the aspect ratio. width >= height is the simple case, but I also account for using
the aspect ratio if height > width and using the floor of the width calculation.
* In TDD practice, there are rules against side effects during tests, granularity of tests, etc. I have ignored a few
of them in the interest of time spent. Many of these rules are subjective and require a judgement of intended use case
of a project anyway.
* I started initially with the objective of supporting jpeg, png and gif images, but I ran into difficulties in
compiling (installing) the php-gd extension. Only `--with-jpeg` seemed to work. So, the image upload and resizing now
works only for jpeg files.
* There probably should be more test cases for image resizing. For example, we could have more sample images of sizes 
close to 800 pixel width or height to see edge behaviour. I have kept that limit configurable within the Processor class 
so that makes it more complex to think through the test cases. For the tests to be repeatable, there is an optional 
rename file mode, which is only used by the tests. That prevents the tests from changing the sample image files in 
place.
* I am assuming that authentication and authorization of users is out of scope for this test. Adding that would
trigger a discussion of databases, frameworks, etc.
* The persistent URL for sharing is printed upon upload in this very simple journey flow.
* An image file is provided in 'tests/' which is larger than 2MB for testing the upload rejection of large files
through the web page.
* The Processor class violates the PSR-2 side effect rule. I should read PSR-2 in more detail. In Python, PEP8 and PEP257
provide guidelines for code style but emphasize that practical considerations may override guidelines.
* A simple way of generating secure URLs is to use a hash of the base filename. That would also ensure that 
re-uploads of the same file would result in an overwrite of the file. If we want to 
prevent overwrites completely, a simple scheme could be to suffix the iso8601 timestamp to the base filename before 
hashing. At low volumes, that will approximate unique URLs because 2 uploads for the same filename are unlikely to 
collide after adding the suffix (especially if we separate the uploads by username). 
* We could use a database to keep maps of users and files. A database would trigger discussions about frameworks, 
long term objectives, etc.
* There are some more sample images in tests/ to help test the upload page. Test automation for UIs is tricky, 
but can be done by using technologies like selenium. There are plenty of paid tools for automating, one of the
prominent ones being browserstack.
* I have not used docstrings because I don't remember much about PHP docstrings and with code that is being
refactored quite often, it is better to leave them for later.
* Even though Validator will reject files > 2MB (configurable inside Validator), I have discovered that php.ini
also controls this setting as per here: https://stackoverflow.com/questions/2184513/change-the-maximum-upload-file-size.
I will have to change the docker configuration to make that part work.

## Bonus Mark questions

1. For secure URLs, see notes on hashing above. I have implemented the first part, which overwrites the same file on
upload.
2. I have based the hash on the filename to be uploaded. That means that if you upload the same file, it will be 
overwritten. The filename is a simple way of judging if the same file has been uploaded. There could be other ways.
You could, for example, checksum the contents to see if an identical file has been uploaded.
3. How to store lots of images:
    * *With Cloud IaaS:* This is a very convenient option, the most obvious being an S3 bucket. I am quite familiar 
    with this use case and a library like smart_open in Python makes S3 usage almost as simple as using a file system. 
    We could find something similar in PHP. https://github.com/RaRe-Technologies/smart_open. AWS also supports NFS
    in the cloud which could also work as central storage for more than one web app server. We have to be careful about
    concurrency, error handling, etc. For example, what happens if the NFS drive gets unmounted or disconnected from a 
    web app server or 2 server processes try to write to the same file. S3 handles a lot of those issues, for example, 
    an S3 upload is an all-or-nothing upload.
    * *Without Cloud IaaS:* There could be several options here. Let's assume we had a data centre in-house. We could
    just use a file server as central server for serving files to many web app servers. NFS will perform OK, but it comes
    with some management overhead in addition to the programming issues mentioned above. A modern database can easily 
    handle binary large objects (BLOBs) and it will give us full ACID transactions for uploads. I think it is a better 
    option to run a database server than NFS for web apps. Managing a database server is a bit more onerous in terms of 
    overhead, but it is worth it for the extra reliability and simplicity in programming.


 







