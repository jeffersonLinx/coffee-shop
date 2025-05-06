<?php
session_start();
if ($_SESSION['rol'] != 'admin') {
    header("Location: productos.php");
    exit();
}
require_once "../controllers/reporteContactoController.php";
include("includes/header.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Mensajes de Contacto</title>
    
    <!-- CDNs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .chart-container {
            position: relative;
            margin: auto;
            width: 100%;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .table-container {
            max-height: 500px;
            overflow-y: auto;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .card-stat {
            color: white;
            transition: transform 0.3s;
        }
        
        .card-stat:hover {
            transform: translateY(-5px);
        }
        
        .badge-info {
            background-color: #17a2b8;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="card shadow-lg mb-5">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-envelope"></i> Reporte de Mensajes de Contacto</h4>
            </div>
            
            <div class="card-body">
                <!-- Sección de Filtros -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="anio">Filtrar por año:</label>
                        <select id="anio" class="form-control">
                            <?php foreach ($anios as $anio): ?>
                                <option value="<?= $anio['anio'] ?>" <?= $anio['anio'] == $filtroAnio ? 'selected' : '' ?>>
                                    <?= $anio['anio'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="busqueda">Buscar:</label>
                        <div class="input-group">
                            <input type="text" id="busqueda" class="form-control" placeholder="Nombre, correo o asunto..." value="<?= htmlspecialchars($busqueda) ?>">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="aplicarFiltros()">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-secondary w-100" onclick="limpiarFiltros()">
                            <i class="fas fa-broom"></i> Limpiar
                        </button>
                    </div>
                </div>

                <!-- Estadísticas Resumidas -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="card card-stat bg-info">
                            <div class="card-body text-center">
                                <h5 class="card-title">Total Mensajes en <?= $filtroAnio ?></h5>
                                <p class="card-text display-4"><?= number_format($totalMensajes) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="chart-container">
                            <h5 class="text-center">Mensajes Recibidos por Mes (<?= $filtroAnio ?>)</h5>
                            <canvas id="graficoBarras" height="80"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Botones de Exportación -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <button class="btn btn-success w-100" onclick="exportarExcel()">
                            <i class="fas fa-file-excel"></i> Exportar a Excel
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-danger w-100" onclick="exportarPDF()">
                            <i class="fas fa-file-pdf"></i> Exportar a PDF
                        </button>
                    </div>
                </div>

                <!-- Tabla de Mensajes -->
                <div class="mt-4 table-container">
                    <table class="table table-bordered table-hover" id="tablaMensajes">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Asunto</th>
                                <th>Fecha de Envío</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mensajes as $mensaje): ?>
                                <tr>
                                    <td><?= htmlspecialchars($mensaje['nombre']) ?></td>
                                    <td><?= htmlspecialchars($mensaje['correo']) ?></td>
                                    <td><?= htmlspecialchars($mensaje['asunto']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($mensaje['fecha_envio'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <?php if (empty($mensajes)): ?>
                        <div class="alert alert-info text-center mt-3">
                            No se encontraron mensajes con los filtros aplicados
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>

    <script>
    // Datos para gráficos
    const chartData = {
        labels: <?= json_encode($labels) ?>,
        data: <?= json_encode($data) ?>,
        anio: <?= $filtroAnio ?>
    };

    // Inicialización
    document.addEventListener('DOMContentLoaded', function() {
        initChart();
    });

    function initChart() {
        const ctx = document.getElementById('graficoBarras').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: `Mensajes recibidos en ${chartData.anio}`,
                    data: chartData.data,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Mensajes: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad de Mensajes'
                        },
                        ticks: {
                            precision: 0,
                            stepSize: 1
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mes'
                        }
                    }
                }
            }
        });
    }

    // Funciones de filtrado
    function aplicarFiltros() {
        const anio = document.getElementById('anio').value;
        const busqueda = document.getElementById('busqueda').value.trim();
        
        let url = `reporteContacto.php?anio=${anio}`;
        if (busqueda) {
            url += `&busqueda=${encodeURIComponent(busqueda)}`;
        }
        
        window.location.href = url;
    }
    
    function limpiarFiltros() {
        window.location.href = 'reporteContacto.php';
    }

    // Funciones de exportación (similares a las anteriores)
// Función para exportar a Excel
function exportarExcel() {
    // Crear tabla HTML con los datos
    let tablaHTML = `
        <table border="1">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Asunto</th>
                    <th>Fecha de Envío</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    // Obtener todos los mensajes de la tabla
    const filas = document.querySelectorAll('#tablaMensajes tbody tr');
    filas.forEach(fila => {
        const celdas = fila.querySelectorAll('td');
        tablaHTML += `
            <tr>
                <td>${celdas[0].textContent}</td>
                <td>${celdas[1].textContent}</td>
                <td>${celdas[2].textContent}</td>
                <td>${celdas[3].textContent}</td>
            </tr>
        `;
    });
    
    // Agregar estadísticas al final
    tablaHTML += `
        <tr><td colspan="4" style="background: #f0f0f0; font-weight: bold;">Estadísticas</td></tr>
        <tr>
            <td colspan="3">Total de Mensajes en ${chartData.anio}</td>
            <td>${document.querySelector('.card-stat .display-4').textContent}</td>
        </tr>
            </tbody>
        </table>
    `;
    
    // Configuración para Excel
    const uri = 'data:application/vnd.ms-excel;charset=UTF-8;base64,';
    const template = `<?xml version="1.0" encoding="UTF-8"?>
        <html xmlns:o="urn:schemas-microsoft-com:office:office" 
              xmlns:x="urn:schemas-microsoft-com:office:excel" 
              xmlns="http://www.w3.org/TR/REC-html40">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Mensajes de Contacto</title>
        <!--[if gte mso 9]>
        <xml>
            <x:ExcelWorkbook>
                <x:ExcelWorksheets>
                    <x:ExcelWorksheet>
                        <x:Name>Mensajes_Contacto</x:Name>
                        <x:WorksheetOptions>
                            <x:DisplayGridlines/>
                            <x:FitToPage/>
                            <x:Print>
                                <x:ValidPrinterInfo/>
                                <x:FitWidth>1</x:FitWidth>
                                <x:FitHeight>1</x:FitHeight>
                            </x:Print>
                        </x:WorksheetOptions>
                    </x:ExcelWorksheet>
                </x:ExcelWorksheets>
            </x:ExcelWorkbook>
        </xml>
        <![endif]-->
        </head>
        <body>${tablaHTML}</body></html>`;
    
    // Codificación base64
    const base64 = function(s) {
        return window.btoa(unescape(encodeURIComponent(s)));
    };
    
    // Crear y descargar archivo
    const link = document.createElement('a');
    link.href = uri + base64(template);
    link.download = `Mensajes_Contacto_${new Date().toISOString().slice(0,10)}.xls`;
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Función para exportar a PDF
function exportarPDF() {
    const loader = showLoader();
    
    // Verificar que las librerías estén cargadas
    if (!window.jspdf || !window.html2canvas) {
        hideLoader(loader);
        alert('Error: Las librerías necesarias no están cargadas correctamente');
        return;
    }
    
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'pt', 'a4');
    
    // Configuración
    const margin = 40;
    const pageWidth = doc.internal.pageSize.getWidth() - (margin * 2);
    let yPosition = margin;
    
    // Agregar título
    doc.setFontSize(18);
    doc.setTextColor(40, 40, 40);
    doc.text('Reporte de Mensajes de Contacto', margin, yPosition);
    yPosition += 30;
    
    // Agregar fecha y filtros
    doc.setFontSize(10);
    doc.text(`Generado el: ${new Date().toLocaleDateString()}`, margin, yPosition);
    yPosition += 15;
    
    const anio = document.getElementById('anio').value;
    const busqueda = document.getElementById('busqueda').value;
    
    doc.text(`Año: ${anio} | Búsqueda: ${busqueda || 'Ninguna'}`, margin, yPosition);
    yPosition += 30;
    
    // Agregar estadísticas
    doc.setFontSize(12);
    doc.text(`Total mensajes en ${anio}: ${document.querySelector('.card-stat .display-4').textContent}`, margin, yPosition);
    yPosition += 30;
    
    // Opciones para html2canvas
    const options = {
        scale: 2,
        useCORS: true,
        allowTaint: true,
        logging: true,
        scrollY: 0
    };
    
    // Capturar el gráfico primero
    const canvasGrafico = document.getElementById('graficoBarras');
    
    html2canvas(canvasGrafico, options).then(canvasG => {
        const imgDataGrafico = canvasG.toDataURL('image/png');
        const imgHeightGrafico = (canvasG.height * pageWidth) / canvasG.width;
        
        // Asegurarse que el gráfico quepa en la página
        if (yPosition + imgHeightGrafico > doc.internal.pageSize.getHeight() - margin) {
            doc.addPage();
            yPosition = margin;
        }
        
        doc.addImage(imgDataGrafico, 'PNG', margin, yPosition, pageWidth, imgHeightGrafico);
        yPosition += imgHeightGrafico + 20;
        
        // Ahora capturar la tabla
        const elementTabla = document.querySelector('.table-container');
        
        return html2canvas(elementTabla, options).then(canvasT => {
            const imgDataTabla = canvasT.toDataURL('image/png');
            const imgHeightTabla = (canvasT.height * pageWidth) / canvasT.width;
            
            // Verificar si necesita nueva página
            if (yPosition + imgHeightTabla > doc.internal.pageSize.getHeight() - margin) {
                doc.addPage();
                yPosition = margin;
            }
            
            doc.addImage(imgDataTabla, 'PNG', margin, yPosition, pageWidth, imgHeightTabla);
            
            // Guardar el PDF
            doc.save(`Mensajes_Contacto_${new Date().toISOString().slice(0,10)}.pdf`);
            hideLoader(loader);
        });
    }).catch(error => {
        console.error('Error al generar PDF:', error);
        hideLoader(loader);
        alert('Error al generar el PDF. Por favor intente nuevamente.');
    });
}

// Helper functions (las mismas del reporte de clientes)
function showLoader() {
    const loader = document.createElement('div');
    loader.id = 'pdf-loader';
    loader.style.position = 'fixed';
    loader.style.top = '0';
    loader.style.left = '0';
    loader.style.width = '100%';
    loader.style.height = '100%';
    loader.style.backgroundColor = 'rgba(0,0,0,0.7)';
    loader.style.display = 'flex';
    loader.style.flexDirection = 'column';
    loader.style.justifyContent = 'center';
    loader.style.alignItems = 'center';
    loader.style.zIndex = '9999';
    
    loader.innerHTML = `
        <div class="spinner-border text-light" role="status">
            <span class="sr-only">Cargando...</span>
        </div>
        <div style="color: white; font-size: 1.2rem; margin-top: 15px;">
            Generando documento, por favor espere...
        </div>
    `;
    
    document.body.appendChild(loader);
    return loader;
}

function hideLoader(loader) {
    if (loader && loader.parentNode) {
        loader.parentNode.removeChild(loader);
    } else {
        const existingLoader = document.getElementById('pdf-loader');
        if (existingLoader) {
            existingLoader.parentNode.removeChild(existingLoader);
        }
    }
}
    </script>
</body>
</html>