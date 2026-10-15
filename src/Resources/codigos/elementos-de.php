<?php

// ekuat-ia 00-fuentes/xsd/DE_v150.xsd (copia fiel, líneas citables) + 03-estructura-xml/campos-obligatorios.md (ID del MT)
// ekuat-ia @ 3f277a7
// Generado por tools/generar-catalogos.php. NO EDITAR A MANO.

return [
  'origen' => 'ekuat-ia 00-fuentes/xsd/DE_v150.xsd (copia fiel, líneas citables) + 03-estructura-xml/campos-obligatorios.md (ID del MT)',
  'tipos' => [
    'tgCOpeDE' => [
      'linea' => 17,
      'hijos' => ['iTipEmi', 'dDesTipEmi', 'dCodSeg', 'dInfoEmi', 'dInfoFisc'],
    ],
    'tgDTim' => [
      'linea' => 33,
      'hijos' => ['iTiDE', 'dDesTiDE', 'dNumTim', 'dEst', 'dPunExp', 'dNumDoc', 'dSerieNum', 'dFeIniT'],
    ],
    'tgEmis' => [
      'linea' => 53,
      'hijos' => ['dRucEm', 'dDVEmi', 'iTipCont', 'cTipReg', 'dNomEmi', 'dNomFanEmi', 'dDirEmi', 'dNumCas', 'dCompDir1', 'dCompDir2', 'cDepEmi', 'dDesDepEmi', 'cDisEmi', 'dDesDisEmi', 'cCiuEmi', 'dDesCiuEmi', 'dTelEmi', 'dEmailE', 'dDenSuc', 'gActEco', 'gRespDE'],
    ],
    'tgActEco' => [
      'linea' => 98,
      'hijos' => ['cActEco', 'dDesActEco'],
    ],
    'tgRespDE' => [
      'linea' => 110,
      'hijos' => ['iTipIDRespDE', 'dDTipIDRespDE', 'dNumIDRespDE', 'dNomRespDE', 'dCarRespDE'],
    ],
    'tgDatRec' => [
      'linea' => 125,
      'hijos' => ['iNatRec', 'iTiOpe', 'cPaisRec', 'dDesPaisRe', 'iTiContRec', 'dRucRec', 'dDVRec', 'iTipIDRec', 'dDTipIDRec', 'dNumIDRec', 'dNomRec', 'dNomFanRec', 'dDirRec', 'dNumCasRec', 'cDepRec', 'dDesDepRec', 'cDisRec', 'dDesDisRec', 'cCiuRec', 'dDesCiuRec', 'dTelRec', 'dCelRec', 'dEmailRec', 'dCodCliente'],
    ],
    'tgDaGOC' => [
      'linea' => 182,
      'hijos' => ['dFeEmiDE', 'gOpeCom', 'gEmis', 'gDatRec'],
    ],
    'tgOpeCom' => [
      'linea' => 196,
      'hijos' => ['iTipTra', 'dDesTipTra', 'iTImp', 'dDesTImp', 'cMoneOpe', 'dDesMoneOpe', 'dCondTiCam', 'dTiCam', 'iCondAnt', 'dDesCondAnt', 'gOblAfe'],
    ],
    'tgOblAfe' => [
      'linea' => 222,
      'hijos' => ['cOblAfe', 'dDesOblAfe'],
    ],
    'tgPagTarCD' => [
      'linea' => 235,
      'hijos' => ['iDenTarj', 'dDesDenTarj', 'dRSProTar', 'dRUCProTar', 'dDVProTar', 'iForProPa', 'dCodAuOpe', 'dNomTit', 'dNumTarj'],
    ],
    'tgPagCheq' => [
      'linea' => 282,
      'hijos' => ['dNumCheq', 'dBcoEmi'],
    ],
    'tgCuotas' => [
      'linea' => 303,
      'hijos' => ['cMoneCuo', 'dDMoneCuo', 'dMonCuota', 'dVencCuo'],
    ],
    'tgCompPub' => [
      'linea' => 319,
      'hijos' => ['dModCont', 'dEntCont', 'dAnoCont', 'dSecCont', 'dFeCodCont'],
    ],
    'tgCamFE' => [
      'linea' => 335,
      'hijos' => ['iIndPres', 'dDesIndPres', 'dFecEmNR', 'gCompPub'],
    ],
    'tgValorItem' => [
      'linea' => 355,
      'hijos' => ['dPUniProSer', 'dTiCamIt', 'dTotBruOpeItem', 'gValorRestaItem'],
    ],
    'tgValorRestaItem' => [
      'linea' => 372,
      'hijos' => ['dDescItem', 'dPorcDesIt', 'dDescGloItem', 'dAntPreUniIt', 'dAntGloPreUniIt', 'dTotOpeItem', 'dTotOpeGs'],
    ],
    'tgCamIVA' => [
      'linea' => 396,
      'hijos' => ['iAfecIVA', 'dDesAfecIVA', 'dPropIVA', 'dTasaIVA', 'dBasGravIVA', 'dLiqIVAItem', 'dBasExe'],
    ],
    'tgCamISC' => [
      'linea' => 414,
      'hijos' => ['cCatISC', 'dDesCatISC', 'cTasaISC', 'dBaseGravISC', 'dLiqISCItem'],
    ],
    'tgRasMerc' => [
      'linea' => 430,
      'hijos' => ['dNumLote', 'dVencMerc', 'dNSerie', 'dNumPedi', 'dNumSegui', 'dNumReg', 'dNumRegEntCom', 'dNomPro'],
    ],
    'tgVehNuevo' => [
      'linea' => 502,
      'hijos' => ['iTipOpVN', 'dDesTipOpVN', 'dChasis', 'dColor', 'dPotencia', 'dCapMot', 'dPNet', 'dPBruto', 'iTipCom', 'dDesTipCom', 'dNroMotor', 'dCapTracc', 'dAnoFab', 'cTipVeh', 'dCapac', 'dCilin'],
    ],
    'tgGrupEner' => [
      'linea' => 611,
      'hijos' => ['dNroMed', 'dActiv', 'dCateg', 'dLecAnt', 'dLecAct', 'dConKwh'],
    ],
    'tgGrupSup' => [
      'linea' => 663,
      'hijos' => ['dNomCaj', 'dEfectivo', 'dVuelto', 'dDonac', 'dDesDonac'],
    ],
    'tgGrupSeg' => [
      'linea' => 706,
      'hijos' => ['dCodEmpSeg', 'gGrupPolSeg'],
    ],
    'tgGrupPolSeg' => [
      'linea' => 734,
      'hijos' => ['dPoliza', 'dUnidVig', 'dVigencia', 'dNumPoliza', 'dFecIniVig', 'dFecFinVig', 'dCodInt'],
    ],
    'tgCamEsp' => [
      'linea' => 794,
      'hijos' => ['gGrupEner', 'gGrupSeg', 'gGrupSup', 'gGrupAdi'],
    ],
    'tgGrupAdi' => [
      'linea' => 811,
      'hijos' => ['dCiclo', 'dFecIniC', 'dFecFinC', 'dVencPag', 'dContrato', 'dSalAnt', 'dCodConDncp'],
    ],
    'tgCamItem' => [
      'linea' => 863,
      'hijos' => ['dCodInt', 'dParAranc', 'dNCM', 'dDncpG', 'dDncpE', 'dGtin', 'dGtinPq', 'dDesProSer', 'cUniMed', 'dDesUniMed', 'dCantProSer', 'cPaisOrig', 'dDesPaisOrig', 'dInfItem', 'cRelMerc', 'dDesRelMerc', 'dCanQuiMer', 'dPorQuiMer', 'dCDCAnticipo', 'gValorItem', 'gCamIVA', 'gRasMerc', 'gVehNuevo'],
    ],
    'tgDtipDE' => [
      'linea' => 927,
      'hijos' => ['gCamFE', 'gCamAE', 'gCamNCDE', 'gCamNRE', 'gCamCond', 'gCamItem', 'gCamEsp', 'gTransp', 'gCamRDE'],
    ],
    'tgCamTrans' => [
      'linea' => 951,
      'hijos' => ['iNatTrans', 'dNomTrans', 'dRucTrans', 'dDVTrans', 'iTipIDTrans', 'dDTipIDTrans', 'dNumIDTrans', 'cNacTrans', 'dDesNacTrans', 'dNumIDChof', 'dNomChof', 'dDomFisc', 'dDirChof', 'dNombAg', 'dRucAg', 'dDVAg', 'dDirAge'],
    ],
    'tgCamNCDE' => [
      'linea' => 996,
      'hijos' => ['iMotEmi', 'dDesMotEmi'],
    ],
    'tgCamNRE' => [
      'linea' => 1009,
      'hijos' => ['iMotEmiNR', 'dDesMotEmiNR', 'iRespEmiNR', 'dDesRespEmiNR', 'dKmR', 'dFecEm', 'cPreFle'],
    ],
    'tgTransp' => [
      'linea' => 1043,
      'hijos' => ['iTipTrans', 'dDesTipTrans', 'iModTrans', 'dDesModTrans', 'iRespFlete', 'cCondNeg', 'dNuManif', 'dNuDespImp', 'dIniTras', 'dFinTras', 'cPaisDest', 'dDesPaisDest', 'gCamSal', 'gCamEnt', 'gVehTras', 'gCamTrans'],
    ],
    'tgVehTras' => [
      'linea' => 1100,
      'hijos' => ['dTiVehTras', 'dMarVeh', 'dTipIdenVeh', 'dNroIDVeh', 'dAdicVeh', 'dNroMatVeh', 'dNroVuelo'],
    ],
    'tgCamEnt' => [
      'linea' => 1202,
      'hijos' => ['dDirLocEnt', 'dNumCasEnt', 'dComp1Ent', 'dComp2Ent', 'cDepEnt', 'dDesDepEnt', 'cDisEnt', 'dDesDisEnt', 'cCiuEnt', 'dDesCiuEnt', 'dTelEnt'],
    ],
    'tgCamSal' => [
      'linea' => 1225,
      'hijos' => ['dDirLocSal', 'dNumCasSal', 'dComp1Sal', 'dComp2Sal', 'cDepSal', 'dDesDepSal', 'cDisSal', 'dDesDisSal', 'cCiuSal', 'dDesCiuSal', 'dTelSal'],
    ],
    'tgCamCond' => [
      'linea' => 1248,
      'hijos' => ['iCondOpe', 'dDCondOpe', 'gPaConEIni', 'gPagCred'],
    ],
    'tgPagCont' => [
      'linea' => 1264,
      'hijos' => ['iTiPago', 'dDesTiPag', 'dMonTiPag', 'cMoneTiPag', 'dDMoneTiPag', 'dTiCamTiPag', 'gPagTarCD', 'gPagCheq'],
    ],
    'tgPagCred' => [
      'linea' => 1288,
      'hijos' => ['iCondCred', 'dDCondCred', 'dPlazoCre', 'dCuotas', 'dMonEnt', 'gCuotas'],
    ],
    'tgCamAE' => [
      'linea' => 1351,
      'hijos' => ['iNatVen', 'dDesNatVen', 'iTipIDVen', 'dDTipIDVen', 'dNumIDVen', 'dNomVen', 'dDirVen', 'dNumCasVen', 'cDepVen', 'dDesDepVen', 'cDisVen', 'dDesDisVen', 'cCiuVen', 'dDesCiuVen', 'dDirProv', 'cDepProv', 'dDesDepProv', 'cDisProv', 'dDesDisProv', 'cCiuProv', 'dDesCiuProv'],
    ],
    'tgCamFEI' => [
      'linea' => 1385,
      'hijos' => ['cTipRegImp', 'dPuLleg', 'dNuDesp', 'dFecDesp', 'dNomDesp', 'dRucDesp', 'dDVDesp', 'cPaisProd', 'dDesPaisProd', 'dVend', 'dValorInv', 'dValorFle', 'dValorSeg', 'dValorImpGs', 'dDerAdu', 'dIndi', 'dSerValor', 'dIVAImp', 'dTasaIntAd'],
    ],
    'tgCamFEE' => [
      'linea' => 1580,
      'hijos' => ['cFleExp', 'dDesFleExp', 'dPuEmb'],
    ],
    'tgTotSub' => [
      'linea' => 1606,
      'hijos' => ['dSubExe', 'dSubExo', 'dSub5', 'dSub10', 'dTotOpe', 'dTotDesc', 'dTotDescGlotem', 'dTotAntItem', 'dTotAnt', 'dPorcDescTotal', 'dDescTotal', 'dAnticipo', 'dRedon', 'dComi', 'dTotGralOpe', 'dIVA5', 'dIVA10', 'dLiqTotIVA5', 'dLiqTotIVA10', 'dIVAComi', 'dTotIVA', 'dBaseGrav5', 'dBaseGrav10', 'dTBasGraIVA', 'dTotalGs'],
    ],
    'tDE' => [
      'linea' => 1653,
      'hijos' => ['dDVId', 'dFecFirma', 'dSisFact', 'gOpeDE', 'gTimb', 'gDatGralOpe', 'gDtipDE', 'gTotSub', 'gCamGen', 'gCamDEAsoc'],
    ],
    'tgCamDEAsoc' => [
      'linea' => 1688,
      'hijos' => ['iTipDocAso', 'dDesTipDocAso', 'dCdCDERef', 'dNTimDI', 'dEstDocAso', 'dPExpDocAso', 'dNumDocAso', 'iTipoDocAso', 'dDTipoDocAso', 'dFecEmiDI', 'dNumComRet', 'dNumResCF', 'iTipCons', 'dDesTipCons', 'dNumCons', 'dNumControl', 'dRucFus', 'dNumCuoDocAso', 'dImpCuoDocAso'],
    ],
    'tgCamGen' => [
      'linea' => 1770,
      'hijos' => ['dOrdCompra', 'dOrdVta', 'dAsiento', 'gCamCarg'],
    ],
    'tgCamCarg' => [
      'linea' => 1825,
      'hijos' => ['cUniMedTotVol', 'dDesUniMedTotVol', 'dTotVolMerc', 'cUniMedTotPes', 'dDesUniMedTotPes', 'dTotPesMerc', 'iCarCarga', 'dDesCarCarga'],
    ],
    'tgCamFuFD' => [
      'linea' => 1901,
      'hijos' => ['dCarQR', 'dInfAdic'],
    ],
    'rDE' => [
      'linea' => 1939,
      'hijos' => ['dVerFor', 'DE', 'Signature', 'gCamFuFD'],
    ],
    'tgCamRDE' => [
      'linea' => 1963,
      'hijos' => ['iForPag', 'dDesForPag', 'dNumTrans', 'dConc', 'dRucEntFin', 'dDvEntFin', 'dNomEntFin', 'dImpPag'],
    ],
  ],
  'elementos' => [
    'iTipEmi' => [
      ['nombre' => 'iTipEmi', 'nombreOriginal' => 'iTipEmi', 'tipo' => 'tiTipEmi', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCOpeDE', 'contenedor' => 'sequence', 'linea' => 24, 'campoMT' => 'B002', 'esGrupo' => false],
    ],
    'dDesTipEmi' => [
      ['nombre' => 'dDesTipEmi', 'nombreOriginal' => 'dDesTipEmi', 'tipo' => 'tdDesTipEmi', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCOpeDE', 'contenedor' => 'sequence', 'linea' => 25, 'campoMT' => 'B003', 'esGrupo' => false],
    ],
    'dCodSeg' => [
      ['nombre' => 'dCodSeg', 'nombreOriginal' => 'dCodSeg', 'tipo' => 'tiCodSe', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCOpeDE', 'contenedor' => 'sequence', 'linea' => 26, 'campoMT' => 'B004', 'esGrupo' => false],
    ],
    'dInfoEmi' => [
      ['nombre' => 'dInfoEmi', 'nombreOriginal' => 'dInfoEmi', 'tipo' => 'tdInfoEmi', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCOpeDE', 'contenedor' => 'sequence', 'linea' => 27, 'campoMT' => 'B005', 'esGrupo' => false],
    ],
    'dInfoFisc' => [
      ['nombre' => 'dInfoFisc', 'nombreOriginal' => 'dInfoFisc', 'tipo' => 'tdInfoFisc', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCOpeDE', 'contenedor' => 'sequence', 'linea' => 29, 'campoMT' => 'B006', 'esGrupo' => false],
    ],
    'iTiDE' => [
      ['nombre' => 'iTiDE', 'nombreOriginal' => 'iTiDE', 'tipo' => 'tiTiDE', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgDTim', 'contenedor' => 'sequence', 'linea' => 40, 'campoMT' => 'C002', 'esGrupo' => false],
    ],
    'dDesTiDE' => [
      ['nombre' => 'dDesTiDE', 'nombreOriginal' => 'dDesTiDE', 'tipo' => 'tdDesTiDE', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgDTim', 'contenedor' => 'sequence', 'linea' => 41, 'campoMT' => 'C003', 'esGrupo' => false],
    ],
    'dNumTim' => [
      ['nombre' => 'dNumTim', 'nombreOriginal' => 'dNumTim', 'tipo' => 'tdNumTim', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgDTim', 'contenedor' => 'sequence', 'linea' => 42, 'campoMT' => 'C004', 'esGrupo' => false],
    ],
    'dEst' => [
      ['nombre' => 'dEst', 'nombreOriginal' => 'dEst', 'tipo' => 'tdEst', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgDTim', 'contenedor' => 'sequence', 'linea' => 43, 'campoMT' => 'C005', 'esGrupo' => false],
    ],
    'dPunExp' => [
      ['nombre' => 'dPunExp', 'nombreOriginal' => 'dPunExp', 'tipo' => 'tdPunExp', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgDTim', 'contenedor' => 'sequence', 'linea' => 44, 'campoMT' => 'C006', 'esGrupo' => false],
    ],
    'dNumDoc' => [
      ['nombre' => 'dNumDoc', 'nombreOriginal' => 'dNumDoc', 'tipo' => 'tdNumDoc', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgDTim', 'contenedor' => 'sequence', 'linea' => 45, 'campoMT' => 'C007', 'esGrupo' => false],
    ],
    'dSerieNum' => [
      ['nombre' => 'dSerieNum', 'nombreOriginal' => 'dSerieNum', 'tipo' => 'tdSerieNum', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDTim', 'contenedor' => 'sequence', 'linea' => 47, 'campoMT' => 'C010', 'esGrupo' => false],
    ],
    'dFeIniT' => [
      ['nombre' => 'dFeIniT', 'nombreOriginal' => 'dFeIniT', 'tipo' => 'tdFeIniT', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgDTim', 'contenedor' => 'sequence', 'linea' => 48, 'campoMT' => 'C008', 'esGrupo' => false],
    ],
    'dRucEm' => [
      ['nombre' => 'dRucEm', 'nombreOriginal' => 'dRucEm', 'tipo' => 'tRuc', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 60, 'campoMT' => 'D101', 'esGrupo' => false],
    ],
    'dDVEmi' => [
      ['nombre' => 'dDVEmi', 'nombreOriginal' => 'dDVEmi', 'tipo' => 'tDVer', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 61, 'campoMT' => 'D102', 'esGrupo' => false],
    ],
    'iTipCont' => [
      ['nombre' => 'iTipCont', 'nombreOriginal' => 'iTipCont', 'tipo' => 'tiTipCont', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 62, 'campoMT' => 'D103', 'esGrupo' => false],
    ],
    'cTipReg' => [
      ['nombre' => 'cTipReg', 'nombreOriginal' => 'cTipReg', 'tipo' => 'tcTipReg', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 63, 'campoMT' => 'D104', 'esGrupo' => false],
    ],
    'dNomEmi' => [
      ['nombre' => 'dNomEmi', 'nombreOriginal' => 'dNomEmi', 'tipo' => 'tdNombre', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 64, 'campoMT' => 'D105', 'esGrupo' => false],
    ],
    'dNomFanEmi' => [
      ['nombre' => 'dNomFanEmi', 'nombreOriginal' => 'dNomFanEmi', 'tipo' => 'tdNombre', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 66, 'campoMT' => 'D106', 'esGrupo' => false],
    ],
    'dDirEmi' => [
      ['nombre' => 'dDirEmi', 'nombreOriginal' => 'dDirEmi', 'tipo' => 'tdDirec', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 67, 'campoMT' => 'D107', 'esGrupo' => false],
    ],
    'dNumCas' => [
      ['nombre' => 'dNumCas', 'nombreOriginal' => 'dNumCas', 'tipo' => 'tdNumCas', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 68, 'campoMT' => 'D108', 'esGrupo' => false],
    ],
    'dCompDir1' => [
      ['nombre' => 'dCompDir1', 'nombreOriginal' => 'dCompDir1', 'tipo' => 'tdDirec', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 69, 'campoMT' => 'D109', 'esGrupo' => false],
    ],
    'dCompDir2' => [
      ['nombre' => 'dCompDir2', 'nombreOriginal' => 'dCompDir2', 'tipo' => 'tdDirec', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 70, 'campoMT' => 'D110', 'esGrupo' => false],
    ],
    'cDepEmi' => [
      ['nombre' => 'cDepEmi', 'nombreOriginal' => 'cDepEmi', 'tipo' => 'tDepartamentos', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 71, 'campoMT' => 'D111', 'esGrupo' => false],
    ],
    'dDesDepEmi' => [
      ['nombre' => 'dDesDepEmi', 'nombreOriginal' => 'dDesDepEmi', 'tipo' => 'tDesDepartamento', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 72, 'campoMT' => 'D112', 'esGrupo' => false],
    ],
    'cDisEmi' => [
      ['nombre' => 'cDisEmi', 'nombreOriginal' => 'cDisEmi', 'tipo' => 'tcDisEmi', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 73, 'campoMT' => 'D113', 'esGrupo' => false],
    ],
    'dDesDisEmi' => [
      ['nombre' => 'dDesDisEmi', 'nombreOriginal' => 'dDesDisEmi', 'tipo' => 'tdDesDisEmi', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 75, 'campoMT' => 'D114', 'esGrupo' => false],
    ],
    'cCiuEmi' => [
      ['nombre' => 'cCiuEmi', 'nombreOriginal' => 'cCiuEmi', 'tipo' => 'tcCiuEmi', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 76, 'campoMT' => 'D115', 'esGrupo' => false],
    ],
    'dDesCiuEmi' => [
      ['nombre' => 'dDesCiuEmi', 'nombreOriginal' => 'dDesCiuEmi', 'tipo' => 'tdDesCiuEmi', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 77, 'campoMT' => 'D116', 'esGrupo' => false],
    ],
    'dTelEmi' => [
      ['nombre' => 'dTelEmi', 'nombreOriginal' => 'dTelEmi', 'tipo' => 'tdTel', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 78, 'campoMT' => 'D117', 'esGrupo' => false],
    ],
    'dEmailE' => [
      ['nombre' => 'dEmailE', 'nombreOriginal' => 'dEmailE', 'tipo' => 'tEmail', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 79, 'campoMT' => 'D118', 'esGrupo' => false],
    ],
    'dDenSuc' => [
      ['nombre' => 'dDenSuc', 'nombreOriginal' => 'dDenSuc', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 80, 'campoMT' => 'D119', 'esGrupo' => false],
    ],
    'gActEco' => [
      ['nombre' => 'gActEco', 'nombreOriginal' => 'gActEco', 'tipo' => 'tgActEco', 'minOccurs' => 1, 'maxOccurs' => 9, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 93, 'campoMT' => 'D130', 'esGrupo' => true],
    ],
    'gRespDE' => [
      ['nombre' => 'gRespDE', 'nombreOriginal' => 'gRespDE', 'tipo' => 'tgRespDE', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgEmis', 'contenedor' => 'sequence', 'linea' => 94, 'campoMT' => 'D140', 'esGrupo' => true],
    ],
    'cActEco' => [
      ['nombre' => 'cActEco', 'nombreOriginal' => 'cActEco', 'tipo' => 'tcActEco', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgActEco', 'contenedor' => 'sequence', 'linea' => 105, 'campoMT' => 'D131', 'esGrupo' => false],
    ],
    'dDesActEco' => [
      ['nombre' => 'dDesActEco', 'nombreOriginal' => 'dDesActEco', 'tipo' => 'tdDesActEco', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgActEco', 'contenedor' => 'sequence', 'linea' => 106, 'campoMT' => 'D132', 'esGrupo' => false],
    ],
    'iTipIDRespDE' => [
      ['nombre' => 'iTipIDRespDE', 'nombreOriginal' => 'iTipIDRespDE', 'tipo' => 'tiTipIDRespDE', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgRespDE', 'contenedor' => 'sequence', 'linea' => 117, 'campoMT' => 'D141', 'esGrupo' => false],
    ],
    'dDTipIDRespDE' => [
      ['nombre' => 'dDTipIDRespDE', 'nombreOriginal' => 'dDTipIDRespDE', 'tipo' => 'tdDTipIDRespDE', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgRespDE', 'contenedor' => 'sequence', 'linea' => 118, 'campoMT' => 'D142', 'esGrupo' => false],
    ],
    'dNumIDRespDE' => [
      ['nombre' => 'dNumIDRespDE', 'nombreOriginal' => 'dNumIDRespDE', 'tipo' => 'tdNumDocId', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgRespDE', 'contenedor' => 'sequence', 'linea' => 119, 'campoMT' => 'D143', 'esGrupo' => false],
    ],
    'dNomRespDE' => [
      ['nombre' => 'dNomRespDE', 'nombreOriginal' => 'dNomRespDE', 'tipo' => 'tdNombre', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgRespDE', 'contenedor' => 'sequence', 'linea' => 120, 'campoMT' => 'D144', 'esGrupo' => false],
    ],
    'dCarRespDE' => [
      ['nombre' => 'dCarRespDE', 'nombreOriginal' => 'dCarRespDE', 'tipo' => 'tdCargo', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgRespDE', 'contenedor' => 'sequence', 'linea' => 121, 'campoMT' => 'D145', 'esGrupo' => false],
    ],
    'iNatRec' => [
      ['nombre' => 'iNatRec', 'nombreOriginal' => 'iNatRec', 'tipo' => 'tiNatRec', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 132, 'campoMT' => 'D201', 'esGrupo' => false],
    ],
    'iTiOpe' => [
      ['nombre' => 'iTiOpe', 'nombreOriginal' => 'iTiOpe', 'tipo' => 'tiTiOpe', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 133, 'campoMT' => 'D202', 'esGrupo' => false],
    ],
    'cPaisRec' => [
      ['nombre' => 'cPaisRec', 'nombreOriginal' => 'cPaisRec', 'tipo' => 'paisType', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 134, 'campoMT' => 'D203', 'esGrupo' => false],
    ],
    'dDesPaisRe' => [
      ['nombre' => 'dDesPaisRe', 'nombreOriginal' => 'dDesPaisRe', 'tipo' => 'tDesPais', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 135, 'campoMT' => 'D204', 'esGrupo' => false],
    ],
    'iTiContRec' => [
      ['nombre' => 'iTiContRec', 'nombreOriginal' => 'iTiContRec', 'tipo' => 'tiTipCont', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 137, 'campoMT' => 'D205', 'esGrupo' => false],
    ],
    'dRucRec' => [
      ['nombre' => 'dRucRec', 'nombreOriginal' => 'dRucRec', 'tipo' => 'tRuc', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 138, 'campoMT' => 'D206', 'esGrupo' => false],
    ],
    'dDVRec' => [
      ['nombre' => 'dDVRec', 'nombreOriginal' => 'dDVRec', 'tipo' => 'tDVer', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 139, 'campoMT' => 'D207', 'esGrupo' => false],
    ],
    'iTipIDRec' => [
      ['nombre' => 'iTipIDRec', 'nombreOriginal' => 'iTipIDRec', 'tipo' => 'tiTipDocRec', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 141, 'campoMT' => 'D208', 'esGrupo' => false],
    ],
    'dDTipIDRec' => [
      ['nombre' => 'dDTipIDRec', 'nombreOriginal' => 'dDTipIDRec', 'tipo' => 'tdDtipDocRec', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 143, 'campoMT' => 'D209', 'esGrupo' => false],
    ],
    'dNumIDRec' => [
      ['nombre' => 'dNumIDRec', 'nombreOriginal' => 'dNumIDRec', 'tipo' => 'tdNumDocId', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 145, 'campoMT' => 'D210', 'esGrupo' => false],
    ],
    'dNomRec' => [
      ['nombre' => 'dNomRec', 'nombreOriginal' => 'dNomRec', 'tipo' => 'tdNombre', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 146, 'campoMT' => 'D211', 'esGrupo' => false],
    ],
    'dNomFanRec' => [
      ['nombre' => 'dNomFanRec', 'nombreOriginal' => 'dNomFanRec', 'tipo' => 'tdNombre', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 148, 'campoMT' => 'D212', 'esGrupo' => false],
    ],
    'dDirRec' => [
      ['nombre' => 'dDirRec', 'nombreOriginal' => 'dDirRec', 'tipo' => 'tdDirec', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 149, 'campoMT' => 'D213', 'esGrupo' => false],
    ],
    'dNumCasRec' => [
      ['nombre' => 'dNumCasRec', 'nombreOriginal' => 'dNumCasRec', 'tipo' => 'tdNumCas', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 151, 'campoMT' => 'D218', 'esGrupo' => false],
    ],
    'cDepRec' => [
      ['nombre' => 'cDepRec', 'nombreOriginal' => 'cDepRec', 'tipo' => 'tDepartamentos', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 153, 'campoMT' => 'D219', 'esGrupo' => false],
    ],
    'dDesDepRec' => [
      ['nombre' => 'dDesDepRec', 'nombreOriginal' => 'dDesDepRec', 'tipo' => 'tDesDepartamento', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 155, 'campoMT' => 'D220', 'esGrupo' => false],
    ],
    'cDisRec' => [
      ['nombre' => 'cDisRec', 'nombreOriginal' => 'cDisRec', 'tipo' => 'tDistrito', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 156, 'campoMT' => 'D221', 'esGrupo' => false],
    ],
    'dDesDisRec' => [
      ['nombre' => 'dDesDisRec', 'nombreOriginal' => 'dDesDisRec', 'tipo' => 'tDesDistrito', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 158, 'campoMT' => 'D222', 'esGrupo' => false],
    ],
    'cCiuRec' => [
      ['nombre' => 'cCiuRec', 'nombreOriginal' => 'cCiuRec', 'tipo' => 'tCiudad', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 159, 'campoMT' => 'D223', 'esGrupo' => false],
    ],
    'dDesCiuRec' => [
      ['nombre' => 'dDesCiuRec', 'nombreOriginal' => 'dDesCiuRec', 'tipo' => 'tDesCiudad', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 161, 'campoMT' => 'D224', 'esGrupo' => false],
    ],
    'dTelRec' => [
      ['nombre' => 'dTelRec', 'nombreOriginal' => 'dTelRec', 'tipo' => 'tdTel', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 162, 'campoMT' => 'D214', 'esGrupo' => false],
    ],
    'dCelRec' => [
      ['nombre' => 'dCelRec', 'nombreOriginal' => 'dCelRec', 'tipo' => 'tdCel', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 163, 'campoMT' => 'D215', 'esGrupo' => false],
    ],
    'dEmailRec' => [
      ['nombre' => 'dEmailRec', 'nombreOriginal' => 'dEmailRec', 'tipo' => 'tEmail', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 164, 'campoMT' => 'D216', 'esGrupo' => false],
    ],
    'dCodCliente' => [
      ['nombre' => 'dCodCliente', 'nombreOriginal' => 'dCodCliente', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDatRec', 'contenedor' => 'sequence', 'linea' => 165, 'campoMT' => 'D217', 'esGrupo' => false],
    ],
    'dFeEmiDE' => [
      ['nombre' => 'dFeEmiDE', 'nombreOriginal' => 'dFeEmiDE', 'tipo' => 'fecHhmmss', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgDaGOC', 'contenedor' => 'sequence', 'linea' => 189, 'campoMT' => 'D002', 'esGrupo' => false],
    ],
    'gOpeCom' => [
      ['nombre' => 'gOpeCom', 'nombreOriginal' => 'gOpeCom', 'tipo' => 'tgOpeCom', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDaGOC', 'contenedor' => 'sequence', 'linea' => 190, 'campoMT' => 'D010', 'esGrupo' => true],
    ],
    'gEmis' => [
      ['nombre' => 'gEmis', 'nombreOriginal' => 'gEmis', 'tipo' => 'tgEmis', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgDaGOC', 'contenedor' => 'sequence', 'linea' => 191, 'campoMT' => 'D100', 'esGrupo' => true],
    ],
    'gDatRec' => [
      ['nombre' => 'gDatRec', 'nombreOriginal' => 'gDatRec', 'tipo' => 'tgDatRec', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgDaGOC', 'contenedor' => 'sequence', 'linea' => 192, 'campoMT' => 'D200', 'esGrupo' => true],
    ],
    'iTipTra' => [
      ['nombre' => 'iTipTra', 'nombreOriginal' => 'iTipTra', 'tipo' => 'tiTipTra', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgOpeCom', 'contenedor' => 'sequence', 'linea' => 203, 'campoMT' => 'D011', 'esGrupo' => false],
    ],
    'dDesTipTra' => [
      ['nombre' => 'dDesTipTra', 'nombreOriginal' => 'dDesTipTra', 'tipo' => 'tdDesTiTran', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgOpeCom', 'contenedor' => 'sequence', 'linea' => 205, 'campoMT' => 'D012', 'esGrupo' => false],
    ],
    'iTImp' => [
      ['nombre' => 'iTImp', 'nombreOriginal' => 'iTImp', 'tipo' => 'tiTImp', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgOpeCom', 'contenedor' => 'sequence', 'linea' => 206, 'campoMT' => 'D013', 'esGrupo' => false],
    ],
    'dDesTImp' => [
      ['nombre' => 'dDesTImp', 'nombreOriginal' => 'dDesTImp', 'tipo' => 'tdDesTImp', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgOpeCom', 'contenedor' => 'sequence', 'linea' => 207, 'campoMT' => 'D014', 'esGrupo' => false],
    ],
    'cMoneOpe' => [
      ['nombre' => 'cMoneOpe', 'nombreOriginal' => 'cMoneOpe', 'tipo' => 'cMondT', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgOpeCom', 'contenedor' => 'sequence', 'linea' => 208, 'campoMT' => 'D015', 'esGrupo' => false],
    ],
    'dDesMoneOpe' => [
      ['nombre' => 'dDesMoneOpe', 'nombreOriginal' => 'dDesMoneOpe', 'tipo' => 'tdDMoneTiPag', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgOpeCom', 'contenedor' => 'sequence', 'linea' => 209, 'campoMT' => 'D016', 'esGrupo' => false],
    ],
    'dCondTiCam' => [
      ['nombre' => 'dCondTiCam', 'nombreOriginal' => 'dCondTiCam', 'tipo' => 'tdCondTiCam', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgOpeCom', 'contenedor' => 'sequence', 'linea' => 211, 'campoMT' => 'D017', 'esGrupo' => false],
    ],
    'dTiCam' => [
      ['nombre' => 'dTiCam', 'nombreOriginal' => 'dTiCam', 'tipo' => 'tTipoCambioBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgOpeCom', 'contenedor' => 'sequence', 'linea' => 213, 'campoMT' => 'D018', 'esGrupo' => false],
    ],
    'iCondAnt' => [
      ['nombre' => 'iCondAnt', 'nombreOriginal' => 'iCondAnt', 'tipo' => 'tiCondAnt', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgOpeCom', 'contenedor' => 'sequence', 'linea' => 214, 'campoMT' => 'D019', 'esGrupo' => false],
    ],
    'dDesCondAnt' => [
      ['nombre' => 'dDesCondAnt', 'nombreOriginal' => 'dDesCondAnt', 'tipo' => 'tdDesCondAnt', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgOpeCom', 'contenedor' => 'sequence', 'linea' => 216, 'campoMT' => 'D020', 'esGrupo' => false],
    ],
    'gOblAfe' => [
      ['nombre' => 'gOblAfe', 'nombreOriginal' => 'gOblAfe', 'tipo' => 'tgOblAfe', 'minOccurs' => 0, 'maxOccurs' => 12, 'padre' => 'tgOpeCom', 'contenedor' => 'sequence', 'linea' => 218, 'campoMT' => NULL, 'esGrupo' => true],
    ],
    'cOblAfe' => [
      ['nombre' => 'cOblAfe', 'nombreOriginal' => 'cOblAfe', 'tipo' => 'tcOblAfe', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgOblAfe', 'contenedor' => 'sequence', 'linea' => 229, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesOblAfe' => [
      ['nombre' => 'dDesOblAfe', 'nombreOriginal' => 'dDesOblAfe', 'tipo' => 'tdDesOblAfe', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgOblAfe', 'contenedor' => 'sequence', 'linea' => 230, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'iDenTarj' => [
      ['nombre' => 'iDenTarj', 'nombreOriginal' => 'iDenTarj', 'tipo' => 'tiDenTarj', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgPagTarCD', 'contenedor' => 'sequence', 'linea' => 243, 'campoMT' => 'E621', 'esGrupo' => false],
    ],
    'dDesDenTarj' => [
      ['nombre' => 'dDesDenTarj', 'nombreOriginal' => 'dDesDenTarj', 'tipo' => 'tdDesDenTarj', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgPagTarCD', 'contenedor' => 'sequence', 'linea' => 244, 'campoMT' => 'E622', 'esGrupo' => false],
    ],
    'dRSProTar' => [
      ['nombre' => 'dRSProTar', 'nombreOriginal' => 'dRSProTar', 'tipo' => 'dNomRazSocial', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgPagTarCD', 'contenedor' => 'sequence', 'linea' => 246, 'campoMT' => 'E623', 'esGrupo' => false],
    ],
    'dRUCProTar' => [
      ['nombre' => 'dRUCProTar', 'nombreOriginal' => 'dRUCProTar', 'tipo' => 'tRuc', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgPagTarCD', 'contenedor' => 'sequence', 'linea' => 247, 'campoMT' => 'E624', 'esGrupo' => false],
    ],
    'dDVProTar' => [
      ['nombre' => 'dDVProTar', 'nombreOriginal' => 'dDVProTar', 'tipo' => 'tDVer', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgPagTarCD', 'contenedor' => 'sequence', 'linea' => 248, 'campoMT' => 'E625', 'esGrupo' => false],
    ],
    'iForProPa' => [
      ['nombre' => 'iForProPa', 'nombreOriginal' => 'iForProPa', 'tipo' => 'tiForProPa', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgPagTarCD', 'contenedor' => 'sequence', 'linea' => 249, 'campoMT' => 'E626', 'esGrupo' => false],
    ],
    'dCodAuOpe' => [
      ['nombre' => 'dCodAuOpe', 'nombreOriginal' => 'dCodAuOpe', 'tipo' => 'tdNunApOpe', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgPagTarCD', 'contenedor' => 'sequence', 'linea' => 251, 'campoMT' => 'E627', 'esGrupo' => false],
    ],
    'dNomTit' => [
      ['nombre' => 'dNomTit', 'nombreOriginal' => 'dNomTit', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgPagTarCD', 'contenedor' => 'sequence', 'linea' => 252, 'campoMT' => 'E628', 'esGrupo' => false],
    ],
    'dNumTarj' => [
      ['nombre' => 'dNumTarj', 'nombreOriginal' => 'dNumTarj', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgPagTarCD', 'contenedor' => 'sequence', 'linea' => 265, 'campoMT' => 'E629', 'esGrupo' => false],
    ],
    'dNumCheq' => [
      ['nombre' => 'dNumCheq', 'nombreOriginal' => 'dNumCheq', 'tipo' => 'tNumCheq', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgPagCheq', 'contenedor' => 'sequence', 'linea' => 289, 'campoMT' => 'E631', 'esGrupo' => false],
    ],
    'dBcoEmi' => [
      ['nombre' => 'dBcoEmi', 'nombreOriginal' => 'dBcoEmi', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgPagCheq', 'contenedor' => 'sequence', 'linea' => 290, 'campoMT' => 'E632', 'esGrupo' => false],
    ],
    'cMoneCuo' => [
      ['nombre' => 'cMoneCuo', 'nombreOriginal' => 'cMoneCuo', 'tipo' => 'cMondT', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCuotas', 'contenedor' => 'sequence', 'linea' => 310, 'campoMT' => 'E653', 'esGrupo' => false],
    ],
    'dDMoneCuo' => [
      ['nombre' => 'dDMoneCuo', 'nombreOriginal' => 'dDMoneCuo', 'tipo' => 'tdDMoneTiPag', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCuotas', 'contenedor' => 'sequence', 'linea' => 311, 'campoMT' => 'E654', 'esGrupo' => false],
    ],
    'dMonCuota' => [
      ['nombre' => 'dMonCuota', 'nombreOriginal' => 'dMonCuota', 'tipo' => 'tMontoBase4', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCuotas', 'contenedor' => 'sequence', 'linea' => 312, 'campoMT' => 'E651', 'esGrupo' => false],
    ],
    'dVencCuo' => [
      ['nombre' => 'dVencCuo', 'nombreOriginal' => 'dVencCuo', 'tipo' => 'tFecAAAAMMDDguion', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCuotas', 'contenedor' => 'sequence', 'linea' => 314, 'campoMT' => 'E652', 'esGrupo' => false],
    ],
    'dModCont' => [
      ['nombre' => 'dModCont', 'nombreOriginal' => 'dModCont', 'tipo' => 'tdModCont', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCompPub', 'contenedor' => 'sequence', 'linea' => 326, 'campoMT' => 'E021', 'esGrupo' => false],
    ],
    'dEntCont' => [
      ['nombre' => 'dEntCont', 'nombreOriginal' => 'dEntCont ', 'tipo' => 'tdEntCont', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCompPub', 'contenedor' => 'sequence', 'linea' => 327, 'campoMT' => 'E022', 'esGrupo' => false],
    ],
    'dAnoCont' => [
      ['nombre' => 'dAnoCont', 'nombreOriginal' => 'dAnoCont', 'tipo' => 'tdAnoCont', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCompPub', 'contenedor' => 'sequence', 'linea' => 328, 'campoMT' => 'E023', 'esGrupo' => false],
    ],
    'dSecCont' => [
      ['nombre' => 'dSecCont', 'nombreOriginal' => 'dSecCont', 'tipo' => 'tdSecCont', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCompPub', 'contenedor' => 'sequence', 'linea' => 329, 'campoMT' => 'E024', 'esGrupo' => false],
    ],
    'dFeCodCont' => [
      ['nombre' => 'dFeCodCont', 'nombreOriginal' => 'dFeCodCont', 'tipo' => 'tFecAAAAMMDDguion', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCompPub', 'contenedor' => 'sequence', 'linea' => 330, 'campoMT' => 'E025', 'esGrupo' => false],
    ],
    'iIndPres' => [
      ['nombre' => 'iIndPres', 'nombreOriginal' => 'iIndPres', 'tipo' => 'tiIndPres', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFE', 'contenedor' => 'sequence', 'linea' => 342, 'campoMT' => 'E011', 'esGrupo' => false],
    ],
    'dDesIndPres' => [
      ['nombre' => 'dDesIndPres', 'nombreOriginal' => 'dDesIndPres', 'tipo' => 'tdDesIndPres', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFE', 'contenedor' => 'sequence', 'linea' => 343, 'campoMT' => 'E012', 'esGrupo' => false],
    ],
    'dFecEmNR' => [
      ['nombre' => 'dFecEmNR', 'nombreOriginal' => 'dFecEmNR', 'tipo' => 'tFecAAAAMMDDguion', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamFE', 'contenedor' => 'sequence', 'linea' => 345, 'campoMT' => 'E013', 'esGrupo' => false],
    ],
    'gCompPub' => [
      ['nombre' => 'gCompPub', 'nombreOriginal' => 'gCompPub', 'tipo' => 'tgCompPub', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamFE', 'contenedor' => 'sequence', 'linea' => 346, 'campoMT' => 'E020', 'esGrupo' => true],
    ],
    'dPUniProSer' => [
      ['nombre' => 'dPUniProSer', 'nombreOriginal' => 'dPUniProSer', 'tipo' => 'tMontoBase', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgValorItem', 'contenedor' => 'sequence', 'linea' => 363, 'campoMT' => 'E721', 'esGrupo' => false],
    ],
    'dTiCamIt' => [
      ['nombre' => 'dTiCamIt', 'nombreOriginal' => 'dTiCamIt', 'tipo' => 'tTipoCambioBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgValorItem', 'contenedor' => 'sequence', 'linea' => 365, 'campoMT' => 'E725', 'esGrupo' => false],
    ],
    'dTotBruOpeItem' => [
      ['nombre' => 'dTotBruOpeItem', 'nombreOriginal' => 'dTotBruOpeItem', 'tipo' => 'tMontoBase', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgValorItem', 'contenedor' => 'sequence', 'linea' => 366, 'campoMT' => 'E727', 'esGrupo' => false],
    ],
    'gValorRestaItem' => [
      ['nombre' => 'gValorRestaItem', 'nombreOriginal' => 'gValorRestaItem', 'tipo' => 'tgValorRestaItem', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgValorItem', 'contenedor' => 'sequence', 'linea' => 367, 'campoMT' => 'EA001', 'esGrupo' => true],
    ],
    'dDescItem' => [
      ['nombre' => 'dDescItem', 'nombreOriginal' => 'dDescItem', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgValorRestaItem', 'contenedor' => 'sequence', 'linea' => 380, 'campoMT' => 'EA002', 'esGrupo' => false],
    ],
    'dPorcDesIt' => [
      ['nombre' => 'dPorcDesIt', 'nombreOriginal' => 'dPorcDesIt', 'tipo' => 'tPorcDesc8', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgValorRestaItem', 'contenedor' => 'sequence', 'linea' => 382, 'campoMT' => 'EA003', 'esGrupo' => false],
    ],
    'dDescGloItem' => [
      ['nombre' => 'dDescGloItem', 'nombreOriginal' => 'dDescGloItem', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgValorRestaItem', 'contenedor' => 'sequence', 'linea' => 384, 'campoMT' => 'EA004', 'esGrupo' => false],
    ],
    'dAntPreUniIt' => [
      ['nombre' => 'dAntPreUniIt', 'nombreOriginal' => 'dAntPreUniIt', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgValorRestaItem', 'contenedor' => 'sequence', 'linea' => 386, 'campoMT' => 'EA006', 'esGrupo' => false],
    ],
    'dAntGloPreUniIt' => [
      ['nombre' => 'dAntGloPreUniIt', 'nombreOriginal' => 'dAntGloPreUniIt', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgValorRestaItem', 'contenedor' => 'sequence', 'linea' => 388, 'campoMT' => 'EA007', 'esGrupo' => false],
    ],
    'dTotOpeItem' => [
      ['nombre' => 'dTotOpeItem', 'nombreOriginal' => 'dTotOpeItem', 'tipo' => 'tMontoBase', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgValorRestaItem', 'contenedor' => 'sequence', 'linea' => 389, 'campoMT' => 'EA008', 'esGrupo' => false],
    ],
    'dTotOpeGs' => [
      ['nombre' => 'dTotOpeGs', 'nombreOriginal' => 'dTotOpeGs', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgValorRestaItem', 'contenedor' => 'sequence', 'linea' => 391, 'campoMT' => 'EA009', 'esGrupo' => false],
    ],
    'iAfecIVA' => [
      ['nombre' => 'iAfecIVA', 'nombreOriginal' => 'iAfecIVA', 'tipo' => 'tiAfecIVA', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamIVA', 'contenedor' => 'sequence', 'linea' => 403, 'campoMT' => 'E731', 'esGrupo' => false],
    ],
    'dDesAfecIVA' => [
      ['nombre' => 'dDesAfecIVA', 'nombreOriginal' => 'dDesAfecIVA', 'tipo' => 'tdDesAfecIVA', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamIVA', 'contenedor' => 'sequence', 'linea' => 404, 'campoMT' => 'E732', 'esGrupo' => false],
    ],
    'dPropIVA' => [
      ['nombre' => 'dPropIVA', 'nombreOriginal' => 'dPropIVA', 'tipo' => 'tPorcDesc8', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamIVA', 'contenedor' => 'sequence', 'linea' => 405, 'campoMT' => 'E733', 'esGrupo' => false],
    ],
    'dTasaIVA' => [
      ['nombre' => 'dTasaIVA', 'nombreOriginal' => 'dTasaIVA', 'tipo' => 'tdTasaIVA', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamIVA', 'contenedor' => 'sequence', 'linea' => 406, 'campoMT' => 'E734', 'esGrupo' => false],
    ],
    'dBasGravIVA' => [
      ['nombre' => 'dBasGravIVA', 'nombreOriginal' => 'dBasGravIVA', 'tipo' => 'tMontoBase', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamIVA', 'contenedor' => 'sequence', 'linea' => 407, 'campoMT' => 'E735', 'esGrupo' => false],
    ],
    'dLiqIVAItem' => [
      ['nombre' => 'dLiqIVAItem', 'nombreOriginal' => 'dLiqIVAItem', 'tipo' => 'tMontoBase', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamIVA', 'contenedor' => 'sequence', 'linea' => 408, 'campoMT' => 'E736', 'esGrupo' => false],
    ],
    'dBasExe' => [
      ['nombre' => 'dBasExe', 'nombreOriginal' => 'dBasExe', 'tipo' => 'tMontoBase', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamIVA', 'contenedor' => 'sequence', 'linea' => 409, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'cCatISC' => [
      ['nombre' => 'cCatISC', 'nombreOriginal' => 'cCatISC', 'tipo' => 'tcCatISC', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamISC', 'contenedor' => 'sequence', 'linea' => 421, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesCatISC' => [
      ['nombre' => 'dDesCatISC', 'nombreOriginal' => 'dDesCatISC', 'tipo' => 'tdDesCatISC', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamISC', 'contenedor' => 'sequence', 'linea' => 422, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'cTasaISC' => [
      ['nombre' => 'cTasaISC', 'nombreOriginal' => 'cTasaISC', 'tipo' => 'tcTasaISC', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamISC', 'contenedor' => 'sequence', 'linea' => 423, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dBaseGravISC' => [
      ['nombre' => 'dBaseGravISC', 'nombreOriginal' => 'dBaseGravISC', 'tipo' => 'tMontoBase', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamISC', 'contenedor' => 'sequence', 'linea' => 424, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dLiqISCItem' => [
      ['nombre' => 'dLiqISCItem', 'nombreOriginal' => 'dLiqISCItem', 'tipo' => 'tMontoBase', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamISC', 'contenedor' => 'sequence', 'linea' => 425, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNumLote' => [
      ['nombre' => 'dNumLote', 'nombreOriginal' => 'dNumLote', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgRasMerc', 'contenedor' => 'sequence', 'linea' => 437, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dVencMerc' => [
      ['nombre' => 'dVencMerc', 'nombreOriginal' => 'dVencMerc', 'tipo' => 'tFecAAAAMMDDguion', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgRasMerc', 'contenedor' => 'sequence', 'linea' => 446, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNSerie' => [
      ['nombre' => 'dNSerie', 'nombreOriginal' => 'dNSerie', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgRasMerc', 'contenedor' => 'sequence', 'linea' => 447, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNumPedi' => [
      ['nombre' => 'dNumPedi', 'nombreOriginal' => 'dNumPedi', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgRasMerc', 'contenedor' => 'sequence', 'linea' => 460, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNumSegui' => [
      ['nombre' => 'dNumSegui', 'nombreOriginal' => 'dNumSegui', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgRasMerc', 'contenedor' => 'sequence', 'linea' => 473, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNumReg' => [
      ['nombre' => 'dNumReg', 'nombreOriginal' => 'dNumReg', 'tipo' => 'tdCadenaBase20', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgRasMerc', 'contenedor' => 'sequence', 'linea' => 487, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNumRegEntCom' => [
      ['nombre' => 'dNumRegEntCom', 'nombreOriginal' => 'dNumRegEntCom', 'tipo' => 'tdCadenaBase20', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgRasMerc', 'contenedor' => 'sequence', 'linea' => 489, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNomPro' => [
      ['nombre' => 'dNomPro', 'nombreOriginal' => 'dNomPro', 'tipo' => 'tdNomPro', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgRasMerc', 'contenedor' => 'sequence', 'linea' => 491, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'iTipOpVN' => [
      ['nombre' => 'iTipOpVN', 'nombreOriginal' => 'iTipOpVN', 'tipo' => 'tiTipOpVN', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehNuevo', 'contenedor' => 'sequence', 'linea' => 509, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesTipOpVN' => [
      ['nombre' => 'dDesTipOpVN', 'nombreOriginal' => 'dDesTipOpVN', 'tipo' => 'tdDesTipOpVN', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehNuevo', 'contenedor' => 'sequence', 'linea' => 511, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dChasis' => [
      ['nombre' => 'dChasis', 'nombreOriginal' => 'dChasis', 'tipo' => 'tdChasis', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehNuevo', 'contenedor' => 'sequence', 'linea' => 512, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dColor' => [
      ['nombre' => 'dColor', 'nombreOriginal' => 'dColor', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehNuevo', 'contenedor' => 'sequence', 'linea' => 513, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dPotencia' => [
      ['nombre' => 'dPotencia', 'nombreOriginal' => 'dPotencia', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehNuevo', 'contenedor' => 'sequence', 'linea' => 521, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dCapMot' => [
      ['nombre' => 'dCapMot', 'nombreOriginal' => 'dCapMot', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehNuevo', 'contenedor' => 'sequence', 'linea' => 533, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dPNet' => [
      ['nombre' => 'dPNet', 'nombreOriginal' => 'dPNet', 'tipo' => 'tMontoBase6', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehNuevo', 'contenedor' => 'sequence', 'linea' => 545, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dPBruto' => [
      ['nombre' => 'dPBruto', 'nombreOriginal' => 'dPBruto', 'tipo' => 'tMontoBase6', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehNuevo', 'contenedor' => 'sequence', 'linea' => 547, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'iTipCom' => [
      ['nombre' => 'iTipCom', 'nombreOriginal' => 'iTipCom', 'tipo' => 'tiTipCom', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehNuevo', 'contenedor' => 'sequence', 'linea' => 548, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesTipCom' => [
      ['nombre' => 'dDesTipCom', 'nombreOriginal' => 'dDesTipCom', 'tipo' => 'tdDesTipCom', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehNuevo', 'contenedor' => 'sequence', 'linea' => 550, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNroMotor' => [
      ['nombre' => 'dNroMotor', 'nombreOriginal' => 'dNroMotor', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehNuevo', 'contenedor' => 'sequence', 'linea' => 551, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dCapTracc' => [
      ['nombre' => 'dCapTracc', 'nombreOriginal' => 'dCapTracc', 'tipo' => 'tMontoBase6', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehNuevo', 'contenedor' => 'sequence', 'linea' => 565, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dAnoFab' => [
      ['nombre' => 'dAnoFab', 'nombreOriginal' => 'dAnoFab', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehNuevo', 'contenedor' => 'sequence', 'linea' => 566, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'cTipVeh' => [
      ['nombre' => 'cTipVeh', 'nombreOriginal' => 'cTipVeh', 'tipo' => 'tcTipVeh', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehNuevo', 'contenedor' => 'sequence', 'linea' => 580, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dCapac' => [
      ['nombre' => 'dCapac', 'nombreOriginal' => 'dCapac', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehNuevo', 'contenedor' => 'sequence', 'linea' => 583, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dCilin' => [
      ['nombre' => 'dCilin', 'nombreOriginal' => 'dCilin', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehNuevo', 'contenedor' => 'sequence', 'linea' => 595, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNroMed' => [
      ['nombre' => 'dNroMed', 'nombreOriginal' => 'dNroMed', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupEner', 'contenedor' => 'sequence', 'linea' => 618, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dActiv' => [
      ['nombre' => 'dActiv', 'nombreOriginal' => 'dActiv', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupEner', 'contenedor' => 'sequence', 'linea' => 631, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dCateg' => [
      ['nombre' => 'dCateg', 'nombreOriginal' => 'dCateg', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupEner', 'contenedor' => 'sequence', 'linea' => 643, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dLecAnt' => [
      ['nombre' => 'dLecAnt', 'nombreOriginal' => 'dLecAnt', 'tipo' => 'tLectura', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupEner', 'contenedor' => 'sequence', 'linea' => 655, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dLecAct' => [
      ['nombre' => 'dLecAct', 'nombreOriginal' => 'dLecAct', 'tipo' => 'tLectura', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupEner', 'contenedor' => 'sequence', 'linea' => 656, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dConKwh' => [
      ['nombre' => 'dConKwh', 'nombreOriginal' => 'dConKwh', 'tipo' => 'tLectura', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupEner', 'contenedor' => 'sequence', 'linea' => 657, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNomCaj' => [
      ['nombre' => 'dNomCaj', 'nombreOriginal' => 'dNomCaj', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupSup', 'contenedor' => 'sequence', 'linea' => 670, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dEfectivo' => [
      ['nombre' => 'dEfectivo', 'nombreOriginal' => 'dEfectivo', 'tipo' => 'tMontoBase4', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupSup', 'contenedor' => 'sequence', 'linea' => 684, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dVuelto' => [
      ['nombre' => 'dVuelto', 'nombreOriginal' => 'dVuelto', 'tipo' => 'tMontoBase6', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupSup', 'contenedor' => 'sequence', 'linea' => 686, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDonac' => [
      ['nombre' => 'dDonac', 'nombreOriginal' => 'dDonac', 'tipo' => 'tMontoBase6', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupSup', 'contenedor' => 'sequence', 'linea' => 687, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesDonac' => [
      ['nombre' => 'dDesDonac', 'nombreOriginal' => 'dDesDonac', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupSup', 'contenedor' => 'sequence', 'linea' => 688, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dCodEmpSeg' => [
      ['nombre' => 'dCodEmpSeg', 'nombreOriginal' => 'dCodEmpSeg', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupSeg', 'contenedor' => 'sequence', 'linea' => 713, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'gGrupPolSeg' => [
      ['nombre' => 'gGrupPolSeg', 'nombreOriginal' => 'gGrupPolSeg', 'tipo' => 'tgGrupPolSeg', 'minOccurs' => 1, 'maxOccurs' => 999, 'padre' => 'tgGrupSeg', 'contenedor' => 'sequence', 'linea' => 728, 'campoMT' => NULL, 'esGrupo' => true],
    ],
    'dPoliza' => [
      ['nombre' => 'dPoliza', 'nombreOriginal' => 'dPoliza', 'tipo' => 'tdPoliza', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgGrupPolSeg', 'contenedor' => 'sequence', 'linea' => 741, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dUnidVig' => [
      ['nombre' => 'dUnidVig', 'nombreOriginal' => 'dUnidVig', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgGrupPolSeg', 'contenedor' => 'sequence', 'linea' => 742, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dVigencia' => [
      ['nombre' => 'dVigencia', 'nombreOriginal' => 'dVigencia', 'tipo' => 'tdVigPol', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgGrupPolSeg', 'contenedor' => 'sequence', 'linea' => 756, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNumPoliza' => [
      ['nombre' => 'dNumPoliza', 'nombreOriginal' => 'dNumPoliza', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgGrupPolSeg', 'contenedor' => 'sequence', 'linea' => 757, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dFecIniVig' => [
      ['nombre' => 'dFecIniVig', 'nombreOriginal' => 'dFecIniVig', 'tipo' => 'fecHhmmss', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupPolSeg', 'contenedor' => 'sequence', 'linea' => 771, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dFecFinVig' => [
      ['nombre' => 'dFecFinVig', 'nombreOriginal' => 'dFecFinVig', 'tipo' => 'fecHhmmss', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupPolSeg', 'contenedor' => 'sequence', 'linea' => 773, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dCodInt' => [
      ['nombre' => 'dCodInt', 'nombreOriginal' => 'dCodInt', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupPolSeg', 'contenedor' => 'sequence', 'linea' => 775, 'campoMT' => 'E701', 'esGrupo' => false],
      ['nombre' => 'dCodInt', 'nombreOriginal' => 'dCodInt', 'tipo' => 'tdCodInt', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 870, 'campoMT' => 'E701', 'esGrupo' => false],
    ],
    'gGrupEner' => [
      ['nombre' => 'gGrupEner', 'nombreOriginal' => 'gGrupEner', 'tipo' => 'tgGrupEner', 'minOccurs' => 0, 'maxOccurs' => 9, 'padre' => 'tgCamEsp', 'contenedor' => 'sequence', 'linea' => 803, 'campoMT' => NULL, 'esGrupo' => true],
    ],
    'gGrupSeg' => [
      ['nombre' => 'gGrupSeg', 'nombreOriginal' => 'gGrupSeg', 'tipo' => 'tgGrupSeg', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamEsp', 'contenedor' => 'sequence', 'linea' => 804, 'campoMT' => NULL, 'esGrupo' => true],
    ],
    'gGrupSup' => [
      ['nombre' => 'gGrupSup', 'nombreOriginal' => 'gGrupSup', 'tipo' => 'tgGrupSup', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamEsp', 'contenedor' => 'sequence', 'linea' => 805, 'campoMT' => NULL, 'esGrupo' => true],
    ],
    'gGrupAdi' => [
      ['nombre' => 'gGrupAdi', 'nombreOriginal' => 'gGrupAdi', 'tipo' => 'tgGrupAdi', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamEsp', 'contenedor' => 'sequence', 'linea' => 806, 'campoMT' => NULL, 'esGrupo' => true],
    ],
    'dCiclo' => [
      ['nombre' => 'dCiclo', 'nombreOriginal' => 'dCiclo', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupAdi', 'contenedor' => 'sequence', 'linea' => 818, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dFecIniC' => [
      ['nombre' => 'dFecIniC', 'nombreOriginal' => 'dFecIniC', 'tipo' => 'tdFeIniS', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupAdi', 'contenedor' => 'sequence', 'linea' => 826, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dFecFinC' => [
      ['nombre' => 'dFecFinC', 'nombreOriginal' => 'dFecFinC', 'tipo' => 'tFecAAAAMMDDguion', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupAdi', 'contenedor' => 'sequence', 'linea' => 828, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dVencPag' => [
      ['nombre' => 'dVencPag', 'nombreOriginal' => 'dVencPag', 'tipo' => 'tFecAAAAMMDDguion', 'minOccurs' => 0, 'maxOccurs' => 3, 'padre' => 'tgGrupAdi', 'contenedor' => 'sequence', 'linea' => 830, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dContrato' => [
      ['nombre' => 'dContrato', 'nombreOriginal' => 'dContrato', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupAdi', 'contenedor' => 'sequence', 'linea' => 831, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dSalAnt' => [
      ['nombre' => 'dSalAnt', 'nombreOriginal' => 'dSalAnt', 'tipo' => 'tMontoBase4', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupAdi', 'contenedor' => 'sequence', 'linea' => 845, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dCodConDncp' => [
      ['nombre' => 'dCodConDncp', 'nombreOriginal' => 'dCodConDncp', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgGrupAdi', 'contenedor' => 'sequence', 'linea' => 846, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dParAranc' => [
      ['nombre' => 'dParAranc', 'nombreOriginal' => 'dParAranc', 'tipo' => 'tdParAranc', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 872, 'campoMT' => 'E702', 'esGrupo' => false],
    ],
    'dNCM' => [
      ['nombre' => 'dNCM', 'nombreOriginal' => 'dNCM', 'tipo' => 'tdNCM', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 873, 'campoMT' => 'E703', 'esGrupo' => false],
    ],
    'dDncpG' => [
      ['nombre' => 'dDncpG', 'nombreOriginal' => 'dDncpG', 'tipo' => 'tdDncpG', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 874, 'campoMT' => 'E704', 'esGrupo' => false],
    ],
    'dDncpE' => [
      ['nombre' => 'dDncpE', 'nombreOriginal' => 'dDncpE', 'tipo' => 'tdDncpE', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 875, 'campoMT' => 'E705', 'esGrupo' => false],
    ],
    'dGtin' => [
      ['nombre' => 'dGtin', 'nombreOriginal' => 'dGtin', 'tipo' => 'tdGtin', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 876, 'campoMT' => 'E706', 'esGrupo' => false],
    ],
    'dGtinPq' => [
      ['nombre' => 'dGtinPq', 'nombreOriginal' => 'dGtinPq', 'tipo' => 'tdGtin', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 877, 'campoMT' => 'E707', 'esGrupo' => false],
    ],
    'dDesProSer' => [
      ['nombre' => 'dDesProSer', 'nombreOriginal' => 'dDesProSer', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 878, 'campoMT' => 'E708', 'esGrupo' => false],
    ],
    'cUniMed' => [
      ['nombre' => 'cUniMed', 'nombreOriginal' => 'cUniMed', 'tipo' => 'tcUniMed', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 886, 'campoMT' => 'E709', 'esGrupo' => false],
    ],
    'dDesUniMed' => [
      ['nombre' => 'dDesUniMed', 'nombreOriginal' => 'dDesUniMed', 'tipo' => 'tdDesUniMed', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 887, 'campoMT' => 'E710', 'esGrupo' => false],
    ],
    'dCantProSer' => [
      ['nombre' => 'dCantProSer', 'nombreOriginal' => 'dCantProSer', 'tipo' => 'tdCantProSer', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 888, 'campoMT' => 'E711', 'esGrupo' => false],
    ],
    'cPaisOrig' => [
      ['nombre' => 'cPaisOrig', 'nombreOriginal' => 'cPaisOrig', 'tipo' => 'paisType', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 889, 'campoMT' => 'E712', 'esGrupo' => false],
    ],
    'dDesPaisOrig' => [
      ['nombre' => 'dDesPaisOrig', 'nombreOriginal' => 'dDesPaisOrig', 'tipo' => 'tDesPais', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 891, 'campoMT' => 'E713', 'esGrupo' => false],
    ],
    'dInfItem' => [
      ['nombre' => 'dInfItem', 'nombreOriginal' => 'dInfItem', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 892, 'campoMT' => 'E714', 'esGrupo' => false],
    ],
    'cRelMerc' => [
      ['nombre' => 'cRelMerc', 'nombreOriginal' => 'cRelMerc', 'tipo' => 'tcRelMerc', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 900, 'campoMT' => 'E715', 'esGrupo' => false],
    ],
    'dDesRelMerc' => [
      ['nombre' => 'dDesRelMerc', 'nombreOriginal' => 'dDesRelMerc', 'tipo' => 'tdDesRelMerc', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 902, 'campoMT' => 'E716', 'esGrupo' => false],
    ],
    'dCanQuiMer' => [
      ['nombre' => 'dCanQuiMer', 'nombreOriginal' => 'dCanQuiMer', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 903, 'campoMT' => 'E717', 'esGrupo' => false],
    ],
    'dPorQuiMer' => [
      ['nombre' => 'dPorQuiMer', 'nombreOriginal' => 'dPorQuiMer', 'tipo' => 'tPorcDesc8', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 914, 'campoMT' => 'E718', 'esGrupo' => false],
    ],
    'dCDCAnticipo' => [
      ['nombre' => 'dCDCAnticipo', 'nombreOriginal' => 'dCDCAnticipo', 'tipo' => 'tCDC', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 915, 'campoMT' => 'E719', 'esGrupo' => false],
    ],
    'gValorItem' => [
      ['nombre' => 'gValorItem', 'nombreOriginal' => 'gValorItem', 'tipo' => 'tgValorItem', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 918, 'campoMT' => 'E720', 'esGrupo' => true],
    ],
    'gCamIVA' => [
      ['nombre' => 'gCamIVA', 'nombreOriginal' => 'gCamIVA', 'tipo' => 'tgCamIVA', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 919, 'campoMT' => 'E730', 'esGrupo' => true],
    ],
    'gRasMerc' => [
      ['nombre' => 'gRasMerc', 'nombreOriginal' => 'gRasMerc', 'tipo' => 'tgRasMerc', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 921, 'campoMT' => NULL, 'esGrupo' => true],
    ],
    'gVehNuevo' => [
      ['nombre' => 'gVehNuevo', 'nombreOriginal' => 'gVehNuevo', 'tipo' => 'tgVehNuevo', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamItem', 'contenedor' => 'sequence', 'linea' => 923, 'campoMT' => NULL, 'esGrupo' => true],
    ],
    'gCamFE' => [
      ['nombre' => 'gCamFE', 'nombreOriginal' => 'gCamFE', 'tipo' => 'tgCamFE', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDtipDE', 'contenedor' => 'sequence', 'linea' => 934, 'campoMT' => 'E010', 'esGrupo' => true],
    ],
    'gCamAE' => [
      ['nombre' => 'gCamAE', 'nombreOriginal' => 'gCamAE', 'tipo' => 'tgCamAE', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDtipDE', 'contenedor' => 'sequence', 'linea' => 937, 'campoMT' => 'E300', 'esGrupo' => true],
    ],
    'gCamNCDE' => [
      ['nombre' => 'gCamNCDE', 'nombreOriginal' => 'gCamNCDE', 'tipo' => 'tgCamNCDE', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDtipDE', 'contenedor' => 'sequence', 'linea' => 938, 'campoMT' => 'E400', 'esGrupo' => true],
    ],
    'gCamNRE' => [
      ['nombre' => 'gCamNRE', 'nombreOriginal' => 'gCamNRE', 'tipo' => 'tgCamNRE', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDtipDE', 'contenedor' => 'sequence', 'linea' => 939, 'campoMT' => 'E500', 'esGrupo' => true],
    ],
    'gCamCond' => [
      ['nombre' => 'gCamCond', 'nombreOriginal' => 'gCamCond', 'tipo' => 'tgCamCond', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDtipDE', 'contenedor' => 'sequence', 'linea' => 940, 'campoMT' => 'E600', 'esGrupo' => true],
    ],
    'gCamItem' => [
      ['nombre' => 'gCamItem', 'nombreOriginal' => 'gCamItem', 'tipo' => 'tgCamItem', 'minOccurs' => 1, 'maxOccurs' => 999, 'padre' => 'tgDtipDE', 'contenedor' => 'sequence', 'linea' => 942, 'campoMT' => 'E700', 'esGrupo' => true],
    ],
    'gCamEsp' => [
      ['nombre' => 'gCamEsp', 'nombreOriginal' => 'gCamEsp', 'tipo' => 'tgCamEsp', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDtipDE', 'contenedor' => 'sequence', 'linea' => 943, 'campoMT' => NULL, 'esGrupo' => true],
    ],
    'gTransp' => [
      ['nombre' => 'gTransp', 'nombreOriginal' => 'gTransp', 'tipo' => 'tgTransp', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgDtipDE', 'contenedor' => 'sequence', 'linea' => 944, 'campoMT' => NULL, 'esGrupo' => true],
    ],
    'gCamRDE' => [
      ['nombre' => 'gCamRDE', 'nombreOriginal' => 'gCamRDE', 'tipo' => 'tgCamRDE', 'minOccurs' => 0, 'maxOccurs' => 999, 'padre' => 'tgDtipDE', 'contenedor' => 'sequence', 'linea' => 945, 'campoMT' => NULL, 'esGrupo' => true],
    ],
    'iNatTrans' => [
      ['nombre' => 'iNatTrans', 'nombreOriginal' => 'iNatTrans', 'tipo' => 'tiNatRec', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamTrans', 'contenedor' => 'sequence', 'linea' => 958, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNomTrans' => [
      ['nombre' => 'dNomTrans', 'nombreOriginal' => 'dNomTrans', 'tipo' => 'dNomRazSocial', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamTrans', 'contenedor' => 'sequence', 'linea' => 959, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dRucTrans' => [
      ['nombre' => 'dRucTrans', 'nombreOriginal' => 'dRucTrans', 'tipo' => 'tRuc', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamTrans', 'contenedor' => 'sequence', 'linea' => 960, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDVTrans' => [
      ['nombre' => 'dDVTrans', 'nombreOriginal' => 'dDVTrans', 'tipo' => 'tDVer', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamTrans', 'contenedor' => 'sequence', 'linea' => 961, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'iTipIDTrans' => [
      ['nombre' => 'iTipIDTrans', 'nombreOriginal' => 'iTipIDTrans', 'tipo' => 'tiTipDoc', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamTrans', 'contenedor' => 'sequence', 'linea' => 963, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDTipIDTrans' => [
      ['nombre' => 'dDTipIDTrans', 'nombreOriginal' => 'dDTipIDTrans', 'tipo' => 'tdDtipDoc', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamTrans', 'contenedor' => 'sequence', 'linea' => 965, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNumIDTrans' => [
      ['nombre' => 'dNumIDTrans', 'nombreOriginal' => 'dNumIDTrans', 'tipo' => 'tdNumDocId', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamTrans', 'contenedor' => 'sequence', 'linea' => 967, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'cNacTrans' => [
      ['nombre' => 'cNacTrans', 'nombreOriginal' => 'cNacTrans', 'tipo' => 'paisType', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamTrans', 'contenedor' => 'sequence', 'linea' => 968, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesNacTrans' => [
      ['nombre' => 'dDesNacTrans', 'nombreOriginal' => 'dDesNacTrans', 'tipo' => 'tDesPais', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamTrans', 'contenedor' => 'sequence', 'linea' => 970, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNumIDChof' => [
      ['nombre' => 'dNumIDChof', 'nombreOriginal' => 'dNumIDChof', 'tipo' => 'tdNumDocId', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamTrans', 'contenedor' => 'sequence', 'linea' => 971, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNomChof' => [
      ['nombre' => 'dNomChof', 'nombreOriginal' => 'dNomChof', 'tipo' => 'dNomRazSocial', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamTrans', 'contenedor' => 'sequence', 'linea' => 972, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDomFisc' => [
      ['nombre' => 'dDomFisc', 'nombreOriginal' => 'dDomFisc', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamTrans', 'contenedor' => 'sequence', 'linea' => 973, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDirChof' => [
      ['nombre' => 'dDirChof', 'nombreOriginal' => 'dDirChof', 'tipo' => 'tdDirec', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamTrans', 'contenedor' => 'sequence', 'linea' => 986, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNombAg' => [
      ['nombre' => 'dNombAg', 'nombreOriginal' => 'dNombAg', 'tipo' => 'dNomRazSocial', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamTrans', 'contenedor' => 'sequence', 'linea' => 988, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dRucAg' => [
      ['nombre' => 'dRucAg', 'nombreOriginal' => 'dRucAg', 'tipo' => 'tRuc', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamTrans', 'contenedor' => 'sequence', 'linea' => 989, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDVAg' => [
      ['nombre' => 'dDVAg', 'nombreOriginal' => 'dDVAg', 'tipo' => 'tDVer', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamTrans', 'contenedor' => 'sequence', 'linea' => 990, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDirAge' => [
      ['nombre' => 'dDirAge', 'nombreOriginal' => 'dDirAge', 'tipo' => 'tdDirec', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamTrans', 'contenedor' => 'sequence', 'linea' => 991, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'iMotEmi' => [
      ['nombre' => 'iMotEmi', 'nombreOriginal' => 'iMotEmi', 'tipo' => 'tiMotEmi', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamNCDE', 'contenedor' => 'sequence', 'linea' => 1003, 'campoMT' => 'E401', 'esGrupo' => false],
    ],
    'dDesMotEmi' => [
      ['nombre' => 'dDesMotEmi', 'nombreOriginal' => 'dDesMotEmi', 'tipo' => 'tdDesMotEmi', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamNCDE', 'contenedor' => 'sequence', 'linea' => 1004, 'campoMT' => 'E402', 'esGrupo' => false],
    ],
    'iMotEmiNR' => [
      ['nombre' => 'iMotEmiNR', 'nombreOriginal' => 'iMotEmiNR', 'tipo' => 'tiMotivTras', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamNRE', 'contenedor' => 'sequence', 'linea' => 1016, 'campoMT' => 'E501', 'esGrupo' => false],
    ],
    'dDesMotEmiNR' => [
      ['nombre' => 'dDesMotEmiNR', 'nombreOriginal' => 'dDesMotEmiNR', 'tipo' => 'tdDMotivTras', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamNRE', 'contenedor' => 'sequence', 'linea' => 1017, 'campoMT' => 'E502', 'esGrupo' => false],
    ],
    'iRespEmiNR' => [
      ['nombre' => 'iRespEmiNR', 'nombreOriginal' => 'iRespEmiNR', 'tipo' => 'tiRespEmiNR', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamNRE', 'contenedor' => 'sequence', 'linea' => 1018, 'campoMT' => 'E503', 'esGrupo' => false],
    ],
    'dDesRespEmiNR' => [
      ['nombre' => 'dDesRespEmiNR', 'nombreOriginal' => 'dDesRespEmiNR', 'tipo' => 'tdDesRespEmiNR', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamNRE', 'contenedor' => 'sequence', 'linea' => 1019, 'campoMT' => 'E504', 'esGrupo' => false],
    ],
    'dKmR' => [
      ['nombre' => 'dKmR', 'nombreOriginal' => 'dKmR', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamNRE', 'contenedor' => 'sequence', 'linea' => 1020, 'campoMT' => 'E505', 'esGrupo' => false],
    ],
    'dFecEm' => [
      ['nombre' => 'dFecEm', 'nombreOriginal' => 'dFecEm', 'tipo' => 'tFecAAAAMMDDguion', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamNRE', 'contenedor' => 'sequence', 'linea' => 1034, 'campoMT' => 'E506', 'esGrupo' => false],
    ],
    'cPreFle' => [
      ['nombre' => 'cPreFle', 'nombreOriginal' => 'cPreFle', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamNRE', 'contenedor' => 'sequence', 'linea' => 1037, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'iTipTrans' => [
      ['nombre' => 'iTipTrans', 'nombreOriginal' => 'iTipTrans', 'tipo' => 'tiTTrans', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTransp', 'contenedor' => 'sequence', 'linea' => 1050, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesTipTrans' => [
      ['nombre' => 'dDesTipTrans', 'nombreOriginal' => 'dDesTipTrans', 'tipo' => 'tdDesTTrans', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTransp', 'contenedor' => 'sequence', 'linea' => 1052, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'iModTrans' => [
      ['nombre' => 'iModTrans', 'nombreOriginal' => 'iModTrans', 'tipo' => 'tiModTrans', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgTransp', 'contenedor' => 'sequence', 'linea' => 1053, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesModTrans' => [
      ['nombre' => 'dDesModTrans', 'nombreOriginal' => 'dDesModTrans', 'tipo' => 'tdDesModTrans', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgTransp', 'contenedor' => 'sequence', 'linea' => 1054, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'iRespFlete' => [
      ['nombre' => 'iRespFlete', 'nombreOriginal' => 'iRespFlete', 'tipo' => 'tiRespFlete', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgTransp', 'contenedor' => 'sequence', 'linea' => 1055, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'cCondNeg' => [
      ['nombre' => 'cCondNeg', 'nombreOriginal' => 'cCondNeg', 'tipo' => 'tcCondNeg', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTransp', 'contenedor' => 'sequence', 'linea' => 1056, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNuManif' => [
      ['nombre' => 'dNuManif', 'nombreOriginal' => 'dNuManif', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTransp', 'contenedor' => 'sequence', 'linea' => 1057, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNuDespImp' => [
      ['nombre' => 'dNuDespImp', 'nombreOriginal' => 'dNuDespImp', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTransp', 'contenedor' => 'sequence', 'linea' => 1071, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dIniTras' => [
      ['nombre' => 'dIniTras', 'nombreOriginal' => 'dIniTras', 'tipo' => 'tdFeIniS', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTransp', 'contenedor' => 'sequence', 'linea' => 1083, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dFinTras' => [
      ['nombre' => 'dFinTras', 'nombreOriginal' => 'dFinTras', 'tipo' => 'tFecAAAAMMDDguion', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTransp', 'contenedor' => 'sequence', 'linea' => 1085, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'cPaisDest' => [
      ['nombre' => 'cPaisDest', 'nombreOriginal' => 'cPaisDest', 'tipo' => 'paisType', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTransp', 'contenedor' => 'sequence', 'linea' => 1086, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesPaisDest' => [
      ['nombre' => 'dDesPaisDest', 'nombreOriginal' => 'dDesPaisDest', 'tipo' => 'tDesPais', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTransp', 'contenedor' => 'sequence', 'linea' => 1088, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'gCamSal' => [
      ['nombre' => 'gCamSal', 'nombreOriginal' => 'gCamSal', 'tipo' => 'tgCamSal', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTransp', 'contenedor' => 'sequence', 'linea' => 1089, 'campoMT' => NULL, 'esGrupo' => true],
    ],
    'gCamEnt' => [
      ['nombre' => 'gCamEnt', 'nombreOriginal' => 'gCamEnt', 'tipo' => 'tgCamEnt', 'minOccurs' => 0, 'maxOccurs' => 99, 'padre' => 'tgTransp', 'contenedor' => 'sequence', 'linea' => 1091, 'campoMT' => NULL, 'esGrupo' => true],
    ],
    'gVehTras' => [
      ['nombre' => 'gVehTras', 'nombreOriginal' => 'gVehTras', 'tipo' => 'tgVehTras', 'minOccurs' => 0, 'maxOccurs' => 4, 'padre' => 'tgTransp', 'contenedor' => 'sequence', 'linea' => 1093, 'campoMT' => NULL, 'esGrupo' => true],
    ],
    'gCamTrans' => [
      ['nombre' => 'gCamTrans', 'nombreOriginal' => 'gCamTrans', 'tipo' => 'tgCamTrans', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTransp', 'contenedor' => 'sequence', 'linea' => 1095, 'campoMT' => NULL, 'esGrupo' => true],
    ],
    'dTiVehTras' => [
      ['nombre' => 'dTiVehTras', 'nombreOriginal' => 'dTiVehTras', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgVehTras', 'contenedor' => 'sequence', 'linea' => 1108, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dMarVeh' => [
      ['nombre' => 'dMarVeh', 'nombreOriginal' => 'dMarVeh', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgVehTras', 'contenedor' => 'sequence', 'linea' => 1122, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dTipIdenVeh' => [
      ['nombre' => 'dTipIdenVeh', 'nombreOriginal' => 'dTipIdenVeh', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgVehTras', 'contenedor' => 'sequence', 'linea' => 1135, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNroIDVeh' => [
      ['nombre' => 'dNroIDVeh', 'nombreOriginal' => 'dNroIDVeh', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehTras', 'contenedor' => 'sequence', 'linea' => 1148, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dAdicVeh' => [
      ['nombre' => 'dAdicVeh', 'nombreOriginal' => 'dAdicVeh', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehTras', 'contenedor' => 'sequence', 'linea' => 1161, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNroMatVeh' => [
      ['nombre' => 'dNroMatVeh', 'nombreOriginal' => 'dNroMatVeh', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehTras', 'contenedor' => 'sequence', 'linea' => 1174, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNroVuelo' => [
      ['nombre' => 'dNroVuelo', 'nombreOriginal' => 'dNroVuelo', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgVehTras', 'contenedor' => 'sequence', 'linea' => 1186, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDirLocEnt' => [
      ['nombre' => 'dDirLocEnt', 'nombreOriginal' => 'dDirLocEnt', 'tipo' => 'tdDirec', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamEnt', 'contenedor' => 'sequence', 'linea' => 1209, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNumCasEnt' => [
      ['nombre' => 'dNumCasEnt', 'nombreOriginal' => 'dNumCasEnt', 'tipo' => 'tdNumCas', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamEnt', 'contenedor' => 'sequence', 'linea' => 1210, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dComp1Ent' => [
      ['nombre' => 'dComp1Ent', 'nombreOriginal' => 'dComp1Ent', 'tipo' => 'tdDirec', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamEnt', 'contenedor' => 'sequence', 'linea' => 1211, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dComp2Ent' => [
      ['nombre' => 'dComp2Ent', 'nombreOriginal' => 'dComp2Ent', 'tipo' => 'tdDirec', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamEnt', 'contenedor' => 'sequence', 'linea' => 1212, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'cDepEnt' => [
      ['nombre' => 'cDepEnt', 'nombreOriginal' => 'cDepEnt', 'tipo' => 'tDepartamentos', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamEnt', 'contenedor' => 'sequence', 'linea' => 1213, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesDepEnt' => [
      ['nombre' => 'dDesDepEnt', 'nombreOriginal' => 'dDesDepEnt', 'tipo' => 'tDesDepartamento', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamEnt', 'contenedor' => 'sequence', 'linea' => 1214, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'cDisEnt' => [
      ['nombre' => 'cDisEnt', 'nombreOriginal' => 'cDisEnt', 'tipo' => 'tDistrito', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamEnt', 'contenedor' => 'sequence', 'linea' => 1215, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesDisEnt' => [
      ['nombre' => 'dDesDisEnt', 'nombreOriginal' => 'dDesDisEnt', 'tipo' => 'tDesDistrito', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamEnt', 'contenedor' => 'sequence', 'linea' => 1217, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'cCiuEnt' => [
      ['nombre' => 'cCiuEnt', 'nombreOriginal' => 'cCiuEnt', 'tipo' => 'tCiudad', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamEnt', 'contenedor' => 'sequence', 'linea' => 1218, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesCiuEnt' => [
      ['nombre' => 'dDesCiuEnt', 'nombreOriginal' => 'dDesCiuEnt', 'tipo' => 'tDesCiudad', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamEnt', 'contenedor' => 'sequence', 'linea' => 1219, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dTelEnt' => [
      ['nombre' => 'dTelEnt', 'nombreOriginal' => 'dTelEnt', 'tipo' => 'tdTel', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamEnt', 'contenedor' => 'sequence', 'linea' => 1220, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDirLocSal' => [
      ['nombre' => 'dDirLocSal', 'nombreOriginal' => 'dDirLocSal', 'tipo' => 'tdDirec', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamSal', 'contenedor' => 'sequence', 'linea' => 1232, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNumCasSal' => [
      ['nombre' => 'dNumCasSal', 'nombreOriginal' => 'dNumCasSal', 'tipo' => 'tdNumCas', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamSal', 'contenedor' => 'sequence', 'linea' => 1233, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dComp1Sal' => [
      ['nombre' => 'dComp1Sal', 'nombreOriginal' => 'dComp1Sal', 'tipo' => 'tdDirec', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamSal', 'contenedor' => 'sequence', 'linea' => 1234, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dComp2Sal' => [
      ['nombre' => 'dComp2Sal', 'nombreOriginal' => 'dComp2Sal', 'tipo' => 'tdDirec', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamSal', 'contenedor' => 'sequence', 'linea' => 1235, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'cDepSal' => [
      ['nombre' => 'cDepSal', 'nombreOriginal' => 'cDepSal', 'tipo' => 'tDepartamentos', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamSal', 'contenedor' => 'sequence', 'linea' => 1236, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesDepSal' => [
      ['nombre' => 'dDesDepSal', 'nombreOriginal' => 'dDesDepSal', 'tipo' => 'tDesDepartamento', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamSal', 'contenedor' => 'sequence', 'linea' => 1237, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'cDisSal' => [
      ['nombre' => 'cDisSal', 'nombreOriginal' => 'cDisSal', 'tipo' => 'tDistrito', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamSal', 'contenedor' => 'sequence', 'linea' => 1238, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesDisSal' => [
      ['nombre' => 'dDesDisSal', 'nombreOriginal' => 'dDesDisSal', 'tipo' => 'tDesDistrito', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamSal', 'contenedor' => 'sequence', 'linea' => 1240, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'cCiuSal' => [
      ['nombre' => 'cCiuSal', 'nombreOriginal' => 'cCiuSal', 'tipo' => 'tCiudad', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamSal', 'contenedor' => 'sequence', 'linea' => 1241, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesCiuSal' => [
      ['nombre' => 'dDesCiuSal', 'nombreOriginal' => 'dDesCiuSal', 'tipo' => 'tDesCiudad', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamSal', 'contenedor' => 'sequence', 'linea' => 1242, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dTelSal' => [
      ['nombre' => 'dTelSal', 'nombreOriginal' => 'dTelSal', 'tipo' => 'tdTel', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamSal', 'contenedor' => 'sequence', 'linea' => 1243, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'iCondOpe' => [
      ['nombre' => 'iCondOpe', 'nombreOriginal' => 'iCondOpe', 'tipo' => 'tiCondOpe', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamCond', 'contenedor' => 'sequence', 'linea' => 1255, 'campoMT' => 'E601', 'esGrupo' => false],
    ],
    'dDCondOpe' => [
      ['nombre' => 'dDCondOpe', 'nombreOriginal' => 'dDCondOpe', 'tipo' => 'tdDCondOpe', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamCond', 'contenedor' => 'sequence', 'linea' => 1256, 'campoMT' => 'E602', 'esGrupo' => false],
    ],
    'gPaConEIni' => [
      ['nombre' => 'gPaConEIni', 'nombreOriginal' => 'gPaConEIni', 'tipo' => 'tgPagCont', 'minOccurs' => 0, 'maxOccurs' => 999, 'padre' => 'tgCamCond', 'contenedor' => 'sequence', 'linea' => 1258, 'campoMT' => 'E605', 'esGrupo' => true],
    ],
    'gPagCred' => [
      ['nombre' => 'gPagCred', 'nombreOriginal' => 'gPagCred', 'tipo' => 'tgPagCred', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamCond', 'contenedor' => 'sequence', 'linea' => 1259, 'campoMT' => 'E640', 'esGrupo' => true],
    ],
    'iTiPago' => [
      ['nombre' => 'iTiPago', 'nombreOriginal' => 'iTiPago', 'tipo' => 'tiTiPago', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgPagCont', 'contenedor' => 'sequence', 'linea' => 1272, 'campoMT' => 'E606', 'esGrupo' => false],
    ],
    'dDesTiPag' => [
      ['nombre' => 'dDesTiPag', 'nombreOriginal' => 'dDesTiPag', 'tipo' => 'tdDesTiPag', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgPagCont', 'contenedor' => 'sequence', 'linea' => 1273, 'campoMT' => 'E607', 'esGrupo' => false],
    ],
    'dMonTiPag' => [
      ['nombre' => 'dMonTiPag', 'nombreOriginal' => 'dMonTiPag', 'tipo' => 'tMontoBase4', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgPagCont', 'contenedor' => 'sequence', 'linea' => 1274, 'campoMT' => 'E608', 'esGrupo' => false],
    ],
    'cMoneTiPag' => [
      ['nombre' => 'cMoneTiPag', 'nombreOriginal' => 'cMoneTiPag', 'tipo' => 'cMondT', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgPagCont', 'contenedor' => 'sequence', 'linea' => 1275, 'campoMT' => 'E609', 'esGrupo' => false],
    ],
    'dDMoneTiPag' => [
      ['nombre' => 'dDMoneTiPag', 'nombreOriginal' => 'dDMoneTiPag', 'tipo' => 'tdDMoneTiPag', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgPagCont', 'contenedor' => 'sequence', 'linea' => 1276, 'campoMT' => 'E610', 'esGrupo' => false],
    ],
    'dTiCamTiPag' => [
      ['nombre' => 'dTiCamTiPag', 'nombreOriginal' => 'dTiCamTiPag', 'tipo' => 'tTipoCambioBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgPagCont', 'contenedor' => 'sequence', 'linea' => 1278, 'campoMT' => 'E611', 'esGrupo' => false],
    ],
    'gPagTarCD' => [
      ['nombre' => 'gPagTarCD', 'nombreOriginal' => 'gPagTarCD', 'tipo' => 'tgPagTarCD', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgPagCont', 'contenedor' => 'sequence', 'linea' => 1280, 'campoMT' => 'E620', 'esGrupo' => true],
    ],
    'gPagCheq' => [
      ['nombre' => 'gPagCheq', 'nombreOriginal' => 'gPagCheq', 'tipo' => 'tgPagCheq', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgPagCont', 'contenedor' => 'sequence', 'linea' => 1282, 'campoMT' => 'E630', 'esGrupo' => true],
    ],
    'iCondCred' => [
      ['nombre' => 'iCondCred', 'nombreOriginal' => 'iCondCred', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgPagCred', 'contenedor' => 'sequence', 'linea' => 1295, 'campoMT' => 'E641', 'esGrupo' => false],
    ],
    'dDCondCred' => [
      ['nombre' => 'dDCondCred', 'nombreOriginal' => 'dDCondCred', 'tipo' => 'tdDCondCred', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgPagCred', 'contenedor' => 'sequence', 'linea' => 1311, 'campoMT' => 'E642', 'esGrupo' => false],
    ],
    'dPlazoCre' => [
      ['nombre' => 'dPlazoCre', 'nombreOriginal' => 'dPlazoCre', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgPagCred', 'contenedor' => 'sequence', 'linea' => 1315, 'campoMT' => 'E643', 'esGrupo' => false],
    ],
    'dCuotas' => [
      ['nombre' => 'dCuotas', 'nombreOriginal' => 'dCuotas', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgPagCred', 'contenedor' => 'sequence', 'linea' => 1330, 'campoMT' => 'E644', 'esGrupo' => false],
    ],
    'dMonEnt' => [
      ['nombre' => 'dMonEnt', 'nombreOriginal' => 'dMonEnt', 'tipo' => 'tMontoBase4', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgPagCred', 'contenedor' => 'sequence', 'linea' => 1344, 'campoMT' => 'E645', 'esGrupo' => false],
    ],
    'gCuotas' => [
      ['nombre' => 'gCuotas', 'nombreOriginal' => 'gCuotas', 'tipo' => 'tgCuotas', 'minOccurs' => 0, 'maxOccurs' => 999, 'padre' => 'tgPagCred', 'contenedor' => 'sequence', 'linea' => 1346, 'campoMT' => 'E650', 'esGrupo' => true],
    ],
    'iNatVen' => [
      ['nombre' => 'iNatVen', 'nombreOriginal' => 'iNatVen', 'tipo' => 'tiNatVen', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1358, 'campoMT' => 'E301', 'esGrupo' => false],
    ],
    'dDesNatVen' => [
      ['nombre' => 'dDesNatVen', 'nombreOriginal' => 'dDesNatVen', 'tipo' => 'tdDesNatVen', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1359, 'campoMT' => 'E302', 'esGrupo' => false],
    ],
    'iTipIDVen' => [
      ['nombre' => 'iTipIDVen', 'nombreOriginal' => 'iTipIDVen', 'tipo' => 'tiTipDoc', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1360, 'campoMT' => 'E304', 'esGrupo' => false],
    ],
    'dDTipIDVen' => [
      ['nombre' => 'dDTipIDVen', 'nombreOriginal' => 'dDTipIDVen', 'tipo' => 'tdDtipDoc', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1361, 'campoMT' => 'E305', 'esGrupo' => false],
    ],
    'dNumIDVen' => [
      ['nombre' => 'dNumIDVen', 'nombreOriginal' => 'dNumIDVen', 'tipo' => 'tdNumDocId', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1362, 'campoMT' => 'E306', 'esGrupo' => false],
    ],
    'dNomVen' => [
      ['nombre' => 'dNomVen', 'nombreOriginal' => 'dNomVen', 'tipo' => 'dNomRazSocial', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1363, 'campoMT' => 'E307', 'esGrupo' => false],
    ],
    'dDirVen' => [
      ['nombre' => 'dDirVen', 'nombreOriginal' => 'dDirVen', 'tipo' => 'tdDirec', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1364, 'campoMT' => 'E308', 'esGrupo' => false],
    ],
    'dNumCasVen' => [
      ['nombre' => 'dNumCasVen', 'nombreOriginal' => 'dNumCasVen', 'tipo' => 'tdNumCas', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1365, 'campoMT' => 'E309', 'esGrupo' => false],
    ],
    'cDepVen' => [
      ['nombre' => 'cDepVen', 'nombreOriginal' => 'cDepVen', 'tipo' => 'tDepartamentos', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1366, 'campoMT' => 'E310', 'esGrupo' => false],
    ],
    'dDesDepVen' => [
      ['nombre' => 'dDesDepVen', 'nombreOriginal' => 'dDesDepVen', 'tipo' => 'tDesDepartamento', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1367, 'campoMT' => 'E311', 'esGrupo' => false],
    ],
    'cDisVen' => [
      ['nombre' => 'cDisVen', 'nombreOriginal' => 'cDisVen', 'tipo' => 'tDistrito', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1368, 'campoMT' => 'E312', 'esGrupo' => false],
    ],
    'dDesDisVen' => [
      ['nombre' => 'dDesDisVen', 'nombreOriginal' => 'dDesDisVen', 'tipo' => 'tDesDistrito', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1370, 'campoMT' => 'E313', 'esGrupo' => false],
    ],
    'cCiuVen' => [
      ['nombre' => 'cCiuVen', 'nombreOriginal' => 'cCiuVen', 'tipo' => 'tCiudad', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1371, 'campoMT' => 'E314', 'esGrupo' => false],
    ],
    'dDesCiuVen' => [
      ['nombre' => 'dDesCiuVen', 'nombreOriginal' => 'dDesCiuVen', 'tipo' => 'tDesCiudad', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1372, 'campoMT' => 'E315', 'esGrupo' => false],
    ],
    'dDirProv' => [
      ['nombre' => 'dDirProv', 'nombreOriginal' => 'dDirProv', 'tipo' => 'tdDirec', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1373, 'campoMT' => 'E316', 'esGrupo' => false],
    ],
    'cDepProv' => [
      ['nombre' => 'cDepProv', 'nombreOriginal' => 'cDepProv', 'tipo' => 'tDepartamentos', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1374, 'campoMT' => 'E317', 'esGrupo' => false],
    ],
    'dDesDepProv' => [
      ['nombre' => 'dDesDepProv', 'nombreOriginal' => 'dDesDepProv', 'tipo' => 'tDesDepartamento', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1375, 'campoMT' => 'E318', 'esGrupo' => false],
    ],
    'cDisProv' => [
      ['nombre' => 'cDisProv', 'nombreOriginal' => 'cDisProv', 'tipo' => 'tDistrito', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1376, 'campoMT' => 'E319', 'esGrupo' => false],
    ],
    'dDesDisProv' => [
      ['nombre' => 'dDesDisProv', 'nombreOriginal' => 'dDesDisProv', 'tipo' => 'tDesDistrito', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1378, 'campoMT' => 'E320', 'esGrupo' => false],
    ],
    'cCiuProv' => [
      ['nombre' => 'cCiuProv', 'nombreOriginal' => 'cCiuProv', 'tipo' => 'tCiudad', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1379, 'campoMT' => 'E321', 'esGrupo' => false],
    ],
    'dDesCiuProv' => [
      ['nombre' => 'dDesCiuProv', 'nombreOriginal' => 'dDesCiuProv', 'tipo' => 'tDesCiudad', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamAE', 'contenedor' => 'sequence', 'linea' => 1380, 'campoMT' => 'E322', 'esGrupo' => false],
    ],
    'cTipRegImp' => [
      ['nombre' => 'cTipRegImp', 'nombreOriginal' => 'cTipRegImp', 'tipo' => 'tcTipRegAdu', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1392, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dPuLleg' => [
      ['nombre' => 'dPuLleg', 'nombreOriginal' => 'dPuLleg', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1393, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNuDesp' => [
      ['nombre' => 'dNuDesp', 'nombreOriginal' => 'dNuDesp', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1406, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dFecDesp' => [
      ['nombre' => 'dFecDesp', 'nombreOriginal' => 'dFecDesp', 'tipo' => 'tFecAAAAMMDDguion', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1418, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNomDesp' => [
      ['nombre' => 'dNomDesp', 'nombreOriginal' => 'dNomDesp', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1419, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dRucDesp' => [
      ['nombre' => 'dRucDesp', 'nombreOriginal' => 'dRucDesp', 'tipo' => 'tRuc', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1432, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDVDesp' => [
      ['nombre' => 'dDVDesp', 'nombreOriginal' => 'dDVDesp', 'tipo' => 'tDVer', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1433, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'cPaisProd' => [
      ['nombre' => 'cPaisProd', 'nombreOriginal' => 'cPaisProd', 'tipo' => 'paisType', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1434, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesPaisProd' => [
      ['nombre' => 'dDesPaisProd', 'nombreOriginal' => 'dDesPaisProd', 'tipo' => 'tDesPais', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1435, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dVend' => [
      ['nombre' => 'dVend', 'nombreOriginal' => 'dVend', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1436, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dValorInv' => [
      ['nombre' => 'dValorInv', 'nombreOriginal' => 'dValorInv', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1449, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dValorFle' => [
      ['nombre' => 'dValorFle', 'nombreOriginal' => 'dValorFle', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1462, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dValorSeg' => [
      ['nombre' => 'dValorSeg', 'nombreOriginal' => 'dValorSeg', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1475, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dValorImpGs' => [
      ['nombre' => 'dValorImpGs', 'nombreOriginal' => 'dValorImpGs', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1490, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDerAdu' => [
      ['nombre' => 'dDerAdu', 'nombreOriginal' => 'dDerAdu', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1503, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dIndi' => [
      ['nombre' => 'dIndi', 'nombreOriginal' => 'dIndi', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1518, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dSerValor' => [
      ['nombre' => 'dSerValor', 'nombreOriginal' => 'dSerValor', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1533, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dIVAImp' => [
      ['nombre' => 'dIVAImp', 'nombreOriginal' => 'dIVAImp', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1548, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dTasaIntAd' => [
      ['nombre' => 'dTasaIntAd', 'nombreOriginal' => 'dTasaIntAd', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEI', 'contenedor' => 'sequence', 'linea' => 1563, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'cFleExp' => [
      ['nombre' => 'cFleExp', 'nombreOriginal' => 'cFleExp', 'tipo' => 'paisType', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEE', 'contenedor' => 'sequence', 'linea' => 1587, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesFleExp' => [
      ['nombre' => 'dDesFleExp', 'nombreOriginal' => 'dDesFleExp', 'tipo' => 'tDesPais', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEE', 'contenedor' => 'sequence', 'linea' => 1588, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dPuEmb' => [
      ['nombre' => 'dPuEmb', 'nombreOriginal' => 'dPuEmb', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFEE', 'contenedor' => 'sequence', 'linea' => 1589, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dSubExe' => [
      ['nombre' => 'dSubExe', 'nombreOriginal' => 'dSubExe', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1614, 'campoMT' => 'F002', 'esGrupo' => false],
    ],
    'dSubExo' => [
      ['nombre' => 'dSubExo', 'nombreOriginal' => 'dSubExo', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1615, 'campoMT' => 'F003', 'esGrupo' => false],
    ],
    'dSub5' => [
      ['nombre' => 'dSub5', 'nombreOriginal' => 'dSub5', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1616, 'campoMT' => 'F004', 'esGrupo' => false],
    ],
    'dSub10' => [
      ['nombre' => 'dSub10', 'nombreOriginal' => 'dSub10', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1617, 'campoMT' => 'F005', 'esGrupo' => false],
    ],
    'dTotOpe' => [
      ['nombre' => 'dTotOpe', 'nombreOriginal' => 'dTotOpe', 'tipo' => 'tMontoBase', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1620, 'campoMT' => 'F008', 'esGrupo' => false],
    ],
    'dTotDesc' => [
      ['nombre' => 'dTotDesc', 'nombreOriginal' => 'dTotDesc', 'tipo' => 'tMontoBase', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1621, 'campoMT' => 'F009', 'esGrupo' => false],
    ],
    'dTotDescGlotem' => [
      ['nombre' => 'dTotDescGlotem', 'nombreOriginal' => 'dTotDescGlotem', 'tipo' => 'tMontoBase', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1622, 'campoMT' => 'F033', 'esGrupo' => false],
    ],
    'dTotAntItem' => [
      ['nombre' => 'dTotAntItem', 'nombreOriginal' => 'dTotAntItem', 'tipo' => 'tMontoBase', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1623, 'campoMT' => 'F034', 'esGrupo' => false],
    ],
    'dTotAnt' => [
      ['nombre' => 'dTotAnt', 'nombreOriginal' => 'dTotAnt', 'tipo' => 'tMontoBase', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1624, 'campoMT' => 'F035', 'esGrupo' => false],
    ],
    'dPorcDescTotal' => [
      ['nombre' => 'dPorcDescTotal', 'nombreOriginal' => 'dPorcDescTotal', 'tipo' => 'tPorcDesc8', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1625, 'campoMT' => 'F010', 'esGrupo' => false],
    ],
    'dDescTotal' => [
      ['nombre' => 'dDescTotal', 'nombreOriginal' => 'dDescTotal', 'tipo' => 'tMontoBase', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1626, 'campoMT' => 'F011', 'esGrupo' => false],
    ],
    'dAnticipo' => [
      ['nombre' => 'dAnticipo', 'nombreOriginal' => 'dAnticipo', 'tipo' => 'tMontoBase', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1627, 'campoMT' => 'F012', 'esGrupo' => false],
    ],
    'dRedon' => [
      ['nombre' => 'dRedon', 'nombreOriginal' => 'dRedon', 'tipo' => 'tdCRed', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1628, 'campoMT' => 'F013', 'esGrupo' => false],
    ],
    'dComi' => [
      ['nombre' => 'dComi', 'nombreOriginal' => 'dComi', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1629, 'campoMT' => 'F025', 'esGrupo' => false],
    ],
    'dTotGralOpe' => [
      ['nombre' => 'dTotGralOpe', 'nombreOriginal' => 'dTotGralOpe', 'tipo' => 'tMontoBase', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1630, 'campoMT' => 'F014', 'esGrupo' => false],
    ],
    'dIVA5' => [
      ['nombre' => 'dIVA5', 'nombreOriginal' => 'dIVA5', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1631, 'campoMT' => 'F015', 'esGrupo' => false],
    ],
    'dIVA10' => [
      ['nombre' => 'dIVA10', 'nombreOriginal' => 'dIVA10', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1632, 'campoMT' => 'F016', 'esGrupo' => false],
    ],
    'dLiqTotIVA5' => [
      ['nombre' => 'dLiqTotIVA5', 'nombreOriginal' => 'dLiqTotIVA5', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1634, 'campoMT' => 'F036', 'esGrupo' => false],
    ],
    'dLiqTotIVA10' => [
      ['nombre' => 'dLiqTotIVA10', 'nombreOriginal' => 'dLiqTotIVA10', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1636, 'campoMT' => 'F037', 'esGrupo' => false],
    ],
    'dIVAComi' => [
      ['nombre' => 'dIVAComi', 'nombreOriginal' => 'dIVAComi', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1638, 'campoMT' => 'F026', 'esGrupo' => false],
    ],
    'dTotIVA' => [
      ['nombre' => 'dTotIVA', 'nombreOriginal' => 'dTotIVA', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1639, 'campoMT' => 'F017', 'esGrupo' => false],
    ],
    'dBaseGrav5' => [
      ['nombre' => 'dBaseGrav5', 'nombreOriginal' => 'dBaseGrav5', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1641, 'campoMT' => 'F018', 'esGrupo' => false],
    ],
    'dBaseGrav10' => [
      ['nombre' => 'dBaseGrav10', 'nombreOriginal' => 'dBaseGrav10', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1643, 'campoMT' => 'F019', 'esGrupo' => false],
    ],
    'dTBasGraIVA' => [
      ['nombre' => 'dTBasGraIVA', 'nombreOriginal' => 'dTBasGraIVA', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1645, 'campoMT' => 'F020', 'esGrupo' => false],
    ],
    'dTotalGs' => [
      ['nombre' => 'dTotalGs', 'nombreOriginal' => 'dTotalGs', 'tipo' => 'tMontoBase', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgTotSub', 'contenedor' => 'sequence', 'linea' => 1649, 'campoMT' => 'F023', 'esGrupo' => false],
    ],
    'dDVId' => [
      ['nombre' => 'dDVId', 'nombreOriginal' => 'dDVId', 'tipo' => 'tDVer', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tDE', 'contenedor' => 'sequence', 'linea' => 1660, 'campoMT' => 'A003', 'esGrupo' => false],
    ],
    'dFecFirma' => [
      ['nombre' => 'dFecFirma', 'nombreOriginal' => 'dFecFirma', 'tipo' => 'fecHhmmss', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tDE', 'contenedor' => 'sequence', 'linea' => 1661, 'campoMT' => 'A004', 'esGrupo' => false],
    ],
    'dSisFact' => [
      ['nombre' => 'dSisFact', 'nombreOriginal' => 'dSisFact', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tDE', 'contenedor' => 'sequence', 'linea' => 1662, 'campoMT' => 'A005', 'esGrupo' => false],
    ],
    'gOpeDE' => [
      ['nombre' => 'gOpeDE', 'nombreOriginal' => 'gOpeDE', 'tipo' => 'tgCOpeDE', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tDE', 'contenedor' => 'sequence', 'linea' => 1674, 'campoMT' => 'B001', 'esGrupo' => true],
    ],
    'gTimb' => [
      ['nombre' => 'gTimb', 'nombreOriginal' => 'gTimb', 'tipo' => 'tgDTim', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tDE', 'contenedor' => 'sequence', 'linea' => 1675, 'campoMT' => 'C001', 'esGrupo' => true],
    ],
    'gDatGralOpe' => [
      ['nombre' => 'gDatGralOpe', 'nombreOriginal' => 'gDatGralOpe', 'tipo' => 'tgDaGOC', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tDE', 'contenedor' => 'sequence', 'linea' => 1676, 'campoMT' => 'D001', 'esGrupo' => true],
    ],
    'gDtipDE' => [
      ['nombre' => 'gDtipDE', 'nombreOriginal' => 'gDtipDE', 'tipo' => 'tgDtipDE', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tDE', 'contenedor' => 'sequence', 'linea' => 1677, 'campoMT' => 'E001', 'esGrupo' => true],
    ],
    'gTotSub' => [
      ['nombre' => 'gTotSub', 'nombreOriginal' => 'gTotSub', 'tipo' => 'tgTotSub', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tDE', 'contenedor' => 'sequence', 'linea' => 1678, 'campoMT' => 'F001', 'esGrupo' => true],
    ],
    'gCamGen' => [
      ['nombre' => 'gCamGen', 'nombreOriginal' => 'gCamGen', 'tipo' => 'tgCamGen', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tDE', 'contenedor' => 'sequence', 'linea' => 1679, 'campoMT' => 'G001', 'esGrupo' => true],
    ],
    'gCamDEAsoc' => [
      ['nombre' => 'gCamDEAsoc', 'nombreOriginal' => 'gCamDEAsoc', 'tipo' => 'tgCamDEAsoc', 'minOccurs' => 0, 'maxOccurs' => 99, 'padre' => 'tDE', 'contenedor' => 'sequence', 'linea' => 1681, 'campoMT' => 'H001', 'esGrupo' => true],
    ],
    'iTipDocAso' => [
      ['nombre' => 'iTipDocAso', 'nombreOriginal' => 'iTipDocAso', 'tipo' => 'tiTipDocAso', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1695, 'campoMT' => 'H002', 'esGrupo' => false],
    ],
    'dDesTipDocAso' => [
      ['nombre' => 'dDesTipDocAso', 'nombreOriginal' => 'dDesTipDocAso', 'tipo' => 'tdDesTipDocAso', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1696, 'campoMT' => 'H003', 'esGrupo' => false],
    ],
    'dCdCDERef' => [
      ['nombre' => 'dCdCDERef', 'nombreOriginal' => 'dCdCDERef', 'tipo' => 'tCDC', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1697, 'campoMT' => 'H004', 'esGrupo' => false],
    ],
    'dNTimDI' => [
      ['nombre' => 'dNTimDI', 'nombreOriginal' => 'dNTimDI', 'tipo' => 'tdNumTim', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1698, 'campoMT' => 'H005', 'esGrupo' => false],
    ],
    'dEstDocAso' => [
      ['nombre' => 'dEstDocAso', 'nombreOriginal' => 'dEstDocAso', 'tipo' => 'tdEst', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1699, 'campoMT' => 'H006', 'esGrupo' => false],
    ],
    'dPExpDocAso' => [
      ['nombre' => 'dPExpDocAso', 'nombreOriginal' => 'dPExpDocAso', 'tipo' => 'tdPunExp', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1701, 'campoMT' => 'H007', 'esGrupo' => false],
    ],
    'dNumDocAso' => [
      ['nombre' => 'dNumDocAso', 'nombreOriginal' => 'dNumDocAso', 'tipo' => 'tdNumDoc', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1703, 'campoMT' => 'H008', 'esGrupo' => false],
    ],
    'iTipoDocAso' => [
      ['nombre' => 'iTipoDocAso', 'nombreOriginal' => 'iTipoDocAso', 'tipo' => 'tiTIpoDoc', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1705, 'campoMT' => 'H009', 'esGrupo' => false],
    ],
    'dDTipoDocAso' => [
      ['nombre' => 'dDTipoDocAso', 'nombreOriginal' => 'dDTipoDocAso', 'tipo' => 'tdDesTIpoDoc', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1707, 'campoMT' => 'H010', 'esGrupo' => false],
    ],
    'dFecEmiDI' => [
      ['nombre' => 'dFecEmiDI', 'nombreOriginal' => 'dFecEmiDI', 'tipo' => 'tFecDocImpAAAAMMDDguion', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1709, 'campoMT' => 'H011', 'esGrupo' => false],
    ],
    'dNumComRet' => [
      ['nombre' => 'dNumComRet', 'nombreOriginal' => 'dNumComRet', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1710, 'campoMT' => 'H012', 'esGrupo' => false],
    ],
    'dNumResCF' => [
      ['nombre' => 'dNumResCF', 'nombreOriginal' => 'dNumResCF', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1723, 'campoMT' => 'H013', 'esGrupo' => false],
    ],
    'iTipCons' => [
      ['nombre' => 'iTipCons', 'nombreOriginal' => 'iTipCons', 'tipo' => 'tdTipCons', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1736, 'campoMT' => 'H014', 'esGrupo' => false],
    ],
    'dDesTipCons' => [
      ['nombre' => 'dDesTipCons', 'nombreOriginal' => 'dDesTipCons', 'tipo' => 'tdDesTipCons', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1738, 'campoMT' => 'H015', 'esGrupo' => false],
    ],
    'dNumCons' => [
      ['nombre' => 'dNumCons', 'nombreOriginal' => 'dNumCons', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1739, 'campoMT' => 'H016', 'esGrupo' => false],
    ],
    'dNumControl' => [
      ['nombre' => 'dNumControl', 'nombreOriginal' => 'dNumControl', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1751, 'campoMT' => 'H017', 'esGrupo' => false],
    ],
    'dRucFus' => [
      ['nombre' => 'dRucFus', 'nombreOriginal' => 'dRucFus', 'tipo' => 'tRuc', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1763, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNumCuoDocAso' => [
      ['nombre' => 'dNumCuoDocAso', 'nombreOriginal' => 'dNumCuoDocAso', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1764, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dImpCuoDocAso' => [
      ['nombre' => 'dImpCuoDocAso', 'nombreOriginal' => 'dImpCuoDocAso', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamDEAsoc', 'contenedor' => 'sequence', 'linea' => 1765, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dOrdCompra' => [
      ['nombre' => 'dOrdCompra', 'nombreOriginal' => 'dOrdCompra', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamGen', 'contenedor' => 'sequence', 'linea' => 1777, 'campoMT' => 'G002', 'esGrupo' => false],
    ],
    'dOrdVta' => [
      ['nombre' => 'dOrdVta', 'nombreOriginal' => 'dOrdVta', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamGen', 'contenedor' => 'sequence', 'linea' => 1791, 'campoMT' => 'G003', 'esGrupo' => false],
    ],
    'dAsiento' => [
      ['nombre' => 'dAsiento', 'nombreOriginal' => 'dAsiento', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamGen', 'contenedor' => 'sequence', 'linea' => 1805, 'campoMT' => 'G004', 'esGrupo' => false],
    ],
    'gCamCarg' => [
      ['nombre' => 'gCamCarg', 'nombreOriginal' => 'gCamCarg', 'tipo' => 'tgCamCarg', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamGen', 'contenedor' => 'sequence', 'linea' => 1819, 'campoMT' => 'G050', 'esGrupo' => true],
    ],
    'cUniMedTotVol' => [
      ['nombre' => 'cUniMedTotVol', 'nombreOriginal' => 'cUniMedTotVol', 'tipo' => 'tcUniMed', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamCarg', 'contenedor' => 'sequence', 'linea' => 1833, 'campoMT' => 'G051', 'esGrupo' => false],
    ],
    'dDesUniMedTotVol' => [
      ['nombre' => 'dDesUniMedTotVol', 'nombreOriginal' => 'dDesUniMedTotVol', 'tipo' => 'tdDesUniMed', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamCarg', 'contenedor' => 'sequence', 'linea' => 1835, 'campoMT' => 'G052', 'esGrupo' => false],
    ],
    'dTotVolMerc' => [
      ['nombre' => 'dTotVolMerc', 'nombreOriginal' => 'dTotVolMerc', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamCarg', 'contenedor' => 'sequence', 'linea' => 1836, 'campoMT' => 'G053', 'esGrupo' => false],
    ],
    'cUniMedTotPes' => [
      ['nombre' => 'cUniMedTotPes', 'nombreOriginal' => 'cUniMedTotPes', 'tipo' => 'tcUniMed', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamCarg', 'contenedor' => 'sequence', 'linea' => 1849, 'campoMT' => 'G054', 'esGrupo' => false],
    ],
    'dDesUniMedTotPes' => [
      ['nombre' => 'dDesUniMedTotPes', 'nombreOriginal' => 'dDesUniMedTotPes', 'tipo' => 'tdDesUniMed', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamCarg', 'contenedor' => 'sequence', 'linea' => 1851, 'campoMT' => 'G055', 'esGrupo' => false],
    ],
    'dTotPesMerc' => [
      ['nombre' => 'dTotPesMerc', 'nombreOriginal' => 'dTotPesMerc', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamCarg', 'contenedor' => 'sequence', 'linea' => 1852, 'campoMT' => 'G056', 'esGrupo' => false],
    ],
    'iCarCarga' => [
      ['nombre' => 'iCarCarga', 'nombreOriginal' => 'iCarCarga', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamCarg', 'contenedor' => 'sequence', 'linea' => 1864, 'campoMT' => 'G057', 'esGrupo' => false],
    ],
    'dDesCarCarga' => [
      ['nombre' => 'dDesCarCarga', 'nombreOriginal' => 'dDesCarCarga', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamCarg', 'contenedor' => 'sequence', 'linea' => 1873, 'campoMT' => 'G058', 'esGrupo' => false],
    ],
    'dCarQR' => [
      ['nombre' => 'dCarQR', 'nombreOriginal' => 'dCarQR', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamFuFD', 'contenedor' => 'sequence', 'linea' => 1908, 'campoMT' => 'J002', 'esGrupo' => false],
    ],
    'dInfAdic' => [
      ['nombre' => 'dInfAdic', 'nombreOriginal' => 'dInfAdic', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamFuFD', 'contenedor' => 'sequence', 'linea' => 1922, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dVerFor' => [
      ['nombre' => 'dVerFor', 'nombreOriginal' => 'dVerFor', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'rDE', 'contenedor' => 'sequence', 'linea' => 1942, 'campoMT' => 'AA002', 'esGrupo' => false],
    ],
    'DE' => [
      ['nombre' => 'DE', 'nombreOriginal' => 'DE', 'tipo' => 'tDE', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'rDE', 'contenedor' => 'sequence', 'linea' => 1950, 'campoMT' => 'A001', 'esGrupo' => true],
    ],
    'Signature' => [
      ['nombre' => 'Signature', 'nombreOriginal' => 'ds:Signature', 'tipo' => 'ds:Signature', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'rDE', 'contenedor' => 'sequence', 'linea' => 1951, 'campoMT' => 'I001', 'esGrupo' => false],
    ],
    'gCamFuFD' => [
      ['nombre' => 'gCamFuFD', 'nombreOriginal' => 'gCamFuFD', 'tipo' => 'tgCamFuFD', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'rDE', 'contenedor' => 'sequence', 'linea' => 1958, 'campoMT' => 'J001', 'esGrupo' => true],
    ],
    'iForPag' => [
      ['nombre' => 'iForPag', 'nombreOriginal' => 'iForPag', 'tipo' => 'tiForPag', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamRDE', 'contenedor' => 'sequence', 'linea' => 1970, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDesForPag' => [
      ['nombre' => 'dDesForPag', 'nombreOriginal' => 'dDesForPag', 'tipo' => 'tdDesForPag', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamRDE', 'contenedor' => 'sequence', 'linea' => 1971, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNumTrans' => [
      ['nombre' => 'dNumTrans', 'nombreOriginal' => 'dNumTrans', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamRDE', 'contenedor' => 'sequence', 'linea' => 1972, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dConc' => [
      ['nombre' => 'dConc', 'nombreOriginal' => 'dConc', 'tipo' => NULL, 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamRDE', 'contenedor' => 'sequence', 'linea' => 1986, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dRucEntFin' => [
      ['nombre' => 'dRucEntFin', 'nombreOriginal' => 'dRucEntFin', 'tipo' => 'tRuc', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamRDE', 'contenedor' => 'sequence', 'linea' => 2000, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dDvEntFin' => [
      ['nombre' => 'dDvEntFin', 'nombreOriginal' => 'dDvEntFin', 'tipo' => 'tDVer', 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamRDE', 'contenedor' => 'sequence', 'linea' => 2001, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dNomEntFin' => [
      ['nombre' => 'dNomEntFin', 'nombreOriginal' => 'dNomEntFin', 'tipo' => NULL, 'minOccurs' => 0, 'maxOccurs' => 1, 'padre' => 'tgCamRDE', 'contenedor' => 'sequence', 'linea' => 2002, 'campoMT' => NULL, 'esGrupo' => false],
    ],
    'dImpPag' => [
      ['nombre' => 'dImpPag', 'nombreOriginal' => 'dImpPag', 'tipo' => 'tMontoBase4', 'minOccurs' => 1, 'maxOccurs' => 1, 'padre' => 'tgCamRDE', 'contenedor' => 'sequence', 'linea' => 2016, 'campoMT' => NULL, 'esGrupo' => false],
    ],
  ],
];
