<?php

declare(strict_types=1);

namespace Keating\Actions;

use Exception;
use Illuminate\Database\ConnectionInterface;
use Keating\Models\Semester;

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

            if ($semester->active) {
                Semester::query()->whereNot("id", $semester->id)->update(["active" => false]);
            }

            $this->db->commit();
        } catch (Exception $exception) {
            $this->db->rollBack();

            throw $exception;
        }
    }
}
