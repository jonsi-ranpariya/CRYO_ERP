<?php

namespace App\Enums\Inventory;

use BenSampo\Enum\Enum;

final class MaterialIssueEnum extends Enum
{
    const WorkOrder = 'work-order';
    const JobCard = 'job-card';
    const itemRequition = 'item-requisition';
    const ManualIssue = 'manual-issue';
    const ItemMaster = 'item-master';
}
