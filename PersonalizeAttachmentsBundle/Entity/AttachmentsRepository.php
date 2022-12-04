<?php

/*
 * @copyright   2016 Mautic, Inc. All rights reserved
 * @author      Mautic, Inc
 *
 * @link        https://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\PersonalizeAttachmentsBundle\Entity;

use Mautic\CoreBundle\Entity\CommonRepository;

class AttachmentsRepository extends CommonRepository
{
    /**
     * @param string $search
     * @param int    $limit
     * @param int    $start
     * @param bool   $viewOther
     * @param array  $ignoreIds
     *
     * @return array
     */
    public function getPersonalizeattachmentsAttachmentsList($search = '', $limit = 10, $start = 0, $viewOther = false, array $ignoreIds = [])
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('partial t.{id, created_by, path, lead_lists_id}');

        if (!empty($search)) {
            if (is_array($search)) {
                $search = array_map('intval', $search);
                $qb->andWhere($qb->expr()->in('a.id', ':search'))
                    ->setParameter('search', $search);
            } else {
                $qb->andWhere($qb->expr()->like('a.path', ':search'))
                    ->setParameter('search', "%{$search}%");
            }
        }

        if (!$viewOther) {
            $qb->andWhere($qb->expr()->eq('a.createdBy', ':id'))
                ->setParameter('id', $this->currentUser->getId());
        }

        // if (!empty($ignoreIds)) {
        //     $qb->andWhere($qb->expr()->notIn('a.id', ':ignoreIds'))
        //         ->setParameter('ignoreIds', $ignoreIds);
        // }

        $qb->orderBy('a.path');

        if (!empty($limit)) {
            $qb->setFirstResult($start)
                ->setMaxResults($limit);
        }

        return $qb->getQuery()->getArrayResult();
    }
}
