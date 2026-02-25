<?php
// Get the path that failed
$failed_path = isset($_temp_path) ? $_temp_path : (defined('ROOT_PATH') ? ROOT_PATH : __DIR__);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error de Permisos — Sistema Administrativo</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #1a1a2e;
            color: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .card {
            background: #16213e;
            border: 1px solid #e74c3c55;
            border-radius: 12px;
            padding: 40px 50px;
            max-width: 550px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }
        .icon { font-size: 60px; margin-bottom: 20px; }
        h1 { font-size: 22px; color: #e74c3c; margin-bottom: 12px; }
        p { color: #aaa; line-height: 1.6; margin-bottom: 16px; }
        code {
            background: #0f3460;
            border-radius: 6px;
            padding: 10px 16px;
            display: block;
            font-size: 13px;
            color: #58d68d;
            text-align: left;
            margin: 10px 0;
            word-break: break-all;
        }
        .hint {
            background: #0f3460;
            border-left: 3px solid #3498db;
            padding: 14px;
            border-radius: 6px;
            text-align: left;
            font-size: 13px;
            color: #85c1e9;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="icon">🔒</div>
    <h1>Error de Permisos del Servidor</h1>
    <p>El sistema no puede escribir en la carpeta requerida. Contacta al administrador del servidor.</p>
    <code><?php echo htmlspecialchars($failed_path); ?></code>
    <div class="hint">
        <strong>Solución (SSH/Terminal):</strong><br>
        <code>chmod 775 <?php echo htmlspecialchars($failed_path); ?></code>
        <code>chown -R [usuario]:[usuario] <?php echo htmlspecialchars(defined('ROOT_PATH') ? ROOT_PATH : __DIR__); ?></code>
    </div>
</div>
</body>
</html>
