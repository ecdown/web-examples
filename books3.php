<!DOCTYPE html>
<html ng-app="bookDisplay">
	<head>
		<title>Imagize E Books</title>
	<script type="text/javascript" src="/iserver/books/js/jquery-1.5.1.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular.min.js"></script>
<style type="text/css">
    * {
    padding: 0;
    margin: 0;
    font-family: arial, helvetica, sanserif, sans-serif;
  }

#wrapper {
width: 95%;
}
.page {
  width: 95%;
}

h1 {
  background-color: #333333;
  color: #FFFFFF;
  }

a {
  text-decoration: none;
 color: #333333;
}

a:hover {
    text-decoration: underline;
}

h3 img {
	padding-right: 5px;
}

li img {
	hidden: true;	
}
.button {
 border-top: 1px solid #96d1f8;
   background: #65a9d7;
   background: -webkit-gradient(linear, left top, left bottom, from(#3e779d), to(#65a9d7));
   background: -webkit-linear-gradient(top, #3e779d, #65a9d7);
   background: -moz-linear-gradient(top, #3e779d, #65a9d7);
   background: -ms-linear-gradient(top, #3e779d, #65a9d7);
   background: -o-linear-gradient(top, #3e779d, #65a9d7);
   padding: 5px 10px;
   -webkit-border-radius: 8px;
   -moz-border-radius: 8px;
   border-radius: 8px;
   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
   box-shadow: rgba(0,0,0,1) 0 1px 0;
   text-shadow: rgba(0,0,0,.4) 0 1px 0;
   color: white;
   font-size: 14px;
   font-family: Georgia, serif;
   text-decoration: none;
   vertical-align: middle;
   }
.button:hover {
   border-top-color: #28597a;
   background: #28597a;
   color: #ccc;
   }
.button:active {
   border-top-color: #1b435e;
   background: #1b435e;
   }
.file {
 float:left;
}

.file.button {
   border-top: 1px solid #f7d797;
   background: #d6c365;
   background: -webkit-gradient(linear, left top, left bottom, from(#fffb12), to(#d6c365));
   background: -webkit-linear-gradient(top, #fffb12, #d6c365);
   background: -moz-linear-gradient(top, #fffb12, #d6c365);
   background: -ms-linear-gradient(top, #fffb12, #d6c365);
   background: -o-linear-gradient(top, #fffb12, #d6c365);
   padding: 5px 10px;
   -webkit-border-radius: 8px;
   -moz-border-radius: 8px;
   border-radius: 8px;
   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
   box-shadow: rgba(0,0,0,1) 0 1px 0;
   text-shadow: rgba(0,0,0,.4) 0 1px 0;
   color: #757575;
   font-size: 13px;
   font-family: Georgia, Serif;
   text-decoration: none;
   vertical-align: middle;
   }
.file.button:hover {
   border-top-color: #f2a60e;
   background: #f2a60e;
   color: #d9d9d9;
   }
.file.button:active {
   border-top-color: #1b435e;
   background: #1b435e;
   }

.folder {
   clear:both;
   width:100%;
   padding-top:10px;
   color:red;
}
</style>
</head>
<script type="text/javascript" >
 var app = angular.module("bookDisplay",[]);
 
 app.controller('bookController',function($scope,$http) {
   var request = $http.get("http://home.etechtips.com/web_examples/webservices/books.php");
   request.success(
     function(html) {
      $scope.books = html;
     }
   );
  
 });

</script>
<body >
  <div ng-controller="bookController">

  <input type="text" ng-model="filters.name" size="30" />
  <button class="button" type="button" ng-click="clearFilter()" >
   Clear Filter
  </button> 
  <br />
  <div ng-repeat="book in books | filter: filters.name ">
    <div ng-repeat="boo in book">
       <div ng-show="boo.type == 'folder'" >
         <a href="_BOOKS/{{boo.name}}" ><button class="button {{boo.type}}">{{boo.name}}</button></a> 
       </div>
       <div ng-show="boo.type == 'file'" >
         <a href="_BOOKS/{{boo.name}}" ><button class="button {{boo.type}}">{{boo.display}}</button></a> 
       </div>
    </div>
  </div>
  <textarea cols="60" rows="30" ng-model="books" ng-show="false" ></textarea> 
</div>
</body>
</html>
