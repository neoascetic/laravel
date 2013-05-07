<?php

class IntersystemsCachePDOStatementMock extends \Laravel\Database\Connectors\IntersystemsCachePDOStatement {
    public function __construct($statement) {}
}

class IntersystemsCachePDOMock extends \Laravel\Database\Connectors\IntersystemsCachePDO {
    public function __construct($dsn) {}
}

class Post extends Model {
    public static $connection = 'intersystems_cache';
    public static $table = 'posts';
}

class IntersystemsCacheGrammarTest extends PHPUnit_Framework_TestCase {
    private static function grub_sql_get_query($fq, $columns = array('*')) {
        $query = $fq->table;
        if (is_null($query->selects)) $query->select($columns);
        return array($query->grammar->select($query), $query->bindings);
    }

    public function testSimpleGet() {
        $fq = Post::where('title', '=', 'post1')
            ->where('body', 'like', '%foobar%');
        $sql_query = static::grub_sql_get_query($fq);
        $expected_sql = 'SELECT * FROM "posts" WHERE "title" = ? AND "body" like ?';
        $this->assertEquals($expected_sql, $sql_query[0]);
        $this->assertEquals(array('post1', '%foobar%'), $sql_query[1]);
    }

    public function testQueryWithRelation() {
        $fq = Post::where('title', '=', 'post1')
            ->select(array(
                'title',
                'parent->title',
                'parent->parent->title as grandpa_title'
            ));
        list($actual_sql, ) = static::grub_sql_get_query($fq);
        $expected_sql = 'SELECT "title", parent->title, parent->parent->title AS "grandpa_title" FROM "posts" WHERE "title" = ?';
        $this->assertEquals($expected_sql, $actual_sql);
    }

    public function testTake() {
        $fq = Post::where('title', '=', 'post1')->take(5);
        $sql_query = static::grub_sql_get_query($fq);
        $expected_sql = 'SELECT TOP 5 * FROM "posts" WHERE "title" = ?';
        $this->assertEquals($expected_sql, $sql_query[0]);
        $this->assertEquals(array('post1'), $sql_query[1]);
    }

    public function testSkip() {
        // Without take()
        $fq = Post::skip(10);
        $sql_query = static::grub_sql_get_query($fq);
        $subquery_top = PHP_INT_MAX;
        $expected_sql = "SELECT * FROM (SELECT TOP $subquery_top * FROM \"posts\") As TempTable WHERE %vid >= 11";
        $this->assertEquals($expected_sql, $sql_query[0]);
        $this->assertEquals(array(), $sql_query[1]);

        // With take()
        $fq = Post::skip(10)->take(10);
        $sql_query = static::grub_sql_get_query($fq);
        $subquery_top = 20;
        $expected_sql = "SELECT * FROM (SELECT TOP $subquery_top * FROM \"posts\") As TempTable WHERE %vid BETWEEN 11 AND 20";
        $this->assertEquals($expected_sql, $sql_query[0]);
        $this->assertEquals(array(), $sql_query[1]);
    }
}
