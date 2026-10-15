<?php

/**
 * Generador de los catálogos de src/Resources/codigos/ a partir de ekuat-ia (Fase C, paso C5).
 *
 * No forma parte del autoload de la librería: lo usan tools/generar-catalogos.php (línea de comandos) y
 * tests/Unit/Resources/CatalogosSincroniaTest.php (require_once). Lee las tablas Markdown de
 * 08-errores-y-respuestas/*.md y 03-estructura-xml/campos-obligatorios.md y el XSD fiel 00-fuentes/xsd/DE_v150.xsd.
 *
 * Reglas de lectura:
 * - Las marcas del MT ([NUEVO], [MODIFICADO], [NT-023], **negrita**) se quitan de todas las celdas.
 * - Las filas ~~tachadas~~ (eliminadas en v150) se conservan con vigente = false.
 * - Los códigos repetidos (p. ej. 4313-4323 en la tabla 11.6.7) se conservan todos.
 * - En respuestas-ws.md se omite la tabla "tal como aparece en el MT" (12.3.4.3, con el 0421 "(sic)") y se toman los
 *   "Códigos vigentes" de la resolución del 03/10/2026 con los IDs BL01, BL02 y BL03.
 */
final class GeneradorCatalogos
{
  private const IDS_CONSULTA_DE = ['0420' => 'BL01', '0421' => 'BL02', '0422' => 'BL03'];

  /** @return array<string, array> nombre de catálogo => datos (lo que devuelve cada archivo PHP) */
  public static function generarTodo(string $docs): array
  {
    $errores = "$docs/08-errores-y-respuestas";
    $ids = self::idsPorCampo(file_get_contents("$docs/03-estructura-xml/campos-obligatorios.md"));
    return [
      'validaciones-de' => self::validacionesDe(file_get_contents("$errores/errores-validacion.md")),
      'validaciones-evento' => self::validacionesEvento(file_get_contents("$errores/eventos-respuesta.md")),
      'respuestas-ws' => self::respuestasWs(file_get_contents("$errores/respuestas-ws.md")),
      'elementos-de' => self::elementosDe("$docs/00-fuentes/xsd/DE_v150.xsd", $ids),
    ];
  }

  /** Validaciones del DE (MT §12.4): tablas con ID, Mensaje, Código y Tipo. */
  public static function validacionesDe(string $md): array
  {
    $entradas = [];
    foreach (self::tablas($md) as $tabla) {
      $c = self::columnas($tabla['columnas'], ['id' => ['ID'], 'mensaje' => ['Mensaje'], 'codigo' => ['Código'], 'estado' => ['Tipo'], 'observacion' => ['Observación']]);
      if ($c === null)
        continue;
      foreach ($tabla['filas'] as $fila) {
        $entrada = self::entrada($fila, $c, $tabla['seccion'], 'errores-validacion.md');
        if ($entrada !== null)
          $entradas[] = $entrada;
      }
    }
    return ['origen' => 'ekuat-ia 08-errores-y-respuestas/errores-validacion.md (MT v150 §12.4)', 'entradas' => $entradas];
  }

  /** Validaciones de los eventos (MT §11.6): tablas con N° Val, ID, Mensaje de Validación, Código, Observación y E. */
  public static function validacionesEvento(string $md): array
  {
    $entradas = [];
    foreach (self::tablas($md) as $tabla) {
      $c = self::columnas($tabla['columnas'], ['id' => ['ID'], 'mensaje' => ['Mensaje de Validación'], 'codigo' => ['Código'], 'estado' => ['E'], 'observacion' => ['Observación']]);
      if ($c === null || !in_array('N° Val', $tabla['columnas'], true))
        continue;
      foreach ($tabla['filas'] as $fila) {
        $entrada = self::entrada($fila, $c, $tabla['seccion'], 'eventos-respuesta.md');
        if ($entrada !== null)
          $entradas[] = $entrada;
      }
    }
    return ['origen' => 'ekuat-ia 08-errores-y-respuestas/eventos-respuesta.md (MT v150 §11.6)', 'entradas' => $entradas];
  }

  /** Códigos de los web services (MT §12.2 y §12.3). */
  public static function respuestasWs(string $md): array
  {
    $entradas = [];
    foreach (self::tablas($md) as $tabla) {
      // Tabla de la resolución 0420/0421/0422: Código | Resultado | E | Fuente.
      if ($tabla['columnas'][0] === 'Código' && in_array('Fuente', $tabla['columnas'], true)) {
        foreach ($tabla['filas'] as $fila) {
          $codigo = self::codigo($fila['celdas'][0]);
          if ($codigo === null)
            continue;
          $entradas[] = [
            'codigo' => $codigo,
            'id' => self::IDS_CONSULTA_DE[$codigo] ?? null,
            'mensaje' => self::sinParentesisFinal(self::limpiar($fila['celdas'][1])),
            'estado' => self::limpiar($fila['celdas'][2]),
            'grupo' => $tabla['seccion'],
            'observacion' => self::limpiar($fila['celdas'][3] ?? ''),
            'vigente' => !$fila['tachada'],
            'fuente' => 'respuestas-ws.md:' . $fila['linea'],
          ];
        }
        continue;
      }
      $c = self::columnas($tabla['columnas'], ['id' => ['ID'], 'mensaje' => ['Resultado de Validación'], 'codigo' => ['Código'], 'estado' => ['E'], 'observacion' => ['Observaciones']]);
      if ($c === null || str_contains($tabla['columnas'][$c['codigo']], 'MT 12.3.4.3'))
        continue;
      foreach ($tabla['filas'] as $fila) {
        $entrada = self::entrada($fila, $c, $tabla['seccion'], 'respuestas-ws.md');
        if ($entrada !== null) {
          $entrada['mensaje'] = self::sinParentesisFinal($entrada['mensaje']);
          $entradas[] = $entrada;
        }
      }
    }
    return ['origen' => 'ekuat-ia 08-errores-y-respuestas/respuestas-ws.md (MT v150 §12.2-12.3, resolución 0420/0421/0422 del 03/10/2026)', 'entradas' => $entradas];
  }

  /** ID del MT por nombre de elemento XML (03-estructura-xml/campos-obligatorios.md). */
  public static function idsPorCampo(string $md): array
  {
    $ids = [];
    foreach (self::tablas($md) as $tabla) {
      $c = self::columnas($tabla['columnas'], ['id' => ['ID'], 'campo' => ['Campo']]);
      if ($c === null)
        continue;
      foreach ($tabla['filas'] as $fila) {
        $campo = self::limpiar($fila['celdas'][$c['campo']] ?? '');
        $id = self::limpiar($fila['celdas'][$c['id']] ?? '');
        if ($campo !== '' && preg_match('/^[A-Z]{1,3}\d{3}[a-z]?$/', $id) && !isset($ids[$campo]))
          $ids[$campo] = $id;
      }
    }
    return $ids;
  }

  /**
   * Elementos y tipos complejos del XSD fiel, con línea, ocurrencias, padre y el ID del MT.
   *
   * @param array<string, string> $idsPorCampo
   */
  public static function elementosDe(string $xsd, array $idsPorCampo): array
  {
    $doc = new DOMDocument();
    $doc->load($xsd, LIBXML_NONET);
    $xp = new DOMXPath($doc);
    $xp->registerNamespace('xs', 'http://www.w3.org/2001/XMLSchema');
    $tipos = [];
    foreach ($xp->query('//xs:complexType[@name]') as $nodo) {
      /** @var DOMElement $nodo */
      $tipos[$nodo->getAttribute('name')] = ['linea' => $nodo->getLineNo(), 'hijos' => []];
    }
    $elementos = [];
    foreach ($xp->query('//xs:element') as $nodo) {
      /** @var DOMElement $nodo */
      if ($nodo->hasAttribute('name')) {
        $original = $nodo->getAttribute('name');
        $nombre = trim($original);
        $tipo = $nodo->hasAttribute('type') ? $nodo->getAttribute('type') : null;
      } elseif ($nodo->hasAttribute('ref')) {
        $ref = $nodo->getAttribute('ref');
        $original = $ref;
        $nombre = str_contains($ref, ':') ? substr($ref, strpos($ref, ':') + 1) : $ref;
        $tipo = $ref;
      } else {
        continue;
      }
      $padre = null;
      $contenedor = 'sequence';
      $contenedorFijado = false;
      for ($a = $nodo->parentNode; $a instanceof DOMElement; $a = $a->parentNode) {
        if (!$contenedorFijado && in_array($a->localName, ['sequence', 'choice', 'all'], true)) {
          $contenedor = $a->localName;
          $contenedorFijado = true;
        }
        if ($a->localName === 'complexType' && $a->hasAttribute('name')) {
          $padre = $a->getAttribute('name');
          break;
        }
        if ($a->localName === 'element' && $a->hasAttribute('name')) {
          $padre = trim($a->getAttribute('name'));
          break;
        }
      }
      $max = $nodo->hasAttribute('maxOccurs') ? $nodo->getAttribute('maxOccurs') : '1';
      $tieneHijos = $xp->query('./xs:complexType', $nodo)->length > 0;
      $ocurrencia = [
        'nombre' => $nombre,
        'nombreOriginal' => $original,
        'tipo' => $tipo,
        'minOccurs' => $nodo->hasAttribute('minOccurs') ? (int) $nodo->getAttribute('minOccurs') : 1,
        'maxOccurs' => $max === 'unbounded' ? null : (int) $max,
        'padre' => $padre,
        'contenedor' => $contenedor,
        'linea' => $nodo->getLineNo(),
        'campoMT' => $idsPorCampo[$nombre] ?? null,
        'esGrupo' => $tieneHijos || ($tipo !== null && str_starts_with($tipo, 'tg')) || $tipo === 'tDE',
      ];
      if ($padre === null)
        continue;
      $elementos[$nombre][] = $ocurrencia;
      if (isset($tipos[$padre]))
        $tipos[$padre]['hijos'][] = $nombre;
    }
    return ['origen' => 'ekuat-ia 00-fuentes/xsd/DE_v150.xsd (copia fiel, líneas citables) + 03-estructura-xml/campos-obligatorios.md (ID del MT)', 'tipos' => $tipos, 'elementos' => $elementos];
  }

  /** Escribe un catálogo como archivo PHP que devuelve el arreglo (una línea por entrada). */
  public static function escribir(string $ruta, array $datos, string $encabezado): void
  {
    file_put_contents($ruta, "<?php\n\n// " . str_replace("\n", "\n// ", $encabezado) . "\n// Generado por tools/generar-catalogos.php. NO EDITAR A MANO.\n\nreturn " . self::exportar($datos, 0) . ";\n");
  }

  private static function exportar(mixed $valor, int $nivel): string
  {
    if (!is_array($valor))
      return var_export($valor, true);
    $lista = array_is_list($valor);
    if (array_filter($valor, 'is_array') === []) {
      $partes = [];
      foreach ($valor as $k => $x)
        $partes[] = ($lista ? '' : var_export($k, true) . ' => ') . var_export($x, true);
      return '[' . implode(', ', $partes) . ']';
    }
    $sangria = str_repeat('  ', $nivel + 1);
    $partes = [];
    foreach ($valor as $k => $x)
      $partes[] = $sangria . ($lista ? '' : var_export($k, true) . ' => ') . self::exportar($x, $nivel + 1) . ',';
    return "[\n" . implode("\n", $partes) . "\n" . str_repeat('  ', $nivel) . ']';
  }

  // --- Lectura de Markdown -------------------------------------------------------------------------------------

  /**
   * Tablas del Markdown: sección (último encabezado), columnas (limpias), filas (celdas crudas, línea, tachada).
   *
   * @return list<array{seccion: string, columnas: list<string>, filas: list<array{celdas: list<string>, linea: int, tachada: bool}>, linea: int}>
   */
  public static function tablas(string $md): array
  {
    $lineas = preg_split('/\r?\n/', $md);
    $n = count($lineas);
    $tablas = [];
    $seccion = '';
    for ($i = 0; $i < $n; $i++) {
      $l = $lineas[$i];
      if (preg_match('/^#{1,6}\s+(.*)$/', $l, $m)) {
        $seccion = self::limpiar($m[1]);
        continue;
      }
      if (str_starts_with($l, '|') && isset($lineas[$i + 1]) && preg_match('/^\|\s*:?-{2,}/', $lineas[$i + 1])) {
        $columnas = array_map([self::class, 'limpiar'], self::celdas($l));
        $filas = [];
        for ($j = $i + 2; $j < $n && str_starts_with($lineas[$j], '|'); $j++) {
          $celdas = self::celdas($lineas[$j]);
          $filas[] = ['celdas' => $celdas, 'linea' => $j + 1, 'tachada' => str_starts_with(trim($celdas[0] ?? ''), '~~')];
        }
        $tablas[] = ['seccion' => $seccion, 'columnas' => $columnas, 'filas' => $filas, 'linea' => $i + 1];
        $i = $j - 1;
      }
    }
    return $tablas;
  }

  /** Quita las marcas del MT y la negrita; colapsa espacios. */
  public static function limpiar(string $texto): string
  {
    $t = preg_replace('/\*\*\[[^\]]*\]\*\*/', '', $texto);
    $t = preg_replace('/\[(NUEVO|MODIFICADO|NT-\d+)[^\]]*\]/', '', $t);
    $t = str_replace(['~~', '**', '`'], '', $t);
    return trim(preg_replace('/\s+/', ' ', $t));
  }

  /** @return list<string> */
  private static function celdas(string $linea): array
  {
    $t = trim($linea);
    $t = preg_replace('/^\|/', '', $t);
    $t = preg_replace('/\|$/', '', $t);
    return array_map('trim', preg_split('/(?<!\\\\)\|/', $t));
  }

  /**
   * Índices de columna por nombre lógico; null si falta alguna de las obligatorias (las que no empiezan con '?').
   *
   * @param list<string> $columnas
   * @param array<string, list<string>> $buscadas
   * @return array<string, int>|null
   */
  private static function columnas(array $columnas, array $buscadas): ?array
  {
    $res = [];
    foreach ($buscadas as $clave => $nombres) {
      $indice = null;
      foreach ($columnas as $i => $col) {
        foreach ($nombres as $nombre) {
          if ($col === $nombre || str_starts_with($col, $nombre . ' ')) {
            $indice = $i;
            break 2;
          }
        }
      }
      if ($indice === null) {
        if ($clave === 'observacion')
          continue;
        return null;
      }
      $res[$clave] = $indice;
    }
    return $res;
  }

  private static function entrada(array $fila, array $c, string $seccion, string $archivo): ?array
  {
    $celdas = $fila['celdas'];
    $codigo = self::codigo($celdas[$c['codigo']] ?? '');
    if ($codigo === null)
      return null;
    return [
      'codigo' => $codigo,
      'id' => self::limpiar($celdas[$c['id']] ?? '') ?: null,
      'mensaje' => self::limpiar($celdas[$c['mensaje']] ?? ''),
      'estado' => self::limpiar($celdas[$c['estado']] ?? ''),
      'grupo' => $seccion,
      'observacion' => isset($c['observacion']) ? self::limpiar($celdas[$c['observacion']] ?? '') : '',
      'vigente' => !$fila['tachada'],
      'fuente' => $archivo . ':' . $fila['linea'],
    ];
  }

  private static function codigo(string $celda): ?string
  {
    return preg_match('/(?<!\d)(\d{4})(?!\d)/', self::limpiar($celda), $m) ? $m[1] : null;
  }

  private static function sinParentesisFinal(string $texto): string
  {
    return trim(preg_replace('/\s*\([^()]*\)\s*$/', '', $texto));
  }
}
