<?php

include("config.php");

/**
 * 留言板控制器
 *
 * 提供取得、新增、修改、刪除
 */
class Database
{
    /** @var mysqli $conn 連接資料庫的物件 */
    private $conn;

    /**
     * 建立資料庫連線
     *
     * @return void
     */
    public function __construct()
    {
        $env = Env::$env;
        $this->conn = new mysqli($env['DB_HOST'], $env['DB_USERNAME'], $env['DB_PASSWORD'], $env['DB_DATABASE']);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    /**
     * 讀取所有留言
     *
     * @return mysqli_result
     */
    public function read(): mysqli_result
    {
        $sql = sprintf("SELECT id, title, content FROM message_board ORDER BY id DESC");
        return $this->conn->query($sql);
    }

    /**
     * 新增留言
     *
     * @param string $title 留言標題
     * @param string $content 留言內容
     *
     * @return bool
     */
    public function store($title, $content): bool
    {
        $sql = sprintf("INSERT INTO message_board (title, content) VALUES ('%s', '%s')",
            $title,
            $content
        );
        $this->conn->query($sql);
        if ($this->conn->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 更新留言
     *
     * @param int $id 留言id
     * @param string $title 新留言標題
     * @param string $content 新留言內容
     *
     * @return bool
     */
    public function update($id, $title, $content): bool
    {
        $sql = sprintf("UPDATE message_board SET title = '%s', content = '%s' WHERE id = '%s'",
            $title,
            $content,
            $id
        );
        $this->conn->query($sql);
        if ($this->conn->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 刪除留言
     *
     * @param int $id 留言id
     *
     * @return bool
     */
    public function destroy($id): bool
    {
        $sql = sprintf("DELETE FROM message_board WHERE id = '%s'", $id);
        $this->conn->query($sql);
        if ($this->conn->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 關閉資料庫連線
     *
     * @return void
     */
    public function __destruct()
    {
        $this->conn->close();
    }
}
