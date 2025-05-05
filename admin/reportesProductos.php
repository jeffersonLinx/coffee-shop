<!-- reportesProductos.php -->
<?php
session_start();
if ($_SESSION['rol'] != 'admin') {
    echo "<script>alert('Acceso denegado: No tienes permisos en esta sección.'); window.location.href = 'productos.php';</script>";
    exit();
}
require_once "../controllers/reporteProductoController.php";
include("includes/header.php");
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="container mt-4">
    <div class="card shadow-lg mb-5">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">📊 Productos Más Reservados</h4>
        </div>
        <div class="card-body">

            <!-- Botones de exportación -->
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

            <!-- Gráficos -->
            <div class="row">
                <div class="col-md-8">
                    <div class="chart-container">
                        <h5 class="text-center">Productos Activos Más Reservados</h5>
                        <canvas id="graficoBarras" height="150"></canvas>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart-container">
                        <h5 class="text-center">Distribución de Reservas por Producto</h5>
                        <canvas id="graficoTorta" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Tabla de registros -->
            <div class="mt-4 table-container">
                <table class="table table-bordered table-hover" id="tablaProductos">
                    <thead class="thead-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Total Reservas</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['producto']) ?></td>
                                <td><?= $p['total_reservas'] ?></td>
                                <td>
                                    <span class="badge <?= $p['estado'] == 1 ? 'badge-success' : 'badge-secondary' ?>">
                                        <?= $p['estado'] == 1 ? 'Activo' : 'Inactivo' ?>
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

<?php include("includes/footer.php"); ?>

<script>
    // Función para generar colores aleatorios
    function generarColoresAleatorios(cantidad) {
        const colores = [];
        for (let i = 0; i < cantidad; i++) {
            const r = Math.floor(Math.random() * 200 + 55);
            const g = Math.floor(Math.random() * 200 + 55);
            const b = Math.floor(Math.random() * 200 + 55);
            colores.push(`rgb(${r}, ${g}, ${b})`);
        }
        return colores;
    }

    // Datos para gráficos
    const datosBarras = <?= json_encode($datosBarras) ?>;
    const datosTorta = <?= json_encode($datosTorta) ?>;
    const coloresTorta = generarColoresAleatorios(datosTorta.length);
    
    let graficoBarras;
    let graficoTorta;

    // Inicialización al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de barras (solo productos activos)
        const ctxBarras = document.getElementById('graficoBarras').getContext('2d');
        graficoBarras = new Chart(ctxBarras, {
            type: 'bar',
            data: {
                labels: datosBarras.map(item => item.producto),
                datasets: [{
                    label: 'Reservas',
                    data: datosBarras.map(item => item.total_reservas),
                    backgroundColor: '#3498db',
                    borderColor: '#2980b9',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Reservas: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Número de Reservas'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Productos'
                        }
                    }
                }
            }
        });

        // Gráfico de torta (todos los productos)
        const ctxTorta = document.getElementById('graficoTorta').getContext('2d');
        graficoTorta = new Chart(ctxTorta, {
            type: 'pie',
            data: {
                labels: datosTorta.map(item => item.producto),
                datasets: [{
                    data: datosTorta.map(item => item.total_reservas),
                    backgroundColor: coloresTorta,
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
                                return `${context.label}: ${context.raw} (${Math.round(context.parsed)}%)`;
                            }
                        }
                    }
                }
            }
        });
    });

    // Exportar a Excel
function exportarExcel() {
    // Crear tabla HTML para exportar
    let tablaHTML = `
        <table border="1">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Total Reservas</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    <?php foreach ($productos as $p): ?>
    tablaHTML += `
        <tr>
            <td><?= htmlspecialchars($p['producto'], ENT_QUOTES | ENT_XML1) ?></td>
            <td><?= $p['total_reservas'] ?></td>
            <td><?= $p['estado'] == 1 ? 'Activo' : 'Inactivo' ?></td>
        </tr>
    `;
    <?php endforeach; ?>
    
    tablaHTML += `
            </tbody>
        </table>
    `;
    
    // Configuración mejorada para Excel
    const uri = 'data:application/vnd.ms-excel;charset=UTF-8;base64,';
    const template = `<?xml version="1.0" encoding="UTF-8"?>
        <html xmlns:o="urn:schemas-microsoft-com:office:office" 
              xmlns:x="urn:schemas-microsoft-com:office:excel" 
              xmlns="http://www.w3.org/TR/REC-html40">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!--[if gte mso 9]>
        <xml>
            <x:ExcelWorkbook>
                <x:ExcelWorksheets>
                    <x:ExcelWorksheet>
                        <x:Name>Productos Reservados</x:Name>
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
    
    // Codificación base64 mejorada para caracteres especiales
    const base64 = function(s) {
        return window.btoa(unescape(encodeURIComponent(s)));
    };
    
    // Crear y descargar archivo
    const link = document.createElement('a');
    link.href = uri + base64(template);
    link.download = `Productos_Mas_Reservados_${new Date().toISOString().slice(0,10)}.xls`;
    
    // Agregar temporalmente al documento y hacer click
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

    // Exportar a PDF
    function exportarPDF() {
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
            doc.save(`Productos_Reservados_${new Date().toISOString().slice(0,10)}.pdf`);
        }).catch(error => {
            console.error('Error al generar PDF:', error);
            document.body.removeChild(loader);
            alert('Error al generar el PDF. Por favor intente nuevamente.');
        });
    }
</script>

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
    
    .badge-success {
        background-color: #28a745;
    }
    
    .badge-secondary {
        background-color: #6c757d;
    }
    
    .btn-export {
        margin-bottom: 10px;
        transition: all 0.3s;
    }
    
    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .btn-export i {
        margin-right: 8px;
    }
</style>