<?php
namespace App\Controllers;
use App\Models\Usuario;

class AuthController extends Controller {
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new Usuario();
            $usuario = $userModel->buscarPorEmail($email);

            // Verificamos si existe y si la contraseña coincide
            if ($usuario && password_verify($password, $usuario['password'])) {
                session_start();
                $_current_user = [
                    'id' => $usuario['id'],
                    'nombre' => $usuario['nombre'],
                    'rol' => $usuario['rol']
                ];
                $_SESSION['user'] = $_current_user;

                // Redirigir según el rol
                header("Location: /E-ticket/admin/dashboard");
                exit;
            } else {
                $data['error'] = "Credenciales incorrectas.";
                $this->render('auth/login', $data);
            }
        } else {
            $this->render('auth/login');
        }
    }

    public function logout() {
    if (session_status() === PHP_SESSION_NONE) session_start();

    // 1. Si quieres limpiar el token en la DB antes de salir
    if (isset($_SESSION['user'])) {
        $userId = $_SESSION['user']['id'];
        $db = (new \App\Core\Database())->getConnection();
        $sql = "UPDATE usuarios SET session_token = NULL WHERE id = :id";
        $db->prepare($sql)->execute([':id' => $userId]);
    }

    // 2. Destruir todas las variables de sesión
    $_SESSION = array();

    // 3. Borrar la cookie de sesión si existe
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // 4. Destruir la sesión finalmente
    session_destroy();

    // 5. Redirigir al login
    header("Location: /E-ticket/login");
    exit;
}
}