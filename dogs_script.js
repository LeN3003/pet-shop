
let preveiwContainer = document.querySelector('.products-preview');
let previewBox = preveiwContainer.querySelectorAll('.preview');

document.querySelectorAll('.products-container .product').forEach(product =>{
  product.onclick = () =>{
    preveiwContainer.style.display = 'flex';
    let name = product.getAttribute('data-name');
    previewBox.forEach(preview =>{
      let target = preview.getAttribute('data-target');
      if(name == target){
        preview.classList.add('active');
      }
    });
  };
});

previewBox.forEach(close =>{
  close.querySelector('.fa-times').onclick = () =>{
    close.classList.remove('active');
    preveiwContainer.style.display = 'none';
  };
});






//new


$(document).ready(function(){
  $(".dry_dog_food").click(function(){
    $("#div1").fadeToggle();
  });
});

$(document).ready(function(){
  $(".wet_dog_food").click(function(){
    $("#div2").fadeToggle();
  });
});

$(document).ready(function(){
  $(".dog_toys").click(function(){
    $("#div3").fadeToggle();
  });
});

$(document).ready(function(){
  $(".dog_accessories").click(function(){
    $("#div4").fadeToggle();
  });
});

$(document).ready(function(){
  $(".carriers_travel").click(function(){
    $("#div5").fadeToggle();
  });
});