<?php namespace Laravel\Database\Query\Grammars;

use Laravel\Database\Query;

class IntersystemsCache extends Grammar {
    /**
     * Compile a SQL SELECT statement from a Query instance.
     *
     * @param  Query   $query
     * @return string
     */
    public function select(Query $query)
    {
        if (!is_null($query->aggregate) && $query->aggregate['aggregator'] === 'COUNT') {
            $query->aggregate['columns'] = array('*');
        }
        $components = parent::components($query);

        if ($query->offset > 0)
        {
            return $this->ansi_offset($query, $components);
        }
        return $this->concatenate($components);
    }

    /**
     * Compile the SELECT clause for a query.
     *
     * @param  Query   $query
     * @return string
     */
    protected function selects(Query $query)
    {
        if ( ! is_null($query->aggregate)) return;

        $select = ($query->distinct) ? 'SELECT DISTINCT ' : 'SELECT ';

        if ($query->limit > 0 and $query->offset <= 0)
        {
            $select .= 'TOP '.$query->limit.' ';
        }

        return $select.$this->columnize($query->selects);
    }

    /**
     * Generate the ANSI standard SQL for an offset clause.
     *
     * @param  Query  $query
     * @param  array  $components
     * @return array
     */
    protected function ansi_offset(Query $query, $components)
    {
        $start = $query->offset + 1;

        if ($query->limit > 0)
        {
            $finish = $query->offset + $query->limit;
            $constraint = "BETWEEN {$start} AND {$finish}";
            $subquery_top = $finish;
        }
        else
        {
            $constraint = ">= {$start}";
            $subquery_top = PHP_INT_MAX;
        }

        unset($components['offset']);
        $components['selects'] = str_replace(
            'SELECT', "SELECT TOP $subquery_top", $components['selects']);

        $sql = $this->concatenate($components);

        return "SELECT * FROM ($sql) As TempTable WHERE %vid {$constraint}";
    }

    /**
     * Compile the LIMIT clause for a query.
     *
     * @param  Query   $query
     * @return string
     */
    protected function limit(Query $query)
    {
        return '';
    }

    /**
     * Compile the OFFSET clause for a query.
     *
     * @param  Query   $query
     * @return string
     */
    protected function offset(Query $query)
    {
        return '';
    }
}
