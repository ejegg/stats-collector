# Stats Collector

This utility allows you to capture application-wide statisitics during a PHP process e.g. http request, batch job or simple cli-script. Once you have captured some stats you can then perform aggregate analysis using common functions like average, count and sum. Finally you can export your stats to a backend of your choice  e.g. file, log, db, queue. (currently only Prometheus file exporter available but you can easily add your own following the iExporter interface)

### To-do

  - Import() - allow Stats Collector to import previously exported data and carry on where it left off. 
  - Tests!

### Credits

* [github.com/dflydev/dflydev-dot-access-data](https://github.com/dflydev/dflydev-dot-access-data)  - small but powerful dot namesapce utility

### Getting Started
```sh
$ git clone https://github.com/jackgleeson/stats-collector.git
$ php composer install
```

Checkout *samples.php* for usage until I have time to add the full README.
