<?php
require_once "config/conn.php";
if (isset($_POST)) {
    if ($_POST['action'] == 'buscar') {
        $array['datos'] = array();
        $total = 0;
        for ($i=0; $i < count($_POST['data']); $i++) { 
            $id = $_POST['data'][$i]['id'];
            $query = mysqli_query($conexion, "SELECT p.*, c.nombre_categoria 
                                            FROM productos p
                                            INNER JOIN categorias c ON c.id = p.id_categoria
                                            WHERE p.id = $id AND p.estado = 1 AND c.estado = 1");
            $result = mysqli_fetch_assoc($query);
            if ($result) {
                $data['id'] = $result['id'];
                $data['precio'] = $result['precio_rebajado'];
                $data['nombre'] = $result['nombre'];
                $data['categoria'] = $result['nombre_categoria'];
                $total = $total + $result['precio_rebajado'];
                array_push($array['datos'], $data);
            }
        }
        $array['total'] = $total;
        echo json_encode($array);
        die();
    }
}
?>
