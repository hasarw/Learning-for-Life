var app = angular.module('app', [])


app.directive('fileInput', function ($parse) {
    return {
    
    link: function($scope, element, attrs) {
        element.on("change", function(event){
            var files = event.target.files;
            $parse(attrs.fileInput).assign($scope, element[0].files);
            $scope.$apply();
        });
    }

   }

});

app.filter("trustUrl", ['$sce', function ($sce) {
        return function (recordingUrl) {
            return $sce.trustAsResourceUrl(recordingUrl);
        };
    }]);


app.controller('mediaCntl', ['$scope','$filter' ,'$http', function($scope, $filter, $http) {
   
    // $scope.video_address = 0;
    // $scope.myFunc = function(value) {
    //     $scope.video_address = value;
    // };
    $scope.img_address = "";
    $scope.myFunc=function(address){

    $scope.img_address = address;

    $('#myModal').modal('show'); 
 

    }



    $scope.uploadFile = function(){
    
    var form_data = new FormData();
    angular.forEach($scope.files, function(file){
        form_data.append('file', file);
    });

    $http.post('upload_photo.php', form_data,
    {

        transformRequest: angular.identity,
        headers: {'Content-Type': undefined, 'Process-Data': false}

    }).then(function(response){
        alert(response);
        $scope.select();
    });
}

$scope.select = function(){
    // $http.get("select_photo.php")
    // .then(function(data){
    //     $scope.photoAddress = data;

    // })

    var request4 = $http({
        method: "get",
        url : "mediaPhotosAddress.json"
        });

        request4.then(function(response){
            $scope.photosAddress = response.data;
        });
}


        var request2 = $http({
        method: "get",
        url : "mediaPhotos.json"
        });

        request2.then(function(response){
            $scope.photos = response.data;
        });


        $scope.getEvent = function(id) {

        $scope.media_id = id;
        $scope.name = id;

        }

        




}]);


   





