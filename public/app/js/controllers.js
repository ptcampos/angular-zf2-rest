/**
 * @author Paulo Campos
 * @param  {[type]} $scope){} [description]
 * @return {[type]}             [description]
 */
angular.module('restZend').controller('AlbumListCtrl', ['$scope', 'Albums', function ($scope, Albums) {
	
	Albums.query(function(res){
		$scope.albums = res;
	});

}])
.controller('AlbumCtrl', ['$scope', 'Albums', '$routeParams', function ($scope, Albums, $routeParams) {
	
	$scope.album = Albums.get({ id: $routeParams.albumId });

}])
.controller('AddAlbumCtrl', ['$scope', '$log', 'Albums', '$location', function ($scope, $log, Albums, $location) {

	$scope.saveNewAlbum = function(){

		// Create new Article object
		var album = new Albums({
			title: this.title,
			artist: this.artist
		});

		// Redirect after save
		album.$save(function (response) {

			$location.path('#/albums/' + response.id);

			// Clear form fields
			$scope.title = '';
			$scopeope.artist = '';

		}, function (errorResponse) {
			$log.error(errorResponse);
		});

	};
	
}]);