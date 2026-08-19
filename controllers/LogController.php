<?php
/**
 * LogController - Log Aktivitas Admin & Log Login
 */
class LogController extends Controller
{
    private $db;

    public function __construct()
    {
        if (!is_admin_login()) { $this->redirect('auth/adminLogin'); }
        $this->db = Database::getInstance();
    }

    public function logActivity()
    {
        $logs = $this->db->query(
            "SELECT la.*, a.nama as nama_admin
             FROM log_activity la LEFT JOIN admin a ON a.id_admin = la.id_admin
             ORDER BY la.created_at DESC LIMIT 200"
        )->fetchAll();

        $this->view('admin/log/activity', [
            'title' => 'Log Aktivitas - Admin', 'pageTitle' => 'Log Aktivitas Admin',
            'activeMenu' => 'log', 'logs' => $logs,
        ]);
    }

    public function logLogin()
    {
        $logs = $this->db->query("SELECT * FROM log_login ORDER BY created_at DESC LIMIT 200")->fetchAll();

        $this->view('admin/log/login', [
            'title' => 'Log Login - Admin', 'pageTitle' => 'Log Login',
            'activeMenu' => 'log', 'logs' => $logs,
        ]);
    }
}
