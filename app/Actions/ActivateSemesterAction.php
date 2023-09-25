<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\SemesterStatus;
use App\Models\Semester;
use Exception;
use Illuminate\Database\ConnectionInterface;

class ActivateSemesterAction
{
    public function __construct(
        protected ConnectionInterface $db,
    ) {}

    /**
     * @throws Exception
     */
    public function execute(Semester $semester): void
    {
        try {
            $this->db->beginTransaction();

            Semester::getActive()?->update(["status" => SemesterStatus::INACTIVE]);
            $semester->update(["status" => SemesterStatus::ACTIVE]);

            $this->db->commit();
        } catch (Exception $exception) {
            $this->db->rollBack();

            throw $exception;
        }
    }
}
