var app = angular.module('restZend', ['ngRoute', 'ngResource']);

app.config(function($routeProvider, $httpProvider){

	$routeProvider
    
	.when('/albums',
	{
		templateUrl: 'partials/albums.html', 
		controller: 'AlbumListCtrl'
	})

    .when('/albums/:albumId',
    {
      templateUrl: 'partials/album.html', 
      controller: 'AlbumCtrl'
    })

	.when('/add', 
    {
    	templateUrl: 'partials/add-album.html', 
    	controller: 'AddAlbumCtrl'
    })

    .otherwise({redirectTo: '/albums'});

});