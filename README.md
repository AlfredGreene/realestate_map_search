# PHP and google Maps Real Estate Map Search

This is a fairly simple map search in the style of real estate websites or airbnb.

The example uses an SQLite table but this can easily be changed to use a different DB. And the code can be easily modified to implement your own filters, etc.

## Configuration

Edit ```library/config.php```


```
$site_name='<Your Site name>';
$site_url='<Your Site url>';
$site_mapsAPIKey='<Your Google Maps API KEY>';
```
And Configure your DB (see ```test\dbSetUp.php  for the default DB column names```)

```
$site_db_array=['dsn'=>'<Your DB DSN>','u'=>'<DB user>','p'=>'<DB Password>'] ;
```



## Usage

TODO: Write usage instructions

## Credits

Juan Camilo Rojas
[warsawweb.com](http://warsawweb.com/)

## License

Feel free to use and modify, and hopefully give credit.
