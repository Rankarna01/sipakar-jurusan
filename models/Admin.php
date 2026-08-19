<?php
/**
 * Model Admin
 */
class Admin extends Model
{
    protected string $table = 'admin';
    protected string $primaryKey = 'id_admin';

    public function findByUsername(string $username): ?array
    {
        return $this->findBy('username', $username);
    }
}
