<?php
require_once __DIR__ . '/../helper/config.php';

class IntroduceIntro extends db
{
  protected $conn;

  public function __construct()
  {
    parent::__construct();
    $this->conn = $this->connect;
    if (!$this->conn) {
      die("Connection failed in Introduce model");
    }
  }

  // Lấy tất cả các giá trị từ bảng introduce
  public function getAllValues()
  {
    $query = "SELECT * FROM `introduce`";
    $result = mysqli_query($this->conn, $query);

    if (!$result) {
      return false;
    }

    $values = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $values[] = $row;
    }

    return $values;
  }

  // Lấy giá trị theo section
  public function getValuesBySection($section)
  {
    $query = "SELECT * FROM `introduce` WHERE section = ?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $section);

    if (!mysqli_stmt_execute($stmt)) {
      return false;
    }

    $result = mysqli_stmt_get_result($stmt);
    $values = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $values[] = $row;
    }

    return $values;
  }

  public function getBranchWithUserPhone()
  {
    $query = "
        SELECT 
            branch.address AS branch_address,
            user.phone AS user_phone
        FROM 
            branch
        INNER JOIN 
            user 
        ON 
            branch.userId = user.id
    ";
    $result = mysqli_query($this->conn, $query);

    if (!$result) {
      return false;
    }

    $branches = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $branches[] = $row;
    }

    return $branches;
  }

  // Tạo một giá trị mới trong bảng introduce
  public function createIntroduce($data)
  {
    $query = "INSERT INTO `introduce` (section, content, note) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param(
      $stmt,
      "sss",
      $data['section'],
      $data['content'],
      $data['note']
    );

    return mysqli_stmt_execute($stmt);
  }

  // Cập nhật giá trị theo ID
  public function updateIntroduce($id, $data)
  {
    $query = "UPDATE `introduce` SET section = ?, content = ?, note = ? WHERE id = ?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param(
      $stmt,
      "sssi",
      $data['section'],
      $data['content'],
      $data['note'],
      $id
    );

    return mysqli_stmt_execute($stmt);
  }

  // Xóa giá trị theo ID
  public function deleteIntroduce($id)
  {
    $query = "DELETE FROM `introduce` WHERE id = ?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    return mysqli_stmt_execute($stmt);
  }
}
?>