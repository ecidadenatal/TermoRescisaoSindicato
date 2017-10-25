<?php
$lin = 2;
$col = 2;
$iAltLinha1 = 8;

$arr_rubproventos = array();
$arr_desproventos = array();
$arr_qtdproventos = array();
$arr_valproventos = array();

$arr_rubdescontos = array();
$arr_desdescontos = array();
$arr_qtddescontos = array();
$arr_valdescontos = array();

$linhasproventos = $this->linhasproventos;
$linhasdescontos = $this->linhasdescontos;

$total_qtdproventos = 0;
$total_valproventos = 0;

$total_qtddescontos = 0;
$total_valdescontos = 0;

for($i=0; $i<$linhasproventos; $i++){
  $arr_rubproventos[$i] = pg_result($this->resultproventos,$i,"rh27_rubric");
  $arr_desproventos[$i] = pg_result($this->resultproventos,$i,"rh27_descr");
  $arr_qtdproventos[$i] = pg_result($this->resultproventos,$i,"r20_quant");
  $arr_valproventos[$i] = pg_result($this->resultproventos,$i,"r20_valor");

  $total_qtdproventos += $arr_qtdproventos[$i];
  $total_valproventos += $arr_valproventos[$i];
}
for($i=0; $i<$linhasdescontos; $i++){
  $arr_rubdescontos[$i] = pg_result($this->resultdescontos,$i,"rh27_rubric");
  $arr_desdescontos[$i] = pg_result($this->resultdescontos,$i,"rh27_descr");
  $arr_qtddescontos[$i] = pg_result($this->resultdescontos,$i,"r20_quant");
  $arr_valdescontos[$i] = pg_result($this->resultdescontos,$i,"r20_valor");

  $total_qtddescontos += $arr_qtddescontos[$i];
  $total_valdescontos += $arr_valdescontos[$i];
}

//db_rescisao($this);
$totalpaginas = (int)(max($linhasproventos, $linhasdescontos) / 20);
if($totalpaginas < 1){
  $totalpaginas = 1;
}else{
  $totalpaginas ++;
}

$iAlturaRect = 0;
$iAlturaText = 0;

$iTotalRegistros = max($linhasproventos, $linhasdescontos);

for ($i=0, $a=1; $i <= $iTotalRegistros; $i++) {

  if($i==0 || $this->objpdf->GetY() > 184){
    $this->objpdf->AliasNbPages();
    $this->objpdf->settopmargin(1);
    $this->objpdf->setfillcolor(245);
    $this->objpdf->AddPage();

    $this->objpdf->rect($col,$lin,206,10);
    $this->objpdf->Setfont('Arial','B',12);
    $this->objpdf->text(70,8,'T E R M O  D E  R E S C I S Ã O');

    $iAlturaRect = 12;
    $this->objpdf->rect($col,$lin+$iAlturaRect,10,24);
    $this->objpdf->rect($col+10,$lin+$iAlturaRect,45,$iAltLinha1);
    $this->objpdf->rect($col+55,$lin+$iAlturaRect,151,$iAltLinha1);
    
    $iAlturaRect = 20;
    $this->objpdf->rect($col+10,$lin+$iAlturaRect,111,$iAltLinha1);
    $this->objpdf->rect($col+121,$lin+$iAlturaRect,85,$iAltLinha1);
    
    $iAlturaRect = 28;
    $this->objpdf->rect($col+10,$lin+$iAlturaRect,80,$iAltLinha1);
    $this->objpdf->rect($col+90,$lin+$iAlturaRect,15,$iAltLinha1);
    $this->objpdf->rect($col+105,$lin+$iAlturaRect,20,$iAltLinha1);
    $this->objpdf->rect($col+125,$lin+$iAlturaRect,20,$iAltLinha1);
    $this->objpdf->rect($col+145,$lin+$iAlturaRect,61,$iAltLinha1);

    
    $this->objpdf->Setfont('Arial','',6);
    $iAlturaText = 14;
    $this->objpdf->text($col+12,$lin+$iAlturaText,'01 - CNPJ/CEI');
    $this->objpdf->text($col+57,$lin+$iAlturaText,'02 - NOME/RAZÃO SOCIAL');
    
    $iAlturaText = 22;
    $this->objpdf->text($col+12,$lin+$iAlturaText,'03 - Endereço(logradouro, n°, andar, apartamento)');
    $this->objpdf->text($col+123,$lin+$iAlturaText,'04 - Bairro');
    
    $iAlturaText = 30;
    $this->objpdf->text($col+12,$lin+$iAlturaText,'05 - Município');
    $this->objpdf->text($col+92,$lin+$iAlturaText,'06 - UF');
    $this->objpdf->text($col+107,$lin+$iAlturaText,'07 - CEP');
    $this->objpdf->text($col+127,$lin+$iAlturaText,'08 - CNAE');
    $this->objpdf->text($col+147,$lin+$iAlturaText,'09 - CNPJ/CEI Tomador/Obra');

    $this->objpdf->Setfont('Arial','',9);
    $iAlturaText = 18;
    $this->objpdf->text($col+12,$lin+$iAlturaText,db_formatar($this->cgcpref,'cnpj'));
    $this->objpdf->text($col+57,$lin+$iAlturaText,$this->prefeitura);
    
    $iAlturaText = 26;
    $this->objpdf->text($col+12,$lin+$iAlturaText,$this->enderpref);
    $this->objpdf->text($col+123,$lin+$iAlturaText,$this->bairropref);
    
    $iAlturaText = 36;
    $this->objpdf->text($col+12,$iAlturaText,$this->municpref);
    $this->objpdf->text($col+92,$iAlturaText,$this->ufpref);
    $this->objpdf->text($col+107,$iAlturaText,db_formatar($this->ceppref,'cep'));
    $this->objpdf->text($col+127,$iAlturaText,substr(db_formatar($this->cnae,"s","0",6,"e",0),0,5).'-'.substr(db_formatar($this->cnae,"s","0",6,"e",0),5,1));
    $this->objpdf->text($col+147,$iAlturaText,'');


    $this->objpdf->Setfont('Arial','',6);
    $iAlturaRect = 40;
    $this->objpdf->rect($col,$iAlturaRect,10,32);
    $this->objpdf->rect($col+10,$iAlturaRect,45,$iAltLinha1);
    $this->objpdf->rect($col+55,$iAlturaRect,151,$iAltLinha1);
    
    $iAlturaRect = 48;
    $this->objpdf->rect($col+10,$iAlturaRect,111,$iAltLinha1);
    $this->objpdf->rect($col+121,$iAlturaRect,85,$iAltLinha1);
    
    $iAlturaRect = 56;
    $this->objpdf->rect($col+10,$iAlturaRect,80,$iAltLinha1);
    $this->objpdf->rect($col+90,$iAlturaRect,15,$iAltLinha1);
    $this->objpdf->rect($col+105,$iAlturaRect,30,$iAltLinha1);
    $this->objpdf->rect($col+135,$iAlturaRect,71,$iAltLinha1);
    
    $iAlturaRect = 64;
    $this->objpdf->rect($col+10,$iAlturaRect,45,$iAltLinha1);
    $this->objpdf->rect($col+55,$iAlturaRect,35,$iAltLinha1);
    $this->objpdf->rect($col+90,$iAlturaRect,116,$iAltLinha1);
  
    $iAlturaText = 42;
    $this->objpdf->text($col+12,$iAlturaText,'10 - PIS / PASEP');
    $this->objpdf->text($col+57,$iAlturaText,'11 - Nome');
    
    $iAlturaText = 50;
    $this->objpdf->text($col+12,$iAlturaText,'12 - Endereço(logradouro, n°, andar, apartamento)');
    $this->objpdf->text($col+123,$iAlturaText,'13 - Bairro');
    
    $iAlturaText = 58;
    $this->objpdf->text($col+12,$iAlturaText,'14 - Município');
    $this->objpdf->text($col+92,$iAlturaText,'15 - UF');
    $this->objpdf->text($col+107,$iAlturaText,'16 - CEP');
    $this->objpdf->text($col+137,$iAlturaText,'17 - Carteira de Trabalho(n°,série,UF');
    
    $iAlturaText = 66;
    $this->objpdf->text($col+12,$iAlturaText,'18 - CPF');
    $this->objpdf->text($col+57,$iAlturaText,'19 - Data de Nascimento');
    $this->objpdf->text($col+92,$iAlturaText,'20 - Nome da Mãe');

    $this->objpdf->Setfont('Arial','',9);
    $iAlturaText = 46;
    $this->objpdf->text($col+12,$iAlturaText,$this->pis);
    $this->objpdf->text($col+57,$iAlturaText,$this->nome);
    
    $iAlturaText = 54;
    $this->objpdf->text($col+12,$iAlturaText,$this->endereco);
    $this->objpdf->text($col+123,$iAlturaText,$this->bairro);
    
    $iAlturaText = 62;
    $this->objpdf->text($col+12,$iAlturaText,$this->munic);
    $this->objpdf->text($col+92,$iAlturaText,$this->uf);
    $this->objpdf->text($col+107,$iAlturaText,db_formatar($this->cep,'cep'));
    $this->objpdf->text($col+137,$iAlturaText,$this->ctps);
    
    $iAlturaText = 70;
    $this->objpdf->text($col+12,$iAlturaText, db_formatar($this->cpf,'cpf'));
    $this->objpdf->text($col+57,$iAlturaText, db_formatar($this->nasc,'d'));
    $this->objpdf->text($col+92,$iAlturaText,$this->mae);

    $this->objpdf->Setfont('Arial','',6);
    $iAlturaRect = 74;
    $this->objpdf->rect($col,$iAlturaRect,10,16);
    $this->objpdf->rect($col+10,$iAlturaRect,98,$iAltLinha1);
    $this->objpdf->rect($col+108,$iAlturaRect,98,$iAltLinha1);
    
    $iAlturaText = 76;
    $this->objpdf->text($col+12, $iAlturaText,'21 - Tipo de Contrato');
    $this->objpdf->text($col+110, $iAlturaText,'22 - Causa do Afastamento');

    $sql_regime = "select case when rh02_codreg in (42,45,46) then 1 else 2 end as tp_contrato 
                   from rhpessoalmov where rh02_anousu = ".$this->ano." and rh02_mesusu = ".$this->mes." and rh02_regist = ".$this->regist;
    $res_regime = pg_result($res_regime,0);
  
    $tipo_contrato = "Contrato de Trabalho por Prazo Indeterminado";
    if(pg_numrows($res_regime) > 0){
      db_fieldsmemory($res_regime,0);
      if($tp_contrato == 1){
        $tipo_contrato = "Contrato de Trabalho por Prazo Determinado";
      }
    }

    $this->objpdf->Setfont('Arial','',9);
    $iAlturaText = 80;
    $this->objpdf->text($col+12,$iAlturaText, $tipo_contrato );
    $this->objpdf->text($col+110, $iAlturaText,$this->causa);


    $iAlturaRect = 82;
    $this->objpdf->rect($col,$iAlturaRect,10,16);
    $this->objpdf->rect($col+50,$iAlturaRect,40,$iAltLinha1);
    $this->objpdf->rect($col+90,$iAlturaRect,40,$iAltLinha1);
    $this->objpdf->rect($col+130,$iAlturaRect,40,$iAltLinha1);
    $this->objpdf->rect($col+170,$iAlturaRect,36,$iAltLinha1);

    $iAlturaRect = 90;
    $this->objpdf->rect($col+10,$iAlturaRect,65,$iAltLinha1);
    $this->objpdf->rect($col+75,$iAlturaRect,65,$iAltLinha1);
    $this->objpdf->rect($col+140,$iAlturaRect,66,$iAltLinha1);
 

 
    $this->objpdf->Setfont('Arial','',6);
    $iAlturaText = 84;
    $this->objpdf->text($col+12, $iAlturaText,'23 - Remuneração p/ fins rescisão');
    $this->objpdf->text($col+52, $iAlturaText,'24 - Data de Admissão');
    $this->objpdf->text($col+92,$iAlturaText,'25 - Data do Aviso Prévio');
    $this->objpdf->text($col+132,$iAlturaText,'26 - Data de Afastamento');
    $this->objpdf->text($col+172,$iAlturaText,'27 - Cód. Afastamento');
    
    $iAlturaText = 92;
    $this->objpdf->text($col+12, $iAlturaText,'28 - Pensão Alim.(%) TRCT');
    $this->objpdf->text($col+77,$iAlturaText,'29 - Pensão Alim.(%) FGTS');
    $this->objpdf->text($col+142,$iAlturaText,'30 - Categoria do Trabalhador');

    $this->objpdf->Setfont('Arial','',9);
    $iAlturaText = 88;
    $this->objpdf->text($col+12, $iAlturaText,db_formatar($this->mremun,'f'));
    $this->objpdf->text($col+52, $iAlturaText,db_formatar($this->admiss,'d'));
    $this->objpdf->text($col+92,$iAlturaText,db_formatar($this->aviso,'d'));
    $this->objpdf->text($col+132,$iAlturaText,db_formatar($this->recis,'d'));
    $this->objpdf->text($col+172,$iAlturaText,$this->cod_afas);
    
    $iAlturaText = 96;
    $this->objpdf->text($col+12, $iAlturaText,db_formatar($this->pensao,'f'));
    $this->objpdf->text($col+77,$iAlturaText,db_formatar(0,'f'));
    $this->objpdf->text($col+142,$iAlturaText,$this->categoria);



    $iAlturaRect = 100;
    $this->objpdf->rect($col,$iAlturaRect,10,$iAltLinha1);
    $this->objpdf->rect($col+10,$iAlturaRect,30,$iAltLinha1);
    $this->objpdf->rect($col+40,$iAlturaRect,166,$iAltLinha1);
 //   $this->objpdf->rect($col+110,$iAlturaRect,96,$iAltLinha1);
    
    $iAlturaText = 102;
    $this->objpdf->Setfont('Arial','',6);
    $this->objpdf->text($col+12, $iAlturaText,'31 - Código Sindicato');
    $this->objpdf->text($col+42, $iAlturaText,'32 - CNPJ e Nome da Entidade Sindical');
   // $this->objpdf->text($col+112,$iAlturaText,'Sindicato');
    
    $this->objpdf->Setfont('Arial','',9);
    $iAlturaText = 106;
    $this->objpdf->text($col+12, $iAlturaText,$this->sindicato_codigo);
    $this->objpdf->text($col+42, $iAlturaText,$this->sindicato_cnpj.' - '.$this->sindicato_descricao);
//    $this->objpdf->text($col+112,$iAlturaText,$this->sindicato_descricao);
    
    $this->objpdf->Setfont('Arial','',10);
    $iAlturaRect = 110;
    $this->objpdf->rect($col,$iAlturaRect,10,99);
    $this->objpdf->rect($col+10,$iAlturaRect,196,99);
    
    $iAlturaRect = 114;
    $this->objpdf->text($col+40,$iAlturaRect,'PROVENTOS');
    $this->objpdf->text($col+150,$iAlturaRect,'DESCONTOS');

    $iAlturaRect = 211;
    $this->objpdf->Setfont('Arial','',6);
    $this->objpdf->rect($col,$iAlturaRect,10,80);
    $this->objpdf->rect($col+10,$iAlturaRect,98,$iAltLinha1);
    $this->objpdf->rect($col+108,$iAlturaRect,98,$iAltLinha1);
    
    $iAlturaRect = 219;
    $this->objpdf->rect($col+10,$iAlturaRect,98,$iAltLinha1);
    $this->objpdf->rect($col+108,$iAlturaRect,98, $iAltLinha1);
    
    $iAlturaRect = 227;
    $this->objpdf->rect($col+10,$iAlturaRect,98,43);
    $this->objpdf->rect($col+108,$iAlturaRect,49,43);
    $this->objpdf->rect($col+157,$iAlturaRect,49,43);
    
    $iAlturaText = 213;
    $this->objpdf->text($col+12,$iAlturaText,'56 - Local e Data do Recolhimento');
    $this->objpdf->text($col+110,$iAlturaText,'57 - Carimbo e Assinatura do Empregador ou Proposto');
    
    $iAlturaText = 221;
    $this->objpdf->text($col+12,$iAlturaText,'58 - Assinatura do Trabalhador');
    $this->objpdf->text($col+110,$iAlturaText,'59 - Assinatura do Responsável Legal do Trabalhador');
    
    $iAlturaText = 229;
    $this->objpdf->text($col+12,$iAlturaText,'60 - Homologação');

    $this->objpdf->Setfont('Arial','',8);
    $iAlturaText = 227;
    if($this->regime != 1){
      $this->objpdf->text($col+12,$iAlturaText+6,'Foi prestado, gratualmente, assistência ao trabalhador, nos termos do ');
      $this->objpdf->text($col+12,$iAlturaText+9,'art. 447 parag. 1° da Consolidação das Leis do Trabalho - CLT, sendo ');
      $this->objpdf->text($col+12,$iAlturaText+12,'comprovado, neste ato, efetivo pagamento das verbas rescisórias acima ');
      $this->objpdf->text($col+12,$iAlturaText+15,'especificadas.');
    }
    $this->objpdf->Setfont('Arial','',6);
    $this->objpdf->text($col+12,$iAlturaText+27,'__________________________________________________');
    $this->objpdf->text($col+12,$iAlturaText+30,'Local e data');
    $this->objpdf->text($col+12,$iAlturaText+39,'__________________________________________________');
    $this->objpdf->text($col+12,$iAlturaText+42,'Carimbo e assinatura do assistente');

    $this->objpdf->Setfont('Arial','',6);
    $this->objpdf->rect($col+10,$iAlturaRect+43,98,21);
    $this->objpdf->rect($col+108,$iAlturaRect+43,98,21);
    
    $this->objpdf->text($col+110,$iAlturaText+2,'61 - Digital do Trabalhador');
    $this->objpdf->text($col+159,$iAlturaText+2,'62 - Digital do Responsável Legal');
    $this->objpdf->text($col+12,$iAlturaText+45,'63 - Identificação do Órgao Homologador');
    $this->objpdf->text($col+110,$iAlturaText+45,'64 - Recepção Pelo Banco (Data e Carimbo');

///    $iAlturaText = 288;
//    $this->objpdf->text($col,$iAlturaText,'Órgao   : '.$this->orgao.'-'.$this->descr_orgao);
//    $this->objpdf->text($col+100,$iAlturaText,'Unidade : '.$this->unidade.'-'.$this->descr_unidade);
    
//    $iAlturaText = 291;
//    $this->objpdf->text($col,$iAlturaText,'Proj/Ativ. : '.$this->projativ.'-'.$this->descr_projativ);
//    $this->objpdf->text($col+100,$iAlturaText,'Recurso  : '.$this->recurso.'-'.$this->descr_recurso);
    
    $iAlturaText = 294;
    $this->objpdf->text($col,$iAlturaText,'Competencia : '.$this->mes.'/'.$this->ano);

    if($i>=0){
      $this->objpdf->text($col + 18,200,"FOLHA ".$a." DE ".$totalpaginas);
      $a ++;
    }

    $this->objpdf->SetX($col + 25);
    $this->objpdf->SetY($lin + 114);
    $this->objpdf->Setfont('Arial','',5);
    $this->objpdf->SetAligns(array('C','R','L','R','C','R','L','R'));
    $this->objpdf->SetWidths(array(10,15,58,16,10,15,58,16));

  }

  if(!isset($arr_rubproventos[$i])){
    $arr_rubproventos[$i] = "";
    $arr_desproventos[$i] = "";
    $arr_qtdproventos[$i] = "";
    $arr_valproventos[$i] = "";
  }
  if(!isset($arr_rubdescontos[$i])){
    $arr_rubdescontos[$i] = "";
    $arr_desdescontos[$i] = "";
    $arr_qtddescontos[$i] = "";
    $arr_valdescontos[$i] = "";
  }

  $this->objpdf->Row(array(
    $arr_rubproventos[$i],($arr_rubproventos[$i]!=""?db_formatar($arr_qtdproventos[$i],"f"):""),$arr_desproventos[$i],($arr_rubproventos[$i]!=""?db_formatar($arr_valproventos[$i],"f"):""),
    $arr_rubdescontos[$i],($arr_rubdescontos[$i]!=""?db_formatar($arr_qtddescontos[$i],"f"):""),$arr_desdescontos[$i],($arr_rubdescontos[$i]!=""?db_formatar($arr_valdescontos[$i],"f"):"")
                          ),3,false,4);

}

//if($a > 1){
  //$this->objpdf->text($col + 18,190,"FOLHA ".$a." DE ".$totalpaginas);
//}

$this->objpdf->SetY(200);
$this->objpdf->SetAligns(array('C','R','R','R','C','R','R','R'));
$this->objpdf->Row(
  array(
    "",
    "",
    "SOMA DOS PROVENTOS",
    db_formatar($total_valproventos,"f"),
    "",
    "",
    "SOMA DOS DESCONTOS",
    db_formatar($total_valdescontos,"f")
  ),
  3,
  false,
  4);
$this->objpdf->Row(array(
                         "", "", "", "",
                         "", "", "TOTAL LÍQUIDO", db_formatar(($total_valproventos - $total_valdescontos),"f")
                        ),3,false,4);

?>
