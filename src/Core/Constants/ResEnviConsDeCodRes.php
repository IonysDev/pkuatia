<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los códigos de respuesta del WS de consulta de comprobantes electrónicos.
 * Estos valores corresponden al campo dCodRes (DRSch03), asi como a su descripción correspondiente del campo dMsgRes (DRSch04) del grupo rResEnviConsDe  (DRSch01).
 */
enum ResEnviConsDeCodRes: int {

    case CDCInexistente = 420;
    case RUCSinPermiso = 421;
    case CDCEncontrado = 422;

    public function getDescription(): string
    {
        return match($this) {
            self::CDCInexistente => 'CDC Inexistente',
            self::RUCSinPermiso => 'RUC Sin Permiso',
            self::CDCEncontrado => 'CDC Encontrado'
        };
    }

    public static function getDescriptionFromValue(int|string $value): ?string
    {
        return self::tryFrom($value)?->getDescription();
    }

    public static function getValueDescriptionMap(): array
    {
        $list = [];
        foreach (self::cases() as $case) {
            $list[$case->value] = $case->getDescription();
        }

        return $list;
    }

    public static function toIdNameList(): array
    {
        $list = [];
        foreach (self::cases() as $case) {
            $list[] = ['id' => $case->value, 'name' => $case->getDescription()];
        }

        return $list;
    }

    /**
     * @deprecated Use getDescriptionFromValue() instead.
     */
    public static function getDescripcion(int $value): ?string
    {
        return self::getDescriptionFromValue($value);
    }
}

?>
