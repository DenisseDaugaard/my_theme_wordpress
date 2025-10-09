function burger_menu() {
  console.log('here is my burger-menu');
  
const hamMenu = document.querySelector(".ham-menu");
const offScreenMenu = document.querySelector(".menu");

hamMenu.addEventListener("click", () => {
  hamMenu.classList.toggle("active");
  offScreenMenu.classList.toggle("active");
}); 
}

burger_menu()