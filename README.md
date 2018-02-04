# Soccer Application  
<h4 align="center">CRUD Based application using the  <a href="https://laravel.com" target="_blank">Laravel</a> framework and <a href="https://vuejs.org/" target="_blank">VueJs</a>.</h4>

## Introduction

Api powered CRUD based application using laravel and VueJs. Session based authentication used for API authentication. Custom validation classes, Custom response formats, Custom Error render methods for exception handling and lot more.

## Official Documentation

Documentation for basic setup can be found at [Laravel](https://laravel.com/docs/5.5/).

## System requirements

Make sure your server meets the following requirements.

- PHP >= 7.0.0
- Node and Npm - latest
- Mysql >= 5.6

## Installation

Please follow the guide.

1. `git clone https://github.com/kk-r/soccer-app.git`
2. `cd soccer-app && cp .env.example .env`
3. `composer install && composer update`
4. `php artisan key:generate`
5. `update the .env file along with database connection`
6. `php artisan migrate`
7. `php artisan db:seed`
8. `npm install`

## Run PHP Dev Server
#### Application will serve on `http://localhost:9201`

```
php artisan serve --port=9201
```

## Run Node Engine

Compile assets one time.
```
npm run dev
```
**OR**
or if you would like to compile assets on runtime then copy paste following command in terminal 

`npm run watch` or `npm run watch-poll`


for complete list of instruction follow the link below
[Laravel Mix](https://laravel.com/docs/5.5/mix#running-mix)

Default user credentials
```
email - admin@admin.com 
password - password
```

## Screenshots:

##### Homepage
![screenshot](https://raw.githubusercontent.com/kk-r/soccer-app/dev/homepage.png)

##### Team Players Listing
![screenshot](https://raw.githubusercontent.com/kk-r/soccer-app/dev/team-players-listing-page.png)

##### Login Screen
![screenshot](https://raw.githubusercontent.com/kk-r/soccer-app/dev/login-page.png)

##### Team CRUD Operation
![screenshot](https://raw.githubusercontent.com/kk-r/soccer-app/dev/team-crud-operation.png)

##### Player CRUD Operation
![screenshot](https://raw.githubusercontent.com/kk-r/soccer-app/dev/player-crud-opertion.png.png)

## Security

If you discover security related issues, please use the issue tracker.

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :blush:

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
