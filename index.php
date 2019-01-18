<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/proyectos.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/ventas.controlador.php";
require_once "controladores/prospeccion.controlador.php";
require_once "controladores/cotizador.controlador.php";
require_once "controladores/simulador.controlador.php";
require_once "controladores/proforma.controlador.php";
require_once "controladores/reserva.controlador.php";



require_once "modelos/usuarios.modelo.php";
require_once "modelos/proyectos.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/ventas.modelo.php";
require_once "modelos/prospeccion.modelo.php";
require_once "modelos/cotizador.modelo.php";
require_once "modelos/simulador.modelo.php";
require_once "modelos/proforma.modelo.php";
require_once "modelos/reserva.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();