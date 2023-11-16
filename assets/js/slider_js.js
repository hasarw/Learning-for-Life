var app = angular.module('app', [])

app.controller('mediaCntl', ['$scope','$filter' ,'$http', function($scope, $filter, $http) {

    $scope.deleteSlide = function(slide_id, slide_address){
    $http({
      method: "POST", 
      url: "slider_remove.php",  
      data: {
       slideId: slide_id,
       // slideAdd: slide_address
      }
      }).then(function(response) {
           console.log(response); //get the echo value from php page
      }).catch(function(response) {
            console.log(response);
      });
      // $scope.select();
      location.reload();
    }
    

    $scope.goUp = function(slide_id, slide_num){

    $http({
      method: "POST", 
      url: "slider_up.php",  
      data: {
       slide__id: slide_id,
       slide__num: slide_num
      }
      }).then(function(response) {
           console.log(response); //get the echo value from php page

      }).catch(function(response) {
            console.log(response);
      });
      $scope.select();
      // location.reload();
    }

   
$scope.select = function(){
// $scope.$watch.select = function(){
    // $http.get("select_photo.php")
    // .then(function(data){
    //     $scope.photoAddress = data;

    // })

    var request4 = $http({
        method: "get",
        url : "mediaSlider.json"
        });

        request4.then(function(response){
            $scope.slider = response.data;
        });
}
       // var request2 = $http({
        // method: "get",
        // url : "mediaPhotos.json"
        // });

        // request2.then(function(response){
        //     $scope.photos = response.data;
        // });
}]);


    // $scope.getEvent = function(id) {

    // 	$scope.media_id = id;
    //     $scope.name = id;

    // }






