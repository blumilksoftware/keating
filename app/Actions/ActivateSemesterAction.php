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

            $semester->update(["active" => !$semester->active]);

            $this->db->commit();
        } catch (Exception $exception) {
            $this->db->rollBack();

            throw $exception;
        }
    }
}
