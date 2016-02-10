# PHP and google Maps Real Estate Map Search

***This is a working rough draft taken from another project will need to be cleaned up and refactored***

This is a fairly simple map search in the style of real estate websites or airbnb.

The example uses an SQLite table but this can easily be changed to use a different DB. And the code can be easily modified to implement your own filters, etc.

## Configuration

Edit ```library/config.php```


```
$site_name='<Your Site name>';
$site_url='<Your Site url>';
$site_mapsAPIKey='<Your Google Maps API KEY>';
```
And Configure your DB (see ```example_db\dbSetUp.php```  for the default DB column name)

```
$site_db_array=['dsn'=>'<Your DB DSN>','u'=>'<DB user>','p'=>'<DB Password>'] ;
```
See [http://php.net/manual/pl/ref.pdo-mysql.connection.php](http://php.net/manual/pl/ref.pdo-mysql.connection.php) for more information on  your Database Data Source Name (DSN) 

TODO: Write more detail


## Usage

TODO: Write usage instructions

You can see a working example here [http://experiments.warsawweb.com/re_map_search](http://experiments.warsawweb.com/re_map_search)

## Credits

Juan Camilo Rojas
[warsawweb.com](http://warsawweb.com/)

## License

Feel free to use and modify, and hopefully give credit.
