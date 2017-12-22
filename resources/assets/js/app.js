
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});


document.addEventListener('DOMContentLoaded', init, false);

function init(){

    var chart = document.getElementById('chart');
  
    
    if(chart){

        var graph = chart.getElementsByClassName('graph');
    
        var arrayPrice = [];
        [].forEach.call(graph, function(element, index){
            arrayPrice.push(parseFloat(element.getAttribute('data-price')));
        });
        console.log(arrayPrice);
        var max = Math.max.apply(Math, arrayPrice);

        [].forEach.call(graph, function(element, index){
            var fixedHeight = (100 * parseFloat(element.getAttribute('data-price'))) / max;
            element.style.height = fixedHeight + '%';
        });

    }

    var formCreate = document.getElementById('spendCreate');

    if(formCreate){
        var inputUsers = document.getElementsByClassName('users_id');
        console.log(inputUsers);
        [].forEach.call(inputUsers, function(element, index){
            element.addEventListener('change', function(){
                
              
                console.log(element.checked);
                if(element.checked){
                    console.log(element.parentNode.parentNode);
                    element.parentNode.parentNode.childNodes[2].disabled = false;
                }else{
                    element.parentNode.parentNode.childNodes[2].disabled = true;
                }
            });
        });
    //     var inputPrice = document.getElementById('price');
        
    //     var price = 0;
    //     inputPrice.addEventListener('focusout', function(){
    //         price = this.value;
    //     }, false);
        
    //     var inputPrices = document.getElementsByClassName('prices');
    //     var inputUsers = document.getElementsByClassName('users_id');
    //     var usersChecked;

    //     [].forEach.call(inputUsers, function(element, index){
    //         element.addEventListener('change', function(){
    //             usersChecked = document.querySelectorAll('.users_id:checked');
    //         });
    //     });
    //     console.log(usersChecked);

    //     var prices = [];
    //     [].forEach.call(inputPrices, function(element, index){
            
    //         element.addEventListener('focusout', function(){
    //             prices = [];
    //             [].forEach.call(inputPrices, function(element, index){
                    
    //                 prices.push(element.value);
    //             });
    //             console.log(prices);
    //         }, false);

    //     });

   }

   var tripForm = document.getElementById('trip-form');
   if(tripForm){
        var addButton = document.getElementsByClassName('add-user')[0];
        var list = document.getElementsByClassName('user-list')[0];
        let template = "<li><label for='name'>name*</label><input id='name' type='text' class='form-control' name='name[]'><label for='email'>email*</label><input id='email' type='text' class='form-control' name='email[]' ><label for='day'>How many day ?*</label><input id='day' type='number' class='form-control' name='day[]' ></li>";
        addButton.addEventListener('click', function(e){
            e.preventDefault();
            list.innerHTML += template;
        });

   }
}
