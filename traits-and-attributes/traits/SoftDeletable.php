<?php

trait SoftDeletable
{
    private ?string $deletedAt = null;

    public function delete() : void
    {
        if($this->deletedAt === null) {
            $this->deletedAt = date("d/m/Y H:i:s");
        }
    }

    public function isDeleted() : bool
    {
        return $this->deletedAt !== null;
    }

    public function getDeletedAt() : ?string
    {
        return $this->deletedAt;
    }
}
