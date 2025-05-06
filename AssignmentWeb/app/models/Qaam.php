<?php
require_once __DIR__ . '/../helper/config.php';

class Qaam extends db
{
  protected $conn;

  public function __construct()
  {
    parent::__construct();
    $this->conn = $this->connect;
    if (!$this->conn) {
      die("Connection failed in Qaa model");
    }
  }

  // Lấy tất cả các câu hỏi - trả lời theo displayOrder
  public function getAllQaa()
  {
    $query = "SELECT * FROM `faq` ORDER BY displayOrder ASC";
    $result = mysqli_query($this->conn, $query);
    if (!$result) {
      return false;
    }
    $qaa = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $qaa[] = $row;
    }
    return $qaa;
  }

  // Lấy các câu hỏi - trả lời theo danh mục
  public function getQaaByCategory($category)
  {
    $query = "SELECT * FROM `faq` WHERE category = ? ORDER BY displayOrder ASC";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $category);
    if (!mysqli_stmt_execute($stmt)) {
      return false;
    }
    $result = mysqli_stmt_get_result($stmt);
    $qaa = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $qaa[] = $row;
    }
    return $qaa;
  }

  // Lấy tất cả FAQ có displayOrder = 1 gia tri và nhóm theo danh mục
  public function getFaqsGroupedByCategory($displayOrder = 1)
  {
    $query = "SELECT * FROM `faq` WHERE displayOrder = ? ORDER BY category, id ASC";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $displayOrder);
    if (!mysqli_stmt_execute($stmt)) {
      return false;
    }
    $result = mysqli_stmt_get_result($stmt);
    $faqs = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $category = $row['category'];
      if (!isset($faqs[$category])) {
        $faqs[$category] = array();
      }
      $faqs[$category][] = $row;
    }
    return $faqs;
  }

  // Tạo một câu hỏi - trả lời mới
  public function createQaa($data)
  {
    $query = "INSERT INTO `faq` (category, question, answer, `name`, email, phone, displayOrder) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param(
      $stmt,
      "ssssssi",
      $data['category'],
      $data['question'],
      $data['answer'],
      $data['name'],
      $data['email'],
      $data['phone'],
      $data['displayOrder']
    );
    return mysqli_stmt_execute($stmt);
  }

  // Cập nhật câu hỏi - trả lời theo id của faq
  public function updateQaa($id, $data)
  {
    $query = "UPDATE `faq` SET category = ?, question = ?, answer = ?, name = ?, email = ?, phone = ?, displayOrder = ? WHERE id = ?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param(
      $stmt,
      "ssssssii",
      $data['category'],
      $data['question'],
      $data['answer'],
      $data['name'],
      $data['email'],
      $data['phone'],
      $data['displayOrder'],
      $id
    );
    return mysqli_stmt_execute($stmt);
  }

  // Xóa câu hỏi - trả lời theo id
  public function deleteQaa($id)
  {
    $query = "DELETE FROM `faq` WHERE id = ?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    return mysqli_stmt_execute($stmt);
  }
}
?>