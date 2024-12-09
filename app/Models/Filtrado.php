<?php

namespace App\Models;

use DateTime;
/**
 * @file Filtrado.php
 * 
 * @author José Díaz Bourre
 * @date 2024-12-08
 * @version 1.0
 * 
 * 
 * @class Filtrado
 * @brief Clase para validar y filtrar datos de entrada.
 * 
 * Esta clase contiene métodos estáticos que permiten validar diversos tipos de datos
 * como NIF, nombres, apellidos, correos electrónicos, teléfonos, fechas y otros campos.
 */
class Filtrado
{
    /**
     * @var array $errores Arreglo estático que almacena los errores de validación.
     */
    public static $errores = [];

    /**
     * @brief Valida un conjunto de datos de entrada.
     * 
     * Realiza múltiples validaciones en los campos del arreglo `$data`, como NIF, nombre,
     * apellidos, correo electrónico, teléfono, dirección, fecha, etc.
     * 
     * @param array $data Datos de entrada a validar.
     * @return array Lista de errores de validación, si los hay.
     */
    public static function validar($data)
    {
        self::$errores = [];  // Reseteamos los errores en cada validación

        // Validación de NIF
        if (empty($data['NIF'])) {
            self::$errores['NIF'] = "El campo NIF está vacío.";
        } else if (!self::nif_valido($data['NIF'])) {
            self::$errores['NIF'] = "El NIF no es válido.";
        }

        // Validación de nombre
        if (empty($data['nombre'])) {
            self::$errores['nombre'] = "El campo nombre está vacío.";
        } else if (!self::solo_letras($data['nombre'])) {
            self::$errores['nombre'] = "El nombre solo puede contener letras.";
        }

        // Validación de apellidos
        if (empty($data['apellidos'])) {
            self::$errores['apellidos'] = "El campo apellidos está vacío.";
        } else if (!self::solo_letras($data['apellidos'])) {
            self::$errores['apellidos'] = "Los apellidos solo pueden contener letras.";
        }

        // Validación de email
        if (empty($data['email'])) {
            self::$errores['email'] = "El campo email está vacío.";
        } else if (!self::es_email_valido($data['email'])) {
            self::$errores['email'] = "Email inválido.";
        }

        // Validación de teléfono
        if (empty($data['telefono'])) {
            self::$errores['telefono'] = "El campo teléfono está vacío.";
        } else if (!self::es_telefono_valido($data['telefono'])) {
            self::$errores['telefono'] = "El formato del teléfono es inválido.";
        }

        if (empty($data['descripcion'])) {
            self::$errores['descripcion'] = "El campo descripción está vacío.";
        }

        // Validación de otros campos (como poblacion, código postal, etc.)
        self::validarCamposGenerales($data);

        // Verificación de errores
        return self::$errores;
    }

    /**
     * @brief Valida un NIF.
     * 
     * Comprueba que el NIF cumpla con el formato estándar y que la letra sea correcta.
     * 
     * @param string $nif NIF a validar.
     * @return bool `true` si el NIF es válido, `false` en caso contrario.
     */
    public static function nif_valido($nif)
    {
        $nif = strtoupper($nif);
        if (!preg_match('/^[0-9]{8}[A-Z]$/', $nif)) {
            return false;
        }
        $numero = substr($nif, 0, 8);
        $letra = $nif[8];
        $letras = "TRWAGMYFPDXBNJZSQVHLCKE";
        $letraCalculada = $letras[$numero % 23];
        return $letra === $letraCalculada;
    }

    /**
     * @brief Verifica si una cadena contiene solo letras.
     * 
     * @param string $input Cadena a validar.
     * @return bool `true` si la cadena contiene solo letras, `false` en caso contrario.
     */
    public static function solo_letras($input)
    {
        return preg_match('/^[a-zA-Z]+$/', $input) === 1;
    }

    /**
     * @brief Valida un correo electrónico.
     * 
     * Comprueba que el correo electrónico tenga un formato válido.
     * 
     * @param string $email Correo electrónico a validar.
     * @return bool `true` si el correo es válido, `false` en caso contrario.
     */
    public static function es_email_valido($email)
    {
        $patron = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        return preg_match($patron, $email) === 1;
    }

    /**
     * @brief Valida un número de teléfono.
     * 
     * Acepta teléfonos que contengan números y ciertos caracteres especiales como 
     * paréntesis, guiones o espacios.
     * 
     * @param string $telefono Número de teléfono a validar.
     * @return bool `true` si el teléfono es válido, `false` en caso contrario.
     */
    public static function es_telefono_valido($telefono)
    {
        $telefono = trim($telefono);
        $soloNumeros = preg_replace('/[^0-9]/', '', $telefono);
        if (strlen($soloNumeros) < 7) {
            return false;
        }
        $patron = '/^[0-9\s\-()+.]+$/';
        return preg_match($patron, $telefono) === 1;
    }

    /**
     * @brief Valida campos generales como población, código postal, dirección, etc.
     * 
     * Agrega mensajes de error a `$errores` si se detectan campos vacíos o con formato inválido.
     * 
     * @param array $data Datos de entrada a validar.
     */
    public static function validarCamposGenerales($data)
    {
        if (empty($data['poblacion'])) {
            self::$errores['poblacion'] = "El campo población está vacío.";
        }

        if (empty($data['codigoPostal'])) {
            self::$errores['codigoPostal'] = "El campo código postal está vacío.";
        } else if (strlen($data['codigoPostal']) !== 5 || !ctype_digit($data['codigoPostal'])) {
            self::$errores['codigoPostal'] = "El campo código postal debe contener 5 dígitos.";
        }

        if (empty($data['direccion'])) {
            self::$errores['direccion'] = "El campo dirección está vacío.";
        }

        if (empty($data['provincia'])) {
            self::$errores['provincia'] = "Por favor, seleccione una provincia.";
        }

        if (empty($data['estado'])) {
            self::$errores['estado'] = "Por favor, seleccione un estado.";
        }

        if (empty($data['operario'])) {
            self::$errores['operario'] = "Por favor, seleccione un operario.";
        }

        if (empty($data['fechaRealizacion'])) {
            self::$errores['fechaRealizacion'] = "Por favor, seleccione una fecha.";
        } else {
            $resultadoValidacion = self::validar_fecha_realizacion($data['fechaRealizacion']);
            if ($resultadoValidacion !== true) {
                self::$errores['fechaRealizacion'] = "La fecha debe ser posterior a la fecha actual."; 
            }
        }

        if (empty($data['anotacionesAnteriores'])) {
            self::$errores['anotacionesAnteriores'] = "El campo anotaciones anteriores está vacío.";
        }

        if (empty($data['anotacionesPosteriores'])) {
            self::$errores['anotacionesPosteriores'] = "El campo anotaciones posteriores está vacío.";
        }
    }

    /**
     * @brief Valida una fecha de realización.
     * 
     * Comprueba que la fecha esté en el formato `YYYY-MM-DD` y sea posterior a la fecha actual.
     * 
     * @param string $fecha Fecha a validar.
     * @return mixed `true` si la fecha es válida, mensaje de error en caso contrario.
     */
    public static function validar_fecha_realizacion($fecha)
    {
        $formato = 'Y-m-d';
        $fechaObj = DateTime::createFromFormat($formato, $fecha);
        $fechaConvertida = $fechaObj->format($formato);

        if (!$fechaObj || $fechaObj->format($formato) !== $fechaConvertida) {
            return "La fecha no tiene un formato válido (YYYY-MM-DD).";
        }

        $hoy = new DateTime();
        $hoy->setTime(0, 0);
        if ($fechaObj->format('Y-m-d') <= $hoy->format('Y-m-d')) {
            return "La fecha debe ser posterior a la fecha actual.";
        }

        return true; // Fecha válida
    }
}
