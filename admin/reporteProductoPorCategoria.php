<?php
session_start();
if ($_SESSION['rol'] != 'admin') {
    echo "<script>alert('Acceso denegado: No tienes permisos en esta sección.'); window.location.href = 'productos.php';</script>";
    exit();
}
require_once "../controllers/reporteProductoPorCategoriaController.php";
include("includes/header.php");
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!--  -->
<!-- Agrega estas líneas con los demás scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<!--  -->
<div class="container mt-4">
    <div class="card shadow-lg mb-5">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">📊 Reporte de Productos por Categoría</h4>
        </div>
        <div class="card-body">

            <!-- Filtros -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Filtrar por Estado:</label>
                    <select id="filtroEstado" class="form-control">
                        <option value="">Todos</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button class="btn btn-secondary w-100" onclick="restaurarFiltros()">
                        <i class="fas fa-sync-alt"></i> Limpiar Filtros
                    </button>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="row">
                <div class="col-md-8">
                    <div class="chart-container">
                        <canvas id="graficoBarras" height="150"></canvas>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart-container">
                        <canvas id="graficoTorta" height="200"></canvas>
                    </div>
                </div>
            </div>
<!-- Después de los filtros, antes de los gráficos -->
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
            <!-- Tabla de registros -->
            <div class="mt-4" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Categoría</th>
                            <th>Cantidad de Productos</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productosPorCategoria as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['nombre_categoria']) ?></td>
                                <td><?= $item['total_productos'] ?></td>
                                <td>
                                    <span class="badge <?= $item['estado'] ? 'badge-success' : 'badge-danger' ?>">
                                        <?= $item['estado'] ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const datosGraficoBarras = <?= json_encode($datosGraficoBarras) ?>;
    const datosGraficoTorta = <?= json_encode($datosGraficoTorta) ?>;
    
    let graficoBarras;
    let graficoTorta;

    function actualizarGraficos(filtroEstado = '') {
        // Filtrar datos si es necesario
        const datosFiltradosBarras = filtroEstado === '' ? 
            datosGraficoBarras : 
            datosGraficoBarras.filter(item => item.estado == filtroEstado);
            
        const datosFiltradosTorta = filtroEstado === '' ? 
            datosGraficoTorta : 
            datosGraficoTorta.filter(item => item.estado == filtroEstado);

        // Actualizar gráfico de barras
        actualizarGraficoBarras(datosFiltradosBarras);
        
        // Actualizar gráfico de torta
        actualizarGraficoTorta(datosFiltradosTorta);
    }

    function actualizarGraficoBarras(datos) {
        const ctx = document.getElementById('graficoBarras').getContext('2d');
        
        // Destruir gráfico anterior si existe
        if (graficoBarras) graficoBarras.destroy();
        
        graficoBarras = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: datos.map(item => item.categoria),
                datasets: [{
                    label: 'Productos por Categoría',
                    data: datos.map(item => item.total),
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
                                return `${context.label}: ${context.raw} productos`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad de Productos'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Categorías'
                        }
                    }
                }
            }
        });
    }

    function actualizarGraficoTorta(datos) {
        const ctx = document.getElementById('graficoTorta').getContext('2d');
        
        // Destruir gráfico anterior si existe
        if (graficoTorta) graficoTorta.destroy();
        
        graficoTorta = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: datos.map(item => item.label),
                datasets: [{
                    data: datos.map(item => item.value),
                    backgroundColor: [
                        '#2ecc71', '#3498db', '#9b59b6', '#f1c40f', 
                        '#e67e22', '#e74c3c', '#1abc9c', '#34495e'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw} productos`;
                            }
                        }
                    }
                }
            }
        });
    }

    function restaurarFiltros() {
        document.getElementById('filtroEstado').value = '';
        actualizarGraficos();
    }

    // Event listeners
    document.getElementById('filtroEstado').addEventListener('change', function() {
        actualizarGraficos(this.value);
    });

    // Inicialización al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        actualizarGraficos();
    });
// reportes exportar 
// Función para exportar a Excel
function exportarExcel() {
    // Crear tabla HTML para exportar
    let tablaHTML = `
        <table border="1">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>Cantidad de Productos</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    <?php foreach ($productosPorCategoria as $item): ?>
    tablaHTML += `
        <tr>
            <td><?= htmlspecialchars($item['nombre_categoria']) ?></td>
            <td><?= $item['total_productos'] ?></td>
            <td><?= $item['estado'] ? 'Activo' : 'Inactivo' ?></td>
        </tr>
    `;
    <?php endforeach; ?>
    
    tablaHTML += `
            </tbody>
        </table>
    `;
    
    // Crear archivo Excel
    const uri = 'data:application/vnd.ms-excel;base64,';
    const template = `<html xmlns:o="urn:schemas-microsoft-com:office:office" 
                  xmlns:x="urn:schemas-microsoft-com:office:excel" 
                  xmlns="http://www.w3.org/TR/REC-html40">
                  <head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                  <x:Name>Reporte Productos por Categoría</x:Name>
                  <x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions>
                  </x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head>
                  <body>${tablaHTML}</body></html>`;
    
    const link = document.createElement('a');
    link.href = uri + window.btoa(unescape(encodeURIComponent(template)));
    link.download = `Reporte_Productos_Categoria_${new Date().toISOString().slice(0,10)}.xls`;
    link.click();
}

// Función para exportar a PDF
function exportarPDF() {
    // Mostrar loader durante la generación
    const loader = document.createElement('div');
    loader.style.position = 'fixed';
    loader.style.top = '0';
    loader.style.left = '0';
    loader.style.width = '100%';
    loader.style.height = '100%';
    loader.style.backgroundColor = 'rgba(0,0,0,0.5)';
    loader.style.display = 'flex';
    loader.style.justifyContent = 'center';
    loader.style.alignItems = 'center';
    loader.style.zIndex = '9999';
    loader.innerHTML = '<div style="color: white; font-size: 24px;">Generando PDF, por favor espere...</div>';
    document.body.appendChild(loader);

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'pt', 'a4');
    const element = document.querySelector('.card');
    const options = {
        scale: 2,
        useCORS: true,
        logging: false,
        scrollY: 0,
        windowHeight: element.scrollHeight
    };

    html2canvas(element, options).then((canvas) => {
        const imgData = canvas.toDataURL('image/png');
        const imgWidth = doc.internal.pageSize.getWidth() - 20;
        const imgHeight = (canvas.height * imgWidth) / canvas.width;
        
        doc.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);
        document.body.removeChild(loader);
        doc.save(`Reporte_Productos_Categoria_${new Date().toISOString().slice(0,10)}.pdf`);
    }).catch(error => {
        console.error('Error al generar PDF:', error);
        document.body.removeChild(loader);
        alert('Error al generar el PDF. Por favor intente nuevamente.');
    });
}

// 
</script>

<style>
    .chart-container {
        position: relative;
        margin: auto;
        width: 100%;
    }
    
    .badge-success {
        background-color: #28a745;
    }
    
    .badge-danger {
        background-color: #dc3545;
    }
    
    .table-container {
        max-height: 400px;
        overflow-y: auto;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
</style>

<?php include("includes/footer.php"); ?>