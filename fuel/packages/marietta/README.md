# fuelphp-maintenance
add maintenance mode to FuelPHP.  
this is FuelPHP package. if you want to use, please use as package.  
How to install : http://fuelphp.com/docs/general/packages.html#/installing

## Basic usage
throw as below.
```
throw new \HttpServerMaintenanceException("your maintenance message.");
```


## Set maintenance mode
create fuel/app/config/maintenance.php  
please set like this.
```
return array(
  "maintenance_mode" => true
);
```
and insert into Conrtoller::before() as below.
```
MaintenanceMode::check();
```
It's displayed maintenance page forcedly.  
if you turn off it, please set maintenance_mode => false.

## Change maintenance view
create fuel/app/views/503.php and customize it.

### Change maintenance view file
if you want to change maintenace view file from default(503.php),  
please create fuel/app/config/maintenance.php 
and set like this.
```
return array(
  // defalut = "503"
  "view" => "your_maintenance_view"
);
```
