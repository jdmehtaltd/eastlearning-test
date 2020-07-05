# East Learning Test

## Test Problem

https://docs.google.com/document/d/15haPQP0pQPJkDDGR0aRBktC4I_-pCUvQ_fdc-SlMQRk/edit

## Getting Started

I use Windows but typically do development on Linux using Docker. To run the PHP, do
`docker-compose up -d`. Port 8000 is exposed on the host OS by docker-compose. Try
http://localhost:8000/index.php on your browser. You should see output of phpinfo().

## Learning PHP (again)

It has been 4+ years outside of PHP world for me so I am revising few things. Like learning to use composer again.

## GitHub workflow

I am using the basic GitHub workflow of feature-branch -> PR -> master. For a single dev, this is still useful because:
* It gives you a chance to squash related commits into one...very small fix commits do not clutter the history. So, 
the commit history in master is a sort of feature add/update history and that also helps with rollbacks.
* GitHub Actions is now a powerful CI/CD environment. In addition to Linux builds, you can also do Windows and Mac 
builds. There is a pretty big library of pre-built actions with lots of community contributions coming at a fast pace. 
For most use cases, a separate CI/CD server is no longer required. At some point, as a project advances, I tend to
make some actions which do things like lint checking, compilation, unit testing at the time of the PR itself. And the
actions can trigger a deployment into the *shared* test system at the time of merge into master branch.

## JetBrains Tools

I tend to rely on the professional tools offered by JetBrains inspite of the fact that they are quite heavy on memory.
For getting quickly productive with new languages and paradigms, it helps. I will most likely put my .idea/ directory 
into this repo. It helps new developers get up to speed quickly and from my latest readings, this is a scheme that
JetBrains now encourages by setting up pre-configured .gitignore file.

## TDD

TDD is pretty standard now with well documented benefits and my first task will be to configure PHPUnit. I have read 
that Pest may be a better option. But for now, PHPUnit may be the easier option since it is more popular. Unit test
run config works inside PHPStorm. For command line, try this to run the tests inside container from outside: 
`docker-compose exec php /vendor/phpunit/phpunit/phpunit /app/tests`

## The PHP file upload

A simple google of 'PHP file upload' yields these links. I will study their code and possibly refactor and enhance it.
https://www.w3schools.com/php/php_file_upload.asp, 
https://www.php.net/manual/en/features.file-upload.php.

## Coding Style Guide

I googled and found the PSR-2 style guide and will adapt the code to fit it: https://www.php-fig.org/psr/psr-2/

## Simplifications, Assumptions, Compromises
1. There are a few TODO comments in the code. Although that is considered bad practice, it is helpful sometimes to just
move on without looking up the full idiomatic style, especially in experimental projects.
2. Accepting only gif, jpg (jpeg), png files as image files but that is easily extensible in the Validator class.
3. During resizing, I preserve the aspect ratio. If width >= height, that is simple, but I calculate a suitable width
otherwise based on the aspect ratio.
4. In TDD practice, there are rules against side effects during tests, granularity of tests, etc. I have ignored a few
of them in the interest of time spent. Many of these rules are subjective and require a judgement of intended use case
of a project anyway.
5. I started initially with the objective of supporting jpeg, png and gif images but I ran into difficulties in
compiling (installing) the php-gd extension. Only --with-jpeg seemed to work. So, the image upload and resizing now
works only for jpeg files.
6. For image resizing there can more test cases. For example, we could have more sample images of sizes close to 800
pixel width or height to see edge behaviour. I have kept that limit configurable within the Processor class so that
lends some more complexity to which test cases may be valid. For the tests, to be repeatable, there needs to be a rename
file mode, otherwise the original files are modified.
7. Assuming that authentication and authorization of users is out of scope for this test. 
8. The persistent URL for sharing is printed upon upload in this very simple journey flow.
9. An image file is provided in tests/ which is larger than 2MB for testing the upload rejection of large files
through the web page.





