<?php

class Input {
    // *******************************************************************************
    // *                                                                             *
    // *                                                                             *
    // *                  INPUT: TEXT, NUMBER, TEL, EMAIL, DATE                      *
    // *                                                                             *
    // *                                                                             *
    // *******************************************************************************
    public static function renderInput(
        $type = "text",
        $name = "",
        $label = "",
        $errors = [],
        $required = false,
        $wrapperClass = ["form-group", "mb-3"],
        $placeholder = "",
        $inputClass = ["form-control"],
    ) {
        $value = isset($_POST[$name]) ? htmlspecialchars($_POST[$name], ENT_QUOTES, 'UTF-8') : "";
        $isRequired = $required ? 'required' : '';
        $inputClass = htmlspecialchars(implode(' ', $inputClass));
        $wrapperClass = htmlspecialchars(implode(' ', $wrapperClass)); // Convertir array de clases en string
        $placeholder = ($placeholder == "") ? $placeholder = $label : $placeholder;
        ?>
            <!-- Campo de texto -->
            <div class="<?= $wrapperClass ?>">
                <label for="<?= htmlspecialchars($name) ?>" class="form-label"><?= htmlspecialchars($label) ?>:</label>
                <input 
                    type="<?= htmlspecialchars($type) ?>" 
                    id="<?= htmlspecialchars($name) ?>" 
                    name="<?= htmlspecialchars($name) ?>" 
                    value="<?= $value ?>" 
                    placeholder="<?= htmlspecialchars($placeholder) ?>" 
                    class="<?= $inputClass ?>"
                    <?= $isRequired ?>
                >
                <?php
                    if (isset($errors[$name])) {
                        foreach ($errors[$name] as $error) {
                            ?>
                                <div class='error'>
                                    <?= htmlspecialchars($error); ?>
                                </div>
                            <?php
                        }
                    }
                ?>
            </div>  
        <?php
    }

    // *****************************************************************************
    // *                                                                           *
    // *                          INPUT: FILE                                      *
    // *                                                                           *
    // *****************************************************************************
    public static function renderInputFile(
        $name = "", 
        $label = "Seleccione un archivo",
        $errors = [],
        $wrapperClass = ["form-group", "mb-3"], 
        $inputClass = ["form-control"], 
        $required = false,
        $accept = "image/png,image/jpeg,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" // Tipos de archivos aceptados por defecto
    ) {
        // Convertir el array de clases del wrapper en un string
        $wrapperClass = implode(' ', array_map('htmlspecialchars', $wrapperClass)); 
        
        // Escapamos las clases del input y el nombre
        $inputClass = implode(' ', array_map('htmlspecialchars', $inputClass)); 
        $name = htmlspecialchars($name);

        // Si es requerido, añadimos el atributo "required" al input
        $isRequired = $required ? 'required' : '';
        ?>
            <!-- Campo de archivo -->
            <div class="<?= $wrapperClass ?>">
                <label for="<?= $name ?>" class="form-label"><?= htmlspecialchars($label) ?></label>
                <input 
                    class="<?= $inputClass ?>" 
                    type="file" 
                    id="<?= $name ?>" 
                    name="<?= $name ?>"
                    <?= $isRequired ?>
                    accept="<?= $accept ?>"
                >
                <?php
                    if (isset($errors[$name])) {
                        foreach ($errors[$name] as $error) {
                            ?>
                                <div class='error'>
                                    <?= htmlspecialchars($error); ?>
                                </div>
                            <?php
                        }
                    }
                ?>
            </div>
        <?php
    }

    // *****************************************************************************
    // *                                                                           *
    // *                             SELECT                                        *
    // *                                                                           *
    // *****************************************************************************
    public static function renderSelectFile(
        $name = "",
        $label = "Selecciona una opción",
        $errors = [],
        $options = [],
        $wrapperClass = ["form-group", "mb-3"],
        $selectClass = ["form-select"],
        $required = false
    ) {
        // Convertir el array de clases del wrapper en un string
        $wrapperClass = implode(' ', array_map('htmlspecialchars', $wrapperClass));
        $selectClass = implode(' ', array_map('htmlspecialchars', $selectClass)); 

        // Escapamos el nombre del select
        $name = htmlspecialchars($name);
        
        // Si es requerido, añadimos el atributo "required" al select
        $isRequired = $required ? 'required' : '';

        // Obtener el valor del select desde $_POST
        $selectedValue = isset($_POST[$name]) ? htmlspecialchars($_POST[$name]) : '';
        ?>
            <!-- Campo de selección -->
            <div class="<?= $wrapperClass ?>">
                <label for="<?= $name ?>" class="form-label"><?= htmlspecialchars($label) ?> *</label>
                <select id="<?= $name ?>" class="<?= htmlspecialchars($selectClass) ?>" name="<?= $name ?>" <?= $isRequired ?>>
                    <?php
                        // Generar las opciones del select
                        foreach ($options as $value => $text) {
                            // Marcar la opción como seleccionada si coincide con el valor del POST
                            $selected = ($value == $selectedValue) ? 'selected' : '';
                            ?>
                                <option value="<?= htmlspecialchars($value) ?>" <?= $selected ?>><?= htmlspecialchars($text) ?></option>
                            <?php
                        }
                    ?>
                </select>
                <?php
                    if (isset($errors[$name])) {
                        foreach ($errors[$name] as $error) {
                            ?>
                                <div class='error'>
                                    <?= htmlspecialchars($error); ?>
                                </div>
                            <?php
                        }
                    }
                ?>
            </div>
        <?php
    }



    // ************************************************************************
    // *                                                                      *
    // *                          CHECKBOX GROUP                              *
    // *                                                                      *
    // ************************************************************************
    public static function renderCheckboxGroup(
        $name = "",
        $label = "Selecciona opciones",
        $errors = [],
        $options = [],
        $wrapperClass = ["form-group", "mb-3"],
        $checkboxClass = ["form-check"],
        $required = false
    ) {
        // Convertir el array de clases del wrapper en un string
        $wrapperClass = implode(' ', array_map('htmlspecialchars', $wrapperClass));
        $checkboxClass = implode(' ', array_map('htmlspecialchars', $checkboxClass)); 

        // Escapamos el nombre del grupo de checkboxes
        $name = htmlspecialchars($name);
        $isRequired = $required ? 'required' : '';

        // Obtener los valores seleccionados desde $_POST
        $selectedValues = isset($_POST[$name]) ? $_POST[$name] : [];

        ?>
        <div class="<?= $wrapperClass ?>">
            <label class="form-label"><?= htmlspecialchars($label) ?> <?= $isRequired ? '*' : '' ?></label>
            <?php
                // Generar los checkboxes
                foreach ($options as $value => $text) {
                    // Comprobar si el checkbox está seleccionado
                    $checked = in_array($value, $selectedValues) ? 'checked' : '';
                    $checkboxId = htmlspecialchars($name . '_' . $value); // Crear un ID único para cada checkbox
                    ?>
                        <div class="<?= htmlspecialchars($checkboxClass) ?>">
                            <input class="form-check-input" type="checkbox" id="<?= $checkboxId ?>" name="<?= $name ?>[]" value="<?= htmlspecialchars($value) ?>" <?= $checked ?>>
                            <label class="form-check-label" for="<?= $checkboxId ?>">
                                <?= htmlspecialchars($text) ?>
                            </label>
                        </div>
                    <?php
                }
            ?>
             <?php
                    if (isset($errors[$name])) {
                        foreach ($errors[$name] as $error) {
                            ?>
                                <div class='error'>
                                    <?= htmlspecialchars($error); ?>
                                </div>
                            <?php
                        }
                    }
                ?>
        </div>
        <?php
    }


    // ************************************************************************
    // *                                                                      *
    // *                               TEXTAREA                               *
    // *                                                                      *
    // ************************************************************************
    public static function renderTextarea(
        $name = "", 
        $label = "",
        $placeholder = "", 
        $errors = [], 
        $required = false, 
        $wrapperClass = ["mb-3"],
        $textareaClass = ["form-control"]
    ) {
        // Convertir el array de clases del wrapper en un string
        $wrapperClass = implode(' ', array_map('htmlspecialchars', $wrapperClass)); 
        $textareaClass = implode(' ', array_map('htmlspecialchars', $textareaClass)); 

        // Obtener el valor desde $_POST
        $value = isset($_POST[$name]) ? htmlspecialchars($_POST[$name], ENT_QUOTES, 'UTF-8') : "";

        // Establecer el atributo required si es necesario
        $isRequired = $required ? 'required' : '';

        ?>
        <div class="<?= $wrapperClass ?>">
            <label for="<?= htmlspecialchars($name) ?>" class="form-label"><?= htmlspecialchars($label) ?> <?= $isRequired ? '*' : '' ?></label>
            <textarea 
                id="<?= htmlspecialchars($name) ?>" 
                name="<?= htmlspecialchars($name) ?>" 
                placeholder="<?= htmlspecialchars($placeholder) ?>" 
                class="<?= htmlspecialchars($textareaClass) ?>" 
                <?= $isRequired ?>
                rows="2"><?= $value ?></textarea>

            <?php
            // Mostrar errores si existen
            if (isset($errors[$name])) {
                foreach ($errors[$name] as $error) {
                    ?>
                        <div class='error'>
                            <?= htmlspecialchars($error); ?>
                        </div>
                    <?php
                }
            }
            ?>
        </div>
        <?php
    }
}

