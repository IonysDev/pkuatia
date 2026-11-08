<?php

/**
 * Configuración de php-cs-fixer de PKuatia (Fase D, 0.3.1).
 *
 * Solo reglas sin cambio semántico: ninguna regla "riesgosa" (setRiskyAllowed(false) lo impide), ninguna que toque
 * docblocks ni cadenas. La indentación es de cuatro espacios (PSR-12, decisión Q-D1 de la Fase D); la regla
 * `line_ending` queda desactivada a propósito: los finales de línea de cada archivo no se tocan (git los normaliza a
 * LF en el índice con `text=auto`). En Windows, donde la copia de trabajo mezcla CRLF y LF, correr el fixer con
 * `PKUATIA_CS_EOL=crlf` sobre los archivos CRLF para que las líneas que inserte lleven el mismo final que el archivo.
 *
 * Uso: composer cs-check (solo informa) · composer cs-fix (corrige).
 */

$finder = (new PhpCsFixer\Finder())
    ->in([__DIR__ . '/src', __DIR__ . '/tests', __DIR__ . '/test', __DIR__ . '/tools'])
    ->notPath('#^Resources/codigos/#') // catálogos generados por tools/generar-catalogos.php: no se formatean a mano
    ->name('*.php');

$finalDeLinea = getenv('PKUATIA_CS_EOL') === 'crlf' ? "\r\n" : "\n";

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(false)
    ->setIndent('    ')
    ->setLineEnding($finalDeLinea)
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setFinder($finder)
    ->setRules([
        // Tipos
        'native_type_declaration_casing' => true,                 // String → string en declaraciones (alias idéntico para PHP)
        'nullable_type_declaration_for_default_null_value' => true, // Tipo $x = null → ?Tipo $x = null (deprecado en PHP 8.4)
        'compact_nullable_type_declaration' => true,
        'type_declaration_spaces' => true,
        'lowercase_cast' => true,
        'short_scalar_cast' => true,
        'cast_spaces' => true,
        // Archivo
        'encoding' => true,
        'full_opening_tag' => true,
        'blank_line_after_opening_tag' => true,
        'no_closing_tag' => true,
        'single_blank_line_at_eof' => true,
        'line_ending' => false,                                   // los finales de línea no se tocan (ver arriba)
        'no_trailing_whitespace' => true,
        'no_trailing_whitespace_in_comment' => true,
        'no_whitespace_in_blank_line' => true,
        // Espacios de nombres e importaciones
        'blank_line_after_namespace' => true,
        'single_line_after_imports' => true,
        'single_import_per_statement' => true,
        'no_leading_import_slash' => true,
        'no_unused_imports' => true,
        // Palabras clave y constantes
        'lowercase_keywords' => true,
        'constant_case' => true,
        'lowercase_static_reference' => true,
        'declare_equal_normalize' => true,
        'single_space_around_construct' => true,
        'elseif' => true,
        // Clases y funciones
        'class_definition' => true,
        'no_blank_lines_after_class_opening' => true,
        'single_class_element_per_statement' => true,
        'visibility_required' => ['elements' => ['method', 'property', 'const']],
        'function_declaration' => true,
        'method_argument_space' => ['on_multiline' => 'ignore'],   // no reacomoda las llamadas de varias líneas
        'no_spaces_after_function_name' => true,
        'return_type_declaration' => ['space_before' => 'none'],
        'new_with_parentheses' => true,
        'no_space_around_double_colon' => true,
        // Estructuras de control
        'control_structure_braces' => true,
        'control_structure_continuation_position' => true,
        'braces_position' => true,
        'no_multiple_statements_per_line' => true,
        'switch_case_semicolon_to_colon' => true,
        'switch_case_space' => true,
        'no_break_comment' => true,
        'spaces_inside_parentheses' => true,
        // Operadores
        'ternary_operator_spaces' => true,
        'unary_operator_spaces' => true,
        'array_syntax' => ['syntax' => 'short'],
        // Indentación (Q-D1: cuatro espacios; aplicada en un commit aislado, D4)
        'indentation_type' => true,
        'statement_indentation' => true,
    ]);
