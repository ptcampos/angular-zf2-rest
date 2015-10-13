'use strict';

//Albums service used for communicating with the articles REST endpoints
angular.module('restZend').factory('Albums', ['$resource',
  function ($resource) {
    return $resource('http://rest-zend-api:8888/album-rest/:id', {
      	id: '@_id'
    }, {
    	query: {
    		isArray: false
    	},
    	update: {
      	method: 'PUT'
    	}
    });
  }
]);