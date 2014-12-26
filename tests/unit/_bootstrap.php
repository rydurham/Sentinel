<?php
// Here you can initialize variables that will be available to your tests

// Prepare the sqlite database
// http://www.chrisduell.com/blog/development/speeding-up-unit-tests-in-php/
//exec('rm ' . __DIR__ . '/../_data/db.sqlite');
exec('cp ' . __DIR__ . '/../_data/prep.sqlite ' . __DIR__ . '/../_data/db.sqlite');