document.addEventListener("DOMContentLoaded", function() {
    const modal2 = document.getElementById("imagenGrandeContainer2");
    const modalImg2 = document.getElementById("imagenGrande2");
    const closeBtn2 = document.getElementById("btnCerrar2");

    document.querySelectorAll(".btn-ver-imagen-2").forEach(btn => {
        btn.addEventListener("click", function() {
            const imgSrc = this.getAttribute("data-img");
            modalImg2.src = imgSrc;
            // Restablecer el tamaño del contenedor antes de mostrar la imagen
            modal2.style.width = null;
            modal2.style.height = null;
            modal2.style.display = "block";
        });
    });

    closeBtn2.addEventListener("click", function() {
        modal2.style.display = "none";
    });

    modal2.addEventListener("click", function(e) {
        if (e.target === modal2) {
            modal2.style.display = "none";
        }
    });
});
