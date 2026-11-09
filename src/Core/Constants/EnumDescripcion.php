<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Métodos comunes de los enums que modelan un código del Manual Técnico con su descripción (iCondOpe/dDCondOpe,
 * iTipIDRec/dDTipIDRec, etc.): la descripción a partir del valor, el mapa valor → descripción y la lista
 * [['id' => valor, 'name' => descripción], …]. Hasta 0.3.0 los 36 enums repetían literalmente estos tres métodos
 * (evaluación del 02/10/2026, §8); el trait los reúne sin cambiar ninguna firma (Fase D, D6).
 *
 * El enum que lo use debe ser un enum respaldado (int o string) y definir getDescription().
 */
trait EnumDescripcion
{
    abstract public function getDescription(): string;

    /**
     * Devuelve la descripción del caso cuyo valor es $value, o null si ningún caso tiene ese valor.
     */
    public static function getDescriptionFromValue(int|string $value): ?string
    {
        return self::tryFrom($value)?->getDescription();
    }

    /**
     * Devuelve el mapa valor → descripción de todos los casos.
     *
     * @return array<int|string, string>
     */
    public static function getValueDescriptionMap(): array
    {
        $list = [];
        foreach (self::cases() as $case) {
            $list[$case->value] = $case->getDescription();
        }

        return $list;
    }

    /**
     * Devuelve la lista de casos como [['id' => valor, 'name' => descripción], …].
     *
     * @return list<array{id: int|string, name: string}>
     */
    public static function toIdNameList(): array
    {
        $list = [];
        foreach (self::cases() as $case) {
            $list[] = ['id' => $case->value, 'name' => $case->getDescription()];
        }

        return $list;
    }
}
