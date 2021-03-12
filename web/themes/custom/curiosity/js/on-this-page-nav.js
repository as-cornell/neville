/*
  On this page "OTP" navigation
  - add .active to first item
  - observers to change active to different links based on location of intersection sections
*/

(function ($) {
  $(".otpNav").first().first().addClass("active");
  $(".otpToggle").on({
  click: function () {
    $(".otpNav").toggleClass("expanded");
  },
});

})(jQuery);

const targets = document.querySelectorAll(".pageSection");
const navOptions = {
  threshold: 0,
  rootMargin: "-200px",
};

const navObserver = new IntersectionObserver((entries, navObserver) => {
  entries.forEach((entry) => {
    console.log(entry);
    if (!entry.isIntersecting) {
      return;
    } else {
      document.querySelector(".active").classList.remove("active");
      var id = entry.target.getAttribute("id");
      var newLink = document
        .querySelector(`[href="#${id}"]`)
        .classList.add("active");
    }
  });
}, navOptions);

targets.forEach((target) => {
  navObserver.observe(target);
});



// watch .title if not intersecting add class 'stuck' to otpNav
const pageTitle = document.querySelector(".main > .title");
const mainContainer = document.querySelector(".main");

const otpNavOptions = {
  threshold: 0,
  // rootMargin: "200px 0px 0px 0px",
};

const otpNavObserver = new IntersectionObserver(function (entries, optNavObserver) { 
  entries.forEach(entry => {
    // console.log(entry.target);
    if (!entry.isIntersecting) {
      mainContainer.classList.add('otpStuck');
    } else {
      mainContainer.classList.remove('otpStuck');
    }
  });
}, otpNavOptions);

otpNavObserver.observe(pageTitle);
