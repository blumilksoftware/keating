<?php

declare(strict_types=1);

namespace App\Actions;

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

            Semester::getActive()?->update(["active" => 0]);
            $semester->update(["active" => 1]);

            $this->db->commit();
        } catch (Exception $exception) {
            $this->db->rollBack();

            throw $exception;
        }
    }
}
