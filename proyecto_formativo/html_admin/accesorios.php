<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarifas</title>
    <link rel="stylesheet" href="../css_admin/main_Ad.css">
    <link rel="stylesheet" href="../css_admin/acesorio.css">
    <link rel="shortcut icon"
        href="../fotos/bushido-removebg-preview-removebg-preview-removebg-preview.png">

</head>

<body>
    <header class="Header">
        <div class="left-links">
            <ul class="nav-links">
                <li><a href="main_ad.html">Inicio</a></li>
                <li><a href="tarifas_ac.html">Grupos y accesorios</a></li>
                <li><a href="rango.php">rango </a></li>
                <li><a href="matricula.html">matricula</a></li>
            </ul>
        </div>
        <div class="logo">
            <a href="../html_admin/main_ad.html"><img src="../fotos/nuevobushido.png" alt="Logo de la marca"></a>
        </div>
        <div class="right-links">
            <ul class="nav-links">
                <li><a href="act_matri.html">actualizar matricula</a></li>
                <li><a href="pagos.html">pagos</a></li>
                <li><a href="comentariosad.html">Informacion</a></li>
                <li><a href="asistencia.html">asistencia</a></li>
                <li><a href="../html_usuario/index.html">salir</a></li>
            </ul>
        </div>
    </header> 

    <div id="accessoryContainer" class="container">
    <?php include '../php/get_dotacion.php'; ?>
</div>

    

    <!-- Ventana Emergente (Modal) -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="editForm">
                <input type="hidden" id="dotacionId" name="id_dotacion">
                <label for="itemName">Nombre:</label><br>
                <input type="text" id="itemName" name="nombre" value=""><br><br>
    
                <label for="itemFeatures">Descripción:</label><br>
                <textarea id="itemFeatures" name="descripcion"></textarea><br><br>
    
                <label for="itemPrice">Precio:</label><br>
                <input type="number" id="itemPrice" name="precio" value=""><br><br>
    
                <label for="imageUpload">Cambiar Imagen:</label><br>
                <input type="file" id="imageUpload" name="imagen" accept="image/*"><br><br>
                <img id="imagePreview" src="" alt="Vista previa" style="max-width: 100%;"><br><br>
    
                <button type="button" id="saveBtn" class="save-button">Guardar Cambios</button>
            </form>
            <button id="deleteBtn" class="delete-button">Eliminar Accesorio</button>
        </div>
    </div>
    

    <script>
const modal = document.getElementById("editModal");
const closeBtn = document.querySelector(".close");

// Abre el modal al hacer clic en un botón de edición
document.querySelectorAll(".info").forEach(function (editIcon) {
    editIcon.onclick = function () {
        const box = editIcon.closest(".box");
        const idDotacion = box.dataset.id;
        const imgSrc = box.querySelector("img").src;
        const name = box.querySelector(".item-name").textContent;
        const description = box.querySelector(".item-description").textContent;
        const price = box.querySelector(".item-price").textContent.replace("$", "").trim();

        // Rellena los campos del formulario con la información del accesorio
        document.getElementById("dotacionId").value = idDotacion;
        document.getElementById("itemName").value = name;
        document.getElementById("itemFeatures").value = description;
        document.getElementById("itemPrice").value = price;
        document.getElementById("imagePreview").src = imgSrc;

        // Muestra el modal
        modal.style.display = "block";
    };
});

// Cierra el modal al hacer clic en la 'X'
closeBtn.onclick = function () {
    modal.style.display = "none";
};

// Cierra el modal al hacer clic fuera de su contenido
window.onclick = function (event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
};


document.getElementById("saveBtn").onclick = function () {
    const formData = new FormData(document.getElementById("editForm"));

    fetch("../php/update_dotacion.php", {
        method: "POST",
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Cambios guardados con éxito.");
                location.reload();
            } else {
                alert("Error al guardar los cambios.");
            }
        })
        .catch(error => console.error("Error:", error));
};

document.getElementById("deleteBtn").onclick = function () {
    const idDotacion = document.getElementById("dotacionId").value;

    fetch(`../php/delete_dotacion.php?id=${idDotacion}`, {
        method: "GET",
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Accesorio eliminado con éxito.");
                location.reload();
            } else {
                alert("Error al eliminar el accesorio.");
            }
        })
        .catch(error => console.error("Error:", error));
};

    </script>

</body>

</html>