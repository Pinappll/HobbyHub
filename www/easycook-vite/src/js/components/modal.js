/* script du composant modal */
window.addEventListener("load", () => {
	document.querySelectorAll(".modal").forEach((elem) => { // on récupère tous les éléments avec la classe modal et on boucle dessus
		initModal(elem);// on initialise les modals au chargement de la page (on peut aussi le faire au clic sur un bouton par exemple)
	});
}); /* on attend que la page soit chargée pour initialiser les modals */

const initModal = (elem) => {
	const id = elem.id;
	document.querySelectorAll('[data-modal-open="' + id + '"]').forEach((btn) => {
		console.log(btn);
		btn.addEventListener("click", () => {
			open(elem);
		});
	});
	document.querySelectorAll("[data-modal-close]").forEach((btn) => {
		btn.addEventListener("click", (e) => {
			const modal = e.target.closest(".modal");
			close(modal);
		});
	});
};

const open = (elem) => {
	elem.style.display = "flex";
};

const close = (elem) => {
	elem.style.display = "none";
};
