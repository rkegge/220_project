let k = document.getElementById('k');
let bb = document.getElementById('bb');
let b = document.getElementById('b');
let rr = document.getElementById('rr');
let w = document.getElementById('w');

let bk = document.getElementById('bk');

let log = document.getElementById('log');

let div = document.getElementById('parallax');

window.addEventListener('scroll', () => {
	let value = window.scrollY;

	k.style.right = value * 1.5 + 'px';
	// k.style.top = value * 1.5 + 'px';

	rr.style.top = -490 + value * -1.5 + 'px';
	
	rr.style.right = value * -1.5 + 'px';

	bb.style.left = 1800 + value * 1.5 + 'px';
	bb.style.top = -390 + value * -1.5 + 'px';

	k.style.left = -190 + value * -0.5 + 'px';
	k.style.top = -490 + value * -0.5 + 'px';

	b.style.left = 1190 + value * 0.3 + 'px';
	b.style.top = -190 + value * -1.2 + 'px';

	w.style.left = value * 0.5 + 'px';
	w.style.top = -590 + value * -0.5 + 'px';

	// console.log("VALUE " + window.scrollY);
	// while(window.scrollY < 3000){
	// 	bk.style.top =  value * 0.3 + 'px';
	// }

	// log.style.top = 800 + value * -2 + 'px';
	
});