<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal to :value.',
        'file' => 'The :attribute must be less than or equal to :value kilobytes.',
        'string' => 'The :attribute must be less than or equal to :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'mac_address' => 'The :attribute must be a valid MAC address.',
    'max' => [
        'numeric' => 'The :attribute must not be greater than :max.',
        'file' => 'The :attribute must not be greater than :max kilobytes.',
        'string' => 'The :attribute must not be greater than :max characters.',
        'array' => 'The :attribute must not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid timezone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute must be a valid URL.',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],

        // Módulo administradores
        'nombre' => [
            'required' => 'El :attribute no puede ser vacío y debe de tener una longitud mínima de 3 caracteres máximo 25.',
            'min' => 'El :attribute debe de tener una longitud mínima de 3 caracteres.',
            'max' => 'El :attribute debe de tener una longitud máxima de 25 caracteres.',
        ],
        'email' => [
            'required' => 'El correo electrónico es obligatorio.',
            'email' => 'El correo electrónico es incorrecto.',
            'unique' => 'El email que esta intentando utilizar para el registro ya existe.'
        ],
        'apellidoPaterno' => [
            'required' => 'El :attribute no puede ser vacío y debe de tener una longitud mínima de 3 caracteres máximo 25.',
            'min' => 'El :attribute debe de tener una longitud mínima de 3 caracteres.',
            'max' => 'El :attribute debe de tener una longitud máxima de 25 caracteres.',
        ],
        'telCelular' => [
            'required' => 'El teléfono celulular es obligatorio.',
            'numeric' => 'El teléfono celulular debe ser numérico de 10 dígitos.',
            'digits_between' => 'El teléfono celulular debe de tener una longitud máxima de 10 dígitos.',
        ],
        'telCasa' => [
            'numeric' => 'El teléfono de casa debe ser numérico de 10 dígitos.',
            'digits_between' => 'El teléfono de casa debe de tener una longitud máxima de 10 dígitos.',
        ],
        'fechaNacimiento' => [
            'required' => 'La fecha de nacimiento es obligatoria.',
            'date' => 'La fecha de nacimiento es incorrecta.',
        ],
        'direccion' => [
            'required' => 'La dirección es obligatoria.',
            'min' => 'La dirección debe de tener una longitud mínima de 15 caracteres.',
        ],
        'codigoPostal' => [
            'required' => 'El código postal es obligatorio.',
            'numeric' => 'El código postal es incorrecto.',
            'digits_between' => 'El código postal debe de tener una longitud máxima de 5 dígitos.',
        ],
        'correoUsuario' => [
            'required' => 'El correo o nombre de usuario es obligatorio.',
        ],
        'password' => [
            'required' => 'La contraseña es obligatoria.',
        ],
        'idAdministrador' => [
            'required' => 'El administrador que esta intentando eliminar no existe.',
            'gt' => 'El administrador que esta intentando eliminar no existe.'
        ],
        'nombreUsuario' => [
            'required' => 'El nombre de usuario es obligatorio.',
            'min' => 'El nombre de usuario debe de tener una longitud mínima de 5 caracteres.',
            'max' => 'El nombre de usuario debe de tener una longitud máxima de 25 caracteres.',
        ],
        'passwordAdministrador' => [
            'required' => 'La contraseña es obligatoria.',
            // 'password' => 'La contraseña debe de tener un formato válido convinando símbolos, letras y números.',
            'min' => 'La contraseña debe de tener una longitud mínima de 5 caracteres.',
        ],
        
        // Módulo categorías
        'nombreCategoria' => [
            'required' => 'El nombre de la categoría no puede ser vacía y debe de tener una longitud mínima de 5 caracteres máxima 25.',
            'min' => 'El nombre de la categoría debe de tener una longitud mínima de 5 caracteres.',
            'max' => 'El nombre de la categoría debe de tener una longitud máxima de 25 caracteres.',
            'string' => 'El nombre para la categoría es incorrecto.',
        ],
        'descripcionCategoria' => [
            'required' => 'La descripción para la categoría no puede ser vacía y debe de tener una longitud mínima de 10 caracteres máxima 150.',
            'min' => 'La descripción para la categoría debe de tener una longitud mínima de 10 caracteres.',
            'max' => 'La descripción para la categoría debe de tener una longitud máxima de 150 caracteres.',
            'string' => 'La descripción para la categoría es incorrecta.',
        ],
        'idCategoria' => [
            'required' => 'La categoría que esta intentando eliminar no existe.',
            'gt' => 'La categoría que esta intentando eliminar no existe.'
        ],

        // Módulo de productos
        'nombreProducto' => [
            'required' => "El nombre del producto es obligarorio y debe tener una longitud mínima de 3 caracteres máximo 50.",
            'min' => "El nombre del producto debe de tener una longitud mínima de 3 caracteres.",
            'max' => "El nombre del producto debe de tener una longitud máxima de 50 caracteres."
        ],
        'descripcionEspecificaProducto' => [
            'required' => "La descripción específica para el producto es obliglatoria.",
            'min' => "La descripción específica para el producto debe de tener una longitud mínima de 10 caracteres.",
            'max' => "La descripción específica para el producto debe de tener una longitud máxima de 100 caracteres .",
        ],
        'descripcionGeneralProducto' => [
            'required' => "La descripción general para el producto es obliglatoria.",
            'min' => "La descripción general para el producto debe de tener una longitud mínima de 10 caracteres.",
            'max' => "La descripción general para el producto debe de tener una longitud máxima de 200 caracteres .",
        ],
        'precioProducto' => [
            'required' => "El precio del producto es obligatorio.",
            'numeric' => "El precio del producto debe se numérico mayor o igual a 0.",
        ],
        'descuentoProducto' => [
            'numeric' => "El descuento para el producto debe ser numérico entre 0 y 100.",
            'digits_between' => "El descuento para el producto debe ser numérico entre 0 y 100.",
        ],
        'idProducto' => [
            'required' => 'El producto que esta intentando eliminar no existe.',
            'gt' => 'El producto que esta intentando eliminar no existe.'
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
