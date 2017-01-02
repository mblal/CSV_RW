<?php

namespace MBL\CSVRWBundle\Formatter;

/**
 * Class UniversalDirectoryCsvReader
 * @package MBL\CSVRWBundle\Formatter
 */
class UniversalDirectoryCsvReader extends AbstractCsvReader
{
    /**
     * Get CSV Header
     * @return array
     */
    public function getHeader()
    {
        return array(
            'Téléphone' => 'ligneTelephonique.msisdn',
            'Format de parution' => 'formatPublication',
            'Type de terminal' => 'terminalType',
            'Nom'=> 'ligneTelephonique.utilisateur.nom',
            'Prénom'=> 'ligneTelephonique.utilisateur.prenom',
            'Publier Prénom'=> 'showLastName',
            'Email'=> 'email',
            'Profession'=> 'profession',
            'Information Complémentaire'=> 'informationComplement',
            'Adresse'=> 'addressComplement',
            'Code Postal'=> 'CODE_POSTAL',
            'Ville'=> 'zipcode',
            'Publier adresse'=> 'NON_IDENTIFIE',
            'Raison sociale'=> 'showCompanyName',
            'Dénomination administrative' => 'additionalName',
            'SIRET'=> 'siret',
            'Code Nace'=> 'nace',
            'Code Postal de Parution'=> 'zipcodePublication',
            'Souhaite apparaître dans l\'annuaire inversé'=> 'showLaai',
            'Souhaite participer à des opérations de prospection'=> 'showLap',
            'Afficher initiale du prénom'=> 'showFirstNameIni',
            'Adresse partielle'=> 'addressTruncate',
            'Ordre de parution'=> 'publicationOrder',
            'Numéro groupé' => 'groupNumber',
            'Test' => 'ligneTelephonique.utilisateur.cleAppairage'
        );
    }
}