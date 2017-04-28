<?php

namespace Amranidev\ScaffoldInterface\Datasystem\Database;

use Illuminate\Support\Facades\DB;

/**
 * Class DefaultDatabase.
 *
 * @author Athi Krishnan <athikrishnan5@gmail.com>
 */
class SqlsrvDatabase extends Database
{
    public function tableNames()
    {

        return collect(DB::select($this->getQuery()))->pluck('TABLE_NAME')->reject(function ($name) {
            return $this->skips()->contains($name);
        });
    }

    /**
     * Mysql query.
     *
     * @return string
     */
    public function getQuery()
    {
        return 'SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = \'BASE TABLE\' AND TABLE_CATALOG=\''.env('DB_DATABASE').'\'';
        //return 'USE '.env('DB_DATABASE').'SELECT name FROM sys.tables';
    }

    /**
     * Skip unused schemas.
     *
     * @return \Illuminate\Support\Collection
     */
    public function skipNames()
    {
        return collect([]);
    }
}
