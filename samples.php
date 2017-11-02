<?php
require __DIR__ . '/vendor/autoload.php';


### get an instance of the Collector ###
$StatsCollector = Statistics\Collector::getInstance();

/**
 * Scalar stats usage
 */

### lets add some stats (basic usage) ###
$StatsCollector->addStat("clicks", 104103); // add stat to "general" default namespace

### lets add some stats to an absolute path namespace (notice the first character of the namespace is '.') ###
$StatsCollector->addStat(".this.is.an.absolute.namespace.path.clicks", 55);

### lets add a custom default namespace, and then add a bunch of stats to it ###
$StatsCollector->setNamespace("noahs.ark.passengers")
    ->addStat("humans", 2)
    ->addStat("aliens", 0)
    ->addStat("animal.cats", 3)// adds sub-namespace 'noahs.ark.passengers.animal.cats'
    ->addStat("animal.dogs", 6)
    ->addStat("animal.chickens", 25);

### lets increment some stats ###
$StatsCollector->setNamespace("general.stats")
    ->addStat("days_on_the_earth", (33 * 365))// 12045 added to 'general.stats.days_on_the_earth'
    ->incrementStat("days_on_the_earth"); //
echo $StatsCollector->getStat("days_on_the_earth") . PHP_EOL; // 12046
echo $StatsCollector->getStat(".general.stats.days_on_the_earth") . PHP_EOL; // same as above 12046

### lets decrement some stats###
$StatsCollector->setNamespace("general.other.stats")
    ->addStat("days_until_christmas", 53)// 53 as of 11/02/2017
    ->decrementStat("days_until_christmas"); // skip 24 hours
echo $StatsCollector->getStat("days_until_christmas"); // 52

### lets retrieve multiple stats in one go ###
// find two stats by absolute path
$statsAbsolute = $StatsCollector->getStats([
    '.general.stats.days_on_the_earth',
    '.general.other.stats.days_until_christmas'
]);
// find two stats, one using absolute namespace and one using relative namespace in relation to path on line 30
$statsRelative = $StatsCollector->getStats(['.general.stats.days_on_the_earth', 'days_until_christmas']);

var_dump($statsAbsolute); // array(2) { [0] => int(12046) [1] => int(52) }
var_dump($statsRelative); // array(2) { [0] => int(12046) [1] => int(52) }

### lets sum up some stats ##
$StatsCollector->setNamespace("donation.count")
    ->addStat("jan", 553)
    ->addStat("feb", 223)
    ->addStat("mar", 434)
    ->addStat("apr", 731)
    ->addStat("may", 136)
    ->addStat("june", 434)
    ->addStat("july", 321)
    ->addStat("aug", 353)
    ->addStat("sept", 657)
    ->addStat("oct", 575)
    ->addStat("nov", 1020)
    ->addStat("dec", 2346);

// get the total of the above stats
echo $StatsCollector->getStatsSum([
        'jan',
        'feb',
        'mar',
        'apr',
        'may',
        'june',
        'july',
        'aug',
        'sept',
        'oct',
        'nov',
        'dec'
    ]) . PHP_EOL; //7783

### Averages of a collection of stats

// lets work out the average donations per month based on the above the above stats
echo $StatsCollector->getStatsAverage([
        'jan',
        'feb',
        'mar',
        'apr',
        'may',
        'june',
        'july',
        'aug',
        'sept',
        'oct',
        'nov',
        'dec'
    ]) . PHP_EOL; //648.58333333333

/**
 * Compound stats usage
 *
 * Stats become "compound" when you add either an array of scalars as the value or when you add a stat to
 * an already existing namespace.
 */

### Compound Averages

// lets get the average of a compound stat
$StatsCollector->setNamespace("test.averages")
    ->addStat("age", 23)
    ->addStat("age", 12)
    ->addStat("age", 74)
    ->addStat("age", 49)
    ->addStat("age", 9);
echo $StatsCollector->getStatAverage('age') . PHP_EOL; //33.4

// lets take two different compound stats and work out the collective average
$StatsCollector->setNamespace("donation.amounts")
    ->addStat("paypal", 10)
    ->addStat("paypal", 22)
    ->addStat("paypal", 16)
    ->addStat("paypal", 15)
    ->addStat("paypal", 50)
    ->addStat("ayden", 18)
    ->addStat("ayden", 22)
    ->addStat("ayden", 20)
    ->addStat("ayden", 33)
    ->addStat("ayden", 14);

echo $StatsCollector->getStatsAverage(['paypal', 'ayden']) . PHP_EOL; //22
echo $StatsCollector->getStatsAverage(['.donation.amounts.paypal', '.donation.amounts.ayden']) . PHP_EOL; //22


## Compound Summation

// lets get the sum of a compound stat
$StatsCollector->setNamespace("gateway.tracking")
    ->addStat("timeouts", 23)
    ->addStat("timeouts", 12)
    ->addStat("timeouts", 74)
    ->addStat("timeouts", 49)
    ->addStat("timeouts", 9);

echo $StatsCollector->getStatSum('timeouts') . PHP_EOL; // 167



/**
 * Work in progres below
 */

//stats grouped by tags
//$StatsCollector->setNamespace("test.averages")
//    ->addStat([
//        'name' => "paypal_processing",
//        'tags' => ['process_times']
//    ], 23);


/*
 * Targeting convention
 * .path.to.namespace = absolute
 * path.to.namespace = sub-namespace relative to current namespace
 * path = leafnode in current name space
 * #path = tags ?
 */
//
//$StatsCollector->getStatCount("age"); // count all indivudal stats
//$StatsCollector->getStatsCount(["target.one", "target.two", "target.three.*"]); // count all individual stats
//
//$StatsCollector->getStatsCountByTag("tag1");
//$StatsCollector->getStatsCountByTags(['tag1', 'tag2']);


?>