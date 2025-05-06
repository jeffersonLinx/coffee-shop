<?php
session_start();
if ($_SESSION['rol'] != 'admin') {
    echo "<script>alert('Acceso denegado: No tienes permisos en esta sección.'); window.location.href = 'productos.php';</script>";
    exit();
}
require_once "../controllers/reporteUsuarioSISController.php";
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
            <h4 class="mb-0">📊 Reporte de Usuarios del Sistema</h4>
        </div>
        <div class="card-body">

            <!-- Filtros y botones de exportación -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Filtrar por Rol:</label>
                    <select id="filtroRol" class="form-control">
                        <option value="">Todos</option>
                        <option value="admin">Administrador</option>
                        <option value="usuario">Usuario</option>
                        <option value="trabajador">Trabajador</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-secondary w-100" onclick="restaurarFiltros()">
                        <i class="fas fa-sync-alt"></i> Limpiar Filtros
                    </button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success w-100" onclick="exportarExcel()">
                        <i class="fas fa-file-excel"></i> Excel
                    </button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger w-100" onclick="exportarPDF()">
                        <i class="fas fa-file-pdf"></i> PDF
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
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['usuario']) ?></td>
                                <td><?= htmlspecialchars($user['correo']) ?></td>
                                <td>
                                    <span class="badge 
                                        <?= $user['rol'] == 'admin' ? 'badge-danger' : 
                                          ($user['rol'] == 'trabajador' ? 'badge-warning' : 'badge-primary') ?>">
                                        <?= ucfirst($user['rol']) ?>
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
    const usuarios = <?= json_encode($usuarios) ?>;
    
    let graficoBarras;
    let graficoTorta;

    function actualizarGraficos(filtroRol = '') {
        // Filtrar datos si es necesario
        const datosFiltradosBarras = filtroRol === '' ? 
            datosGraficoBarras : 
            datosGraficoBarras.filter(item => item.rol.toLowerCase() === filtroRol);
            
        const datosFiltradosTorta = filtroRol === '' ? 
            datosGraficoTorta : 
            datosGraficoTorta.filter(item => item.label.toLowerCase() === filtroRol);

        // Actualizar gráfico de barras
        actualizarGraficoBarras(datosFiltradosBarras);
        
        // Actualizar gráfico de torta
        actualizarGraficoTorta(datosFiltradosTorta);
    }

    function actualizarGraficoBarras(datos) {
        const ctx = document.getElementById('graficoBarras').getContext('2d');
        
        if (graficoBarras) graficoBarras.destroy();
        
        graficoBarras = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: datos.map(item => item.rol),
                datasets: [{
                    label: 'Usuarios por Rol',
                    data: datos.map(item => item.total),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
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
                                return `${context.label}: ${context.raw} usuarios`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad de Usuarios'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Roles del Sistema'
                        }
                    }
                }
            }
        });
    }

    function actualizarGraficoTorta(datos) {
        const ctx = document.getElementById('graficoTorta').getContext('2d');
        
        if (graficoTorta) graficoTorta.destroy();
        
        graficoTorta = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: datos.map(item => item.label),
                datasets: [{
                    data: datos.map(item => item.value),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)'
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
                                return `${context.label}: ${context.raw} usuarios`;
                            }
                        }
                    }
                }
            }
        });
    }

    function restaurarFiltros() {
        document.getElementById('filtroRol').value = '';
        actualizarGraficos();
    }

    function exportarExcel() {
        let tablaHTML = `
            <table border="1">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
        `;
        
        usuarios.forEach(user => {
            tablaHTML += `
                <tr>
                    <td>${user.usuario}</td>
                    <td>${user.correo}</td>
                    <td>${user.rol}</td>
                </tr>
            `;
        });
        
        tablaHTML += `
                </tbody>
            </table>
        `;
        
        const uri = 'data:application/vnd.ms-excel;base64,';
        const template = `<html xmlns:o="urn:schemas-microsoft-com:office:office" 
                      xmlns:x="urn:schemas-microsoft-com:office:excel" 
                      xmlns="http://www.w3.org/TR/REC-html40">
                      <head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                      <x:Name>Reporte Usuarios</x:Name>
                      <x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions>
                      </x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head>
                      <body>${tablaHTML}</body></html>`;
        
        const link = document.createElement('a');
        link.href = uri + window.btoa(unescape(encodeURIComponent(template)));
        link.download = `Reporte_Usuarios_${new Date().toISOString().slice(0,10)}.xls`;
        link.click();
    }

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
            doc.save(`Reporte_Usuarios_${new Date().toISOString().slice(0,10)}.pdf`);
        }).catch(error => {
            console.error('Error al generar PDF:', error);
            document.body.removeChild(loader);
            alert('Error al generar el PDF. Por favor intente nuevamente.');
        });
    }

    // Event listeners
    document.getElementById('filtroRol').addEventListener('change', function() {
        actualizarGraficos(this.value);
    });

    // Inicialización al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        actualizarGraficos();
    });
</script>

<style>
    .chart-container {
        position: relative;
        margin: auto;
        width: 100%;
    }
    
    .badge-primary {
        background-color: #007bff;
    }
    
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
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
</style>

<?php include("includes/footer.php"); ?>