/*
  Inpage navigation observers
  - watch sections
  - get get id's and match to the # at the end of the navigation.
  - if section intersecting, change class on the nav item
*/

// // watch sections with class navTarget
// const targets = document.querySelectorAll(".pcWrapper--page-section");

// // set navOptions
// const navOptions = {
//   threshold: 0.55,
// };

// const navObserver = new IntersectionObserver((entries, navObserver) => {
//   entries.forEach((entry) => {
//     if (!entry.isIntersecting) {
//       return;
//     } else {
//       console.log(entry);
//       // remove old active class
//       document.querySelector(".active").classList.remove("active");
//       // get id of the intersecting section
//       var id = entry.target.getAttribute("id");
//       // find matching link & add appropriate class
//       var newLink = document
//         .querySelector(`[href="#${id}"]`)
//         .classList.add("active");
//     }
//   });
// }, navOptions);

// targets.forEach((target) => {
//   navObserver.observe(target);
// });

// watch sections with class navTarget
// console.log("observers-activated");
// const targets = document.querySelectorAll(".navTarget");
// console.log("observers");

// const asideNav = document.querySelector(".asideNavWrapper");
// const sectionOne = document.querySelector(".title");

// const sectionOneOptions = {
//   rootMargin: "100px 0px 0px 0px",
// };

// const sectionOneObserver = new IntersectionObserver(function (
//   entries,
//   sectionOneObserver
// ) {
//   entries.forEach((entry) => {
//     console.log(entry.target);
//     if (!entry.isIntersecting) {
//       asideNav.classList.add("stuck");
//     } else {
//       asideNav.classList.remove("stuck");
//     }
//   });
// },
// sectionOneOptions);
// sectionOneObserver.observe(sectionOne);

// // watch sections with class navTarget
// const targets = document.querySelectorAll(".navTarget");

// // set navOptions
// const navOptions = {
//   threshold: 0.55,
// };

// const navObserver = new IntersectionObserver((entries, navObserver) => {
//   entries.forEach((entry) => {
//     if (!entry.isIntersecting) {
//       return;
//     } else {
//       // remove old active class
//       document.querySelector(".active").classList.remove("active");
//       // get id of the intersecting section
//       var id = entry.target.getAttribute("id");
//       // find matching link & add appropriate class
//       var newLink = document
//         .querySelector(`[href="#${id}"]`)
//         .classList.add("active");
//     }
//   });
// }, navOptions);

// targets.forEach((target) => {
//   navObserver.observe(target);
// });
