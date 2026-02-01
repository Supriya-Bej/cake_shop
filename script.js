

// Make Timeline
var tl = gsap.timeline({
    scrollTrigger: {
        trigger: ".two",
        start: "0% 95%",//First value is "div" and second value is for "screen"
        end: "70% 50%",
        scrub: true, //Provide Reverse animation
        // markers: true
    }
})

tl.to("#fanta", {
    width: "25%",
    top: "116%",
    left: "6%"
}, 'orange')
tl.to("#slice", {
    width: "15%",
    top: "160%",
    left: "23%"
}, 'orange')
tl.to("#orange", {
    width: "15%",
    top: "160%",
    right: "5%"
}, 'orange')
tl.to("#leaf1", {
    top: "110%",
    rotate: "130deg",
    left: "81%"
}, 'orange')
tl.to("#leaf2", {
    top: "110%",
    rotate: "130deg",
    left: "0%"
}, 'orange')


// Make Timeline
var tl2 = gsap.timeline({
    scrollTrigger: {
        trigger: ".three",
        start: "0% 95%",
        end: "20% 50%",
        scrub: true,
        // markers: true
    }
})

tl2.to("#slice", {
    left: "40%",
    width: "20%",
    top: "200%"
}, 'orange')
tl2.to("#fanta", {
    left: "38%",
    width: "25%",
    top: "210%"
}, 'orange')
