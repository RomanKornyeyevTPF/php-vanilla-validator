<?php

use Humber\Validation\Validator;

require_once "Humber/Validation/Validator.php";
require_once "Input.php";

$errors = [];

if (isset($_POST['enviar'])) {
    $formRequest = [
        'nombre'       => $_POST['nombre'],
        'password'     => $_POST['password'],
        'email'        => $_POST['email'],
        'edad'         => $_POST['edad'],
        'fecha_nac'    => $_POST['fecha_nac'],
        'foto'         => $_FILES['foto'],  // Para archivos se usa $_FILES
        'genero'       => $_POST['genero'],
        'telefono'     => $_POST['telefono'],
        'terminos'     => isset($_POST['terminos']) ? $_POST['terminos'] : null,
        'mensaje'      => $_POST['mensaje'],
        'intereses'    => isset($_POST['intereses']) ? $_POST['intereses'] : [],  // Checkbox múltiple
    ];
    
    $rules = [
        'nombre'       => 'alpha_num|required',
        'password'     => 'required|size:8',  // Exactamente 8 caracteres
        'email'        => 'email|filled',
        'edad'         => 'integer|required',
        'fecha_nac'    => 'date|required',
        'foto'         => 'size_file:15000',  // No hay validación de archivo o tamaño
        'genero'       => 'required',  // No se puede validar en base a opciones fijas
        'telefono'     => 'required',  // 9 dígitos exactos
        'terminos'     => 'required',  // El checkbox debe estar marcado
        'mensaje'      => 'filled',  // No vacío si está presente
    ];
    
    
    
    // $messages = [
    //     'email.email' => 'Invalid email',
    //     'email.filled' => 'Empty email',
    //     'password.array' => 'Empty name'
    // ];
    
    $validator = new Validator($rules);
    $errors = $validator->validate($formRequest);
    
    if (empty($errors)) {
        echo "<br> POST: <br>";
        echo "form validado";
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";

        echo "<br> FILES: <br>";
        echo "form validado";
        echo "<pre>";
        print_r($_FILES);
        echo "</pre>";
    }else{
        echo "form no validado";
    }

    echo "<br> ERRORES: <br>";
    echo "<pre>";
    print_r($errors);
    echo "</pre>";
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .error{color:red;}
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container shadow br-3 p-5 my-5">
        <form action="" method="post" enctype="multipart/form-data">
            
            <div class="row">
                <?php
                    // Campo de texto
                    Input::renderInput(
                        'text', // type (text by default)
                        'nombre', // name
                        'Nombre Completo', // label
                        $errors, // errores personalizados
                        false, // required (OPTIONAL: false by default)
                        ['form-group', 'mb-3', 'col-md-6'], // Array de clases para el wrapper (OPTIONAL: ['mb-3'] by default)
                        'Ingrese su nombre completo', //placeholder (OPTIONAL: label value by default)
                        ['form-control'], //input class (OPTIONAL: form-control by default)
                    );
                
                    // Campo contraseña
                    Input::renderInput(
                        'password',
                        'password',
                        'Contraseña',
                        $errors,
                        false,
                        ['form-group', 'mb-3', 'col-md-6']
                    );
                ?>
            </div>
            <div class="row">
                <?php
                    // Campo de email
                    Input::renderInput(
                        'text',
                        'email',
                        'Email',
                        $errors,
                        false,
                        ['form-group', 'mb-3', 'col-md-9']
                    );

                    // Campo de número
                    Input::renderInput(
                        'number',
                        'edad',
                        'Edad',
                        $errors,
                        false,
                        ['form-group', 'mb-3', 'col-md-3']
                    );
                ?>
            </div>
            <div class="row">
                <?php
                    // Campo de fecha
                    Input::renderInput(
                        'date',
                        'fecha_nac',
                        'Fecha de nacimiento',
                        $errors,
                        false,
                        ['form-group', 'mb-3', 'col-md-6']
                    );

                    // Campo archivo
                    Input::renderInputFile(
                        'foto', 
                        'Sube tu documento', 
                        $errors,
                        ['form-group', 'mb-3', 'col-md-6'],
                        ['form-control'], 
                        false,  // Indica que es requerido (OPTIONAL: false by default)
                        'image/png,application/pdf'  // Acepta solo PNG y PDF (OPTIONAL: accept png, jpf, pdf and word by default)
                    );
                ?>
            </div>
            <div class="row">
                <?php
                
                    // Campo select
                    Input::renderSelectFile(
                        'genero', 
                        'Género',
                        $errors,
                        [
                            '1' => 'No especificar', 
                            '2' => 'Masculino', 
                            '3' => 'Femenino'
                        ],
                        ['form-group', 'mb-3', 'col-md-6'],
                    );

                    // Campo contraseña
                    Input::renderInput(
                        'tel',
                        'telefono',
                        'Teléfono',
                        $errors,
                        false,
                        ['form-group', 'mb-3', 'col-md-6']
                    );
                
                ?>
            </div>
            <div class="row">
                <?php
                    // Ejemplo de uso del grupo de checkboxes
                    Input::renderCheckboxGroup(
                        'terminos', 
                        'Aceptar términos y condiciones',
                        $errors,
                        [
                            '0' => 'Términos y condiciones'
                        ], 
                        ['form-group', 'mb-3', 'col-md-3']
                    );

                    // Ejemplo de uso del grupo de checkboxes
                    Input::renderCheckboxGroup(
                        'intereses', 
                        'Selecciona tus intereses',
                        $errors,
                        [
                            '0' => 'Deporte', 
                            '1' => 'Música', 
                            '2' => 'Cine'
                        ], 
                        ['form-group', 'mb-3', 'col-md-3']
                    );

                    // Ejemplo de uso del textarea
                    Input::renderTextarea(
                        'mensaje', 
                        'Mensaje / comentarios:', 
                        'Escribe aquí tus comentarios...', 
                        $errors, // Puedes pasar un array de errores si es necesario
                        false, // Indica que es requerido
                        ['form-group', 'mb-3', 'col-md-6'], 
                        ["form-control"]
                    );

                
                ?>
            </div>

            <hr>
            <!-- Campo de radio -->
            <!-- <p>Estado civil:</p>
            <input type="radio" id="soltero" name="estado_civil" value="soltero" checked>
            <label for="soltero">Soltero</label><br>
            <input type="radio" id="casado" name="estado_civil" value="casado" >
            <label for="casado">Casado</label><br>
            <input type="radio" id="otro" name="estado_civil" value="otro" >
            <label for="otro">Otro</label><br><br> -->

            <!-- Campo de textarea -->
            <!-- <label for="mensaje">Mensaje:</label><br>
            <textarea id="mensaje" name="mensaje" rows="4" cols="50" placeholder="Escriba su mensaje..."></textarea><br><br> -->

            <!-- Campo oculto -->
            <!-- <input type="hidden" name="token" value="abc123"> -->

            <!-- Botón de envío -->
            <input type="submit" value="Enviar" name="enviar" class="btn btn-primary">
        </form>
    </div>

</body>
</html>