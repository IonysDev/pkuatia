<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los códigos de respuesta del WS de envío de lotes de comprobantes electrónicos.
 * Estos valores corresponden al campo dCodRes (BRSch03), asi como a su descripción correspondiente del campo dMsgRes (BRSch04) del grupo rResEnviLoteDe (BRSch01).
 */
enum ResEnviLoteDeCodRes: int {

    case EntradaSuperiorA100000KB = 270;
    case LoteRecibidoConExito = 300;
    case LoteNoEncolado = 301;

    public function getDescription(): string
    {
        return match($this) {
            self::EntradaSuperiorA100000KB => 'Entrada superior a 100000 KB',
            self::LoteRecibidoConExito => 'Lote recibido con éxito',
            self::LoteNoEncolado => 'Lote no encolado'
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
