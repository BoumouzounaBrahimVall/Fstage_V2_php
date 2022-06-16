<?php

require('../PDF/fpdf.php');
require( __DIR__.'./../phpQueries/etudiant/dash.php');
$num_niv_etu=$etudiant_niveau['NUM_NIV'];
$req_niv="SELECT LIBELLE_NIV from NIVEAU where NIVEAU.NUM_NIV='$num_niv_etu';";
$libelle_niv= $bdd->query($req_niv);
$libelle_niv_etu=$libelle_niv->fetch();
/* requette pour les informations du stage concerne par l etudiant */
$req_stg = "SELECT NUM_STG,DATEDEB_STG,DATEFIN_STG,SUJET_STG from STAGE where CNE_ETU='$etudiant_cne';";
$info_stg = $bdd->query($req_stg);
$info_stg_etu=$info_stg->fetch();
/* requete pour les informations d entreprise concerne par le stage  */
$req_ent = "SELECT ENTREPRISE.NUM_ENT ,ENTREPRISE.IMAGE_ENT,LIBELLE_ENT,ADRESSE_ENT,TEL_ENT,VILLE_ENT,PAYS_ENT from ENTREPRISE,OFFREDESTAGE,STAGE where STAGE.NUM_OFFR=OFFREDESTAGE.NUM_OFFR and OFFREDESTAGE.NUM_ENT=ENTREPRISE.NUM_ENT and STAGE.CNE_ETU='$etudiant_cne';";
$info_ent = $bdd->query($req_ent);
$info_ent_etu=$info_ent->fetch();

if(!empty($info_stg_etu)){
class PDF extends FPDF {

	// Page header
	function Header() {
		
		// Add logo to page
		$this->Image('../assets/icon/logo.png',10,8,33);
		// Set font family to Arial bold
		$this->SetFont('Arial','B',15);
		
		
        $this->SetY(50);
        $this->Cell(60);
		
		// Header
		//$this->Cell(50,10,'Heading',1,0,'C');
        $this->Cell(25,5,"Contrat de Stage ",);
		
		// Line break
		$this->Ln(20);
	}
    
	// Page footer
	function Footer() {
		
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		
		// Page number
		$this->Cell(0,10,'Page ' .
			$this->PageNo() . '/{nb}',0,0,'C');
	}

}

// Instantiation of FPDF class
$pdf = new PDF();

// Define alias for number of pages
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',14);

// Entreprise Informations 
$pdf->SetFont('helvetica','I',20);
$pdf->SetY(70);
$pdf->Cell(10);
$pdf->SetTextColor(0, 00, 200);
$pdf->Cell(10,10,"Informations sur l'entreprise",'C');

// Nom de l'entreprise
$pdf->SetTextColor(0, 00, 0);
$pdf->SetFont('Times','',12);
$pdf->SetY(80);
$pdf->Cell(10);
$pdf->Cell(45,10,"Nom de l'entreprise :");
$pdf->SetFont("Courier");
$pdf->Cell(45,10,$info_ent_etu['LIBELLE_ENT']);
$pdf->Image($info_ent_etu['IMAGE_ENT'],160,8,33);
//$pdf->Image('logo.png',160,8,33);
// Adresse de l'entreprise
$pdf->SetFont('Times','',12);
$pdf->SetY(90);
$pdf->Cell(10);
$pdf->Cell(50,10,"Adresse de l'entreprise : ");
$pdf->SetFont("Courier");
$pdf->Cell(45,10,$info_ent_etu['ADRESSE_ENT']);

// Ville de l'entreprise
$pdf->SetFont('Times','',12);
$pdf->SetY(100);
$pdf->Cell(10);
$pdf->Cell(50,10,"Ville de l'entreprise : ");
$pdf->SetFont("Courier");
$pdf->Cell(45,10,$info_ent_etu['VILLE_ENT']);

// Tel de l'entreprise
$pdf->SetFont('Times','',12);
$pdf->SetY(110);
$pdf->Cell(10);
$pdf->Cell(50,10,"TEL de l'entreprise : ");
$pdf->SetFont("Courier");
$pdf->Cell(45,10,$info_ent_etu['TEL_ENT']);
// Pays de l'entreprise
$pdf->SetFont('Times','',12);
$pdf->SetY(120);
$pdf->Cell(10);
$pdf->Cell(50,10,"PAYS de l'entreprise : ");
$pdf->SetFont("Courier");
$pdf->Cell(45,10,$info_ent_etu['PAYS_ENT']);


// Etudiant Informations
$pdf->SetFont('helvetica','I',20);
$pdf->SetY(130);
$pdf->Cell(10);
$pdf->SetTextColor(0, 0, 200);
$pdf->Cell(45,10,"Informations sur l'etudiant");
$pdf->SetTextColor(0, 00, 0);

// Nom de l'etudiant
$pdf->SetFont('Times','',12);
$pdf->SetY(140);
$pdf->Cell(10);
$pdf->Cell(45,10,"Nom de l'etudiant :");
$pdf->SetFont("Courier");
$pdf->Cell(45,10,$etudiant_info['NOM_ETU']);

// Niveau de l'etudiant
$pdf->SetFont('Times','',12);
$pdf->SetY(150);
$pdf->Cell(10);
$pdf->Cell(45,10,"Niveau de l'etudiant :");
$pdf->SetFont("Courier");
$pdf->Cell(45,10,$libelle_niv_etu[0]);

// Filiere de l'etudiant
$pdf->SetFont('Times','',12);
$pdf->SetY(160);
$pdf->Cell(10);
$pdf->Cell(45,10,"Ville de l'etudiant :");
$pdf->SetFont("Courier");
$pdf->Cell(45,10,$etudiant_info['VILLE_ETU']);

$pdf->SetFont("Courier");


// Stage Informations 
$pdf->SetFont('helvetica','I',20);
$pdf->SetY(140);
$pdf->Cell(10);
$pdf->SetTextColor(0, 0, 200);

$pdf->Cell(20,100,"Informations sur le Stage");
$pdf->SetTextColor(0, 00, 0);

$pdf->SetFont('Times','',12);
$pdf->SetY(200);
$pdf->Cell(10);
$pdf->Cell(45,10,"Numero de Stage :");
$pdf->SetFont("Courier");
$pdf->Cell(45,10,$info_stg_etu['NUM_STG']);
$pdf->SetFont('Times','',12);
$pdf->SetY(210);
$pdf->Cell(10);
$pdf->Cell(45,10,"Date Debut STG :");
$pdf->SetFont("Courier");
$pdf->Cell(45,10,$info_stg_etu['DATEDEB_STG']);
$pdf->SetFont('Times','',12);
$pdf->SetY(220);
$pdf->Cell(10);
$pdf->Cell(45,10,"Date Fint STG :");
$pdf->SetFont("Courier");
$pdf->Cell(45,10,$info_stg_etu['DATEFIN_STG']);
$pdf->SetFont('Times','',12);
$pdf->SetY(230);
$pdf->Cell(10);
$pdf->Cell(45,10,"Sujet du STG :");

$pdf->Cell(45,10,$info_stg_etu['SUJET_STG']);
$pdf->SetFont('Times','U',14);
$pdf->SetY(220);
$pdf->Cell(10);
$pdf->SetTextColor(0, 0, 20000);
$pdf->Cell(45,50,"Signature de l'etudiant :");

//$pdf->Output('F', '../ressources/EtudiantCONTRAT/'.$etudiant_info['CNE_ETU'].'.pdf');
$pdf->Output('F','../ressources/EtudiantCONTRAT/'.$etudiant_info['CNE_ETU'].''.$etudiant_niveau['NUM_NIV'].''.$info_stg_etu['NUM_STG'].'.pdf');
$pdf->Output();
}
?>



