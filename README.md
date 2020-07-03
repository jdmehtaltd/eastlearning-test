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
that Pest may be a better option. But for now, PHPUnit may be the easier option since it is more popular.





