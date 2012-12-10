Phing Li3
=========

A Phing task for running lithium tests.

# Usage

An example phing build file that runs just the lithium tests is below.

    <?xml version="1.0"?>
    <project name="lithium-app" default="main">
        <target name="main">
            <taskdef classname="TestTask" classpath="li3_phinger/core" name="li3test" />
            <li3test li3Base="." tests="app\tests" />
        </target>
    </project>

## Params

li3Base : is the base location for lithium, it'll have the app, libraries directories in it.
tests : this is what tests you wish to run, it uses the web interfaces agruments. So "all" will run all the tests, "app\tests" will run all the ones in that namespace, etc.

## Known Issues

Since the way lithium defines it's base for for url handling you will need to mock the Request class and redefine Request::_base() to set $this->base as '/'.

