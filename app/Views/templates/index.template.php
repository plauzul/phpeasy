<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>@namesection("title")</title>
	<link rel="stylesheet" href="resources/css/angular-material.min.css">
	@namesection("insertCss")
</head>
<body ng-controller="IndexTemplateCtrl" ng-cloak>

	@namesection("body")

	<!-- Angular Material requires Angular.js Libraries -->	
	<script src="resources/js/angular.min.js"></script>
	<script src="resources/js/angular-animate.min.js"></script>
	<script src="resources/js/angular-aria.min.js"></script>
	<script src="resources/js/angular-messages.min.js"></script>

	<!-- Angular Material Library -->
	<script src="resources/js/angular-material.min.js"></script>

	@namesection("insertJs")
</body>
</html>