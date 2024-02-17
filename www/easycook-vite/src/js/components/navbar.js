/* script du composant navbar */
window.addEventListener("load", () => {
	document.querySelectorAll(".navbar_toggle_button").forEach((elem) => {
		console.log(elem);
		let span = document.createElement("span");
		elem.append(span);
		elem.onclick = () => {
			const targetName = elem.getAttribute("data-target");
			const target = document.querySelector(targetName);
			target.classList.toggle("toggled");
			elem.classList.toggle("toggled");
			if (target.classList.contains("toggled")) {
				target.style.transform = "translateX(100%)";
				target.style.top= document.querySelector(".container").offsetHeight +"px";
				target.style.paddingBottom= (document.querySelector(".container").offsetHeight +30) +"px";
				document.querySelector(".navbar").style.position = "fixed";
				
			} else {
				target.style.transform = "translateX(-100%)";
				document.querySelector(".navbar").style.position = "relative";
			}
		};
	});
});
