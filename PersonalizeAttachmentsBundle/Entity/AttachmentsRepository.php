<?php

/*
 * @author      FFC_HOU
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */


namespace MauticPlugin\PersonalizeAttachmentsBundle\Entity;

use Mautic\CoreBundle\Entity\CommonRepository;

class AttachmentsRepository extends CommonRepository
{


    public function getEntitiess(array $args = [])
    {
        // $q = $this
        //     ->createQueryBuilder('a')
        //     ->select('a')
        //     ->leftJoin('a.segmentId', 's');

        // $args['qb'] = $q;

        return parent::getEntities();
    }

    

}
