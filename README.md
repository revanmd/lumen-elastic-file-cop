# Integrate HTTP Elastic Middleware Lumen

## How to


* Move the file into your directory, there are 2 files : LogMiddleware.php and ElasticService.php
* Register LogMiddleware into bootstrap.php
```
$app->middleware([
    App\Http\Middleware\LogMiddleware::class
]);
```

* Add the environtment variable to your .env
```
ELASTIC_HOST = https://localhost:9200
ELASTIC_USERNAME = elastic
ELASTIC_PASSWORD = Pusri123

```

