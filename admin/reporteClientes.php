<?php
session_start();
if ($_SESSION['rol'] != 'admin') {
    header("Location: productos.php");
    exit();
}

require_once "../controllers/clientesRegistradosController.php";
include("includes/header.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Clientes</title>
    
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
            max-height: 400px;
            overflow-y: auto;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .card-stat {
            color: white;
        }
        
        .card-stat .display-4 {
            font-size: 2.5rem;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="card shadow-lg mb-5">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-users"></i> Reporte de Clientes Registrados</h4>
            </div>
            
            <div class="card-body">
                <!-- Sección de Filtros -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="fecha_inicio">Fecha Inicio:</label>
                        <input type="date" id="fecha_inicio" class="form-control" 
                               value="<?= htmlspecialchars($_GET['fecha_inicio'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="fecha_fin">Fecha Fin:</label>
                        <input type="date" id="fecha_fin" class="form-control" 
                               value="<?= htmlspecialchars($_GET['fecha_fin'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="agrupacion">Agrupar por:</label>
                        <select id="agrupacion" class="form-control">
                            <option value="mes" <?= ($_GET['agrupacion'] ?? 'mes') === 'mes' ? 'selected' : '' ?>>Mes</option>
                            <option value="trimestre" <?= ($_GET['agrupacion'] ?? '') === 'trimestre' ? 'selected' : '' ?>>Trimestre</option>
                            <option value="año" <?= ($_GET['agrupacion'] ?? '') === 'año' ? 'selected' : '' ?>>Año</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-2">
                        <button class="btn btn-primary" onclick="aplicarFiltros()">
                            <i class="fas fa-filter"></i> Aplicar Filtros
                        </button>
                        <button class="btn btn-secondary" onclick="limpiarFiltros()">
                            <i class="fas fa-broom"></i> Limpiar
                        </button>
                    </div>
                </div>

                <!-- Estadísticas Resumidas -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="card card-stat bg-info">
                            <div class="card-body">
                                <h5 class="card-title">Total Clientes</h5>
                                <p class="card-text display-4"><?= number_format($totalClientes) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-stat bg-success">
                            <div class="card-body">
                                <h5 class="card-title">Periodos Analizados</h5>
                                <p class="card-text display-4"><?= number_format(count($datosGrafico)) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-stat bg-warning">
                            <div class="card-body">
                                <h5 class="card-title">Promedio por <?= $agrupacion ?></h5>
                                <p class="card-text display-4"><?= number_format($promedio, 2) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="chart-container">
                            <h5 class="text-center">Registro de Clientes por <?= ucfirst($agrupacion) ?></h5>
                            <canvas id="graficoBarras" height="100"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Botones de Exportación -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <button class="btn btn-success w-100" id="btnExportExcel">
                            <i class="fas fa-file-excel"></i> Exportar a Excel
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-danger w-100" id="btnExportPDF">
                            <i class="fas fa-file-pdf"></i> Exportar a PDF
                        </button>
                    </div>
                </div>

                <!-- Tabla de Registros -->
                <div class="mt-4 table-container">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" id="busqueda" class="form-control" placeholder="Buscar cliente...">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="buscarClientes()">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <span class="badge badge-info">
                                Mostrando <?= count($clientes) ?> de <?= number_format($totalClientes) ?> registros
                            </span>
                        </div>
                    </div>

                    <table class="table table-bordered table-hover" id="tablaClientes">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Fecha de Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $c): ?>
                                <tr>
                                    <td><?= htmlspecialchars($c['nombre'] ?? 'Sin nombre') ?></td>
                                    <td><?= htmlspecialchars($c['correo']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($c['fecha_registro'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    <?php if ($totalPaginas > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php if ($pagina > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?pagina=<?= $pagina-1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                                    <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($pagina < $totalPaginas): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?pagina=<?= $pagina+1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
    // Datos para gráficos
    const chartData = {
        labels: <?= json_encode($labels) ?>,
        data: <?= json_encode($data) ?>,
        agrupacion: "<?= $agrupacion ?>"
    };

    // Configuración inicial
    document.addEventListener('DOMContentLoaded', function() {
        initCharts();
        initEventListeners();
    });

    function initCharts() {
        const ctxBarras = document.getElementById('graficoBarras').getContext('2d');
        window.myChart = new Chart(ctxBarras, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: `Clientes registrados por ${chartData.agrupacion}`,
                    data: chartData.data,
                    backgroundColor: '#3498db',
                    borderColor: '#2980b9',
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
                                return `Clientes: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad de Clientes'
                        },
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: `Periodo (${chartData.agrupacion})`
                        }
                    }
                }
            }
        });
    }

    function initEventListeners() {
        document.getElementById('btnExportExcel').addEventListener('click', exportarExcel);
        document.getElementById('btnExportPDF').addEventListener('click', exportarPDF);
    }

    // Funciones de filtrado
    function aplicarFiltros() {
        const params = new URLSearchParams();
        const fechaInicio = document.getElementById('fecha_inicio').value;
        const fechaFin = document.getElementById('fecha_fin').value;
        const agrupacion = document.getElementById('agrupacion').value;
        
        if (fechaInicio) params.set('fecha_inicio', fechaInicio);
        if (fechaFin) params.set('fecha_fin', fechaFin);
        params.set('agrupacion', agrupacion);
        
        window.location.href = `reporteClientes.php?${params.toString()}`;
    }
    
    function limpiarFiltros() {
        window.location.href = 'reporteClientes.php';
    }
    
    function buscarClientes() {
        const busqueda = document.getElementById('busqueda').value.trim();
        if (busqueda) {
            const params = new URLSearchParams(window.location.search);
            params.set('busqueda', busqueda);
            params.set('pagina', '1');
            window.location.href = `reporteClientes.php?${params.toString()}`;
        }
    }

    // Funciones de exportación
// Función para exportar a Excel
function exportarExcel() {
    // Crear tabla HTML con los datos
    let tablaHTML = `
        <table border="1">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Fecha de Registro</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    // Obtener todos los clientes (no solo los de la página actual)
    const filas = document.querySelectorAll('#tablaClientes tbody tr');
    filas.forEach(fila => {
        const celdas = fila.querySelectorAll('td');
        tablaHTML += `
            <tr>
                <td>${celdas[0].textContent}</td>
                <td>${celdas[1].textContent}</td>
                <td>${celdas[2].textContent}</td>
            </tr>
        `;
    });
    
    // Agregar estadísticas al final
    tablaHTML += `
        <tr><td colspan="3" style="background: #f0f0f0; font-weight: bold;">Estadísticas</td></tr>
        <tr>
            <td colspan="2">Total de Clientes</td>
            <td>${document.querySelector('.card-stat.bg-info .display-4').textContent}</td>
        </tr>
        <tr>
            <td colspan="2">Periodos Analizados</td>
            <td>${document.querySelector('.card-stat.bg-success .display-4').textContent}</td>
        </tr>
        <tr>
            <td colspan="2">Promedio por ${chartData.agrupacion}</td>
            <td>${document.querySelector('.card-stat.bg-warning .display-4').textContent}</td>
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
        <title>Clientes Registrados</title>
        <!--[if gte mso 9]>
        <xml>
            <x:ExcelWorkbook>
                <x:ExcelWorksheets>
                    <x:ExcelWorksheet>
                        <x:Name>Clientes_Registrados</x:Name>
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
    link.download = `Clientes_Registrados_${new Date().toISOString().slice(0,10)}.xls`;
    
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
    doc.text('Reporte de Clientes Registrados', margin, yPosition);
    yPosition += 30;
    
    // Agregar fecha y filtros
    doc.setFontSize(10);
    doc.text(`Generado el: ${new Date().toLocaleDateString()}`, margin, yPosition);
    yPosition += 15;
    
    const fechaInicio = document.getElementById('fecha_inicio').value;
    const fechaFin = document.getElementById('fecha_fin').value;
    const agrupacion = document.getElementById('agrupacion').value;
    
    let filtros = 'Filtros: ';
    if (fechaInicio || fechaFin) {
        filtros += `Período: ${fechaInicio || 'Inicio'} - ${fechaFin || 'Fin'}`;
    }
    filtros += ` | Agrupación: ${agrupacion}`;
    
    doc.text(filtros, margin, yPosition);
    yPosition += 30;
    
    // Agregar estadísticas
    doc.setFontSize(12);
    doc.text(`Total clientes: ${document.querySelector('.card-stat.bg-info .display-4').textContent}`, margin, yPosition);
    yPosition += 20;
    doc.text(`Promedio por ${agrupacion}: ${document.querySelector('.card-stat.bg-warning .display-4').textContent}`, margin, yPosition);
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
            doc.save(`Clientes_Registrados_${new Date().toISOString().slice(0,10)}.pdf`);
            hideLoader(loader);
        });
    }).catch(error => {
        console.error('Error al generar PDF:', error);
        hideLoader(loader);
        alert('Error al generar el PDF. Por favor intente nuevamente.');
    });
}

// Helper functions
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