<?php
$languages = array("Bash", "Plain");
$data['lang'] = $languages;
$this->load->view('parser/code', $data);
$data['cclicense'] = 'by';
?>

<div>
  <div id="article_page" class="twelve columns" data-target="#toc">
    <?php heading(2, 'Line coverage report using
 <ccode>gcov</ccode>/<wccode>lcov</wccode>','Top',true); ?>
    <p>When using unit-tests to add robustness to development projects, it is
    nice (even important) to be able to see which parts of your code is actually
    being tested.</p>

    <p>If you are using <ccode>gcc</ccode>, this is exceedingly easy to
    accomplish, using the built in tool <ccode>gcov</ccode>. All you need to
     do is use the compile flags
      <ccode>-fprofile-arcs -ftest-coverage</ccode> and link flags <ccode>-lgcov
    -fprofile-arcs</ccode> when compiling with <ccode>gcc</ccode>.
    </p>

    <p>This creates a <ccode>.gcno</ccode> file for each compilation unit
      <ccode>gcc</ccode> processes. These files don't contain any actual
    coverage information (which makes sense, since no code has yet been executed).
    They only keep some basic data on code blocks and source code line numbers.
    </p>

    <p>The key is that when a program built with <ccode>gcov</ccode> is
      executed, it creates <ccode>.gcda</ccode> files, one for each compilation
      unit. The <ccode>.gcda</ccode>-files contain the interesting coverage
data -- which lines were touched, how many times, and which branches it went
through. With the help of <ccode>lcov</ccode>, these files are processed
 to generate an <ccode>html</ccode>-page.</p>

    <p>This jotting is divided into three parts:<br/>
      <b>1.</b> A general outline of the steps to create a clean coverage
        report, which should apply to any <ccode>gcc</ccode> project.<br/>
      <b>2.</b> How I arrived at these steps (cheating a bit for brevity)<br/>
      <b>3.</b> Finally I'll summarize the working script, an implementation of
      the general outline.</p>

      <?php heading(4, '1. General outline'); ?>
      <p>
        <div class="prettyprint pushup">
          <ol>
            <li>Clean project completely (you want a complete rebuild)</li>
            <li>Recompile everything with <ccode>gcov</ccode> compile and link flags.</li>
            <li>Use <ccode>lcov</ccode> to process initial <ccode>.gcno</ccode> files.</li>
            <li>Run all tests.</li>
            <li>Use <ccode>lcov</ccode> to process <ccode>.gcna</ccode> coverage files.</li>
            <li>Merge the initial and final <ccode>lcov</ccode> files (<wccode>step 3</wccode>
           and <wccode>step 5</wccode>).</li>
            <li>Filter <ccode>lcov</ccode> output to only include project files.</li>
            <li>Filter <ccode>lcov</ccode> output to exclude unit test files, and <ccode>main.cpp</ccode>.</li>
            <li>Generate <ccode>html</ccode> coverage report from final filtered <ccode>lcov</ccode> output..</li>
          </ol>
        </div>
      </p>
      <p>The point of <wccode>step 3</wccode> and <wccode>step 6</wccode> is to include
    files that have no coverage at all, and don't get a corresponding <ccode>.gcna</ccode> file. Without
    this, these untouched files wouldn't show up in the final coverage report.
      </p>

      <?php heading(4, '2. Trial and error'); ?>

      <p>First, a quick note on my <ccode>SCons</ccode> setup: All source files
      are contained in the <ccode>./src/</ccode> directory. During the build process,
      all used source code files are copied to a <ccode>./build/</ccode> directory,
      and all generated files (<ccode>.o</ccode>, <ccode>.gcno</ccode>, etc)
      also end up here.</p>
      <p>This completely separates the <ccode>build</ccode> and <ccode>src</ccode>
      directories, keeping a clean shop, just how I like it.</p>

      <p>I should also mention that my <ccode>SCons</ccode> script looks for
 environment variables <ccode>CPPFLAGS</ccode> and <ccode>CCFLAGS</ccode>, and
 uses these when present. So that  <wccode>step 1</wccode> and
        <wccode>step 2</wccode> from the general outline become:
      </p>

      <div class="prettyprint pushup">
        <pre class="brush: bash; gutter:false;">
rm -rf ./build
export LDFLAGS="-lgcov -fprofile-arcs"
export CPPFLAGS="-fprofile-arcs -ftest-coverage"
nice scons -j6 --tests  # --tests is a custom option that builds tests
        </pre>
      </div>

      <?php heading(5, '2.1 First attempt', '', false); ?>
      <p>Let's skip <wccode>step 3</wccode> for now, and run the tests (<wccode>step 4</wccode>),
process the coverage output (<wccode>step 5</wccode>), and generate the <ccode>html</ccode>
 report (<wccode>step 9</wccode>):</p>
      <div class="prettyprint pushup">
        <pre class="brush: bash; gutter:false;">
 # Run tests
for i in ./bin/tests/* ; do $i ; done
# Process coverage files
lcov -c -d ./build -o coverage.run
# Generate html report (make sure ./html folder exists)
genhtml -o ./html/ coverage.run
        </pre>
      </div>

      <div class="nine columns alpha">
        <p> The result is quite messy. For some reason, it includes coverage
          on <ccode>boost</ccode>,
          <ccode>cxxtest</ccode> and <ccode>gcc-stl</ccode> source files.
        </p>
      </div>
      <div class="three columns omega">
        <a href="<?=imgsrc('first-attempt.png')?>" data-lightbox="lcovattempt">
          <img src="<?=imgsrc('first-attempt-thumb120w.png')?>" class="" alt="" />
        </a>
      </div>
      <div class="clear"></div>


      <?php heading(5, '2.2 Second attempt - Excluding external files', '', false); ?>
 Let's clean this up with some filtering that only includes files in the project (<wccode>step 7</wccode>).
      <div class="prettyprint">
        <pre class="brush: bash; gutter:false;">
 # Extract (-e) from coverage.run data from files in cwd
lcov -e coverage.run "`pwd`/*" -o coverage.run.filtered
genhtml -o ./html/ coverage.run.filtered
        </pre>
      </div>


      <div class="nine columns alpha">
        <p>Much better. It still incorrectly lists directories that don't
      exist. Also, when browsing to the individual source files, it only shows
      the error message<ccode>(missing file)</ccode>.
        </p>
      </div>
      <div class="three columns omega">
        <a href="<?=imgsrc('second-attempt.png')?>" data-lightbox="lcovattempt">
          <img src="<?=imgsrc('second-attempt-thumb120w.png')?>" class="" alt="" />
        </a>
      </div>
      <div class="clear"></div>

      <?php heading(5, '2.3 Third attempt - Specifying source directory', '', false); ?>
      <p>Turns out that <ccode>lcov</ccode> needs to be told what the base directory is,
      using the <ccode>-b</ccode> flag.
      </p>

      <div class="prettyprint pushup">
        <pre class="brush: bash; gutter:false;">
 # Process coverage files
lcov -b . -c -d ./build -o coverage.run
# Extract (-e) from coverage.run data from files in cwd
lcov -e coverage.run "`pwd`/*" -o coverage.run.filtered
# Generate html report (make sure ./html folder exists)
genhtml -o ./html/ coverage.run.filtered
        </pre>
      </div>

      <div class="nine columns alpha">
        <p>Almost there. Unit test files are still included in the coverage
          report. Since these will always have <ccode>100%</ccode> coverage, it's better
          to not include them.
        </p>
      </div>
      <div class="three columns omega">
        <a href="<?=imgsrc('third-attempt.png')?>" data-lightbox="lcovattempt">
          <img src="<?=imgsrc('third-attempt-thumb120w.png')?>" class="" alt="" />
        </a>
      </div>
      <div class="clear"></div>


      <?php heading(5, '2.4 Fourth attempt - Excluding unit test files', '', false); ?>
      <p>Above we <em>extracted</em> our project files, now let's further
        <em>remove</em> all <ccode>Test*.*</ccode> files,
     which belong to the unit tests (<wccode>step 8</wccode> ).
      </p>

      <div class="prettyprint pushup">
        <pre class="brush: bash; gutter:false;">
 # Remove (-r) from coverage.run.filtered all Test*.* files
lcov -r coverage.run.filtered "`pwd`/*/Test*.*" -o coverage.run.filtered
genhtml -o ./html/ coverage.run.filtered
        </pre>
      </div>

      <div class="nine columns alpha">
        <p>Only relevant data now. However, I know that there are several
      files that are not tested at all, and don't show up. Even a whole
      directory (<ccode>audio</ccode>) is missing.
        </p>
      </div>
      <div class="three columns omega">
        <a href="<?=imgsrc('fourth-attempt.png')?>" data-lightbox="lcovattempt">
          <img src="<?=imgsrc('fourth-attempt-thumb120w.png')?>" class="" alt="" />
        </a>
      </div>
      <div class="clear"></div>

      <?php heading(5, '2.5 Fifth attempt - Including static <ccode>.gcno</ccode> files', '', false); ?>
      <p>This is where <wccode>step 3</wccode> and <wccode>step 6</wccode> save
    the day. By using the<ccode>-i</ccode> flag it looks for the initial static
        <ccode>.gcno</ccode> files. If you remember, these were created when
compiling, and there is one for each compilation unit. We merge this output with
the one from running the tests, and filter the result like before.</p>

        <div class="prettyprint pushup">
          <pre class="brush: bash; gutter:false;">
 # Process *.gcno files
lcov -b . -c -i -d ./build -o coverage.init

# Run tests like before
for i in ./bin/tests/* ; do $i ; done

# Process coverage from executed tests
lcov -b . -c -d ./build -o coverage.run

# Merge coverage.init and coverage.run
lcov -a coverage.init -a coverage.run -o coverage.total

# Filter like before, and also remove main.cpp
lcov -e coverage.total "`pwd`/*" -o coverage.total.filtered
lcov -r coverage.total.filtered "`pwd`/*/Test*.*" -o coverage.total.filtered
lcov -r coverage.total.filtered "`pwd`/build/main.cpp" -o coverage.total.filtered
genhtml -o ./html/ coverage.total.filtered
          </pre>
        </div>


        <div class="nine columns alpha">
          <p>Finally, it shows my hitherto sloppy test coverage in all
            earnestness.
          </p>
        </div>
        <div class="three columns omega">
          <a href="<?=imgsrc('fifth-attempt.png')?>" data-lightbox="lcovattempt">
            <img src="<?=imgsrc('fifth-attempt-thumb120w.png')?>" class="" alt="" />
          </a>
        </div>
        <div class="clear"></div>

        <?php heading(5, '2.6 Sixth (final) attempt - Merging folders', '', false); ?>
        <p>The <ccode>/build/</ccode> folder is just a by-product of compilation, a
    temporary mirror of files in the <ccode>/src/</ccode> directory. It would be nice to
    pretend that the coverage output for the files in<ccode>/build/</ccode> were
    located in <ccode>/src/</ccode>, merging together with the ones already there.
    How can that be done? I'm glad you asked!
        </p>
        <div class="prettyprint pushup">
          <pre class="brush: bash; gutter:false;">
sed 's/\/build\//\/src\//g' coverage.total.filtered > coverage.total.final
genhtml -o ./html/ coverage.total.final
          </pre>
        </div>
        <div class="nine columns alpha">
          <p>That's right, a simple search-and-replace does the trick!</p>
        </div>
        <div class="three columns omega">
          <a href="<?=imgsrc('sixth-attempt.png')?>" data-lightbox="lcovattempt">
            <img src="<?=imgsrc('sixth-attempt-thumb120w.png')?>" class="" alt="" />
          </a>
        </div>
        <div class="clear"></div>


        <?php heading(4, '3. Summary - final script'); ?>
        <p>
          <div class="prettyprint pushup">
            <pre class="brush: bash;">
#!/bin/bash

# Step 1: Clean all build files
rm -rf ./build

# Step 2: Re-compile whole project, including tests
export LDFLAGS="-lgcov -fprofile-arcs"
export CPPFLAGS="-fprofile-arcs -ftest-coverage"
nice scons -j6 --tests

# Step 3: Generate initial coverage information
lcov -b . -c -i -d ./build -o .coverage.wtest.base

# Step 4: Run all tests:
export LD_LIBRARY_PATH=$LD_LIBRARY_PATH:`pwd`/lib
for i in ./bin/tests/* ; do $i ; done

# Step 5: Generate coverage based on executed tests
lcov -b . -c -d ./build -o .coverage.wtest.run

# Step 6: Merge coverage tracefiles
lcov -a .coverage.wtest.base -a .coverage.wtest.run  -o .coverage.total

# Step 7: Filtering, extracting project files
lcov -e .coverage.total "`pwd`/*" -o .coverage.total.filtered

# Step 8: Filtering, removing test-files and main.cpp
lcov -r .coverage.total.filtered "`pwd`/build/main.cpp" -o .coverage.total.filtered
lcov -r .coverage.total.filtered "`pwd`/*/Test*.*" -o .coverage.total.filtered

# Extra:  Replace /build/ with /src/ to unify directories
sed 's/\/build\//\/src\//g' .coverage.total.filtered > .coverage.total

# Extra: Clear up previous data, create html folder
if [[ -d ./html/ ]] ; then
    rm -rf ./html/*
else
    mkdir html
fi

# Step 9: Generate webpage
genhtml -o ./html/ .coverage.total

# Extra: Preserve coverage file in coveragehistory folder
[[ -d ./coveragehistory/ ]] || mkdir coveragehistory
cp .coverage.total ./coveragehistory/`date +'%Y.%m.%d-coverage'`

# Cleanup
rm .coverage.*
            </pre>
          </div>

        </p>


        <div style="height:200px;" class="clear"></div>


  </div>
  <?php
  global $toc;
  $data['toc'] = $toc;
  $this->load->view('sidebars/sb_jotting', $data); ?>
</div>
