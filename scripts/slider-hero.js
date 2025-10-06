document.addEventListener("DOMContentLoaded", () => {
  initializeSlider();
});


function initializeSlider(){

  let carousel = document.querySelector(".slides-container")
  let slides = carousel.querySelectorAll(".slide")
  let slideIndex = 0  // this is our current img or slide we show in the browser 
  let nextButton = document.getElementById("slide-arrow-next")
  let prevButton = document.getElementById("slide-arrow-prev")
  console.log(nextButton, prevButton);
  
  let changer // this has to be here, because then we can use it in all our code!!!
  
  //4
  function changeAutomatic (){
      changer = setInterval(nextSlide, 5000);
  }
  carousel.addEventListener("mouseenter", function(){
      clearInterval(changer) // add a propety or funtion
  })
  carousel.addEventListener("mouseleave", changeAutomatic)
    
  
  /* ---------------------------------------- */
  //3
      console.log(slides.length);
  
          function nextSlide (){
              slideIndex++
  
              if(slideIndex == slides.length){    // if we go to the 5th slide, insted of a having a blank page for the next element, we want to be back to the beginning
                  slideIndex = 0                 // then the current slide has to be the first one witch has a index of 0
              }
              showSlide(slideIndex)
          }

  nextButton.addEventListener("click", nextSlide)
      /* ----------------------------------------- */
   //2
          function previusSlide (){
              slideIndex--
              // the Dobble == its a compatation, a single = its an asigment of a value!!!!
              if(slideIndex == -1){                // if the current slide es the last one = -1
                  slideIndex = slides.length -1;  // then the number of slides to go has to be 4 sa, if slides.length = 5, we say slides.length -1 == 5
              }
              showSlide(slideIndex)
          }
          
  prevButton.addEventListener("click", previusSlide)
      /* ------------------------------------------- */
  //1
  
          // en the first part of the funtion, we hide all elemnts. In the second part we show just one
          function showSlide (index){
            
              slides.forEach(function(slide, i){ // here we make to paralale node list that responde to each other // first is the element == slide ,  i == the place to take
                  slide.classList.remove("slide--visible")
            
              })
              slides[index].classList.add("slide--visible")
            
          }
  
          showSlide (slideIndex)
          changeAutomatic ()
}
