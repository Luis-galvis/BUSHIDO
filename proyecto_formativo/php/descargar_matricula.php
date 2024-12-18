<?php
include('bd.php');
require(__DIR__ . "/../../vendor/fpdf/fpdf/original/fpdf.php");

// Obtener id_usuario desde GET
$id_usuario = $_GET['id_usuario'] ?? null;
if (!$id_usuario) {
    die("ID de usuario no especificado.");
}

// Consultar datos de usuario, acudiente y matrícula
$query_usuario = "SELECT * FROM usuarios WHERE id_usuario = ?";
$stmt_usuario = mysqli_prepare($conn, $query_usuario);
mysqli_stmt_bind_param($stmt_usuario, 'i', $id_usuario);
mysqli_stmt_execute($stmt_usuario);
$result_usuario = mysqli_stmt_get_result($stmt_usuario);
$usuario = mysqli_fetch_assoc($result_usuario);

$query_acudiente = "SELECT * FROM acudientes WHERE id_usuario = ?";
$stmt_acudiente = mysqli_prepare($conn, $query_acudiente);
mysqli_stmt_bind_param($stmt_acudiente, 'i', $id_usuario);
mysqli_stmt_execute($stmt_acudiente);
$result_acudiente = mysqli_stmt_get_result($stmt_acudiente);
$acudiente = mysqli_fetch_assoc($result_acudiente);

$query_matricula = "SELECT * FROM matricula WHERE id_usuario = ?";
$stmt_matricula = mysqli_prepare($conn, $query_matricula);
mysqli_stmt_bind_param($stmt_matricula, 'i', $id_usuario);
mysqli_stmt_execute($stmt_matricula);
$result_matricula = mysqli_stmt_get_result($stmt_matricula);
$matricula = mysqli_fetch_assoc($result_matricula);

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Título
$pdf->Cell(200, 10, 'Datos de la Matrícula', 0, 1, 'C');

// Agregar una línea de separación
$pdf->Line(10, 30, 200, 30);


// Agregar un rectángulo alrededor de la tabla

// Crear la tabla con celdas
function agregarFila($pdf, $col1, $col2) {
    // Primer columna (Centrado)
    $pdf->Cell(95, 10, $col1, 1, 0, 'C');
    // Segunda columna (Centrado)
    $pdf->Cell(95, 10, $col2, 1, 1, 'C');
}

$pdf->SetFont('Arial', '', 12);

// Encabezado de la tabla
$pdf->SetFillColor(201, 22, 22);  // Fondo rosado para el encabezado
$pdf->Cell(190, 10, 'DATOS USUARIO', 1, 1, 'C', true);


// Datos del usuario
agregarFila($pdf, 'Nombre', $usuario['nombre'] . ' ' . $usuario['apellidos']);
agregarFila($pdf, 'Documento', $usuario['documento']);
agregarFila($pdf, 'Tipo Documento', $usuario['tipo_documento']);
agregarFila($pdf, 'Edad', $usuario['edad']);
agregarFila($pdf, 'Dirección', $usuario['direccion']);
agregarFila($pdf, 'Teléfono', $usuario['numero_tel']);
agregarFila($pdf, 'Lugar Expedición', $usuario['lugar_expedicion']);
agregarFila($pdf, 'Fecha Nacimiento', $usuario['fecha_naci']);
agregarFila($pdf, 'Correo', $usuario['correo']);
agregarFila($pdf, 'EPS', $usuario['eps']);
agregarFila($pdf, 'Peso', $usuario['peso']);
agregarFila($pdf, 'Talla', $usuario['talla']);
agregarFila($pdf, 'Género', $usuario['genero']);
agregarFila($pdf, 'Lesiones', $usuario['lesiones']);
agregarFila($pdf, 'Recomendación Médica', $usuario['recomendacion_medica']);
agregarFila($pdf, 'Régimen Especial', $usuario['regimen_especial']);
agregarFila($pdf, 'Medicina Prevenida', $usuario['medicina_pregada']);
agregarFila($pdf, 'Grupo Sanguíneo', $usuario['grupo_sanguineo']);
agregarFila($pdf, 'Antecedentes Familiares', $usuario['antecedentes_familiares']);
agregarFila($pdf, 'Enfermedad', $usuario['sufre_enfermedad']);
agregarFila($pdf, 'Alergias', $usuario['sufre_alergias']);
agregarFila($pdf, 'Medicamentos', $usuario['toma_medicamentos']);

// Salto de línea antes de los datos del acudiente
$pdf->Ln(5);
$pdf->SetFillColor(201, 22, 22);  // Fondo rosado para el encabezado
$pdf->Cell(190, 10, 'DATOS ACUDIENTE', 1, 1, 'C', true);




agregarFila($pdf, 'Nombre', $acudiente['nombre'] . ' ' . $acudiente['apellido']);
agregarFila($pdf, 'Documento', $acudiente['documento_identidad']);
agregarFila($pdf, 'Fecha Nacimiento', $acudiente['fecha_nacimiento']);
agregarFila($pdf, 'Dirección', $acudiente['direccion']);
agregarFila($pdf, 'Teléfono', $acudiente['telefono']);
agregarFila($pdf, 'Correo Electrónico', $acudiente['correo_electronico']);
agregarFila($pdf, 'Parentesco', $acudiente['parentesco']);
agregarFila($pdf, 'Ocupación', $acudiente['ocupacion']);
agregarFila($pdf, 'Empresa', $acudiente['empresa']);
agregarFila($pdf, 'Tipo Documento', $acudiente['tipo_documento']);
agregarFila($pdf, 'Género', $acudiente['genero']);
agregarFila($pdf, 'Lugar Expedición', $acudiente['lugar_expedicion']);

// Salto de línea antes de los datos del acudiente
$pdf->Ln(5);
$pdf->SetFillColor(201, 22, 22);  // Fondo rosado para el encabezado
$pdf->Cell(190, 10, 'DATOS MATRICULA', 1, 1, 'C', true);

// Salto de línea antes de los datos de matrícul
agregarFila($pdf, 'Fecha Matrícula', $matricula['fecha_matricula']);
agregarFila($pdf, 'Hora Matrícula', $matricula['hora_matricula']);







// Generar el PDF
$pdf->Output('D', 'matricula_usuario_' . $id_usuario . '.pdf');
?>


