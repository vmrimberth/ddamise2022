<?php
class Database {

    public static function init() {
        $query = <<<EOF
            CREATE TABLE IF NOT EXISTS main.path (
                username text NOT NULL,
                latitude number NOT NULL,
                longitude number NOT NULL,
                accuracy number NOT NULL
            );
        EOF;
        $db = new SQLite3("database.db");
        $results = $db->exec($query);
        if (!$results) {
            echo $db->lastErrorMsg();
            $db->close();
            return false;
        }
        $db->close();
        return true;
    }

    public static function save(Point $point): bool {
        $query = <<<EOF
            INSERT INTO main.path VALUES ('{$point->username}',{$point->latitude},{$point->longitude},{$point->accuracy});
        EOF;
        $db = new SQLite3("database.db");
        $results = $db->exec($query);
        if (!$results) {
            echo $db->lastErrorMsg();
            $db->close();
            return false;
        }
        $db->close();
        return true;
    }

    public static function list(): array {
        $query = <<<EOF
            select * from path
        EOF;
        $db = new SQLite3("database.db");
        $results = $db->query($query);
        if (!$results) {
            echo $db->lastErrorMsg();
            $db->close();
            return false;
        }
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $list[] = $row;
        }
        $db->close();
        return $list ?? [];
    }

    public static function listUsers(): array {
        $query = <<<EOF
            select distinct username from path where username!='' order by username
        EOF;
        $db = new SQLite3("database.db");
        $results = $db->query($query);
        if (!$results) {
            echo $db->lastErrorMsg();
            $db->close();
            return false;
        }
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $list[] = $row;
        }
        $db->close();
        return $list ?? [];
    }

    public static function listPoints(string $username): array {
        $query = <<<EOF
            select * from path where username like '{$username}%'
        EOF;
        $db = new SQLite3("database.db");
        $results = $db->query($query);
        if (!$results) {
            echo $db->lastErrorMsg();
            $db->close();
            return false;
        }
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $list[] = $row;
        }
        $db->close();
        return $list ?? [];
    }
}
