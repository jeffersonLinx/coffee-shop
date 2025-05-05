<!-- reporte.php -->
<!-- aqui son los reportes de las reservas  -->
<?php
session_start();
if ($_SESSION['rol'] != 'admin') {
    echo "<script>alert('Acceso denegado: No tienes permisos en esta sección.'); window.location.href = 'productos.php';</script>";
    exit();
}
require_once "../controllers/reporteReserva.php";
include("includes/header.php");

// Obtener el año actual para selección por defecto
$currentYear = date('Y');
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container mt-4">
    <div class="card shadow-lg mb-5">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">📊 Reporte de Reservas</h4>
        </div>
        <div class="card-body">

            <!-- Filtros para gráfico -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Filtrar por Estado:</label>
                    <select id="filtroEstado" class="form-control">
                        <option value="todos">Todos</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="confirmada">Confirmada</option>
                        <option value="cancelada">Cancelada</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Seleccionar Año:</label>
                    <select id="filtroAnio" class="form-control">
                        <?php for ($year = $currentYear - 1; $year <= $currentYear + 2; $year++): ?>
                            <option value="<?= $year ?>" <?= $year == $currentYear ? 'selected' : '' ?>>
                                <?= $year ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-secondary w-100" onclick="restaurarGrafico()">Restaurar</button>
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

            <!-- Tabla de registros -->
            <div class="mt-4" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Cliente</th>
                            <th>Correo</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Producto</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservas as $r): ?>
                            <tr>
                                <td><?= htmlspecialchars($r['nombre_cliente']) ?></td>
                                <td><?= htmlspecialchars($r['correo_cliente']) ?></td>
                                <td><?= htmlspecialchars($r['fecha_reserva']) ?></td>
                                <td><?= htmlspecialchars($r['hora_reserva']) ?></td>
                                <td><?= htmlspecialchars($r['producto']) ?></td>
                                <td>
                                    <span class="badge 
                                        <?= $r['estado'] == 'pendiente' ? 'badge-warning' : 
                                            ($r['estado'] == 'confirmada' ? 'badge-success' : 'badge-danger') ?>">
                                        <?= ucfirst($r['estado']) ?>
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
<!-- Agrega estas líneas con los demás scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<!-- Iconos de Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- llÇ -->
<script>
    const resumenMensual = <?= json_encode($resumenMensual) ?>;
    const resumenPorEstado = <?= json_encode($resumenPorEstado) ?>;
    const meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    
    let graficoBarras;
    let graficoTorta;

    function actualizarGraficoBarras(estado = 'todos', anio = <?= $currentYear ?>) {
        // Inicializar datos para todos los meses
        const data = new Array(12).fill(0);
        
        // Procesar datos filtrados
        resumenMensual.forEach(item => {
            if (item.anio == anio && (estado === 'todos' || item.estado === estado)) {
                data[item.mes - 1] = parseInt(item.total);
            }
        });

        // Destruir gráfico anterior si existe
        if (graficoBarras) graficoBarras.destroy();
        
        // Crear nuevo gráfico
        const ctx = document.getElementById('graficoBarras').getContext('2d');
        graficoBarras = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: meses,
                datasets: [{
                    label: `Reservas por Mes ${estado !== 'todos' ? '('+estado+')' : ''}`,
                    data: data,
                    backgroundColor: '#3498db',
                    borderColor: '#2980b9',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad de Reservas'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Meses del Año'
                        }
                    }
                }
            }
        });
    }

    function cargarGraficoTorta() {
        const etiquetas = resumenPorEstado.map(e => e.estado);
        const valores = resumenPorEstado.map(e => e.total);
        const colores = {
            'pendiente': '#f1c40f',
            'confirmada': '#2ecc71',
            'cancelada': '#e74c3c'
        };

        const ctx = document.getElementById('graficoTorta').getContext('2d');
        graficoTorta = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: etiquetas,
                datasets: [{
                    data: valores,
                    backgroundColor: etiquetas.map(e => colores[e] || '#95a5a6'),
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
    }

    // Event listeners para filtros
    document.getElementById('filtroEstado').addEventListener('change', function() {
        actualizarGraficoBarras(this.value, document.getElementById('filtroAnio').value);
    });

    document.getElementById('filtroAnio').addEventListener('change', function() {
        actualizarGraficoBarras(document.getElementById('filtroEstado').value, this.value);
    });

    function restaurarGrafico() {
        document.getElementById('filtroEstado').value = 'todos';
        document.getElementById('filtroAnio').value = '<?= $currentYear ?>';
        actualizarGraficoBarras();
    }

    // Inicialización al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        actualizarGraficoBarras();
        cargarGraficoTorta();
    });


// imprimir pdf o excel
function exportarExcel() {
    // Crear tabla HTML para exportar
    let tablaHTML = `
        <table border="1">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Correo</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Producto</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    <?php foreach ($reservas as $r): ?>
    tablaHTML += `
        <tr>
            <td><?= htmlspecialchars($r['nombre_cliente']) ?></td>
            <td><?= htmlspecialchars($r['correo_cliente']) ?></td>
            <td><?= htmlspecialchars($r['fecha_reserva']) ?></td>
            <td><?= htmlspecialchars($r['hora_reserva']) ?></td>
            <td><?= htmlspecialchars($r['producto']) ?></td>
            <td><?= ucfirst($r['estado']) ?></td>
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
                  <x:Name>Reporte Reservas</x:Name>
                  <x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions>
                  </x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head>
                  <body>${tablaHTML}</body></html>`;
    
    const link = document.createElement('a');
    link.href = uri + window.btoa(unescape(encodeURIComponent(template)));
    link.download = `Reporte_Reservas_${new Date().toISOString().slice(0,10)}.xls`;
    link.click();
}

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
        doc.save(`Reporte_Reservas_${new Date().toISOString().slice(0,10)}.pdf`);
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
    }
/* dff */
.btn-export {
    margin: 5px;
    padding: 10px 15px;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-export:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.btn-export i {
    margin-right: 8px;
    font-size: 1.2em;
}

/* Estilo para los botones de exportación específicamente */
.btn-success, .btn-danger {
    margin-bottom: 10px;
}

/* Mejora para la tabla */
.table-container {
    max-height: 400px;
    overflow-y: auto;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

</style>