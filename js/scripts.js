/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var theme = 1;

$(document).ready(function() { 
    
    

    $("#preview-btn").click("click", function(){
        
            console.log("here");
        if( $("#themes option[value='theme1']").prop('selected') == true){
            
            window.open('theme1.php','_blank');
        }
        else if( $("#themes option[value='theme2']").prop('selected') == true ){
            
            window.open('theme2.php','_blank');
        }
        else if( $("#themes option[value='theme3']").prop('selected') == true ){

            window.open('theme3.php','_blank');
        }
        
       
        //console.log($("#themes option[value='theme3']").prop('selected'));
    });
    


});


    
    




