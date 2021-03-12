
/*
  back to top
  - add .active to first item
  - observers to change active to different links based on location of intersection sections
  - watch pageTitle1, do stuff to .toTopButton
*/

// watch .title if not intersecting add class 'stuck' to otpNav
const pageTitle1 = document.querySelector(".main > .title");
const toTopButton = document.querySelector(".toTopButton");

const otpNavOptions1 = {
  threshold: 0,
  // rootMargin: "200px 0px 0px 0px",
};

const toTopObserver = new IntersectionObserver(function (entries, toTopObserver) { 
  entries.forEach(entry => {
    console.log(entry.target);
    if (!entry.isIntersecting) {
      toTopButton.classList.add('show');
    } else {
      toTopButton.classList.remove('show');
    }
  });
}, otpNavOptions1);

toTopObserver.observe(pageTitle1);
