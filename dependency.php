<?php

/*NOTES*/
/*---> spl_autoload_register() takes a param that is a function
-----> autoload adds the classes as you need them.

For example: 

function loadclasses($classname){
	include 'class/'.$class . '.php';
}


then you can pass the previous function as a param into spl_autoload_register()
spl_autoload_register($loadclasses);
*/



spl_autoload_register(function($class) {
    include 'classes/'.$class . '.php';
});

// 'class/' is an actual folder where you can store all of your classes
// this function includes all your classes for you as you need them, then you won't need to specify all your includes on every padge
// then you only need to include the dependency.php file on your pages.
//any page that you create for your user to go to, include the dependcy file.



// session must start in php, else it doesnt esxit
session_start();
session_regenerate_id(true);
        
        
?>
