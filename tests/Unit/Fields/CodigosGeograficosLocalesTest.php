<?php

namespace IonysDev\Pkuatia\Tests\Unit\Fields;

use DOMDocument;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamEnt;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamSal;
use PHPUnit\Framework\TestCase;

/**
 * cDepSal (E924) llevaba el código del distrito: GCamSal::toDOMElement() lo escribía con getCDisSal(). Corregido en
 * main por Gabriel Gauto (1f479ba, 04/11/2026) e incorporado a la rama de la Fase D en su QA final. Los fixtures de
 * DocumentoFactory usan departamento, distrito y ciudad 1, así que ningún test lo distinguía: aquí se usan códigos
 * reales distintos de PyGeoCodes.xml (11 ALTO PARANA, distrito 142 HERNANDARIAS, ciudad 3298 PUERTO STAMATO).
 * GCamEnt se prueba igual como control (no tenía el defecto).
 */
final class CodigosGeograficosLocalesTest extends TestCase
{
    public function testElLocalDeSalidaEmiteElDepartamentoYNoElDistrito(): void
    {
        $sal = (new GCamSal())->setDDirLocSal('Ruta 7 km 30')->setDNumCasSal(100)->setCDepSal(11)->setCDisSal(142)->setCCiuSal(3298);
        $doc = new DOMDocument();
        $xml = $doc->saveXML($sal->toDOMElement($doc));
        $this->assertStringContainsString('<cDepSal>11</cDepSal><dDesDepSal>ALTO PARANA</dDesDepSal>', $xml);
        $this->assertStringContainsString('<cDisSal>142</cDisSal><dDesDisSal>HERNANDARIAS</dDesDisSal>', $xml);
        $this->assertStringContainsString('<cCiuSal>3298</cCiuSal><dDesCiuSal>PUERTO STAMATO</dDesCiuSal>', $xml);
    }

    public function testElLocalDeEntregaEmiteElDepartamentoYNoElDistrito(): void
    {
        $ent = (new GCamEnt())->setDDirLocEnt('Ruta 7 km 30')->setDNumCasEnt(200)->setCDepEnt(11)->setCDisEnt(142)->setCCiuEnt(3298);
        $doc = new DOMDocument();
        $xml = $doc->saveXML($ent->toDOMElement($doc));
        $this->assertStringContainsString('<cDepEnt>11</cDepEnt><dDesDepEnt>ALTO PARANA</dDesDepEnt>', $xml);
        $this->assertStringContainsString('<cDisEnt>142</cDisEnt><dDesDisEnt>HERNANDARIAS</dDesDisEnt>', $xml);
        $this->assertStringContainsString('<cCiuEnt>3298</cCiuEnt><dDesCiuEnt>PUERTO STAMATO</dDesCiuEnt>', $xml);
    }
}
