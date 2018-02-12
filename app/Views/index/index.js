angular.module('app', ['ngMaterial']).controller('IndexTemplateCtrl', ($scope, $location) => {

    $scope.goTo = function(url) {
        window.open(url);
    }
});