<?php
require_once __DIR__ . '/../models/SiteModel.php';

class ReviewController {
    private $db;

    public function __construct() {
        $model = new SiteModel();
        $this->db = $model->getDbConnection();
    }

    public function updateReviewStatus($id, $status) {
        if (in_array($status, ['approved', 'rejected'])) {
            $query = "UPDATE review SET status = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("si", $status, $id);

            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }
}
?>